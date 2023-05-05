<?php 

include_once('App/Services/FlatArray.php');

class Carrera{
    static function todas(){
        return  ArrayFlatter::flat(DB::query("SELECT id_carrera FROM carrera"));
    }

    static function deAlumno(){
        $carrerasIds = Carrera::todas();

        return DB::query("SELECT car.id_carrera, car.nombre
        FROM carrera car,asignaturas asig,cursada curs
        WHERE car.id_carrera = asig.id_carrera
        AND asig.id_asignatura = curs.id_asignatura
        AND curs.id_alumno = :id GROUP BY car.id_carrera
        ", ['id'=> Auth::id()]);
    }

    static function setDefault($idCarrera){
        $userId = Auth::id();
        $yaExiste = DB::queryFirst("SELECT id FROM carrera_default WHERE id_alumno=:id_alumno",['id_alumno'=>$userId]);
        
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