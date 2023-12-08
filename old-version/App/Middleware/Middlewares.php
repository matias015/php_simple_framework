<?php


class Middlewares{
    static $registered = [
      // 'middleware_name' => isLogin::class,
    ];

    static function exec($alias){
      $class = Middlewares::$registered[$alias];
      call_user_func([$class,'check']);
    }
}

