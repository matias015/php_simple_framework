<?php
require_once('querys.php');

class Alumno extends DB{

    static function existente($mail){
        return DB::queryFirst("SELECT * FROM alumnos WHERE alumnos.correo=? AND alumnos.password IS NOT NULL",[$mail],true);
    }

    static function setPasword($data){
        $email = $data[0];
        $pw = md5($data[1]);
        return DB::query("UPDATE alumnos SET alumnos.password = ? WHERE alumnos.correo = ? ",[$pw,$email]);
    }

}