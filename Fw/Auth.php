<?php

require_once('Fw/DB.php');
require_once('App/config/config.php');

class Auth extends DB{
    static $usersTable = AUTH_TABLE_NAME;
    static $tokensTable = AUTH_TABLE_TOKENS_NAME;
    static $token_duration_time = COOKIE_EXPIRATION_TIME;
    static $authIdField = AUTH_ID_NAME;

    static $user;

    /**
     * Auto exec when session starts
     */
    static function start(){
        if(!Auth::isLogin()){
            Auth::loginWithCookie();
        }
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
     * make login to the user
     */
    static function login($user, $remember=false) {

        $_SESSION['user_id'] = $user -> {Auth::$authIdField};
        $_SESSION['logged_at'] = time();

        if ($remember) Auth::remember($user);

        Auth::$user = $user;
        return true;
    }

    /**
     * return if an user is login
     */
    static function isLogin() {
        return isset($_SESSION['user_id']);
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
            $tokensTable = Auth::$tokensTable;

            $token = hash('sha256', $_COOKIE['user_token']);

            $usersTable = Auth::$usersTable;
            $idField = Auth::$authIdField;
            
            $user = DB::queryFirst("
            SELECT * 
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
                Auth::login($user);
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

        DB::query("DELETE FROM $tokensTable WHERE $tokensTable.user_id = :user_id", 
        ['user_id'=>$_SESSION['user_id']],false);
    }

    /**
     * delete cookie
     */
    static function deleteCookie(){
        Auth::deleteCookieFromDB();
        setcookie('user_token', '', time()-3600, '/', '', true, true);
    }

    static private function unsetSessionVars(){
        unset($_SESSION['user_id']);
        unset($_SESSION['logged_at']);
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
        return DB::queryFirst('Select * FROM '.Auth::$usersTable.' WHERE '.Auth::$authIdField.' = :user_id', ['user_id'=>$_SESSION['user_id']],false);
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
        return Auth::user()->{Auth::$authIdField};
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
        VALUES(NULL, :user_id,:token,:exp_date)", [
            'user_id' => $user -> {Auth::$authIdField}, 
            'token' => hash('sha256', $token),
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
        $table = Auth::$tokensTable;
        DB::query("DELETE FROM $table WHERE user_id = ?",[$id]);
    }
    
}