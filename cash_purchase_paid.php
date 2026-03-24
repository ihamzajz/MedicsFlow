<?php
session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id = $_GET['id'];

$approver_name = $_SESSION['fullname'];
$date = date('Y-m-d H:i:s');

$update = "UPDATE cash_purchase 
           SET paid = 'yes'
           WHERE id = $id";
$update_q = mysqli_query($conn, $update);

header("Location:cash_purchase_finance_details?id=$id");
exit;
?>
