<?php
session_start();
require 'apiconfig.php';
try {
    $stmt = $pdo->prepare("insert into transaction_log(billType,movie_id,bill_amount,vendor_id,raised_by,
bill_status,shoot_date,raised_datetime,transaction_mode) values(:billType,:movieId,:billAmount,:vendorId,:raisedBy,
:billStatus,:shootDate,:raisedAt,:transactionMode)");
    $stmt->execute(
        array(
            ':billType' => $_POST['expenseType'],
            ':movieId' => $_SESSION['movie_id'],
            ':billAmount' => $_POST['billAmount'],
            ':vendorId' => $_POST['vendorId'],
            ':raisedBy' => $_SESSION['vendor_id'],
            ':billStatus' => 'Raised',
            ':shootDate' => $_POST['shootDate'],
            ':raisedAt' => date("Y-m-d H:i:s"),
            ':transactionMode' => $_POST['transactionMode'],
        )
    );
    $billID = $pdo->lastInsertId();
    $stmt = $pdo->prepare("insert into trans_item_log(bill_id,movie_id,item_id,shoot_date,quantity,remarks,vendor_id,call_time,in_time,out_time,no_of_attendants,no_of_call_sheet) values (:bill_id,:movie_id,:item_id,:shoot_date,:quantity,:remarks,:vendor_id,:call_time,:in_time,:out_time,:no_of_attendants,:no_of_call_sheet)");
    $stmt->execute(
        array(
            ':bill_id' => $billID,
            ':movie_id' => $_SESSION['movie_id'],
            ':item_id' => $_POST['equipmentName'],
            ':shoot_date' => $_POST['shootDate'],
            ':quantity' => $_POST['itemQuantity'],
            ':remarks' => $_POST['itemRemarks'],
            ':vendor_id' => $_POST['vendorId'],
            ':call_time' => $_POST['callTime'],
            ':in_time' => $_POST['inTime'],
            ':out_time' => $_POST['outTime'],
            ':no_of_attendants' => $_POST['noAttendants'],
            ':no_of_call_sheet' => $_POST['noCallSheet']
        )
    );
    $response['success'] = "Bill Raised Successfully.";
} catch (\Error $e) {
    $response['success'] = false;
    $response["error"] = $e->getMessage();
}
echo json_encode($response);
