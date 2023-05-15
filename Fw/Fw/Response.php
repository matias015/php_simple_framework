<?php

class Response{

    static function view($path, $data=[]){
        extract($data);
        $path = str_replace('.','/',$path);
        include_once('App/Views/'.$path.'.php');
    }

    static function json($data){
        echo json_encode($data);
    }

}