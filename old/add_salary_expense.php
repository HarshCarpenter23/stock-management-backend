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
    $stmt = $pdo->prepare("insert into trans_salary values (:billId,:movieId,:remarks,:vendorId,:shootDate,:conveyanceCharges,:agentCommission)");
    $stmt->execute(
        array(
            ':billId' => $billID,
            ':movieId' => $_SESSION['movie_id'],
            ':remarks' => $_POST['itemRemarks'],
            ':vendorId' => $_POST['vendorId'],
            ':shootDate' => $_POST['shootDate'],
            ':conveyanceCharges' => $_POST['conveyanceCharges'],
            ':agentCommission' => $_POST['agentCommission']
        )
    );

    $response['success'] = "Bill Raised Successfully.";
} catch (\Error $e) {
    $response['success'] = false;
    $response["error"] = $e->getMessage();
}
echo json_encode($response);
