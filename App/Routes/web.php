<?php

require_once('Fw/Route.php');

require_once('App/Controllers/GeneralController.php');
require_once('App/Controllers/AlumnoController.php');
require_once('App/Controllers/AdminController.php');


require_once('dev.php');
require_once('errors.php');



Route::get('/', function(){ GeneralController::inicio(); })->middleware(['login']);

include_once('auth.php');

Route::redirect('/alumno','/alumno/informacion');

Route::get('/setear-carrera', function(){ GeneralController::setCarrera(); })->middleware(['login']);

Route::get('/alumno/informacion', fn()=>AlumnoController::informacion())->middleware(['login']);
Route::get('/alumno/cursadas', fn()=>AlumnoController::cursadas())->middleware(['login']);
Route::get('/alumno/examenes', fn() => AlumnoController::examenes())->middleware(['login']);
Route::get('/alumno/inscripciones', function(){ AlumnoController::inscripciones(); })->middleware(['login']);
Route::post('/alumno/inscripciones', function(){ AlumnoController::inscribirAlumno(); })->middleware(['login']);
Route::post('/alumno/desinscripcion', function(){ AlumnoController::desinscribirAlumno(); })->middleware(['login']);

Route::get('/admin/login', function(){ AdminController::loginView(); })->middleware(['nologin']);
Route::post('/admin/login', function(){ AdminController::login(); })->middleware(['nologin']);
Route::get('/admin/logout', function(){ AdminController::logout(); })->middleware(['admin']);

Route::get('/admin',[AdminController::class,'index'])->middleware(['admin']);
Route::get('/admin/dias', function(){ AdminController::noHabiles(); })->middleware(['admin']);
Route::post('/admin/dias/agregar', function(){ AdminController::agregarDia(); })->middleware(['admin']);
Route::post('/admin/dias/eliminar', function(){ AdminController::eliminarDia(); })->middleware(['admin']);