<?php
include 'dbconfig.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $delete = "DELETE FROM assets WHERE id = $id";
    $delete_q = mysqli_query($conn, $delete);

    if ($delete_q) {
        header("Location: assets_list.php?delete_success=1");
    } else {
        header("Location: assets_list.php?delete_error=1");
    }
}

mysqli_close($conn);
?>
