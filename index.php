<?php
require('connect.php');
session_start();
$query = "SELECT * FROM items";

$statement = $db->prepare($query);

$statement->execute();





?>


<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
</head>
<body>
<?php if(isset($_SESSION['logged'])): ?>
    <p>User: <a href="userpage.php"><?=$_SESSION['logged']?></a></p>
    <a href="new_item.php">Create new item listing</a>
<?php endif ?>

<?php if($statement->rowcount() <= 0): ?>
    <h2>No posts</h2>
<?php else: ?>

    <?php while($row = $statement->fetch()): ?>
        <ul>
            <li><?=$row['name']?></li>
            <?php if(!is_null($row['icon_path'])): ?>
                <img src="<?=$row['icon_path']?>" alt="">
            <?php endif ?>
            <a href="full_page.php?post=<?=$row['id']?>">Full Post</a>

        </ul>
    <?php endwhile ?>

<?php endif ?>

</body>
</html>