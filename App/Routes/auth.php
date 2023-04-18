<?php

require_once('App/Controllers/AuthController.php');

Route::get('/registro', function(){ AuthController::registroView(); });
Route::post('/registro', function(){ AuthController::registro(); });

// link que procesa y verifica el token y lo marca como verificado si esta bien
// luego redirige al login o al registro si algo fallo, no muestra ninguna vista
// aqui van los links de verificacion generados del mail del usuario
Route::get('email-verify', function(){ AuthController::verificarEmail(); });

Route::get('/login', function(){ AuthController::loginView(); });
Route::post('/login', function(){ AuthController::login(); });

Route::get('/logout', function(){ AuthController::logout(); });

Route::get('/reset-password', function(){ AuthController::resetPasswordView(); });
Route::post('/reset-password', function(){ AuthController::resetPassword(); });

Route::post('/change-password', function(){ AuthController::cambiarPassword(); });
