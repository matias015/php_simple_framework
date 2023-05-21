<?php

require_once('Fw/DB.php');
require_once('App/config/config.php');

class Auth extends DB{
    
    static $token_duration_time = COOKIE_EXPIRATION_TIME;

    static $user;

    /**
     * Auto exec when session starts
     */
    static function start(){
        if(!Auth::isLogin()){
            Auth::loginWithCookie();
        }
        if(!isset($_SESSION['_AUTH_'])) $_SESSION['_AUTH_'] = ['guard' => null,'user_id'=>null,'logged_at'=>null];
    }

    /**
     * get table name of the actual guard
     */
    static function getTable(){
        $guard = $_SESSION['_AUTH_']['guard'];
 
        return AuthConfig::getGuards()[$guard]['table'];
    }

    /**
     * get primary key of the actual guard
     */
    static function getPrimary(){
        $guard = $_SESSION['_AUTH_']['guard'];
        return AuthConfig::getGuards()[$guard]['primary'];
    }

    /**
     * get the actual guard
     */
    static function getGuard(){
        return $_SESSION['_AUTH_']['guard'];
    }

    /**
     * create cookie and call functions to store it
     */
    static function remember($user){
        $token = bin2hex(random_bytes(16));

        Auth::setCookieTable($user, $token);
        Auth::setCookie($token);
    }

    /**
     * set cookie
     */
    static private function setCookie($token){
        setcookie('user_token', $token, time()+ strtotime(COOKIE_EXPIRATION_TIME), '/', '', true, true);
    }

    /**
     * login in a specific guard
     */
    static function loginGuard($guard, $user,$remember=false){
        $data = AuthConfig::getGuards()[$guard];

        $_SESSION['_AUTH_']['guard'] = $guard;
        $_SESSION['_AUTH_']['user_id'] = $user -> {$data['primary']};
        $_SESSION['_AUTH_']['logged_at'] = time();

        if ($remember) Auth::remember($user);

        return true;
    }

    /**
     * make login to the user with the default guard
     */
    static function login($user, $remember=false) {
        $_SESSION['_AUTH_']['guard'] = AuthConfig::defaultGuard();
        $_SESSION['_AUTH_']['user_id'] = $user -> {Auth::$authIdField};
        $_SESSION['_AUTH_']['logged_at'] = time();

        if ($remember) Auth::remember($user);

        Auth::$user = $user;
        return true;
    }

    /**
     * return if an user is login
     */
    static function isLogin($guard=false) {
        $isGuard = true;
        if($guard) $isGuard = Auth::getGuard()==$guard;
        return isset($_SESSION['_AUTH_']['user_id']) && $isGuard;
    }

    /** 
     * check if a cookie exists 
     */
    static function cookieExists(){
        return isset($_COOKIE['user_token']);
    }

    /**
     * get the user from the database with his token 
     */
    static function getUserWithCookieToken(){
            $tokensTable = AUTH_TABLE_TOKENS_NAME;

            $token = hash('sha256', $_COOKIE['user_token']);

            $usersTable = Auth::getTable();
            $idField = Auth::getPrimary();
            $guard = Auth::getGuard();
        
            $user = DB::queryFirst("
            SELECT $idField, $tokensTable.guard 
            FROM $usersTable,$tokensTable 
            WHERE $tokensTable.user_id = $usersTable.$idField
            AND token = :token", ['token'=>$token],false);
        
            return $user;
        }

    /**
     * login user using cookie
     */
    static function loginWithCookie() {
        if (Auth::cookieExists()) {
            
            $user = Auth::getUserWithCookieToken();

            if ($user) {
                Auth::loginGuard($user->guard, $user);
                return true;
            }
        }
        return false;
    }

    /**
     * delete cookie from the cookie table
     */
    static function deleteCookieFromDB(){
        $tokensTable = Auth::$tokensTable;

        DB::query("DELETE FROM $tokensTable 
            WHERE $tokensTable.user_id = :user_id
            AND $tokensTable.guard = ?", 
        ['user_id'=>$_SESSION['_AUTH_']['user_id'], Auth::getGuard()], false);
    }

    /**
     * delete cookie
     */
    static function deleteCookie(){
        Auth::deleteCookieFromDB();
        setcookie('user_token', '', time()-3600, '/', '', true, true);
    }

    static private function unsetSessionVars(){
        unset($_SESSION['_AUTH_']);
    }

    /**
     * logout user
     */
    static function logout() {
        if (Auth::cookieExists()) {
            Auth::deleteCookie();
        }
        
        Auth::unsetSessionVars();
        return true;
    }

    /**
     * get user data from db
     */
    static function getUserData(){
        return DB::queryFirst('Select * FROM '.Auth::getTable().' WHERE '.Auth::getPrimary().' = :user_id', ['user_id'=>$_SESSION['_AUTH_']['user_id']],false);
    }

    /**
     * returns the actual logged user, if doesnt exists, search for it in db
     */
    static function user(){
        if(Auth::$user) return Auth::$user;
        Auth::$user = Auth::getUserData();
        return Auth::$user;
    }

    /**
     * return the id field from the actual user
     */
    static function id(){
        return Auth::user()->{Auth::getPrimary()};
    }

    /**
     * set cookie in data base
     */
    static private function setCookieTable($user, $token){
        $tokensTable = Auth::$tokensTable;
        $token_duration_time = date('Y-m-d', strtotime(COOKIE_EXPIRATION_TIME));
        
        if(DELETE_DUPLICATED_COOKIES) Auth::deleteUserTokenFromDB(Auth::id());

        DB::query("
        INSERT INTO $tokensTable 
        VALUES(NULL, :user_id,:token,:guard,:exp_date)", [
            'user_id' => $user -> {Auth::$authIdField}, 
            'token' => hash('sha256', $token),
            'guard' => Auth::getGuard(),
            'exp_date' => $token_duration_time
        ], false);    
    }

    /**
     * delete expired tokens from the database
     */
    static public function deleteExpiredTokens(){
        $table = Auth::$tokensTable;
        DB::query("DELETE FROM $table WHERE exp_date < NOW()");
    }

    static function deleteUserTokenFromDB($id){
        $table = AUTH_TABLE_TOKENS_NAME;
        DB::query("DELETE FROM $table WHERE user_id = ? AND guard", [$id, Auth::getGuard()]);
    }
    
}