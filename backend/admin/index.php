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
    <!-- Page content -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6>
                        <script>
                            let today = new Date();
                            let curHr = today.getHours();
                            if (curHr > 4 && curHr < 12) {
                                document.write('<i class="fas fa-sun"></i> Good Morning!');
                            } else if (curHr > 11 && curHr < 15) {
                                document.write('<i class="fas fa-cloud-sun"></i> Good Afternoon!');
                            } else if (curHr > 15 && curHr < 19) {
                                document.write('<i class="fas fa-cloud-moon"></i> Good Evening!');
                            } else {
                                document.write('<i class="fas fa-moon"></i> Good Night!');
                            }
                        </script>
                        <br/><br/>
                        <i class="far fa-clock"></i> <?php echo date('Y-m-d'); ?> <span id="timer"></span>
                        <script>
                            setInterval(function () {
                                let currentTime = new Date();
                                let currentHours = currentTime.getHours();
                                let currentMinutes = currentTime.getMinutes();
                                currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
                                let timeOfDay = (currentHours < 12) ? " AM" : " PM";
                                currentHours = (currentHours > 12) ? currentHours - 12 : currentHours;
                                currentHours = (currentHours === 0) ? 12 : currentHours;
                                document.getElementById("timer").innerHTML = currentHours + ":" + currentMinutes + timeOfDay;
                            }, 1000);
                        </script>
                    </h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <canvas id="HorizontalChart"></canvas>
                    <script>
                        Chart.platform.disableCSSInjection = true;
                        let ctx = document.getElementById('HorizontalChart').getContext('2d');
                        let myChart = new Chart(ctx, {
                            type: 'horizontalBar',
                            data: {
                                labels: [
                                    <?php
                                    $idquery = array();
                                    $result = mysqli_query($connection, "SELECT * FROM clinics ");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '"' . $row['clinic_name'] . '",';

                                        $idquery[] = $row["clinic_id"];
                                    }
                                    ?>
                                ],
                                datasets: [{
                                    label: 'Number of Appointment',
                                    data: [
                                        <?php
                                        foreach ($idquery as $arrvalue) {
                                            $newsql = "SELECT * FROM appointment WHERE clinic_id = $arrvalue ";
                                            $idnum = mysqli_num_rows(mysqli_query($connection, $newsql));
                                            echo $idnum . ',';
                                        }
                                        ?>
                                    ],
                                    backgroundColor: [
                                        'rgba(241, 90, 90, 0.2)',  // red
                                        'rgba(243, 156, 18, 0.2)', // orange
                                        'rgba(246, 229, 141, 0.2)', // yellow
                                        'rgba(155, 197, 61, 0.2)', // green
                                        'rgba(86, 157, 224, 0.2)', // blue
                                        'rgba(187, 85, 232, 0.2)'  // purple
                                    ],
                                    borderColor: [
                                        'rgba(241, 90, 90, 1)',  // red
                                        'rgba(243, 156, 18, 1)', // orange
                                        'rgba(246, 229, 141, 1)', // yellow
                                        'rgba(155, 197, 61, 1)', // green
                                        'rgba(86, 157, 224, 1)', // blue
                                        'rgba(187, 85, 232, 1)'  // purple
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                title: {
                                    display: true,
                                    text: 'Rank of Appointment Clinics',
                                },
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
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
    <!-- End Page Content -->
</div>
<?php include JS; ?>
</body>

</html>