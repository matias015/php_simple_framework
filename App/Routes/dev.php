<?php

Route::get('/mig', function(){
    include_once('Migrations/Migrations.php');
});

include_once('App/Models/Alumno.php');
include_once('App/Models/Carrera.php');

include_once('Fw/Debug.php');
include_once('App/Services/DiasHabiles.php');

Route::get('/dias', function(){
    $fecha = DB::queryFirst("SELECT * FROM mesa WHERE ID_MESA=4454")->fecha;
    echo "fecha: $fecha <br>";
    print_r(DiasHabiles::desdeHoyHasta($fecha));
});

Route::get('test',function(){
    print_r(Examen::delete()
        -> where('id_mesa',':4242')
        -> andWhere('id_alumno', '616') 
        -> getQueryString());
});