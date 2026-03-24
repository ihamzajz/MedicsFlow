<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id=$_GET['id'];
$approver_name = $_SESSION['fullname'];
$date =  date('Y-m-d H:i:s');

$update="UPDATE newuserform SET hr_status = 'Rejected' ,hr_msg = 'Rejected By $approver_name',hr_date = '$date' WHERE id = $id";
$update_q=mysqli_query($conn,$update);

if ($update_q) {
    header("Location:newuserhr.php"); 
} else {
    header("Location:newuserhr.php"); 
}
?>
