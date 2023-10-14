<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json; charset=UTF-8");

include("../config/database.php");

if (isset($_POST['inputID'])) {
    $id = mysqli_escape_string($connection, $_POST['inputID']);
    $firstname = mysqli_escape_string($connection, $_POST['inputFirstname']);
    $lastname = mysqli_escape_string($connection, $_POST['inputLastname']);
    $email = mysqli_escape_string($connection, $_POST['inputEmail']);
    $identity = mysqli_escape_string($connection, $_POST['inputIdentity']);
    $dob = date('Y-m-d', strtotime(mysqli_escape_string($connection, $_POST['inputDOB'])));
    $gender = mysqli_escape_string($connection, $_POST['inputGender']);
    $contact = mysqli_escape_string($connection, $_POST['inputContact']);
    $maritalstatus = mysqli_escape_string($connection, $_POST['inputMaritalStatus']);
    $nationality = mysqli_escape_string($connection, $_POST['inputNationality']);

    $statement = $connection->prepare("UPDATE patients SET patient_firstname = ?, patient_lastname = ?, patient_identity = ?, patient_email = ?, patient_dob = ?, patient_gender = ?, patient_contact = ?, patient_maritalstatus = ?, patient_nationality = ? WHERE patient_id = ? ");
    $statement->bind_param("ssssssssss", $firstname, $lastname, $identity, $email, $dob, $gender, $contact, $maritalstatus, $nationality, $id);

    if ($statement->execute()) {
        $result2 = $connection->query("SELECT * FROM patients WHERE patient_id = '" . $id . "' ");
        $numrows = mysqli_num_rows($result2);

        if ($numrows > 0) {
            $arr = array();
            while ($row = mysqli_fetch_assoc($result2)) {
                $arr[] = $row;
            }
            echo json_encode($arr);
        } else {
            echo json_encode(null);
        }
    } else {
        echo json_encode(array("message" => "Unsuccessful."));
    }
} else {
    echo "No Data Posted";
}
mysqli_close($connection);