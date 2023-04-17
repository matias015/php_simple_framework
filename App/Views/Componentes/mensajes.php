<?php
    if(Session::exists('mensajes')){
        foreach(Session::getAndDelete('mensajes') as $mensaje){
            echo "<p>$mensaje</p>";
        }
    }
    if(Session::exists('errores')){
        foreach(Session::getAndDelete('errores') as $error){
            echo "<p>$error</p>";
        }
    }
        
?>