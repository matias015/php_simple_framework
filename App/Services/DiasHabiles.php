<?php

class DiasHabiles{

    static function desdeHoyHasta($hasta){
        $end = new DateTime(date('Y-m-d'));
        $start = new DateTime($hasta);

        // crea un período de fecha iterable (P1D equivale a 1 día)
        $period = new DatePeriod($end, new DateInterval('P1D'), $start);
        
        // dias no habiles seleccionados
        $holidays = ArrayFlatter::flat(DiaNoHabil::all('fecha')); 

        $dias = 0;

        foreach($period as $dt) {
            $curr = $dt->format('D');

            if($curr == 'Sates'|| $curr == 'Sat' || $curr == 'Sun') continue;
            elseif (in_array($dt->format('Y-m-d'), $holidays)) continue;

            $dias++;
        }

            return $dias;
    }
}