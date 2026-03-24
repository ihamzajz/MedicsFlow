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

// $select = "SELECT * FROM workorder_form where username = '$username'";
// $select = "SELECT * FROM qc_ccrf WHERE username = '$username' order by id desc";


if ($be_depart == 'super') {
    // Show all records
    $select = "SELECT * FROM qc_ccrf ORDER BY id DESC";
} else {
    // Old condition stays the same
   $select = "SELECT * FROM qc_ccrf WHERE username = '$username' order by id desc";
}   


$select_q = mysqli_query($conn, $select);
$data = mysqli_num_rows($select_q);
?>

<div class="d-flex align-items-center justify-content-between mb-1">
    <a class="btn btn-dark btn-sm" href="cc_home.php" style="">
        <i class="fa-solid fa-home"></i> Home
    </a>
    <h6 class="m-0 text-center " style="flex:1;font-weight:600">Request History</h6>
    <input id="filter" type="text" class="form-control w-25" placeholder="Search here..."
        style="height: 27px; font-size:12px;border:.5px solid black;border-radius:0px!important">
</div>
<div class="table-responsive">
    <table class="table w-100" id="myTable">
        <thead>
            <tr id="row_<?php echo $row['id']; ?>">
                <th scope="col" colspan="5">Edit Parts</th>
                <th scope="col">Action Plan</th>
                <th scope="col">Code</th>
                <th scope="col">User</th>
                <th scope="col">Department</th>
                <th scope="col">Date Initiated</th>
                <th scope="col">Area of Change</th>
                <th scope="col">Dashboard</th>
            </tr>
        </thead>
        <?php
        if ($data) {
            while ($row = mysqli_fetch_array($select_q)) {
        ?>
                <tbody class="searchable">
                    <tr id="row_<?php echo $row['id']; ?>">

                        <?php if ($row['qchead_status'] === 'Pending' or $be_depart == 'super') { ?>
                            <td>
                                <a href="cc_form2.php?id=<?php echo $row['id']; ?>">
                                    <button class="btn-input-text">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                        Risk + Stock
                                    </button>
                                </a>
                            </td>

                            <td>
                                <a href="cc_form3.php?id=<?php echo $row['id']; ?>">
                                    <button class="btn-input-text">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                        Consequences + Revision
                                    </button>
                                </a>
                            </td>

                            <td>
                                <a href="cc_form4.php?id=<?php echo $row['id']; ?>">
                                    <button class="btn-input-text">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                        Assign To Department
                                    </button>
                                </a>
                            </td>

                        <?php } elseif ($row['qchead_status'] === 'Approved' ) { ?>
                            <td colspan="3" class="text-muted">
                                <i class="fa-solid fa-lock"></i>
                                Editing disabled — QC Head has approved this form
                            </td>

                        <?php } elseif ($row['qchead_status'] === 'Rejected') { ?>
                            <td colspan="3" class="text-muted">
                                <i class="fa-solid fa-ban"></i>
                                Editing disabled — QC Head has rejected this form
                            </td>
                        <?php } else { ?>
                            <td colspan="3" class="text-muted">
                                <i class="fa-solid fa-circle-question"></i>
                                Status unknown
                            </td>
                        <?php } ?>

            
                        <td>
                            <?php if ($row['status'] === 'Open' or $be_depart == 'super') : ?>
                                <a href="cc_add_action_plan.php?id=<?php echo $row['id']; ?>">
                                    <button class="btn-input-text">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                        Action Plan
                                    </button>
                                </a>
                            <?php else : ?>
                                <span class="text-danger fw-bold">
                                    <i class="fa-solid fa-lock"></i>Form Closed
                                </span>
                            <?php endif; ?>
                        </td>


                        <td><?php echo $row['code'] ?> </td>
                        <td><?php echo $row['username'] ?></td>
                        <td><?php echo $row['user_department'] ?></td>
                        <td><?php echo $row['i_date_initiated'] ?> </td>
                        <td><?php echo $row['i_area_of_change'] ?> </td>
                        <!-- <td>
                                        <a href="cc_dashboard_details.php?id=<?php echo $row['id']; ?>" class="btn btn-fixed-text" style="font-size:11px!important;font-weight:500!important;letter-spacing:0.5px!important;background-color:#129990;border-radius:15px!important">
                                        <i class="fa-solid fa-arrow-up"></i> Dashboard 
                                        </a>
                                    </td> -->
                        <td>
                            <a href="cc_dashboard_details.php?id=<?php echo $row['id']; ?>" class="btn btn-fixed-text">
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
</div>
<?php
include "footer.php"
?>