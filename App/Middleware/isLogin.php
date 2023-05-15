<?php
class isLogin{

    static function check(){
        if(!Auth::isLogin()){
            Request::redirect('/login');
            return false;
        }
    }


}