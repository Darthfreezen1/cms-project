<?php 
session_start();
$postNum = filter_input(INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT);
$pageType = filter_input(INPUT_GET, 'pagetype', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


if($postNum == false){
    header("Location: index.php");
    exit;
}else{

    require('connect.php');

    $query = "SELECT * FROM items WHERE id = :id";
    $queryihatethis = "SELECT * FROM items WHERE id = :id";
    $query2 = "SELECT type FROM users WHERE username = :user";
    $comments = "SELECT comment, username, CreatedOn FROM user_changes WHERE pageid = :pid AND type = :ptype ORDER BY CreatedOn DESC";
    $enemies = "SELECT * FROM enemies WHERE item_dropped = :itemname";

    $statement = $db->prepare($query);
    $statement2 = $db->prepare($query2);
    $commentsSt = $db->prepare($comments);
    $enemiesSt = $db->prepare($enemies);
    $ihatethis = $db->prepare($queryihatethis);
    $statement->bindValue(':id', $postNum, PDO::PARAM_INT);
    $commentsSt->bindValue(':pid', $postNum, PDO::PARAM_INT);
    $commentsSt->bindValue(':ptype', $pageType);
    $ihatethis->bindValue(':id', $postNum, PDO::PARAM_INT);
    $ihatethis->execute();
    $statement->execute();
    $commentsSt->execute();
    if(isset($_SESSION['logged'])){
        $statement2->bindValue(':user', $_SESSION['logged']);
        $statement2->execute();
        $results = $statement2->fetch(PDO::FETCH_ASSOC);
    }
    $reallynotlikingthis = $ihatethis->fetch(PDO::FETCH_ASSOC);
    $enemiesSt->bindValue(':itemname', $reallynotlikingthis['name']);
    $enemiesSt->execute();
    
    
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> 
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>Item Post</title>
</head>
<body>
<a href="index.php?items">Back to index</a>
<div class="container_fluid">
    <?php while($row = $statement->fetch()): ?>
        <div>
            <ul>
                <li>Name: <?=$row['name']?></li>
                <li>Type: <?=$row['type']?></li>
                <li>Location: <?=$row['location']?></li>
                <li>Description: <?=html_entity_decode($row['description'])?></li>
                <li>Attributes: <?=$row['attributes']?></li>
                <?php if($row['image_path'] !== "no_image"): ?>
                    <img src="<?=$row['image_path']?>" alt="">
                <?php else: ?>
                    <li>No image supplied!</li>
                <?php endif ?>
            </ul>

            <h3>Enemies that hold this item:</h3>
            <?php if($enemiesSt->rowCount() <= 0): ?>
                <p>No enemies drop this item.</p>
            <?php else: ?>
                <?php while($e = $enemiesSt->fetch()): ?>
                    <p><?=$e['name']?> in <?=$e['location']?></p>
                <?php endwhile ?>
            <?php endif ?>    
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
                <div class="form-group">
                    <label for="comment">Comment:</label>
                    <textarea name="comment" class="form-control" rows="5" id="comment"></textarea>
                </div> 
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
</div>
</body>
<footer>
    <div class="media border p-3">
        <div class="media-body">
            <?php while($c = $commentsSt->fetch()): ?>
                <h4><?=$c['username']?> <small><i><?=$c['CreatedOn']?></i></small></h4>
                <p><?=$c['comment']?></p>
            <?php endwhile ?>
        </div>
    </div>
</footer>
</html>