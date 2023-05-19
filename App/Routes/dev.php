<?php

include_once('vendor/autoload.php');

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


Route::get('reset', function(){
    DB::query("UPDATE `alumnos` SET `password` = '0', `verificado` = '0' WHERE `alumnos`.`id` = 617");
});


use Dompdf\Dompdf;
Route::get('/pdf',function(){
    $pdf = new DOMPDF();
    $pdf->setPaper('letter','portrait');
    include_once('App/Views/Pdf/test.php');
    $pdf->loadHtml(utf8_decode($data));
    $pdf->render();
    
    $pdf->stream('hola.pdf');
});