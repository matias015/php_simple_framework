<?php

namespace Framework;
use Framework\Middlewares\Middleware;

class Route{

    // Current path and method
    static $currentPath;
    static $currentMethod;

    /**
     * Registered routes
     */
    static $registeredRoutes = 
    [
        'GET' => [],
        'POST' => [],
        'DELETE' => [],
        'PUT' => []
    ];

    static function getCurrentRequestData()
    {
        Route::$currentMethod = Route::getMethod();
        Route::$currentPath = ($_SERVER['REQUEST_URI']=='/')? '/' : rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),'/');        
    }

    /**
     * Returns the current path
     */
    static function path()
    {
        return self::$currentPath;
    }
    
    /**
     * Returns the current method
     */
    static function method()
    {
        return self::$currentMethod;
    }
    
    /**
    * Method input exists 
    */
    static function methodInputExists()
    {
        return isset($_POST['_method']);
    }

    /**
    * Reset the current method
    */
    static function getMethod()
    {
        if(Route::methodInputExists()) 
            return $_POST['_method'];
        else
            return $_SERVER['REQUEST_METHOD'];
    }

    /**
    * Register a GET route
    */
    static function get($path, $callback, $middlewares = [])
    {
        $route=[
            'path' => $path,
            'callback'=>$callback
        ];
        
        if(empty($middlewares)) $route['mw'] = $middlewares;
        
        Route::$registeredRoutes['GET'][]=$route;
    }

    /**
    * Register a POST route
    */
    static function post($path, $callback, $middlewares=[])
    {
        $route=[
            'path' => $path,
            'callback' => $callback
        ];
        
        if(empty($middlewares)) $route['mw'] = $middlewares;
        
        Route::$registeredRoutes['POST'][]=$route;
    }

    /**
    * Register a DELETE route
    */
    static function delete($path, $callback, $middlewares=[])
    {
        $route=[
            'path' => $path,
            'callback'=>$callback
        ];
        
        if(empty($middlewares)) $route['mw'] = $middlewares;
        
        Route::$registeredRoutes['DELETE'][]=$route;
    }

    /*
     * Register a PUT route
     */
    static function put($path, $callback, $middlewares=[])
    {
        $route=['path' => $path, 'callback'=>$callback];  

        if(empty($middlewares))
            $route['mw'] = $middlewares;
        
            Route::$registeredRoutes['PUT'][]=$route;
    }

    /*
     * Test if a path matches with the current
     */
    static function RouteMatched($route)
    {
        $replaced = str_replace('*','[A-Za-z0-9]+',$route);
        $regexp = '/^'.str_replace('/','\/',$replaced).'$/';

        if (preg_match($regexp, preg_quote(self::path()), $matches)) return true;
        else return false;
    }

    /*
     * Get a segment of the current path
     */
    static function segment($index)
    {
        return explode('/',self::path())[$index];
    }

    /*
     * Route dispatcher
     */
    static function dispatch()
    {
        foreach(self::$registeredRoutes[self::method()] as $route){
            if(Route::RouteMatched($route['path'])) {
                if(isset($route['mw'])) Middleware::applyMiddlewares($route['mw']);
                $route['callback']();
            }

        }
    }
}

Route::getCurrentRequestData();