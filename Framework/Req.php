<?php

namespace Framework;

class Req{

    static function post($key){
        return htmlspecialchars($_POST[$key]);
    }

    static function get($key){
        return htmlspecialchars($_GET[$key]);
    }

    static function postHas($key){
        return isset($_POST[$key]);
    }

    static function getHas($key){
        return isset($_GET[$key]);
    }

    static function any($key){
        if(Route::path() == 'GET') return htmlspecialchars($_GET[$key]);
        else return htmlspecialchars($_POST[$key]);
    }

    static function trim(){
        foreach($_POST as $key=>$val){
            $_POST[$key] = trim($val);
        }
        return __CLASS__;
    }

    static function deleteEmptyInputs(){
        foreach($_POST as $key=>$val){
            if(!$val) unset($_POST[$key]);
        }
        return __CLASS__;
    }

    static function referer($cb='/'){
        return isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER'] : $cb;
    }
}