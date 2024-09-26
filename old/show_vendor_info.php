<?php
session_start();
require 'apiconfig.php';
$stmt = $pdo->query("select * from vendor where vendor_id='".$_POST['vendorid']."'");
$row=$stmt->fetch(PDO::FETCH_ASSOC);
if($row['type']==0){$temp='Individual';}
if($row['type']==1){$temp='Company';}
if($row['kyc_verified']==0){$temp1='No';}
if($row['kyc_verified']==1){$temp1='Yes';}
echo '
<div class="row">
<div class="col-md-6 row">
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>First Name</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
       : '.$row['first_name'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Last Name</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
       : '.$row['last_name'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Username</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['vendor_name'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Vendor type</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$temp.'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>PAN Number</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
       : '.$row['pan'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>GST Number</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['gst'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Aadhar Number</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['aadhar_number'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>KYC Verified</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$temp1.'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Mobile Number</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['mobile_number'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Other Number</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
    : '.$row['mobile_number_other'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>State</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['state'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Country</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['country'].'
    </div>
    </div>
    <div class="col-md-6 row">
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>IFSC Code</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['ifsc'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Account Number</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['account_number'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Contract Type</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['contract_type'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Contract Signed</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['contract_signed'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Estimated Budget</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['estimated_budget'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Final Budget</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
    : '.$row['final_budget'].'
    </div>
    
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Boarding Date</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
     : '.$row['boarding_date'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Work Rating</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['work_rating'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Planned Days</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['planned_days'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Utilised Days</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['utilised_days'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Last Updated</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['last_updated'].'
    </div></div>
</div>
';
?>
