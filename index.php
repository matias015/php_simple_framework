<?php

// date_default_timezone_set('America/Argentina/Buenos_Aires');    
spl_autoload_register(function ($class_name) {
    $base_dir = __DIR__."/";
    
    // Reemplaza los backslashes por slashes en el nombre de la clase
    $class_name = str_replace('\\', '/', $class_name);
    
    // Ruta completa del archivo de la clase
    $file = $base_dir . $class_name . '.php';

    // Verifica si el archivo existe y lo incluye
    if (file_exists($file)) {
        require_once $file;
    }
});

use Framework\Route;

include_once('App/Routes/web.php');

Route::dispatch();