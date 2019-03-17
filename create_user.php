<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
</head>
<body>

    <form method="POST" action="insert.php?user">
        <label for="username">Username: </label>
        <input type="text" id="username" name="username" value="Username">

        <label for="email">Email Address: </label>
        <input type="text" id="email" name="email">

        <label for="password">Password: </label>
        <input type="password" name="password" id="password">

        <label for="retype">Retype Password: </label>
        <input type="password" name="retype" id="retype">
        <input type="submit" value="Submit!">
    </form>

    <?php if(isset($_GET['error'])): ?>
        <p><?=$_GET['error']?></p>
    <?php endif ?>
    
</body>
</html>