<?php

Route::get('/mig', function(){
    include_once('Migrations/Migrations.php');
});

include_once('App/Models/Alumno.php');
include_once('App/Models/Carrera.php');
include_once('App/Models/Mesa.php');

include_once('Fw/Debug.php');
include_once('App/Services/DiasHabiles.php');

Route::get('/dias', function(){
    $fecha = DB::queryFirst("SELECT * FROM mesa WHERE ID_MESA=4454")->fecha;
    echo "fecha: $fecha <br>";
    print_r(DiasHabiles::desdeHoyHasta($fecha));
});

Route::get('test',function(){
    $materias = Alumno::inscribibles();
    
    foreach($materias as $key => $materia){
        $mesas = Mesa::materia($materia->id_asignatura);
        foreach($mesas as $key => $mesa){
                $mesa -> {'diasHabiles'} = DiasHabiles::desdeHoyHasta($mesa->fecha);
                $mesas[$key] = $mesa;
        }
        $conMesa = $materia;
        $conMesa -> {'mesas'} = $mesas;
        $materias[$key] = $conMesa;
    }

    print_r($materias);
});