<?php 
include_once('Fw/Route.php');

class Validation{
    static private $errors;
    static private $data;



    static function validate($cb){
        if(Route::method() == 'POST') Validation::$data = $_POST;
        if(Route::method() == 'GET') Validation::$data = $_GET;
        Validation::$errors = [];
        $cb();
    }

    static function getErrors(){
        return Validation::$errors;
    }

    static function success(){
        return count(Validation::$errors) === 0;
    }

    static private function nameHasError($name){
        return isset(Validation::$errors[$name]);
    }

    static public function required($name, $msg){
        if(Validation::nameHasError($name)) return;
        if(!Request::has($name)){
            Validation::$errors[$name] = $msg;
        }
    }

    static public function in($name, $values, $msg){
        if(Validation::nameHasError($name)) return;
        if(!in_array(Validation::$data[$name], $values)){
            Validation::$errors[$name] = $msg;
        }
    }
    
}

