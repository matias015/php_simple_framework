<?php

namespace Framework;

use Framework\Middlewares\Middleware;

class Route{

    // Actual path
    static $currentPath;
    static $currentMethod;

    // Registered routes
    static $registeredRoutes = [
        'GET' => [],
        'POST' => [],
        'DELETE' => [],
        'PUT' => []
    ];

    // Get the current path
    static function path(){
        return self::$currentPath;
    }

    // Get the base path
    static function getBasePath(){
        $url = explode('index.php', $_SERVER['PHP_SELF']);
        return $url[0];
    }

    // NO ANDA COMO TAL
    static function route($path){
        $path = trim($path,'/');
        return Route::getBasePath() . parse_url($path, PHP_URL_PATH);
    }

    static function getMethod(){
        return self::$currentMethod;
    }

    static function method(){
        if(isset($_POST['_method'])) return $_POST['_method'];
        return $_SERVER['REQUEST_METHOD'];
    }

    static function get($path, $callback, $mw=[]){
        $route=[
            'path' => $path,
            'callback'=>$callback
        ];
        
        if(empty($mw)){
            $route['mw'] = $mw;
        }
        
        self::$registeredRoutes['GET'][]=$route;
    }

    static function post($path, $callback, $mw=[]){
        $route=[
            'path' => $path,
            'callback'=>$callback
        ];
        
        if(empty($mw)){
            $route['mw'] = $mw;
        }
        
        self::$registeredRoutes['POST'][]=$route;
    }

    static function delete($path, $callback, $mw=[]){
        $route=[
            'path' => $path,
            'callback'=>$callback
        ];
        
        if(empty($mw)){
            $route['mw'] = $mw;
        }
        
        self::$registeredRoutes['DELETE'][]=$route;
    }

    static function put($path, $callback, $mw=[]){
        $route=[
            'path' => $path,
            'callback'=>$callback
        ];
        
        if(empty($mw)){
            $route['mw'] = $mw;
        }
        
        self::$registeredRoutes['PUT'][]=$route;
    }

    static function RouteMatched($route){
        $replaced = str_replace('*','[A-Za-z0-9]+',$route);
        $replaced = str_replace('/','\/',$replaced);
    
        $regexp = '/^'.$replaced.'$/';

        if (preg_match($regexp, preg_quote(self::path()), $matches)) {
           return true;
        } return false;
    }

    static function segment($index){
        return explode('/',self::path())[$index];
    }

    static function dispatch(){
        foreach(self::$registeredRoutes[self::method()] as $route){

            if(Route::RouteMatched($route['path'],'/')) {
                if(isset($route['mw'])){
                    Middleware::applyMiddlewares($route['mw']);
                }
                $route['callback']();
            }

        }
    }
}

Route::$currentMethod = Route::method();
Route::$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
