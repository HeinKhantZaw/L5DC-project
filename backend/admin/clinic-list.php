<?php
require_once('../config/autoload.php');
include('includes/path.inc.php');
include('includes/session.inc.php');
error_reporting(E_ALL);
ini_set('display_errors', 'on');

if (isset($_REQUEST['d']) && $_REQUEST['d'] == 'true') {
    $id = $_REQUEST['cid'];
    $decoded_id = base64_decode(urldecode($id));
    $sql = "DELETE FROM clinics WHERE clinic_id = '$decoded_id'";
    $connection->query($sql);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
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
            <!-- Card Content -->
            <div class="card">
                <div class="card-body">
                    <div class="card-inner">
                        <div class="data-tables">
                            <table id="datatable" class="table" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Clinic ID #</th>
                                    <th>Clinic Branch Name</th>
                                    <th>Phone Number</th>
                                    <th>Date Added</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $table_result = mysqli_query($connection, "SELECT * FROM clinics");
                                while ($table_row = mysqli_fetch_assoc($table_result)) {
                                    $id = $table_row["clinic_id"];
                                    $encrypt_id = urlencode(base64_encode($id));
                                    ?>
                                    <tr>
                                        <td><?php echo $table_row["clinic_id"]; ?></td>
                                        <td><?php echo $table_row["clinic_name"]; ?></td>
                                        <td><?php echo $table_row["clinic_contact"]; ?></td>
                                        <td><?php echo $table_row["date_created"]; ?></td>
                                        <td>
                                            <?php if ($table_row["clinic_status"] == "1") {
                                                echo '<span class="badge badge-success">Approved</span>';
                                            } else {
                                                echo '<span class="badge badge-danger">Not Approve</span>';
                                            } ?>
                                        </td>
                                        <td>
                                            <a href="clinic-view.php?cid=<?php echo $encrypt_id; ?>"
                                               class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a>
                                            <a href="clinic-edit.php?cid=<?php echo $encrypt_id; ?>"
                                               class="btn btn-sm btn-secondary"><i class="fa fa-pen"></i> Edit</a>
                                            <a data-toggle="modal" href="#deleteclinicid<?= $table_row["clinic_id"]; ?>"
                                               class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i> Delete</a>
                                        </td>
                                    </tr>
                                    <!--  Modal  -->
                                    <div class="modal fade" tabindex="-1" role="dialog"
                                         id="deleteclinicid<?= $table_row["clinic_id"]; ?>">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span
                                                                aria-hidden="true">&times;</span></button>
                                                </div>
                                                <form method="POST"
                                                      action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="inputDeleteID"
                                                               value="<?= $table_row["clinic_id"]; ?>">
                                                        <p>Are you sure you want to delete this clinic?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="deletebtn" class="btn btn-danger">
                                                            Delete
                                                        </button>
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- End Datatable -->
                    </div>
                </div>
            </div>
            <!-- End Card Content -->
        </div>
    </div>
    <!-- End Page Content -->
</div>

<?php include JS;
if (isset($_POST['deletebtn'])) {
    $clinicID = escape_input($_POST['inputDeleteID']);

    $delstmt = $connection->prepare("DELETE FROM clinics WHERE clinic_id = ?");
    $delstmt->bind_param("s", $clinicID);

    if ($delstmt->execute()) {
        echo '<script>
			Swal.fire({ title: "Great!", text: "Successfully Deleted!", type: "success" }).then((result) => {
				if (result.value) { window.location.href = "clinic-list.php"; }
			});
		</script>';
    } else {
        echo "Error<br>" . mysqli_error($connection);
    }
    $delstmt->close();
}
?>
</body>
</html>