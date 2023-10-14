<?php
include('../config/autoload.php');
include('./includes/path.inc.php');
include('./includes/session.inc.php');
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="data-tables">
                            <?php
                            function headerTable()
                            {
                                $header = array("Doctor Name", "Speciality", "Contact", "Email", "Date Added", "Action");
                                for ($i = 0; $i < count($header); $i++) {
                                    echo "<th>" . $header[$i] . "</th>" . PHP_EOL;
                                }
                            }

                            ?>
                            <table id="datatable" class="table" style="width:100%">
                                <thead>
                                <tr>
                                    <?= headerTable(); ?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $tresult = $connection->query("SELECT * FROM doctors LEFT JOIN speciality ON doctors.doctor_speciality = speciality.speciality_id");
                                if ($tresult->num_rows === 0) {
                                    echo '<div>No Doctor Record</div>';
                                } else {
                                    while ($row = $tresult->fetch_assoc()) { ?>
                                        <tr>
                                            <td>Dr. <?= $row["doctor_firstname"] . ' ' . $row["doctor_lastname"] ?></td>
                                            <td><?= $row["speciality_name"] ?></td>
                                            <td><?= $row["doctor_contact"] ?></td>
                                            <td><?= $row["doctor_email"] ?></td>
                                            <td><?= $row["date_created"] ?></td>
                                            <td>
                                                <a data-toggle="modal"
                                                   href="#deletedoctorid<?= $row["doctor_id"]; ?>"
                                                   class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i>
                                                    Delete</a>
                                            </td>
                                        </tr>
                                        <!-- Delete Modal -->
                                        <div class="modal fade" tabindex="-1" role="dialog"
                                             id="deletedoctorid<?= $row["doctor_id"]; ?>">
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
                                                                   value="<?= $row["doctor_id"]; ?>">
                                                            <p>Are you sure you want to remove this doctor?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="deletebtn"
                                                                    class="btn btn-danger">Delete
                                                            </button>
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- End Datatable -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
    <?php include JS; ?>
    </body>

    </html>
<?php
if (isset($_POST["deletebtn"])) {
    $id = escape_input($_POST["inputDeleteID"]);
    $delstmt = $connection->prepare("DELETE FROM doctors WHERE doctor_id = ?");
    $delstmt->bind_param("s", $id);

    if ($delstmt->execute()) {
        echo '<script>
			Swal.fire({ title: "Great!", text: "Successfully Deleted!", type: "success" }).then((result) => {
				if (result.value) { window.location.href = "doctor-list.php"; }
			});
		</script>';
    } else {
        echo "Error:<br>" . mysqli_error($connection);
    }
    mysqli_close($connection);
}
?>