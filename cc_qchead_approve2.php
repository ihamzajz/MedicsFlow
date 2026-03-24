<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id = $_GET['id'];
$date = date('Y-m-d H:i:s');
$reason = $_GET['reason'];

$update = "UPDATE qc_ccrf SET qchead_status2 = 'Approved', qchead_date2 = '$date', qchead_comment2 = '$reason' WHERE id = $id";
$update_q = mysqli_query($conn, $update);

header("Location:cc_qchead_list2.php");

?>
