<?php
require_once('../config/autoload.php');
require_once('./includes/path.inc.php');
require_once('./includes/session.inc.php');

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = escape_input($_POST['inputTitle']);
    $content = escape_input($_POST['inputContent']);

    if (empty($title)) {
        array_push($errors, "Title is required");
    }
    if (empty($content)) {
        array_push($errors, "Content is required");
    }

    if (count($errors) == 0 && $clinic_row["clinic_status"] != 0) {
        $statement = $connection->prepare("INSERT INTO announcement (ann_title, ann_content, date_created, clinic_id) VALUES (?,?,?,?)");
        $statement->bind_param("sssi", $title, $content, $date_created, $clinic_row['clinic_id']);
        if ($statement->execute()) {
            header('Location: announcement.php');
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($connection);
        }
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
    <!-- Page content -->
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
                        <form name="announce_frm" method="POST"
                              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <?php echo display_error(); ?>
                            <div class="form-group">
                                <input type="text" name="inputTitle" class="form-control form-control-sm"
                                       id="inputTitle" placeholder="Title">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="inputContent" id="inputContent" rows="3"
                                          placeholder="New Announcement"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm px-5 pull-right" name="postbtn">Post
                            </button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php
    function total_time_elapsed($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    $table_result = mysqli_query($connection, "SELECT * FROM announcement WHERE clinic_id = " . $clinic_row['clinic_id'] . "");
    $count = mysqli_num_rows($table_result);
    if ($clinic_row["clinic_status"] != 0) {
        if ($count == 0) {
            print '<div class="card text-center"><div class="card-body"><h6>No Results Available</h6></div></div>';
        } else {
            while ($table_row = mysqli_fetch_assoc($table_result)) {
                echo '<div class="card">
                <div class="card-header">
                    <div class="d-flex w-100 justify-content-between">
                        <span>' . $table_row["ann_title"] . '</span>
                        <small>' . total_time_elapsed($table_row['date_created']) . '</small>
                    </div>
                </div>
                <div class="card-body">
                    ' . $table_row["ann_content"] . '
                </div>
            </div>';
            }
        }
    }
    ?>
    <!-- End Page Content -->
</div>
<?php include JS; ?>
</body>

</html>