<?php
require 'apiconfig.php';
try {
    $tableName = $_POST['tableName'];
    $stmt = $pdo->query("SELECT COLUMN_NAME
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME = '" . $tableName . "'
ORDER BY ORDINAL_POSITION");
    $index = 0;
    $response['success'] = true;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $response['columns'][$index] = $row['COLUMN_NAME'];
        $index++;
    }
} catch (\Error $e) {
    $response['success'] = false;
    $response["error"] = $e->getMessage();
}
echo (json_encode($response));
