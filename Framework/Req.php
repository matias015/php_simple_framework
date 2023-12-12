<?php

namespace Framework;

class Req{


    static function post($key){
        return htmlspecialchars($_POST[$key]);
    }

    static function get($key){
        return htmlspecialchars($_GET[$key]);
    }

    static function postAll(){
        $values = $_POST;
        unset($values['_input']);
        return $values;
    }

    static function getAll(){
        $values = $_GET;
        return $values;
    }

    static function postOnly($asked){
        $values = [];
        foreach($_POST as $key => $value){
            if(in_array($key, $asked))
                $values[$key] = $value;
        }
        return $values;
    }

    static function getOnly($asked){
        $values = [];
        foreach($_GET as $key => $value){
            if(in_array($key, $asked))
                $values[$key] = $value;
        }
        return $values;
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
        foreach($_GET as $key=>$val){
            $_GET[$key] = trim($val);
        }
        return __CLASS__;
    }

    static function deleteEmptyInputs(){
        foreach($_POST as $key=>$val){
            if(!$val) unset($_POST[$key]);
        }
        foreach($_GET as $key=>$val){
            if(!$val) unset($_GET[$key]);
        }
        return __CLASS__;
    }

    static function referer($cb='/'){
        return isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER'] : $cb;
    }
}