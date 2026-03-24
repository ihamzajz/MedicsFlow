<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id = $_GET['id'];
$date = date('Y-m-d H:i:s');
$reason = mysqli_real_escape_string($conn, $_GET['reason']);
$approver_name = mysqli_real_escape_string($conn, $_SESSION['fullname']);

$update = "UPDATE new_hiring SET hr_status = 'Rejected', hr_date = '$date', hr_comment = '$reason', hr_msg = 'Rejected By $approver_name' WHERE id = $id";
$update_q = mysqli_query($conn, $update);

header("Location:new_hiring_form_hr_list.php");

?>
