<?php
include("../config/autoload.php");
include("includes/path.inc.php");
include("includes/session.inc.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include CSS; ?>
</head>

<body>
<?php include NAVIGATION; ?>
<div class="page-content" id="content">
    <?php include HEADER; ?>
    <!-- Page content -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Datatable -->
                    <div class="data-tables">
                        <?php
                        function headerTable()
                        {
                            $header = array("Patient", "Date", "Time", "Provider", "Clinic", "Medical Condition", "Status");
                            for ($i = 0; $i < count($header); $i++) {
                                echo "<th>" . $header[$i] . "</th>" . PHP_EOL;
                            }
                        }

                        ?>
                        <table id="datatable" class="table" style="width:100%">
                            <thead>
                            <tr>
                                <?= headerTable(); ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $result = mysqli_query($connection, "SELECT * FROM appointment a JOIN patients p ON a.patient_id = p.patient_id JOIN clinics c ON a.clinic_id = c.clinic_id JOIN doctors d ON a.doctor_id = d.doctor_id ");
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($result->num_rows == 0) {
                                    echo '<p>No result</p>';
                                } else {
                                    ?>
                                    <tr>
                                        <td><?= $row["patient_firstname"] . ' ' . $row["patient_lastname"] ?></td>
                                        <td><?= $row["app_date"] ?></td>
                                        <td><?= $row["app_time"] ?></td>
                                        <td>Dr. <?= $row["doctor_firstname"] . ' ' . $row["doctor_lastname"] ?></td>
                                        <td><?= $row["clinic_name"] ?></td>
                                        <td><?php if($row["treatment_type"] != "undefined") echo $row["treatment_type"]; else echo "Not Known";  ?></td>
                                        <?php
                                        if ($row['status'] == 1) {
                                            echo '<td><span class="badge badge-success px-3 py-1">Confirmed</span></td>';
                                        } else {
                                            echo '<td><span class="badge badge-warning px-3 py-1">Pending</span></td>';
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- End Datatable -->
                </div>
            </div>

        </div>
    </div>
    <!-- End Page Content -->
</div>
<?php include JS; ?>
</body>
</html>