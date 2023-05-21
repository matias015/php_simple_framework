<?php
require_once('Query.php');
require_once('Fw/Auth.php');
require_once('App/Services/FlatArray.php');

class Examen extends Query{

    protected $table='examenes';

    static function aprobados(){
        //examenes aprobados
        return Examen::select('id_asignatura')
            -> where('id_alumno',Auth::id())
            -> andWhere('nota','>=',':4')
            -> exec();
    }

    static function yaAnotado($mesa){
        return Examen::select('*')
            -> where('id_mesa', $mesa)
            -> andWhere('id_alumno', Auth::id())
            -> exec();   
    }

    static function anotarAlumno($mesa){
        Examen::insert()
            -> fields('id', 'id_mesa', 'id_alumno', 'id_asignatura', 'aprobado', 'nota', 'tipo_final', 'llamado', 'libro', 'acta', 'fecha', 'equivalencias')
            -> values(':NULL', $mesa, Auth::id(), ':NULL', ':NULL', '0.00', ':NULL', ':NULL', ':NULL', ':NULL', ':NULL', ':NULL')
            -> exec();
    }

    static function bajar($mesa){
        Examen::delete()->where('id_mesa', $mesa->id)->andWhere('id_alumno',Auth::id())->exec();
    }

    static function alumno(){
        $idCarrera = Carrera::getDefault();

        return Query::select('asignaturas.nombre', 'MAX(examenes.nota) as nota')
            -> from('asignaturas')
            -> join('examenes','examenes.id_asignatura','asignaturas.id ')
            -> where('examenes.id_alumno', Auth::id())
            -> andWhere('asignaturas.id_carrera', $idCarrera)
            -> group('asignaturas.nombre')
            -> exec();
    }

    static function alumnoAnotado(){
        $mesas = Examen::select('id_mesa')
            -> where('id_alumno',Auth::id())
            -> exec();
        return ArrayFlatter::flat($mesas);
    } 

    static function puedeBajarse($mesa){
        $mesas = DB::query("SELECT id_mesa 
            FROM examenes, mesa
            WHERE examenes.id_alumno = ?
            AND mesa.id_mesa = examenes.id_mesa
            AND fecha > NOW() + INTERVAL 1 DAY
        ",[Auth::id()]);

        return ArrayFlatter::flat($mesas);
    }

}