<?php

class DiasHabiles{

static function desdeHoyHasta($hasta){
    
            $end = new DateTime(date('Y-m-d'));
            $start = new DateTime($hasta);

            //de lo contrario, se excluye la fecha de finalización (¿error?)
            //$end->modify('+1 day');
    
    
            // crea un período de fecha iterable (P1D equivale a 1 día)
            $period = new DatePeriod($end, new DateInterval('P1D'), $start);
            
            // almacenado como matriz, por lo que puede agregar más de una fecha feriada
            $holidays = ArrayFlatter::flat(DiaNoHabil::todos()); //array('2023-05-03');
            //
            $dias = 0;
            foreach($period as $dt) {
                echo "<br>";
                print_r($dt->format('Y-m-d'));
                echo "<br>";
                print_r($holidays);
                $curr = $dt->format('D');
                // obtiene si es Sábado o Domingo
                if($curr == 'Sates'|| $curr == 'Sat' || $curr == 'Sun') {
                    echo "hoy es $curr asi que saltemos <br>";
                    continue;
                }elseif (in_array($dt->format('Y-m-d'), $holidays)) {
                    echo "hoy es $curr y es feriado asi que saltemos <br>";
                    continue;
                }
                $dias++;
                echo "hoy es $curr y no feriado asi que sumamos <br>";
            }
            return $dias;
    }
}