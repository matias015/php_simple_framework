<?php

namespace Framework;

class Session{

    static function set($key, $value){
        $_SESSION[$key] = $value;
    }

    static function get($key, $default=null){
        return isset($_SESSION[$key]) ? 
            $_SESSION[$key]:
            $default;
    }
    
    static function unset($key){
        unset($_SESSION[$key]);
    }

    static function getAndDelete($key){
        $value = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $value;
    }

}