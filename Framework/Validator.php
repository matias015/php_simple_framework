<?php
namespace Framework;

use App\Request\ValidationMessages;

class Validator{

    public $errors;

    public $value;
    public $name;

    public function __construct() {
        $this->errors=[];
        $this->value = '';
        $this->name = '';
    }

    /**
     * 
     * [
     *      'name' => ['required','other']
     * ]
     * 
     */
   static function start($fields)
   {
        $validator = new Validator();
        
        foreach($fields as $name => $fieldRules){
            $validator->name = $name;
            
            if(isset($_POST[$name]))
                $validator->value = $_POST[$name];
            else if(isset($_GET[$name]))
                $validator->value = $_GET[$name];
            else
                $validator->value = null;
            
            foreach($fieldRules as $rule){
                $exploded = explode(':', $rule);
                $method = $exploded[0];
                unset($exploded[0]);                      
                call_user_func_array([$validator, $method], $exploded);
            }    
            
        }

        if(!empty($validator->errors)){
            $_SESSION['EV_VALIDATION_ERRORS']=$validator->errors;
        }

    }
    
    public function getErrorMessage($rule){
        return ValidationMessages::$ev_app_error_messages['es'][$rule];
    }

    public function getAlias(){
        return isset(ValidationMessages::$ev_app_error_aliases['es'][$this->name]) ?
            ValidationMessages::$ev_app_error_aliases['es'][$this->name] : $this->name;
    }

    public function getProcesedErrorMessage($rule){
        $alias = $this->getAlias();
        $message = $this->getErrorMessage($rule);
        
        return str_replace(':@', $alias, $message);
    }

    public function insertExtraData($array, $message){
        foreach($array as $index => $value){
            $message = str_replace(':arg'.$index, $value, $message);
        }
        return $message;
    }

    public function addError($rule, $extra=null){
        $msg = $this->getProcesedErrorMessage($rule);
        if($extra)
            $msg = $this->insertExtraData($extra, $msg);
        $this->errors[$this->name] = $msg;
    }

    public function required(){
        if(!$this->value) $this->addError('required');
    }

    public function minlen($min){
        if(strlen($this->value)<$min)
            $this->addError('minlen',[$min]);
    }
    
    public function maxlen($max){
        if(strlen($this->value)>$max)
            $this->addError('maxlen',[$max]);
    }

}