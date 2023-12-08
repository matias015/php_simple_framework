<?php

use App\Database\User;
use App\Request\Val;
use Framework\Req;
use Framework\Response;
use Framework\Route;



Route::get('a', function(){
    Response::view('home');
});

Route::get('xd', function(){
    echo Response::redirect(Req::referer());
});

Route::post("users/post", function(){
    Req::deleteEmptyInputs();

    $status = Val::start()->rules(function($val){
        return [
            $val->maxlen('f1',10,'Este es el mensaje'),
            $val->maxlen('f2',5,'Este es el mensaje 2')
        ];
    });

    if($status->success()) echo 'pasoooo';
});

Route::get('users/*/edit',function(){
    $userId = Route::segment(2);

    Val::start()->rules(function($val){
        return [
            $val->maxlen('f1',10,'Este es el mensaje')
        ];
    });

    $user = User::id($userId);
    print_r($user->email);
});

Route::get('/path2',function(){
    echo Route::path();
});
