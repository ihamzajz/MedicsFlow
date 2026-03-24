<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id = $_GET['id'];
$date = date('Y-m-d H:i:s');
$reason = mysqli_real_escape_string($conn, $_GET['reason']);
$approver_name = mysqli_real_escape_string($conn, $_SESSION['fullname']);

$update = "UPDATE new_hiring SET hod_status = 'Approved', hod_date = '$date', hod_comment = '$reason', hod_msg = 'Approved By $approver_name' WHERE id = $id";
$update_q = mysqli_query($conn, $update);

header("Location:new_hiring_form_head_list.php");

?>
