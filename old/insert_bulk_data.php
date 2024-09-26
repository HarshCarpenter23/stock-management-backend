<?php
require './apiconfig.php';
$tableName = $_POST['table_name'];
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
$column_query_string = "";
$column_value_string = "";
for ($i = 0; $i < count($response['columns']); $i++) {
    if ($_POST[$response['columns'][$i]] != '-1') {
        $column_query_string =$column_query_string.$response['columns'][$i].",";
    }
}
$column_query_string=substr($column_query_string, 0, -1);

for ($i = 1; $i < count($_POST['insert_data']); $i++) {
    $column_value_string=$column_value_string."(";
    for ($j = 0; $j < count($response['columns']); $j++) {
        if ($_POST[$response['columns'][$j]] != '-1') {
            $column_value_string = $column_value_string. $_POST['insert_data'][$i][$_POST[$response['columns'][$j]]].",";
        }
    }
    $column_value_string=substr($column_value_string, 0, -1);
    $column_value_string=$column_value_string."),";
}
$column_value_string=substr($column_value_string,0,-1);

$stmt = $pdo->prepare("insert into " . $tableName . "(" . $column_query_string . ") values" . $column_value_string);
$stmt->execute();
echo("insert into " . $tableName . "(" . $column_query_string . ") values" . $column_value_string);