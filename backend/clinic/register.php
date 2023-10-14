<?php
require_once('../config/autoload.php');
require_once('./includes/path.inc.php');
ob_start();

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = escape_input($_POST['inputClinicName']);
    $staff = escape_input($_POST['inputStaffName']);
    $email = escape_input($_POST['inputEmail']);
    $contact = escape_input($_POST['inputContact']);
    $password = $connection->real_escape_string($_POST['inputPassword']);
    $con_pass = $connection->real_escape_string($_POST['inputConfirmPassword']);

    if (empty($name)) {
        array_push($errors, "Clinic Branch Name is required");
    }
    if (empty($staff)) {
        array_push($errors, "Clinic Staff Name is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    } else {
        email_validation($email);
    }
    if (empty($contact)) {
        array_push($errors, "Contact is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    } elseif ($password != $con_pass) {
        array_push($errors, "Password not Equal");
    } else {
        password_validation($password);
    }

    if (empty($con_pass)) {
        array_push($errors, "Confirm Password is required");
    }
}
?>
    <!DOCTYPE html>
    <html>

    <head>
        <?php include CSS; ?>
        <link rel="stylesheet" href="../assets/css/login.css">
    </head>

    <body>
    <div class="container">
        <div class="login-wrap mx-auto">
            <div class="login-head">
                <h4><?php echo $BRAND_NAME; ?></h4>
                <p>Create an Account! Manage Your Clinic</p>
            </div>
            <div class="login-body">
                <form name="login_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <?php echo display_error(); ?>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Clinic Branch Name</label>
                        <input type="text" name="inputClinicName" class="form-control" id="inputClinicName"
                               placeholder="Clinic Branch Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleinputStaffName">Clinic Staff Name</label>
                        <input type="text" name="inputStaffName" class="form-control" id="inputStaffName"
                               placeholder="John Doe">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Email Address</label>
                            <input type="text" name="inputEmail" class="form-control" id="inputEmail"
                                   placeholder="example@address.com">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputContact">Contact Number</label>
                            <input type="text" name="inputContact" class="form-control" id="inputContact"
                                   placeholder="01012345678">
                        </div>
                    </div>
                    <div class="form-row mb-2">
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="inputPassword" class="form-control" id="inputPassword"
                                   placeholder="Enter Password" data-toggle="popover" data-placement="left"
                                   data-content="Password must contain at least 8 characters, including UPPERCASE, lowercase and numbers">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Confirm Password</label>
                            <input type="password" name="inputConfirmPassword" class="form-control"
                                   id="inputConfirmPassword" placeholder="Re-enter Password">
                        </div>
                    </div>
                    <button type="submit" name="registerbtn" class="btn btn-primary btn-block button">Create an
                        Account
                    </button>
                </form>
            </div>
            <div class="login-footer">
                <p class="text-muted">Already have an account? <a href="login.php">Sign In</a></p>
            </div>
        </div>
    </div>
    <?php include JS; ?>
    <script>
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover();
        });
    </script>
    </body>

    </html>
<?php
if (isset($_POST['registerbtn'])) {
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (count($errors) == 0) {
        $statement = $connection->prepare("INSERT INTO clinics (clinic_name, date_created) VALUES (?, ?)");
        $statement->bind_param("ss", $name, $date_created);
        if ($statement->execute()) {
            $last_id = mysqli_insert_id($connection);
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        }
        $statement->close();

        $token = generateCode(22);
        $en_pass = encrypt(md5($password), $token);

        $statement = $connection->prepare("INSERT INTO clinic_staff (staff_name, staff_email, staff_password, staff_token, staff_phone, date_created, clinic_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $statement->bind_param("sssssss", $staff, $email, $en_pass, $token, $contact, $date_created, $last_id);

        $weekstmt = $connection->prepare("INSERT INTO business_hour (clinic_id) VALUES (?)");
        $weekstmt->bind_param("i", $last_id);

        if ($statement->execute() && $weekstmt->execute()) {
            $_SESSION['session_staff_email'] = $email;
            $_SESSION['cliniclogin'] = 1;
            header("Location: clinic-register.php");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        }

        $statement->close();
        $weekstmt->close();
    }
}
?>