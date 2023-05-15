<?php

require_once('App/Controllers/AuthController.php');
require_once('App/Controllers/MailVerificacionController.php');

Route::get('/registro', function(){ AuthController::registroView(); })->middleware(['nologin']);
Route::post('/registro', function(){ AuthController::registro(); })->middleware(['nologin']);

////////////////////
Route::get('email-verify', function(){ MailVerificacionController::vista(); })->middleware(['nologin']);
Route::post('email-verify', function(){ MailVerificacionController::verificar(); })->middleware(['nologin']);


Route::get('/login', [AuthController::class,'loginView'])->middleware(['nologin']);
Route::post('/login', function(){ AuthController::login(); })->middleware(['nologin']);

Route::get('/logout', function(){ AuthController::logout(); })->middleware(['login']);

Route::get('/reset-password', function(){ AuthController::resetPasswordView(); });  
Route::post('/reset-password', function(){ AuthController::resetPassword(); });

Route::post('/change-password', function(){ AuthController::cambiarPassword(); });
