<?php
session_start();
require 'apiconfig.php';
try {
    $stmt = $pdo->prepare("insert into transaction_log(billType,movie_id,bill_amount,settled_amount,vendor_id,raised_by,
bill_status,shoot_date,raised_datetime,transaction_mode) values(:billType,:movieId,:billAmount,:settledAmount,:vendorId,:raisedBy,
:billStatus,:shootDate,:raisedAt,:transactionMode)");
    $stmt->execute(
        array(
            ':billType' => $_POST['expenseType'],
            ':movieId' => $_SESSION['movie_id'],
            ':billAmount' => $_POST['billAmount'],
            ':settledAmount' => $_POST['billAmount'],
            ':vendorId' => $_POST['vendorId'],
            ':raisedBy' => $_SESSION['vendor_id'],
            ':billStatus' => 'Raised',
            ':shootDate' => $_POST['shootDate'],
            ':raisedAt' => date("Y-m-d H:i:s"),
            ':transactionMode' => $_POST['transactionMode'],
        )
    );

    $billID = $pdo->lastInsertId();
    $stmt = $pdo->prepare("insert into trans_expense (bill_id,equipment_name,quantity,remarks,movie_id,shoot_date,vendor_id) values (:billId,:equipment_name,:quantity,:remarks,:movie_id,:shoot_date,:vendor_id)");
    $stmt->execute(
        array(
            ':billId' => $billID,
            ':equipment_name' => $_POST['itemName'],
            ':quantity' => $_POST['itemQuantity'],
            ':remarks' => $_POST['itemRemarks'],
            ':movie_id' => $_SESSION['movie_id'],
            ':shoot_date' => $_POST['shootDate'],
            ':vendor_id' => $_POST['vendorId']
        )
    );
    $response['success'] = "Bill Raised Successfully.";
} catch (\Error $e) {
    $response['success'] = false;
    $response["error"] = $e->getMessage();
}
echo json_encode($response);
