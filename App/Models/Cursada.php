<?php 

include_once('Query.php');



class Cursada extends Query{

    protected $table = "cursada";

    static function aprobadasSinRendir($listaAprobados){
        $idCarrera = Carrera::getDefault();
        
        return Cursada::select('cursada.id_asignatura','asignaturas.nombre')
            -> join('asignaturas', 'asignaturas.id','cursada.id_asignatura')
            -> andWhere('cursada.aprobada', 1)
            -> andWhere('cursada.id_alumno', Auth::id())
            -> andWhere('cursada.id_asignatura', 'NOT IN', $listaAprobados)
            -> andWhere('asignaturas.id_carrera', $idCarrera)
            -> exec();
    }


    static function alumno(){        
        $idCarrera = Carrera::getDefault();
        
        $cursadas = Cursada::select('cursada.id_asignatura','asignaturas.nombre','anio_cursada', 'aprobada')
            -> join('asignaturas', 'cursada.id_asignatura','asignaturas.id')
            -> where('cursada.id_alumno', Auth::id())
            -> andWhere('asignaturas.id_carrera', $idCarrera)
            -> exec();
    
        return $cursadas;    
    }
}