<?php
if(isset($_SESSION['logged'])){
    session_start();
    session_destroy();
    header("Location: login.php?success=Successfully logged out.");
    exit();
}else {
    header("Location: login.php?error=Cannot view page");
    exit();
}

?>