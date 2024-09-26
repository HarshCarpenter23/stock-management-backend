<?php
session_start();
require 'apiconfig.php';
try{
    $name=$_POST['keyword'];
    $stmt=$pdo->query("select * from vendor where movie_id='".$_SESSION['movie_id']."' and vendor_name like '%$name%' and account_status=1");
        $stmt=$pdo->query("select * from vendor where movie_id='".$_SESSION['movie_id']."' and vendor_name like '%$name%' and account_status=1");
        $index=0;
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $stmt2=$pdo->query("select * from role where role_id='".$row['role_id']."'");
            $row2=$stmt2->fetch(PDO::FETCH_ASSOC);
            $role=$row2['role_value'];
            $response['vendors'][$index]=array(
                "vendor_name"=>$row['vendor_name'],
                "email"=>$row["email"],
                "role"=>$role,
                "vendor_id"=>$row['vendor_id']
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