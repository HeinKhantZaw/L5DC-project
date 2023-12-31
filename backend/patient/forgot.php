<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../config/database.php");
include("../config/validator.php");
include("../utils/email.php");
error_reporting(E_ALL);
ini_set('display_errors', 'on');

if (isset($_POST['inputEmail'])) {
    $email = escape_input($_POST['inputEmail']);

    $statement = $connection->prepare("SELECT * FROM patients WHERE patient_email = ? ");
    $statement->bind_param("s", $email);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();

    if ($result->num_rows == 1) {
        $selector = bin2hex(random_bytes(8));
        $validator = random_bytes(32);
        $link = $_SERVER["SERVER_NAME"] . "/lifecare/backend/patient/reset.php?selector=" . $selector . "&validator=" . bin2hex($validator);
        $expries = date("U") + 1800;

        $fgstmt = $connection->prepare("DELETE FROM patient_reset WHERE reset_email = ?");
        $fgstmt->bind_param("s", $email);
        $fgstmt->execute();

        $hashedToken = password_hash($validator, PASSWORD_DEFAULT);

        $fgstmt = $connection->prepare("INSERT INTO patient_reset (reset_email, reset_selector, reset_token, reset_expires) VALUE (?,?,?,?)");
        $fgstmt->bind_param("ssss", $email, $selector, $hashedToken, $expries);
        $fgstmt->execute();
        $fgstmt->close();

        $t = "";
        sendmail($email, $mail['fg_subject'], $mail['fg_title'], $mail['fg_content'], $mail['fg_button'], $link, $t);

        $message_array = array("1");
        echo json_encode($message_array, JSON_FORCE_OBJECT);
    } else {
        $message_array = array("0");
        echo json_encode($message_array, JSON_FORCE_OBJECT);
    }

    $statement->close();
    $connection->close();
} else {
    echo "POST METHOD ONLY";
}