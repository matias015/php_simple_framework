<?php

use App\Database\Post;
use App\Database\User;
use Framework\Database\DB;
use Framework\Database\Item;
use Framework\Req;
use Framework\Response;
use Framework\Route;
use Framework\Session;

Route::get('/',function(){
    echo Route::getBasePath();
    $users = DB::query('SELECT * FROM users');
    return Response::view('index',['users'=> $users]);
});

Route::get('/session', function(){
    Session::set('xd','2');
    echo Session::get('xd');
    Session::unset('xd');
    echo Session::get('xd');
});

Route::get('/path', function(){
    echo Route::route('xd/2');
});

Route::get('/edit/*',function(){
    $user_id = Route::segment(2);
    $user = User::id($user_id);

    return Response::view('edit',['user'=>$user]);
});

Route::put('/edit/*', function(){
    $user_id = Route::segment(2);
    
    Session::set('previuous', Req::postAll());
   
    DB::query('UPDATE users SET username = :username, email = :email WHERE id=:userid',[
        'username'=> Req::post('username'),
        'email'=> Req::post('email'),
        'userid' => $user_id
    ]);

    // return Response::redirect('/');
});

Route::get('/segment/a/b',function(){
    echo "el segment es: ".Route::segment(1);
});