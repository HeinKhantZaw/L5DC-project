<?php
require_once('../config/autoload.php');
require_once('./includes/path.inc.php');
require_once('./includes/session.inc.php');

$doctor_id = decrypt_url($_GET['did']);
$result = mysqli_query($connection, "SELECT * FROM doctors WHERE doctor_id = '" . $doctor_id . "' ");
$doctor_row = mysqli_fetch_assoc($result);
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
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <?php
                    if ($doctor_row["doctor_avatar"] != "") {
                        echo '<img src="../uploads/' . $doctor_row["clinic_id"] . '/doctor' . '/' . $doctor_row["doctor_avatar"] . '" id="output" class="img-fluid thumbnail" alt="Doctor-Avatar" title="Doctor-Avatar">';
                    } else {
                        echo '<img src="./img/empty-avatar.jpg" id="output" class="img-fluid thumbnail" alt="Doctor-Avatar" title="Doctor-Avatar">';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h5 class="font-weight-bold mb-2">
                        Dr. <?php echo $doctor_row["doctor_firstname"] . ' ' . $doctor_row["doctor_lastname"]; ?></h5>
                    <h6>
                        <?php
                        $table_result = mysqli_query($connection, "SELECT * FROM speciality WHERE speciality_id =  '" . $doctor_row["doctor_speciality"] . "' ");
                        while ($table_row = mysqli_fetch_assoc($table_result)) {
                            echo $table_row['speciality_name'];
                        }
                        ?>
                    </h6>
                </div>
            </div>
            <div class="mt-3">
                <h5>About Me</h5>
                <div class="card">
                    <div class="card-body row">
                        <div class="col-7">
                            <div class="row">
                                <div class="col-1"><i class="fas fa-vote-yea fa-fw mr-3"></i></div>
                                <div class="col-3">Exp</div>
                                <div class="col-1">:</div>
                                <div class="col-6"><?= $doctor_row["doctor_experience"]; ?> years</div>
                            </div>
                            <div class="row">
                                <div class="col-1"><i class="fas fa-phone-alt fa-fw mr-3"></i></div>
                                <div class="col-3"> Phone</div>
                                <div class="col-1">:</div>
                                <div class="col-6"><?= $doctor_row["doctor_contact"]; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-1"><i class="fas fa-envelope fa-fw mr-3"></i></div>
                                <div class="col-3"> Email</div>
                                <div class="col-1">:</div>
                                <div class="col-6"><?= $doctor_row["doctor_email"]; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-1"><i class="fas fa-calendar fa-fw mr-3"></i></div>
                                <div class="col-3"> DOB</div>
                                <div class="col-1">:</div>
                                <div class="col-6"><?= $doctor_row["doctor_dob"]; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-1"><i class="fas fa-venus-mars fa-fw mr-3"></i></div>
                                <div class="col-3"> Gender</div>
                                <div class="col-1">:</div>
                                <div class="col-6"><?= $doctor_row["doctor_gender"]; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-1"><i class="fas fa-language fa-fw mr-3"></i></div>
                                <div class="col-3"> Language</div>
                                <div class="col-1">:</div>
                                <div class="col-6"><?= $doctor_row["doctor_spoke"]; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Biography</h5>
                        <p><?= $doctor_row["doctor_desc"]; ?></p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End Page Content -->
</div>
<?php include JS; ?>
</body>

</html>