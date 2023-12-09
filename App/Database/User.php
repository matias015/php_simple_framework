<?php

namespace App\Database;

use Framework\DB;
use Framework\Query;

class User extends Query{


    static function id($id){
        return DB::queryFirst('SELECT * FROM users WHERE id=:idUser',['idUser'=>$id]);
    }


} 