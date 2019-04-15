<?php 
/**
 * This scrpit is a mega script that puts all database inserts in. I plan on changing
 * the if block to use get when creating new pages.
 */
include 'ImageResize.php';

    if(isset($_GET['user'])){
        user_insert();
    }elseif(isset($_GET['item'])){
        item_insert();
    }elseif(isset($_GET['enemy'])){
        enemy_insert();
    }elseif(isset($_GET['location'])){
        location_insert();
    }elseif(isset($_GET['spell'])){
        spell_insert();
    }else {
        header("Location: index.php");
        exit();
    }

function user_insert(){
    if($_POST && !empty($_POST['username']) && !empty($_POST['password'])){
        if(strlen($_POST['username']) > 30){
            header("Location: create_user?error=Username must be 30 characters or less.");
            exit;
        }

        if(strlen($_POST['password']) > 30){
            header("Location: create_user?error=Password must be 30 characters or less.");
            exit;
        }

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email    = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $retype   = filter_input(INPUT_POST, 'retype', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $type = 'U';

        if($username == false || $password == false || $retype == false){
            header("Location: create_user.php?error=Please fill out all the inputs.");
            exit;
        } else {
            if($password !== $retype){
                header("Location: create_user.php?error=Passwords do not match.");
                exit;
            }
            require('connect.php');

            $colision = "SELECT COUNT(username) AS num FROM users WHERE username = :user";
            $colision_st = $db->prepare($colision);
            $colision_st->bindValue(':user', $username);
            $colision_st->execute();
            $name = $colision_st->fetch(PDO::FETCH_ASSOC);
            if($name['num'] > 0){
                header("Location: create_user.php?error=Username already exists.");
                exit();
            }

            $query = "INSERT INTO users (username, password, type, email) VALUES (:username, :password, :type, :email)";
            $statement = $db->prepare($query);

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $statement->bindValue(":username", $username);
            $statement->bindValue(":password", $hash);
            $statement->bindValue(":type", $type);
            $statement->bindValue(":email", $email);
        }

        if($statement->execute()){
            header('Location: login.php?');
            exit;
        }
    }else {
        exit;
    }
}



function file_upload_path($origFileName, $uploadSubfolder = 'images'.DIRECTORY_SEPARATOR.'items'){
    $current_folder = dirname(__FILE__);
    $path_segments = [$current_folder, $uploadSubfolder, basename($origFileName)];
    return join(DIRECTORY_SEPARATOR, $path_segments);
}

function file_is_an_image($temp_path, $new_path){
    $allowed_mime       =   ['image/gif', 'image/jpeg', 'image/png', 'image/webp'];
    $allowed_extentions =   ['gif', 'jpg', 'jpeg', 'png', 'webp'];

    $actual_ext         =   pathinfo($new_path, PATHINFO_EXTENSION);
    $actual_mime        =   getimagesize($temp_path)['mime'];

    $file_ext_valid     =   in_array($actual_ext, $allowed_extentions);
    $mime_valid         =   in_array($actual_mime, $allowed_mime);

    return $file_ext_valid && $mime_valid;
}

function item_insert(){
    session_start();
    $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error']) === 0;
    
    if(!$image_upload_detected){
        item_insert_no_image();
    }
    $image_path = "";
    if($image_upload_detected){
        $image_filename = $_FILES['image']['name'];
        $temp_path = $_FILES['image']['tmp_name'];
        $newFile_path = file_upload_path($image_filename);
        
        if(file_is_an_image($temp_path, $newFile_path)){
            move_uploaded_file($temp_path, $newFile_path);
        }
    }

    $new_path = $_FILES['image']['name'];
    $actual_file = pathinfo($newFile_path);
    $new_path1 = "images/items/{$_FILES['image']['name']}";
    $icon = new \Gumlet\ImageResize($new_path1);
    $icon->resizeToWidth(100);
    $icon->save("images/items/icon_".$actual_file['filename'].".".$actual_file['extension']);

    $title = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $attribute = filter_input(INPUT_POST, 'attributes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $creator = filter_input(INPUT_POST, 'creator', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $image_path = "images".DIRECTORY_SEPARATOR."items".DIRECTORY_SEPARATOR.$_FILES['image']['name'];
    //ON WINDOWS     $image_path = "images\items\\{$_FILES['image']['name']}";
    $icon_path = "images/items/icon_".$actual_file['filename'].".".$actual_file['extension'];
    //ON WINDOWS     $icon_path = "images\items\\icon_{$_FILES['image']['name']}";

    $page_type = 'I';

    if(!$title || !$location || !$description || !$attribute || !$creator || !$type){
        header('Location: index.php');
        exit();
    }else {
        if(!isset($_SESSION['logged'])){
            header("Location: new_item.php?error=Must be logged in.");
            exit();
        }else {
            require('connect.php');

            $query = "INSERT INTO items (name, location, description, attributes, creator, type, image_path, page_type, icon_path) VALUES (:name, :location, :description, :attributes, :creator, :type, :image_path, :page_type, :icon_path)";

            $statement = $db->prepare($query);

            $statement->bindValue(":name", $title);
            $statement->bindValue(":location", $location);
            $statement->bindValue(":description", $description);
            $statement->bindValue(":attributes", $attribute);
            $statement->bindValue(":creator", $creator);
            $statement->bindValue(":type", $type);
            $statement->bindValue(":image_path", $image_path);
            $statement->bindValue(":page_type", $page_type);
            $statement->bindValue(":icon_path", $icon_path);
            
            if($statement->execute()){
                header("Location: userpage.php");
                exit();
            }else {
                header("Location: userpage.php?error");
                exit();
            }
            
        }
    }

}

function item_insert_no_image(){
    $title = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $attribute = filter_input(INPUT_POST, 'attributes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $creator = filter_input(INPUT_POST, 'creator', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $page_type = 'I';

    if(!$title || !$location || !$description || !$attribute || !$creator || !$type){
        header('Location: index.php');
        exit();
    }else {
        if(!isset($_SESSION['logged'])){
            header("Location: new_item.php?error=Must be logged in.");
            exit();
        }else {
            require('connect.php');

            $query = "INSERT INTO items (name, location, description, attributes, creator, type, image_path, page_type, icon_path) VALUES (:name, :location, :description, :attributes, :creator, :type, :image_path, :page_type, :icon_path)";

            $statement = $db->prepare($query);

            $statement->bindValue(":name", $title);
            $statement->bindValue(":location", $location);
            $statement->bindValue(":description", $description);
            $statement->bindValue(":attributes", $attribute);
            $statement->bindValue(":creator", $creator);
            $statement->bindValue(":type", $type);
            $statement->bindValue(":image_path", "no_image");
            $statement->bindValue(":page_type", $page_type);
            $statement->bindValue(":icon_path", "no_icon");
            
            if($statement->execute()){
                header("Location: userpage.php");
                exit();
            }else {
                header("Location: userpage.php?error");
                exit();
            }
            
        }
    }
}

function enemy_insert(){
    session_start();
    $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error']) === 0;
    
    if(!$image_upload_detected){
        //item_insert_no_image();
    }
    $image_path = "";
    if($image_upload_detected){
        $image_filename = $_FILES['image']['name'];
        $temp_path = $_FILES['image']['tmp_name'];
        $newFile_path = file_upload_path($image_filename);
        
        if(file_is_an_image($temp_path, $newFile_path)){
            move_uploaded_file($temp_path, $newFile_path);
        }
    }

    $new_path = $_FILES['image']['name'];
    $actual_file = pathinfo($newFile_path);
    $new_path1 = "images/items/{$_FILES['image']['name']}";
    $icon = new \Gumlet\ImageResize($new_path1);
    $icon->resizeToWidth(100);
    $icon->save("images/items/icon_".$actual_file['filename'].".".$actual_file['extension']);

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
    
    $image_path = "images".DIRECTORY_SEPARATOR."items".DIRECTORY_SEPARATOR.$_FILES['image']['name'];
    //ON WINDOWS     $image_path = "images\items\\{$_FILES['image']['name']}";
    $icon_path = "images/items/icon_".$actual_file['filename'].".".$actual_file['extension'];
    //ON WINDOWS     $icon_path = "images\items\\icon_{$_FILES['image']['name']}";

    $page_type = 'E';

    if(!$title || !$location || !$description || !$fire || !$water || !$wind || !$earth
    ||!$mirage || !$soul || !$space || !$item || !$creator){
        header('Location: index.php?error');
        exit();
    }else {
        if(!isset($_SESSION['logged'])){
            header("Location: new_enemy.php?error=Must be logged in.");
            exit();
        }else {
            require('connect.php');

            $query = "INSERT INTO enemies 
                        (name, description, image_path, icon_path,
                        fire_effectiveness,water_effectiveness,wind_effectiveness,earth_effectiveness,
                        mirage_effectiveness,soul_effectiveness,space_effectiveness,location,item_dropped,
                        page_type,creator) 
                        VALUES (:name, :description, :image_path, :icon_path,
                        :fire,:water,:wind,:earth,:mirage,:soul,:space,:location,:item,:page_type,:author)";

            $statement = $db->prepare($query);

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
            
            if($statement->execute()){
                header("Location: userpage.php");
                exit();
            }else {
                header("Location: userpage.php?errorenemy");
                exit();
            }
            
        }
    }
}

function location_insert(){
    session_start();
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $creator = filter_input(INPUT_POST, 'creator', FILTER_SANITIZE_SPECIAL_CHARS);
    $page_type = 'L';
    

    if(!$name || !$description || !$page_type){
        header("Location: index.php?error");
        exit();
    }else {
        if(!isset($_SESSION['logged'])){
            header("Location: login.php");
            exit();
        }else {
            require('connect.php');
            $query = "INSERT INTO locations (name, description, page_type, creator)
                        VALUES (:name, :description, :page_type, :creator)";
            $statement = $db->prepare($query);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':page_type', $page_type);
            $statement->bindValue(':creator', $creator);

            if($statement->execute()){
                header("Location: userpage.php");
                exit();
            }else {
                header("Location: userpage.php?errorlocation");
                exit();
            }
        }
    }
}

function spell_insert(){
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $creator = filter_input(INPUT_POST, 'creator', FILTER_SANITIZE_SPECIAL_CHARS);
    $page_type = 'S';
    $fire = filter_input(INPUT_POST, 'fire', FILTER_SANITIZE_SPECIAL_CHARS);
    $water = filter_input(INPUT_POST, 'water', FILTER_SANITIZE_SPECIAL_CHARS);
    $wind = filter_input(INPUT_POST, 'wind', FILTER_SANITIZE_SPECIAL_CHARS);
    $earth = filter_input(INPUT_POST, 'earth', FILTER_SANITIZE_SPECIAL_CHARS);
    $mirage = filter_input(INPUT_POST, 'mirage', FILTER_SANITIZE_SPECIAL_CHARS);
    $soul = filter_input(INPUT_POST, 'soul', FILTER_SANITIZE_SPECIAL_CHARS);
    $space = filter_input(INPUT_POST, 'space', FILTER_SANITIZE_SPECIAL_CHARS);

    if(!$name || !$description || !$creator || !$page_type || !$fire
        || !$water || !$wind || !$earth || !$mirage || !$soul || !$space){
            header("Location: index.php?error");
            exit();
        }else {
            
                require('connect.php');
                $query = "INSERT INTO spells (name, description, fire, water,
                            wind, earth, mirage, soul, space, creator, page_type)
                            VALUES (:name, :description, :fire, :water,
                            :wind, :earth, :mirage, :soul, :space, :creator, :page_type)";
                $statement = $db->prepare($query);
                $statement->bindValue(':name', $name);
                $statement->bindValue(':description', $description);
                $statement->bindValue(':fire', $fire);
                $statement->bindValue(':water', $water);
                $statement->bindValue(':wind', $wind);
                $statement->bindValue(':earth', $earth);
                $statement->bindValue(':mirage', $mirage);
                $statement->bindValue(':soul', $soul);
                $statement->bindValue(':space', $space);
                $statement->bindValue(':creator', $creator);
                $statement->bindValue(':page_type', $page_type);
    
                if($statement->execute()){
                    header("Location: userpage.php");
                    exit();
                }else {
                    header("Location: userpage.php?errorlocation");
                    exit();
                }
            }
        
}




?>