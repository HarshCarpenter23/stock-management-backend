<?php
session_start();
require 'apiconfig.php';

try{
    $response['success']=true;
    function assignVendor($username,$email,$movie_id,$role_id){ 
    require 'apiconfig.php';
    $stmt=$pdo->query("select * from user where user_id='".$username."' and email='".$email."'");
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if($row==null){
        $response['inn']="some";
        require_once 'create_account.php';
        createAccount($username,$email);
    }
    $response['in']="some";
    $stmt = $pdo->prepare("insert into vendor (movie_id,first_name,last_name,vendor_name,type,pan,gst,aadhar_number,
                            kyc_verified,mobile_number,mobile_number_other,state,country,ifsc,account_number,contract_type,
                            contract_signed,estimated_budget,final_budget,boarding_date,work_rating,
                            planned_days,utilised_days,role_id,email) values (:movie_id,:first_name,:last_name,:vendor_name,:type,:pan,:gst,:aadhar_number,
                            :kyc_verified,:mobile_number,:mobile_number_other,:state,:country,:ifsc,:account_number,:contract_type,
                            :contract_signed,:estimated_budget,:final_budget,:boarding_date,:work_rating,
                            :planned_days,:utilised_days,:role_id,:email)");
    $stmt->execute(
        array(
            ':movie_id'=>$movie_id,
            ':first_name'=>$_POST['vendorFirstName'],
            ':last_name'=>$_POST['vendorLastName'],
            ':vendor_name'=>$username,
            ':type'=>$_POST['vendorType'],
            ':pan'=>$_POST['vendorPan'],
            ':gst'=>$_POST['vendorGst'],
            ':aadhar_number'=>$_POST['aadharNumber'],
            ':kyc_verified'=>$_POST['kycVerified'],
            ':mobile_number'=>$_POST['mobileNumber'],
            ':mobile_number_other'=>$_POST['mobileNumber2'],
            ':state'=>$_POST['state'],
            ':country'=>$_POST['country'],
            ':ifsc'=>$_POST['ifscCode'],
            ':account_number'=>$_POST['accountNumber'],
            ':contract_type'=>$_POST['contractType'],
            ':contract_signed'=>$_POST['contractSigned'],
            ':estimated_budget'=>$_POST['estimatedBudget'],
            ':final_budget'=>$_POST['finalisedBudget'],
            ':boarding_date'=>$_POST['boardingDate'],
            ':work_rating'=>$_POST['workRating'],
            ':planned_days'=>$_POST['plannedDays'],
            ':utilised_days'=>$_POST['daysutilised'],
            ':role_id'=>$role_id,
            ':email'=>$email,
        )
    );
    $stmt=$pdo->query("select * from role where role_id='".$role_id."'");
    $category=$stmt->fetch(PDO::FETCH_ASSOC);
    $category=$category['category_id'];
    $stmt=$pdo->query("select vendor_id from vendor where vendor_name='".$username."' and movie_id='".$movie_id."' and role_id='".$role_id."'");
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    $vendor_id=$row['vendor_id'];
    $stmt = $pdo->prepare("insert into vendor_users (vendor_id,user_id,category_id,role_id,movie) values (:vendor_id,:user_id,:category_id,:role_id,:movie)");
    $stmt->execute(
        array(
            ':vendor_id'=>$vendor_id,
            ':user_id'=>$username,
            ':category_id'=>$category,
            ':role_id'=>$role_id,
            ':movie'=>$movie_id
        )
    );
}

    $stmt=$pdo->query("select * from user where user_id='".$_POST['vendorName']."' or email='".$_POST['vendorEmail']."'");
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if($row!=null){
        if($row["email"]!=$_POST['vendorEmail'] || $row["user_id"]!=$_POST['vendorName']){
            $response["error"]="User username or email didnt match with the records.";
            $response['success']=false;
        }
        else{
            $movie_id=$_SESSION['movie_id'];
        assignVendor($_POST['vendorName'],$_POST['vendorEmail'],$movie_id,$_POST['vendorRole']);
        }
    }
    else{
       
        $movie_id=$_SESSION['movie_id'];
        assignVendor($_POST['vendorName'],$_POST['vendorEmail'],$movie_id,$_POST['vendorRole']);
    }


}
catch(\Error $e){
    $response['error']=$e->getMessage();
    $response['success']=false;
    
}
echo json_encode($response);
