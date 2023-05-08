<?php
include_once('App/Models/DiaNoHabil.php');

class AdminController{

    /**
     * pagina inicio de admin
     */
    static function index(){
        isLogin::esAdmin();
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
        isLogin::esAdmin();
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
        isLogin::esAdmin();
        Response::view('Admin/nohabiles', ['dias' => DiaNoHabil::all()]);
    }

    /**
     * agregar dia no habil [post]
     */
    static function agregarDia(){
        isLogin::esAdmin();

        if(Request::has('end')) {
            $fecha_inicio = new DateTime(Request::value('fecha'));
            $fecha_fin = new DateTime(Request::value('end'));
            
            $intervalo = new DateInterval('P1D');

            // rango de fechas
            $fechas = array();
            $fecha_actual = $fecha_inicio;
            
            while ($fecha_actual <= $fecha_fin) {
                $fechas[] = $fecha_actual->format('Y-m-d');
                $fecha_actual->add($intervalo);
            }

            foreach($fechas as $fecha){
                DiaNoHabil::insert()->values(':NULL', $fecha)->exec();  
            }

        }else DiaNoHabil::insert()->values(':NULL', Request::value('fecha'))->exec();
        Request::redirect('/admin/dias');
    }

    /**
     * borra dia no habil [post]
     */
    static function eliminarDia(){
        isLogin::esAdmin();
        $fecha = Request::value('fecha');
        DiaNoHabil::delete()->where('id', $fecha)->exec();
        Request::redirect('/admin/dias');
    }

}