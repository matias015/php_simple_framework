<?php

class DiaNoHabil{
    static function todos(){
        return DB::query("SELECT fecha FROM dias_no_habiles");
    }

    static function agregar($fecha){
        return DB::query("INSERT INTO dias_no_habiles VALUES(NULL,?)",[$fecha]);
    }

}