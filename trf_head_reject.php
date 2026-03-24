<?php
session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id = $_GET['id'];
$approver_name = $_SESSION['fullname'];
$date = date('Y-m-d H:i:s');

// Update head status
$update = "UPDATE trf 
           SET head_status = 'Rejected',
               head_msg = 'Rejected By $approver_name',
               head_date = '$date' 
           WHERE id = $id";
$update_q = mysqli_query($conn, $update);

// Refresh the page with the same id
header("Location: trf_head_details.php?id=$id");
exit();
?>
