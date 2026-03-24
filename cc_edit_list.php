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

$select = "SELECT * FROM qc_ccrf WHERE qchead_status = 'Approved' order by code desc";


$select_q = mysqli_query($conn, $select);
$data = mysqli_num_rows($select_q);
?>

<div class="d-flex align-items-center justify-content-between">
    <a class="btn btn-dark btn-sm" href="cc_home.php" style="">
        <i class="fa-solid fa-home"></i> Home
    </a>
    <h6 class="m-0 text-center" style="flex:1;font-weight:600">Change Control List - Edit</h6>
    <input id="filter" type="text" class="form-control w-25" placeholder="Search here..."
        style="height: 27px; font-size:12px;border:.5px solid black;border-radius:0px!important">
</div>

<div class="table-responsive">
    <table class="table table-bordered mt-1" id="myTable">
        <thead>
            <tr id="row_<?php echo $row['id']; ?>">
                <th scope="col" colspan="5">Edit Parts</th>
                <th scope="col">Code</th>
                <th scope="col">User</th>
                <th scope="col">Department</th>
                <th scope="col">Date Initiated</th>
                <th scope="col">Area of Change</th>
            </tr>
        </thead>

        <?php
        if ($data) {
            while ($row = mysqli_fetch_array($select_q)) {
                ?>
                <tbody class="searchable">
                    <tr id="row_<?php echo $row['id']; ?>">

                        <td>
                            <a href="cc_form2_edit.php?id=<?php echo $row['id']; ?>"><button class="btn-input-text">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                    Risk + Stock
                                </button></a>
                        </td>

                        <td>
                            <a href="cc_form3_edit.php?id=<?php echo $row['id']; ?>"><button class="btn-input-text">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                    Consequences + Revision
                                </button></a>
                        </td>

                        <td>
                            <?php if ($be_depart == 'it' or $be_depart == 'qaqc' or $be_depart == 'super') { ?>
                                <a href="cc_form4_edit.php?id=<?php echo $row['id']; ?>"><button class="btn-input-text">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                        Assign Department
                                    </button></a>

                            <?php } ?>
                        </td>


                         <td>
                            <?php if ($be_depart == 'it' or $be_depart == 'qaqc' or $be_depart == 'super') { ?>
                               <a href="cc_add_action_plan.php?id=<?php echo $row['id']; ?>">
                                    <button class="btn-input-text">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                        Action Plan
                                    </button>
                                </a>

                            <?php } ?>
                        </td>

                        <!-- <td>
                            <?php if ($be_depart == 'it' or $be_depart == 'qaqc' or $be_depart == 'super') { ?>
                                <a href="cc_qchead_list2.php"><button class="btn-input-text">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                        Mark Critical
                                    </button></a>

                            <?php } ?>
                        </td> -->

                        <td>
                            <?php if ($be_depart == 'it' or $be_depart == 'qaqc' or $be_depart == 'super') { ?>
                                <a href="cc_form6_edit.php?id=<?php echo $row['id']; ?>"><button class="btn-input-text" style="background-color: pink;">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                        Closing
                                    </button></a>

                            <?php } ?>
                        </td>
                        <td><?php echo $row['code'] ?> </td>
                        <td><?php echo $row['username'] ?></td>
                        <td><?php echo $row['user_department'] ?></td>
                        <td><?php echo $row['i_date_initiated'] ?> </td>
                        <td><?php echo $row['i_area_of_change'] ?> </td>

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