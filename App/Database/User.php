<?php

namespace App\Database;

use Framework\DB;

class User{
    static function id($id){
        return DB::queryFirst('SELECT * FROM users WHERE id=:idUser',['idUser'=>$id]);
    }
} 