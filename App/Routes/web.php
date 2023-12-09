<?php

use App\Database\Post;
use App\Database\User;
use Framework\DB;
use Framework\Item;
use Framework\Req;
use Framework\Response;
use Framework\Route;

Route::get('/',function(){
    $users = User::query()
        -> selectAll()
        -> from('users')
        -> exec();

    $posts = Post::query()
        -> selectAll()
        -> from('posts')
        -> exec();

    
    print_r($users);
    print_r($posts);
    echo '<br><br><br>';
    $final = Item::unifyMany($users,$posts,'id_user','posts');
    foreach($final as $user){
        print_r($user);
        echo '<br><br>';
    }
    
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