<?php

require_once('Fw/DB.php');
require_once('App/config/config.php');

class Auth extends DB{
    static $usersTable = AUTH_TABLE_NAME;
    static $tokensTable = AUTH_TABLE_TOKENS_NAME;
    static $token_duration_time = COOKIE_EXPIRATION_TIME;

    static $user;

    static function start(){
        session_start();
        
        if(!Auth::isLogin()){
            Auth::loginWithCookie();
        }
    }

    static function login($user, $remember=false) {
        $_SESSION['user_id'] = $user['id'];

        if ($remember) {
            $tokensTable = Auth::$tokensTable;
            $token_duration_time = date('Y-m-d', strtotime(COOKIE_EXPIRATION_TIME));

            $token = bin2hex(random_bytes(16));
            DB::query("INSERT INTO $tokensTable VALUES(NULL, ?,?,?)",[$user['id'], hash('sha256', $token),$token_duration_time],false);
            setcookie('user_token', $token, time()+$token_duration_time, '/', '', true, true);
        }

        Auth::$user = $user;
        return true;
    }

    static function isLogin() {
        return isset($_SESSION['user_id']);
    }

    static function loginWithCookie() {
        if (isset($_COOKIE['user_token'])) {
            $tokensTable = Auth::$tokensTable;

            $token = hash('sha256', $_COOKIE['user_token']);

            $usersTable = Auth::$usersTable;

            $user = DB::queryFirst("SELECT * FROM $usersTable,$tokensTable WHERE $tokensTable.user_id = $usersTable.id AND token = ?", [$token],false);
            
            if ($user) {
                Auth::login($user);
                return true;
            }
        }
        return false;
    }

    static function logout() {
        if (isset($_COOKIE['user_token'])) {
            $tokensTable = Auth::$tokensTable;
            DB::query("DELETE FROM $tokensTable WHERE $tokensTable.user_id = ?", [$_SESSION['user_id']],false);
            setcookie('user_token', '', time()-3600, '/', '', true, true);
        }
        unset($_SESSION['user_id']);
        return true;
    }

    static function user(){
        if(Auth::$user) return Auth::$user;
        $res = DB::query('Select * FROM '.Auth::$usersTable.' WHERE id = ?', [$_SESSION['user_id']],false);
        Auth::$user = $res[0];
        return Auth::$user;
    }

    static public function deleteExpiredTokens(){
        DB::query('DELETE FROM user_tokens WHERE exp_date < NOW()');
    }
    
}

Auth::start();