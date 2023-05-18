<?php
require_once('App/Controllers/AdminController.php');
Route::get('/admin/login', function(){ AdminController::loginView(); })->middleware(['nologin']);
Route::post('/admin/login', function(){ AdminController::login(); })->middleware(['nologin']);
Route::get('/admin/logout', function(){ AdminController::logout(); })->middleware(['admin']);

Route::get('/admin',[AdminController::class,'index'])->middleware(['admin']);
Route::get('/admin/dias', function(){ AdminController::noHabiles(); })->middleware(['admin']);
Route::post('/admin/dias/agregar', function(){ AdminController::agregarDia(); })->middleware(['admin']);
Route::post('/admin/dias/eliminar', function(){ AdminController::eliminarDia(); })->middleware(['admin']);