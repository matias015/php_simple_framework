<?php

class CSRF{
    static function create(){
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf'] = $token;
        return $token;
    }
}

$_input = "<input hidden name='csrf' value=". CSRF::create() .">";
echo $_input;