<?php
session_start();
require './apiconfig.php';
$tmpName = $_FILES['fileToUpload']['tmp_name'];
$csvAsArray = array_map('str_getcsv', file($tmpName));
$result['movie_id']=$_SESSION['movie_id'];
$result['data']=$csvAsArray;
echo(json_encode($result));
?>