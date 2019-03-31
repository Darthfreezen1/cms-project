<?php
session_start();

if(isset($_SESSION['logged'])){
    $username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if($username){
        require('connect.php');

        $delete = "DELETE FROM users WHERE username = :username";
        $statement = $db->prepare($delete);

        $statement->bindValue(':username', $username);

        $statement->execute();
        header("Location: admin_dashboard.php");
        exit();
    }
}


?>