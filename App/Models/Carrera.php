<?php 

include_once('App/Services/FlatArray.php');
include_once('App/Models/Query.php');

class Carrera extends Query{

    protected $table = "carrera";

    static function todas(){
        return  ArrayFlatter::flat(Carrera::select('id'));
    }

    static function deAlumno(){
        $carrerasIds = Carrera::todas();

        return Carrera::select('carrera.id', 'carrera.nombre')
            -> join('asignaturas', 'asignaturas.id_carrera', 'carrera.id')
            -> join('cursada', 'cursada.id_asignatura', 'asignaturas.id')
            -> where('cursada.id_alumno', Auth::id()) 
            -> group('carrera.nombre')
            -> exec();
    }

    static function setDefault($idCarrera){
        $yaExiste = Query::select('id')
            -> from('carreras_default')
            -> where('id_alumno', Auth::id())
            -> first();
        
        if(!$yaExiste){
            Query::insert('carreras_default')
                -> values(':NULL', Auth::id(), $idCarrera)
                -> exec();
        }else{
            Query::update('carreras_default')
                -> set('id_carrera',$idCarrera)
                -> where('id_alumno', Auth::id())
                -> exec();
        }
    }

    static function getDefault(){
        $carrera = Query::select('id_carrera')
            -> from('carreras_default')
            -> where('id_alumno',Auth::id())
            -> first();

        if(!$carrera || $carrera->id == 0) {
            return Carrera::deAlumno()[0]->id;
        }
        else return $carrera->id;
    }
}