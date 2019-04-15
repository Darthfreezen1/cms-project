<?php
    session_start();

    if(isset($_SESSION['logged'])){
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

        if($id){
            require('connect.php');
            $query = "SELECT * FROM locations WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> 
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=z7yh5eydvfgcrjrgf5a398yhcf36xe41odam33bnlv37bbg0"></script> 
    <script>
    tinymce.init({
        selector: "textarea"
    });
    </script>
</head>
<body>
<div class="container">
        <form class="form-horizontal" method="post" action="editlocation_update.php?id=<?=$id?>">
        <div class="form-group">
            <label class="control-label col-sm-2" for="Name">Name:</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="name" id="name" value="<?=$results['name']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="comment">Description:</label>
            <textarea class="form-control" rows="5" name="description" id="description"><?=html_entity_decode($results['description'])?></textarea>
        </div> 
        <div class="form-group">
            <label class="control-label col-sm-2" for="creator">Creator:</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="creator" id="creator" readonly value="<?=$_SESSION['logged']?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Submit</button>
        </div>
    </div>
</body>
</html>


