<?php
session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id = $_GET['id'];
$approver_name = $_SESSION['fullname'];
$date = date('Y-m-d H:i:s');

// Update admin status
$update = "UPDATE trf 
           SET admin_status = 'Rejected',
               admin_msg = 'Rejected By $approver_name',
               admin_date = '$date' 
           WHERE id = $id";
$update_q = mysqli_query($conn, $update);

// Refresh the page with the same id
header("Location: trf_admin_details.php?id=$id");
exit();
?>
