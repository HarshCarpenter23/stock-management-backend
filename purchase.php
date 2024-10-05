<?php
require 'db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST, PUT, DELETE, GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

// Handle GET request to fetch all purchase records
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query('SELECT * FROM purchase');
        $purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $purchases]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

// Handle POST request to add a new purchase
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['success' => false, 'error' => 'Invalid JSON format']);
        exit;
    }

    if (!isset($data['po_number']) || !isset($data['item_code']) || !isset($data['invoice_number']) ||
        !isset($data['item_name']) || !isset($data['description_configuration']) || !isset($data['vendor_name']) ||
        !isset($data['quantity']) || !isset($data['rate_per_piece']) || !isset($data['gst_amount'])) {
        echo json_encode(['success' => false, 'error' => 'Required fields are missing']);
        exit;
    }

    try {
        $stmt = $pdo->prepare('INSERT INTO purchase (po_number, item_code, invoice_number, item_name, description_configuration, vendor_name, quantity, rate_per_piece, gst_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['po_number'], $data['item_code'], $data['invoice_number'],
            $data['item_name'], $data['description_configuration'], $data['vendor_name'],
            $data['quantity'], $data['rate_per_piece'], $data['gst_amount']
        ]);

        // Update stock table: add purchase entry or create new record
        $updateStockStmt = $pdo->prepare('
            INSERT INTO stock (item_code, purchase_qty) 
            VALUES (?, ?) 
            ON DUPLICATE KEY UPDATE purchase_qty = purchase_qty + ?
        ');
        $updateStockStmt->execute([$data['item_code'], $data['quantity'], $data['quantity']]);

        echo json_encode(['success' => true, 'message' => 'Purchase record added successfully']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }

    exit;
}

// Handle PUT request to update an existing purchase
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $data);

    if (!isset($data['po_number']) || !isset($data['item_code']) || !isset($data['invoice_number']) ||
        !isset($data['item_name']) || !isset($data['description_configuration']) || !isset($data['vendor_name']) ||
        !isset($data['quantity']) || !isset($data['rate_per_piece']) || !isset($data['gst_amount'])) {
        echo json_encode(['success' => false, 'error' => 'Required fields are missing']);
        exit;
    }

    try {
        // Fetch old quantity to calculate difference
        $stmt = $pdo->prepare('SELECT quantity FROM purchase WHERE po_number = ?');
        $stmt->execute([$data['po_number']]);
        $oldQuantity = $stmt->fetchColumn();

        // Update purchase record
        $updatePurchaseStmt = $pdo->prepare('
            UPDATE purchase 
            SET item_code = ?, invoice_number = ?, item_name = ?, description_configuration = ?, vendor_name = ?, quantity = ?, rate_per_piece = ?, gst_amount = ? 
            WHERE po_number = ?
        ');
        $updatePurchaseStmt->execute([
            $data['item_code'], $data['invoice_number'], $data['item_name'],
            $data['description_configuration'], $data['vendor_name'],
            $data['quantity'], $data['rate_per_piece'], $data['gst_amount'],
            $data['po_number']
        ]);

        // Update stock based on the quantity difference
        $quantityDifference = $data['quantity'] - $oldQuantity;
        if ($quantityDifference !== 0) {
            $updateStockStmt = $pdo->prepare('
                INSERT INTO stock (item_code, purchase_qty) 
                VALUES (?, ?) 
                ON DUPLICATE KEY UPDATE purchase_qty = purchase_qty + ?
            ');
            $updateStockStmt->execute([$data['item_code'], $quantityDifference, $quantityDifference]);
        }

        echo json_encode(['success' => true, 'message' => 'Purchase record updated successfully']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }

    exit;
}

// Handle DELETE request to remove a purchase record
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data === null || !isset($data['po_number'])) {
        echo json_encode(['success' => false, 'error' => 'PO number is required']);
        exit;
    }

    try {
        // Fetch the quantity and item code before deletion
        $stmt = $pdo->prepare('SELECT quantity, item_code FROM purchase WHERE po_number = ?');
        $stmt->execute([$data['po_number']]);
        $purchase = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$purchase) {
            echo json_encode(['success' => false, 'error' => 'Purchase record not found']);
            exit;
        }

        // Delete the purchase record
        $deleteStmt = $pdo->prepare('DELETE FROM purchase WHERE po_number = ?');
        $deleteStmt->execute([$data['po_number']]);

        // Update stock (decrement distribution_entry)
        $updateStockStmt = $pdo->prepare('
            INSERT INTO stock (item_code, distribution_entry) 
            VALUES (?, ?) 
            ON DUPLICATE KEY UPDATE distribution_entry = distribution_entry + ?
        ');
        $updateStockStmt->execute([$purchase['item_code'], $purchase['quantity'], $purchase['quantity']]);

        echo json_encode(['success' => true, 'message' => 'Purchase record deleted successfully']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }

    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request method']);
?>
