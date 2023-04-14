<?php

Route::get('/mig', function(){
    include_once('Migrations/Migrations.php');
});

Route::get('/test', function(){
    var_dump(Request::bcrypt(123));
});