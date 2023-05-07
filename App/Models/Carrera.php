<?php 

include_once('App/Services/FlatArray.php');
include_once('App/Models/Query.php');

class Carrera extends Query{

    protected $table = "carrera";

    static function todas(){
        return  ArrayFlatter::flat(Carrera::select('id_carrera'));
    }

    static function deAlumno(){
        $carrerasIds = Carrera::todas();

        return Carrera::select('carrera.id_carrera', 'carrera.nombre')
            -> join('asignaturas', 'asignaturas.id_carrera', 'carrera.id_carrera')
            -> join('cursada', 'cursada.id_asignatura', 'asignaturas.id_asignatura')
            -> where('cursada.id_alumno', Auth::id()) 
            -> group('carrera.nombre')
            -> exec();
    }

    static function setDefault($idCarrera){
        $yaExiste = Query::select('id')
            -> from('carrera_default')
            -> where('id_alumno', Auth::id())
            -> first();
        
        if(!$yaExiste){
            Query::insert('carrera_default')
                -> values(':NULL', Auth::id(), $idCarrera)
                -> exec();
        }else{
            Query::update('carrera_default')
                -> set('id_carrera',$idCarrera)
                -> where('id_alumno', Auth::id())
                -> exec();
        }
    }

    static function getDefault(){
        $carrera = Query::select('id_carrera')
            -> from('carrera_default')
            -> where('id_alumno',Auth::id())
            -> first();

        if(!$carrera || $carrera->id_carrera == 0) {
            return Carrera::deAlumno()[0]->id_carrera;
        }
        else return $carrera->id_carrera;
    }
}