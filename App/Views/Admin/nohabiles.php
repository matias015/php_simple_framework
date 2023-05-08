<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form action="/admin/dias/agregar" method="post">
        <?php CSRF::field() ?>
        <input type="date" name="fecha">
        <input type="date" name="end">
        <input type="submit" value="anotar">
    </form>
    <ul>
        <?php foreach($dias as $dia){ ?>
            <li><?php echo $dia->fecha ?></li>    

            <form action="/admin/dias/eliminar" method="post">
                <?php CSRF::field() ?>
                <input type="hidden" name="fecha" value="<?php echo $dia->id ?>">
                <button type="submit">Eliminar</button>
            </form>
        <?php } ?>
    </ul>
</body>
</html>