<?php
include_once('App/Models/DiaNoHabil.php');

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
        Session::delete('Admin');
        Request::redirect('/');
    }

    /**
     * inicia sesion [post]
     */
    static function login(){
        if(Request::value('password') == 123){
            Session::set('Admin',true);
            Request::redirect('/admin');
        }
        else Request::redirect('/admin/login');
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