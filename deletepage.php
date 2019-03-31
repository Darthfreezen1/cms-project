<?php

session_start();

if(isset($_SESSION['logged'])){
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
    //$type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_SPECIAL_CHARS);

    if($id){
        require('connect.php');

        $del_image = "SELECT image_path, icon_path FROM items WHERE id = :id";
        $del_imagest = $db->prepare($del_image);
        $del_imagest->bindValue(':id', $id);
        $del_imagest->execute();
        $links = $del_imagest->fetch(PDO::FETCH_ASSOC);

        @unlink($links['image_path']);
        @unlink($links['icon_path']);

        $delete = "DELETE FROM items WHERE id = :id";
        $delst = $db->prepare($delete);
        $delst->bindValue(':id', $id, PDO::PARAM_INT);
        $delst->execute();
        header("Location: index.php");
        exit();
    }


}


?>