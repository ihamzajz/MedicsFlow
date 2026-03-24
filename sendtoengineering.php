<?php

session_start();
include 'dbconfig.php';

$id = $_GET['id'];

$update = "UPDATE workorder_form SET depart_type = 'Engineering' WHERE id = $id";
$update_q = mysqli_query($conn, $update);

if ($update_q) {
    header("Location: workorder_admin_estimatecost.php");
    exit(); // Ensure script stops after redirection
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

?>
