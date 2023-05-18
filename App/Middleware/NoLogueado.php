<?php
class Nologueado{

    static function check(){
        if(Auth::isLogin('alumno')){
            Request::redirect('/');
            return false;
        }
    }
}