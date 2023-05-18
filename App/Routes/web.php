<?php

require_once('Fw/Route.php');

require_once('App/Controllers/GeneralController.php');
require_once('App/Controllers/AlumnoController.php');


require_once('dev.php');
require_once('errors.php');



Route::get('/', fn() => GeneralController::inicio());

include_once('auth.php');

Route::redirect('/alumno','/alumno/informacion');

Route::get('/setear-carrera', function(){ GeneralController::setCarrera(); })->middleware(['login']);

Route::get('/alumno/informacion', fn()=>AlumnoController::informacion())->middleware(['login']);
Route::get('/alumno/cursadas', fn()=>AlumnoController::cursadas())->middleware(['login']);
Route::get('/alumno/examenes', fn() => AlumnoController::examenes())->middleware(['login']);
Route::get('/alumno/inscripciones', function(){ AlumnoController::inscripciones(); })->middleware(['login']);
Route::post('/alumno/inscripciones', function(){ AlumnoController::inscribirAlumno(); })->middleware(['login']);
Route::post('/alumno/desinscripcion', function(){ AlumnoController::desinscribirAlumno(); })->middleware(['login']);


include_once('App/Routes/admin.php');