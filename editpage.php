<?php
    session_start();

    if(isset($_SESSION['logged'])){
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

        if($id){
            require('connect.php');
            $query = "SELECT * FROM items WHERE id = :id";
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
</head>
<body>

    <form action="editpage_update.php?id=<?=$id?>" method="post">
        <label for="name">Title: </label>
        <input type="text" name="name" id="name" value="<?=$results['name']?>">

        <label for="location">Location: </label>
        <input type="text" name="location" id="location" value="<?=$results['location']?>">

        <label for="description">Description: </label>
        <textarea name="description" id="description" cols="30" rows="10"><?=$results['description']?></textarea>

        <label for="attributes">Attributes</label>
        <input type="text" name="attributes" id="attributes" value="<?=$results['attributes']?>">

        <label for="creator">Creator: </label>
        <input type="text" name="creator" id="creator" readonly value=<?=$results['creator']?>>

        <br><label for="type">Type: </label><br>
        <input type="radio" name="type" id="weapon" value="Weapon">Weapon<br>
        <input type="radio" name="type" id="armour" value="Armour">Armour<br>
        <input type="radio" name="type" id="consumable" value="Consumable">Consumable<br>
        <input type="radio" name="type" id="key_item" value="Key Item">Key Item<br>

        <input type="submit" value="Submit!">
    </form>
    
</body>
</html>


