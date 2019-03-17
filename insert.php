<?php 
/**
 * This scrpit is a mega script that puts all database inserts in. I plan on changing
 * the if block to use get when creating new pages.
 */

    if(isset($_GET['user'])){
        user_insert();
    }elseif (isset($_GET['change'])) {
        
    }elseif(isset($_GET['item'])){
        item_insert();
    }elseif(isset($_GET['location'])){
    
    }elseif(isset($_GET['enemy'])){
    
    }elseif(isset($_GET['spell'])){
    
    }elseif(isset($_GET['quartz'])){
    
    }

function user_insert(){
    if($_POST && !empty($_POST['username']) && !empty($_POST['password'])){
        if(strlen($_POST['username']) > 30){
            header("Location: create_user?error=Username must be 30 characters or less.");
            exit;
        }

        if(strlen($_POST['password']) > 30){
            header("Location: create_user?error=Password must be 30 characters or less.");
            exit;
        }

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $retype   = filter_input(INPUT_POST, 'retype', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $type = 'U';

        if($username == false || $password == false || $retype == false){
            header("Location: create_user.php?error=Please fill out all the inputs.");
            exit;
        } else {
            if($password !== $retype){
                header("Location: create_user.php?error=Passwords do not match.");
                exit;
            }
            require('connect.php');
            $query = "INSERT INTO users (username, password, type) VALUES (:username, :password, :type)";
            $statement = $db->prepare($query);

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $statement->bindValue(":username", $username);
            $statement->bindValue(":password", $hash);
            $statement->bindValue(":type", $type);
        }

        if($statement->execute()){
            header('Location: login.php?success');
            exit;
        }
    }else {
        exit;
    }
}

function item_insert(){

}


?>