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
    $stmt3 = $pdo->prepare('insert into trans_generator(bill_id,movie_id,shoot_date,start_time,end_time,generator_type,vendor_id,remarks) values
(:billId,:movieId,:shootDate,:startTime,:endTime,:generatorType,:vendorId,:remarks)');
    $stmt3->execute(
        array(
            ':billId' => $billID,
            ':movieId' => $_SESSION['movie_id'],
            ':shootDate' => $_POST['shootDate'],
            ':startTime' => $_POST['startTime'],
            ':endTime' => $_POST['endTime'],
            ':generatorType' => $_POST['generatorType'],
            ':vendorId' => $_POST['vendorId'],
            ':remarks' => $_POST['itemRemarks']

        )
    );

    $response['success'] = "Bill Raised Successfully.";
} catch (\Error $e) {
    $response['success'] = false;
    $response["error"] = $e->getMessage();
}
echo json_encode($response);
