<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Registro</h1>

    <form method="POST" action="/registro">
        email <input name="email">
        contraseña <input name="password">
        <?php CSRF::field() ?>
        <input type="submit" value="Crear cuenta">
    </form>

    <br><br>

    <?php include_once('App/Views/Componentes/mensajes.php') ?>
    
</body>
</html>