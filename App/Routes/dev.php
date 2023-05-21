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

include_once('Fw/Cache.php');


Route::get('/dias', function(){
    echo DiasHabiles::desdeHoyHasta(Mesa::select('fecha')->where('id_mesa', 4452)->first()->fecha);
});

Route::get('test',function(){

    // SETEA CACHE
    $result = Alumno::inscribibles();

    Cache::setForLogged('ins',$result);

    // SIN CACHE
    Debug::performance(function(){
        Alumno::inscribibles();
    });

    // CON CACHE
    Debug::performance(function(){
        print_r(
            Cache::getForLogged('ins', fn() => Alumno::inscribibles())
        );
    });
    

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

include_once('App/Models/Asignatura.php');
include_once('App/Models/Examen.php');
Route::get('add-mesas',function(){
    $materias = Asignatura::all();
   
    
    Examen::update()->set('nota','8')->where('id_alumno',Auth::id())->exec();
    // foreach($materias as $materia){
    //     Mesa::insert()->values(':NULL',$materia->id,$materia->id_carrera,5,4,3,1,'2023-5-29 00:00:00','18')->exec();
    //     Mesa::insert()->values(':NULL',$materia->id,$materia->id_carrera,5,4,3,2,'2023-6-12 00:00:00','18')->exec();
    // }

});