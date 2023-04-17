<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>Mis examenes</h1>
    <table>
        <tr>
            <th></th>
        </tr>
        <?php 
        foreach($examenes as $examen){ ?>
        <tr>    
            <td><?php echo $examen['nombre'] ?></td>
            <td><?php echo $examen['nota'] ?></td>
        </tr>
        <?php } ?>
    </table>
    
    


</body>
</html>