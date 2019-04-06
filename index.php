<?php
require('connect.php');
session_start();

$query = "SELECT * FROM items";
$enemies = "SELECT * FROM enemies";

$statement = $db->prepare($query);
$statement2 = $db->prepare($enemies);

$statement->execute();
$statement2->execute();

?>


<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
</head>
<body>
<?php if(!isset($_SESSION['logged'])): ?>
    <a href="login.php">Log in</a>
<?php elseif(isset($_SESSION['logged'])): ?>
    <a href="logout.php">Log out</a>
<?php endif ?>

<?php if(isset($_SESSION['logged'])): ?>
    <p>User: <a href="userpage.php"><?=$_SESSION['logged']?></a></p>
    <p><a href="new_item.php">Create new item listing</a></p>
    <p><a href="new_enemy.php">Create new enemy listing</a></p>

<?php endif ?>

<?php if($statement->rowcount() <= 0): ?>
    <h2>No posts</h2>
<?php else: ?>

    <?php while($row = $statement->fetch()): ?>
        <ul>
            <li><?=$row['name']?></li>
            <?php if($row['icon_path'] !== "no_icon"): ?>
                <img src="<?=$row['icon_path']?>" alt="">
            <?php else: ?>
                <li>No image supplied!</li>
            <?php endif ?>
            <a href="full_item_page.php?post=<?=$row['id']?>&pagetype=<?=$row['page_type']?>">Full Post</a>
        </ul>
    <?php endwhile ?>
    <?php while($row = $statement2->fetch()): ?>
        <ul>
            <li><?=$row['name']?></li>
            <?php if($row['icon_path'] !== "no_icon"): ?>
                <img src="<?=$row['icon_path']?>" alt="">
            <?php else: ?>
                <li>No image supplied!</li>
            <?php endif ?>
            <a href="full_enemy_page.php?post=<?=$row['id']?>&pagetype=<?=$row['page_type']?>">Full Post</a>
        </ul>
    <?php endwhile ?>

<?php endif ?>

</body>
</html>