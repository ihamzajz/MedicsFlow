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
        <title>Asset Main Data</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
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
            input::placeholder {
            color: black!important; /* Placeholder text color */
            }
        </style>
        <style>
            .btn{
            font-size: 11px!important;
            }
            a{
            text-decoration:none!important;
            }
            .table-container1 {
            overflow-y: auto;
            height: 93vh; 
            margin: 0;
            padding: 0;
            }
            table {
            width: 100%;
            border-collapse: collapse;
            }
            table th {
            background-color: #0D9276!important;;
            position: sticky;
            top: 0;
            z-index: 1000; 
            font-size: 10px;
            border: none!important;
            text-align: left;
            color:white!important;;
            }
            table td {
            font-size: 10px;
            color: black!important;
            padding: 5px!important; /* Adjust padding as needed */
            border: 1px solid #ddd;
            }
            .table_add_service th{
            background-color:white!important;
            color:black!important;
            font-size: 14px;
            }
        </style>
        <style>
            #filter {
            font-size: 14px;
            max-width: 150px;
            height: 28px;
            border-radius: 0px;
            }
            .btn {
            font-size: 11px !important;
            border-radius: 0px !important;
            }
            p {
            font-size: 13px;
            padding: 2px;
            margin: 0px;
            }
            .modal-dialog.modal-fullscreen {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            max-width: none;
            }
            .modal-content {
            height: 100%;
            border-radius: 0;
            }
            h6 {
            font-size: 16px !important;
            }
            th.hidden,
            td.hidden {
            display: none;
            }
            .btn-dark,
            .btn-success,
            .btn-danger,
            .btn-info {
            font-size: 11px;
            }
            .labelm {
            font-size: 11px;
            font-weight: bold;
            }
            select,
            select option,
            input[type=date] {
            font-size: 13px !important;
            height: 10px: !important;
            }
        </style>
        <style>
            .heading-main {
            font-size: 22px !important;
            color: black !important;
            padding: 0px;
            margin:0px;
            font-weight:bold!important;
            }
        </style>
        <style>
            th {
            background-color: #0d9276;
            position: sticky;
            top: 0;
            z-index: 1000;
            font-size: 10px !important;
            border: none !important;
            }
            td {
            font-size: 10px !important;
            color: black;
            padding: 1px !important;
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
            background: #263144 !important;
            color: #fff;
            transition: all 0.3s;
            }
            #sidebar.active {
            margin-left: -250px;
            }
            #sidebar .sidebar-header {
            padding: 20px;
            background: yellow !important;
            }
            #sidebar ul.components {
            padding: 10px 0;
            }
            #sidebar ul p {
            color: #fff;
            padding: 8px !important;
            }
            #sidebar ul li a {
            padding: 8px !important;
            font-size: 11px !important;
            display: block;
            color: white !important;
            }
            #sidebar ul li a:hover {
            text-decoration: none;
            }
            #sidebar ul li.active>a,
            a[aria-expanded="true"] {
            color: cyan !important;
            background: #1c9be7 !important;
            }
            a[data-toggle="collapse"] {
            position: relative;
            }
            .dropdown-toggle::after {
            display: block;
            position: absolute;
            color: #1c9be7 !important;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            background: transparent !important;
            }
            ul ul a {
            font-size: 11px !important;
            padding-left: 15px !important;
            background: yellow !important;
            color: yellow !important;
            }
            ul.CTAs {
            font-size: 11px !important;
            }
            ul.CTAs a {
            text-align: center;
            font-size: 11px !important;
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
            color: yellow !important;
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
            <h5 class="heading-main ">
                <span class="float-left">
                <a href="assets_management_home.php" class="btn btn-sm btn-warning mr-3">Back</a>
                </span>Assets Data: <span style="font-weight:normal!important;font-size:23px!important"> <?php
                    include 'dbconfig.php';
                    // Query to count total records for 'Operation - Production'
                    $select_total = "SELECT * FROM assets_main";
                    $select_q_total = mysqli_query($conn, $select_total);
                    $total_count = mysqli_num_rows($select_q_total);
                    
                    ?> <?php
                    if ($total_count > 0) {
                        echo "
                    
                    $total_count
                    
                        ";
                    } else {
                        echo "
                    	<p>No data found!</p>";
                    }
                    ?> </span>
                <span class="float-right d-flex align-items-center">
                <a class="btn btn-sm btn-dark ml-1" href="assets_data_dashboard.php">Assets Receipt</a>
                <a class="btn btn-sm btn-dark ml-1" href="interCompanyTransfer_dashboard.php">Assets Transfer</a>
                <a class="btn btn-sm btn-dark ml-1" href="fixedAssetsDisposal_dashboard.php">Assets Disposal</a>
                <button type="button" class="btn btn-sm ml-1" data-toggle="modal" data-target="#exampleModalCenter" style="background-color:#8576FF;color:white"> Summary </button>
                <input id="filter" type="text" class="form-control ml-1" placeholder="Search here...">
                </span>
            </h5>
            <div class="col-md-2 col-12 row1-cols">
                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Department Wise - Summary</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row " style="margin-top: 15px;margin-bottom: 60px;">
                                    <div class="col-12"> <?php
                                        include 'dbconfig.php';
                                        // Query to count total records for 'Operation - Production'
                                        $select_total = "SELECT * FROM assets";
                                        $select_q_total = mysqli_query($conn, $select_total);
                                        $total_count = mysqli_num_rows($select_q_total);
                                        // Query to count records for different task statuses
                                        $select_it = "SELECT * FROM assets WHERE department1 LIKE '%Information Technology%' OR department1 LIKE '%IT%'";
                                        $select_marketing = "SELECT * FROM assets WHERE department1 like '%Marketing%' OR department1 LIKE '%Marketing Room%'";
                                        $select_finance = "SELECT * FROM assets WHERE department1 like '%Finance%'";
                                        $select_sales = "SELECT * FROM assets WHERE department1 like '%Sales%' OR department1 LIKE '%Sales%'"; 
                                        $select_qaqc = "SELECT * FROM assets WHERE department1 like '%QAQC%' OR department1 like '%QC LAB%'"; 
                                        $select_micro = "SELECT * FROM assets WHERE department1 like '%Micro%' OR department1 like '%Micro LAB%'"; 
                                        $select_admin= "SELECT * FROM assets WHERE department1 like 'Admin Department' OR department1 LIKE '%Admin%'"; 
                                        $select_eng = "SELECT * FROM assets WHERE department1 like 'Engineering Department' OR department1 like '%Engineering%'"; 
                                        $select_production = "SELECT * FROM assets WHERE department1 like 'Production Department' OR department1 like '%Production%'";
                                        $select_warehouse = "SELECT * FROM assets WHERE department1 like 'Warehouse' OR department1 like '%Warehouse Department%'";  
                                        $select_scrape = "SELECT * FROM assets WHERE department1 like 'Scrape Area'"; 
                                        // $select_production = "SELECT * FROM assets WHERE department1 like 'R&D'"; 
                                                
                                        $select_q_it= mysqli_query($conn, $select_it);
                                        $select_q_marketing = mysqli_query($conn, $select_marketing);
                                        $select_q_finance = mysqli_query($conn, $select_finance);
                                        $select_q_sales = mysqli_query($conn, $select_sales);
                                        $select_q_qaqc = mysqli_query($conn, $select_qaqc);
                                        $select_q_micro = mysqli_query($conn, $select_micro);
                                        $select_q_admin = mysqli_query($conn, $select_admin);
                                        $select_q_eng = mysqli_query($conn, $select_eng);
                                        $select_q_production = mysqli_query($conn, $select_production);
                                        $select_q_warehouse = mysqli_query($conn, $select_warehouse);
                                        $select_q_scrape = mysqli_query($conn, $select_scrape);
                                        
                                        
                                        $count_it = mysqli_num_rows($select_q_it);
                                        $count_marketing = mysqli_num_rows($select_q_marketing);
                                        $count_finance = mysqli_num_rows($select_q_finance);
                                        $count_sales = mysqli_num_rows($select_q_sales);
                                        $count_qaqc = mysqli_num_rows($select_q_qaqc);
                                        $count_micro = mysqli_num_rows($select_q_micro);
                                        $count_admin = mysqli_num_rows($select_q_admin);
                                        $count_eng = mysqli_num_rows($select_q_eng);
                                        $count_production  = mysqli_num_rows($select_q_production);
                                        $count_warehouse  = mysqli_num_rows($select_q_warehouse);
                                        $count_scrape  = mysqli_num_rows($select_q_scrape);
                                        ?> <?php
                                        if ($total_count > 0) {
                                            echo "
                                            
                                        <h5>Summary</h5>
                                        <p>Total: $total_count</p>
                                        <p>Information Technologyy: $count_it</p>
                                        <p>Marketing: $count_marketing</p>
                                        <p>Finance: $count_finance</p>
                                        <p>Sales: $count_sales</p>
                                        <p>QAQC: $count_qaqc</p>
                                        <p>Micro:$count_micro</p>
                                        <p>Admin:$count_admin</p>
                                        <p>Engineering:$count_eng</p>
                                        <p>Production:$count_production</p>
                                        <p>Warehouse:$count_warehouse</p>
                                        <p>Scrape Area:$count_scrape</p>
                                            ";
                                        } else {
                                            echo "
                                        <p>No data found!</p>";
                                        }
                                        ?> </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary btn-sm">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal ends -->
                </div>
            </div>
            <?php
                include 'dbconfig.php';
                // Initial query (optional) or leave this out if you only load data via AJAX
                $select = "SELECT * FROM assets_main";
                $select_q = mysqli_query($conn, $select);
                $data = mysqli_num_rows($select_q);
                ?> 
            <div class="table-wrapper">
                <div class="table-container1">
                    <table class="table table-striped" id="myTable2">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">S.no</th>
                                <th scope="col">Part&nbsp;Of&nbsp;far</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Type</th>
                                <th scope="col">Comments</th>
                                <th scope="col">Part&nbsp;Of&nbsp;Machine</th>
                                <th scope="col">Old&nbsp;Code</th>
                                <th scope="col">New&nbsp;Code</th>
                                <th scope="col">Name</th>
                                <th scope="col">Department1</th>
                                <th scope="col">Asset Location</th>
                                <th scope="col">Purchase Date</th>
                                <th scope="col">Asset Class</th>
                                <th scope="col">No Of Units</th>
                                <th scope="col">Model</th>
                                <th scope="col">Usage</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Status</th>
                                <th scope="col">Remarks2</th>
                                <th scope="col">Part of far2</th>
                                <th scope="col">Department2</th>
                                <th scope="col">Unique Nuim</th>
                                <th scope="col">Item Description</th>
                                <th scope="col">Balances</th>
                                <th scope="col">Supplier Name</th>
                                <th scope="col">Department Name</th>
                                <th scope="col">Category</th>
                                <th scope="col">Invoice Date</th>
                                <th scope="col">Invoice Number</th>
                                <th scope="col">Original Amount</th>
                                <th scope="col">Available Amount</th>
                                <th scope="col">Asset Tag Number</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Location</th>
                                <th scope="col">Cost</th>
                                <th scope="col">Comments</th>
                            </tr>
                        </thead>
                        <tbody class='searchable' id="data-body">
                            <!-- Data will be loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
                <div class="container-fluid pagination-scroll" style="width: 100%; display: flex; justify-content: center; align-items: center;">
                    <div id="pagination-controls">
                        <!-- Pagination controls will be loaded via AJAX -->
                    </div>
                </div>
            </div>
            <!--page content-->
        </div>
        <!--wrapper-->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
              let offset = 0; // Initial offset
              const limit = 30; // Number of rows per page
              const $dataBody = $('#data-body');
              const $paginationControls = $('#pagination-controls');
              const $filterInput = $('#filter');
            
              function loadData() {
                $.ajax({
                  url: 'fetchData_assets_main.php', // Adjust this URL to your backend script
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
        <script type="text/javascript" src="libs/js-xlsx/xlsx.core.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
              $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
              });
            });
        </script>
        <script>
            $(document).ready(function() {
              (function($) {
                $('#filter').keyup(function() {
                  var rex = new RegExp($(this).val(), 'i');
                  $('.searchable tr').hide();
                  $('.searchable tr').filter(function() {
                    return rex.test($(this).text());
                  }).show();
                })
              }(jQuery));
            });
        </script>
        <script src="assets/js/main.js"></script>
    </body>
</html>