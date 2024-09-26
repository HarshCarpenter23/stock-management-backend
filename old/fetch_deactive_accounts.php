<?php
session_start();
require 'apiconfig.php';
$stmt=$pdo->query("select * from vendor where movie_id='".$_SESSION['movie_id']."' and account_status=2");
$index=0;
$response['success']=true;
try{

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $stmt2=$pdo->query("select * from role where role_id='".$row['role_id']."'");
        $row2=$stmt2->fetch(PDO::FETCH_ASSOC);
        $role=$row2['role_value'];
        $response['accounts'][$index]=array(
            "user_id"=>$row['vendor_name'],
            "email"=>$row['email'],
            "role"=>$role,
            "role_id"=>$row['role_id'],
            "mobile"=>$row['mobile_number']
    
        );
        $index++;
    }
}
catch(\Error $e){
    $response['error']=$e->getMessage();
    $response['success']=false;
}
if($index==0)$response['empty']=true;
else $response['empty']=false;
echo json_encode($response);
?>