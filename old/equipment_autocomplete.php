<?php
session_start();
require 'apiconfig.php';
try{
    $stmt=$pdo->query("select * from item_master where movie_id='".$_SESSION['movie_id']."' and item_name like '%".$_POST['key']."%' and item_type='equipment' limit 10");
    $index=0;
    $response["items"]=null;
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $response['items'][$index]=array(
            "item_name"=>$row["item_name"],
            "itemId"=>$row['itemId'],
        );
        $index++;
    }
}
catch(\Error $e){
    $response["error"]=$e->getMessage();
}
$response["empty"]=true;
if($response["items"]!=null)$response["empty"]=false;
echo json_encode($response);
?>