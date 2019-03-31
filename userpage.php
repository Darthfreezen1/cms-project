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

    $pages_created = "SELECT id, name, page_type FROM items WHERE creator = :creator";
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
    <p><a href="index.php">Back to Index</a></p>

    <?php if($results['type'] === 'A'): ?>
        <a href="admin_dashboard.php">Admin Dashboard</a>
    <?php endif ?>

    <p>Pages You Created: </p>
    <?php while($pages_row = $pages_created_stmnt->fetch()): ?>
        <ul>
            <li><a href="full_page.php?post=<?=$pages_row['id']?>&pagetype=<?=$pages_row['page_type']?>"><?=$pages_row['name']?></a></li>
        </ul>
    <?php endwhile ?>

    <?php if($results['type'] === 'U'): ?>
        <a href="user_change_request.php">Request administrative access.</a>
    <?php endif ?>
    
</body>
</html>