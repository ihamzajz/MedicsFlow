<?php
session_start();


if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php'); // Redirect to the login page
    exit;
}

$head_email = $_SESSION['head_email'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Performance Evaluation</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
     <?php
   include 'cdncss.php'
      ?>

    <!-- fevicon -->
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
    <style>
              a{
        text-decoration:none!important
    }
    body {
        font-family: 'Poppins', sans-serif;
    }

        .table2-2 td {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            font-size: 11px !important;
        }

        .btn-submit {
            font-size: 15px !important;
            color: white;
            background-color: #0D9276;
            padding: 5px 35px;
            border-radius: 2px;
            border: 2px solid #0D9276;
            letter-spacing: 1px;
            font-weight: 500;
            transition: all 0.3s ease;
            /* Smooth transition effect */
        }

        .btn-submit:hover {
            color: #0D9276;
            background-color: white;
            border: 2px solid #0D9276;
        }

        .btn {
            font-size: 11px !important;
            border-radius: 0px !important
        }

        a {
            text-decoration: none !important;
        }

        .table-container {
            overflow-y: auto;
            height: 90vh;
            /* Full viewport height */
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            font-size: 12px !important;
            border: none !important;
            background-color: #1B7BBC !important;
            color: white !important;
            font-weight: 500;
        }

        table td {
            font-size: 12px;
            color: black;
            padding: 0px !important;
            /* Adjust padding as needed */
            /* border: 1px solid #ddd; */
        }

        .table_add_service th {
            background-color: white !important;
            color: black !important;
            font-size: 14px !important;
        }

        input {
            width: 100% !important;
            font-size: 12px;
            border-radius: 0px !important;
            border: 1px solid black !important;
            transition: border-color 0.3s ease;
            padding: 5px 5px;
            letter-spacing: 0.4px;
            height: 25px !important;
        }

        input:focus {
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
        }

        p {
            font-size: 13px !important;
        }

        li {
            font-size: 13px !important;
        }

        .table1-1 th,
        .table1-2 th {
            border: 1px solid #1B7BBC !important;
        }

        .table1-1 td,
        .table1-2 td {
            font-size: 12.5px !important;
            padding: 5px !important;
            border: 1px solid black !important;
        }

        .table2-1 td,
        .table2-2 td,
        .table2-3 td {
            font-size: 12.3px !important;
            padding: 5px !important;
        }

        .table2-1 td,
        .table2-2 td,
        .table2-3 td {
            font-size: 12.5px !important;
            padding: 5px !important;
        }

        .table3-1 th {
            border: 1px solid #1B7BBC !important;
        }
    </style>
    <style>
        .pagination-scroll {
            overflow-x: auto;
            /* Enable horizontal scrolling */
            white-space: nowrap;
            /* Prevent wrapping of pagination buttons */
            width: 100%;
            /* Full width of the parent container */
        }

        #pagination-controls {
            display: inline-block;
            /* Ensure the pagination controls are displayed inline to enable scrolling */
        }
    </style>
    <style>
        .nav-tabs .nav-link {
            background-color: white;
            border: 1px solid black;
            color: black;
            border-radius: 0;
            margin-right: 2px;
            padding: 8px 15px;
            transition: background-color 0.3s ease;
            font-size: 12px;
        }

        /* Hover effect for inactive tabs */
        .nav-tabs .nav-link:hover {
            background-color: #f0f0f0;
            /* light grey */
            border: 1px solid black;
            /* keep border on hover */
            color: black;
        }

        /* Active tab */
        .nav-tabs .nav-link.active {
            background-color: #8ABB6C;
            color: white;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            border: 1px solid #8ABB6C;
        }


       .slide {
            position: relative;
            overflow: hidden;
            background-color: #34e4ea;
            border: 1.5px solid black;
            color: black;
            font-weight: 600;
            border-radius: 1px;
            cursor: pointer;
            padding: 0 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 16px!important;
            font-weight: 500;
        }
        .text {
            position: relative;
            z-index: 2;
            transition: color 0.4s ease;
        }
        .slide::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 130%;
            height: 100%;
            background-color: white;
            /* white overlay */
            transform: translateX(-110%) skew(-30deg);
            transition: transform 0.5s ease;
            z-index: 1;
            
        }
        .slide:hover::before {
            transform: translateX(-5%) skew(-15deg);
        }
        .slide:hover .text {
            color: black;
        }
    </style>


<style>
          .bg-menu {
         background-color: #393E46 !important;
         border-radius: 0px !important;
      }

      .btn-menu {
         font-size: 12.5px;
         background-color: #FFB22C !important;
         padding: 5px 10px;
         font-weight: 600;
         border: none !important;
      }
</style>
    <?php
    include 'sidebarcss.php'
        ?>
</head>

<body>
    <div class="wrapper">
        <?php
        include 'sidebar1.php';
        ?>
        <!-- Page Content  -->
        <div id="content">
            <!-- navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-menu">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </nav>
            <div class="container-fluid">

                <nav class="mt-2">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active mt-md-0 mt-1" id="nav-one-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-one" type="button" role="tab" aria-controls="nav-one"
                            aria-selected="true">All Vehicle</button>
                        <button class="nav-link mt-md-0 mt-1" id="nav-two-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-two" type="button" role="tab" aria-controls="nav-two"
                            aria-selected="false">Enter Mileage</button>
                        <button class="nav-link mt-md-0 mt-1" id="nav-three-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-three" type="button" role="tab" aria-controls="nav-three"
                            aria-selected="false">Mileage Data</button>
                        <button class="nav-link mt-md-0 mt-1" id="nav-four-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-four" type="button" role="tab" aria-controls="nav-four"
                            aria-selected="false">Service Data</button>
                        <button class="nav-link mt-md-0 mt-1" id="nav-five-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-five" type="button" role="tab" aria-controls="nav-five"
                            aria-selected="false">Enter Service</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <!-- tab 1 start -->
                    <div class="tab-pane fade show active" id="nav-one" role="tabpanel" aria-labelledby="nav-one-tab"
                        tabindex="0">
                        <!--ander ka kaam start-->
                        <div class="d-flex align-items-center justify-content-between mb-2 px-3 pt-3">
                            <!-- Left: Create Button -->
                            <div>
                                <a href="add_new_vehicle.php">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-plus"></i> Add New
                                    </button>
                                </a>
                            </div>
                            <!-- Center: Heading -->
                            <div class="flex-grow-1 text-center">
                                <h3 class="m-0 fw-semibold">All Vehicles</h3>
                            </div>
                            <!-- Right: Search Bar -->
                            <!-- <div style="min-width:220px;">
                                <input id="filter1" type="text" class="form-control form-control-sm"
                                    placeholder="Search here...">
                            </div> -->
                            <div style="min-width:220px; position: relative;">
                                <input id="filter1" type="text" class="form-control form-control-sm"
                                    placeholder="Search here...">
                                <span id="clearSearch1"
                                    style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; display: none;">
                                    ❌
                                </span>
                            </div>
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


                        $select = " SELECT * FROM vehicle";

                        $select_q = mysqli_query($conn, $select);
                        $data = mysqli_num_rows($select_q);
                        ?>
                        <div class="table-wrapper">
                            <div class="table-responsive table-container">
                                <table class="table mt-1 table-1" id="myTable1">
                                    <thead>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Id</th>
                                        <th scope="col">Reg&nbsp;pNo</th>
                                        <th scope="col">Reg&nbsp;Date</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Make</th>
                                        <th scope="col">Model</th>
                                        <th scope="col">Color</th>
                                        <th scope="col">Engine&nbsp;No</th>
                                        <th scope="col">Chassis&nbsp;No</th>
                                        <th scope="col">Engine&nbsp;Power</th>
                                        <th scope="col">User&nbsp;Name</th>
                                        <th scope="col">Designation</th>
                                        <th scope="col">User&nbsp;Location</th>
                                        <th scope="col">FuelTank&nbsp;Capacity</th>
                                    </thead>
                                    <?php
                                    if ($data) {
                                        while ($row = mysqli_fetch_array($select_q)) {
                                            ?>
                                            <tbody class="searchable1">
                                                <td>
                                                    <a href="edit_vehicle.php?vehicle_id=<?php echo $row['vehicle_id']; ?>"
                                                        class="btn btn-dark btn-sm">Edit</a>
                                                </td>
                                                <td>&nbsp;<?php echo $row['vehicle_id'] ?></td>
                                                <td><?php echo $row['reg_no'] ?></td>
                                                <td><?php echo $row['reg_date'] ?></td>
                                                <td><?php echo $row['type'] ?></td>
                                                <td><?php echo $row['make'] ?></td>
                                                <td><?php echo $row['model'] ?></td>
                                                <td><?php echo $row['color'] ?></td>
                                                <td><?php echo $row['engine_no'] ?></td>
                                                <td><?php echo $row['chassis_no'] ?></td>
                                                <td><?php echo $row['engine_power'] ?></td>
                                                <td><?php echo $row['user_name'] ?></td>
                                                <td><?php echo $row['designation'] ?></td>
                                                <td><?php echo $row['user_location'] ?></td>
                                                <td><?php echo $row['fuel_tank_capacity'] ?></td>
                                                <!-- <td><?php echo $row['assigned_user_id'] ?></td> -->
                                                <?php
                                        }
                                    } else {
                                        echo "No record found!";
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                        <!-- live search start  -->
                        <script>
                            // Live Search
                            document.getElementById("filter1").addEventListener("keyup", function () {
                                let value = this.value.toLowerCase();
                                let rows = document.querySelectorAll("#myTable1 tbody tr");

                                rows.forEach(row => {
                                    let text = row.textContent.toLowerCase();
                                    row.style.display = text.includes(value) ? "" : "none";
                                });

                                // Show/Hide Clear Button
                                document.getElementById("clearSearch1").style.display = value ? "block" : "none";
                            });

                            // Clear Button Functionality
                            document.getElementById("clearSearch1").addEventListener("click", function () {
                                document.getElementById("filter1").value = "";
                                let rows = document.querySelectorAll("#myTable1 tbody tr");
                                rows.forEach(row => row.style.display = "");
                                this.style.display = "none";
                            });
                        </script>
                        <!-- live search end -->


                    </div>
                    <!-- tab 1 end -->
                    <!-- tab 2 start -->
                    <div class="tab-pane fade" id="nav-two" role="tabpanel" aria-labelledby="nav-two-tab" tabindex="0">
                        <h3 class="text-center pb-3 pt-3">Enter Mileage</h3>
                        <form method="POST" enctype="multipart/form-data">
                            <table class="table table=bordered table_add_service">
                                <tr>
                                    <th style="font-size:15px!important"><label>Registration Number</label>
                                    </th>
                                    <td><input type="text" name="reg_no" class="form-control" autocomplete="off"
                                            required>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="font-size:15px!important"><label>Daily Mileage</label></th>
                                    <td><input type="text" name="daily_mileage" class="form-control" autocomplete="off"
                                            required>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="font-size:15px!important"><label>Issues</label></th>
                                    <td><input type="text" name="issues" class="form-control" autocomplete="off"> </td>
                                </tr>
                                <tr>
                                    <th colspan="2">
                                        <div class="text-center mt-3">
                                            <button name="enter_log"
                                                class="btn btn-dark px-4 btn-sm">
                                                <span class="text">Submit</span>
                                            </button>
                                        </div>
                                    </th>
                                </tr>
                            </table>
                        </form>
                        <?php
                        include 'dbconfig.php';

                        date_default_timezone_set("Asia/Karachi");

                        if (isset($_POST['enter_log'])) {
                            $reg_no = $_POST['reg_no'];

                            // Fetch the corresponding vehicle_id based on the entered reg_no
                            $fetch_vehicle_id_query = "SELECT vehicle_id FROM vehicle WHERE reg_no = '$reg_no'";
                            $result_vehicle_id = mysqli_query($conn, $fetch_vehicle_id_query);

                            if ($result_vehicle_id && mysqli_num_rows($result_vehicle_id) > 0) {
                                $row_vehicle_id = mysqli_fetch_assoc($result_vehicle_id);
                                $vehicle_id = $row_vehicle_id['vehicle_id'];

                                $daily_mileage = $_POST['daily_mileage'];
                                $issues = $_POST['issues'];
                                $date = date('Y-m-d H:i:s');

                                // Set the new daily mileage as the total mileage
                                $new_total = $daily_mileage;

                                // Insert the new log with the new total mileage
                                $insert = "INSERT INTO vehicle_log (veh_id, daily_mileage, issues, date, total_mileage)
                                                            VALUES ('$vehicle_id', '$daily_mileage', '$issues', '$date', '$new_total')";

                                $insert_q = mysqli_query($conn, $insert);

                                if ($insert_q) {
                                    ?>
                                    <script type="text/javascript">
                                        alert("Data inserted successfully!");
                                    </script>
                                    <?php
                                } else {
                                    ?>
                                    <script type="text/javascript">
                                        alert("Data inserting failed!");
                                    </script>
                                    <?php
                                }
                            } else {
                                ?>
                                <script type="text/javascript">
                                    alert("Invalid Registration Number!");
                                </script>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <!-- tab 2 end -->
                    <!-- tab 3 start -->
                    <div class="tab-pane fade <?php echo (isset($_GET['tab']) && $_GET['tab'] == 'nav-three') ? 'show active' : ''; ?>"
                        id="nav-three" role="tabpanel" aria-labelledby="nav-three-tab" tabindex="0">

                        <div class="d-flex align-items-center justify-content-between mb-3 px-3 pt-3">
                            <!-- Center Heading -->
                            <h3 class="m-0 fw-semibold text-center flex-grow-1">All Mileage Data</h3>
                            <!-- Right Search -->
                            <div style="min-width:220px;">
                                <form method="GET" class="d-flex">
                                    <input type="hidden" name="tab" value="nav-three">
                                    <input type="text" name="search2"
                                        value="<?php echo isset($_GET['search2']) ? htmlspecialchars($_GET['search2']) : ''; ?>"
                                        class="form-control form-control-sm" placeholder="Search here...">
                                    <button type="submit" class="btn btn-sm btn-dark ms-1">Search</button>
                                </form>
                            </div>
                        </div>

                        <?php
                        include 'dbconfig.php';

                        $limit = 50;
                        $page = isset($_GET['page2']) ? (int) $_GET['page2'] : 1;
                        if ($page < 1)
                            $page = 1;
                        $offset = ($page - 1) * $limit;

                        $search = isset($_GET['search2']) ? mysqli_real_escape_string($conn, $_GET['search2']) : "";

                        $sql = "SELECT vl.log_id, vl.veh_id, v.reg_no, v.user_name, vl.total_mileage, vl.daily_mileage, vl.issues, vl.date
            FROM vehicle_log vl
            JOIN vehicle v ON vl.veh_id = v.vehicle_id";

                        if (!empty($search)) {
                            $sql .= " WHERE vl.log_id LIKE '%$search%'
                  OR v.reg_no LIKE '%$search%'
                  OR v.user_name LIKE '%$search%'
                  OR vl.total_mileage LIKE '%$search%'
                  OR vl.daily_mileage LIKE '%$search%'
                  OR vl.issues LIKE '%$search%'
                  OR vl.date LIKE '%$search%'";
                        }

                        $count_q = mysqli_query($conn, $sql);
                        $total_records = mysqli_num_rows($count_q);
                        $total_pages = ceil($total_records / $limit);

                        $sql .= " ORDER BY vl.date DESC LIMIT $limit OFFSET $offset";
                        $result = mysqli_query($conn, $sql);
                        ?>

                        <div class="table-wrapper">
                            <div id="dataTableCont">
                                <table class="table a1 mt-1" id="myTable2">
                                    <thead style="background-color:#8576FF;color:white">
                                        <tr>
                                            <th scope="col">Log&nbsp;Id</th>
                                            <th scope="col">Registration&nbsp;Number</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Mileage</th>
                                            <th scope="col">Issues</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="searchable2">
                                        <?php if (mysqli_num_rows($result) > 0): ?>
                                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                                <tr>
                                                    <td><?php echo $row['log_id']; ?></td>
                                                    <td><?php echo $row['reg_no']; ?></td>
                                                    <td><?php echo $row['user_name']; ?></td>
                                                    <td><?php echo $row['total_mileage']; ?></td>
                                                    <td><?php echo $row['issues']; ?></td>
                                                    <td><?php echo $row['date']; ?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center">No record found!</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination Links -->
                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <!-- Show total records -->
                            <div>
                                <small>Total Records: <strong><?php echo $total_records; ?></strong></small>
                            </div>

                            <!-- Pagination Buttons -->
                            <div class="pagination-scroll text-center">
                                <?php if ($page > 1): ?>
                                    <a class="btn btn-sm btn-dark"
                                        href="?tab=nav-three&page2=<?php echo $page - 1; ?>&search2=<?php echo $search; ?>">Prev</a>
                                <?php endif; ?>

                                <?php
                                $start = max(1, $page - 5);
                                $end = min($total_pages, $page + 4);

                                for ($i = $start; $i <= $end; $i++): ?>
                                    <a class="btn btn-sm <?php echo ($i == $page) ? 'btn-primary' : 'btn-outline-dark'; ?>"
                                        href="?tab=nav-three&page2=<?php echo $i; ?>&search2=<?php echo $search; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                <?php endfor; ?>

                                <?php if ($page < $total_pages): ?>
                                    <a class="btn btn-sm btn-dark"
                                        href="?tab=nav-three&page2=<?php echo $page + 1; ?>&search2=<?php echo $search; ?>">Next</a>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <!-- Force tab to remain open after reload -->
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            const urlParams = new URLSearchParams(window.location.search);
                            const activeTab = urlParams.get('tab');
                            if (activeTab) {
                                let tabTrigger = document.querySelector(`#${activeTab}-tab`);
                                if (tabTrigger) {
                                    new bootstrap.Tab(tabTrigger).show();
                                }
                            }
                        });
                    </script>


                    <!-- tab 3 end -->
                    <!-- tab 4 start -->
                    <div class="tab-pane fade <?php echo (isset($_GET['tab']) && $_GET['tab'] == 'nav-four') ? 'show active' : ''; ?>"
                        id="nav-four" role="tabpanel" aria-labelledby="nav-four-tab" tabindex="0">

                        <div class="d-flex align-items-center justify-content-between mb-3 px-3 pt-3">
                            <!-- Center Heading -->
                            <h3 class="m-0 fw-semibold text-center flex-grow-1">Service Data</h3>

                            <!-- Right Search -->
                            <div style="min-width:220px;">
                                <form method="GET" class="d-flex">
                                    <input type="hidden" name="tab" value="nav-four">
                                    <input type="text" name="search3"
                                        value="<?php echo isset($_GET['search3']) ? htmlspecialchars($_GET['search3']) : ''; ?>"
                                        class="form-control form-control-sm" placeholder="Search here...">
                                    <button type="submit" class="btn btn-sm btn-dark ms-1">Search</button>
                                </form>
                            </div>
                        </div>

                        <?php
                        include 'dbconfig.php';

                        $limit = 50;
                        $page = isset($_GET['page3']) ? (int) $_GET['page3'] : 1;
                        if ($page < 1)
                            $page = 1;
                        $offset = ($page - 1) * $limit;

                        $search = isset($_GET['search3']) ? mysqli_real_escape_string($conn, $_GET['search3']) : "";

                        $sql = "SELECT s.service_id, s.vehicle_id, v.reg_no, v.user_name, s.s_date, s.s_type, 
                   s.s_description, s.s_cost, s.s_mileage, s.s_due
            FROM service s
            JOIN vehicle v ON s.vehicle_id = v.vehicle_id";

                        if (!empty($search)) {
                            $sql .= " WHERE s.service_id LIKE '%$search%'
                  OR v.reg_no LIKE '%$search%'
                  OR v.user_name LIKE '%$search%'
                  OR s.s_date LIKE '%$search%'
                  OR s.s_type LIKE '%$search%'
                  OR s.s_description LIKE '%$search%'
                  OR s.s_cost LIKE '%$search%'
                  OR s.s_mileage LIKE '%$search%'
                  OR s.s_due LIKE '%$search%'";
                        }

                        $count_q = mysqli_query($conn, $sql);
                        $total_records = mysqli_num_rows($count_q);
                        $total_pages = ceil($total_records / $limit);

                        $sql .= " ORDER BY s.s_date DESC LIMIT $limit OFFSET $offset";
                        $result = mysqli_query($conn, $sql);
                        ?>

                        <div class="table-wrapper">
                            <div class="table-responsive">
                                <table class="table a1 mt-1" id="myTable3">
                                    <thead>
                                        <tr>
                                            <th scope="col">Service Id</th>
                                            <th scope="col">Registration&nbsp;Number</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Cost</th>
                                            <th scope="col">Mileage</th>
                                            <th scope="col">Due</th>
                                        </tr>
                                    </thead>
                                    <tbody class="searchable3">
                                        <?php if (mysqli_num_rows($result) > 0): ?>
                                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                                <tr>
                                                    <td><?php echo $row['service_id']; ?></td>
                                                    <td><?php echo $row['reg_no']; ?></td>
                                                    <td><?php echo $row['user_name']; ?></td>
                                                    <td><?php echo $row['s_date']; ?></td>
                                                    <td><?php echo $row['s_type']; ?></td>
                                                    <td><?php echo $row['s_description']; ?></td>
                                                    <td><?php echo $row['s_cost']; ?></td>
                                                    <td><?php echo $row['s_mileage']; ?></td>
                                                    <td><?php echo $row['s_due']; ?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="9" class="text-center">No record found!</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <!-- Show total records -->
                            <div>
                                <small>Total Records: <strong><?php echo $total_records; ?></strong></small>
                            </div>

                            <!-- Pagination Buttons -->
                            <div class="pagination-scroll text-center">
                                <?php if ($page > 1): ?>
                                    <a class="btn btn-sm btn-dark"
                                        href="?tab=nav-four&page3=<?php echo $page - 1; ?>&search3=<?php echo $search; ?>">Prev</a>
                                <?php endif; ?>

                                <?php
                                $start = max(1, $page - 5);
                                $end = min($total_pages, $page + 4);

                                for ($i = $start; $i <= $end; $i++): ?>
                                    <a class="btn btn-sm <?php echo ($i == $page) ? 'btn-primary' : 'btn-outline-dark'; ?>"
                                        href="?tab=nav-four&page3=<?php echo $i; ?>&search3=<?php echo $search; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                <?php endfor; ?>

                                <?php if ($page < $total_pages): ?>
                                    <a class="btn btn-sm btn-dark"
                                        href="?tab=nav-four&page3=<?php echo $page + 1; ?>&search3=<?php echo $search; ?>">Next</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- tab 4 end -->

                    <!-- tab 4 end -->
                    <!-- tab 5 start -->
                    <div class="tab-pane fade" id="nav-five" role="tabpanel" aria-labelledby="nav-five-tab"
                        tabindex="0">
                        <h5 class="text-center pt-3" style="font-weight:600!important">Enter Service Details</h5>
                        <form method="POST" enctype="multipart/form-data">
                            <table class="table table-bordered table_add_service">
                                <tr>
                                    <th><label>Registration Number</label></th>
                                    <td><input type="text" name="reg_no" class="form-control" autocomplete="off"
                                            required>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label>Service Date</label></th>
                                    <td><input type="date" name="s_date" class="form-control"> </td>
                                </tr>
                                <tr>
                                    <th><label>Service Type</label></th>
                                    <td><input type="text" name="s_type" class="form-control" autocomplete="off"> </td>
                                </tr>
                                <tr>
                                    <th><label>Service Required</label></th>
                                    <td><input type="text" name="s_req" class="form-control" autocomplete="off">
                                    </td>
                                </tr>
                                <tr>
                                    <th><label>Service Description</label></th>
                                    <td><input type="text" name="s_description" class="form-control" autocomplete="off">
                                    </td>
                                </tr>
                                <tr>
                                    <th><label>Service Cost</label></th>
                                    <td><input type="text" name="s_cost" class="form-control" autocomplete="off"> </td>
                                </tr>
                                <tr>
                                    <th><label>Service Mileage</label></th>
                                    <td><input type="text" name="s_mileage" class="form-control" autocomplete="off">
                                    </td>
                                </tr>
                                <tr>
                                    <th><label>Service Due</label></th>
                                    <td><input type="text" name="s_due" class="form-control" autocomplete="off"> </td>
                                </tr>
                                <tr>
                                    <th colspan="2">
                                        <div class="text-center mt-3">
                                            <button type="submit" name="enter_service"
                                                class="btn btn-dark px-4">
                                                <span class="text">Submit</span>
                                            </button>
                                        </div>
                                    </th>
                                </tr>
                            </table>
                        </form>
                        <?php
                        include 'dbconfig.php';

                        date_default_timezone_set("Asia/Karachi");

                        if (isset($_POST['enter_service'])) {
                            $reg_no = $_POST['reg_no'];

                            // Fetch the corresponding vehicle_id based on the entered reg_no
                            $fetch_vehicle_id_query = "SELECT vehicle_id FROM vehicle WHERE reg_no = '$reg_no'";
                            $result_vehicle_id = mysqli_query($conn, $fetch_vehicle_id_query);

                            if ($result_vehicle_id && mysqli_num_rows($result_vehicle_id) > 0) {
                                $row_vehicle_id = mysqli_fetch_assoc($result_vehicle_id);
                                $vehicle_id = $row_vehicle_id['vehicle_id'];

                                $s_date = $_POST['s_date'];
                                $s_type = $_POST['s_type'];
                                $s_description = $_POST['s_description'];
                                $s_cost = $_POST['s_cost'];
                                $s_mileage = $_POST['s_mileage'];
                                $s_due = $_POST['s_due'];
                                $s_req = $_POST['s_req'];

                                // Insert the new service details
                                $insert = "INSERT INTO service (vehicle_id, s_date, s_type, s_description, s_cost, s_mileage, s_due, s_req)
                                                            VALUES ('$vehicle_id', '$s_date', '$s_type', '$s_description', '$s_cost', '$s_mileage', '$s_due', ' $s_req')";

                                $insert_q = mysqli_query($conn, $insert);

                                if ($insert_q) {
                                    ?>
                                    <script type="text/javascript">
                                        alert("Service details inserted successfully!");
                                    </script>
                                    <?php
                                } else {
                                    ?>
                                    <script type="text/javascript">
                                        alert("Service details inserting failed!");
                                    </script>
                                    <?php
                                }
                            } else {
                                ?>
                                <script type="text/javascript">
                                    alert("Invalid Registration Number!");
                                </script>
                                <?php
                            }
                        }
                        ?>
                        <!-- Enter Service content -->
                    </div>
                    <!-- tab 5 end -->
                </div>
            </div>
        </div>
    </div>
    <!-- conatiner -->

    <?php
    include 'footer.php'
        ?>