<?php

namespace Framework;

class Auth{

    /**
     * Make login with the given id
     */
    static function login($id)
    {
        $_SESSION['user_login_id'] = $id;
        session_regenerate_id();

        return __CLASS__;
    }

    /**
     * Set a role for the logged user
     */
    static function as($role)
    {
        $_SESSION['user_login_role'] = $role;
        return __CLASS__;
    }

    /**
     * Returns if the user is logged
     */
    static function isLogin()
    {
        return isset($_SESSION['user_login_id']);
    }

    /**
     * Returns if the user is logged as determinated role
     */
    static function isLoginAs($role)
    {
        return $_SESSION['user_login_role'] == $role;
    }

    /**
     * Make logout of the current loggedin user
     */
    static function logout()
    {
        unset($_SESSION['user_login_id']);
        unset($_SESSION['user_login_role']);
    
        session_destroy();
        return __CLASS__;
    }

    /**
     * Returns the id of the loggedin user
     */
    static function id()
    {
        return Auth::isLogin()?   
            $_SESSION['user_login_id']:
            null;
    }

    /**
     * Returns a tokens for remember
     */
    static function createToken()
    {
        return bin2hex(random_bytes(16));
    }

    static function setRememberToken($table='users'){
        self::deleteCookie();
        $token = Auth::createToken();
        setcookie('user_token', $token, time()+ strtotime(COOKIE_EXPIRATION_TIME), '/', '', true, true);
        DB::query('UPDATE '.$table.' SET remember_token=:token WHERE id=:userid',['token'=>$token,'userid'=>Auth::id()]);
        return __CLASS__;
    }

    static function unsetRememberToken($table='users'){
        DB::query('UPDATE '.$table.' SET remember_token=NULL WHERE id=:userid',['userid'=>self::id()]);
        self::deleteCookie();
        return __CLASS__;
    }

    static function deleteCookie(){
        setcookie('user_token', '', time()-3600, '/', '', true, true);
        return __CLASS__;
    }

    static function getUserRememberToken($table='users'){
        $user=DB::queryFirst('SELECT id FROM '.$table.' WHERE id = :iduser',['iduser'=>self::id()]);
        return $user->remember_token;
    }

    static function tryLoginWithCookie($table='users'){
        $user = DB::queryFirst('SELECT id FROM '.$table.' WHERE remember_token = :token',['token'=>$_COOKIE['user_token']]);
        self::login($user->id);
        return __CLASS__;
    }

    static function getUserFromDB($table='users',$fields='*'){
        return DB::queryFirst('SELECT '.$fields.' FROM '.$table.' WHERE id=:userid',['userid'=> self::id()]);
    }

}