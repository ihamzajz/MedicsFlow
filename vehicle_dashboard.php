<?php
    session_start();
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php'); // Redirect to the login page
        exit;
    }
    ?> 
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Engineering Workorder Reporting Tool</title>
        
        <style>
            .full-screen-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            overflow-y: auto; 
            }
            .full-screen-image img {
            max-width: auto; 
            max-height: 60vh;
            cursor: pointer;
            }
            .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
            }
        </style>
        <style>
            p {
            margin-bottom: 2px; 
            padding-bottom: 0; 
            }
        </style>
        <style>
            .label{
            font-size: 16px;
            font-weight:500;
            padding-bottom: 5px;
            }
            .row1-cols{
            background-color: #fefffe;
            padding-top: 15px;
            padding-bottom: 10px;
            margin-right: 20px!important;
            margin-left: 20px!important;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            }
            .row2-cols{
            background-color: #fefffe;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            padding: 15px;
            }
            th{
            font-size: 12px!important;
            }
            td{
            font-size: 13px!important;
            }
        </style>
        <style>
            /* Custom CSS for full screen modal */
            .modal-fullscreen {
            width: 100vw;
            max-width: 100%;
            height: 100vh;
            max-height: 100%;
            margin: 0;
            }
            .modal-fullscreen .modal-dialog {
            width: 100%;
            max-width: none;
            height: 100%;
            margin: 0;
            }
            .modal-fullscreen .modal-content {
            height: 100%;
            border: none;
            border-radius: 0;
            }
        </style>

        <style>
            button{
                /* font-size: 15px!important; */
                padding: 6px!important;
            }
        </style>

<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">

        <div class="row justify-content-center">
        <h5 style="font-weight: bold;">Go To <span><a href="profile.php"><button class="btn btn-sm" style="background-color: #0D9276;color:White">Workflow</button></a></span> <span> <a href="reportingtool.php"><button class="btn btn-sm" style="background-color: #0D9276;color:White">Reporting Tool Home</button></a></span></h5>


        <h5 style="font-weight: bold;">Dashboards <span><a href="eng_workorder_rp.php"><button class="btn btn-sm" style="background-color: #0D9276;color:White">Engineering Workorder</button></a></span> <span>
            <a href="admin_workorder_rp.php"><button class="btn btn-sm" style="background-color: #0D9276;color:White">Admin Workorder</button></a></span>
                 <span><a href=""><button class="btn btn-sm" style="background-color: #0D9276;color:White">Travel Request</button></a></span> 
                <span><a href=""><button class="btn btn-sm" style="background-color: #0D9276;color:White">ERP Access</button></a></span> 
                <span><a href="newuser_rp.php"><button class="btn btn-sm" style="background-color: #0D9276;color:White">New User</button></a></span> 
                 <span><a href=""><button class="btn btn-sm" style="background-color: #0D9276;color:White">Requisition</button></a></span>
                 <span><a href="expense_rp.php"><button class="btn btn-sm" style="background-color: #0D9276;color:White">Expense</button></a></span>
                </h5>
        </div>

    
        <div class="row justify-content-center pb-3">

        </div>

            
        




            <ul class="nav nav-pills" id="pills-tab" role="tablist">

            </ul>
            <div class="tab-content" id="pills-tabContent">
                <!-- Main tabs starts -->
                <!-- 1 WORK ORDER STARTS -->
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <h3 class="text-center" style="font-weight: bold;">Vehicle Details Dashboard <span style="float: right;"><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            View Summary
                            </button></span></h3>
                    <div class="row pb-2 justify-content-start">
                    <div class="col-md-2">
         
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-fullscreen" style="background-color: #f1f4f5;">
                                    <div class="modal-content">
                                        <div class="modal-body" style="background-color: #f1f4f5;">
                                            <!-- modal body starts -->
                                            <!-- 2nd row starts -->
                                            <div class="row justify-content-around container" style="margin-top: 15px;margin-bottom: 60px;">
                                                <h3 class="text-center">Summary <span style="float: right;"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></span></h3>
                                                <div class="col-md-3 row2-cols">
                                                    <?php
                                                        include 'dbconfig.php';
                                                        // Query to count total records for 'Operation - Production'
                                                        $select_total = "SELECT * FROM workorder_form where depart_type = 'Engineering'";
                                                        $select_q_total = mysqli_query($conn, $select_total);
                                                        $total_count = mysqli_num_rows($select_q_total);
                                                        // Query to count records for different task statuses
                                                        $select_completed = "SELECT * FROM workorder_form WHERE task_status = 'Task Completed' AND depart_type = 'Engineering'";
                                                        $select_pending = "SELECT * FROM workorder_form WHERE (task_status = 'Task is going through Approval' OR task_status = '') AND depart_type = 'Engineering'";
                                                        $select_rejected = "SELECT * FROM workorder_form WHERE (head_status = 'Rejected' OR engineering_status = 'Rejected') AND depart_type = 'Engineering'";
                                                        $select_wip = "SELECT * FROM workorder_form WHERE task_status = 'Work In Progress' AND depart_type = 'Engineering'";             
                                                        $select_q_completed = mysqli_query($conn, $select_completed);
                                                        $select_q_pending = mysqli_query($conn, $select_pending);
                                                        $select_q_rejected = mysqli_query($conn, $select_rejected);
                                                        $select_q_wip = mysqli_query($conn, $select_wip);
                                                        $completed_count = mysqli_num_rows($select_q_completed);
                                                        $pending_count = mysqli_num_rows($select_q_pending);
                                                        $rejected_count = mysqli_num_rows($select_q_rejected);
                                                        $wip_count = mysqli_num_rows($select_q_wip);
                                                        ?>
                                                    <?php
                                                        if ($total_count > 0) {
                                                            echo "
                                                            <h5>All</h5>
                                                            <p>Total: $total_count</p>
                                                            <p>Completed: $completed_count</p>
                                                            <p>Work In Progress: $wip_count</p>
                                                            <p>Pending: $pending_count</p>
                                                            <p>Rejected: $rejected_count</p>
                                                            ";
                                                        } else {
                                                            echo "<p>No data found!</p>";
                                                        }
                                                        ?>
                                                </div>
                                                <div class="col-md-3 row2-cols">
                                                    <div>
                                                        <?php
                                                            include 'dbconfig.php';
                                                            // Query to count total records for 'Operation - Production'
                                                            $select_total = "SELECT * FROM workorder_form WHERE department = 'Operation - Production' AND depart_type = 'Engineering'";
                                                            $select_q_total = mysqli_query($conn, $select_total);
                                                            $total_count = mysqli_num_rows($select_q_total);       
                                                            // Query to count records for different task statuses
                                                            $select_completed = "SELECT * FROM workorder_form WHERE department = 'Operation - Production' AND task_status = 'Task Completed' AND depart_type = 'Engineering'";
                                                            $select_pending = "SELECT * FROM workorder_form WHERE department = 'Operation - Production' AND (task_status = 'Task is going through Approval' OR task_status = '') AND depart_type = 'Engineering'";
                                                            $select_rejected = "SELECT * FROM workorder_form WHERE department = 'Operation - Production' AND (head_status = 'Rejected' OR engineering_status = 'Rejected') AND depart_type = 'Engineering'";
                                                            $select_wip = "SELECT * FROM workorder_form WHERE department = 'Operation - Production' AND task_status = 'Work In Progress' AND depart_type = 'Engineering'";
                                                            $select_q_completed = mysqli_query($conn, $select_completed);
                                                            $select_q_pending = mysqli_query($conn, $select_pending);
                                                            $select_q_rejected = mysqli_query($conn, $select_rejected);
                                                            $select_q_wip = mysqli_query($conn, $select_wip);
                                                            $completed_count = mysqli_num_rows($select_q_completed);
                                                            $pending_count = mysqli_num_rows($select_q_pending);
                                                            $rejected_count = mysqli_num_rows($select_q_rejected);
                                                            $wip_count = mysqli_num_rows($select_q_wip);
                                                            ?>
                                                        <?php
                                                            if ($total_count > 0) {
                                                                echo "
                                                                <h5>Operation - Production</h5>
                                                                <p>Total: $total_count</p>
                                                                <p>Completed: $completed_count</p>
                                                                <p>Work In Progress: $wip_count</p>
                                                                <p>Pending: $pending_count</p>
                                                                <p>Rejected: $rejected_count</p>
                                                                ";
                                                            } else {
                                                                echo "<p>No data found!</p>";
                                                            }
                                                            ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 row2-cols">
                                                    <?php
                                                        include 'dbconfig.php';
                                                        // Query to count total records for 'Operation - Production'
                                                        $select_total = "SELECT * FROM workorder_form WHERE department = 'QAQC' AND depart_type = 'Engineering'";
                                                        $select_q_total = mysqli_query($conn, $select_total);
                                                        $total_count = mysqli_num_rows($select_q_total);    
                                                        // Query to count records for different task statuses
                                                        $select_completed = "SELECT * FROM workorder_form WHERE department = 'QAQC' AND task_status = 'Task Completed' AND depart_type = 'Engineering'";
                                                        $select_pending = "SELECT * FROM workorder_form WHERE department = 'QAQC' AND (task_status = 'Task is going through Approval' OR task_status = '') AND depart_type = 'Engineering'";
                                                        $select_rejected = "SELECT * FROM workorder_form WHERE department = 'QAQC' AND (head_status = 'Rejected' OR engineering_status = 'Rejected') AND depart_type = 'Engineering'";
                                                        $select_wip = "SELECT * FROM workorder_form WHERE department = 'QAQC' AND task_status = 'Work In Progress' AND depart_type = 'Engineering'";              
                                                        $select_q_completed = mysqli_query($conn, $select_completed);
                                                        $select_q_pending = mysqli_query($conn, $select_pending);
                                                        $select_q_rejected = mysqli_query($conn, $select_rejected);
                                                        $select_q_wip = mysqli_query($conn, $select_wip);
                                                        $completed_count = mysqli_num_rows($select_q_completed);
                                                        $pending_count = mysqli_num_rows($select_q_pending);
                                                        $rejected_count = mysqli_num_rows($select_q_rejected);
                                                        $wip_count = mysqli_num_rows($select_q_wip);
                                                        ?>
                                                    <?php
                                                        if ($total_count > 0) {
                                                            echo "
                                                            <h5 class='text-center'>QAQC</h5>
                                                            <p>Total: $total_count</p>
                                                            <p>Completed: $completed_count</p>
                                                            <p>Work In Progress: $wip_count</p>
                                                            <p>Pending: $pending_count</p>
                                                            <p>Rejected: $rejected_count</p>
                                                            ";
                                                        } else {
                                                            echo "<p>No data found!</p>";
                                                        }
                                                        ?>
                                                </div>
                                            </div>
                                            <!-- avg time completion starts -->
                                            <
                                            <div class="row justify-content-around container" style="margin-top: 15px;margin-bottom: 60px;">
                                                <div class="col-md-4">
                                                    <img src="assets/images/all.png" alt="" class="img-fluid full-screen-image" data-src="assets/images/all.png">
                                                </div>
                                                <div class="col-md-4">
                                                    <img src="assets/images/production.png" alt="" class="img-fluid full-screen-image" data-src="assets/images/production.png">
                                                </div>
                                                <div class="col-md-4">
                                                    <img src="assets/images/qaqc.png" alt="" class="img-fluid full-screen-image" data-src="assets/images/qaqc.png">
                                                </div>
                                            </div>
                                            <!-- Full-screen overlay -->
                                            <div class="full-screen-overlay">
                                                <span class="close-btn">&times;</span>
                                                <img src="" class="img-fluid full-screen-image">
                                            </div>
                                            <!-- avg time completion ends -->
                                            <!-- 2nd row ends -->
                                            <!-- modal body ends -->
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-2 row1-cols col-1">
                            <label for="" class="label labelm">Select Price Range:</label><br>
                            <select id="priceRange">
                                <option value="all">All</option>
                                <!-- Add option for all -->
                                <option value="0-500">0</option>
                                <option value="500-1999">500 - 1999</option>
                                <option value="2000-4999">2000 - 4999</option>
                                <option value="5000-9999">5000 - 9999</option>
                                <option value="10000">10,000 +</option>
                            </select>
                        </div>
                        <!-- Add two date inputs for "From" and "To" dates -->
                        <div class="col-md-2 row1-cols col-2">
                            <label for="fromDate" class="label labelm">From Date:</label><br>
                            <input type="date" id="fromDate">
                        </div>
                        <div class="col-md-2 row1-cols col-3">
                            <label for="toDate" class="label labelm">To Date:</label><br>
                            <input type="date" id="toDate">
                        </div>
                        <div class="col-md-2 row1-cols col-4">
                            <label for="department" class="label labelm">Department:</label><br>
                            <select id="departmentFilter">
                                <!-- Add id attribute -->
                                <option value="All">All</option>
                                <option value="Operation - Production">Operation - Production</option>
                                <option value="QAQC">QAQC</option>
                                <option value="Administration.">Administration.</option>
                                <option value="Information Technology">Information Technology</option>
                                <option value="Engineering">Engineering</option>
                            </select>
                        </div>
                        <div class="col-md-2 row1-cols col-5">
                            <label for="taskStatus" class="label labelm" >Task Status:<br>
                            <select id="finalStatusFilter" onchange="applyFinalStatusFilter()">
                                <option value="All">All</option>
                                <option value="Completed">Completed</option>
                                <option value="Rejected">Rejected</option>
                                <option value="Approval Pending">Approval Pending</option>
                                <option value="Work In Progress">Work In Progress</option>
                            </select>
                        </div>

                    </div>
                    <!-- col4 ends -->
                </div>
                <!-- 1st row ends -->
                <!-- 3rd row starts -->
                <div class="row">
                    <div class="col">
                        <!-- col 8 starts -->
                        <?php
                            include 'dbconfig.php';
                            $select = "SELECT * FROM workorder_form WHERE depart_type = 'Engineering' ORDER BY date DESC";
                            $select_q = mysqli_query($conn,$select);
                            $data = mysqli_num_rows($select_q);
                            ?>
                        <div id="dataTableCont">
                            <table class="table table-responsive table-bordered mt-1 table-striped" id="myTable" style="background-color: #fefefe;box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
                                <thead style="background-color: #0B5ED7;color:white">
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Date&nbsp;&&nbsp;Time</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Head&nbsp;Details</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Reason</th>
                                        <th scope="col">Closeout&nbsp;Remarks</th>
                                        <th scope="col">Avg&nbsp;Completion&nbsp;Time</th>
                                        <!-- New column -->
                                    </tr>
                                </thead>
                                <tbody class="searchable">
                                    <?php 
                                        if($data){
                                            while ($row=mysqli_fetch_array($select_q)) {
                                                $head_date = new DateTime($row['head_date']);
                                                $closeout_date = new DateTime($row['closeout_date']);
                                                $completion_time = $head_date->diff($closeout_date)->format('%d days %h hours %i minutes');
                                        
                                                ?>
                                    <tr>
                                        <td><?php echo $row['id']?></td>
                                        <td><?php echo $row['name']?></td>
                                        <td><?php echo $row['department']?></td>
                                        <td><?php echo $row['date']?></td>
                                        <td><?php echo $row['type']?></td>
                                        <td><?php echo $row['description']?></td>
                                        <td><?php echo $row['amount']?></td>
                                        <td><?php echo $row['head_msg']?><br><?php echo $row['head_date']?></td>
                                        <td data-final-status="<?php echo $row['final_status']; ?>"><?php echo $row['final_status']; ?></td>
                                        <td><?php echo $row['reason']?></td>
                                        <td><?php echo $row['closeout']?><?php echo $row['closeout_date']?></td>
                                        <td><?php echo $completion_time; ?></td>
                                        <!-- Display completion time -->
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
                    <!-- col 8  ends -->
                </div>
                <!-- 3rd row ends -->
            </div>
            <!-- 1 WORK ORDER ENDS -->
            <!-- 2 VEHICLE STARTS -->
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <h2>Comming Soon</h2>
            </div>
            <!-- 2 VEHICLE ENDS -->
            <!-- 3 ERP STARTS -->
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                <h2>Comming Soon</h2>
            </div>
            <!-- 3 ERP ENDS -->
        </div>
        <!-- Main tabs end -->
        </div>
        <!-- <script>
            new DataTable('#example');
            </script> -->
        <!-- Optional JavaScript; choose one of the two! -->
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>
        <script>
            $(document).ready(function(){
                // Function to handle change in filters
                function applyFilters() {
                    var priceRange = $('#priceRange').val();
                    var finalStatus = $('#finalStatusFilter').val();
                    var department = $('#departmentFilter').val(); // Get selected department
                    var fromDate = $('#fromDate').val(); // Get selected "From" date
                    var toDate = $('#toDate').val(); // Get selected "To" date
                    filterTableData(priceRange, finalStatus, department, fromDate, toDate);
                }
                // Function to filter table data based on filters
                function filterTableData(priceRange, finalStatus, department, fromDate, toDate) {
                    var minPrice, maxPrice;
                    // Parse the price range
                    if (priceRange === "all") {
                        minPrice = 0;
                        maxPrice = Number.POSITIVE_INFINITY;
                    } else if (priceRange === "10000") {
                        minPrice = 10000;
                        maxPrice = Number.POSITIVE_INFINITY;
                    } else {
                        var rangeParts = priceRange.split('-');
                        minPrice = parseInt(rangeParts[0]);
                        maxPrice = parseInt(rangeParts[1]);
                    }
                    $('#myTable tbody tr').each(function() {
                        var amount = parseInt($(this).find('td:nth-child(7)').text());
                        var rowFinalStatus = $(this).find('td[data-final-status]').data('final-status');
                        var rowDepartment = $(this).find('td:nth-child(3)').text().trim(); // Get department from third column
                        var rowDate = $(this).find('td:nth-child(4)').text().trim(); // Get date from fourth column
            
                        // Parse the row date and selected date
                        var rowDateObj = new Date(rowDate);
                        var selectedFromDate = new Date(fromDate);
                        var selectedToDate = new Date(toDate);
            
                        // Compare selected dates with row date
                        var dateMatch = (fromDate === "" || rowDateObj >= selectedFromDate) && (toDate === "" || rowDateObj <= selectedToDate);
            
                        if ((amount >= minPrice && amount <= maxPrice) && (finalStatus === 'All' || rowFinalStatus === finalStatus) && (department === 'All' || rowDepartment === department) && dateMatch) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                }
                $('#priceRange, #finalStatusFilter, #departmentFilter, #fromDate, #toDate').change(applyFilters);
            });
            
                    
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                $(".full-screen-image").click(function() {
                    var imgSrc = $(this).attr("data-src");
                    $(".full-screen-overlay").html('<span class="close-btn">&times;</span><img src="' + imgSrc + '" class="img-fluid">');
                    $(".full-screen-overlay").fadeIn();
                });
                $(document).on("click", ".close-btn", function() {
                    $(".full-screen-overlay").fadeOut();
                });
            });
        </script>
    </body>
</html>