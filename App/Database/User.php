<?php

namespace App\Database;

use Framework\Database\Query;
use Framework\Database\DB;


class User extends Query{


    static function id($id){
        return DB::queryFirst('SELECT * FROM users WHERE id=:idUser',['idUser'=>$id]);
    }


} 