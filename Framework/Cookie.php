<?php

namespace Framework;

use COM;

class Cookie
{
  /*
  * Create a cookie
  */
  static function create(String $name, $value,$path="/")
  {
      setcookie(
        $name, 
        base64_encode($value), 
        COOKIE_EXPIRATION_TIME, 
        $path, 
        COOKIE_APP_DOMAIN, 
        SECURE_COOKIES, 
        HTTP_COOKIES_ONLY
    );
  }

  static function exists($key)
  {
      return isset($_COOKIE[$key]);
  }
  
  static function get($key)
  {
      if (Cookie::exists($key)) 
          return null;
    
      $valor_cookie = $_COOKIE['mi_cookie'];
      return base64_decode($valor_cookie);
  } 

  
}
  
