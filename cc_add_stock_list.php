<?php
include "header.php";
?>
<?php

include 'dbconfig.php';


$id = $_SESSION['id'];
$fullname = $_SESSION['fullname'];
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$email = $_SESSION['email'];
$gender = $_SESSION['gender'];
$department = $_SESSION['department'];
$role = $_SESSION['role'];
$added_date = $_SESSION['added_date'];


$select = "SELECT * FROM qc_ccrf order by code desc ";

$select_q = mysqli_query($conn, $select);
$data = mysqli_num_rows($select_q);
?>

<div class="d-flex align-items-center justify-content-between">
    <a class="btn btn-dark btn-sm" href="cc_home.php" style="">
        <i class="fa-solid fa-home"></i> Home
    </a>
    <h6 class="m-0 text-center" style="flex:1;font-weight:600">Change Control List - Add Stock</h6>
    <input id="filter" type="text" class="form-control w-25" placeholder="Search here..."
        style="height: 27px; font-size:12px;border:.5px solid black;border-radius:0px!important">
</div>

<div class="table-responsive">
    <table class="table table-bordered mt-1" id="myTable">
        <thead>
            <tr>
                <th scope="col">Add Stock</th>
                <th scope="col">Code</th>
                <th scope="col">User</th>
                <th scope="col">Department</th>
                <th scope="col">Date Initiated</th>
                <th scope="col">Area of Change</th>
                <th>Dashboard</th>
            </tr>
        </thead>
        <?php
        if ($data) {
            while ($row = mysqli_fetch_array($select_q)) {
                ?>
                <tbody class="searchable">
                    <tr id="row_<?php echo $row['id']; ?>">
                        <td>
                            <a href="cc_add_stock.php?id=<?php echo $row['id']; ?>"><button class="btn-input-text">
                                    <i class="fa-solid fa-pen"></i> Add Stock
                                </button></a>
                        </td>
                        <td><?php echo $row['code'] ?> </td>
                        <td><?php echo $row['username'] ?></td>
                        <td><?php echo $row['user_department'] ?></td>
                        <td><?php echo $row['i_date_initiated'] ?> </td>
                        <td><?php echo $row['i_area_of_change'] ?> </td>
                        <td>
                            <a href="cc_dashboard_details.php?id=<?php echo $row['id']; ?>" class="btn-fixed-text">
                                <i class="fa-solid fa-arrow-up" style=""></i> Dashboard
                            </a>
                        </td>
                    </tr>
                </tbody>
                <?php
            }
        } else {
            echo "No record found!";
        }
        ?>
    </table>
</div>

</div> 
</div> 


<?php
include "footer.php"
    ?>