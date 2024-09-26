<?php
session_start();
require 'apiconfig.php';
$presentId=$_POST['vendorIdGlobal'];
$stmt=$pdo->query("select * from vendor where vendor_id='".$presentId."'");
$row=$stmt->fetch(PDO::FETCH_ASSOC);
$presentUsername=$row['vendor_name'];
$stmt=$pdo->query("select * from user where user_id='".$presentUsername."'");
$row=$stmt->fetch(PDO::FETCH_ASSOC);
$presentEmail=$row['email'];
$stmt = $pdo->query("select * from user where user_id='" . $_POST['vendorName'] . "'");
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$response['success']=true;
if (!$result == null && $_POST['vendorName']!=$presentUsername) {
    $response['success']=false;
    $response["error"]='<div class="alert alert-danger alert-dismissible fade show" role="alert">Username is alredy taken.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
}
$stmt = $pdo->query("select * from user where email='" . $_POST['vendorEmail'] . "'");
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$result == null && $_POST['vendorEmail']!=$presentEmail) {
    $response['success']=false;
    $response["error"]='<div class="alert alert-danger alert-dismissible fade show" role="alert">an account with the email already exists.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
}
if ($response['success']) {
    $categoryId = $pdo->query("select * from role where role_id='" . $_POST['vendorRole'] . "'");
    $categoryId = $categoryId->fetch(PDO::FETCH_ASSOC);
    $categoryId = $categoryId['category_id'];
    $stmt = $pdo->prepare("update user set user_id=:username,email=:email where user_id='".$presentUsername."'");
    $stmt->execute(
        array(
            ':username' => $_POST['vendorName'],
            ':email' => $_POST['vendorEmail'],
        )
    );
    $stmt = $pdo->prepare("update vendor_users set user_id=:username,category_id=:categoryId,role_id=:roleId where user_id='".$presentUsername."'");
    $stmt->execute(
        array(
            ':username' => $_POST['vendorName'],
            ':categoryId' => $categoryId,
            ':roleId' => $_POST['vendorRole'],
        )
    );
    $pdo->query("delete from vendor where vendor_name='".$presentUsername."'");
    $stmt1=$pdo->prepare("insert into vendor (first_name,last_name,vendor_name,movie_id,type,pan,gst,aadhar_number,kyc_verified,mobile_number,mobile_number_other,state,country,ifsc,account_number,contract_type,contract_signed,estimated_budget,final_budget,boarding_date,work_rating,planned_days,utilised_days,role_id) 
                                      values(:firstName,:lastName,:vendorName,:movieId,:type,:pan,:gst,:aadharNumber,:kycVerified,:mobilenumber,:mobilenumber2,:state,:country,:ifsc,:accountNumber,:contractType,:contractSigned,:estimatedBudget,:finalBudget,:bordingDate,:workRating,:plannedDays,:utilisedDays,:role_id)");
   
    $stmt1->execute(
        array(
            ':firstName'=>$_POST['vendorFirstName'],
            ':lastName'=>$_POST['vendorLastName'],
            ':vendorName'=>$_POST['vendorName'],
            ':movieId'=>$_SESSION['movie_id'],
            ':type'=>$_POST['vendorType'],
            ':pan'=>$_POST['vendorPan'],
            ':gst'=>$_POST['vendorGst'],
            ':aadharNumber'=>$_POST['aadharNumber'],
            ':kycVerified'=>$_POST['kycVerified'],
            ':mobilenumber'=>$_POST['mobileNumber'],
            ':mobilenumber2'=>$_POST['mobileNumber2'],
            ':state'=>$_POST['state'],
            ':country'=>$_POST['country'],
            ':ifsc'=>$_POST['ifscCode'],
            ':accountNumber'=>$_POST['accountNumber'],
            ':contractType'=>$_POST['contractType'],
            ':contractSigned'=>$_POST['contractSigned'],
            ':estimatedBudget'=>$_POST['estimatedBudget'],
            ':finalBudget'=>$_POST['finalisedBudget'],
            ':bordingDate'=>$_POST['boardingDate'],
            ':workRating'=>$_POST['workRating'],
            ':plannedDays'=>$_POST['plannedDays'],
            ':utilisedDays'=>$_POST['daysutilised'],
            ':role_id'=>$_POST['vendorRole']

        )
        );
   
        $response["successmsg"]= '<div class="alert alert-success alert-dismissible fade show" role="alert">Updated Successfully.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
}
echo json_encode($response);
