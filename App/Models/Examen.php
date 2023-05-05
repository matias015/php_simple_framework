<?php
require_once('querys.php');
require_once('Fw/Auth.php');
require_once('App/Services/FlatArray.php');

class Examen extends DB{

    static function aprobados(){
        //examenes aprobados
        return DB::query("SELECT examenes.ID_ASIGNATURA
        FROM examenes
        WHERE examenes.ID_ALUMNO=:id_alumno AND examenes.NOTA>4",['id_alumno'=>Auth::id()]);
    }

    static function yaAnotado($mesa){
        return DB::queryFirst("SELECT * FROM examenes WHERE ID_MESA=? AND ID_ALUMNO=?",[$mesa,Auth::id()]);
    }

    static function anotarAlumno($mesa){
        DB::query("INSERT INTO `examenes` 
        (`ID_EXAMENES`, `ID_MESA`, `ID_ALUMNO`, `ID_ASIGNATURA`, `APROBADO`, `NOTA`, `TIPOFINAL`, `LLAMADO`, `LIBRO`, `ACTA`, `FECHA`, `EQUIVALENCIAS`) 
        VALUES (NULL, :id_mesa, :id_alumno, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, NULL)",
        ['id_mesa'=>$mesa, 'id_alumno'=>Auth::id()]);
    }

    static function bajar($mesa){
        DB::query("DELETE FROM `examenes` WHERE ID_MESA = :id_mesa AND ID_ALUMNO=:id_alumno",
        ['id_mesa'=>$mesa, 'id_alumno'=>Auth::id()]);
    }

    static function alumno(){
        $idCarrera = Carrera::getDefault();

        return DB::query("SELECT asignaturas.nombre as nombre, MAX(examenes.nota) as nota
        FROM examenes, asignaturas
        WHERE examenes.ID_ALUMNO=?
        AND examenes.id_asignatura=asignaturas.id_asignatura
        AND asignaturas.id_carrera=?
        GROUP BY asignaturas.nombre
        ",[Auth::id(), $idCarrera]);
    }

    static function alumnoAnotado(){
        $id = Auth::id();
        $mesas = DB::query("SELECT id_mesa 
            FROM examenes
            WHERE examenes.id_alumno=?
        ",[$id]);
        return ArrayFlatter::flat($mesas);
    } 

    static function puedeBajarse($mesa){
        $id = Auth::user()['ID_ALUMNO'];
        $mesas = DB::query("SELECT id_mesa 
            FROM examenes, mesa
            WHERE examenes.id_alumno = ?
            AND mesa.id_mesa = examenes.id_mesa
            AND fecha > NOW() + INTERVAL 1 DAY
        ",[$id]);

        return ArrayFlatter::flat($mesas);
    }

}