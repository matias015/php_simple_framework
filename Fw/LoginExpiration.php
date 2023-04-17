<?php

include_once('App/config/config.php');

class LoginIsExpired{
    static function check(){
        if(!Auth::isLogin()) return;
         if(time() - $_SESSION['logged_at'] > LOGIN_EXPIRATION_TIME ){
             unset($_SESSION['logged_at']);
             Auth::logout();
             session_destroy();
             session_unset();
         }
    }
}