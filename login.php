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
        <input type="text" id="password" name="password"/>

        <input type="submit">
    </form>

    <?php if(isset($_GET['error'])): ?>
            <p>An error occurred while trying to login. Are your username and password correct?</p>
            <p><a href="create_user.php">Click here if you need to make an account!</a></p>
    <?php endif ?>
    
</body>
</html>