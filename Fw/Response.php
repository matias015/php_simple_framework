<?php

class Response{

    static function view($path){
        include_once('App/views/'.$path.'.php');
    }

    static function json($data){
        echo json_encode($data);
    }

}