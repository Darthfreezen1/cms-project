<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>
<body>

    <form method="POST" action="check_user.php">
        <label for="username">Username: </label>
        <input type="text" id="username" name="username">

        <label for="password">Password: </label>
        <input type="password" id="password" name="password"/>

        <label for="retype">Retype Password: </label>
        <input type="password" id="retype" name="retype">

        <input type="submit">
    </form>

    <?php if(isset($_GET['error'])): ?>
            <p><?=$_GET['error']?></p>
    <?php endif ?>
    
    <?php if(isset($_GET['success'])): ?>
        <p><?=$_GET['success']?></p>
    <?php endif ?>

    <p><a href="create_user.php">Click here if you need to make an account!</a></p>
    
</body>
</html>