<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id = $_GET['id'];
$date = date('Y-m-d H:i:s');
$reason = $_GET['reason'];

$update = "UPDATE new_product_idea SET bd_status = 'Rejected', bd_date = '$date', bd_remarks2 = '$reason' WHERE id = $id";
$update_q = mysqli_query($conn, $update);

// Redirect to the work order list page
header("Location:newproductidea_bd_list.php");
exit;

?>
