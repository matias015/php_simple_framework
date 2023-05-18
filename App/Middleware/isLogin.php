<?php
class isLogin{

    static function check(){
        if(!Auth::isLogin('alumno')){
            Request::redirect('/login');
            return false;
        }
    }


}