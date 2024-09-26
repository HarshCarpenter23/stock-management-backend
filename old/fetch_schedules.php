<?php
session_start();
require 'apiconfig.php';
try{
    $stmt=$pdo->query("select * from schedule where movie_id='".$_SESSION['movie_id']."'");
    $index=0;
    $response["empty"]=true;
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $response['schedule'][$index]=array(
            "sl"=>$row["sl"],
            "title"=>$row["title"],
            "shoot_date"=>$row['shoot_date'],
            "city"=>$row["city"],
            "call_sheet"=>$row["call_sheet"],
            "shoot_start_time"=>$row['shoot_start_time']
        );
        $index++;
    }
}
catch(\Error $e){
    $response["error"]=$e->getMessage();
}
if($index==0)$response['empty']=true;
else $response['empty']=false;
echo json_encode($response);
?>