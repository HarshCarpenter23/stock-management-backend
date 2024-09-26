<?php
session_start();
require 'apiconfig.php';
$response['success']=true;
try{
$stmt=$pdo->query("delete from movie_budgeting where sl='".$_POST['sl']."'");
}
catch(\Error $e){
    $response['success']=false;
    $response["error"]=$e->getMessage();
}
echo json_encode($response);
?>