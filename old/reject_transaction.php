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
        $stmt = $pdo->query("delete from transaction_log where bill_id='" . $_POST['id'] . "'");
    }
} catch (\Error $e) {
    $response['success'] = false;
    $response["error"] = $e->getMessage();
}
echo json_encode($response);
