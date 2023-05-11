<?php

include_once('Fw/csrfTokenMiddle.php');
include_once('Fw/LoginExpiration.php');
include_once('App/config/config.php');

class Route{

    static $routes = [];

    static function path(){
        $url = $_SERVER['REQUEST_URI'];
        return parse_url($url, PHP_URL_PATH);  
    }

    static function getBasePath(){
        $url = explode('index.php', $_SERVER['PHP_SELF']);
        return $url[0];
    }

    static function route($path){
        $path = trim($path,'/');
        return Route::getBasePath() . parse_url($path, PHP_URL_PATH);
    }
    
    static function method(){
        return $_SERVER['REQUEST_METHOD'];
    }

    static function get($path,$cb){
        Route::$routes['GET'][Route::route($path)] = $cb;
    }

    static function post($path,$cb){
        Route::$routes['POST'][Route::route($path)] = $cb;
    }

    static function redirect($path,$to){
        if(Route::path() == Route::route($path) && Route::method() === 'GET'){
            header("location: ". Route::route($to));
            exit;
        };
        return;
    }


    static function dispatch(){
        $path = Route::path();
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