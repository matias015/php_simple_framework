<?php

class Debug{
    static function printStr($str,$desc="value"){
        echo "<br><br>";
        echo " --- $desc: $str --- ";
        echo "<br><br>";
    }

    static function performance($cb){    
        $start_time = microtime(true);
        $start_memory = memory_get_usage();
        
        $cb();
        
        $end_time = microtime(true);
        $end_memory = memory_get_usage();
        
        $execution_time = ($end_time - $start_time) * 1000; // en milisegundos
        $memory_usage = ($end_memory - $start_memory) / 1024 / 1024; // en megabytes
        echo "<br><br>  Time: $execution_time <br><br>";
        echo "<br><br>Memory: $memory_usage <br><br>";
    }
}