<?php
class isLogin{

    static function check(){
        if(!Auth::isLogin()){
            Request::redirect('/login');
            return false;
        }
    }

    static function not(){
        if(Auth::isLogin()){
            echo 2;
            Request::redirect('/');
            return false;
        }
    }

}