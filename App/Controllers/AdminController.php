<?php
include_once('App/Models/DiaNoHabil.php');

class AdminController{
    static function noHabiles(){
        Response::view('Admin/nohabiles',['dias'=>DiaNoHabil::todos()]);
    }

    static function agregarDia(){
        DiaNoHabil::agregar(Request::value('fecha'));
    }
}