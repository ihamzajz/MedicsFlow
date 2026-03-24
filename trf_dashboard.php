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
        <title>TRF - Dashboard</title>
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
            .modal-fullscreen {
            width: 100%;
            max-width: none;
            height: 100%;
            margin: 0;
            }

            p{
                padding: 0px!important;
                margin: 0px!important;
            }
            th{
            font-size: 12px!important;
            }
            td{
            font-size: 13px!important;
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
                <button id="excel" class="btn btn-success btn-sm dataExport" data-type="excel">Excel</button>
                <!-- <button class="btn btn-warning btn-sm">View Summary</button> -->
                
                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#exampleModalLong">
  View Summary
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row justify-content-around" style="margin-top: 15px; margin-bottom: 60px;">
          <div class="col-md-3">
            <?php
              include 'dbconfig.php';
              $select_total = "SELECT * FROM trf ";
              $select_q_total = mysqli_query($conn, $select_total);
              $total_count = mysqli_num_rows($select_q_total);
              $select_completed = "SELECT * FROM trf WHERE task_status = 'Task Completed'";
              $select_pending = "SELECT * FROM trf WHERE (task_status = 'Task is going through Approval' OR task_status = '')";
              $select_rejected = "SELECT * FROM trf WHERE (head_status = 'Rejected' OR cfo_status = 'Rejected')";
              $select_wip = "SELECT * FROM trf WHERE task_status = 'Work In Progress'";
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
                $select_total = "SELECT * FROM trf WHERE be_depart = 'it'";
                $select_q_total = mysqli_query($conn, $select_total);
                $total_count = mysqli_num_rows($select_q_total);
                $select_completed = "SELECT * FROM trf WHERE be_depart = 'it' AND task_status = 'Task Completed'";
                $select_pending = "SELECT * FROM trf WHERE be_depart = 'it' AND (task_status = 'Task is going through Approval' OR task_status = '') ";
                $select_rejected = "SELECT * FROM trf WHERE be_depart = 'it' AND (head_status = 'Rejected' OR cfo_status = 'Rejected')";
                $select_wip = "SELECT * FROM trf WHERE be_depart = 'it' AND task_status = 'Work In Progress'";
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
                  <h5>Information Techonology</h5>
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
              $select_total = "SELECT * FROM trf WHERE be_depart = 'finance'";
              $select_q_total = mysqli_query($conn, $select_total);
              $total_count = mysqli_num_rows($select_q_total);
              $select_completed = "SELECT * FROM trf WHERE be_depart = 'finance' AND task_status = 'Task Completed'";
              $select_pending = "SELECT * FROM trf WHERE be_depart = 'finance' AND (task_status = 'Task is going through Approval' OR task_status = '')";
              $select_rejected = "SELECT * FROM trf WHERE be_depart = 'finance' AND (head_status = 'Rejected' OR cfo_status = 'Rejected')";
              $select_wip = "SELECT * FROM trf WHERE be_depart = 'finance' AND task_status = 'Work In Progress'";
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








          <div class="col-md-3 row2-cols">
            <?php
              include 'dbconfig.php';
              $select_total = "SELECT * FROM trf WHERE be_depart = 'marketing' OR be_depart = 'comm'";
              $select_q_total = mysqli_query($conn, $select_total);
              $total_count = mysqli_num_rows($select_q_total);
              $select_completed = "SELECT * FROM trf WHERE (be_depart = 'markeing' OR be_depart = 'comm') AND task_status = 'Task Completed'";
              $select_pending = "SELECT * FROM trf WHERE (be_depart = 'markeing' OR be_depart = 'comm') AND (task_status = 'Task is going through Approval' OR task_status = '')";
              $select_rejected = "SELECT * FROM trf WHERE (be_depart = 'markeing' OR be_depart = 'comm') AND (head_status = 'Rejected' OR cfo_status = 'Rejected')";
              $select_wip = "SELECT * FROM trf WHERE (be_depart = 'markeing' OR be_depart = 'comm') AND task_status = 'Work In Progress'";
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

                <input id="filter" type="text" class="form-control w-25" placeholder="Search here..." style="height: 30px; display:inline;">
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
                    
                    $select = "SELECT * FROM trf 
                    ORDER BY date DESC";
                    
                    $select_q = mysqli_query($conn,$select);
                    $data = mysqli_num_rows($select_q);
                       ?>
                <div id="dataTableCont">
                    <table  class="table table-responsive table-bordered mt-1" id="myTable">
                        <thead class="thead-dark">
                            <tr id="row_<?php echo $row['id']; ?>">
                                <th scope="col">Id </th>
                                <th scope="col">Name</th>
                                <th scope="col">Department</th>
                                <th scope="col">Role</th>
                                <th scope="col">Date</th>
                                <th scope="col">Dest. From</th>
                                <th scope="col">Dest. To</th>
                                <th scope="col">Head Details</th>
                                <th scope="col">CFO Details</th>
                                <th scope="col">Admin Details</th>
                                <th scope="col">View&nbsp;Detail</th>
                            </tr>
                        </thead>
                        <?php 
                            if($data){
                              while ($row=mysqli_fetch_array($select_q)) {
                                ?>
                        <tbody class="searchable">
                            <tr id="row_<?php echo $row['id']; ?>">
                                <td><?php echo $row['id']?>  </td>
                                <td><?php echo $row['name']?></td>
                                <td><?php echo $row['department']?></td>
                                <td><?php echo $row['role']?></td>
                                <td><?php echo $row['date']?></td>
                                <td><?php echo $row['to_1']?></td>
                                <td><?php echo $row['to_2']?></td>
                                <td><?php echo $row['head_msg']?><br><?php echo $row['head_date']?></td>
                                <td><?php echo $row['cfo_msg']?><br><?php echo $row['cfo_date']?></td>
                                <td><?php echo $row['admin_msg']?><br><?php echo $row['admin_date']?></td>
                                <td>
                                    <a href="trf_dashboard_details.php?id=<?php echo $row['id']; ?>" style="text-decoration: none;"><button class="btn btn-primary btn-sm">
                                    View Details
                                    </button></a>
                                </td>
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
            <!--ander ka kaam khatam-->
        </div>
        <!--page content-->
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
        <script src="assets/js/main.js"></script>
    </body>
</html>