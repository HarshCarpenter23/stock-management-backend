<?php
session_start();
require 'apiconfig.php';
try {
    $response['success'] = true;
    if ($_POST['billno'] == "") $billno = '%';
    else $billno = $_POST['billno'];
    if ($_POST['status_filter'] == "All") $status = '%';
    else $status = $_POST['status_filter'];
    if ($_POST['bill_type'] == "All") $billtype = '%';
    else $billtype = $_POST['bill_type'];
    if ($_POST['category'] == 'All') $category = '%';
    else $category = $_POST['category'];
    $stmt = $pdo->query("select * from transaction_log where movie_id='" . $_SESSION['movie_id'] . "' and bill_id like '" . $billno . "' and
 bill_status like '" . $status . "' 
    and raised_datetime>='" . $_POST['from_date'] . "' and raised_datetime<='" . $_POST['end_date'] . "' and billType like '" . $billtype . "'");
    $index = 0;
    $response["bills"] = null;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $stmt2 = $pdo->query("select * from vendor_users where vendor_id='" . $row['vendor_id'] . "'");
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        $vendor_name = $row2['user_id'];
        if ($category == '%') {
            $response['bills'][$index] = array(
                "bill_id" => $row["bill_id"],
                "bill_type" => $row['billType'],
                "vendor_name" => $vendor_name,
                "bill_amount" => $row["bill_amount"],
                "bill_status" => $row['bill_status']
            );
            $index++;
        } else if ($row2['category_id'] == $category) {
            $response['bills'][$index] = array(
                "bill_id" => $row["bill_id"],
                "bill_type" => $row['billType'],
                "vendor_name" => $vendor_name,
                "bill_amount" => $row["bill_amount"],
                "bill_status" => $row['bill_status']
            );
            $index++;
        }
    }
    if ($index = 0) $response['empty'] = true;
    else $response['empty'] = false;
} catch (\Error $e) {
    $response['success'] = false;
    $response["error"] = $e->getMessage();
}
echo json_encode($response);
