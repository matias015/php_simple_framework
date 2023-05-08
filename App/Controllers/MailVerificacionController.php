<?php

include_once('App/Models/Alumno.php');

class MailVerificacionController{

    /**
     * vista de verificacion de mail luego del registro
     */
    static function vista(){
        include_once('App/Views/Auth/verificacion-mail.php');
    }

    /**
     * verificacion [post]
     */
    static function verificar(){
        $token = Request::value('token');
        Alumno::verificarMail($token);
        Request::redirect('/login', ['mensajes' => ['Ya puedes iniciar sesion']]);
    }
}