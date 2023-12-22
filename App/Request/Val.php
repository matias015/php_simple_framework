<?php

namespace App\Request;

use Framework\Validator;

class Val extends Validator{

    public function my_custom_validation(){
        if('pass'){
            return;
        }else {
            $this->addError('my_custom_validation');
        }
        
    }

}
