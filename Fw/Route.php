<?php

include_once('Fw/csrfTokenMiddle.php');
include_once('Fw/LoginExpiration.php');

class Route{

    static $routes = [];

    static function path(){
        $url = $_SERVER['REQUEST_URI'];
        return parse_url($url, PHP_URL_PATH);  
    }
    
    static function method(){
        return $_SERVER['REQUEST_METHOD'];
    }

    static function get($path,$cb){
        Route::$routes['GET'][trim($path,'/')] = $cb;
    }

    static function post($path,$cb){
        Route::$routes['POST'][trim($path,'/')] = $cb;
    }

    static function redirect($path,$to){
        if(Route::path() == $path && Route::method() === 'GET'){
            header("location: $to");
            exit;
        };
        return;
    }


    static function dispatch(){
        $path = trim(Route::path(), '/');
        $method = Route::method();

        if(isset(Route::$routes[$method][$path])){            
            
            LoginIsExpired::check();

            if($method==='POST') {
                csrfTokenMiddle::check(); 
            }

            Route::$routes[$method][$path]();
        }
        else{
            Request::redirect('/404');
        }
    }
    
}