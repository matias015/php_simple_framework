<?php

namespace App\Request;

use Framework\Validator;

class Val extends Validator{

    public function adulto(){
        if($this->value < 18){
            $this->addError('adulto');
        }
    }

    public function genero($arg){
        if($this->value == $arg){
            $this->addError('genero',[$arg]);
        }
    }
}