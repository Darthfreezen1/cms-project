<?php
session_start();

if(isset($_SESSION['logged'])){
    $title = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $attribute = filter_input(INPUT_POST, 'attributes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $creator = filter_input(INPUT_POST, 'creator', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if($title && $location && $description && $attribute && $creator && $type){
        require('connect.php');

        $update = "UPDATE items SET name = :name, location = :location,
                    description = :description, attributes = :attributes,
                    creator = :creator, type = :type
                    WHERE id = :id";

        $stmt = $db->prepare($update);
        $stmt->bindValue(':name', $title);
        $stmt->bindValue(':location', $location);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':attributes', $attribute);
        $stmt->bindValue(':creator', $creator);
        $stmt->bindValue(':type', $type);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        header("Location: index.php");
        exit();



    }


}

?>