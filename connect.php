<?php
    define('DB_DSN','mysql:host=localhost;dbname=wiki;charset=utf8');
    define('DB_USER','');
    define('DB_PASS','');     

    try {
        $db = new PDO(DB_DSN, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage();
        die(); // Force execution to stop on errors.
    }
?>
