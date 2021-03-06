<?php
session_start();
if(isset($_SESSION['logged'])){

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $email    = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
    echo($type);
    echo($email);
    echo($username);
    if($username != false && $type != false && $email != false){
        require('connect.php');

        $update = "UPDATE users SET username = :username, email = :email, type = :type WHERE username = :user";
        $statement = $db->prepare($update);

        $statement->bindValue(':username', $username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':type', $type);
        $statement->bindValue(':user', $username);

        $statement->execute();

        header("Location: admin_dashboard.php");
        exit();
    }

}






?>