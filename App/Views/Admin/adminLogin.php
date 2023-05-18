<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <form action="<?php echo Route::route("/admin/login")?>" method="post">
        <?php CSRF::field() ?>
        <input type="text" name="username">
        <input type="text" name="password">
        <button type="submit">Ingresar</button>
    </form>
</body>
</html>