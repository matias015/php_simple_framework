<?php 

class Cursada{
    static function aprobadasSinRendir($listaAprobados){
        return DB::query("SELECT cursada.ID_ASIGNATURA, asignaturas.nombre as nombre
        FROM cursada, alumnos, asignaturas
        WHERE cursada.ID_ALUMNO = alumnos.ID_ALUMNO AND cursada.APROBADA=1 AND alumnos.ID_ALUMNO=?
        AND cursada.ID_ASIGNATURA NOT IN($listaAprobados)
        AND asignaturas.id_asignatura=cursada.id_asignatura
        ",[Auth::user()['ID_ALUMNO']]);
    }

    static function alumno(){
        return DB::query("SELECT asignaturas.nombre as NOMBRE
        FROM cursada,asignaturas
        WHERE cursada.id_alumno=?
        AND cursada.id_asignatura = asignaturas.id_asignatura", [Auth::user()['ID_ALUMNO']]);
    }
}