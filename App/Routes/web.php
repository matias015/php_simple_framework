<?php

require_once('Fw/Route.php');

require_once('App/Controllers/AuthController.php');

require_once('dev.php');

Route::redirect('/','/registro');

Route::get('/registro', function(){ AuthController::registroView(); });
Route::post('/registro', function(){ AuthController::registro(); });

Route::get('/login', function(){ AuthController::loginView(); });
Route::post('/login', function(){});

Route::get('/logout', function(){});