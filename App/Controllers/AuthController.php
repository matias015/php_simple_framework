<?php

use LDAP\Result;

include_once('App/Models/Alumno.php');
include_once('Fw/Validation.php');

include_once('App/Services/MailService.php');

class AuthController{
    
    static function registroView(){
        isLogin::not();
        include_once('App/Views/Auth/registro.php');
    }

    // ok
    static function registro(){
        isLogin::not();
        Validation::validate(function(){
            Validation::required('email','El correo es necesario');
            Validation::required('password','La contraseña es necesaria');
        });

        if(!Validation::success()) Request::redirect('/registro',['errores'=>Validation::getErrors()]);

        $email = Request::value('email');

        $alumno = Alumno::sinRegistrar($email);
        if(!$alumno) Request::redirect('/registro', ['errores'=>['Ya existe una cuenta asociada a este correo electronico o el correo no existe']]);

        Alumno::setPasword(Request::values(['email','password'],false));

        MailService::verificacionMail(Request::value('email'));

        Request::redirect('/login', ['mensajes'=>['Revisa tu correo!']]);
    }

    static function loginView(){
        isLogin::not();
        include_once('App/Views/Auth/login.php');
    }


    static function login(){
        isLogin::not();

        Validation::validate(function(){
            Validation::required('email','El correo es necesario');
            Validation::required('password','La contraseña es necesaria');
        });

        if(!Validation::success()) Request::redirect('/login',['errores'=>Validation::getErrors()]);

        $alumno = Alumno::buscarMailPassword(Request::values(['email','password']));
        if(!$alumno) Request::redirect('/login', ['errores'=>['Credenciales invalidas']]);
        

        if($alumno['verified'] == 0) {
            MailService::verificacionMail(Request::value('email'));
            Request::redirect('/login',['mensajes'=>['Revisa tu mail!']]);
        }

        Auth::login($alumno);
        Request::redirect('/');
    }

    static function verificarEmail(){
        Alumno::verificarMail(Request::values(['mail','token'],false));
        echo 'Ya puedes cerrar esta pagina';
    }

    // ok
    static function logout(){
        Auth::logout();
        Request::redirect('/login');
    }

}