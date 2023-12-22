<?php

namespace Framework;

use Framework\Route;

class Req{

    static $post = null;
    static $get = null;

    /**
    * Returns the value of given key
    */
    static function post($key)
    {
        return Req::$post[$key];
    }

    /**
    * Returns the value of given key
    */
    static function get($key)
    {
        return Req::$get[$key];
    }

    /**
    * Returns all post values except the _method input
    */ 
    static function postAll()
    {
        $values = Req::$post;
        unset($values['_input']);
        return (object) $values;
    }
    
    /**
    * Returns all get values except the _method input
    */ 
    static function getAll()
    {
        return (object) Req::$post;
    }

    /**
    * Returns only selected values
    */ 
    static function postOnly($asked)
    {
        $values = [];

        foreach(Req::$post as $key => $value){
            if(in_array($key, $asked))
                $values[$key] = $value;
        }

        return $values;
    }
    
    /**
    * Returns only selected values
    */ 
    static function getOnly($asked)
    {
        $values = [];
        foreach(Req::$get as $key => $value){
            if(in_array($key, $asked))
                $values[$key] = $value;
        }
        return $values;
    }
    
    /**
    * Returns if post has the given key
    */ 
    static function postHas($key)
    {
        return isset(Req::$post[$key]);
    }
    
    /**
    * Returns if get has the given key
    */ 
    static function getHas($key)
    {
        return isset(Req::$get[$key]);
    }

    /**
    * Returns if any of both has the given key
    */ 
    static function any($key)
    {
        if(Route::path() == 'GET') 
            return Req::$get[$key];
        else
            return Req::$post[$key];
    }

    /**
    * Trims inputs 
    */ 
    static function trim()
    {
        foreach(Req::$post as $key=>$val){
            Req::$post[$key] = trim($val);
        }
        foreach(Req::$get as $key=>$val){
            Req::$get[$key] = trim($val);
        }
    }

    /**
    * deletes values that are empty
    */ 
    static function deleteEmptyInputs()
    {
        foreach($_POST as $key=>$val){
            if(!$val) unset($_POST[$key]);
        }
        foreach($_GET as $key=>$val){
            if(!$val) unset(Req::$get[$key]);
        }
    }
    
    /**
    * Returns the previous path, if it doesn't exists, returns the default 
    */ 
    static function referer($cb='/')
    {
        return isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER'] : $cb;
    }
}

if(Route::path() === 'GET')
    Req::$get = filter_input_array(INPUT_GET,FILTER_SANITIZE_SPECIAL_CHARS);
else
    Req::$post = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
