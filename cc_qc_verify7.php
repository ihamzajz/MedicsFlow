<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id = $_GET['id'];
$fname = $_SESSION['fullname']; // from session
$date = date('d-m-Y');

$update = "UPDATE qc_ccrf2 SET f_verify_by_7 = 'Verified' WHERE id = $id";
$update_q = mysqli_query($conn, $update);

// Set a success message in session

// Redirect back to the form with the same ID
header("Location: cc_add_action_plan.php?id=$id");
?>
