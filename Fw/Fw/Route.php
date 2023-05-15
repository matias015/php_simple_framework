<?php

include_once('Fw/csrfTokenMiddle.php');
include_once('Fw/LoginExpiration.php');
include_once('App/config/config.php');
include_once('Fw/Routing.php');

class Route{

    public $path = "";
    public $action = null;
    public $method = null;
    public $middlewares = [];
    public $isRedirect = false;
    public $redirectTo = "";
    // public $regexp = null;

    public function __construct($method,$path,$action=null)
    {
        $this -> method = $method;
        $this -> path = $path;
        $this -> action = $action;
        $this -> middlewares = [];

    }

    static function getBasePath(){
        $url = explode('index.php', $_SERVER['PHP_SELF']);
        return $url[0];
    }

    static function route($path){        
        $path = trim($path,'/');
        return Route::getBasePath() . parse_url($path, PHP_URL_PATH);
    }

    // private function setRegexp(){
    //     $this->regexp = preg_replace(
    //         "/\{([a-zA-Z0-9]+)\}/",
    //         "([a-zA-Z0-9]+)",
    //         str_replace("/","\/",$this->path)
    //     );
    // }

    private function prepareToRegister(){
        $this -> path = Route::route($this->path);
        // $this -> setRegexp();
        Routing::routeRegister($this);
    }

    public function getMiddlewares(){
        return $this -> middlewares;
        Routing::routeRegister($this);
    }

    static function redirect($path,$to){
        $route = new Route("GET", $path);
        $route -> isRedirect = true;
        $route -> redirectTo = $to;
        $route -> prepareToRegister(); 
        return $route;
    }

    static function get($path,$cb){
        $route = new Route("GET", $path, $cb);
        $route -> prepareToRegister();
        return $route;
    }

    static function post($path,$cb){
        $route = new Route("POST", $path, $cb);
        $route -> prepareToRegister();
        return $route;
    }

    public function middleware($mws){
        $this -> middlewares = $mws;
    }

}
    
