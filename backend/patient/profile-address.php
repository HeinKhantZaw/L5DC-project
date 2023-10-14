<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json; charset=UTF-8");

include("../config/database.php");

if (isset($_POST['inputID'])) {
    $id = mysqli_escape_string($connection, $_POST['inputID']);
    $address = mysqli_escape_string($connection, $_POST['inputAddress']);
    $city = mysqli_escape_string($connection, $_POST['inputCity']);
    $township = mysqli_escape_string($connection, $_POST['inputTownship']);
    $zipcode = mysqli_escape_string($connection, $_POST['inputZipcode']);

    $statement = $connection->prepare("UPDATE patients SET patient_address = ?, patient_city = ?, patient_state = ?, patient_zipcode = ? WHERE patient_id = ? ");
    $statement->bind_param("sssss", $address, $city, $township, $zipcode, $id);

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