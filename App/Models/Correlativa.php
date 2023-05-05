<?php
include_once('Query.php');

class correlativa{
    static function de($id){

        return Query::select('asignatura_correlativa')
            -> from('correlatividad')
            -> where('id_asignatura',$id)
            -> exec();
    }
}