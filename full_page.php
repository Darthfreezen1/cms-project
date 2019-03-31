<?php 
session_start();
$postNum = filter_input(INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT);
$pageType = filter_input(INPUT_GET, 'pagetype', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//use when i make more page types!


if($postNum == false){
    header("Location: index.php");
    exit;
}else{

    require('connect.php');

    $query = "SELECT * FROM items WHERE id = :id";
    $query2 = "SELECT type FROM users WHERE username = :user";
    $comments = "SELECT comment, username, CreatedOn FROM user_changes WHERE pageid = :pid AND type = :ptype ORDER BY CreatedOn DESC";

    $statement = $db->prepare($query);
    $statement2 = $db->prepare($query2);
    $commentsSt = $db->prepare($comments);
    $statement->bindValue(':id', $postNum, PDO::PARAM_INT);
    $commentsSt->bindValue(':pid', $postNum, PDO::PARAM_INT);
    $commentsSt->bindValue(':ptype', $pageType);
    $statement->execute();
    
    $commentsSt->execute();
    if(isset($_SESSION['logged'])){
        $statement2->bindValue(':user', $_SESSION['logged']);
        $statement2->execute();
        $results = $statement2->fetch(PDO::FETCH_ASSOC);
    }
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
                <?php if($row['image_path'] !== "no_image"): ?>
                    <img src="<?=$row['image_path']?>" alt="">
                <?php else: ?>
                    <li>No image supplied!</li>
                <?php endif ?>
            </ul>

            <p>Page created by <?=$row['creator']?></p>

            <?php if(isset($_SESSION['logged'])):?>

                <?php if($results['type'] === 'A' || $row['creator'] === $_SESSION['logged']): ?>
                    <a href="editpage.php?id=<?=$row['id']?>">Edit</a>
                <?php endif ?>

                <?php if($results['type'] === 'A' || $row['creator'] === $_SESSION['logged']): ?>
                    <a href="deletepage.php?id=<?=$row['id']?>">Delete Post</a>
                <?php endif ?>

            <?php endif ?>

        </div>
        <?php if(isset($_SESSION['logged'])): ?>
            <form action="page_change_request.php?type=<?=$row['page_type']?>&pageid=<?=$row['id']?>" method="post">
                <label for="comment">Comment!</label>
                <textarea name="comment" id="comment" cols="30" rows="10">Request</textarea>
                <input type="submit" value="Submit!">
            </form>
        <?php else: ?>
            <p>You must be logged in to comment.</p>
        <?php endif ?>
    <?php endwhile ?>
    
</body>
<footer>

    <?php while($c = $commentsSt->fetch()): ?>
        <p><?=$c['username']?>   at   <?=$c['CreatedOn']?></p>
        <p><?=$c['comment']?></p>
    <?php endwhile ?>

</footer>
</html>