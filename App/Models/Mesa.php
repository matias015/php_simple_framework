<?php

include_once('App/Services/FlatArray.php');

class Mesa{
    static function materia($id){
        return DB::query("SELECT * 
            FROM mesa
            WHERE mesa.id_asignatura=?
            AND FECHA>NOW()
        ",[$id]);
    }

   static function disponibles(){
    $idCarrera = Carrera::getDefault();

    return ArrayFlatter::flat(DB::query("SELECT mesa.id_mesa
            FROM mesa, asignaturas
            WHERE mesa.id_asignatura=asignaturas.id_asignatura
            AND asignatura.id_carrera = carrera.id_carrera
            AND carrera.id_carrera = ?
            AND FECHA>NOW()",[$idCarrera]));
   }



    
}