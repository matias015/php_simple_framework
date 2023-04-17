<?php

Route::get('/mig', function(){
    include_once('Migrations/Migrations.php');
});

include_once('App/Models/Alumno.php');


Route::get('/test',function(){
    print_r(Alumno::inscribibles(616));
    
});