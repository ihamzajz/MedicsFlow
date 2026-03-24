<?php

include 'dbconfig.php';
$id=$_GET['id'];
$delete="DELETE FROM bonus_form WHERE id = '$id'";
$delete_q=mysqli_query($conn,$delete);
header('location:bonus_userlist.php');

?>