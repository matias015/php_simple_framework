<?php

use LDAP\Result;

include_once('App/Models/DiaNoHabil.php');
include_once('App/Models/Admin.php');

class AdminController{

    /**
     * pagina inicio de admin
     */
    static function index(){
        Response::view('Admin.index');
    }

    /**
     * pagina de ingreso de contraseña
     */
    static function loginView(){
        Response::view('Admin.adminLogin');
    }

    /**
     * cierra sesion como admin
     */
    static function logout(){
        Auth::logout();
        Request::redirect('/');
    }

    /**
     * inicia sesion [post]
     */
    static function login(){

        $admin = Admin::select('id')
            -> where('username',Request::value('username'))
            -> andWhere('password',Request::value('password'))
            -> first();

        Auth::loginGuard('admin',$admin);
        Request::redirect('/admin');
    }

    /**
     * pagina para setear los dias feriados
     */
    static function noHabiles(){
    
        Response::view('Admin/nohabiles', ['dias' => DiaNoHabil::all()]);
    }

    /**
     * agregar dia no habil [post]
     */
    static function agregarDia(){

        if(Request::has('end')) {
            $fechaActual = new DateTime(Request::value('fecha'));
            $fechaFin = new DateTime(Request::value('end'));
            
            $intervalo = new DateInterval('P1D');
            
            while ($fechaActual <= $fechaFin) {
                DiaNoHabil::insert()->values(':NULL', $fechaActual->format('Y-m-d'))->exec();
                $fechaActual->add($intervalo);
            }

        }
        else{
            DiaNoHabil::insert()->values(':NULL', Request::value('fecha'))->exec();
        }
        
        Request::redirect('/admin/dias');
    }

    /**
     * borra dia no habil [post]
     */
    static function eliminarDia(){
        $fecha = Request::value('fecha');
        DiaNoHabil::delete()->where('id', $fecha)->exec();
        Request::redirect('/admin/dias');
    }

}