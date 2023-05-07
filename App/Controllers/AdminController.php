<?php
include_once('App/Models/DiaNoHabil.php');

class AdminController{

    static function index(){
        isLogin::esAdmin();

        Response::view('Admin.index');
    }

    static function loginView(){
        Response::view('Admin.adminLogin');
    }

    static function logout(){
        isLogin::esAdmin();
        Session::delete('Admin');
        Request::redirect('/');
    }

    static function login(){
        if(Request::value('password') == 123){
            Session::set('Admin',true);
            Request::redirect('/admin');
        }
    }

    static function noHabiles(){
        isLogin::esAdmin();
        Response::view('Admin/nohabiles', ['dias' => DiaNoHabil::all()]);
    }

    static function agregarDia(){
        isLogin::esAdmin();
        if(Request::has('lista')) {
            
        }
        DiaNoHabil::insert()->values(':NULL', Request::value('fecha'))->exec();
        Request::redirect('/admin/dias');
    }

    static function eliminarDia(){
        isLogin::esAdmin();
        $fecha = Request::value('fecha');
        DiaNoHabil::delete()->where('id', $fecha)->exec();
        Request::redirect('/admin/dias');
    }

}