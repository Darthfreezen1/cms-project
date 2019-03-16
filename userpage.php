<?php 

session_start();
if(!$_SESSION['logged']){
    //error, not logged in
}else {
    require('connect.php');
    $query = "SELECT username, type FROM users WHERE username = :username";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $_SESSION['logged']);
    
    $statement->execute();
    
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Page Title</title>
</head>
<body>

    <?php while($row = $statement->fetch()): ?>
        <p><?=$row['username']?></p>
        <p><?=$row['type']?></p>
    <?php endwhile ?>
    
</body>
</html>