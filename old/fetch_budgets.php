<?php
session_start();
require 'apiconfig.php';
try{
    $stmt=$pdo->query("select sl,category_name,role_value,estimated_budget from movie_budgeting left JOIN  role  on movie_budgeting.role_id=role.role_id  LEFT JOIN category on role.category_id=category.category_id where movie_budgeting.movie='".$_SESSION['movie_id']."'");
    $index=0;
    $response["budgets"]=null;
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $response['budgets'][$index]=array(
            "sl"=>$row["sl"],
            "category_name"=>$row["category_name"],
            "role_value"=>$row['role_value'],
            "estimated_budget"=>$row["estimated_budget"]
        );
        $index++;
    }
}
catch(\Error $e){
    $response["error"]=$e->getMessage();
}
$response["empty"]=true;
if($response["budgets"]!=null)$response["empty"]=false;
echo json_encode($response);
?>