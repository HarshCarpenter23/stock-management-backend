<?php
    require 'apiconfig.php';
    $stmt = $pdo->query("select * from role where category_id = '".$_POST['category_id']."'");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value=" . $row["role_id"] . ">" . $row["role_value"] . "</option>";
    }
