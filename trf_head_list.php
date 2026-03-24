<?php
include "header.php";
?>
<?php
include 'dbconfig.php';
$id = $_SESSION['id'];
$name = $_SESSION['fullname'];
$email = $_SESSION['email'];
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$gender = $_SESSION['gender'];
$department = $_SESSION['department'];
$role = $_SESSION['role'];
$email = $_SESSION['email'];

$be_depart = $_SESSION['be_depart'];
$bc_role = $_SESSION['be_role'];

// $select = "SELECT * FROM trf WHERE department = '$department' AND
// head_status = 'Pending'
//  ORDER BY date DESC";

$select = "SELECT * FROM trf WHERE 
                department = '$department'
                ORDER BY date DESC";

$select_q = mysqli_query($conn, $select);
$data = mysqli_num_rows($select_q);
?>


<div class="d-flex align-items-center justify-content-between">
    <a class="btn btn-home" href="trf_home.php" style="">
        <i class="fa-solid fa-home"></i> Home
    </a>
    <h5 class="m-0 text-center" style="flex:1;font-weight:600">Head Approval</h5>
    <input id="filter" type="text" class="form-control w-25" placeholder="Search here..."
        style="height: 27px; font-size:12px;border:.5px solid black;border-radius:0px!important">
</div>

<div id="dataTableCont" class=" table-responsive">
    <table class="table table-bordered mt-1" id="myTable">
        <thead style="background-color:#8576FF;color:white">
            <tr id="row_<?php echo $row['id']; ?>">
                <th colspan="2">Action</th>
                <th scope="col">Id </th>
                <th scope="col">Name</th>
                <th scope="col">Department</th>
                <th scope="col">Role</th>
                <th scope="col">Date</th>

                <th scope="col">Dest. To</th>
                <th scope="col">Dest. From</th>

                <th scope="col">View&nbsp;Detail</th>
            </tr>
        </thead>

        <?php
        if ($data) {
            while ($row = mysqli_fetch_array($select_q)) {
                ?>
                <tbody class="searchable">
                    <tr id="row_<?php echo $row['id']; ?>">
                        <td><a href="trf_head_approve.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email']; ?>&name=<?php echo $row['name']; ?>"
                                class="btn-approve"><i class="fa-solid fa-check"></i> Approve</a></td>
                        <td><a href="trf_head_reject.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email']; ?>&name=<?php echo $row['name']; ?>"
                                class="btn-reject"><i class="fa-solid fa-xmark"></i> Reject</a></td>
                        <td><?php echo $row['id'] ?> </td>
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['department'] ?></td>
                        <td><?php echo $row['role'] ?></td>
                        <td><?php echo $row['date'] ?></td>

                        <td><?php echo $row['to_1'] ?></td>
                        <td><?php echo $row['to_2'] ?></td>
                        <td>
                            <a href="trf_head_details.php?id=<?php echo $row['id']; ?>"><button class="btn-fixed-text">
                                    View Details
                                </button></a>
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
<!--ander ka kaam khatam-->

</div> <!--page content-->
</div> <!--wrapper-->

<?php
include "footer.php"
    ?>