<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body><?php include_once('App/Views/Componentes/header.php') ?>
    <?php
    include_once('App/Services/FormatoTexto.php');
    
    echo '<p>' . $datos -> nombre . '</p>';
    echo '<p>' . $datos -> apellido . '</p>';
    echo '<p>' . $datos -> dni . '</p>';
    echo '<p>' . $datos -> email . '</p>';
    echo '<p>' . $datos -> telefono1 . '</p>';
    ?>
    <a href="<?php echo Route::route("/reset-password")?>">Restablecer mi contraseña</a>
    

    <h2>Mis carreras</h2>

    <form action="<?php echo Route::route("/setear-carrera")?>">
    
        <select name="carrera" style="height: 5vh;">
            <?php foreach($carreras as $carrera) {?>
                <option <?php if($default && $default == $carrera->id) echo 'selected' ?> value="<?php echo $carrera->id_carrera ?>"><?php echo FormatoTexto::utf8Minusculas($carrera->nombre) ?></option>
            <?php } ?>
        </select>
        
        <input type="submit" value="Seleccionar">
    
    </form>
</body>
</html>