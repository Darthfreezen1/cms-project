<?php
session_start();

if(isset($_SESSION['logged'])){
    $title = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $creator = filter_input(INPUT_POST, 'creator', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if($title && $description ){
        require('connect.php');

        $update = "UPDATE locations SET name = :name, 
                    description = :description, 
                    creator = :creator
                    WHERE id = :id";

        $stmt = $db->prepare($update);
        $stmt->bindValue(':name', $title);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':creator', $creator);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        header("Location: index.php");
        exit();



    }


}

?>