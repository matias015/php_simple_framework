<?php

namespace Fw;
include_once('App/config/config.php');

class LoginIsExpired{
    static function check(){
        if(!Auth::isLogin()) return;
         if(time() - $_SESSION['_AUTH_']['logged_at'] > LOGIN_EXPIRATION_TIME ){
             Auth::logout();
         }
    }
}