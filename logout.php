<?php
    session_start();
    session_destroy();
    header("Location: login.php?success=Successfully logged out.");
    exit();
?>