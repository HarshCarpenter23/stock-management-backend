<?php
require 'db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST, GET");
header("Content-Type: application/json; charset=UTF-8");

// Fetch stock data directly from the stock table with item_name from items table
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Join the stock table with the items table to fetch item_name
        $stmt = $pdo->query("
            SELECT 
                s.item_code, 
                i.item_name, 
                s.purchase_qty, 
                s.distribution_qty, 
                s.current_stock 
            FROM 
                stock s
            JOIN 
                items i ON s.item_code = i.item_code;
        ");
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Prepare the response with the stock data
        echo json_encode(['success' => true, 'data' => $items]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

// Update stock based on new distribution entry
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['success' => false, 'error' => 'Invalid JSON format']);
        exit;
    }

    if (!isset($data['po_number']) || !isset($data['item_code']) || !isset($data['invoice_number']) ||
        !isset($data['item_name']) || !isset($data['quantity']) || !isset($data['to_department'])) {
        echo json_encode(['success' => false, 'error' => 'Required fields are missing']);
        exit;
    }

    try {
        // Insert the distribution record
        $stmt = $pdo->prepare('INSERT INTO distribution (po_number, invoice_number, item_code, item_name, description_configuration, asset_number, to_department, quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['po_number'], $data['invoice_number'],
            $data['item_code'], $data['item_name'], $data['description_configuration'],
            $data['asset_number'], $data['to_department'], $data['quantity']
        ]);

        // Update the stock in the stock table
        $stmt = $pdo->prepare("
            UPDATE stock 
            SET distribution_qty = distribution_qty + ?, 
                current_stock = purchase_qty - distribution_qty
            WHERE item_code = ?
        ");
        $stmt->execute([$data['quantity'], $data['item_code']]);

        // Fetch the updated stock information with item_name
        $stmt = $pdo->prepare("
            SELECT 
                s.item_code, 
                i.item_name, 
                s.purchase_qty, 
                s.distribution_qty, 
                s.current_stock 
            FROM 
                stock s
            JOIN 
                items i ON s.item_code = i.item_code
            WHERE 
                s.item_code = ?;
        ");
        $stmt->execute([$data['item_code']]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        // Prepare the response with the updated stock data
        echo json_encode(['success' => true, 'message' => 'Distribution added successfully', 'updated_stock' => $item]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}
?>
