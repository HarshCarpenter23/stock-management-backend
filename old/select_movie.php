<?php
session_start();
require 'apiconfig.php';
try {
    $_SESSION['movie_id'] = $_POST['movie_id'];
    if (!isset($_SESSION['category_id']) || $_SESSION['category_id'] != "MASTER") {
        $stmt = $pdo->query("select * from vendor_users where user_id='" . $_SESSION['logged'] . "' and movie='" . $_SESSION['movie_id'] . "'");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['vendor_id'] = $row['vendor_id'];
        $_SESSION['role_id'] = $row['role_id'];
    } else {
        $_SESSION['vendor_id'] = 0;
    }
    $result['success'] = true;
} catch (\Error $e) {
    $response['success'] = false;
    $response["error"] = $e->getMessage();
}
echo json_encode($result);
