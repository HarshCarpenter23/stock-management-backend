<?php
session_start();
require 'apiconfig.php';

try{
    $response['success']=true;
    $stmt = $pdo->prepare("insert into schedule (movie_id,title,shoot_date,day_of_shoot,activity,city,call_sheet,location_1,
                            location_2,location_3,location_4,crew_call_time,shoot_start_time,breakfast_time,lunch_time,
                            dinner_time,
                            scheduled_wrap_time,actual_wrap_time,scenes_to_be_executed,scenes_executed,pending_scenes,
                            shoot_nature,remarks,weather,required_vendor_id) values (:movie_id,:title,:shoot_date,:day_of_shoot,:activity,:city,:call_sheet,:location_1,
                            :location_2,:location_3,:location_4,:crew_call_time,:shoot_start_time,:breakfast_time,:lunch_time,:dinner_time,
                            :scheduled_wrap_time,:actual_wrap_time,:scenes_to_be_executed,:scenes_executed,:pending_scenes,
                            :shoot_nature,:remarks,:weather,:required_vendor_id)");
    $stmt->execute(
        array(
            ':movie_id'=>$_SESSION['movie_id'],
            ':title'=>$_POST['title'],
            ':shoot_date'=>$_POST['shootdate'],
            ':day_of_shoot'=>$_POST['dateofshoot'],
            ':activity'=>$_POST['activity'],
            ':city'=>$_POST['city'],
            ':call_sheet'=>$_POST['callsheet'],
            ':location_1'=>$_POST['location1'],
            ':location_2'=>$_POST['location2'],
            ':location_3'=>$_POST['location3'],
            ':location_4'=>$_POST['location4'],
            ':crew_call_time'=>$_POST['crewcalltime'],
            ':shoot_start_time'=>$_POST['shootstarttime'],
            ':breakfast_time'=>$_POST['breakfasttime'],
            ':lunch_time'=>$_POST['lunchtime'],
            ':dinner_time'=>$_POST['dinnertime'],
            ':scheduled_wrap_time'=>$_POST['schedulewraptime'],
            ':actual_wrap_time'=>$_POST['actualwraptime'],
            ':scenes_to_be_executed'=>$_POST['scenestobeexecuted'],
            ':scenes_executed'=>$_POST['scenesexecuted'],
            ':pending_scenes'=>$_POST['pendingscenes'],
            ':shoot_nature'=>$_POST['shootnature'],
            ':remarks'=>$_POST['remarks'],
            ':weather'=>$_POST['weather'],
            ':required_vendor_id'=>$_POST['requriedvendor'],
        )
    );
}
catch(\Error $e){
    $response['error']=$e->getMessage();
    $response['success']=false;
    
}
echo json_encode($response);
?>