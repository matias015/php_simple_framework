<?php

namespace Framework;

class Exception{

    static function report($error_reported){
        echo include_once('exception-view.php');
    }

}