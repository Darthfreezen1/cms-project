<?php
$uniqueModal = 0;
session_start();
if(!isset($_SESSION['logged'])){
    header("Location: login.php");
    exit();
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
    }else {
        header("Location: login.php");
        exit();
    }
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
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>

        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

    </style>
</head>
<body style="background: darkred">

    <a href="logout.php">Logout</a>
    <p>Welcome, <?=$results['username']?>!</p>
    <a href="index.php">Back to Index</a>
    <p>Registered Users: </p>
    <?php while($admin_row = $admin_stmnt->fetch()): ?>
        <p><?=$admin_row['username'] ?> is <?=conversion($admin_row['type'])?><button id="myBtn<?=$uniqueModal?>">Open Options...</button></p>

        <div id="myModal<?=$uniqueModal?>" class="modal">
            <div class="modal-content">
                <button id="close<?=$uniqueModal?>" class="close">&times;</button>
                <h2><?=$admin_row['username']?></h2>
                <p><a href="admin_deleteuser.php?username=<?=$admin_row['username']?>">Delete <?=$admin_row['username']?></a></p>
                <p><a href="admin_edituser.php?username=<?=$admin_row['username']?>">Edit </a><?=$admin_row['username']?></p>
                <p><a href="admin_viewuser.php?username=<?=$admin_row['username']?>">View </a><?=$admin_row['username']?>'s Page</p>
            </div>
        </div>

        <script>
            var modal<?=$uniqueModal?> = document.getElementById('myModal<?=$uniqueModal?>');
            var btn<?=$uniqueModal?> = document.getElementById("myBtn<?=$uniqueModal?>");
            var span<?=$uniqueModal?> = document.getElementById("close<?=$uniqueModal?>");
            span<?=$uniqueModal?>.onclick = function(){
                console.log("COCK");
                modal<?=$uniqueModal?>.style.display = "none";
            }
            btn<?=$uniqueModal?>.onclick = function(){
                modal<?=$uniqueModal?>.style.display = "block";
            }
        </script>
        
        <?php $uniqueModal++ ?>

    <?php endwhile ?>
        
    <p>Change Requests and Page Comments: </p>
    <?php while($changes_row = $changes_stmnt->fetch()): ?>
        <?php if($changes_row['comment'] !== "Requests Administrative Access"): ?>
            <p>User <?=$changes_row['username']?> commented <a href="full_page.php?post=<?=$changes_row['pageid']?>&pagetype=<?=$changes_row['type']?>">"<?=$changes_row['comment']?>".</a>  <a href="access_change_granted.php?comment=<?=$changes_row['id']?>"> Delete?</a></p>
        <?php else: ?>
            <p>User <?=$changes_row['username']?> <?=$changes_row['comment']?>. <a href="access_change_granted.php?user=<?=$changes_row['username']?>">Accept</a>   <a href="access_change_granted.php?user=<?=$changes_row['username']?>&deny">Deny</a></p>
        <?php endif ?>
    <?php endwhile ?>

    
    
</body>
</html>