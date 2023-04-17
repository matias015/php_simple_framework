<?php

class SQL{
    static function posibleInscripcion(){
        return "SELECT asig.ID_ASIGNATURA as id, asig.NOMBRE as nombre, asig.id_carrera as carrera
            FROM asignaturas asig, cursada c, alumnos a, correlatividad
            WHERE c.APROBADA=1 AND c.ID_ALUMNO=a.id_alumno AND a.dni = ? AND asig.ID_ASIGNATURA = c.ID_ASIGNATURA
                AND asig.ID_ASIGNATURA NOT IN(
                    SELECT examenes.ID_ASIGNATURA
                    FROM examenes,alumnos
                    WHERE examenes.ID_ALUMNO=alumnos.id_alumno AND alumnos.dni=?
                    AND examenes.nota>4
                )
                AND ((c.ID_ASIGNATURA NOT IN(SELECT correlatividad.ID_ASIGNATURA from correlatividad))
                OR (c.ID_ASIGNATURA=correlatividad.ID_ASIGNATURA AND correlatividad.ASIGNATURA_CORRELATIVA IN(
                    SELECT examenes.ID_ASIGNATURA
                    FROM examenes, alumnos
                    WHERE examenes.ID_ALUMNO=alumnos.id_alumno AND alumnos.dni=?
                    AND examenes.nota>4
                ))) GROUP BY asig.NOMBRE
        ";         
        
                }
                static function posibleInscripcion2(){
                    return "SELECT asig.ID_ASIGNATURA as id, asig.NOMBRE as nombre, asig.id_carrera as carrera
                        FROM asignaturas asig, cursada c, alumnos a, correlatividad
                        WHERE c.APROBADA=1 AND c.ID_ALUMNO=a.id_alumno AND a.dni = ? AND asig.ID_ASIGNATURA = c.ID_ASIGNATURA
                            AND asig.ID_ASIGNATURA NOT IN(
                                SELECT examenes.ID_ASIGNATURA
                                FROM examenes,alumnos
                                WHERE examenes.ID_ALUMNO=alumnos.id_alumno AND alumnos.dni=?
                                AND examenes.nota>4
                            )
                    ";         
                    
                            }
}