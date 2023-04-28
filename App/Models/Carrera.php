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
        AND curs.id_alumno = ? GROUP BY car.id_carrera
        ", [Auth::user()['ID_ALUMNO']]);
    }

    static function setDefault($idCarrera){
        $userId = Auth::user()['ID_ALUMNO'];
        $yaExiste = DB::queryFirst("SELECT id FROM carrera_default WHERE id_alumno=?",[$userId]);
        
        if(!$yaExiste){
            DB::query("INSERT INTO carrera_default VALUES(NULL, ?, ?)",[$userId,$idCarrera]);
        }else{
            DB::query("UPDATE carrera_default SET id_carrera=? WHERE id_alumno=?",[$idCarrera, $userId]);
        }
    }

    static function getDefault(){
        $carrera = DB::queryFirst("SELECT id_carrera as id FROM carrera_default WHERE id_alumno=?",[$userId = Auth::user()['ID_ALUMNO']]);
        if(!$carrera || $carrera['id'] == 0) return Carrera::deAlumno()[0]['id_carrera'];
        else return $carrera['id'];
    }
}