<?php

session_start();

if(isset($_SESSION['logged'])){
    require('connect.php');

    $username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "SELECT username, type, email FROM users WHERE username = :username";
    $statement = $db->prepare($query);

    $statement->bindValue(':username', $username);

    $statement -> execute();

    $results = $statement->fetch(PDO::FETCH_ASSOC);
}


?>




<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

    <form action="admin_updateuser.php" method="POST">
        <label for="username">Username: </label>
        <input type="text" name="username" id="username" value="<?=$results['username']?>">

        <label for="email">Email: </label>
        <input type="text" name="email" id="email" value="<?=$results['email']?>">

        <label for="type">Type: </label>
        <select name="type" id="type">
            <option value="U">User</option>
            <option value="A">Administrator</option>
            <option value="M">Moderator</option>
        </select>

        <input type="submit" value="Update User">

    </form>
    
</body>
</html>