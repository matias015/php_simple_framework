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
    static function is_login()
    {
        return isset($_SESSION['user_login_id']);
    }

    /**
     * Returns if the user is logged as determinated role
     */
    static function is_login_as($role)
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
        return Auth::is_login()?   
            $_SESSION['user_login_id']:
            null;
    }

    /**
     * Returns a tokens for remember
     */
    static function create_token()
    {
        return bin2hex(random_bytes(16));
    }

    static function set_remember_token($table='users'){
        self::delete_cookie();
        $token = Auth::create_token();
        setcookie('user_token', $token, time()+ strtotime(COOKIE_EXPIRATION_TIME), '/', '', true, true);
        DB::query('UPDATE '.$table.' SET remember_token=:token WHERE id=:userid',['token'=>$token,'userid'=>Auth::id()]);
        return __CLASS__;
    }

    static function unset_remember_token($table='users'){
        DB::query('UPDATE '.$table.' SET remember_token=NULL WHERE id=:userid',['userid'=>self::id()]);
        self::delete_cookie();
        return __CLASS__;
    }

    static function delete_cookie(){
        setcookie('user_token', '', time()-3600, '/', '', true, true);
        return __CLASS__;
    }

    static function get_user_remember_token($table='users'){
        $user=DB::query_first('SELECT id FROM '.$table.' WHERE id = :iduser',['iduser'=>self::id()]);
        return $user->remember_token;
    }

    static function try_login_with_cookie($table='users'){
        $user = DB::query_first('SELECT id FROM '.$table.' WHERE remember_token = :token',['token'=>$_COOKIE['user_token']]);
        self::login($user->id);
        return __CLASS__;
    }

    static function get_user_from_db($table='users',$fields='*'){
        return DB::query_first('SELECT '.$fields.' FROM '.$table.' WHERE id=:userid',['userid'=> self::id()]);
    }

}
