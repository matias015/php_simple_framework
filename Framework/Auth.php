<?php

namespace Framework;

use Framework\Database\DB;

class Auth{

    /**
     * Make login with the given id
     */
    static function login($id)
    {
        $_SESSION['user_login_id'] = $id;
        session_regenerate_id();
    }

    /**
     * Set a role for the logged user
     */
    static function as($role)
    {
        $_SESSION['user_login_role'] = $role;
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

    static function getRole()
    {
        return ( Auth::isLogin() ) ? $_SESSION['user_login_role'] : null;   
    }

    /**
     * Make logout of the current loggedin user
     */
    static function logout()
    {
        unset($_SESSION['user_login_id'], $_SESSION['user_login_role']);    
        session_destroy();
    }

    /**
     * Returns the id of the loggedin user
     */
    static function id()
    {
        return ( Auth::isLogin() ) ? $_SESSION['user_login_id'] : null;
    }

    /**
     * Returns a tokens for remember
     */
    static function createToken($as=null)
    {
        return bin2hex(random_bytes(16));
    }

    /**
     * Create cookie for remember
     */

    static function createRememberCookie($token)
    {
        $token = $token . '::' . Auth::getRole();
        setcookie('user_token', $token, time()+ strtotime(COOKIE_EXPIRATION_TIME), '/', '', true, true);
    }

    /**
     * Set the remember token in db
     */

     static function setTokenInDB($table, $token)
     {
        DB::query('UPDATE '.$table.' SET remember_token=:token WHERE id=:userid',['token'=>$token,'userid'=>Auth::id()]);
     }

    /**
     * Create the cookie for remember and set into the database
     */
    static function remember($table='users')
    {
        $token = Auth::createToken();

        Auth::createRememberCookie($token);
        Auth::setTokenInDB($table, $token);
    }

    static function deleteCookieFromDb($table)
    {
        DB::query('UPDATE '.$table.' SET remember_token=NULL WHERE id=:userid',['userid'=>Auth::id()]);
    }

    /**
     * Delete remember data
     */

    static function forget($table='users')
    {
        Auth::deleteCookieFromDb($table);
        Auth::deleteCookie();
    }

    static function deleteCookie()
    {
        setcookie('user_token', '', time()-3600, '/', '', true, true);
    }

    static function getUserRememberToken($table='users')
    {
        $user = DB::query_first('SELECT remember_token FROM '.$table.' WHERE id = :iduser',['iduser'=>self::id()]);
        return $user->remember_token;
    }

    static function tryLoginWithCookie($table='users')
    {
        $tokenData = explode('::', $_COOKIE['user_token']);

        $user = DB::query_first('SELECT id FROM '.$table.' WHERE remember_token = :token',['token'=>$tokenData[0]]);
        if(!$user) return false;
        
        Auth::login($user->id);
        Auth::as($tokenData[1]);
        return true;
    }

    static function getUserFromDB($table='users', $fields='*')
    {
        return DB::query_first('SELECT '.$fields.' FROM '.$table.' WHERE id=:userid',['userid'=> self::id()]);
    }

}
