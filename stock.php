<?php
require 'db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST, GET");
header("Content-Type: application/json; charset=UTF-8");

// Fetch and calculate stock based on purchase and distribution
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query("
            SELECT 
                p.item_name,
                SUM(p.quantity) AS purchase_quantity,
                COALESCE(SUM(d.quantity), 0) AS distributed_quantity,
                (SUM(p.quantity) - COALESCE(SUM(d.quantity), 0)) AS stock
            FROM 
                purchase p
            LEFT JOIN 
                distribution d ON p.item_name = d.item_name
            GROUP BY 
                p.item_name;
        ");
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Prepare a stock variable
        $stock = [];
        foreach ($items as $item) {
            $stock[] = [
                'item_name' => $item['item_name'],
                'purchase_quantity' => (int)$item['purchase_quantity'],
                'distributed_quantity' => (int)$item['distributed_quantity'],
                'stock' => (int)$item['stock'],
            ];
        }

        echo json_encode(['success' => true, 'data' => $stock]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

// Update distribution and reflect in stock when POSTing new distribution
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
        $stmt = $pdo->prepare('INSERT INTO distribution (po_number, invoice_number, item_code, item_name, description_configuration, asset_number, to_department, quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['po_number'], $data['invoice_number'],
            $data['item_code'], $data['item_name'], $data['description_configuration'],
            $data['asset_number'], $data['to_department'], $data['quantity']
        ]);

        // Now fetch the updated stock information for the specific item
        $stmt = $pdo->prepare("
            SELECT 
                p.item_name,
                SUM(p.quantity) AS purchase_quantity,
                COALESCE(SUM(d.quantity), 0) AS distributed_quantity,
                (SUM(p.quantity) - COALESCE(SUM(d.quantity), 0)) AS stock
            FROM 
                purchase p
            LEFT JOIN 
                distribution d ON p.item_name = d.item_name
            WHERE 
                p.item_name = ?
            GROUP BY 
                p.item_name;
        ");
        $stmt->execute([$data['item_name']]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        // Prepare a stock variable for the updated item
        $updated_stock = [
            'item_name' => $item['item_name'],
            'purchase_quantity' => (int)$item['purchase_quantity'],
            'distributed_quantity' => (int)$item['distributed_quantity'],
            'stock' => (int)$item['stock'],
        ];

        echo json_encode(['success' => true, 'message' => 'Distribution added successfully', 'updated_stock' => $updated_stock]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}
?>
