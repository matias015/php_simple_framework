<?php

use LDAP\Result;

include_once('Fw/csrfTokenMiddle.php');
include_once('Fw/LoginExpiration.php');
include_once('App/config/config.php');
include_once('App/Middleware/Middlewares.php');

class Routing{

    static $routes = [];
    public $path = "";
    public $action=null;

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

    static function routeRegister($route){
        Routing::$routes[$route->method][$route->path] = $route;
    }



    static function dispatch(){
        $path = Routing::path();
        $method = Routing::method();

        if(isset(Routing::$routes[$method][$path])){            

            LoginIsExpired::check();

            if($method==='POST') {
                csrfTokenMiddle::check(); 
            }

            $route = Routing::$routes[$method][$path];
            
            foreach($route->getMiddlewares() as $mw){
                Middlewares::exec($mw);
            }

            if($route->isRedirect) Request::redirect($route->redirectTo);

            if(is_array($route->action)){
                $controller = new $route->action[0];
                $controller -> {$route->action[1]}();
            }else if(is_callable($route->action)){
                $action = $route->action;
                $action();
            }else throw new Exception("Bad action");
    }
        else{
            Request::redirect('/404');
        }
    }
    
}