<?php 
include_once('Fw/Routing.php');

class Validation{
    static private $errors;
    static private $data;

    static function validate($cb){
        if(Routing::method() == 'POST') Validation::$data = $_POST;
        if(Routing::method() == 'GET') Validation::$data = $_GET;
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

    static public function unique($name, $tableDb,$msg){
        if(Validation::nameHasError($name)) return;

        $table = $tableDb[0];
        $field = $tableDb[1];

        $value = Validation::$data[$name];

        if(DB::queryFirst("SELECT $field FROM $table WHERE $field='$value'")){
            Validation::$errors[$name] = $msg;
        }
    }

    static public function min($name, $min, $msg){
        if(Validation::nameHasError($name)) return;
        if(strlen(Validation::$data[$name]) < $min){
            Validation::$errors[$name] = $msg;
        }
    }

    static public function max($name, $max, $msg){
        if(Validation::nameHasError($name)) return;
        if(strlen(Validation::$data[$name]) > $max){
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

