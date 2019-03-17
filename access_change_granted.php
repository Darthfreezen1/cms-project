<?php 
session_start();

if(isset($_SESSION['logged'])){
    if(isset($_GET['user'])){
        $username = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if($username){
            require('connect.php');

            $update = "UPDATE users SET type = :type WHERE username = :username";
            $delete = "DELETE FROM user_changes WHERE username = :username";

            $update_stmnt = $db->prepare($update);
            $delete_stmnt = $db->prepare($delete);

            $update_stmnt->bindValue(':type', 'A');
            $update_stmnt->bindValue(':username', $username);
            $delete_stmnt->bindValue(':username', $username);

            if($update_stmnt->execute() && $delete_stmnt->execute()){
                header("Location: userpage.php?success");
                exit();
            }else {
                header("Location: userpage.php?fail");
                exit();
            }
        }else {
            header("Location: userpage.php?fail=User contains invalid characters.");
            exit();
        }
    }
}else {
    header("Location: login.php?error=You must be an authorized administrator to access this page.");
    exit();
}

?>