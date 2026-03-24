<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id = $_GET['id'];
$date = date('Y-m-d H:i:s');

$update = "UPDATE qc_ccrf SET i_classification_status2 = 'Critical' WHERE id = $id";
$update_q = mysqli_query($conn, $update);

header("Location:cc_qchead_list2.php");
// header("Location: cc_qchead_list2.php?status=critical_sent");
// exit();

?>
