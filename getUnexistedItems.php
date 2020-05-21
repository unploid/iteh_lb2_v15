<?php 
    require "./dbConnect.php";
    $cond = array('amount' => "0");

    $cursor = $collection -> find($cond);
    $res = [];

    foreach($cursor as $document){
        array_push($res, $document["manufacturer"]);
        
    }
    echo json_encode($res);
?>