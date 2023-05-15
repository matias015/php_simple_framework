<?php

include_once('App/Middleware/isLogin.php');
include_once('App/Middleware/NoLogueado.php');
include_once('App/Middleware/EsAdmin.php');


class Middlewares{
    static $registered = [
      'login' => isLogin::class,
      'nologin' => Nologueado::class,
      'admin' => EsAdmin::class
    ];

    static function exec($alias){
      $class = Middlewares::$registered[$alias];
      call_user_func([$class,'check']);
    }
}

