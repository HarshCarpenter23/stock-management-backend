<?php
session_start();
require 'apiconfig.php';
try{
    $stmt=$pdo->query("select * from transaction_log where movie_id='".$_SESSION['movie_id']."' and bill_status='Raised'");
    $index=0;
    $response["bills"]=null;
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $stmt2=$pdo->query("select * from vendor_users where vendor_id='".$row['vendor_id']."'");
        $row2=$stmt2->fetch(PDO::FETCH_ASSOC);
        $vendor_name=$row2['user_id'];
        $response['bills'][$index]=array(
            "bill_id"=>$row["bill_id"],
            "bill_type"=>$row['billType'],
            "vendor_name"=>$vendor_name,
            "bill_amount"=>$row["bill_amount"]
        );
        $index++;
    }
}
catch(\Error $e){
    $response["error"]=$e->getMessage();
}
$response["empty"]=true;
if($response["bills"]!=null)$response["empty"]=false;
echo json_encode($response);
?>