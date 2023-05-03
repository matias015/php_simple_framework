<?php 

class Cursada{
    static function aprobadasSinRendir($listaAprobados){

        $idCarrera = Carrera::getDefault();

        return DB::query("SELECT cursada.ID_ASIGNATURA, asignaturas.nombre as nombre
        FROM cursada, alumnos, asignaturas
        WHERE cursada.ID_ALUMNO = alumnos.ID_ALUMNO AND cursada.APROBADA=1 AND alumnos.ID_ALUMNO=:id_alumno
        AND cursada.ID_ASIGNATURA NOT IN($listaAprobados)
        AND asignaturas.id_asignatura=cursada.id_asignatura
        AND asignaturas.id_carrera = :id_carrera
        ",['id_alumno'=>Auth::id(), 'id_carrera'=>$idCarrera]);
    }

    

    static function alumno(){
        $idCarrera = Carrera::getDefault();

        return DB::query("SELECT 
            cursada.ID_ASIGNATURA,
            asignaturas.nombre as NOMBRE, 
            ANO_CURSADA, 
            APROBADA
        FROM cursada,asignaturas
        WHERE cursada.id_alumno=:id_alumno
        AND cursada.id_asignatura = asignaturas.id_asignatura
        AND asignaturas.id_carrera = :id_cursada", ['id_alumno'=>Auth::id(), 'id_cursada'=>$idCarrera]);
    }
}