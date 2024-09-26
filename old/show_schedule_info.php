<?php
session_start();
require 'apiconfig.php';
$response['success']=true;
try{
    $stmt=$pdo->query("select * from schedule where sl='".$_POST['sl']."'");
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    echo '
    <div class="row">
    <div class="col-md-6 row">
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Sl</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
           : ' . $row['sl'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Title</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
           : ' . $row['title'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Shoot Date</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['shoot_date'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Day of Shoot</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['day_of_shoot'] . '
        </div>
        
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>activity</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
           : ' . $row['activity'] . '
        </div>
       
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>City</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['city'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Loction 1</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['location_1'] . '
        </div>
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Location 2</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['location_2'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Location 3</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['location_3'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Location 4</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : ' . $row['location_4'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Crew Call Time</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['crew_call_time'] . '
        </div>
        
        </div>
        <div class="col-md-6 row">
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Shoot Start Time</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['shoot_start_time'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Breakfast Time</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['breakfast_time'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Lunch Time</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['lunch_time'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Dinner Time</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['dinner_time'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Schedule Wrap Time</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['scheduled_wrap_time'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Actual Wrap Time</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['actual_wrap_time'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Scenes to be Executed</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['scenes_to_be_executed'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Scenes Executed</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : ' . $row['scenes_executed'] . '
        </div>
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Pending Scenes</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
         : ' . $row['pending_scenes'] . '
        </div>
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Shoot Nature</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
         : ' . $row['shoot_nature'] . '
        </div>
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Remarks</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
         : ' . $row['remarks'] . '
        </div>
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Weather</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
         : ' . $row['weather'] . '
        </div>
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Required Vendor Ids</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
         : ' . $row['required_vendor_id'] . '
        </div>
        </div>
    </div>
    ';
}
catch(\Error $e){
    $response['success']=false;
    $response["error"]=$e->getMessage();
}
?>