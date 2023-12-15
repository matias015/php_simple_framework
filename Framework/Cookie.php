<?php

namespace Framework;

class Cookie
{
  /*
  * Create a cookie
  */
  static function create(String $name, $value,$path="/")
  {
      $tiempo_expiracion = COOKIE_EXPIRATION_TIME; // Caduca en 30 días (ajusta el tiempo según necesites)
      $dominio = COOKIE_APP_DOMAIN; // Especifica tu dominio (ajusta según tu entorno)
      $secure = COOKIE_SECURE; // Solo se enviará la cookie a través de conexiones seguras (HTTPS)
      $http_only = COOKIE_HTTP_ONLY; // Evita que la cookie sea accesible a través de JavaScript
      setcookie(
        $name, base64_encode($value), $tiempo_expiracion, $path, $dominio, $secure, $http_only);
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
  
}
