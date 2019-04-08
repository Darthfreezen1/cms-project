<?php
session_start();
$postNum = filter_input(INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT);
$pageType = filter_input(INPUT_GET, 'pagetype', FILTER_SANITIZE_SPECIAL_CHARS);

if($postNum == false){
    header("Location: index.php");
    exit();
}else {
    require('connect.php');

    $query = "SELECT * FROM enemies WHERE id = :id";
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Enemy Post</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
</head>
<body>
<a href="index.php?enemies">Back to index</a>
    <?php while($row = $statement->fetch()): ?>
        <div>
            <ul>
                <li>Name: <?=$row['name']?></li>
                <li>Item Dropped: <?=$row['item_dropped']?></li>
                <li>Location: <?=$row['location']?></li>
                <li>Elemental Effectiveness: 
                    <ul>
                        <li>Fire: <?=$row['fire_effectiveness']?></li>
                        <li>Water: <?=$row['water_effectiveness']?></li>
                        <li>Wind: <?=$row['wind_effectiveness']?></li>
                        <li>Earth: <?=$row['earth_effectiveness']?></li>
                        <li>Mirage: <?=$row['mirage_effectiveness']?></li>
                        <li>Soul: <?=$row['soul_effectiveness']?></li>
                        <li>Space: <?=$row['space_effectiveness']?></li>
                    </ul>
                </li>
                <li><p><?=$row['description']?></p></li>
            </ul>
            <img src="<?=$row['image_path']?>" alt="">
            <p>Author: <?=$row['creator']?></p>
        </div>
        <?php if(isset($_SESSION['logged'])): ?>
            <form action="page_change_request.php?type=<?=$row['page_type']?>&pageid=<?=$row['id']?>" method="post">
                <label for="comment">Comment!</label>
                <textarea name="comment" id="comment" cols="30" rows="10">Request</textarea>
                <img src="captcha.php" /><br>
                <input type="text" name="captcha" placeholder="Please enter the four digit number">
                <input type="submit" value="Submit">
                <?php if(isset($_GET['error'])): ?>
                    <p><?=$_GET['error']?></p>
                <?php endif ?>
            </form>
        <?php else: ?>
            <p>You must be logged in to comment.</p>
        <?php endif ?>
        <?php endwhile ?>
</body>
<footer>
    <?php while($c = $commentsSt->fetch()): ?>
        <p><?=$c['username']?>  at  <?=$c['CreatedOn']?></p>
        <p><?=$c['comment']?></p>
    <?php endwhile ?>
</footer>


</html>