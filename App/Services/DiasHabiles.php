<?php

class DiasHabiles{

    static function desdeHoyHasta($hasta){

        
        // feha de hoy
        $init = new DateTime(date("Y-m-d"));

        // fecha ingresada
        $mesa = new DateTime($hasta);

        // fecha ingresada en formato yyyy-mm-dd
        $mesaString = $mesa->format('Y-m-d');

        $noHabiles = ArrayFlatter::flat(DiaNoHabil::all('fecha'));

        $dias = 0;
        for($i=0;$i<365;$i++){
            
            // si llegamos a la fecha pero cae dia feriado o finde retorna -1
            if($init->format('Y-m-d') === $mesaString){
                if(($init -> format('D') == "Sat" || $init -> format('D') == "Sun") || in_array($init->format('Y-m-d'), $noHabiles) ){
                    return -1;
                }
                break;
            }

            //si es sabado o feriado no suma
            if(($init -> format('D') == "Sat" || $init -> format('D') == "Sun") || in_array($init->format('Y-m-d'), $noHabiles) ){
                $init -> modify('+1 day');
                continue;
            }
            
            $dias++;
            $init -> modify('+1 day');
        }

        return $dias;
    }
}