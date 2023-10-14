<?php
require_once('../config/autoload.php');
require_once('./includes/path.inc.php');
include('../utils/select_helper.php');
error_reporting(E_ALL);
ini_set('display_errors', 'on');

if ($_SESSION["cliniclogin"] != 1)
    header("Location: register.php");

$sess_email = $_SESSION["session_staff_email"];
$result1 = mysqli_query($connection, "SELECT * FROM clinic_staff WHERE staff_email = '" . $sess_email . "' ");
$row1 = mysqli_fetch_assoc($result1);
$clinic_id = $row1["clinic_id"];

$result = mysqli_query($connection, "SELECT * FROM clinics WHERE clinic_id = '" . $clinic_id . "' ");
$row = mysqli_fetch_assoc($result);
ob_start();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include CSS; ?>
        <link rel="stylesheet" href="../assets/css/clinic/style.css">
    </head>

    <body>
    <div class="container">
        <div class="title text-center mt-5">
            <h3><a href="login.php"><?php echo $BRAND_NAME; ?></a></h3>
        </div>
        <form name="registerForm" id="registerForm" method="POST"
              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <ul class="timeline mb-5" id="timeline">
                <li class="li">
                    <div class="timestamp">
                        <span class="frame">Step 1</span>
                    </div>
                    <div class="status">
                        <h4>Detail</h4>
                    </div>
                </li>
                <li class="li">
                    <div class="timestamp">
                        <span class="frame">Step 2</span>
                    </div>
                    <div class="status">
                        <h4>Contact</h4>
                    </div>
                </li>
                <li class="li">
                    <div class="timestamp">
                        <span class="frame">Step 3</span>
                    </div>
                    <div class="status">
                        <h4>Location</h4>
                    </div>
                </li>
            </ul>

            <div class="register-wrap">
                <!-- Details -->
                <div class="tab">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputClinicName">Clinic Branch Name</label>
                            <input type="text" name="inputClinicName" class="form-control input" id="inputClinicName"
                                   placeholder="Enter Name" value="<?php echo $row["clinic_name"]; ?>">
                        </div>
                    </div>
                    <label for="inputBusinessHour">Business Hour</label>
                    <div class="mb-3">
                        <small class="text-muted">If the clinic is closed on a certain day, just leave the hours
                            blank.</small>
                    </div>
                    <div class="form-group row">
                        <label for="inputBusinessHourWeek" class="col-sm-2 col-form-label text-right">Monday -
                            Friday</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control timepicker" name="inputOpensHourWeek">
                        </div>
                        <span>--</span>
                        <div class="col-sm-4">
                            <input type="text" class="form-control timepicker" name="inputCloseHourWeek">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputBusinessHourSat" class="col-sm-2 col-form-label text-right">Saturday</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control timepicker" name="inputOpensHourSat">
                        </div>
                        <span>--</span>
                        <div class="col-sm-4">
                            <input type="text" class="form-control timepicker" name="inputCloseHourSat">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputBusinessHourSun" class="col-sm-2 col-form-label text-right">Sunday</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control timepicker" name="inputOpensHourSun">
                        </div>
                        <span>--</span>
                        <div class="col-sm-4">
                            <input type="text" class="form-control timepicker" name="inputCloseHourSun">
                        </div>
                    </div>
                </div>

                <!-- Contact -->
                <div class="tab">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputContact">Contact Number*</label>
                            <input type="text" name="inputContact" class="form-control input" id="inputContact"
                                   placeholder="Enter Phone Number" value="<?php echo $row["clinic_contact"]; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmailAddress">Email Address*</label>
                            <input type="text" name="inputEmailAddress" class="form-control input"
                                   id="inputEmailAddress" placeholder="Enter Email Address"
                                   value="<?php echo $row["clinic_email"]; ?>">
                        </div>
                    </div>
                </div>

                <!-- Location -->
                <div class="tab">
                    <div class="form-group">
                        <label for="inputAddress">Address</label>
                        <input type="text" name="inputAddress" class="form-control input" id="inputAddress"
                               onfocus="geolocate()" oninput="map_marker()"
                               placeholder=" 24, Baho Rd., Corner of Pyay Htaung Su Yeik Thar Rd."
                               value="<?php echo $row["clinic_address"]; ?>">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">City</label>
                            <input type="text" name="inputCity" class="form-control input" id="inputCity"
                                   placeholder="Yangon"
                                   oninput="map_marker()" value="<?php echo $row["clinic_city"]; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputTownship">Township</label>
                            <input type="text" name="inputTownship" class="form-control input" id="inputTownship"
                                   placeholder="Lanmadaw"
                                   oninput="map_marker()" value="<?php echo $row["clinic_state"]; ?>">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputZipCode">Zip Code</label>
                            <input type="text" name="inputZipCode" class="form-control input" id="inputZipCode"
                                   placeholder="11131"
                                   oninput="map_marker()" value="<?php echo $row["clinic_zipcode"]; ?>">
                        </div>
                    </div>
                    <div class="form-group map-container">
                        <script>
                            function map_marker() {
                                let street = document.getElementById("inputAddress").value;
                                let city = document.getElementById("inputCity").value;
                                let state = document.getElementById("inputTownship").value;
                                let country = "Myanmar";
                                let zipcode = document.getElementById("inputZipCode").value;
                                let address = "" + city + " " + state + " " + country + "";
                                let q = encodeURIComponent(address);
                                document.getElementById("map").innerHTML = "<iframe width='100%' height='450' frameborder='0' style='border:0' src='https://www.google.com/maps/embed/v1/place?key=AIzaSyAGx-OjyNn10KsJ_OsE7cl2_qxg6mNBZyI&q=" + street + "," + city + "," + state + "," + zipcode + "+Myanmar' allowfullscreen></iframe>";
                            }
                        </script>
                        <div id="map"></div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <div class="row">
                    <div class="col-6">
                        <button type="button" class="btn btn-primary btn-block" id="prevBtn" onclick="nextPrev(-1)">
                            Previous
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-primary btn-block" id="nextBtn" onclick="nextPrev(1)">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php include JS; ?>
    <script>
        $('#upload').change(function () {
            $('#preview').htm("");
            let totalFile = document.getElementById("inputGroupFileImage").files.length;

            for (let i = 0; i < totalFile; i++) {
                $('#preview').append("<img src='" + URL.createObjectURL(event.target.files[i]) + "'>");
            }
        });
    </script>
    <script>
        let currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form ...
            let x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            // ... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            // ... and run a function that displays the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            let x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            currentTab = currentTab + n;
            if (currentTab >= x.length) {
                document.getElementById("registerForm").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            let x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByClassName("input")
            for (i = 0; i < y.length; i++) {
                if (y[i].value == "") {
                    y[i].className += " invalid";
                    valid = false;
                }
            }
            if (valid) {
                document.getElementsByClassName("li")[currentTab].className += " complete";
            }
            return valid;
        }

        function fixStepIndicator(n) {
            let i, x = document.getElementsByClassName("li");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            x[n].className += " active";
            x[n].className = x[n].className.replace(" complete", "");
        }
    </script>
    <script>
        $(function () {
            $('.timepicker').datetimepicker({
                format: 'LT'
            });
        });
    </script>

    <script>
        // src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAGx-OjyNn10KsJ_OsE7cl2_qxg6mNBZyI&q=Space+Needle,Seattle+WA"
        // This example displays an address form, using the autocomplete feature
        // of the Google Places API to help users fill in the information.

        // This example requires the Places library. Include the libraries=places
        // parameter when you first load the API. For example:
        // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

        let placeSearch, autocomplete;
        let componentForm = {
            street_number: 'short_name',
            route: 'long_name',
            locality: 'long_name',
            administrative_area_level_1: 'short_name',
            country: 'long_name',
            postal_code: 'short_name'
        };

        function initAutocomplete() {
            // Create the autocomplete object, restricting the search to geographical
            // location types.
            autocomplete = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */
                (document.getElementById('autocomplete')), {
                    types: ['geocode']
                });

            // When the user selects an address from the dropdown, populate the address
            // fields in the form.
            autocomplete.addListener('place_changed', fillInAddress);
        }

        function fillInAddress() {
            // Get the place details from the autocomplete object.
            let place = autocomplete.getPlace();

            for (let component in componentForm) {
                document.getElementById(component).value = '';
                document.getElementById(component).disabled = false;
            }

            // Get each component of the address from the place details
            // and fill the corresponding field on the form.
            for (let i = 0; i < place.address_components.length; i++) {
                let addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    let val = place.address_components[i][componentForm[addressType]];
                    document.getElementById(addressType).value = val;
                }
            }
        }

        // Bias the autocomplete object to the user's geographical location,
        // as supplied by the browser's 'navigator.geolocation' object.
        function geolocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    let geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    let circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    autocomplete.setBounds(circle.getBounds());
                });
            }
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfDjL3bKUl1fLdby_vhWimMejbVecejpc&libraries=places&callback=initAutocomplete"
            async defer></script>

    </body>

    </html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = "0";
    $clinic_name = escape_input($_POST["inputClinicName"]);

    $weekopen = escape_input($_POST["inputOpensHourWeek"]);
    $weekclose = escape_input($_POST["inputCloseHourWeek"]);
    $satopen = escape_input($_POST["inputOpensHourSat"]);
    $satclose = escape_input($_POST["inputCloseHourSat"]);
    $sunopen = escape_input($_POST["inputOpensHourSun"]);
    $sunclose = escape_input($_POST["inputCloseHourSun"]);

    $contact = escape_input($_POST["inputContact"]);
    $email = escape_input($_POST["inputEmailAddress"]);
    $address = escape_input($_POST["inputAddress"]);
    $city = escape_input($_POST["inputCity"]);
    $township = escape_input($_POST["inputTownship"]);
    $zipcode = escape_input($_POST["inputZipCode"]);

    // Check Email Valid
    $clinicstmt = $connection->prepare("SELECT * FROM clinics WHERE clinic_email = ?");
    $clinicstmt->bind_param("s", $email);
    $clinicstmt->execute();
    $clinicresult = $clinicstmt->get_result();
    $clinicstmt->free_result();

    $businessstmt = $connection->prepare("UPDATE business_hour SET open_week = ?, close_week = ?, open_sat = ?, close_sat = ?, open_sun = ?, close_sun = ? WHERE clinic_id = ?");
    $businessstmt->bind_param("sssssss", $weekopen, $weekclose, $satopen, $satclose, $sunopen, $sunclose, $clinic_id);
    $businessstmt->execute();

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($clinicresult->num_rows != 0) {
        echo "<script>Swal.fire({title: 'Error!', text: 'Email Already Exist', type: 'error', confirmButtonText: 'Try Again'})</script>";
        exit();
    }

    $updatestmt = $connection->prepare("UPDATE clinics SET clinic_name = ?, clinic_email = ?, clinic_contact = ?, clinic_address = ?, clinic_city = ?, clinic_state = ?, clinic_zipcode = ?, clinic_status = ? WHERE clinic_id = ?");
    $updatestmt->bind_param("sssssssss", $clinic_name, $email, $contact, $address, $city, $township, $zipcode, $status, $clinic_id);

    if ($updatestmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }

    ob_end_flush();
    mysqli_close($connection);
}
?>