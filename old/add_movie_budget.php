<?php
session_start();
require 'apiconfig.php';
$response['success']=true;
try{
$stmt=$pdo->prepare("insert into movie_budgeting (category_id,role_id,estimated_budget,movie) values(:category_id,:role_id,:estimated_budget,:movie)");
$stmt->execute(
    array(
        ':category_id'=>$_POST['category_id'],
        ':role_id'=>$_POST['role_id'],
        ':estimated_budget'=>$_POST['estimated_budget'],
        ':movie'=>$_SESSION['movie_id']
    )
    );
}
catch(\Error $e){
    $response['success']=false;
    $response["error"]=$e->getMessage();
}
echo json_encode($response);
?>