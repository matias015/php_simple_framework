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
        <input type="submit" value="Ingresar">
    </form>

    <br><br>

    <?php
        if(Session::exists('mensaje')) echo '<p>'. Session::getAndDelete('mensaje') .'</p>';
    ?>

</body>
</html>