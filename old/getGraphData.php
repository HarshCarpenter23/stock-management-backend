<?php
session_start();
require 'apiconfig.php';
try {
    $stmt=$pdo->query("select * from transaction_log where movie_id='".$_SESSION['movie_id']."'");
    $index=0;
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $response['transactions'][$index]=$row;
        $index++;
    }
    $stmt=$pdo->query("select * from vendor_users where movie='".$_SESSION['movie_id']."'");
    $index=0;
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $response['users'][$index]=array(
            "vendor_id"=>$row['vendor_id'],
            "user_id"=>$row['user_id'],
            "category_id"=>$row['category_id'],
            "role_id"=>$row['role_id']
        );
        $index++;
    }
    $stmt=$pdo->query("select DATE(settled_datetime) day, sum(settled_amount) as settled_amount, sum(bill_amount) as raised_amount from transaction_log where bill_status='Settled' group by day limit 10");
    $index=0;
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $response['dayWiseData'][$index]=$row;
        $index++;
    }
    $stmt=$pdo->query("select MONTH(settled_datetime) month, sum(settled_amount) as settled_amount, sum(bill_amount) as raised_amount from transaction_log where bill_status='Settled' group by month");
    $index=0;
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $response['monthWiseData'][$index]=$row;
        $index++;
    }
   
    $stmt=$pdo->query(" SELECT category_id,SUM(settled_amount) as settled_amount,sum(bill_amount) as raised_amount FROM vendor_users RIGHT JOIN transaction_log ON transaction_log.vendor_id= vendor_users.vendor_id  group by vendor_users.category_id;");
    $index=0;
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $response['categoryWiseData'][$index]=$row;
        $index++;
    }
} catch (\Error $e) {
    $response['success'] = false;
    $response["error"] = $e->getMessage();
}
echo (json_encode($response));
