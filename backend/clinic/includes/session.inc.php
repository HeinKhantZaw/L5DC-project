<?php
try {
    if ($_SESSION["cliniclogin"] != 1) {
        header("Location: login.php");
    }

    $sess_email = $_SESSION["session_staff_email"];

    $statement1 = $connection->prepare("SELECT * FROM clinic_staff WHERE staff_email = ?");
    $statement1->bind_param("s", $sess_email);
    $statement1->execute();
    // $result = $statement1->get_result();
    $admin_row = $statement1->get_result()->fetch_assoc();
    $adminid = $admin_row['clinic_id'];
    $token = $admin_row["staff_token"];

    $statement2 = $connection->prepare("SELECT * FROM clinics WHERE clinic_id = ?");
    $statement2->bind_param("i", $adminid);
    $statement2->execute();
    $result = $statement2->get_result();
    $clinic_row = $result->fetch_assoc();

    $pt_row = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM appointment INNER JOIN patients ON appointment.patient_id = patients.patient_id WHERE appointment.clinic_id = '" . $clinic_row['clinic_id'] . "' AND appointment.status = 1"));
    $app_row = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM appointment WHERE clinic_id = '" . $clinic_row['clinic_id'] . "'"));
    $tr_row = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM doctors WHERE clinic_id = '" . $clinic_row['clinic_id'] . "'"));

    $statement1->close();
    $statement2->close();

} catch (Exception $e) {
    error_log($e);
    exit('Error message for user to understand');
}