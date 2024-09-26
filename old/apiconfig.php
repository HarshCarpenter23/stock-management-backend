<?php
    header('Content-Security-Policy: default-src \'self\' \'unsafe-inline\' \'unsafe-eval\' https: data:');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    header('X-Content-Type-Options: nosniff');
    header('Strict-Transport-Security:max-age=31536000; includeSubdomains; preload');
    date_default_timezone_set('Asia/Kolkata');

    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=flickanalytics', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $error_codes =[
        "500"=>"error name"
    ];
?>
