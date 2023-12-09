<?php

namespace App\Database;

use Framework\DB;

class User{
    static function id($id){
        return DB::queryFirst('SELECT * FROM users WHERE id=:idUser',['idUser'=>$id]);
    }

    static function all(){
        return DB::query('SELECT * FROM users');
    }
} 