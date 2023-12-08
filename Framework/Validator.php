<?php
namespace Framework;
use Framework\Req;


class Validator{

    public $errors;

    public function __construct() {
        $this->errors=[];
    }

    public function rules($cb){
        $cb($this);
        return $this;
    }

    public function success(){
        if(\count($this->errors)>0)return false;
        else return true;
    }

    static function start(){
        return new Validator();
    }

    public function maxlen($input,$max,$mssg){
        $val = Req::any($input);
        if(\strlen($val)>$max){
            $this->errors[$input]=$mssg;
        }
    }


}