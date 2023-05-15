<?php

include_once('DB.php');

class Migrator{


    static function exec($registered){
    
        foreach($registered as $sql){
            try{
                DB::query($sql,[]);
            }catch(Exception $e){
                continue;
            }
        }

    }


}