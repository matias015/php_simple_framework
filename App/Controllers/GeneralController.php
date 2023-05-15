<?php

use LDAP\Result;

include_once('App/Models/Alumno.php');
include_once('Fw/Validation.php');
include_once('App/Middleware/isLogin.php');

include_once('App/Services/MailService.php');

class GeneralController{
    
    static function inicio(){
        //();
        Response::view('home');
    }

    /**
     * setear carrera default seleccionada por alumno [post]
     */
    static function setCarrera(){
       

        $carrera_id = Request::value('carrera');
        Carrera::setDefault($carrera_id);
        Request::redirect('/');
    }

}