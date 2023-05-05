<?php 

include_once('Query.php');

function performance($cb){    
    $start_time = microtime(true);
    $start_memory = memory_get_usage();
    
    $cb();
    
    $end_time = microtime(true);
    $end_memory = memory_get_usage();
    
    $execution_time = ($end_time - $start_time) * 1000; // en milisegundos
    $memory_usage = ($end_memory - $start_memory) / 1024 / 1024; // en megabytes
    echo "<br><br>tiempo: $execution_time <br><br>";
    echo "<br><br>memoria: $memory_usage <br><br>";
}

class Cursada{
    static function aprobadasSinRendir($listaAprobados){
        $idCarrera = Carrera::getDefault();
        
        return Query::select('cursada.id_asignatura','asignaturas.nombre')
            -> from('cursada')
            -> join('asignaturas', 'asignaturas.id_asignatura','cursada.id_asignatura')
            -> andWhere('cursada.aprobada', 1)
            -> andWhere('cursada.id_alumno', Auth::id())
            -> andWhere('cursada.ID_ASIGNATURA', 'NOT IN', $listaAprobados)
            -> andWhere('asignaturas.id_carrera', $idCarrera)
            -> exec();
    }


    static function alumno(){        
        $idCarrera = Carrera::getDefault();

        $cursadas = Query::select('cursada.id_asignatura','asignaturas.nombre','ano_cursada', 'aprobada')
            -> from('cursada') 
            -> join('asignaturas', 'cursada.id_asignatura','asignaturas.id_asignatura')
            -> where('cursada.id_alumno', Auth::id())
            -> andWhere('asignaturas.id_carrera', $idCarrera)
            -> exec();
    
        return $cursadas;    
    }
}