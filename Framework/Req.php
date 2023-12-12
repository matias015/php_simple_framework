<?php

namespace Framework;

class Req{

    /**
    * Returns the value of given key
    */
    static function post($key)
    {
        return htmlspecialchars($_POST[$key]);
    }

    /**
    * Returns the value of given key
    */
    static function get($key)
    {
        return htmlspecialchars($_GET[$key]);
    }

    /**
    * Returns all post values except the _method input
    */ 
    static function post_all()
    {
        $values = $_POST;
        unset($values['_input']);
        return $values;
    }
    
    /**
    * Returns all get values except the _method input
    */ 
    static function get_all()
    {
        $values = $_GET;
        return $values;
    }

    /**
    * Returns only selected values
    */ 
    static function post_only($asked)
    {
        $values = [];
        foreach($_POST as $key => $value){
            if(in_array($key, $asked))
                $values[$key] = $value;
        }
        return $values;
    }
    
    /**
    * Returns only selected values
    */ 
    static function get_only($asked)
    {
        $values = [];
        foreach($_GET as $key => $value){
            if(in_array($key, $asked))
                $values[$key] = $value;
        }
        return $values;
    }
    
    /**
    * Returns if post has the given key
    */ 
    static function post_has($key)
    {
        return isset($_POST[$key]);
    }
    
    /**
    * Returns if get has the given key
    */ 
    static function get_has($key)
    {
        return isset($_GET[$key]);
    }

    /**
    * Returns if any of both has the given key
    */ 
    static function any($key)
    {
        if(Route::path() == 'GET') return htmlspecialchars($_GET[$key]);
        else return htmlspecialchars($_POST[$key]);
    }

    /**
    * Trims inputs 
    */ 
    static function trim()
    {
        foreach($_POST as $key=>$val){
            $_POST[$key] = trim($val);
        }
        foreach($_GET as $key=>$val){
            $_GET[$key] = trim($val);
        }
        return __CLASS__;
    }

    /**
    * deletes values that are empty
    */ 
    static function delete_empty_inputs()
    {
        foreach($_POST as $key=>$val){
            if(!$val) unset($_POST[$key]);
        }
        foreach($_GET as $key=>$val){
            if(!$val) unset($_GET[$key]);
        }
        return __CLASS__;
    }
    
    /**
    * Returns the previous path, if it doesn't exists, returns the default 
    */ 
    static function referer($cb='/')
    {
        return isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER'] : $cb;
    }
}
