<?php

use LDAP\Result;

include_once('App/Models/Alumno.php');
include_once('App/Models/ResetPassword.php');

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

        Request::redirect('/email-verify', ['mensajes'=>['Revisa tu correo!']]);
    }

    static function loginView(){
        isLogin::not();
        
        include_once('App/Views/Auth/login.php');
    }


    static function login(){
        isLogin::not();

        Validation::validate(function(){
            Validation::required('correo','El correo es necesario');
            Validation::required('password','La contraseña es necesaria');
        });

        if(!Validation::success()) Request::redirect('/login',['errores'=>Validation::getErrors()]);

        $alumno = Alumno::buscarMailPassword(Request::values('correo','password'));
        if(!$alumno) Request::redirect('/login', ['errores'=>['Credenciales invalidas']]);
        

        if($alumno -> verified == 0) {
            MailService::verificacionMail(Request::value('email'));
            Request::redirect('/email-verify');
        }

        Auth::login($alumno);
        Request::redirect('/');
    }

    // ok
    static function logout(){
        Auth::logout();
        Request::redirect('/login');
    }

    static function resetPasswordView(){
        $correoActual = Auth::isLogin()? Auth::user()->correo:"";
        include_once('App/Views/Auth/cambio-password.php');
    }

    static function resetPassword(){
        MailService::resetPwPin(Request::value('email'));
        include_once('App/Views/Auth/nueva-contra.php');
    }

    static function cambiarPassword(){
        $resetData = ResetPassword::buscarMailConToken(Request::value('token'));
        if(!$resetData) Request::redirect('/reset-password',['mensajes'=>['token invalido']]);
        
        $newPw = Request::value('password');

        Alumno::setPasword([$resetData->email,$newPw]);
        ResetPassword::borrar($resetData->id);

        Request::redirect('/login',['mensajes'=>['tu contraseña se ha restablecido']]);
    }

}