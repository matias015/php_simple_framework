<?php

class correlativa{
    static function de($id){
        return DB::query("SELECT ASIGNATURA_CORRELATIVA 
        FROM `correlatividad` 
        WHERE ID_ASIGNATURA=?",[$id]);
    }
}