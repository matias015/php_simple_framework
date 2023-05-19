<?php
include_once('Query.php');

class correlativa extends Query{

    protected $table = 'correlatividades';

    static function de($id){
        return correlativa::select('asignatura_correlativa')
            -> where('id_asignatura',$id)
            -> exec();
    }
}