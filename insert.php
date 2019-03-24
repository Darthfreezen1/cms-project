<?php 
/**
 * This scrpit is a mega script that puts all database inserts in. I plan on changing
 * the if block to use get when creating new pages.
 */

    if(isset($_GET['user'])){
        user_insert();
    }elseif(isset($_GET['item'])){
        item_insert();
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



function file_upload_path($origFileName, $uploadSubfolder = 'images\items'){
    $current_folder = dirname(__FILE__);
    $path_segments = [$current_folder, $uploadSubfolder, basename($origFileName)];
    return join(DIRECTORY_SEPARATOR, $path_segments);
}

function file_is_an_image($temp_path, $new_path){
    $allowed_mime       =   ['image/gif', 'image/jpeg', 'image/png'];
    $allowed_extentions =   ['gif', 'jpg', 'jpeg', 'png'];

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
        header("Location: userpage.php?erroruploading");
        exit();
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

    $title = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $attribute = filter_input(INPUT_POST, 'attributes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $creator = filter_input(INPUT_POST, 'creator', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $image_path = "images\items\\{$_FILES['image']['name']}";
    $page_type = 'I';

    if(!$title || !$location || !$description || !$attribute || !$creator || !$type){
        header("Location: new_item.php?error=Could not process information.".$title.$location.$description.$attribute.$creator.$type.$image_path);
        exit();
    }else {
        if(!isset($_SESSION['logged'])){
            header("Location: new_item.php?error=Must be logged in.");
            exit();
        }else {
            require('connect.php');

            $query = "INSERT INTO items (name, location, description, attributes, creator, type, image_path, page_type) VALUES (:name, :location, :description, :attributes, :creator, :type, :image_path, :page_type)";

            $statement = $db->prepare($query);

            $statement->bindValue(":name", $title);
            $statement->bindValue(":location", $location);
            $statement->bindValue(":description", $description);
            $statement->bindValue(":attributes", $attribute);
            $statement->bindValue(":creator", $creator);
            $statement->bindValue(":type", $type);
            $statement->bindValue(":image_path", $image_path);
            $statement->bindValue(":page_type", $page_type);
            
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




?>