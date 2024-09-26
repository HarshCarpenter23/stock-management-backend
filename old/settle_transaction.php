<?php
session_start();
require 'apiconfig.php';
$response['error']=false;
if($_SESSION['role_id']!="USER_EXE_PRODUCTION"){
    $response['error']=true;
    $response['title']="Restricted Access";
    $response['body']="Caution trying to access restricted features";
    $response['status']="warning";
    echo json_encode($response);
}
else{

    $date = date('Y-m-d H:i:s');
    $stmt=$pdo->query("update transaction_log set bill_status='Settled',settled_by='".$_SESSION['vendor_id']."',settled_datetime='".$date."',settled_amount='".$_POST['settled_amount']."' where bill_id='".$_POST['id']."'");
    $stmt=$pdo->query("select * from transaction_log where bill_id='".$_POST['id']."'");
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    $amount=$row['settled_amount'];
    $vendor=$row['vendor_id'];
    $mode=$row['transaction_mode'];
    $stmt2=$pdo->query("select * from vendor where vendor_id='".$row['vendor_id']."'");
    $row2=$stmt2->fetch(PDO::FETCH_ASSOC);
    $actual_amount=$row2['actual_amount_paid']+$amount;
    $stmt2=$pdo->query("update vendor set actual_amount_paid='".$actual_amount."' where vendor_id='".$row['vendor_id']."'");
    if($mode=="cash"){
        $stmt=$pdo->query("select cash_transaction from vendor where vendor_id=".$vendor);
        $cashtrans=$stmt->fetch(PDO::FETCH_ASSOC);
        $cashtrans=$cashtrans["cash_transaction"]+$amount;
        $pdo->query("update vendor set cash_transaction='".$cashtrans."' where vendor_id=".$vendor);
    }
    if($mode=="digital"){
        $stmt=$pdo->query("select bank_transfer_amount from vendor where vendor_id=".$vendor);
        $banktrans=$stmt->fetch(PDO::FETCH_ASSOC);
        $banktrans=$banktrans["bank_transfer_amount"]+$amount;
        $pdo->query("update vendor set bank_transfer_amount='".$banktrans."' where vendor_id=".$vendor);
    }
    echo json_encode($response);
}
?>