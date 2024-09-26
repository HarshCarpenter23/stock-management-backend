<?php
session_start();
require 'apiconfig.php';
try {
    $stmt = $pdo->query("select * from vendor_users where movie='" . $_SESSION['movie_id'] . "' and category='" . $_POST['category'] . "'");
    $index = 0;
    $response["bills"] = null;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $stmt2 = $pdo->query("select * from vendor_users where vendor_id='" . $row['vendor_id'] . "'");
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        $vendor_name = $row2['user_id'];
        $response['bills'][$index] = array(
            "bill_id" => $row["bill_id"],
            "bill_type" => $row['billType'],
            "vendor_name" => $vendor_name,
            "bill_amount" => $row["bill_amount"],
            "bill_status" => $row['bill_status']
        );
        $index++;
    }
    if ($index = 0) $response['empty'] = true;
    else $response['empty'] = false;
} catch (\Error $e) {
    $response['success'] = false;
    $response["error"] = $e->getMessage();
}
echo json_encode($response);
