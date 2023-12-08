<?php

namespace Framework;

use Framework\Middlewares\Middleware;

class Route{

    // Actual path
    static $currentPath;

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

    // Create a route
    static function route($path){
        $path = trim($path,'/');
        return Route::getBasePath() . parse_url($path, PHP_URL_PATH);
    }
    
    static function method(){
        if(isset($_POST['_method'])){
            return $_POST['_method'];
        }
        return $_SERVER['REQUEST_METHOD'];
    }

    static function get($path, $callback, $mw=[]){
        $route=[];
        $route['path'] = $path;
        $route['callback'] = $callback;
        
        if(\count($mw)>0){
            $route['mw'] = $mw;
        }
        
        self::$registeredRoutes['GET'][]=$route;
    }

    static function post($path, $callback, $mw=[]){
        $route=[];
        $route['path'] = $path;
        $route['callback'] = $callback;
        
        if(\count($mw)>0){
            $route['mw'] = $mw;
        }
        
        self::$registeredRoutes['POST'][]=$route;
    }

    static function delete($path, $callback, $mw=[]){
        $route=[];
        $route['path'] = $path;
        $route['callback'] = $callback;
        
        if(\count($mw)>0){
            $route['mw'] = $mw;
        }
        
        self::$registeredRoutes['DELETE'][]=$route;
    }

    static function put($path, $callback, $mw=[]){
        $route=[];
        $route['path'] = $path;
        $route['callback'] = $callback;
        
        if(\count($mw)>0){
            $route['mw'] = $mw;
        }
        
        self::$registeredRoutes['PUT'][]=$route;
    }

    static function RouteMatched($route){
        $replaced = str_replace('*','[A-Za-z0-9]+',$route);
        $replaced = str_replace('/','\/',$replaced);
    
        $regexp = '/p1\/5\/p2/';
        $regexp = '/'.$replaced.'/';
    
        if (preg_match($regexp, self::path(), $matches)) {
           return true;
        } return false;
    }

    static function segment($index){
        return \explode('/',self::path())[$index-1];
    }

    static function dispatch(){
        foreach(self::$registeredRoutes[self::method()] as $route){
            if(Route::RouteMatched($route['path'])) {
                if(isset($route['mw'])){
                    Middleware::applyMiddlewares($route['mw']);
                }
                $route['callback']();
            }
        }
    }
}

Route::$currentPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),'/');