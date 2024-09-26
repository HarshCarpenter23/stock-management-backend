<?php
session_start();
require 'apiconfig.php';
$response['success'] = true;
try {
    $uploadstr = "";
    for ($i = 1; $i < count($_POST['data']); $i++) {
        $uploadstr = $uploadstr . "('" . $_SESSION['movie_id'] . "',";
        for ($j = 0; $j < count($_POST['data'][$i]); $j++) {
            if ($j == 1) {
                $uploadstr = $uploadstr . "'" . date('Y-m-d', strtotime($_POST['data'][$i][$j])) . "',";
            } else if ($j == 10 || $j == 11 || $j == 12 || $j == 13 || $j == 14 || $j == 15 || $j == 16) {
                $uploadstr = $uploadstr . "'" . date('h:i:s', strtotime($_POST['data'][$i][$j])) . "',";
            } else {
                $uploadstr = $uploadstr . "'" . $_POST['data'][$i][$j] . "',";
            }
        }
        $uploadstr = substr($uploadstr, 0, strlen($uploadstr) - 1);
        $uploadstr = $uploadstr . "),";
    }
    $uploadstr = substr($uploadstr, 0, strlen($uploadstr) - 1);
    echo ($uploadstr);
    $stmt = $pdo->query("insert into schedule (movie_id,title,shoot_date,day_of_shoot,activity,city,call_sheet,location_1,location_2,location_3,
                                           location_4,crew_call_time,shoot_start_time,breakfast_time,lunch_time,dinner_time,scheduled_wrap_time,
                                          actual_wrap_time,scenes_to_be_executed,scenes_executed,pending_scenes,shoot_nature,remarks,weather) values " . $uploadstr);
} catch (\Error $e) {
    $response['success'] = false;
    $response["error"] = $e->getMessage();
}
echo json_encode($response);
