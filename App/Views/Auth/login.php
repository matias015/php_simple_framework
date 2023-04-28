<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Login</h1>

    <form method="POST" action="/login">
        email <input name="email">
        contraseña <input name="password">
        <?php include_once('Fw/Csrf.php') ?>
        <input type="submit" value="Ingresar">
    </form>

    <a href="/registro">Ingresar</a><br>
    <a href="/reset-password">Olvide mi contraseña</a>

    <br><br>

    <?php include_once('App/Views/Componentes/mensajes.php') ?>

</body>
</html>