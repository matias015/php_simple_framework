<?php

class FormatoTexto{
    static function utf8Minusculas ($texto){
        return ucfirst(mb_strtolower(utf8_encode($texto)));
    }


}