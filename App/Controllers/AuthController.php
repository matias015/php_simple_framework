<?php

use LDAP\Result;

include_once('App/Models/Alumno.php');
include_once('App/Models/ResetPassword.php');

include_once('Fw/Validation.php');

include_once('App/Services/MailService.php');

class AuthController{
    
    static function registroView(){
        isLogin::not();
        Response::view('Auth.registro');
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

        Alumno::setPasword(Request::values('email','password'));

        MailService::verificacionMail(Request::value('email'));

        Request::redirect('/email-verify', ['mensajes'=>['Revisa tu correo!']]);
    }

    static function loginView(){
        isLogin::not();
        
        Response::view('Auth.login');
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
        Response::view('Auth.cambio-password');
    }

    static function resetPassword(){
        MailService::resetPwPin(Request::value('email'));
        Response::view('Auth.nueva-contra');
    }

    static function cambiarPassword(){
        $resetData = ResetPassword::buscarMailConToken(Request::value('token'));
        if(!$resetData) Request::redirect('/reset-password',['mensajes'=>['token invalido']]);
        
        $newPw = Request::value('password');

        Alumno::setPasword(['email'=>$resetData->email,'password'=>$newPw]);
        ResetPassword::borrar($resetData->id);

        Request::redirect('/login',['mensajes'=>['tu contraseña se ha restablecido']]);
    }

}