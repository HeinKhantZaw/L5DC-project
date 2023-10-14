<?php
require_once('../config/autoload.php');
include('includes/path.inc.php');
include('includes/session.inc.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include CSS; ?>
    <link rel="stylesheet" href="../assets/css/clinic/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
</head>

<body>
<?php include NAVIGATION; ?>
<div class="page-content" id="content">
    <?php include HEADER; ?>
    <?php include WIDGET; ?>
    <div class="row">
        <div class="col-12">
            <?php
            if ($clinic_row["clinic_status"] == 0) {
                echo '<div class="alert alert-danger mt-3" role="alert">
                            Sorry, the system administrator hasn&#39;t approved yet. Please wait until you&#39;re approved. 
                        </div>';
            } else {
                $doctor_result = mysqli_query($connection, "SELECT * FROM doctors WHERE clinic_id = " . $clinic_row['clinic_id'] . "");
                $doctor_row = mysqli_fetch_assoc($doctor_result);
                if (mysqli_num_rows($doctor_result) == 0) {
                    echo '<div class="alert alert-warning mt-3" role="alert">
                                Please Add Doctor. <a href="doctor-add.php" class="alert-link">Click to Add Doctor</a>
                            </div>';
                }
            }
            ?>

            <?php
            $doctor_result = mysqli_query($connection, "SELECT * FROM clinic_images WHERE clinic_id = " . $clinic_row['clinic_id'] . "");
            $doctor_row = mysqli_fetch_assoc($doctor_result);
            if (mysqli_num_rows($doctor_result) == 0) {
                echo '<div class="alert alert-warning mt-3" role="alert">
                            Please add some images for the clinic. <a href="profile-edit.php" class="alert-link">Click to Add Images</a>
                        </div>';
            }
            ?>

            <!-- <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Hi, <?php echo $clinic_row["clinic_name"]; ?></h5>
                    </div>
                </div> -->

        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="myChart"></canvas>
                    <script>
                        Chart.platform.disableCSSInjection = true;
                        var ctx = document.getElementById('myChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                                datasets: [{
                                    label: 'Number of Appointment',
                                    data: [
                                        <?php
                                        $month_array = array("jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec");
                                        foreach ($month_array as $key => $month_value) {
                                            $result = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM appointment WHERE MONTH(app_date) = '" . ++$key . "' AND clinic_id = '" . $clinic_row['clinic_id'] . "' AND consult_status = 1"));
                                            echo "$result,";
                                        }
                                        ?>
                                    ],
                                    fill: false,
                                    borderColor: '#2196f3',
                                    backgroundColor: '#2196f3',
                                    borderWidth: 2
                                }]
                            },
                            options: {
                                title: {
                                    display: true,
                                    text: 'Monthly Visited Appointments',
                                },
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            scaleIntegersOnly: true,
                                            stepSize: 1,
                                            beginAtZero: true,
                                        }
                                    }]
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="HorizontalChart"></canvas>
                    <script>
                        Chart.platform.disableCSSInjection = true;
                        var ctx = document.getElementById('HorizontalChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'horizontalBar',
                            data: {
                                // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                                labels: [
                                    <?php
                                    $idquery = array();
                                    $result = mysqli_query($connection, "SELECT * FROM doctors WHERE clinic_id = " . $clinic_row['clinic_id'] . " ");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '"' . $row['doctor_firstname'] . ' ' . $row['doctor_lastname'] . '",';

                                        $idquery[] = $row["doctor_id"];
                                    }
                                    ?>
                                ],
                                datasets: [{
                                    label: 'Number of Appointment',
                                    data: [
                                        <?php
                                        foreach ($idquery as $arrvalue) {
                                            $newsql = "SELECT * FROM appointment WHERE doctor_id = $arrvalue AND consult_status = 1";
                                            $idnum = mysqli_num_rows(mysqli_query($connection, $newsql));
                                            echo $idnum . ',';
                                        }
                                        ?>
                                    ],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                title: {
                                    display: true,
                                    text: 'Visited Appointments Based on Doctor',
                                },
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true,
                                        }
                                    }],
                                    xAxes: [{
                                        ticks: {
                                            beginAtZero: true,
                                            scaleIntegersOnly: true,
                                            stepSize: 1,
                                        }
                                    }]
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include JS; ?>
</body>

</html>