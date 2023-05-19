<?php
class Verificado{

    static function check(){
        if(Auth::isLogin('alumno') && Auth::user()->verificado == 1) return;

        Request::redirect('/');
        return false;
    }

}