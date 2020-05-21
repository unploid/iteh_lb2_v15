<?php 
    require "./dbConnect.php";
    $cursor = $collection -> find();
    $res = [];

    foreach($cursor as $document){
        array_push($res, $document["manufacturer"]);
        
    }
    echo json_encode($res);
?>