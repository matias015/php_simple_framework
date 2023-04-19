<?php

class ResetPassword{
    static function setToken($token,$email){
        DB::query("INSERT INTO `password_reset` (`id`, `email`, `token`) 
        VALUES (NULL, ?, ?) ",[$token,$email]);
    }

    static function buscarMailConToken($token){
        return DB::queryFirst("SELECT id,email FROM password_reset WHERE token=?",[$token]);
    }

    static function borrar($id){
        DB::query("DELETE FROM password_reset WHERE id=?",[$id]);
    }
}

