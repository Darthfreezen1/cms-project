<?php

if(isset($_GET['term'])){
    $return_arr = array();

    try{
        require('connect.php');
        $query = "SELECT name FROM enemies WHERE name LIKE :term";
        $st = $db->prepare($query);
        $st->execute(array('term' => '%'.$_GET['term'].'%'));

        while($row = $st->fetch()){
            $return_arr[] = $row['name'];
        }
    }catch(PDOException $e){
        echo 'ERROR: '.$e->getMessage();
    }

    echo json_encode($return_arr);
}
?>