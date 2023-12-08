<?php

    spl_autoload_register(function ($class_name) {
        // Ruta base de tus clases
        $base_dir = __DIR__."\/..\/";
        
        // Reemplaza los backslashes por slashes en el nombre de la clase
        $class_name = str_replace('\\', '/', $class_name);
        
        // Ruta completa del archivo de la clase
        $file = $base_dir . $class_name . '.php';
        echo $file;
        // Verifica si el archivo existe y lo incluye
        if (file_exists($file)) {
            
            require_once $file;
        }
    });

