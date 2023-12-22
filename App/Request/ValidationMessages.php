<?php

namespace App\Request;

class ValidationMessages{

    static $ev_app_error_messages = [
        'es' => [
            'required' => 'El campo :@ es requerido',
            'minlen' => 'El campo :@ no puede tener menos de :arg0 caracteres',
            'maxlen' => 'El campo :@ no debe tener mas de :arg0 caracteres',
            'my_custom_validation' => 'the field :@ does not pass the custom validation :(',
            ]
        ];
        
    static $ev_app_error_aliases = [
            'es' => [
                'name' => 'nombre',
                ]
            ];
}
