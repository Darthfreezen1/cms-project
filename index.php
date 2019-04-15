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

if(isset($_GET['searchl'])){
    $name = filter_input(INPUT_GET, 'searchl', FILTER_SANITIZE_SPECIAL_CHARS);
    $query = "SELECT * FROM locations WHERE name = :name";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->execute();
}

if(isset($_GET['searchs'])){
    $name = filter_input(INPUT_GET, 'searchs', FILTER_SANITIZE_SPECIAL_CHARS);
    $query = "SELECT * FROM spells WHERE name = :name";
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
<p>User: <a href="userpage.php"><?=$_SESSION['logged']?></a></p>
<?php if(isset($_SESSION['logged'])): ?>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
    Create a new page
    </button>

    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Add a...</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <ul>
                    <li class="nav-item">
                        <a class="nav-link" href="new_item.php">New Item</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="new_enemy.php">New Enemy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="new_location.php">New Location</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="new_spell.php">New Spell</a>
                    </li>
                </ul>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

            </div>
        </div>
    </div>
    
<?php endif ?>





<ul class="nav">
    <p><b>Categories: </b></p>
        <li class="nav-item">
        <a class="nav-link" href="index.php?items">Items</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="index.php?enemies">Enemies</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="index.php?locations">Locations</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="index.php?spells">Spells</a>
        </li>
    </ul> 
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

    <?php elseif(isset($_GET['spells'])): ?>
        <form action="index.php?searchspells" method="get">
            <label for="searchl">Search Spells: </label>
            <input type="text" name="searchs" class="searchspells">
            <input type="submit" value="Search!">
        </form>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>

    <?php elseif(isset($_GET['locations'])): ?>
        <form action="index.php?searchlocations" method="get">
            <label for="searchl">Search Locations: </label>
            <input type="text" name="searchl" class="searchlocations">
            <input type="submit" value="Search!">
        </form>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
    <?php endif ?>

    <?php if(isset($_GET['items']) || isset($_GET['enemies']) || isset($_GET['search']) || isset($_GET['searche']) || isset($_GET['locations']) || isset($_GET['spells']) || isset($_GET['searchl']) || isset($_GET['searchs'])): ?>
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

                    <?php elseif(isset($_GET['locations']) || isset($_GET['searchl'])): ?>
                        <a href="full_location_page.php?post=<?=$row['id']?>&pagetype=<?=$row['page_type']?>">Full Post</a>
                        <script type="text/javascript">
                            $(function(){
                                $(".searchlocations").autocomplete({
                                    source: "search_locations.php",
                                    minLength: 1
                                });
                            });
                        </script>

                    <?php elseif(isset($_GET['spells']) || isset($_GET['searchs'])): ?>
                        <a href="full_spell_page.php?post=<?=$row['id']?>&pagetype=<?=$row['page_type']?>">Full Post</a>
                        <script type="text/javascript">
                            $(function(){
                                $(".searchspells").autocomplete({
                                    source: "search_spells.php",
                                    minLength: 1
                                });
                            });
                        </script>
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
