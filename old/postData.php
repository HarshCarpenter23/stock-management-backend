<?php
require './apiconfig.php';
try {
    $tmpName = $_FILES['fileToUpload']['tmp_name'];
    $csvAsArray = array_map('str_getcsv', file($tmpName));
    echo (json_encode($csvAsArray));
} catch (\Error $e) {
    $response['success'] = false;
    $response["error"] = $e->getMessage();
}
