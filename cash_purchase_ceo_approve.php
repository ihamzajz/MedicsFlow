<?php
session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id = $_GET['id'];
$email = $_GET['email'];
$user_name = $_GET['name'];

$approver_name = $_SESSION['fullname'];
$date = date('Y-m-d H:i:s');

$update = "UPDATE cash_purchase 
           SET ceo_status = 'Approved', 
               ceo_msg = 'Approved By $approver_name', 
               ceo_date = '$date' 
           WHERE id = $id";
$update_q = mysqli_query($conn, $update);

header("Location:cash_purchase_ceo_details?id=$id");
exit;
?>
