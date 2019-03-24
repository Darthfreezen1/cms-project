<?php 

$postNum = filter_input(INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT);
$pageType = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//use when i make more page types!


if($postNum == false){
    header("Location: index.php");
    exit;
}else{

    require('connect.php');

    $query = "SELECT * FROM items WHERE id = :id";

    $statement = $db->preparE($query);
    $statement->bindValue(':id', $postNum, PDO::PARAM_INT);

    $statement->execute();

}



?>