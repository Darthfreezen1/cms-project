<?php

session_start();
if(!isset($_SESSION['logged'])){
    header("Location: login.php");
    exit();
}else {
    $username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    
        require('connect.php');
        $query = "SELECT * FROM items WHERE creator = :username";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);

        $statement->execute();
}



?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>
<body>
<a href="admin_dashboard.php">Back to dashboard</a>
    <div>
        <?php if($statement->rowcount() <= 0): ?>
            <h1>User has no posts!</h1>
        <?php else:?>

            <?php while($pages = $statement->fetch()): ?>
                <ul>
                    <li><img src="<?=$pages['icon_path']?>" alt=""></li>
                    <li><a href="full_item_page.php?post=<?=$pages['id']?>"><?=$pages['name']?></a></li>
                    <li><?=$pages['description']?></li>
                    <li><a href="full_item_page.php?post=<?=$pages['id']?>&pagetype=<?=$pages['page_type']?>">View</a></li>
                    <li><a href="#">Edit</a></li>
                    <li><a href="#">Delete</a></li>
                </ul>
            <?php endwhile ?>

        <?php endif ?>
    </div>
    
</body>
</html>