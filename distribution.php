<?php
require 'db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST, PUT, DELETE, GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

// Function to update stock after any distribution change
function updateStock($pdo, $item_code, $quantity) {
    try {
        // Check if item_code exists in stock table
        $stmt = $pdo->prepare('SELECT * FROM stock WHERE item_code = ?');
        $stmt->execute([$item_code]);
        $stock = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stock) {
            // Item exists, update distribution_entry and current_stock
            $new_distribution_entry = $stock['distribution_qty'] + $quantity;
            $new_current_stock = $stock['purchase_qty'] - $new_distribution_entry;
            $stmt = $pdo->prepare('UPDATE stock SET distribution_qty = ?, current_stock = ? WHERE item_code = ?');
            $stmt->execute([$new_distribution_entry, $new_current_stock, $item_code]);
        } else {
            // Item does not exist, return error
            throw new Exception("Item with code $item_code does not exist in stock.");
        }
    } catch (Exception $e) {
        throw new Exception('Error updating stock: ' . $e->getMessage());
    }
}

// Handle GET request to fetch all distribution records
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query('SELECT * FROM distribution');
        $distributions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $distributions]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

// Handle POST request to add a new distribution record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['success' => false, 'error' => 'Invalid JSON format']);
        exit;
    }

    if (!isset($data['po_number']) || !isset($data['invoice_number']) ||
        !isset($data['item_code']) || !isset($data['item_name']) || !isset($data['description_configuration']) ||
        !isset($data['asset_number']) || !isset($data['to_department']) || !isset($data['quantity'])) {
        echo json_encode(['success' => false, 'error' => 'Required fields are missing']);
        exit;
    }

    try {
        // Check if item exists in stock before proceeding
        $stmt = $pdo->prepare('SELECT * FROM stock WHERE item_code = ?');
        $stmt->execute([$data['item_code']]);
        $stock = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$stock) {
            // If item does not exist in stock, return error
            echo json_encode(['success' => false, 'error' => 'Item does not exist in stock. Please add it first.']);
            exit;
        }

        // Insert distribution record
        $stmt = $pdo->prepare('INSERT INTO distribution (po_number, invoice_number, item_code, item_name, description_configuration, asset_number, to_department, quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['po_number'], $data['invoice_number'],
            $data['item_code'], $data['item_name'], $data['description_configuration'],
            $data['asset_number'], $data['to_department'], $data['quantity']
        ]);

        // Update stock after adding distribution
        updateStock($pdo, $data['item_code'], $data['quantity']);

        echo json_encode(['success' => true, 'message' => 'Distribution record added successfully']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

// Handle PUT request to update an existing distribution record
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $data);

    if (!isset($data['po_number']) || !isset($data['invoice_number']) ||
        !isset($data['item_code']) || !isset($data['item_name']) || !isset($data['description_configuration']) ||
        !isset($data['asset_number']) || !isset($data['to_department']) || !isset($data['quantity'])) {
        echo json_encode(['success' => false, 'error' => 'Required fields are missing']);
        exit;
    }

    try {
        // Update distribution record
        $stmt = $pdo->prepare('UPDATE distribution SET po_number = ?, invoice_number = ?, item_code = ?, item_name = ?, description_configuration = ?, asset_number = ?, to_department = ?, quantity = ? WHERE po_number = ?');
        $stmt->execute([
            $data['po_number'], $data['invoice_number'], $data['item_code'],
            $data['item_name'], $data['description_configuration'], $data['asset_number'],
            $data['to_department'], $data['quantity'], $data['po_number']
        ]);

        // Update stock after updating distribution
        updateStock($pdo, $data['item_code'], $data['quantity']);

        echo json_encode(['success' => true, 'message' => 'Distribution record updated successfully']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

// Handle DELETE request to remove a distribution record
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data === null || !isset($data['po_number'])) {
        echo json_encode(['success' => false, 'error' => 'PO number is required']);
        exit;
    }

    try {
        // Delete the distribution record
        $stmt = $pdo->prepare('DELETE FROM distribution WHERE po_number = ?');
        $stmt->execute([$data['po_number']]);

        // Update stock after deleting distribution (set quantity to negative to subtract from stock)
        updateStock($pdo, $data['item_code'], -$data['quantity']);

        echo json_encode(['success' => true, 'message' => 'Distribution record deleted successfully']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request method']);
?>
