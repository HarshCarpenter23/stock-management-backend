<?php
require 'apiconfig.php';

function createAccount($username,$email){
    require 'apiconfig.php';
    $password = randomPassword(10,1,"lower_case,upper_case,numbers,special_symbols");
    $hash=md5(rand(1,1000));
    $stmt = $pdo->prepare("insert into user (user_id,email,password,hash) values (:username,:email,:password,:hash)");
    $stmt->execute(
        array(
            ':username'=>$username,
            ':password'=>$password[0],
            ':email'=>$email,
            ':hash'=>$hash,
        )
    );
        $to      = $email;
        $subject = 'Signup | Verification';
        $message = '
        Your FlickAnalytics account has been created,
        username - '.$username.'
        password - '.$password[0].'
        ';
        $headers = "From:mailtoflickanalytics@gmail.com" . "\r\n";
        //mail($to, $subject, $message, $headers);
}

function randomPassword($length,$count, $characters) { 
    $symbols = array();
    $passwords = array();
    $used_symbols = '';
    $pass = '';
  
    $symbols["lower_case"] = 'abcdefghijklmnopqrstuvwxyz';
    $symbols["upper_case"] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $symbols["numbers"] = '1234567890';
    $symbols["special_symbols"] = '!?~@#-_+<>[]{}';
 
    $characters = explode(",",$characters);
    foreach ($characters as $key=>$value) {
        $used_symbols .= $symbols[$value];
    }
    $symbols_length = strlen($used_symbols) - 1;
     
    for ($p = 0; $p < $count; $p++) {
        $pass = '';
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $symbols_length); 
            $pass .= $used_symbols[$n]; }
        $passwords[] = $pass;
    }
     
    return $passwords; 
}
?>