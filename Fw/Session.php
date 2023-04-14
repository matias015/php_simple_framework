<?php

class Session{
    
    static function set($key,$value){
        $_SESSION[$key] = $value;
    }

    static function delete($key){
        unset($_SESSION[$key]);
    }

    static function exists($key){
        return isset($_SESSION[$key]);
    }

    static function get($key){
        return $_SESSION[$key];
    }

    static function getAndDelete($key){
        $val = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $val;
    }

}