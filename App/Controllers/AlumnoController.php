<?php

include_once('App/Models/Alumno.php');
include_once('App/Models/Cursada.php');
include_once('App/Models/Examen.php');
include_once('Fw/Validation.php');
include_once('App/Middleware/isLogin.php');

class AlumnoController{

    static function informacion(){
        isLogin::check();
        $datos = Auth::user();
        include_once('App/Views/informacion.php');
    }

    static function cursadas(){
        isLogin::check();
        $cursadas = Cursada::alumno();

        include_once('App/Views/cursadas.php');
    }

    static function examenes(){
        isLogin::check();
        $examenes = Examen::alumno();

        include_once('App/Views/examenes.php');
    }

    static function inscripciones(){
        isLogin::check();
        $materias = Alumno::inscribibles();

        include_once('App/Views/inscripciones.php');
    }
    
}