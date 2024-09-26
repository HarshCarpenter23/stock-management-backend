<?php 
session_start();
require 'apiconfig.php';
$response['success']=true;
try{
$name=$_POST['keyword'];
$stmt=$pdo->query("select * from item_master where movie_id='".$_SESSION['movie_id']."' and item_name like '%$name%'");
$index=0;
$row=$stmt->fetch(PDO::FETCH_ASSOC);
if($row!=null){
    $stmt=$pdo->query("select * from item_master where movie_id='".$_SESSION['movie_id']."' and item_name like '%$name%'");
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $response['items'][$index]=array(
            "item_name"=>$row['item_name'],
            "item_type"=>$row['item_type'],
            "item_id"=>$row['itemId']
        );
        $index++;
    }
}
else{
    $response['empty']=true;
}

}
catch(\Error $e){
    $response['success']=false;
    $response["error"]=$e->getMessage();
}
echo json_encode($response);
?>