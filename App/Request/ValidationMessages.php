<?php

namespace App\Request;

class ValidationMessages{

    static $ev_app_error_messages = [
        'es' => [
            'required' => 'El campo :@ es requerido',
            'minlen' => 'El campo :@ no puede tener menos de :arg0 caracteres',
            'maxlen' => 'El campo :@ no debe tener mas de :arg0 caracteres',
            'adulto' => 'No eres mayor de de edad',
            'genero' => 'Solo puedes ingresar si tu genero es :arg0'
            ]
        ];
        
    static $ev_app_error_aliases = [
            'es' => [
                'name' => 'nombre',
                ]
            ];
}