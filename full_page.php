<?php 
session_start();
$postNum = filter_input(INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT);
//$pageType = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//use when i make more page types!


if($postNum == false){
    header("Location: index.php");
    exit;
}else{

    require('connect.php');

    $query = "SELECT * FROM items WHERE id = :id";

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $postNum, PDO::PARAM_INT);

    $statement->execute();

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post</title>
</head>
<body>
<a href="index.php">Back to index</a>
    <?php while($row = $statement->fetch()): ?>
        <div>
            <ul>
                <li>Name: <?=$row['name']?></li>
                <li>Type: <?=$row['type']?></li>
                <li>Location: <?=$row['location']?></li>
                <li>Description: <?=$row['description']?></li>
                <li>Attributes: <?=$row['attributes']?></li>
                <img src="<?=$row['image_path']?>" alt="">
            </ul>

            <p>Page created by <?=$row['creator']?></p>

            <?php if($row['creator'] === $_SESSION['logged']): ?>
                <p>Edit Post (not yet implemented)</p>
            <?php endif ?>

        </div>
    <?php endwhile ?>
    
</body>
</html>