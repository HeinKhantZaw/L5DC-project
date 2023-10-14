<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../config/database.php");
include("../config/validator.php");

if (isset($_POST['inputAppointmentID'])) {
    $app_id = escape_input($_POST['inputAppointmentID']);

    $statement = $connection->prepare("UPDATE appointment SET status = 0 WHERE app_id = ? ");
    $statement->bind_param("i", $app_id);
    $statement->execute();
    $statement->close();
    $connection->close();
} else {
    echo json_encode("POST METHOD ONLY");
}