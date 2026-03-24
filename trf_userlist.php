<?php
include "header.php";
?>
<div class="container-fluid">
    <div class="row">
        <div class="col"></div>
        <div class="d-flex align-items-center justify-content-between pt-5">
            <a class="btn btn-home" href="trf_home.php" style="">
                <i class="fa-solid fa-home"></i> Home
            </a>
            <h5 class="m-0 text-center" style="flex:1;font-weight:600">Request History</h5>
            <input id="filter" type="text" class="form-control w-25" placeholder="Search here..."
                style="height: 27px; font-size:12px;border:.5px solid black;border-radius:0px!important">
        </div>
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

        $select = "SELECT * FROM trf WHERE username = '$username' ORDER BY date DESC";

        $select_q = mysqli_query($conn, $select);
        $data = mysqli_num_rows($select_q);
        ?>

        <div id="dataTableCont">
            <table class="table table-responsive table-bordered mt-1" id="myTable">
                <thead class="thead-dark">
                    <tr id="row_<?php echo $row['id']; ?>">
                        <th scope="col">Detail</th>
                        <th scope="col">Id </th>
                        <th scope="col">Name</th>
                        <th scope="col">Department</th>
                        <th scope="col">Role</th>
                        <th scope="col">Date</th>
                        <th scope="col">Dest. From</th>
                        <th scope="col">Dest. To</th>
                        <th scope="col">Head</th>
                        <th scope="col">Admin </th>
                        <th scope="col">Finance</th>
                    </tr>
                </thead>

                <?php
                if ($data) {
                    while ($row = mysqli_fetch_array($select_q)) {
                        ?>
                        <tbody class="searchable">
                            <tr id="row_<?php echo $row['id']; ?>">
                                <td>
                                    <a href="trf_userlist_details.php?id=<?php echo $row['id']; ?>" class="btn-fixed-text">
                                        <i class="fa-solid fa-arrow-up" style=""></i> Details
                                    </a>
                                </td>
                                <td><?php echo $row['id'] ?> </td>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['department'] ?></td>
                                <td><?php echo $row['role'] ?></td>
                                <td><?php echo $row['date'] ?></td>

                                <td><?php echo $row['to_1'] ?></td>
                                <td><?php echo $row['to_2'] ?></td>
                                <td><?php echo $row['head_msg'] ?></td>
                                <td><?php echo $row['admin_msg'] ?></td>
                                <td><?php echo $row['finance_msg'] ?></td>




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