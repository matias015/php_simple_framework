<?php

include_once('App/Services/FlatArray.php');
require_once('Query.php');

class Mesa extends Query{
    protected $table = "mesa";

    static function materia($id){
        return Mesa::select('id_mesa', 'fecha', 'llamado')
            -> where('id_asignatura', $id) 
            -> andWhere('fecha','>',':NOW()')
            -> exec();
    }

    static function disponibles($asignatura){
        return ArrayFlatter::flat(DB::query("SELECT mesa.id_mesa
                FROM mesa
                WHERE mesa.id_asignatura=?
                AND FECHA>NOW()",[$asignatura]));
   }



    
}