<?php 
session_start (); 

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php'); // Redirect to the login page
    exit;
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Asset Receipt - Dashboard</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>


    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

<style>
    h6{
        font-size: 16px!important;
    }
        th.hidden, td.hidden {
        display: none;
    }
    .btn-dark,.btn-success,.btn-danger, .btn-info{
        font-size: 11px;
    }
    .labelm {
        font-size: 11px;
        font-weight: bold;
    }
    select,  select option , input[type=date]{
        font-size: 13px!important;
        height:10px!important;
    }
</style>
    <style>
        .heading-main{
            padding-top: 10px;
            padding-bottom: 10px;
            font-size: 22px;
            font-weight:700;
            color: white;
            background-color: #8576FF;
            }
    </style>
    <style>
        th{
            font-size: 10px!important;
            border:none!important;
        }
        td{
            font-size: 10px!important;
            border:1px solid black;
            color:black;
            padding:1!important;
        }
    </style>
    <link rel="stylesheet" href="assets/css/style.css">



    <style>
         .wrapper {
         display: flex;
         width: 100%;
         align-items: stretch;
         }
         #sidebar {
         min-width: 250px;
         max-width: 250px;
         background: #263144!important;
         color: #fff;
         transition: all 0.3s;
         }
         #sidebar.active {
         margin-left: -250px;
         }
         #sidebar .sidebar-header {
         padding: 20px;
         background: yellow!important;
         }
         #sidebar ul.components {
         padding: 10px 0;
         }
         #sidebar ul p {
         color: #fff;
         padding: 8px!important;
         }
         #sidebar ul li a {
         padding: 8px!important;
         font-size: 11px !important;
         display: block;
         color: white!important;
         }
         #sidebar ul li a:hover {
         text-decoration: none;
         }
         #sidebar ul li.active>a,
         a[aria-expanded="true"] {
         color: cyan!important;
         background: #1c9be7!important;
         }
         a[data-toggle="collapse"] {
         position: relative;
         }
         .dropdown-toggle::after {
         display: block;
         position: absolute;
         color: #1c9be7!important;
         top: 50%;
         right: 20px;
         transform: translateY(-50%);
         background: transparent!important;
         }
         ul ul a {
         font-size: 11px!important;
         padding-left: 15px !important;
         background: yellow!important;
         color: yellow!important;
         }
         ul.CTAs {
         font-size: 11px !important;
         }
         ul.CTAs a {
         text-align: center;
         font-size: 11px!important;
         display: block;
         margin-bottom: 5px;
         }
         a.download {
         background: #fff;
         color: yellow;
         }
         a.article,
         a.article:hover {
         background: yellow;
         color: yellow!important ;
         }
         #content {
         width: 100%;
         padding: 20px;
         min-height: 100vh;
         transition: all 0.3s;
         }
         @media (max-width: 768px) {
         #sidebar {
            margin-left: -250px;
         }
         #sidebar.active {
            margin-left: 0;
         }
         #sidebarCollapse span {
            display: none;
         }
         }
      </style>
</head>
<body>
    <div class="wrapper d-flex align-items-stretch">

    <?php
            include 'sidebar.php';
        ?>
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </nav>

            <h6 class="text-center heading-main px-2 py-3">
                        <span style="float:left;">
                        <a href="profile.php"><button class="btn btn-sm btn-dark" >Back</button></a>
                        </span>
                       Assets Receipt Dashboard
                       <span style="float:right;">
                       <a href="assets_data_dashboard.php"><button class="btn btn-sm btn-dark">Assets Data</button></a>
                        <a href="interCompanyTransfer_dashboard.php"><button class="btn btn-sm btn-dark">Assets Transfer</button></a>
                        <a href="fixedAssetsDisposal_dashboard.php"><button class="btn btn-sm btn-dark">Assets Disposal</button></a>
                        </span>
                    </h6>



             <!-- <button id="print1" type="button" class="btn btn-danger btn-sm" onclick="getPrint()">PDF</button>
             <button id="excel" class="btn btn-success btn-sm dataExport" data-type="excel">Excel</button>
             <input id="filter" type="text" class="form-control w-25" placeholder="Search here..." style="height: 30px; display:inline;"> -->

             <div class="row pb-2">
                    <div class="col-md-2 col-12 row1-cols">
                        <label for="fromDate" class="label labelm">From Date:</label><br>
                        <input type="date" id="fromDate" name="fromDate" class="form-control" onchange="applyFilters()">
                    </div>
                    <div class="col-md-2 col-12 row1-cols">
                        <label for="toDate" class="label labelm">To Date:</label><br>
                        <input type="date" id="toDate" name="toDate" class="form-control" onchange="applyFilters()">
                    </div>
                    <div class="col-md-2 col-12 row1-cols">
                        <label for="taskStatus" class="label labelm">Status:</label><br>
                        <select id="taskStatus" class="form-control" onchange="applyFilters()">
                            <option value="All">All</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                    <div class="col-md-2 col-12 row1-cols">
                        <label for="taskDepartment" class="label labelm">Department:</label><br>
                        <select id="taskDepartment" class="form-control" onchange="applyFilters()">
                            <option value="All">All</option>
                            <option value="Information Technology">Information Technology</option>
                            <option value="Finance">Finance</option>
                            <option value="QAQC">QAQC</option>
                            <option value="Production">Production</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Sales">Sales</option>
                        </select>
                    </div>

                    
                    <div class="col-md-2 col-12 row1-cols">
                        <button id="excel" class="btn btn-success btn-sm dataExport mb-2 mr-2" data-type="excel" style="float: left;">Excel</button>
                        


















                        <!-- modal starts  -->
                         <!-- Button trigger modal -->
<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModalCenter">
 Summary
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Department Wise - Summary</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Finance = 15</p>
       <p> Information Technology = 44</p>
       <p> Engineering = 20</p>




















       <div class="row justify-content-around container" style="margin-top: 15px;margin-bottom: 60px;">
                                                <h3 class="text-center">Summary <span style="float: right;"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></span></h3>
                                                <div class="col-md-3 row2-cols">
                                                    <?php
                                                        include 'dbconfig.php';
                                                        // Query to count total records for 'Operation - Production'
                                                        $select_total = "SELECT * FROM asset_receipt_form";
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
















      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm">Save changes</button>
      </div>
    </div>
  </div>
</div>
                        <!-- modal ends -->































                        <input id="filter" type="text" class="form-control" placeholder="Search here..." style="display:inline; font-size:14px;">
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

                $be_depart = $_SESSION['be_depart'];
                $bc_role = $_SESSION['be_role'];

                // $select = "SELECT * FROM workorder_form where username = '$username'";
                $select = "SELECT * FROM asset_receipt_form";

                $select_q = mysqli_query($conn,$select);
                $data = mysqli_num_rows($select_q);
                   ?>
                
              
           
                        <div id="dataTableCont table-responsive">
                    <table  class="table table-responsive table-bordered mt-1 table-striped" id="myTable" style="background-color: #fefefe;box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
                  <thead style="background-color:#0d9276;color:white">
                    <tr id="row_<?php echo $row['id']; ?>">
                    <th scope="col" class="hidden">Status</th> 

                    <th scope="col">Id</th> 
                    <th scope="col">Name</th>  
                      <th scope="col">Department</th>  
                      <th scope="col">Role</th>  
                      <th scope="col">Date</th>  

                      <th scope="col">Asset&nbsp;Receipt&nbsp;From</th> 
                      <th scope="col">Department</th> 
                      <th scope="col">Purchase&nbsp;Date</th> 
                      <th scope="col">Invoice&nbsp;Number</th> 
                      <th scope="col">Asset&nbsp;Location</th> 
                      <th scope="col">Supplier&nbsp;Name</th>

                      <th scope="col">Asset&nbsp;Tag&nbsp;No.</th> 
                      <th scope="col">Qty</th> 
                      <th scope="col">S.no</th>
                      <th scope="col">Description</th> 
                      
                      <th scope="col">Model</th>
                      <th scope="col">Usage</th>
                      <th scope="col">Cost</th>
                     
                      <th scope="col">Location</th>
                      <th scope="col">Owner&nbsp;Code</th>
                      <th scope="col">PO&nbsp;Satus</th>
                      <th scope="col" style="background-color:#1A2130;color:white;font-size:11px!important;text-align:center">Finance Input</th>


                        <th>Remarks1</th>
                          <th>Type</th>
                          <th>Comments</th>
                          <th>Part&nbsp;of&nbsp;machine</th>
                          <th>Old&nbsp;code</th>
                          <th>New&nbsp;code</th>
                          <th>Asset&nbsp;Class</th>
                          <th>Origin</th>
                          <th>Status</th>
                          <th>Remarks2</th>
                          <th>Part&nbsp;of&nbsp;far</th>
                          <th>Department</th>
                          <th>Unique&nbsp;Num</th>
                          <th>Item&nbsp;Desc</th>
                          <th>Balances</th>
                          <th>Department&nbsp;Name</th>
                          <th>Category</th>
                          <th>Available&nbsp;Amount</th>
                          <th>Acc&nbsp;Dept.2023</th> 

                    </tr>
                  </thead>
              
                  <?php 
                  if($data){
                    while ($row=mysqli_fetch_array($select_q)) {
                      ?>
                      <tbody class="searchable">
                        <tr id="row_<?php echo $row['id']; ?>">
                        <td class="hidden"><?php echo $row['status']?></td> 


                        <td><?php echo $row['id']?></td>
                        <td><?php echo $row['user_name']?></td>
                          <td><?php echo $row['user_department']?></td>
                          <td><?php echo $row['user_role']?></td>
                          <td><?php echo $row['user_date']?></td>

                          <td><?php echo $row['ar_from']?></td>  
                          <td><?php echo $row['ar_department']?></td>  
                          <td><?php echo $row['ar_date']?></td>  

                          <td><?php echo $row['ar_invoice_number']?></td> 
                          <td><?php echo $row['ar_location']?></td>  
                          <td><?php echo $row['ar_supplier_name']?></td>  

                          <td><?php echo $row['asset_tag_number']?></td>  
                          <td><?php echo $row['qty']?></td>
                          <td><?php echo $row['s_no']?></td>

                          <td><?php echo $row['description']?></td>

                          <td><?php echo $row['model']?></td>
                          <td><?php echo $row['usage']?></td>
                          <td><?php echo $row['cost']?></td>
                          
                          <td><?php echo $row['location']?></td>
                          <td><?php echo $row['owner_code']?></td>  
                          <td><?php echo $row['po_approve_status']?></td>
                          
                          <td style="background-color:#1A2130;color:white;font-size:11px!important;text-align:center">Finance Input</td>



                          <td><?php echo $row['f_remarks1']?></td>
                          <td><?php echo $row['f_type']?></td>
                          <td><?php echo $row['f_comments']?></td>
                          <td><?php echo $row['f_part_of_machine']?></td>
                          <td><?php echo $row['f_old_code']?></td>
                          <td><?php echo $row['f_new_code']?></td>
                          <td><?php echo $row['f_asset_class']?></td>
                          <td><?php echo $row['f_origin']?></td>
                          <td><?php echo $row['f_status']?></td>
                          <td><?php echo $row['f_remarks2']?></td>
                          <td><?php echo $row['f_part_of_far']?></td>
                          <td><?php echo $row['f_department']?></td>
                          <td><?php echo $row['f_unique_num']?></td>
                          <td><?php echo $row['f_item_desc']?></td>
                          <td><?php echo $row['f_balances']?></td>
                          <td><?php echo $row['f_department_name']?></td>
                          <td><?php echo $row['f_category']?></td>
                          <td><?php echo $row['f_available_amount']?></td>
                          <td><?php echo $row['f_acc_dept2023']?></td>

                      </tr>
                      </tbody>

                      <?php
                    }
                  }
                  else{
                    echo "No record found!";
                  }
                  ?>
                </table>
               </div>
          </div>
       
        </div> <!--page content-->
    </div> <!--wrapper-->

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript" src="libs/js-xlsx/xlsx.core.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
        $('#example').DataTable({
            "paging": true, // Enable pagination
            "searching": true, // Enable search box
            // More options can be added as needed
        });
        });
    </script>

    <!-- table export -->
    <script src="
    https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/tableExport.min.js
    "></script>
    <script type="text/javascript" src="libs/FileSaver/FileSaver.min.js"></script>
    <script type="text/javascript" src="../libs/jsPDF/polyfills.umd.js"></script>
    <script type="text/javascript" src="tableExport.min.js"></script>
    <script type="text/javascript">
            $(document).ready(function() {
        $('#excel').click(function() {
            $('#myTable').tableExport({ type: 'excel'});
            //$('#table_report').tableExport({ type: 'excel',escape:'false',ignoreColumn: [15]});
        });
    });
    </script>

    <script>
        $(document).ready(function () {
        (function ($) {
            $('#filter').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.searchable tr').hide();
                $('.searchable tr').filter(function () {
                    return rex.test($(this).text());
                }).show();
            })

        }(jQuery));
        });
    </script>









<script>
    function applyFilters() {
        var fromDate = document.getElementById("fromDate").value;
        var toDate = document.getElementById("toDate").value;
        var taskStatus = document.getElementById("taskStatus").value.toLowerCase().trim();
        var taskDepartment = document.getElementById("taskDepartment").value.toLowerCase().trim();
        var table = document.getElementById("myTable");
        var tr = table.getElementsByTagName("tr");

        for (var i = 1; i < tr.length; i++) {
            var tdDate = tr[i].getElementsByTagName("td")[5];
            var tdStatus = tr[i].getElementsByTagName("td")[0];
            var tdDepartment = tr[i].getElementsByTagName("td")[3];
            var dateValue = tdDate.textContent || tdDate.innerText;
            var statusValue = tdStatus.textContent || tdStatus.innerText;
            var departmentValue = tdDepartment.textContent || tdDepartment.innerText;
            var showRow = true;
            var date = new Date(dateValue);
            var from = fromDate ? new Date(fromDate) : null;
            var to = toDate ? new Date(toDate) : null;

            // Ensure the date is valid
            if (!isNaN(date)) {
                if (from && date < from) {
                    showRow = false;
                }
                if (to && date > to) {
                    showRow = false;
                }
            } else {
                showRow = false;
            }

            if (taskStatus !== "all" && statusValue.trim().toLowerCase() !== taskStatus) {
                showRow = false;
            }
            if (taskDepartment !== "all" && departmentValue.trim().toLowerCase() !== taskDepartment) {
                showRow = false;
            }

            if (showRow) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
</script>



<script src="assets/js/main.js"></script>


</body>

</html>