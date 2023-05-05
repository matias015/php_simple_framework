<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    
    <?php include_once('App/Views/Componentes/header.php') ?>
    
    <h1>Inscribirme</h1>
    
    <?php include_once('Componentes/mensajes.php'); ?>
    
    <div style="display:flex; flex-direction:column;">

    <?php
        foreach($materias as $materia){
            $yaAnotado=false; 
            $sinMesas=false;

            $mesas = Mesa::materia($materia->id_asignatura);
            
            if(count($mesas)<1)$sinMesas=true;
            else {
                foreach($mesas as $mesa){
                    if(in_array($mesa->id_mesa,$yaAnotadas)) $yaAnotado=$mesa;
                }
            }

            $path = $yaAnotado? "desinscripcion":"inscripciones"; 

            echo '<p>' . $materia->nombre . '</p>';
            echo '<form action="/alumno/'. $path .'" method="post" style="display:flex; flex-direction:column;">';
            CSRF::field();
            
            if($yaAnotado){
                include('App/Views/Componentes/desinscripcion-form.php');        
            }
            else if($sinMesas) echo 'No hay mesas';
            else{    
                foreach($mesas as $mesa){
                    include('App/Views/Componentes/inscripcion-form.php');
                }
            }

            echo "<input type='submit' value=". $path . ">";
            echo "</form>";
        }
    ?>  
    
</div>
    


</body>
</html>