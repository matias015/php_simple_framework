<?php

class ResetPassword{
    static function setToken($token,$email){
        DB::query("INSERT INTO `password_reset` (`id`, `email`, `token`) 
        VALUES (NULL, ?, ?) ",[$email,$token]);
    }
}
