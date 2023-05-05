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
            //DB::query("INSERT INTO carrera_default VALUES(NULL, :user_id, :id_carrera)",['user_id'=>$userId,'id_carrera'=>$idCarrera]);
        }else{
            DB::query("UPDATE carrera_default SET id_carrera=:id_carrera WHERE id_alumno=:user_id",['user_id'=>$userId,'id_carrera'=>$idCarrera]);
        }
    }

    static function getDefault(){
        $carrera = DB::queryFirst("SELECT id_carrera as id FROM carrera_default WHERE id_alumno=:id",['id'=>Auth::id()]);
        if(!$carrera || $carrera->id == 0) return Carrera::deAlumno()[0]->id_carrera;
        else return $carrera->id;
    }
}