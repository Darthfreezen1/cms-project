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

    $pages_created = "SELECT id, name FROM items WHERE creator = :creator";
    $pages_created_stmnt = $db->prepare($pages_created);
    $pages_created_stmnt->bindValue(":creator", $_SESSION['logged']);

    $pages_created_stmnt->execute();
}

function conversion($letter){
    if($letter === 'A'){
        return "an Administrator";
    }elseif($letter === 'U'){
        return "a User";
    }elseif($letter === 'M'){
        return "a Moderator";
    }else {
        return "Undefined";
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
    <a href="index.php">Back to Index</a>

    <p>Pages Created: </p>
    <?php while($pages_row = $pages_created_stmnt->fetch()): ?>
        <ul>
            <li><a href="full_page.php?post=<?=$pages_row['id']?>"><?=$pages_row['name']?></a></li>
        </ul>
    <?php endwhile ?>

    <?php if($results['type'] === 'A'): ?>

        <p>Registered Users: </p>
        <?php while($admin_row = $admin_stmnt->fetch()): ?>
            <p><?=$admin_row['username'] ?> is <?=conversion($admin_row['type'])?></p>
        <?php endwhile ?>
        
        <p>Change Requests: </p>
        <?php while($changes_row = $changes_stmnt->fetch()): ?>
            <?php if($changes_row['comment'] !== "Requests Administrative Access"): ?>
                <p>User <?=$changes_row['username']?> commented "<a href="full_page.php?post=<?=$changes_row['pageid']?>&pagetype=<?=$changes_row['type']?>"><?=$changes_row['comment']?>".</a>  <a href="access_change_granted.php?comment=<?=$changes_row['id']?>"> Delete?</a></p>
            <?php else: ?>
                <p>User <?=$changes_row['username']?> <?=$changes_row['comment']?>. <a href="access_change_granted.php?user=<?=$changes_row['username']?>">Accept</a>   <a href="access_change_granted.php?user=<?=$changes_row['username']?>&deny">Deny</a></p>
            <?php endif ?>
        <?php endwhile ?>

    <?php endif ?>

    <?php if($results['type'] === 'U'): ?>
        <a href="user_change_request.php">Request administrative access.</a>
    <?php endif ?>
    
</body>
</html>