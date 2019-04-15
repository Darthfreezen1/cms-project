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
    $enemies_created = "SELECT id, name, page_type FROM enemies WHERE creator = :creator";
    $location_created = "SELECT id, name, page_type FROM locations WHERE creator = :creator";
    $spells_created = "SELECT id, name, page_type FROM spells WHERE creator = :creator";
    $spells = $db->prepare($spells_created);
    $pages_created_stmnt = $db->prepare($pages_created);
    $enemies_created_stmt = $db->prepare($enemies_created);
    $locations = $db->prepare($location_created);
    $locations->bindValue(":creator", $_SESSION['logged']);
    $pages_created_stmnt->bindValue(":creator", $_SESSION['logged']);
    $enemies_created_stmt->bindValue(":creator", $_SESSION['logged']);
    $spells->bindValue(":creator", $_SESSION['logged']);

    $pages_created_stmnt->execute();
    $enemies_created_stmt->execute();
    $locations->execute();
    $spells->execute();
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Home</title>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> 
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>

    <a href="logout.php">Logout</a>
    <p>Welcome, <?=$results['username']?>!</p>
    <p><a href="index.php">Back to Index</a></p>
    <?php if($results['type'] === 'A'): ?>
        <a href="admin_dashboard.php">Admin Dashboard</a>
    <?php endif ?>
    <?php if($results['type'] === 'U'): ?>
        <a href="user_change_request.php">Request administrative access.</a>
    <?php endif ?>

    <div class="container">
        <h3>Items</h2>        
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Title</th>
                <th>Link</th>
            </tr>
            </thead>
            <tbody>
                <?php while($pages_row = $pages_created_stmnt->fetch()): ?>
                    <tr>
                        <td><?=$pages_row['name']?></td>
                        <td><a href="full_item_page.php?post=<?=$pages_row['id']?>&pagetype=<?=$pages_row['page_type']?>">View</a></td>
                    <tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>

    <div class="container">
        <h3>Enemies</h2>        
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Title</th>
                <th>Link</th>
            </tr>
            </thead>
            <tbody>
                <?php while($enemies_row = $enemies_created_stmt->fetch()): ?>
                    <tr>
                        <td><?=$enemies_row['name']?></td>
                        <td><a href="full_enemy_page.php?post=<?=$enemies_row['id']?>&pagetype=<?=$enemies_row['page_type']?>">View</a></td>
                    <tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>

    <div class="container">
        <h3>Locations</h2>        
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Title</th>
                <th>Link</th>
            </tr>
            </thead>
            <tbody>
                <?php while($locations_row = $locations->fetch()): ?>
                    <tr>
                        <td><?=$locations_row['name']?></td>
                        <td><a href="full_location_page.php?post=<?=$locations_row['id']?>&pagetype=<?=$locations_row['page_type']?>">View</a></td>
                    <tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>

    <div class="container">
        <h3>Spells</h2>        
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Title</th>
                <th>Link</th>
            </tr>
            </thead>
            <tbody>
                <?php while($spells_row = $spells->fetch()): ?>
                    <tr>
                        <td><?=$spells_row['name']?></td>
                    <td><a href="full_spell_page.php?post=<?=$spells_row['id']?>&pagetype=<?=$spells_row['page_type']?>">View</a></td>
                    <tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>

    
    
</body>
</html>