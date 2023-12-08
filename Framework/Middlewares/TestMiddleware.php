<?php

namespace Framework\Middlewares;

class TestMiddleware{

    static function check(){
        echo 'mw executado';
        return true;
    }

}