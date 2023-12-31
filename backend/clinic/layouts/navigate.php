<div id="preloader">
    <div class="loader"></div>
</div>
<div class="navbar-sidebar">
    <div class="vertical-nav bg-white" id="sidebar">
        <div class="sidebar-header">
            <a href="#" data-toggle="tooltip" data-placement="bottom" title="" class="logo-src"
               data-original-title="Clinic"><?php echo $BRAND_NAME ?></a>
        </div>
        <div class="sidebabr-inner">
            <ul class="nav flex-column bg-white mb-0" id="metismenu">
                <p class="sidebar-heading px-3 pb-1 mb-0">Main</p>
                <li class="nav-item <?php if (stripos($_SERVER['REQUEST_URI'], 'index.php') !== FALSE) {
                    echo 'mm-active';
                } ?>">
                    <a href="index.php" class="nav-link"><i class="fas fa-tachometer-alt mr-3 fa-fw"></i>Dashboard</a>
                </li>
                <li class="nav-item <?php if (preg_match('/(profile)/', $_SREVRER["REQUEST_URI"]) == TRUE) {
                    echo 'mm-active';
                } ?>">
                    <a href="profile.php" class="nav-link"><i class="fas fa-clinic-medical mr-3 fa-fw"></i>Clinic
                        Profile</a>
                </li>
                <?php
                if ($clinic_row["clinic_status"] == 1) {
                    ?>
                    <li class="nav-item <?php if (preg_match('/(doctor)/', $_SERVER["REQUEST_URI"]) == TRUE) {
                        echo 'mm-active';
                    } ?>">
                        <a href="#" class="nav-link has-arrow" aria-expanded="false"><i
                                    class="fas fa-stethoscope mr-3 fa-fw"></i>Doctors</a>
                        <ul class="side-collapse">
                            <a href="doctor-list.php" class="nav-link"><i class="fas fa-list-ol mr-3 fa-fw"></i>Doctor
                                List</a>
                            <a href="doctor-add.php" class="nav-link"><i class="fa fa-user-plus mr-3 fa-fw"></i>Add
                                Doctor</a>
                        </ul>
                    </li>
                    <?php
                }
                ?>
                <li class="nav-item <?php if (preg_match('/(patient)/', $_SERVER["REQUEST_URI"]) == TRUE) {
                    echo 'mm-active';
                } ?>">
                    <a href="#" class="nav-link has-arrow" aria-expanded="false"><i
                                class="fa fa-user-injured mr-3 fa-fw"></i>Patients</a>
                    <ul class="side-collapse">
                        <a href="patient-list.php" class="nav-link"><i class="fas fa-list-ol mr-3 fa-fw"></i>Patient
                            List</a>
                    </ul>
                </li>
                <li class="nav-item <?php if (stripos($_SERVER['REQUEST_URI'], 'appointment.php') !== FALSE) {
                    echo 'mm-active';
                } ?>">
                    <a href="appointment.php" class="nav-link"><i class="fas fa-calendar-check mr-3 fa-fw"></i>Appointment</a>
                </li>
                <p class="sidebar-heading px-3 pb-1 mb-0">Others</p>
                <li class="nav-item <?php if (stripos($_SERVER['REQUEST_URI'], 'announcement.php') !== FALSE) {
                    echo 'mm-active';
                } ?>">
                    <a href="announcement.php" class="nav-link"><i
                                class="fa fa-bullhorn mr-3 fa-fw"></i>Announcement</a>
                </li>
                <li class="nav-item <?php if (stripos($_SERVER['REQUEST_URI'], 'report.php') !== FALSE) {
                    echo 'mm-active';
                } ?>">
                    <a href="report.php" class="nav-link"><i class="fa fa-chart-bar mr-3 fa-fw"></i>Report</a>
                </li>
            </ul>
        </div>
    </div>
</div>