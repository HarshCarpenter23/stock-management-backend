<?php
require 'db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST, PUT, DELETE, GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

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
        $stmt = $pdo->prepare('INSERT INTO distribution (po_number, invoice_number, item_code, item_name, description_configuration, asset_number, to_department, quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['po_number'], $data['invoice_number'],
            $data['item_code'], $data['item_name'], $data['description_configuration'],
            $data['asset_number'], $data['to_department'], $data['quantity']
        ]);
        echo json_encode(['success' => true, 'message' => 'Distribution record added successfully']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

// Handle PUT request to update an existing distribution record
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $data);

    if ( !isset($data['po_number']) || !isset($data['invoice_number']) ||
        !isset($data['item_code']) || !isset($data['item_name']) || !isset($data['description_configuration']) ||
        !isset($data['asset_number']) || !isset($data['to_department']) || !isset($data['quantity'])) {
        echo json_encode(['success' => false, 'error' => 'Required fields are missing']);
        exit;
    }

    try {
        $stmt = $pdo->prepare('UPDATE distribution SET po_number = ?, invoice_number = ?, item_code = ?, item_name = ?, description_configuration = ?, asset_number = ?, to_department = ?, quantity = ? WHERE last_po_number = ?');
        $stmt->execute([
            $data['po_number'], $data['invoice_number'], $data['item_code'],
            $data['item_name'], $data['description_configuration'], $data['asset_number'],
            $data['to_department'], $data['quantity']
        ]);
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
        $stmt = $pdo->prepare('DELETE FROM distribution WHERE po_number = ?');
        $stmt->execute([$data['po_number']]);
        echo json_encode(['success' => true, 'message' => 'Distribution record deleted successfully']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request method']);
?>
