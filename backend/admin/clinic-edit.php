<?php
require_once('../config/autoload.php');
include('includes/path.inc.php');
include('includes/session.inc.php');
include(SELECT_HELPER);


$id = $_REQUEST['cid'];
$decoded_id = base64_decode(urldecode($id));

$result = mysqli_query($connection, "SELECT * FROM clinics WHERE clinic_id = " . $decoded_id . "");
$clinic_row = mysqli_fetch_assoc($result);
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
        <?php
        $errName = $errContact = $errEmail = $errAddress = $errCity = $errTownship = $errZipcode = "";
        $className = $classContact = $classEmail = $classURL = $classAddress = $classCity = $classState = $classZipcode = "";

        if (isset($_POST["savebtn"])) {
            $clinic_status = escape_input($_POST["inputStatus"]);
            $clinic_name = escape_input($_POST["inputClinicName"]);
            $contact = escape_input($_POST["inputContact"]);
            $email = escape_input($_POST["inputEmailAddress"]);

            $opensweek = escape_input($_POST["inputOpensHourWeek"]);
            $closeweek = escape_input($_POST["inputCloseHourWeek"]);

            $openssat = escape_input($_POST["inputOpensHourSat"]);
            $closesat = escape_input($_POST["inputCloseHourSat"]);

            $openssun = escape_input($_POST["inputOpensHourSun"]);
            $closesun = escape_input($_POST["inputCloseHourSun"]);

            $address = escape_input($_POST["inputAddress"]);
            $city = escape_input($_POST["inputCity"]);
            if (isset($_POST['inputTownship'])) {
                $township = escape_input($_POST['inputTownship']);
            }
            $zipcode = escape_input($_POST["inputZipCode"]);

            // Validate
            if (empty($clinic_name)) {
                $errName = $error_html['errFirstName'];
                $className = $error_html['errClass'];
            } else {
                if (!preg_match($regrex['text'], $clinic_name)) {
                    $errName = $error_html['invalidText'];
                    $className = $error_html['errClass'];
                }
            }

            if (empty($email)) {
                $errEmail = $error_html['errEmail'];
                $classEmail = $error_html['errClass'];
            } else {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errEmail = $error_html['invalidEmail'];
                    $classEmail = $error_html['errClass'];
                }
            }

            if (empty($contact)) {
                $errContact = $error_html['errContact'];
                $classContact = $error_html['errClass'];
            } else {
                if (!preg_match($regrex['contact'], $contact)) {
                    $errContact = $error_html['invalidContact'];
                    $classContact = $error_html['errClass'];
                }
            }

            if (empty($address)) {
                $errAddress = $error_html['errAddress'];
                $classAddress = $error_html['errClass'];
            } else {
                if (!preg_match($regrex['text'], $address)) {
                    $errAddress = $error_html['invalidText'];
                    $classAddress = $error_html['errClass'];
                }
            }

            if (empty($city)) {
                $errCity = $error_html['errCity'];
                $classCity = $error_html['errClass'];
            } else {
                if (!preg_match($regrex['text'], $city)) {
                    $errCity = $error_html['invalidText'];
                    $classCity = $error_html['errClass'];
                }
            }

            if (empty($zipcode)) {
                $errZipcode = $error_html['errZipcode'];
                $classZipcode = $error_html['errClass'];
            } else {
                if (!filter_var($zipcode, FILTER_VALIDATE_INT)) {
                    $errZipcode = $error_html['invalidInt'];
                    $errZipcode = $error_html['errClass'];
                }
            }

            if (empty($township)) {
                $errTownship = $error_html['errTownship'];
                $classState = $error_html['errClass'];
            }

            if (multi_empty($errName, $errContact, $errEmail, $errAddress, $errCity, $errTownship, $errZipcode)) {
                $clinicstmt = $connection->prepare("UPDATE clinics SET clinic_name = ?, clinic_email = ?, clinic_contact = ?, clinic_address = ?, clinic_city = ?, clinic_state = ?, clinic_zipcode = ?, clinic_status = ? WHERE clinic_id = ?");
                $clinicstmt->bind_param("ssssssssi", $clinic_name, $email, $contact, $address, $city, $township, $zipcode, $clinic_status, $clinic_row['clinic_id']);

                $hourstmt = $connection->prepare("UPDATE business_hour SET open_week = ?, close_week = ?, open_sat = ?, close_sat = ?, open_sun = ?, close_sun = ? WHERE clinic_id = ?");
                $hourstmt->bind_param("sssssss", $opensweek, $closeweek, $openssat, $closesat, $openssun, $closesun, $clinic_row['clinic_id']);

                if ($clinicstmt->execute() && $hourstmt->execute()) {
                    echo '<script>
							Swal.fire({ title: "Great!", text: "Record Updated!", type: "success" }).then((result) => {
								if (result.value) { window.location.href = "clinic-list.php"; }
							});
						</script>';
                } else {
                    echo '<script>Swal.fire({ title: "Oops...!", text: "Something Happen!", type: "error" });</script>';
                }
            }
        }
        ?>
        <!-- Page content -->
        <div class="row">
            <div class="col-12">
                <form name="regform" method="POST" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>">
                    <h5 class="card-title mt-3">
                        Clinic Profile Info
                    </h5>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputStatus">Clinic ID #</label>
                                    <select name="inputStatus" id="inputStatus" class="form-control">
                                        <option value="1" <?= $clinic_row["clinic_status"] == 1 ? "selected" : "" ?>>
                                            Approve
                                        </option>
                                        <option value="0" <?= $clinic_row["clinic_status"] == 0 ? "selected" : "" ?>>Not
                                            Approved
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputClinicName">Clinic Branch Name</label>
                                    <input type="text" name="inputClinicName" class="form-control <?= $className ?>"
                                           id="inputClinicName" placeholder=""
                                           value="<?php echo $clinic_row["clinic_name"]; ?>">
                                    <?= $errName; ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputContact">Contact Number</label>
                                    <input type="text" name="inputContact" class="form-control <?= $classContact ?>"
                                           id="inputContact" placeholder=""
                                           value="<?php echo $clinic_row["clinic_contact"]; ?>">
                                    <?= $errContact; ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputEmailAddress">Email Address</label>
                                    <input type="text" name="inputEmailAddress" class="form-control <?= $classEmail ?>"
                                           id="inputEmailAddress" placeholder="example@address.com"
                                           value="<?php echo $clinic_row["clinic_email"]; ?>">
                                    <?= $errEmail; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <span class="card-title">Business Hour</span>
                            <div class="mb-2">
                                <small class="text-muted">If the clinic is closed on a certain day, just leave the hours
                                    blank.</small>
                            </div>
                            <?php
                            $hour_row = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM business_hour WHERE clinic_id = " . $clinic_row["clinic_id"] . " "));
                            ?>
                            <div class="form-group row">
                                <label for="inputBusinessHourWeek" class="col-sm-2 col-form-label">Monday -
                                    Friday</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control timepicker"
                                           name="inputOpensHourWeek" value="<?= $hour_row["open_week"]; ?>">
                                </div>
                                <span>--</span>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control timepicker"
                                           name="inputCloseHourWeek" value="<?= $hour_row["close_week"]; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputBusinessHourSat" class="col-sm-2 col-form-label">Saturday</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control timepicker"
                                           name="inputOpensHourSat" value="<?= $hour_row["open_sat"]; ?>">
                                </div>
                                <span>--</span>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control timepicker"
                                           name="inputCloseHourSat" value="<?= $hour_row["close_sat"]; ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputBusinessHourSun" class="col-sm-2 col-form-label">Sunday</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control timepicker"
                                           name="inputOpensHourSun" value="<?= $hour_row["open_sun"]; ?>">
                                </div>
                                <span>--</span>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control timepicker"
                                           name="inputCloseHourSun" value="<?= $hour_row["close_sun"]; ?>">
                                </div>
                            </div>
                            <!-- <div id="new_chq"></div>
                            <input type="hidden" value="1" id="total_chq">
                            <div class="d-flelx">
                                <button type="button" class="btn btn-primary" id="add">Add</button>
                                <button type="button" class="btn btn-primary" id="remove">Remove</button>
                            </div> -->
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputAddress">Address</label>
                                <input type="text" name="inputAddress" class="form-control <?= $classAddress ?>"
                                       id="inputAddress"
                                       placeholder=" 24, Baho Rd., Corner of Pyay Htaung Su Yeik Thar Rd."
                                       value="<?php echo $clinic_row["clinic_address"]; ?>">
                                <?= $errAddress; ?>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCity">City</label>
                                    <input type="text" name="inputCity" class="form-control <?= $classCity ?>"
                                           id="inputCity" placeholder="Yangon"
                                           value="<?php echo $clinic_row["clinic_city"]; ?>">
                                    <?= $errCity; ?>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputTownship">Township</label>
                                    <input type="text" name="inputTownship" class="form-control <?= $classState ?>"
                                           id="inputTownship" placeholder="Lanmadaw"
                                           value="<?php echo $clinic_row["clinic_state"]; ?>">
                                    <?= $errTownship; ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputZipCode">Zip Code</label>
                                    <input type="text" name="inputZipCode" class="form-control <?= $classZipcode ?>"
                                           id="inputZipCode" placeholder="11131"
                                           value="<?php echo $clinic_row["clinic_zipcode"]; ?>">
                                    <?= $errZipcode; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 mt-3">
                        <button type="submit" class="btn btn-primary btn-block" name="savebtn">Save</button>
                    </div>
                </form>
            </div>

            <div class="col-12">
                <hr>
                <h5 class="card-title mt-3">
                    Clinic Cover Image
                </h5>
                <form name="imgform" method="POST" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>"
                      enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" name="inputImageUpload[]" class="custom-file-input"
                                           id="inputImageUpload" multiple>
                                    <label class="custom-file-label" for="inputImageUpload">Choose file</label>
                                </div>
                                <div class="input-group-prepend">
                                    <button type="submit" name="uploadbtn" class="btn btn-primary btn-sm px-4"
                                            id="inputGroupFileImage">Upload
                                    </button>
                                </div>
                            </div>

                            <div class="row">
                                <?php
                                $table_result = mysqli_query($connection, "SELECT * FROM clinic_images WHERE clinic_id = " . $clinic_row['clinic_id'] . "");
                                $count = mysqli_num_rows($table_result);
                                if ($count == 0) {
                                    echo '<div class="col mt-2">
								<div class="text-center">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
								<h6 class="mt-2">No Image Available</h6>
								</div></div>';
                                } else {
                                    while ($table_row = mysqli_fetch_assoc($table_result)) {
                                        if (!empty($table_row["clinicimg_filename"])) {
                                            echo '<div class="col-sm-3">
										<img src="../uploads/' . $clinic_row["clinic_id"] . '/clinic/' . $table_row["clinicimg_filename"] . '" class="img-thumbnail" width="300px" alt="">
										</div>';
                                        } else {
                                            echo '<div class="col-sm-3">
										<img src="../assets/img/empty/empty-image.png" class="img-thumbnail" width="300px" alt="">
										</div>';
                                        }
                                    }
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

        </div>
        <!-- End Page Content -->
    </div>
    <?php include JS; ?>
    <script>
        $(function () {
            $('.timepicker').datetimepicker({
                format: 'LT'
            });
        });
    </script>
    </body>

    </html>
<?php
$currentLink = $_SERVER["REQUEST_URI"];

if (isset($_POST["uploadbtn"])) {
    $targetDir = "../uploads/" . $clinic_row['clinic_id'] . "/clinic" . "/";
    $allowTypes = array('jpg', 'png', 'jpeg');

    $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = "";
    if (!empty(array_filter($_FILES['inputImageUpload']['name']))) {
        foreach ($_FILES['inputImageUpload']['name'] as $key => $value) {
            // File upload path
            $fileName = basename($_FILES['inputImageUpload']['name'][$key]);
            $targetFilePath = $targetDir . $fileName;

            $folderpath = "../uploads/" . $clinic_row['clinic_id'] . "/clinic" . "/";
            if (!file_exists($folderpath)) {
                mkdir($folderpath, 0777, true);
            }

            // Check whether file type is valid
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            if (in_array($fileType, $allowTypes)) {
                // Upload file to server
                if (move_uploaded_file($_FILES["inputImageUpload"]["tmp_name"][$key], $targetFilePath)) {
                    // Image db insert sql
                    $insertValuesSQL .= "('" . $fileName . "', '" . $clinic_row['clinic_id'] . "'),";
                } else {
                    $errorUpload .= $_FILES['inputImageUpload']['name'][$key] . ', ';
                }
            }
        }

        if (!empty($insertValuesSQL)) {
            $insertValuesSQL = trim($insertValuesSQL, ',');
            $insert = $connection->query("INSERT INTO clinic_images (clinicimg_filename, clinic_id) VALUES $insertValuesSQL");
            if ($insert) {
                $errorUpload = !empty($errorUpload) ? 'Upload Error: ' . $errorUpload : '';
                $errorUploadType = !empty($errorUploadType) ? 'File Type Error: ' . $errorUploadType : '';
                $errorMsg = !empty($errorUpload) ? '<br/>' . $errorUpload . '<br/>' . $errorUploadType : '<br/>' . $errorUploadType;
                echo "<script>Swal.fire('Great!','Images are uploaded successfully!','success').then((result) => { if (result.value) { window.location.href = '" . $currentLink . "'; } });</script>";
            } else {
                echo "<script>Swal.fire('Oops...','there was an error uploading your file.','error')</script>";
            }
        }
    } else {
        echo "<script>Swal.fire('Oops...','Please upload a file.','error').then((result) => { if (result.value) { window.location.href = '" . $currentLink . "'; } });</script>";
    }
}
?>