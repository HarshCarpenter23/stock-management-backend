<?php
session_start();
require 'apiconfig.php';
$stmt = $pdo->query("select * from transaction_log where bill_id='" . $_POST['billId'] . "'");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row['billType'] == 0) {
    $stmt2 = $pdo->query("select * from trans_expense where bill_id='" . $_POST['billId'] . "'");
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
}
if ($row['billType'] == 1) {
    $stmt2 = $pdo->query("select * from trans_item_log where bill_id='" . $_POST['billId'] . "'");
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
}
if ($row['billType'] == 2) {
    $stmt2 = $pdo->query("select * from trans_generator where bill_id='" . $_POST['billId'] . "'");
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
}
if ($row['billType'] == 3) {
    $stmt2 = $pdo->query("select * from trans_vehicle_rent where bill_id='" . $_POST['billId'] . "'");
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
}
if ($row['billType'] == 4) {
    $stmt2 = $pdo->query("select * from trans_salary where bill_id='" . $_POST['billId'] . "'");
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
}
$stmt3 = $pdo->query("select * from vendor where vendor_id='" . $row['vendor_id'] . "'");
$row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
if ($row['billType'] == 1) {
    $stmt4 = $pdo->query("select * from item_master where itemId='" . $row2['item_id'] . "'");
    $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
}
if ($row['billType'] == 0) {
    $tp = 'Property & Material Hire';
}
if ($row['billType'] == 1) {
    $tp = 'Equipment Hire';
}

if ($row['billType'] == 2) {
    $tp = 'Generator Hire';
}
if ($row['billType'] == 3) {
    $tp = 'Transportation Hire';
}
if ($row['billType'] == 4) {
    $tp = 'Salary';
}


if ($row['billType'] == 0) {
    echo '
    <div class="row">
    <div class="col-md-6 row">
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Bill Id</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
           : ' . $row['bill_id'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Bill Type</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
           : ' . $tp . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Bill Amount</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['bill_amount'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Vendor Name</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row3['vendor_name'] . '
        </div>
        
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Item Name</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
           : ' . $row2['equipment_name'] . '
        </div>
       
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Quantity</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row2['quantity'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Transaction Mode</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['transaction_mode'] . '
        </div>
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Shoot Date</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row2['shoot_date'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>remarks</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row2['remarks'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Raise By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : ' . $row['raised_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Approved By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['approved_by'] . '
        </div>
        
        </div>
        <div class="col-md-6 row">
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Approved By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['approved_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Hold By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['held_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Settled By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['settled_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Rejected By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['rejected_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Bill Status</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['bill_status'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Raised At</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['raised_datetime'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Approved At</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['approved_datetime'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Hold At</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : ' . $row['held_datetime'] . '
        </div>
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Rejected At</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
         : ' . $row['rejected_datetime'] . '
        </div>
        </div>
    </div>
    ';
}

if ($row['billType'] == 1) {
    echo '
    <div class="row">
    <div class="col-md-6 row">
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Bill Id</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
           : ' . $row['bill_id'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Bill Type</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
           : ' . $tp . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Bill Amount</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['bill_amount'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Vendor Name</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row3['vendor_name'] . '
        </div>
        
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Equipment Name</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
           : ' . $row4['item_name'] . '
        </div>
       
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Quantity</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row2['quantity'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Transaction Mode</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['transaction_mode'] . '
        </div>
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Shoot Date</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row2['shoot_date'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>remarks</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row2['remarks'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Raise By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : ' . $row['raised_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Approved By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['approved_by'] . '
        </div>
        
        </div>
        <div class="col-md-6 row">
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Approved By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['approved_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Hold By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['held_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Settled By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['settled_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Rejected By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['rejected_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Bill Status</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['bill_status'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Raised At</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['raised_datetime'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Approved At</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['approved_datetime'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Hold At</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : ' . $row['held_datetime'] . '
        </div>
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Rejected At</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
         : ' . $row['rejected_datetime'] . '
        </div>
        </div>
    </div>
    ';
}

if ($row['billType'] == 2) {
    echo '
    <div class="row">
    <div class="col-md-6 row">
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Bill Id</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
           : ' . $row['bill_id'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Bill Type</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
           : ' . $tp . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Bill Amount</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['bill_amount'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Vendor Name</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row3['vendor_name'] . '
        </div>
        
   
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Transaction Mode</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['transaction_mode'] . '
        </div>
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Shoot Date</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row2['shoot_date'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Start Time</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row2['start_time'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>End Time</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row2['end_time'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Generator Type</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row2['generator_type'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>remarks</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row2['remarks'] . '
        </div>
        
      
        
        
        </div>
        <div class="col-md-6 row">
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Raise By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : ' . $row['raised_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Approved By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['approved_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Hold By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['held_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Settled By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['settled_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Rejected By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['rejected_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Bill Status</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['bill_status'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Raised At</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['raised_datetime'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Approved At</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['approved_datetime'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Hold At</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : ' . $row['held_datetime'] . '
        </div>
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Rejected At</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
         : ' . $row['rejected_datetime'] . '
        </div>
        </div>
    </div>
    ';
}

if ($row['billType'] == 3) {
    echo '
    <div class="row">
    <div class="col-md-6 row">
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Bill Id</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
           : ' . $row['bill_id'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Bill Type</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
           : ' . $tp . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Bill Amount</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['bill_amount'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Vendor Name</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row3['vendor_name'] . '
        </div>
        
   
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Transaction Mode</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['transaction_mode'] . '
        </div>
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Shoot Date</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row2['shoot_date'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Vehicle Number</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row2['vehicle_number'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Used For</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row2['used_by_vendor_id'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>remarks</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row2['remarks'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Raise By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : ' . $row['raised_by'] . '
        </div>
      
        
        
        </div>
        <div class="col-md-6 row">
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Approved By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['approved_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Hold By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['held_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Settled By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['settled_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Rejected By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['rejected_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Bill Status</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['bill_status'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Raised At</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['raised_datetime'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Approved At</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['approved_datetime'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Hold At</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : ' . $row['held_datetime'] . '
        </div>
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Rejected At</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
         : ' . $row['rejected_datetime'] . '
        </div>
        </div>
    </div>
    ';
}


if ($row['billType'] == 4) {
    echo '
    <div class="row">
    <div class="col-md-6 row">
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Bill Id</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
           : ' . $row['bill_id'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Bill Type</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
           : ' . $tp . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Bill Amount</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['bill_amount'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Vendor Name</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row3['vendor_name'] . '
        </div>
        
   
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Transaction Mode</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['transaction_mode'] . '
        </div>
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Shoot Date</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['shoot_date'] . '
        </div>
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>remarks</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row2['remarks'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Raise By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : ' . $row['raised_by'] . '
        </div>
      
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Approved By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['approved_by'] . '
        </div>
        
        
        </div>
        <div class="col-md-6 row">
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Hold By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['held_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Settled By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['settled_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Rejected By</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['rejected_by'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Bill Status</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['bill_status'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Raised At</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['raised_datetime'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Approved At</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            : ' . $row['approved_datetime'] . '
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Hold At</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : ' . $row['held_datetime'] . '
        </div>
        
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
            <b>Rejected At</b>  
        </div>
        <div class="col-sm-6" style="width:100%;padding:10px 0px;">
         : ' . $row['rejected_datetime'] . '
        </div>
        </div>
    </div>
    ';
}
/*
echo '
<div class="row">
<div class="col-md-6 row">
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Bill Id</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
       : '.$row['bill_id'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Bill Type</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
       : '.$tp.'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Bill Amount</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['bill_amount'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Vendor Name</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row3['vendor_name'].'
    </div>
    
    ';
    if($row['billType']==0){
    echo '
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Item Name</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
       : '.$row4['item_name'].'
    </div>';}
   
    if($row['billType']!=2 && $row['billType']!=3 && $row['billType']!=4){
    echo '
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Quantity</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row2['quantity'].'
    </div>';}
    echo '
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Transaction Mode</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['transaction_mode'].'
    </div>
    ';
    if($row['billType']!=4){
    echo'
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Shoot Date</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row2['shoot_date'].'
    </div>';}
    echo'
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>remarks</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row2['remarks'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Raise By</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
    : '.$row['raised_by'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Approved By</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['approved_by'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Hold By</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['hold_by'].'
    </div>
    </div>
    <div class="col-md-6 row">
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Settled By</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['settled_by'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Rejected By</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['rejected_by'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Bill Status</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['bill_status'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Raised At</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['raised_datetime'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Approved At</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row['approved_datetime'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Hold At</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
    : '.$row['hold_datetime'].'
    </div>
    
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Rejected At</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
     : '.$row['rejected_datetime'].'
    </div>
    ';
    if($row['billType']==1){
    echo'
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Call Time</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row2['callTime'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>In Time</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row2['inTime'].'
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        <b>Out Time</b>  
    </div>
    <div class="col-sm-6" style="width:100%;padding:10px 0px;">
        : '.$row2['outTime'].'
    </div>';}
    echo'
    </div>
</div>
';*/
