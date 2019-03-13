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

        <label for="password">Password: </label>
        <input type="text" name="password" id="password">

        <label for="matchpass">Re-Type Password: </label>
        <input type="text" name="matchpass" id="matchpass">

        <input type="button" value="Submit!">

    </form>

    <?php if($_GET['error']): ?>
        <p>Password does not match!</p>
    <?php endif ?>
    
</body>
</html>