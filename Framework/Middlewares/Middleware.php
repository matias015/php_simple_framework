<?php

namespace Framework\Middlewares;

use Framework\Middlewares\AuthMiddleware;
use Framework\Middlewares\TestMiddleware;

class Middleware{

    static $resgisteredMiddlewares = [
        'auth' => AuthMiddleware::class,
        'test' => TestMiddleware::class
    ];
    
    static function applyMiddlewares($list){
        foreach($list as $middlewareAlias){
            $mwclass = self::$resgisteredMiddlewares[$middlewareAlias];
            $mwclass::check();
        }
    }

}