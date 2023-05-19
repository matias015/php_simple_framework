<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="<?php echo Route::route("/enviar-mail")?>"><button>Enviar mail</button></a>
    <form method="POST" action="<?php echo Route::route("/verificar-mail")?>">
        <?php CSRF::field() ?>
        <input name="token">
        <input type="submit" value="confirmar">
    </form>
    
</body>
</html>