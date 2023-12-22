<?php

namespace Framework;

class Response{

    static function view($path, $data=[]){
        extract($data);

        $errors = isset($_SESSION['EV_VALIDATION_ERRORS']) ? Session::getAndDelete('EV_VALIDATION_ERRORS') : null;
        include_once('App/Views/'.$path.'.php');
        
        exit;
    }

    static function setStatusCode($code){
        http_response_code($code);
    }

    static function header($h){
        header($h);
    }

    static function json($data){
        header('Content_Type: application/json');
        echo json_encode($data);
        exit;
    }

    static function redirect($url){
        header('Location: '.$url);
        exit;
    }

}