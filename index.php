<?php
require('connect.php');
session_start();

if(isset($_GET['items'])){
    $query = "SELECT * FROM items";
    $statement = $db->prepare($query);
    $statement->execute();
}
if(isset($_GET['enemies'])){
    $query = "SELECT * FROM enemies";
    $statement = $db->prepare($query);
    $statement->execute();
}

if(isset($_GET['search'])){
    $name = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
    $query = "SELECT * FROM items WHERE name = :name";//cant figure out how to do more than one table...
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->execute();
}

if(isset($_GET['locations'])){
    $query = "SELECT * FROM locations";
    $statement = $db->prepare($query);
    $statement->execute();
}

if(isset($_GET['spells'])){
    $query = "SELECT * FROM spells";
    $statement = $db->prepare($query);
    $statement->execute();
}

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

<a href="index.php?items">Items</a>
<a href="index.php?enemies">Enemies</a>
    <?php if(isset($_GET['items']) || isset($_GET['enemies']) || isset($_GET['search'])): ?>
        <form action="index.php?search" method="get">
            <label for="search">Search Category: </label>
            <input type="text" name="search" class="search">
            <input type="submit" value="Submit!">
        </form>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
        <?php if($statement->rowcount() <= 0): ?>
            <h2>No posts</h2>
            <?php if(isset($_GET['search'])): ?>
                <p>Cannot find <?=$_GET['search']?>. Please try another search.</p>
            <?php endif ?>
        <?php else: ?>
            <?php while($row = $statement->fetch()): ?>
                <ul>
                    <li><?=$row['name']?></li>
                    <?php if($row['icon_path'] !== "no_icon"): ?>
                        <img src="<?=$row['icon_path']?>" alt="">
                    <?php else: ?>
                        <li>No image supplied!</li>
                    <?php endif ?>
                    <?php if(isset($_GET['items']) || isset($_GET['search'])): ?>
                        <a href="full_item_page.php?post=<?=$row['id']?>&pagetype=<?=$row['page_type']?>">Full Post</a>
                        <script type="text/javascript">
                            $(function(){
                                $(".search").autocomplete({
                                    source: "search_items.php",
                                    minLength: 1
                                });
                            });
                        </script>
                    <?php elseif(isset($_GET['enemies'])): ?>
                        <a href="full_enemy_page.php?post=<?=$row['id']?>&pagetype=<?=$row['page_type']?>">Full Post</a>
                        <script type="text/javascript">
                            $(function(){
                                $(".search").autocomplete({
                                    source: "search_enemies.php",
                                    minLength: 1
                                });
                            });
                        </script>
                    <?php elseif(isset($_GET['locations'])): ?>
                        <a href="full_location_page.php?post=<?=$row['id']?>&pagetype=<?=$row['page_type']?>">Full Post</a>
                    <?php elseif(isset($_GET['spells'])): ?>
                        <a href="full_spell_page.php?post=<?=$row['id']?>&pagetype=<?=$row['page_type']?>">Full Post</a>
                    <?php endif ?>



                </ul>
            <?php endwhile ?>
        <?php endif ?>
    <?php else: ?>
        <p>Please select a category</p>
    <?php endif ?>
</body>
</html>
