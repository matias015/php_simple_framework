<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Elige una nueva contraseña</h1>
    <form action="/change-password" method="post">
        <?php include_once('Fw/Csrf.php') ?>
        <input name="password">
        <input name="token">
        <input type="submit" value="Cambiar contraseña">
    </form>
</body>
</html>