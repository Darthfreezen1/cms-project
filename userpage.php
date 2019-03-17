<?php 

session_start();
if(!$_SESSION['logged']){
    header("Location: login.php?error=You must be logged in to access this page.");
}else {
    require('connect.php');
    $query = "SELECT username, type FROM users WHERE username = :username";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $_SESSION['logged']);
    
    $statement->execute();

    $results = $statement->fetch(PDO::FETCH_ASSOC);

    if($results['type'] === 'A'){
        $admin_query = "SELECT username, type FROM users";
        $changes_query = "SELECT * FROM user_changes";

        $admin_stmnt = $db->prepare($admin_query);
        $changes_stmnt = $db->prepare($changes_query);

        $admin_stmnt->execute();
        $changes_stmnt->execute();
    }
    
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Page Title</title>
</head>
<body>

    <a href="logout.php">Logout</a>
    <p>Welcome, <?=$results['username']?>!</p>

    <?php if($results['type'] === 'A'): ?>

        <p>Registered Users: </p>
        <?php while($admin_row = $admin_stmnt->fetch()): ?>
            <p><?=$admin_row['username'] ?> is of type <?=$admin_row['type']?></p>
        <?php endwhile ?>

        <p>Change Requests: </p>
        <?php while($changes_row = $changes_stmnt->fetch()): ?>
            <a href="access_change_granted.php?user=<?=$changes_row['username']?>">User <?=$changes_row['username'] ?> <?=$changes_row['comment'] ?></a>
        <?php endwhile ?>

    <?php endif ?>

    <?php if($results['type'] === 'U'): ?>
        <a href="user_change_request.php">Request administrative access.</a>
    <?php endif ?>
    
</body>
</html>