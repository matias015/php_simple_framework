<?php

require_once('Fw/Route.php');

require_once('App/Controllers/GeneralController.php');
require_once('App/Controllers/AlumnoController.php');


require_once('dev.php');
require_once('errors.php');

Route::get('/', function(){ GeneralController::inicio(); });

include_once('auth.php');

Route::get('/alumno/informacion', function(){ AlumnoController::informacion(); });
Route::get('/alumno/cursadas', function(){ AlumnoController::cursadas(); });
Route::get('/alumno/examenes', function(){ AlumnoController::examenes(); });
Route::get('/alumno/inscripciones', function(){ AlumnoController::inscripciones(); });
Route::post('/alumno/inscripciones', function(){ AlumnoController::inscribirAlumno(); });