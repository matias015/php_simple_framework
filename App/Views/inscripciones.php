<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>Inscribirme</h1>
    <div style="display:flex; flex-direction:column;">
        <?php foreach($materias as $materia){ ?>
            <div style="display:flex; flex-direction:column;">   
                <h3><?php echo $materia['nombre'] ?></h3>
                <form action="/alumno/inscripciones" style="display:flex; flex-direction:column;" method="post">
                    <?php 
                        include_once('Fw/Csrf.php');
                        $mesas = Mesa::materia($materia['ID_ASIGNATURA']); 
                        if(count($mesas)<1) echo "no hay mesas";
                        else{
                            echo "Llamados <br>";
                            foreach($mesas as $mesa){?>
                                <label for="">llamado <?php echo $mesa['LLAMADO'] ?>
                                    <input type="radio" name="mesa" value="<?php echo $mesa['ID_MESA'] ?>">
                                    fecha:   <?php echo $mesa['FECHA'] ?>
                                </label>
                                <?php } ?>
                    <input type="submit" value="inscribirme">
                    <?php } ?>
                </form>
                
            </div>
        <?php } ?>
    </div>
    


</body>
</html>