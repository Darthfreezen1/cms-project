<?php 
session_start();

//if(isset($_SESSION['loggedin'])){
    if(isset($_GET['user'])){
        user_insert();
    }elseif (isset($_GET['change'])) {
        
    }elseif(isset($_GET['item'])){
    
    }elseif(isset($_GET['location'])){
    
    }elseif(isset($_GET['enemy'])){
    
    }elseif(isset($_GET['spell'])){
    
    }elseif(isset($_GET['quartz'])){
    
    }
//}else {
    //must be logged in.

//}

function user_insert(){
    if($_POST && !empty($_POST['username']) && !empty($_POST['password'])){
        if(strlen($_POST['username']) > 30){
            exit;
        }

        if(strlen($_POST['password']) > 30){
            exit;
        }

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $type = 'U';

        if($username == false || $password == false){
            exit;
        } else {
            require('connect.php');
            $query = "INSERT INTO users (username, password, type) VALUES (:username, :password, :type)";
            $statement = $db->prepare($query);

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $statement->bindValue(":username", $username);
            $statement->bindValue(":password", $hash);
            $statement->bindValue(":type", $type);
        }

        if($statement->execute()){
            header('Location: create_user.php');
            exit;
        }
    }else {
        exit;
    }

}

?>