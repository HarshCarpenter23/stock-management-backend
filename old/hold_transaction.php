<?php
session_start();
require 'apiconfig.php';
$response['error'] = false;
try {
    if ($_SESSION['role_id'] != "USER_EXE_PRODUCTION") {
        $response['error'] = true;
        $response['title'] = "Restricted Access";
        $response['body'] = "Caution trying to access restricted features";
        $response['status'] = "warning";
    } else {
        $date = date('Y-m-d H:i:s');
        $stmt = $pdo->query("update transaction_log set bill_status='Held',held_by='" . $_SESSION['vendor_id'] . "',held_datetime='" . $date . "' where bill_id='" . $_POST['id'] . "'");
    }
} catch (\Error $e) {
    $response['success'] = false;
    $response["error"] = $e->getMessage();
}
echo json_encode($response);
