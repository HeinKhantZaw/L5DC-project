<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../config/database.php");

if (isset($_POST['inputdate'])) {
    $date = $_POST['inputdate'];
    $id = $_POST['inputID'];

    $query = "SELECT * FROM schedule s LEFT JOIN schedule_detail sd ON s.schedule_id = sd.schedule_id 
	WHERE s.date_from <= '$date' AND s.date_to >= '$date' AND doctor_id = '$id'
	ORDER BY sd.time_slot";
    $result = $connection->query($query);

    if ($result->num_rows < 0) {
        echo json_encode(array("No Schedule Found"));
    } else {
        $arr = array();
        while ($row = $result->fetch_assoc()) {

            $day = $row['schedule_week'];
            $dayofweek = date("l", strtotime($date));

            if ($dayofweek == $day) {
                $arr[] = $row;
            }
        }

        echo json_encode($arr);
        mysqli_close($connection);
    }

} else {
    echo "POST METHOD ONLY";
}