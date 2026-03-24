<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id= $_GET['id'];
$name = $_SESSION['fullname'];
$date =  date('Y-m-d H:i:s');

$update="UPDATE staff_allocation SET head_status = 'Approved', head_date =  '$date', head_msg = 'Approved by $name' WHERE id = $id";
$update_q=mysqli_query($conn,$update);

header("Location:sa_head_list");

?>
