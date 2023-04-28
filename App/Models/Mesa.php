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

   



    
}