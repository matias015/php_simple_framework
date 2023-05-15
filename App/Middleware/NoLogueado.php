<?php
class Nologueado{

    static function check(){
        if(Auth::isLogin()){
            Request::redirect('/');
            return false;
        }
    }
}