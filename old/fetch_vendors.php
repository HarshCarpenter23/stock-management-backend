<?php
session_start();
require 'apiconfig.php';
try{
    $stmt=$pdo->query("select * from vendor where movie_id='".$_SESSION['movie_id']."' and account_status=1");
    $index=0;
    $response["empty"]=true;
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $response["empty"]=false;
        $stmt2=$pdo->query("select * from role where role_id='".$row['role_id']."'");
        $row2=$stmt2->fetch(PDO::FETCH_ASSOC);
        $role=$row2['role_value'];
        $response['vendors'][$index]=array(
            "vendor_id"=>$row["vendor_id"],
            "vendor_name"=>$row['vendor_name'],
            "email"=>$row["email"],
            "role"=>$role,
            "mobile"=>$row['mobile_number']
        );
        $index++;
    }
}
catch(\Error $e){
    $response["error"]=$e->getMessage();
}
echo json_encode($response);
?>