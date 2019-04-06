<?php
session_start();

if(isset($_SESSION['logged'])){
    
    
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pageid = filter_input(INPUT_GET, 'pageid', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = $_SESSION['logged'];
    $type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    
    if(!$comment || !$pageid || !$username || !$type){

    }else{
        require('connect.php');

        $query = "INSERT INTO user_changes (comment, pageid, username, type) VALUES
                    (:comment, :pageid, :username, :type)";

        $statement = $db->prepare($query);

        $statement->bindValue(":username", $username);
        $statement->bindValue(":pageid", $pageid);
        $statement->bindValue(":comment", $comment);
        $statement->bindValue(":type", $type);

        $statement->execute();

        header('Location: full_item_page.php?post='.$pageid.'&pagetype='.$type);
        exit();

    }
}



?>
