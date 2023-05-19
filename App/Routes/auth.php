<?php

require_once('App/Controllers/AuthController.php');
require_once('App/Controllers/MailVerificacionController.php');

Route::get('/registro', function(){ AuthController::registroView(); })->middleware(['nologin']);
Route::post('/registro', function(){ AuthController::registro(); })->middleware(['nologin']);


Route::get('enviar-mail', [MailVerificacionController::class, 'enviarMail']);

////////////////////
Route::get('/verificar-mail', function(){ MailVerificacionController::vista(); })->middleware(['login']);
Route::post('/verificar-mail', function(){ MailVerificacionController::verificar(); })->middleware(['login']);


Route::get('/login', [AuthController::class,'loginView'])->middleware(['nologin']);
Route::post('/login', function(){ AuthController::login(); })->middleware(['nologin']);

Route::get('/logout', function(){ AuthController::logout(); })->middleware(['login']);

Route::get('/reset-password', function(){ AuthController::resetPasswordView(); });  
Route::post('/reset-password', function(){ AuthController::resetPassword(); });

Route::post('/change-password', function(){ AuthController::cambiarPassword(); });
