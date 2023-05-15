<?php

class Cookie{
 
    public $name = "";
    public $value = "";
    public $expires_or_options = 0;
    public $path = "/";
    public $domain = "";
    public $secure = SECURE_COOKIES;
    public $httponly = HTTP_COOKIES_ONLY;

    public function __construct()
    {
        $this->expires_or_options = time()+ strtotime(COOKIE_EXPIRATION_TIME);
    }

    public function create(){
        if($this->expires_or_options)
        setcookie($this->name,$this->value,$this->expires_or_options, $this->path, $this->domain, $this->secure, $this->httponly);
    }

    public function name($name){
        $this->name = $name;
        return $this;
    }

    public function expiration($time){
        $this->expires_or_options = $time;
        return $this;
    }

    public function path($path){
        $this->path = $path;
        return $this;
    }

    public function domain($domain){
        $this->domain = $domain;
        return $this;
    }
}
