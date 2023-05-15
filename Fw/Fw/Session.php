<?php
include_once('Fw/Csrf.php');
class Session{

    static function init(){
        session_start();
        Auth::start();
        CSRF::generate();
    }

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

    static function destroy(){
        session_destroy();
        session_unset();
        session_regenerate_id();
    }

}
Session::init();