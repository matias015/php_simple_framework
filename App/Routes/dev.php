<?php

Route::get('/mig', function(){
    include_once('Migrations/Migrations.php');
});

include_once('App/Models/Alumno.php');
include_once('App/Models/Carrera.php');
include_once('App/Models/Mesa.php');

include_once('Fw/Debug.php');
include_once('App/Services/DiasHabiles.php');

include_once('App/Models/DiaNoHabil.php');


Route::get('/dias', function(){
    echo DiasHabiles::desdeHoyHasta(Mesa::select('fecha')->where('id_mesa', 4452)->first()->fecha);
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