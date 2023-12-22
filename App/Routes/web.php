<?php

use App\Database\User;
use App\Request\Val;
use Framework\Database\DB;
use Framework\Req;
use Framework\Response;
use Framework\Route;
use Framework\Session;

Route::get('/form', function(){
    return Response::view('index');
});

Route::get('/form2', function(){
    return Response::view('index');
});
Route::get('/form3', function(){
    return Response::view('index');
});
Route::get('/fo4rm', function(){
    return Response::view('index');
});

Route::get('/fo6rm', function(){
    return Response::view('index');
});

// Route::fallback(function(){
//     echo 404;
// });