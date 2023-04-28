<?php

class DiasHabiles{

static function desdeHoy($fin,$end){
    
            $start = new DateTime(date('Y-m-d'));
            $end = new DateTime($fin);

            //de lo contrario, se excluye la fecha de finalización (¿error?)
            //$end->modify('+1 day');
    
            $interval = $end->diff($start);
    
            // total dias
            $days = $interval->days+1;
    
            // crea un período de fecha iterable (P1D equivale a 1 día)
            $period = new DatePeriod($start, new DateInterval('P1D'), $end);
    
            // almacenado como matriz, por lo que puede agregar más de una fecha feriada
            $holidays = array('2012-09-07');
            echo "inicia en: $days dias <br>";
            foreach($period as $dt) {

                $curr = $dt->format('D');
                echo "hoy es $curr<br>";
                // obtiene si es Sábado o Domingo
                if($curr == 'Sates'|| $curr == 'Sat' || $curr == 'Sun') {
                    echo "hoy es $curr asi que saltemos <br>";
                    $days--;
                }elseif (in_array($dt->format('Y-m-d'), $holidays)) {
                    echo "hoy es $curr y es feriado asi que saltemos <br>";
                    $days--;
                }
            }
            return $days;
    }
}