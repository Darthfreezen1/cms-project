<?php

if($_POST && !empty($_POST['username']) && !empty($_POST['password'])){
    
    require('connect.php');

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "SELECT password FROM users WHERE username = :username";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);

    $statement->execute();

    $results = $statement->fetch(PDO::FETCH_ASSOC);

    if(password_verify($password, $results['password'])){
        header("Location: create_user.php?success");
        exit;
    }else {
        header("Location: create_user.php?fail".$results['password']);
        exit;
    }

}else {
    exit;
}
?>