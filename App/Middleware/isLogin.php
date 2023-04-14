<?php
class isLogin{

    static function check(){
        if(!Auth::is_login()){
            Request::redirect('/login');
            return false;
        }
    }

}