<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Ingresa el mail</h1>
    <form action="/reset-password" method="post">
        <?php CSRF::field() ?>
        <input name="email" value="<?php echo $correoActual ?>">
        <input type="submit" value="Enviar mail">
    </form>
</body>
</html>