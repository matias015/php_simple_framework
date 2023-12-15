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
    $users = DB::query('SELECT * FROM users');
    return Response::view('index',['users'=> $users]);
});

Route::get('/session', function(){
    Session::set('test','2');
    echo Session::get('test');
    Session::unset('test');
    echo Session::get('test');
});

Route::get('/path', function(){

});

Route::get('/edit/*',function(){
    $user_id = Route::segment(2);
    $user = User::id($user_id);

    return Response::view('edit',['user'=>$user]);
});

Route::put('/edit/*', function(){
    $user_id = Route::segment(2);
    
    Session::set('previuous', Req::post_all());
   
    DB::query('UPDATE users SET username = :username, email = :email WHERE id=:userid',[
        'username'=> Req::post('username'),
        'email'=> Req::post('email'),
        'userid' => $user_id
    ]);

    // return Response::redirect('/');
});

Route::get('/segment/a/b',function(){
    echo "el segment es: " . Route::segment(1);
});