<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id = $_GET['id'];
$date = date('Y-m-d H:i:s');

$update = "UPDATE qc_ccrf SET ceo_status = 'Approved', ceo_date = '$date' WHERE id = $id";
$update_q = mysqli_query($conn, $update);

header("Location:cc_ceo_list.php");

?>
