<?php
session_start();

if(isset($_SESSION['logged'])){
    $title = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $fire = filter_input(INPUT_POST, 'fire', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $water = filter_input(INPUT_POST, 'water', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $wind = filter_input(INPUT_POST, 'wind', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $earth = filter_input(INPUT_POST, 'earth', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $mirage = filter_input(INPUT_POST, 'mirage', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $soul = filter_input(INPUT_POST, 'soul', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $space = filter_input(INPUT_POST, 'space', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $creator = filter_input(INPUT_POST, 'creator', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $item = filter_input(INPUT_POST, 'thing', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $image_path = filter_input(INPUT_POST, 'image_path', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $icon_path = filter_input(INPUT_POST, 'icon_path', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $page_type = 'E';
    if($title && $location){
        require('connect.php');

        $update = "UPDATE enemies SET 
        name = :name, description = :description, image_path = :image_path, icon_path = :icon_path,
        fire_effectiveness = :fire,water_effectiveness = :water,wind_effectiveness = :wind,earth_effectiveness = :earth,
        mirage_effectiveness = :mirage,soul_effectiveness = :soul,space_effectiveness = :space,location = :location,item_dropped = :item,
        page_type = :page_type,creator = :creator WHERE id = :id";
        $statement = $db->prepare($update);
        $statement->bindValue(":name", $title);
        $statement->bindValue(":location", $location);
        $statement->bindValue(":description", $description);
        $statement->bindValue(":fire", $fire);
        $statement->bindValue(":water", $water);
        $statement->bindValue(":wind", $wind);
        $statement->bindValue(":earth", $earth);
        $statement->bindValue(":mirage", $mirage);
        $statement->bindValue(":soul", $soul);
        $statement->bindValue(":space", $space);
        $statement->bindValue(":author", $creator);
        $statement->bindValue(":item", $item);
        $statement->bindValue(":image_path", $image_path);
        $statement->bindValue(":page_type", $page_type);
        $statement->bindValue(":icon_path", $icon_path);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);

        $statement->execute();

        header("Location: index.php");
        exit();
    }


}

?>