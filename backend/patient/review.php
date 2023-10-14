<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../config/database.php");
include("../config/validator.php");

if (isset($_POST['inputRating'])) {
    $patient = escape_input($_POST['inputPatientID']);
    $doctor = escape_input($_POST['inputDoctorID']);
    $rating = escape_input($_POST['inputRating']);
    $review = escape_input($_POST['inputReview']);
    date_default_timezone_set('Asia/Rangoon');
    $date = date('Y-m-d H:i:s');


    $statement = $connection->prepare("INSERT INTO reviews (rating, review, date, doctor_id, patient_id) VALUES (?, ?, ?, ?, ?)");
    $statement->bind_param("sssii", $rating, $review, $date, $doctor, $patient);
    $statement->execute();
    $statement->close();
    $connection->close();
} else {
    echo "POST METHOD ONLY";
}