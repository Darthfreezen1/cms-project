<?php
require('connect.php');

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

<?php if($statement->rowcount() <= 0): ?>

    <h2>No posts</h2>
<?php else: ?>

    <?php while($row = $statement->fetch()): ?>
        <ul>
            <li><?=$row['name']?></li>
            <img src="<?=$row['image_path']?>" alt="">

        </ul>
    <?php endwhile ?>

<?php endif ?>

</body>
</html>