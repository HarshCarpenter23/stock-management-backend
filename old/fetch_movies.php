<?php
session_start();
require 'apiconfig.php';
$response['error']=false;
$response['empty']=false;
try{
    
    $index=0;
if(isset($_SESSION['category_id']) && $_SESSION['category_id']=="MASTER"){
    $stmt=$pdo->query("select * from movie");
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $response['movies'][$index]=array(
            "movie_name"=>$row['movie_name'],
            "movie_id"=>$row['movie_id']
        );
        $index++;
    }
}
else{
    $stmt=$pdo->query("select * from vendor_users where user_id='".$_SESSION['logged']."'");
    $index=0;
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $stmt2=$pdo->query("select movie_name from movie where movie_id='".$row['movie']."'");
        $row2=$stmt2->fetch(PDO::FETCH_ASSOC);
        $response['movies'][$index]=array(
            "movie_name"=>$row2['movie_name'],
            "movie_id"=>$row["movie"]
        );
        $index++;
    }
}}
catch(\Error $e){
    $response["error"]=$e->getMessage();
}

if($index==0)$response['empty']=true;
echo json_encode($response);
?>