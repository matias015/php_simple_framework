<?php

class Response{

    static function view($path, $data=[]){
        extract($data);
        include_once('App/views/'.$path.'.php');
    }

    static function json($data){
        
        echo json_encode($data);
    }

}