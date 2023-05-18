<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

use function PHPSTORM_META\type;

    include_once('App/Views/Componentes/header.php'); 
    include_once('App/Services/FormatoTexto.php');
?>
    <h1>Mis cursadas</h1>
    <table>
        <tr>
            <th>Materia</th>
            <th>Año</th>
            <th>Aprobado</th>
            <th>Estado de final</th>
        </tr>
        <?php 
        foreach($cursadas as $cursada){ ?>
        <tr>    
            <td><?php echo FormatoTexto::utf8Minusculas($cursada->nombre) ?></td>
            <td><?php echo $cursada->anio_cursada ?></td>
            <td><?php if($cursada->aprobada==1) echo 'Aprobada';else echo 'sin Aprobar' ?></td>
            <td><?php 
    
                if(in_array($cursada->id_asignatura, $finalesAprobados)){
                    echo "Aprobada";
                }else echo "Sin aprobar/rendir";
            ?></td>
        </tr>
        <?php } ?>
    </table>
    
</body>
</html>