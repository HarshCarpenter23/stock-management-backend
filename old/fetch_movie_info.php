<?php
session_start();
require 'apiconfig.php';
$response['success']=true;
try{
    $stmt=$pdo->query("select * from movie where movie_id='".$_SESSION['movie_id']."'");
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    $response['movie_name']=$row['movie_name'];
    $response['production_name']=$row['production_name'];
    $response['estimated_budget']=$row['estimated_budget'];
    $response['internation_travel']=$row['international_travel'];
    $response['countries_to_travel']=$row['countries_to_travel'];
    $response['scheduled_plan']=$row['scheduled_plan'];
    $response['shoot_start_date']=$row['shoot_start_date'];
    $response['shoot_days']=$row['shoot_days'];
    $response['production_mobile_number']=$row['production_mobile_number'];
    $response['production_email_id']=$row['production_email_id'];
}

catch(\Error $e){
    $response['success']=false;
    $response["error"]=$e->getMessage();
}
echo json_encode($response);
