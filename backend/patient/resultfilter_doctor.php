<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../config/database.php");

$contentdata = file_get_contents("php://input");
$getdata = json_decode($contentdata);

$lowprice = $getdata->inputLowPrice;
$highprice = $getdata->inputHighPrice;
$gender = $getdata->inputGender;
//$language = $getdata->inputLanguage;

$query = "SELECT * FROM doctors INNER JOIN speciality ON doctors.doctor_speciality = speciality.speciality_id WHERE doctor_gender = '" . $gender . "' AND consult_fee BETWEEN '" . $lowprice . "' AND '" . $highprice . "' ";

$result = mysqli_query($connection, $query);

$numrow = mysqli_num_rows($result);

if ($numrow > 0) {
    $arr = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $arr[] = $row;
    }

    echo json_encode($arr);
    mysqli_close($connection);
} else {
    echo json_encode(null);
}