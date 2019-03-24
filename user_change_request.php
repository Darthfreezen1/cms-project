<?php
session_start();

if(isset($_SESSION['logged'])){
    require('connect.php');

    $query = "INSERT INTO user_changes (username) VALUES (:username)";
    $statement = $db->prepare($query);

    $statement->bindValue(":username", $_SESSION['logged']);

    if($statement->execute()){
        header("Location: userpage.php?success");
        exit();
    }


}else {
    header("Location: login.php?error=You must be an authorized user to view this page.");
    exit();
}

?>