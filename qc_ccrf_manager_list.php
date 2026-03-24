<?php
    session_start();
    
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php'); // Redirect to the login page
        exit;
    }
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>QC - CCRF Manager List</title>
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
        <link rel="stylesheet" href="assets/css/style.css">
        <style>
         .btn-menu{
            font-size: 11px!important;
            border-radius: 0px!important;
         }
         .btn{
            font-size: 11px!important;
            border-radius: 0px!important;
         }
        th{
            font-size: 10.5px!important;
            border:none!important;
        }
        td{
            font-size: 10.5px!important;
            background-color:White!important;
            color:black!important;
        }
    </style>
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
        <?php
            include 'dbconfig.php';
            ?>
        <div class="wrapper d-flex align-items-stretch">
            <?php
                include 'sidebar.php';
                ?>
            <!-- Page Content  -->
            <div id="content">
                <!-- navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-menu btn-dark">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                        </button>
                    </div>
                </nav>
                <button id="excel" class="btn btn-success dataExport btn-sm" data-type="excel">Excel</button>				
                <input id="filter" type="text" class="form-control w-25" placeholder="Search here..." style="height: 27px; display:inline;font-size:11px">
                <?php
                    include 'dbconfig.php';
                    
                    $head_depart = $_SESSION['be_depart'];
                    
                  

                    $select = "SELECT * FROM qc_ccrf WHERE user_be_depart = '$be_depart' AND user_be_role = 'user'";
                    
                    $select_q = mysqli_query($conn,$select);
                    $data = mysqli_num_rows($select_q);
                    ?>
                <div id="dataTableCont">
                    <table  class="table table.responsive table-bordered mt-1" id="myTable">
                    <thead style="background-color:#0D9276;color:white">
                            <tr>
                                <!-- <th colspan="2">Head</th> -->
                                <th scope="col">Id</th>
                                <th scope="col">View&nbsp;Detail</th>
                            </tr>
                        </thead>
                        <?php 
                            if($data){
                            	while ($row=mysqli_fetch_array($select_q)) {
                            		?>
                        <tbody class="searchable">
                            <tr id="row_<?php echo $row['id']; ?>">
                                <!-- <td><a href="workorder_head_approve.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email']; ?>&name=<?php echo $row['name']; ?>&depart_type=<?php echo $row['depart_type']; ?>&type=<?php echo $row['type']; ?>&category=<?php echo $row['category']; ?>" class="text-success" style="text-decoration: none;color: green;font-weight:600">Approve</a></td>
                                <td ><a href="workorder_head_reject.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email'];?>&name=<?php echo $row['name']; ?>" style="text-decoration: none;color: red;font-weight:600">Reject</a></td> -->
                                <td><?php echo $row['id']?></td>
                                <td>
                                    <a href="qc_ccrf_manager_form.php?id=<?php echo $row['id']; ?>"><button class="btn btn-sm btn-dark">
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
        </div>
        </div>
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
        <!-- TABLE EXPORT -->



        <script type="text/javascript">
            $(document).ready(function() {
            $('#excel').click(function() {
            $('#myTable').tableExport({ type: 'excel',ignoreColumn: [16] });
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
            $(document).ready(function() {
              let offset = 0; // Initial offset
              const limit = 15; // Number of rows per page
              const $dataBody = $('#data-body');
              const $paginationControls = $('#pagination-controls');
              const $filterInput = $('#filter');
            
              function loadData() {
                $.ajax({
                  url: 'qc_ccrf_manager_list_fetchData.php', // Adjust this URL to your backend script
                  type: 'GET',
                  data: {
                    limit: limit,
                    offset: offset,
                    search: $filterInput.val() // Include the search term
                  },
                  dataType: 'json',
                  success: function(response) {
                    if (response.data) {
                      // Update table with new data
                      $dataBody.html(response.data.rows);
                      // Update pagination controls
                      $paginationControls.html(response.data.pagination);
                      // Update offset
                      offset = response.nextOffset;
                    }
                  }
                });
              }
              // Load initial data
              loadData();
              // Handle pagination controls click
              $paginationControls.on('click', 'button', function() {
                let newOffset = $(this).data('offset');
                if (newOffset !== undefined) {
                  offset = newOffset;
                  loadData();
                }
              });
              // Handle search input change
              $filterInput.on('input', function() {
                offset = 0; // Reset offset when searching
                loadData();
              });
            });
        </script>


        <script src="assets/js/main.js"></script>
    </body>
</html>