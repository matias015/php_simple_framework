<?php

namespace App\Database;

use Framework\Database\DB;


class User{


    static function id($id){
        return DB::query_first('SELECT * FROM users WHERE id=:idUser',['idUser'=>$id]);
    }


} 