<?php
include "header.php";
?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="d-flex align-items-center justify-content-between">
                <a class="btn btn-dark btn-sm" href="cc_home.php" style="">
                    <i class="fa-solid fa-home"></i> Home
                </a>
                <h5 class="m-0 text-center" style="flex:1;font-weight:600">Add Action Plan</h5>
                <input id="filter" type="text" class="form-control w-25" placeholder="Search here..."
                    style="height: 27px; font-size:12px;border:.5px solid black;border-radius:0px!important">
            </div>
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

            $select = "SELECT * FROM qc_ccrf where username =  $username order by id desc";
            $select_q = mysqli_query($conn, $select);
            $data = mysqli_num_rows($select_q);
            ?>

            <div class="table-responsive">
                <table class="table table-bordered mt-1" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">Action Plan</th>
                            <th scope="col">Code</th>
                            <th scope="col">Name</th>
                            <th scope="col">Department</th>
                            <th scope="col">Role</th>
                            <th scope="col">Date Initiate</th>
                            <th scope="col">Area of change</th>
                            <th scope="col">Dashboard</th>

                        </tr>
                    </thead>
                    <tbody class="searchable">
                        <?php
                        if ($data) {
                            while ($row = mysqli_fetch_array($select_q)) {

                                ?>
                                <tr>
                                    <td>
                                        <a href="cc_add_action_plan_user.php?id=<?php echo $row['id']; ?>"><button
                                                class="btn-input-text">
                                                <i class="fa-solid fa-pen"></i> Add Here
                                            </button></a>
                                    </td>
                                    <td><?php echo $row['code'] ?></td>
                                    <td><?php echo $row['username'] ?></td>
                                    <td><?php echo $row['user_department'] ?></td>
                                    <td><?php echo $row['user_role'] ?></td>
                                    <td><?php echo $row['i_date_initiated'] ?><br>
                                    <td><?php echo $row['i_area_of_change'] ?></td>
                                    <td>
                                        <a href="cc_dashboard_details.php?id=<?php echo $row['id']; ?>" class="btn-fixed-text">
                                            <i class="fa-solid fa-arrow-up" style=""></i> Dashboard
                                        </a>
                                    </td>

                                </tr>
                                <?php
                            }
                        } else {
                            echo "No record found!";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<?php
include "footer.php"
    ?>