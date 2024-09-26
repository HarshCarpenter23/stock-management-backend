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
    $stmt = $pdo->prepare("insert into trans_vehicle_rent values
(:billID,:movieId,:shootDate,:vehicleNumber,:usedFor,:remarks,:fuelCharges,:driverBata,:otherCharges)");
    $stmt->execute(
        array(
            ':billID' => $billID,
            ':movieId' => $_SESSION['movie_id'],
            ':vehicleNumber' => $_POST['vehicleNumber'],
            ':usedFor' => $_POST['usedFor'],
            ':shootDate' => $_POST['shootDate'],
            ':remarks' => $_POST['itemRemarks'],
            ':fuelCharges' => $_POST['fuelCharges'],
            ':driverBata' => $_POST['driverBata'],
            ':otherCharges' => $_POST['otherCharges']

        )
    );

    $response['success'] = "Bill Raised Successfully.";
} catch (\Error $e) {
    $response['success'] = false;
    $response["error"] = $e->getMessage();
}
echo json_encode($response);
