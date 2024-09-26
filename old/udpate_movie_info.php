<?php
session_start();
require 'apiconfig.php';
$response['success']=true;
try{
    $stmt=$pdo->prepare("update movie set movie_name=:movie_name,production_name=:production_name,estimated_budget=:estimated_budget,
    international_travel=:international_travel,countries_to_travel=:countries_to_travel,
    shoot_start_date=:shoot_start_date,shoot_days=:shoot_days,production_mobile_number=:production_mobile_number,production_email_id=:production_email_id
     where movie_id='".$_SESSION['movie_id']."'");
    $stmt->execute(
        array(
            'movie_name'=>$_POST['movie_name'],
            'production_name'=>$_POST['production_name']==''?null:$_POST['production_name'],
            'estimated_budget'=>$_POST['estimated_budget']==''?null:$_POST['estimated_budget'],
            'international_travel'=>$_POST['international_travel']==''?null:$_POST['international_travel'],
            'countries_to_travel'=>$_POST['countries_to_travel']==''?null:$_POST['countries_to_travel'],
            'shoot_start_date'=>$_POST['shoot_start_date']==''?null:$_POST['shoot_start_date'],
            'shoot_days'=>$_POST['shoot_days']==''?null:$_POST['shoot_days'],
            'production_mobile_number'=>$_POST['production_mobile_number']==''?null:$_POST['production_mobile_number'],
            'production_email_id'=>$_POST['production_email_id']==''?null:$_POST['production_email_id'],
        )
        );
}

catch(\Error $e){
    $response['success']=false;
    $response["error"]=$e->getMessage();
}
echo json_encode($response);
