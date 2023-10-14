<?php
require_once('../config/autoload.php');
require_once('./includes/path.inc.php');
require_once('./includes/session.inc.php');

$errors = array();

if (isset($_POST["savebtn"])) {
    $id = $admin_row["staff_id"];
    $name = escape_input($_POST['inputName']);
    $email = escape_input($_POST['inputEmailAddress']);
    $contact = escape_input($_POST['inputContactNumber']);

    if (empty($name)) {
        array_push($errors, "Name is required");
    }

    if (empty($email)) {
        array_push($errors, "Email Address is required");
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Invalid email format");
        }
    }

    if (empty($contact)) {
        array_push($errors, "Contact Number is required");
    }
}

// Reset Password
if (isset($_POST["resetbtn"])) {
    $id = $admin_row["staff_id"];
    $oldpass = $connection->real_escape_string($_POST['inputOldPassword']);
    $newpass = $connection->real_escape_string($_POST['inputNewPassword']);
    $conpass = $connection->real_escape_string($_POST['inputConfirmPassword']);

    $passstmt = $connection->prepare("SELECT * FROM clinic_staff WHERE staff_id =?");
    $passstmt->bind_param("i", $id);
    $passstmt->execute();
    $result = $passstmt->get_result();
    $row = $result->fetch_assoc();
    $token = $row["staff_token"];
    $password = decrypt($row["staff_password"], $token);

    if (empty($oldpass)) {
        array_push($errors, "Password is required");
    } elseif (empty($newpass)) {
        array_push($errors, "New Password is required");
    } elseif (empty($conpass)) {
        array_push($errors, "Confirm Password is required");
    } elseif (md5($oldpass) != $password) {
        array_push($errors, "Incorrect Password");
    } elseif (!empty($newpass)) {
        password_validation($newpass);
    } elseif ($newpass != $conpass) {
        array_push($errors, "Password not Equal");
    }
}
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include CSS; ?>
    </head>

    <body>
    <?php
    if (isset($_POST["resetbtn"])) {
        if (count($errors) == 0) {
            $newtoken = generateCode(22);
            $en_pass = encrypt(md5($newpass), $newtoken);
            $statement2 = $connection->prepare("UPDATE clinic_staff SET staff_password = ?, staff_token = ? WHERE staff_id = ?");
            $statement2->bind_param("ssi", $en_pass, $newtoken, $id);
            if ($statement2->execute()) {
                echo '<script>
                        Swal.fire({ title: "Great!", text: "Password Reset Successfully!", type: "success" }).then((result) => {
                            if (result.value) { window.location.href = "admin.php"; }
                        })
                        </script>';
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($connection);
            }
        }
    }
    ?>
    <?php include NAVIGATION; ?>
    <div class="page-content" id="content">
        <?php include HEADER; ?>
        <!-- Page content -->
        <div class="row">
            <div class="col-12">
                <form name="regform" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                      autocomplete="off">
                    <?php echo display_error(); ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputFirstName">Name</label>
                                    <input type="text" name="inputName" class="form-control" id="inputName"
                                           placeholder="Enter Name" value="<?php echo $admin_row["staff_name"]; ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputContactNumber">Contact Number</label>
                                    <input type="text" name="inputContactNumber" class="form-control"
                                           id="inputContactNumber" placeholder="Enter Phone Number"
                                           value="<?php echo $admin_row["staff_phone"]; ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputEmailAddress">Email Address</label>
                                    <input type="text" name="inputEmailAddress" class="form-control"
                                           id="inputEmailAddress" placeholder="Enter Email Address"
                                           value="<?php echo $admin_row["staff_email"]; ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 mt-3">
                        <button type="submit" class="btn btn-primary btn-block" name="savebtn">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <form name="resetform" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                      autocomplete="off">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputOldPassword">Old Password</label>
                                <input type="password" name="inputOldPassword" class="form-control"
                                       id="inputOldPassword" placeholder="Enter Old Password">
                            </div>
                            <div class="form-group">
                                <label for="inputNewPassword">New Password</label>
                                <input type="password" name="inputNewPassword" class="form-control"
                                       id="inputNewPassword" placeholder="Enter New Password">
                                <small class="form-text text-muted" id="passwordHelp">Use 8 or more characters with a
                                    mix of letters, numbers & symbols</small>
                            </div>
                            <div class="form-group">
                                <label for="inputConfirmPassword">Confirm New Password</label>
                                <input type="password" name="inputConfirmPassword" class="form-control"
                                       id="inputConfirmPassword" placeholder="Enter Confirm New Password">
                            </div>
                        </div>
                    </div>
                    <div class="md-3 mt-3">
                        <button type="submit" class="btn btn-primary btn-block" name="resetbtn">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
    <?php include JS; ?>
    </body>

    </html>
<?php
// Edit Profile
if (isset($_POST["savebtn"])) {
    if (count($errors) == 0) {
        $statement = $connection->prepare("UPDATE clinic_staff SET staff_name = ?, staff_email = ?, staff_phone = ? WHERE staff_id = ? ");
        $statement->bind_param("sssi", $name, $email, $contact, $id);

        if ($statement->execute()) {
            $_SESSION['session_staff_email'] = $email;
            echo '<script>
            Swal.fire({ title: "Great!", text: "Update Successfully!", type: "success" }).then((result) => {
                if (result.value) { window.location.href = "admin.php"; }
            });
            </script>';
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($connection);
        }
        $statement->close();
    }
}
?>