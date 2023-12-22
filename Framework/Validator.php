<?php
namespace Framework;

use App\Request\Val;
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
        $validator = new Val();
        
        foreach($fields as $name => $fieldRules){
            $validator->setName($name);
            
            if(isset($_POST[$name]))
                $validator->setValue($_POST[$name]);
            else if(isset($_GET[$name]))
                $validator->setValue($_GET[$name]);
            else
                $validator->setValue(null);
            
            foreach($fieldRules as $rule){
                $exploded = explode(':', $rule);
                $method = $exploded[0];
                unset($exploded[0]);                      
                call_user_func_array([$validator, $method], $exploded);
            }    
            
        }

        if($validator->hasErrors()){
            $_SESSION['EV_VALIDATION_ERRORS']=$validator->errors;
            Response::redirect(Req::referer());
        }

        return $validator;
    }
    
    public function setValue($value){
        $this->value = $value;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function hasErrors()
    {
        return (!(empty($this->errors)));
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function getErrorMessage($rule){
        return ValidationMessages::$ev_app_error_messages['es'][$rule];
    }

    private function getAlias(){
        return isset(ValidationMessages::$ev_app_error_aliases['es'][$this->name]) ?
            ValidationMessages::$ev_app_error_aliases['es'][$this->name] : $this->name;
    }

    private function getProcesedErrorMessage($rule){
        $alias = $this->getAlias();
        $message = $this->getErrorMessage($rule);
        
        return str_replace(':@', $alias, $message);
    }

    private function insertExtraData($array, $message){
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