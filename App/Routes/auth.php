<?php

require_once('App/Controllers/AuthController.php');
require_once('App/Controllers/MailVerificacionController.php');

Route::get('/registro', function(){ AuthController::registroView(); });
Route::post('/registro', function(){ AuthController::registro(); });

////////////////////
Route::get('email-verify', function(){ MailVerificacionController::vista(); });
Route::post('email-verify', function(){ MailVerificacionController::verificar(); });


Route::get('/login', [AuthController::class,'loginView']);
Route::post('/login', function(){ AuthController::login(); });

Route::get('/logout', function(){ AuthController::logout(); });

Route::get('/reset-password', function(){ AuthController::resetPasswordView(); });
Route::post('/reset-password', function(){ AuthController::resetPassword(); });

Route::post('/change-password', function(){ AuthController::cambiarPassword(); });
