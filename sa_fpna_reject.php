<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id = $_GET['id'];
$name = $_SESSION['fullname'];
$date = date('Y-m-d H:i:s');
$reason = $_GET['reason'];

$update = "UPDATE staff_allocation SET fpna_status = 'Rejected', fpna_date = '$date', fpna_comments = '$reason', fpna_msg = 'Rejected by $name' WHERE id = $id";
$update_q = mysqli_query($conn, $update);

header("Location:sa_fpna_list");
exit();

?>
