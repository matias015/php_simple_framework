<?php

require_once('config.php');

spl_autoload_register(function ($class_name) {
    $class_name = str_replace('\\', '/', $class_name);
    
    $file = __DIR__."/" . $class_name . '.php';
    
    if (file_exists($file)) require_once $file;
});

if(HIDE_WARNINGS) error_reporting(E_ERROR | E_PARSE);

session_start();

use Framework\Route;

include_once('App/Routes/web.php');

Route::dispatch();

    

