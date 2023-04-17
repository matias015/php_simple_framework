<?php
require_once('querys.php');
class User extends DB{

    static function all(){
        return DB::query("SELECT * FROM users",[]);
    }

}