<?php
include('../config/autoload.php');
include('./includes/path.inc.php');
if (array_key_exists("cliniclogin", $_SESSION) && $_SESSION["cliniclogin"] == 1) {
    header("Location: index.php");
}
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include CSS; ?>
    </head>

    <body>
    <div class="container">
        <div class="login-wrap mx-auto">
            <div class="login-head">
                <h4><?php echo $BRAND_NAME; ?></h4>
                <p>Hello there, Sign into your Account!</p>
            </div>
            <div class="login-body">
                <form name="login_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="text" name="email" class="form-control" id="exampleInputEmail1"
                               aria-describedby="emailHelp" placeholder="Enter email">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                            else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                               placeholder="Password">
                    </div>
                    <div class="mb-3">
                        <a href="forgot.php">Forgot Password?</a>
                    </div>
                    <button type="submit" name="login_btn" class="btn btn-primary btn-block button">Log In</button>
                </form>
            </div>
            <div class="login-footer">
                <p class="text-muted">Don't have an account? <a href="register.php">Sign up</a></p>
            </div>
        </div>
    </div>
    </body>
    <?php include JS; ?>
    </html>

<?php
if (isset($_POST['login_btn'])) {
    $inputEmail = $connection->real_escape_string($_POST['email']);

    $check = $connection->prepare("SELECT * FROM clinic_staff WHERE staff_email = ? ");
    $check->bind_param("s", $inputEmail);
    $check->execute();
    $q = $check->get_result();
    $r = $q->fetch_assoc();
    if (mysqli_num_rows($q) != 1) {
        echo "<script>Swal.fire({title: 'Error!', text: 'Email & Password Not Exist', type: 'error', confirmButtonText: 'Try Again'})</script>";
        exit();
    } else {
        $token = $r["staff_token"];
    }

    $inputPassword = $connection->real_escape_string(encrypt(md5($_POST['password']), $token));

    $statement = $connection->prepare("SELECT * FROM clinic_staff WHERE staff_email = ? AND staff_password = ? ");
    $statement->bind_param("ss", $inputEmail, $inputPassword);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();

    if ($inputEmail == "" && empty($inputEmail)) {
        echo "<script>Swal.fire({title: 'Error!', text: 'Please Enter a Email', type: 'error'}).then(function() { $('#inputEmail').focus(); });</script>";
        exit();
    }

    if ($inputPassword == "" && empty($inputPassword)) {
        echo "<script>Swal.fire({title: 'Error!', text: 'Please Enter a Password', type: 'error'}).then(function() { $('#inputPassword').focus(); });</script>";
        exit();
    }

    if ($result->num_rows != 1) {
        echo "<script>Swal.fire({title: 'Error!', text: 'Email & Password Not Exist', type: 'error', confirmButtonText: 'Try Again'})</script>";
        exit();
    } else {
        $_SESSION['session_staff_id'] = $row['staff_id'];
        $_SESSION['session_staff_email'] = $row['staff_email'];
        $_SESSION['cliniclogin'] = 1;
        header("Location: index.php");
    }
    $statement->close();
}
?>