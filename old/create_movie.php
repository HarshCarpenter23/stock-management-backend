<?php
session_start();
require 'apiconfig.php';

try{
    function assignVendor($username,$email,$movie_id,$role_id){
    require 'apiconfig.php';
    $stmt=$pdo->query("select * from user where user_id='".$username."' and email='".$email."'");
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if($row==null){
        require_once 'create_account.php';
        createAccount($username,$email);
    }
    $stmt = $pdo->prepare("insert into vendor (movie_id,vendor_name,role_id,email) values (:movie_id,:vendor_name,:role_id,:email)");
    $stmt->execute(
        array(
            ':movie_id'=>$movie_id,
            ':vendor_name'=>$username,
            ':role_id'=>$role_id,
            ':email'=>$email
        )
    );
    $stmt=$pdo->query("select vendor_id from vendor where vendor_name='".$username."' and movie_id='".$movie_id."'");
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    $vendor_id=$row['vendor_id'];
    $stmt = $pdo->prepare("insert into vendor_users (vendor_id,user_id,role_id,movie) values (:vendor_id,:user_id,:role_id,:movie)");
    $stmt->execute(
        array(
            ':vendor_id'=>$vendor_id,
            ':user_id'=>$username,
            ':role_id'=>$role_id,
            ':movie'=>$movie_id
        )
    );
}
$stmt=$pdo->query("select * from movie where movie_name='".$_POST['moviename']."'");
$row=$stmt->fetch(PDO::FETCH_ASSOC);
if($row!=null){
    $response["error"]="Movie Name already exists.";
}
else{
    $create=true;
    $stmt=$pdo->query("select * from user where user_id='".$_POST['produsername']."' or email='".$_POST['prodemail']."'");
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if($row!=null){
        if($row["email"]!=$_POST['prodemail'] || $row["user_id"]!=$_POST['produsername']){
            $response["error"]="Producer username or email didnt match with the records.";
            $create=false;
        }
    }
    $stmt=$pdo->query("select * from user where user_id='".$_POST['lineprodusername']."' or email='".$_POST['lineprodemail']."'");
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if($row!=null){
        if($row["email"]!=$_POST['lineprodemail'] || $row["user_id"]!=$_POST['lineprodusername']){
            $response["error"]="Line Producer username or email didnt match with the records.";
            $create=false;
        }
    }
    $stmt=$pdo->query("select * from user where user_id='".$_POST['execprodusername']."' or email='".$_POST['execprodemail']."'");
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if($row!=null){
        if($row["email"]!=$_POST['execprodemail'] || $row["user_id"]!=$_POST['execprodusername']){
            $response["error"]="Executive Producer username or email didnt match with the records.";
            $create=false;
        }
    }
    $stmt=$pdo->query("select * from user where user_id='".$_POST['directorusername']."' or email='".$_POST['directoremail']."'");
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if($row!=null){
        if($row["email"]!=$_POST['directoremail'] || $row["user_id"]!=$_POST['directorusername']){
            $response["error"]="Director username or email didnt match with the records.";
            $create=false;
        }
    }
    if($create==true){
        $stmt=$pdo->prepare("insert into movie (movie_name) values (:movie_name) ");
        $stmt->execute(
            array(
                ":movie_name"=>$_POST['moviename'] ,
            )
        );
        $stmt=$pdo->query("select * from movie where movie_name='".$_POST['moviename']."'");
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $movie_id=$row['movie_id'];
        assignVendor($_POST['produsername'],$_POST['prodemail'],$movie_id,"USER_PRODUCER");
        sleep(1);
        assignVendor($_POST['lineprodusername'],$_POST['lineprodemail'],$movie_id,"USER_LINE_PRODUCTION");
        sleep(1);
        assignVendor($_POST['execprodusername'],$_POST['execprodemail'],$movie_id,"USER_EXE_PRODUCTION");
        sleep(1);
        assignVendor($_POST['directorusername'],$_POST['directoremail'],$movie_id,"USER_DIRECTOR");
    }
}
$response['success']=true;

}
catch(\Error $e){
    $response['error']=$e->getMessage();
    
}
echo json_encode($response);
