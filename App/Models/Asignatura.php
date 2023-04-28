<?php 

class Asignatura{
    static function carrera($id){
        return DB::queryFirst("SELECT * 
        FROM carrera,asginatura 
        WHERE asignatura.id_asignatura = ? 
        AND asignatura.id_carrera=carrera.id_carrera",[$id]);
    }
}