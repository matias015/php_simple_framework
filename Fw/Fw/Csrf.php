<?php

class CSRF{
    static function generate(){
        if(isset($_SESSION['csrf'])) return;

        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf'] = $token;
        return;
    }

    static function get(){
        return $_SESSION['csrf'];
    }

    static function delete(){
        unset($_SESSION['csrf']);
    }

    static function field(){
        include('Fw/csrf-field.php');
    }
}

