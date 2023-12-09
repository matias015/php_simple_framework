<?php

use App\Database\User;
use Framework\DB;
use Framework\Req;
use Framework\Response;
use Framework\Route;

Route::get('/',function(){
    return Response::view('index',['users'=>User::all()]);
});

Route::get('/edit/*',function(){
    $user_id = Route::segment(2);
    $user = User::id($user_id);

    return Response::view('edit',['user'=>$user]);
});

Route::put('/edit/*', function(){
    $user_id = Route::segment(2);

    DB::query('UPDATE users SET username = :username, email = :email WHERE id=:userid',[
        'username'=> Req::post('username'),
        'email'=> Req::post('email'),
        'userid' => $user_id
    ]);

    return Response::redirect('/');
});