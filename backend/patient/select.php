<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../utils/select_helper.php");

$arr = array();
foreach ($select_nationality as $value) {
    $arr[] = $value;
}

echo json_encode($arr);