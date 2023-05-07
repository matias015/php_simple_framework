<?php

include_once('Query.php');

class DiaNoHabil extends Query{

    protected $table = "dias_no_habiles";

    static function todos(){
        return DiaNoHabil::select('fecha');
    }

    static function agregar($fecha){
        DiaNoHabil::insert()->values(':NULL',$fecha);
    }

}