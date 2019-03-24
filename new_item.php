<?php
session_start();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Page Title</title>
</head>
<body>

    <form action="insert.php?item" method="post" enctype="multipart/form-data">
        
        <label for="name">Title: </label>
        <input type="text" name="name" id="name">

        <label for="location">Location: </label>
        <input type="text" name="location" id="location">

        <label for="description">Description: </label>
        <textarea name="description" id="description" cols="30" rows="10"></textarea>

        <label for="attributes">Attributes: </label>
        <input type="text" name="attributes" id="attributes">

        <label for="creator">Creator: </label>
        <input type="text" name="creator" id="creator" readonly value=<?=$_SESSION['logged']?>>

        <br><label for="type">Type: </label><br>
        <input type="radio" name="type" id="weapon" value="Weapon">Weapon<br>
        <input type="radio" name="type" id="armour" value="Armour">Armour<br>
        <input type="radio" name="type" id="consumable" value="Consumable">Consumable<br>
        <input type="radio" name="type" id="key_item" value="Key Item">Key Item<br>

        <label for="image">Image: </label>
        <input type="file" name="image" id="image">

        <input type="submit" value="Submit!">

    </form>
    
</body>
</html>