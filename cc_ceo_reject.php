<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id = $_GET['id'];
$date = date('Y-m-d H:i:s');
$reason = $_GET['reason'];

$update = "UPDATE qc_ccrf SET ceo_status = 'Rejected', ceo_date = '$date', reject_reason3 = '$reason' WHERE id = $id";
$update_q = mysqli_query($conn, $update);

// Redirect to the work order list page
header("Location:cc_ceo_list.php");
exit;

?>
