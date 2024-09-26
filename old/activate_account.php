<?php
session_start();
require 'apiconfig.php';
$response['success'] = true;
try {
    $stmt = $pdo->query("update vendor set account_status=1 where vendor_name='" . $_POST['id'] . "' and role_id='" . $_POST['role_id'] . "' and movie_id='" . $_SESSION['movie_id'] . "'");
    echo "something";
} catch (\Error $e) {
    $response['success'] = false;
    $response["error"] = $e->getMessage();
}
echo json_encode($response);
