<?php
session_start();

if(!isset($_SESSION['logged'])){
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New Enemy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 

    
</head>
<body>
    <form action="insert.php?enemy" method="post" enctype="multipart/form-data">

        <label for="name">Name: </label>
        <input type="text" name="name" id="name">

        <label for="description">Description: </label>
        <textarea name="description" id="description" cols="30" rows="10"></textarea>
        <label for="fire">Fire Effect: </label>
        <input type="text" name="fire" id="fire">
        <label for="water">Water Effect: </label>
        <input type="text" name="water" id="water">
        <label for="wind">Wind Effect: </label>
        <input type="text" name="wind" id="wind">
        <label for="earth">Earth Effect: </label>
        <input type="text" name="earth" id="earth">
        <label for="mirage">Mirage Effect: </label>
        <input type="text" name="mirage" id="mirage">
        <label for="soul">Soul Effect: </label>
        <input type="text" name="soul" id="soul">
        <label for="space">Space Effect: </label>
        <input type="text" name="space" id="space">
        <label for="location">Location Found: </label>
        <input type="text" name="location" id="location">
        <label for="author">Creator: </label>
        <input type="text" name="creator" id="creator" readonly value="<?=$_SESSION['logged']?>">

        <br><label>Item: </label>
        <input type="text" name="thing" class='auto'>
        <br><label for="image">Image: </label>
        <input type="file" name="image" id="image">
        <input type="submit" value="Submit!">
    </form>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $(".auto").autocomplete({
                source: "search_items.php",
                minLength: 1
            });
        });
    </script>
</body>
</html>