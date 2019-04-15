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
    $query = "SELECT * FROM items WHERE name = :name";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->execute();
}

if(isset($_GET['searche'])){
    $name = filter_input(INPUT_GET, 'searche', FILTER_SANITIZE_SPECIAL_CHARS);
    $query = "SELECT * FROM enemies WHERE name = :name";
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> 
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</head>
<body>
<div class="container">
<?php if(!isset($_SESSION['logged'])): ?>
    <a href="login.php">Log in</a>
<?php elseif(isset($_SESSION['logged'])): ?>
    <a href="logout.php">Log out</a>
<?php endif ?>

<?php if(isset($_SESSION['logged'])): ?>
    <p>User: <a href="userpage.php"><?=$_SESSION['logged']?></a></p>
    <p><a href="new_item.php">Create new item listing</a></p>
    <p><a href="new_enemy.php">Create new enemy listing</a></p>
    <p><a href="new_location.php">Create a new location listing</a></p>
    <a href="new_spell.php"><p>Create a new spell listing</p></a>
<?php endif ?>

<a href="index.php?items">Items</a>
<a href="index.php?enemies">Enemies</a>
<a href="index.php?locations">Locations</a>
<a href="index.php?spells">Spells</a>
    <?php if(isset($_GET['items'])): ?>
        <form action="index.php?search" method="get">
                <label for="search">Search Items: </label>
                <input type="text" name="search" class="search">
                <input type="submit" value="Search!">
            </form>
            <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
            <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>

    <?php elseif(isset($_GET['enemies'])): ?>
        <form action="index.php?searchenemies" method="get">
            <label for="searche">Search Enemies: </label>
            <input type="text" name="searche" class="searchenemies">
            <input type="submit" value="Search!">
        </form>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
    <?php endif ?>

    <?php if(isset($_GET['items']) || isset($_GET['enemies']) || isset($_GET['search']) || isset($_GET['searche']) || isset($_GET['locations']) || isset($_GET['spells'])): ?>
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

                    <?php elseif(isset($_GET['enemies']) || isset($_GET['searche'])): ?>
                        <a href="full_enemy_page.php?post=<?=$row['id']?>&pagetype=<?=$row['page_type']?>">Full Post</a>
                        <script type="text/javascript">
                            $(function(){
                                $(".searchenemies").autocomplete({
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
</div>
</body>
</html>
