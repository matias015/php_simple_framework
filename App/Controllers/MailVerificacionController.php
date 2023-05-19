<?php

include_once('App/Models/Alumno.php');

class MailVerificacionController{

    /**
     * vista de verificacion de mail luego del registro
     */
    static function vista(){
        include_once('App/Views/Auth/verificacion-mail.php');
    }

    function enviarMail(){
        MailService::verificacionMail(Auth::user()->email);
        Request::redirect('verificar-mail');
    }

    /**
     * verificacion [post]
     */
    static function verificar(){
        $token = Request::value('token');
        
        if($_SESSION['TOKEN_VERIF'] != $token) Request::redirect('/verificar-mail', ['mensajes' => ['el token no es correcto']]);
        
        Alumno::verificarMail($token);
        Request::redirect('/login', ['mensajes' => ['Ya puedes iniciar sesion']]);
    }
}