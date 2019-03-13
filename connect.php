<?php
    define('DB_DSN','mysql:host=localhost;dbname=wiki;charset=utf8');
    define('DB_USER','darthfreezen');
    define('DB_PASS','Garray1234!');     

    // Create a PDO object called $db.
    $db = new PDO(DB_DSN, DB_USER, DB_PASS); 

    try {
        $db = new PDO(DB_DSN, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage();
        die(); // Force execution to stop on errors.
    }
?>