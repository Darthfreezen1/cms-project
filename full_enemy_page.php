<?php
session_start();
$postNum = filter_input(INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT);
$pageType = filter_input(INPUT_GET, 'pagetype', FILTER_SANITIZE_SPECIAL_CHARS);

if($postNum == false){
    header("Location: index.php");
    exit();
}else {
    require('connect.php');

    $query = "SELECT * FROM enemies WHERE id = :id";
    $query2 = "SELECT type FROM users WHERE username = :user";
    $comments = "SELECT comment, username, CreatedOn FROM user_changes WHERE pageid = :pid AND type = :ptype ORDER BY CreatedOn DESC";

    $statement = $db->prepare($query);
    $statement2 = $db->prepare($query2);
    $commentsSt = $db->prepare($comments);

    $statement->bindValue(':id', $postNum, PDO::PARAM_INT);
    $commentsSt->bindValue(':pid', $postNum, PDO::PARAM_INT);
    $commentsSt->bindValue(':ptype', $pageType);

    $statement->execute();
    $commentsSt->execute();

    if(isset($_SESSION['logged'])){
        $statement2->bindValue(':user', $_SESSION['logged']);
        $statement2->execute();
        $results = $statement2->fetch(PDO::FETCH_ASSOC);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Enemy Post</title>
    <link rel="stylesheet" href="css/elementstyle.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> 
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
</head>
<body>
<nav class="navbar navbar-expand-sm bg-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="index.php?enemies">Back to index</a>
    </li>
  </ul>

</nav>
<div class="container">
    <?php while($row = $statement->fetch()): ?>
    <h2><i><?=$row['name']?></i></h2>
        <div>
            <ul>
                <li>Item Dropped: <?=$row['item_dropped']?></li>
                <li>Location: <?=$row['location']?></li>
                <li>Elemental Effectiveness: 
                    <ul class="element">
                        <li class="fire">Fire: <?=$row['fire_effectiveness']?></li>
                        <li class="water">Water: <?=$row['water_effectiveness']?></li>
                        <li class="wind">Wind: <?=$row['wind_effectiveness']?></li>
                        <li class="earth">Earth: <?=$row['earth_effectiveness']?></li>
                        <li class="mirage">Mirage: <?=$row['mirage_effectiveness']?></li>
                        <li class="soul">Soul: <?=$row['soul_effectiveness']?></li>
                        <li class="space">Space: <?=$row['space_effectiveness']?></li>
                    </ul>
                </li>
                <li><p><?=$row['description']?></p></li>
                <img src="<?=$row['image_path']?>" alt="">
            </ul>
            
            <i>Page created by <?=$row['creator']?></i>
        </div>
        <?php if(isset($_SESSION['logged'])):?>

                <nav class="navbar navbar-expand-sm bg-light">
                    <ul class="navbar-nav">
                    
                        <li class="nav-item">
                            <?php if($results['type'] === 'A' || $row['creator'] === $_SESSION['logged']): ?>
                                <a class="nav-link" href="editenemy.php?id=<?=$row['id']?>">Edit</a>
                            <?php endif ?>
                        </li>
                        <li class="nav-item">
                            <?php if($results['type'] === 'A' || $row['creator'] === $_SESSION['logged']): ?>
                                <a class="nav-link" href="deletepage.php?enemy&id=<?=$row['id']?>">Delete</a>
                            <?php endif ?>
                        </li>
                        
                    </ul>
                </nav> 

            <?php endif ?>

        </div>
        <?php if(isset($_SESSION['logged'])): ?>
            <form action="page_change_request.php?type=<?=$row['page_type']?>&pageid=<?=$row['id']?>" method="post">
                <div class="form-group">
                    <label for="comment">Comment:</label>
                    <textarea name="comment" class="form-control" rows="5" id="comment"></textarea>
                </div> 
                <img src="captcha.php" /><br>
                <input type="text" name="captcha" placeholder="Enter the captcha">
                <input type="submit" value="Submit">
                <?php if(isset($_GET['error'])): ?>
                    <p><?=$_GET['error']?></p>
                <?php endif ?>
            </form>
        <?php else: ?>
            <p>You must be logged in to comment.</p>
        <?php endif ?>
    <?php endwhile ?>
</div>
</body>
<footer>
<br>
<h3>Comments</h3>
    <div class="media border p-3">
        <div class="media-body">
            <?php while($c = $commentsSt->fetch()): ?>
                <h4><?=$c['username']?> <small><i><?=$c['CreatedOn']?></i></small></h4>
                <p><?=$c['comment']?></p>
            <?php endwhile ?>
        </div>
    </div>
</footer>

</html>