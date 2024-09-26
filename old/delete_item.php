<?php
session_start();
require 'apiconfig.php';
$response['success']=true;
try{
$stmt=$pdo->query("delete from item_master where itemId='".$_POST['item_id']."'");
}
catch(\Error $e){
    $response['success']=false;
    $response["error"]=$e->getMessage();
}
echo json_encode($response);
?>