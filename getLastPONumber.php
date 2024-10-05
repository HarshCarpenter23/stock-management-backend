<?php
require 'db.php';  // Assuming db.php contains the PDO connection details
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle GET request to fetch the last entered PO number
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query('SELECT po_number FROM purchase ORDER BY id DESC LIMIT 1');
        $lastPO = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($lastPO) {
            echo json_encode(['success' => true, 'po_number' => $lastPO['po_number']]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No PO numbers found']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request method']);
?>
