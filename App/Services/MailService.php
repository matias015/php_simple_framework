<?php
include_once('Fw/Mail.php');
include_once('App/Models/Alumno.php');
include_once('App/Models/ResetPassword.php');

class MailService{
    static function verificacionMail($mail){
        $token = rand(100000,999999);
        $_SESSION['TOKE_VERIF'] = $token;

        Mail::to($mail,'Confirma tu correo!',"tu codigo es: $token",'');
    }

    static function resetPwPin($mail){
        $token = rand(100000,999999);
        ResetPassword::setToken($mail,$token);

        Mail::to($mail,'Cambia tu contraseña!',"Tu codigo de reseteo de contraseña es: $token",'');
    }
}