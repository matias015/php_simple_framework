<?php

class Mesa{
    static function materia($id){
        return DB::query("SELECT * 
            FROM mesa, asignaturas
            WHERE mesa.id_asignatura=asignaturas.id_asignatura
        ");
    }
}