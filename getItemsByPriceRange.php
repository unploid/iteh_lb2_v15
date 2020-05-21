<?php 
    require "./dbConnect.php";
    
    $startPrice = $_GET["startPrice"];
    $finalPrice = $_GET["finalPrice"];

    $collection = (new MongoDB\Client) -> dbforlab -> items;
    
    $res = [];

    $js = "function() {
        return this.price >= ".$startPrice." && this.price <= ".$finalPrice." ;
    }";
    
    $cursor = $collection -> find(array('$where' => $js));

    foreach($cursor as $document){
        array_push($res, $document["name"]);
    }
    echo json_encode($res);
?>