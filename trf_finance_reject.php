<?php
session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id = $_GET['id'];
$approver_name = $_SESSION['fullname'];
$date = date('Y-m-d H:i:s');

// Update finance status
$update = "UPDATE trf 
           SET finance_status = 'Rejected',
               finance_msg = 'Rejected By $approver_name',
               finance_date = '$date' 
           WHERE id = $id";
$update_q = mysqli_query($conn, $update);

// Refresh the page with the same id
header("Location: trf_finance_details.php?id=$id");
exit();
?>
