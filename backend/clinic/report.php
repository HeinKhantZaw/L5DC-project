<?php
require_once('../config/autoload.php');
require_once('./includes/path.inc.php');
require_once('./includes/session.inc.php');

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $datefrom = $connection->real_escape_string($_POST['inputDateFrom']);
    $dateto = $connection->real_escape_string($_POST['inputDateTo']);

    if (empty($datefrom)) {
        array_push($errors, "Date From is required");
    }
    if (empty($dateto)) {
        array_push($errors, "Date Until is required");
    }
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
    <div class="row">
        <div class="col-12">
            <?php
            if ($clinic_row["clinic_status"] == 0) {
                echo '<div class="alert alert-danger mt-3" role="alert">
                            Sorry, the system administrator hasn&#39;t approved yet. Please wait until you&#39;re approved. 
                        </div>';
            } else { ?>
                <div class="card">
                    <div class="card-body">
                        <form name="report_frm" method="POST"
                              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <?php echo display_error(); ?>
                            <div class="form-group row">
                                <label for="inputDateFrom" class="col-sm-3 col-form-label text-right">From Date</label>
                                <div class="col-sm-6">
                                    <input type="text" name="inputDateFrom" class="form-control form-control-sm"
                                           id="datefrom">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputDateTo" class="col-sm-3 col-form-label text-right">To Date</label>
                                <div class="col-sm-6">
                                    <input type="text" name="inputDateTo" class="form-control form-control-sm"
                                           id="dateto">
                                </div>
                            </div>
                            <div class="d-flex justify-content-md-center pt-3">
                                <button type="clear" class="btn btn-light btn-sm px-5 mr-2" name="clearbtn">Clear
                                </button>
                                <button type="submit" class="btn btn-primary btn-sm px-5" name="generatebtn">Generate
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div id="responsecontainer"></div>

</div>
<?php include JS; ?>
<script>
    function print() {
        let divToPrint = document.getElementById('printContent');
        let newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
        newWin.document.close();
        setTimeout(function () {
            newWin.close();
        }, 10);
    }
</script>
<script type="text/javascript">
    $(function () {
        $('#datefrom').datetimepicker({
            format: 'YYYY-MM-DD',
        });
        $('#dateto').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: false,
        });

        $('#datefrom').on('dp.change', function (e) {
            $('#dateto').data('DateTimePicker').minDate(e.date);
        });
        $('#dateto').on('dp.change', function (e) {
            $('#datefrom').data('DateTimePicker').maxDate(e.date);
        });

    });
</script>
<script>
    function loadData(from, to) {
        $.ajax({
            type: "POST",
            data: {
                datefrom: from,
                dateto: to,
            },
            url: 'loadReport.php',
            dateType: "html",
            success: function (response) {
                $("#responsecontainer").html(response);
            }
        });
    }
</script>
<?php
if (isset($_POST['generatebtn'])) {
    if (count($errors) == 0) {
        ?>
        <script>
            loadData('<?=$datefrom?>', '<?= $dateto ?>')
        </script>
        <?php
    }
}
?>
</body>

</html>