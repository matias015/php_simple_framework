<?php
include_once('Fw/Mail.php');
include_once('App/Models/Alumno.php');
include_once('App/Models/ResetPassword.php');

// FUNCIONA!
class MailService{
    static function verificacionMail($mail){
        $token = bin2hex(random_bytes(16));
        Alumno::setVerificacionToken($mail,$token);

        $url = "http://" . $_SERVER['HTTP_HOST'] . "/email-verify?mail=$mail&token=$token";
        Mail::to($mail,'Confirma tu correo!','<a href="'.$url.'">Haz click aqui para confirmar tu correo</a>','');
        
    }
    static function resetPwPin($mail){
        $token = substr(time(),4);
        ResetPassword::setToken($mail,$token);

        Mail::to($mail,'Cambia tu contraseña!',"Tu codigo de reseteo de contraseña es: $token",'');
    }
}