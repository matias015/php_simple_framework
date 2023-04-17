<?php
require_once('querys.php');
require_once('Fw/Auth.php');
require_once('App/Services/FlatArray.php');

class Examen extends DB{

    static function aprobados(){
        //examenes aprobados
        return DB::query("SELECT examenes.ID_ASIGNATURA
        FROM examenes
        WHERE examenes.ID_ALUMNO=? AND examenes.NOTA>4",[Auth::user()['ID_ALUMNO']]);
    }

    static function alumno(){
        return DB::query("SELECT asignaturas.nombre as nombre, examenes.nota as nota
        FROM examenes, asignaturas
        WHERE examenes.ID_ALUMNO=?
        AND examenes.id_asignatura=asignaturas.id_asignatura
        ",[Auth::user()['ID_ALUMNO']]);
    }

}