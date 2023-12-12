<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="/edit/<?php echo $user['id'] ?>" method="post">
        <input type="hidden" value="PUT" name="_method">
        <input name="username" value="<?php echo $user->username ?>">
        <input name="email" value="<?php echo $user->email ?>">
        <button>Enviar</button>
    </form>
</body>
</html>
