<?php

include_once('App/Models/Alumno.php');
include_once('App/Models/Cursada.php');
include_once('App/Models/Examen.php');
include_once('App/Models/Mesa.php');
include_once('Fw/Validation.php');
include_once('App/Middleware/isLogin.php');

class AlumnoController{

    static function informacion(){
        isLogin::check();

        $carreras = Carrera::deAlumno();
        $default = Carrera::getDefault();
        
        $datos = Auth::user();
        
        include_once('App/Views/informacion.php');
    }

    static function cursadas(){
        isLogin::check();
        $cursadas = Cursada::alumno();
        $finalesAprobados = ArrayFlatter::flat(Examen::aprobados());

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
        $yaAnotadas = Examen::alumnoAnotado();
        include_once('App/Views/inscripciones.php');
    }
    
    static function inscribirAlumno(){
        isLogin::check();

        $mesa = Request::value('mesa');

        $inscribibles = Alumno::inscribibles();
        $puede = false;

        foreach($inscribibles as $materia){
            if($materia['ID_ASIGNATURA'] == $mesa){
                $puede = true;
                break;
            }
        }

        if(!$puede) Request::redirect('/alumno/inscripciones',['errores' => ['No puedes anotarte a esta mesa']]);

        if(Examen::yaAnotado($mesa)) Request::redirect('/alumno/inscripciones',['errores' => ['Ya estas anotado en esta mesa']]);

        Examen::anotarAlumno($mesa); 

        Request::redirect('/alumno/inscripciones',['mensajes'=>['Te has anotado a la mesa.']]);
    }

    static function desinscribirAlumno(){
        isLogin::check();
        $mesa = Request::value('mesa');
        
        if(!Examen::yaAnotado($mesa)) Request::redirect('/alumno/inscripcion');
        
        Examen::bajar($mesa);
        
        Request::redirect('/alumno/inscripciones',['mensajes'=>['Te has dado de baja de la mesa.']]);
    }
}