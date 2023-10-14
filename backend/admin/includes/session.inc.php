<?php
try {
    if ($_SESSION["adminlogin"] != 1)
        header("Location: login.php");

    $sess_id = $_SESSION["sess_adminid"];
    $adminstmt = $connection->prepare("SELECT * FROM admin WHERE admin_id = ?");
    $adminstmt->bind_param("i", $sess_id);
    $adminstmt->execute();
    $admin_result = $adminstmt->get_result();
    $admin_row = $admin_result->fetch_assoc();

    $clinic_count = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM clinics"));
    $patient_count = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM patients"));
    $appointment_count = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM appointment"));

    $adminstmt->close();
} catch (Exception $e) {
    error_log($e);
    exit('Error message for user to understand');
}