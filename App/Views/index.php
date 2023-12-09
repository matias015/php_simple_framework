<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <ul>
        <?php foreach($users as $user): ?>
            <li><?php echo $user->email ?></li>      
            <a href="/edit/<?php echo $user->id ?>">editar</a>      
        <?php endforeach ?>
    </ul>
</body>
</html>