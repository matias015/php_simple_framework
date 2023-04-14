<?php

include_once('App/Models/Alumno.php');

class AuthController{
    
    static function registroView(){
        include_once('App/Views/Auth/registro.php');
    }

    static function registro(){
        $email = Request::value('email');

        if(Alumno::existente($email)) Request::redirect('/registro', ['mensaje'=>'Ya existe una cuenta asociada a este correo electronico']);
        
        Alumno::setPasword(Request::values(['email','password'],false));
        
        Request::redirect('/login', ['mensaje'=>'Ya puedes ingresar con tu cuenta!']);
    }

    static function loginView(){
        include_once('App/Views/Auth/login.php');
    }

}