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

    <title>Asset Transfer - Dashboard</title>
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
              #filter {
            font-size: 14px;
            max-width: 150px;
            height: 28px;
            border-radius: 0px;
            }
            input::placeholder {
            color: black!important; /* Placeholder text color */
            }
        </style>
    <style>
        .btn{
            border-radius:0px!important;
        }
        input{
            height:10px:!important;
        }
           h6{
        font-size: 16px!important;
    }
        th.hidden, td.hidden {
        display: none;
    }
    .btn-dark,.btn-success,.btn-danger , .btn-info{
        font-size: 11px;
    }
    .labelm {
        font-size: 11px;
        font-weight: bold;
    }
    select,  select option , input[type=date]{
        font-size: 13px!important;
        height:10px:!important;
    }
</style>

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        .btn{
            font-size: 11px;
        }
        .heading-main {
            font-size: 23px !important;
            color: black !important;
            font-weight:bold!important;
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


    <style>
        th {
            background-color: #0d9276;
            position: sticky;
            top: 0;
            z-index: 1000;
            color:white;
            font-size: 10px !important;
            border: none !important;
        }

        td {
            font-size: 10px !important;
            color: black;
            padding: 3px !important;
            background-color: white!important;

        }
        </style>
</head>
<body>
    <div class="wrapper d-flex align-items-stretch">

    <?php
            include 'sidebar1.php';
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



            <h5 class="heading-main">
          <span class="float-left">
            <a href="assets_management_home.php" class="btn btn-sm btn-warning mr-3">Back</a>
            Assets Transfer: <?php
            include 'dbconfig.php';
            // Query to count total records for 'Operation - Production'
            $select_total = "SELECT * FROM intercompanytransfer_form";
            $select_q_total = mysqli_query($conn, $select_total);
            $total_count = mysqli_num_rows($select_q_total);

            ?> <?php
            if ($total_count > 0) {
                echo "

            $total_count

                ";
            } else {
                // echo "
				// 									<p>No data found!</p>";
            }
            ?> </span>
          <span class="float-right d-flex align-items-center">
          <a href="assets_main_dashboard.php"><button class="btn btn-sm btn-dark mr-1">Assets Data</button></a>
          <a href="assets_data_dashboard.php"><button class="btn btn-sm btn-dark mr-1">Assets Receipt</button></a>
          <a href="fixedAssetsDisposal_dashboard.php"><button class="btn btn-sm btn-dark">Assets Disposal</button></a>
            <button type="button" class="btn btn-sm ml-1" data-toggle="modal" data-target="#exampleModalCenter" style="background-color:#8576FF;color:white"> Summary </button>
            <input id="filter" type="text" class="form-control ml-1" placeholder="Search here...">
          </span>
        </h5>






        <?php
                    include 'dbconfig.php';
                    // Initial query (optional) or leave this out if you only load data via AJAX
                    $select = "SELECT * FROM intercompanytransfer_form";
                    $select_q = mysqli_query($conn, $select);
                    $data = mysqli_num_rows($select_q);
                    ?> 
                    <div class="table-wrapper">
          <div class="table-container1">
            <table class="table table-bordered" id="myTable2">
              <thead>
                <tr>
                <th scope="col">Report</th>
                    <th scope="col">Id</th> 
                    <th scope="col">Prepared By</th> 
                    <th scope="col">Department</th> 
                    <th scope="col">Form Sumbission Date</th> 
                    <th scope="col">Receiving Custodian Name</th> 
                    <th scope="col">Receiving Custodian No.</th> 
                    <th scope="col">Receiving Department</th> 
                    <th scope="col">Date Prepared</th>  
                    <th scope="col">Asset Tag Number</th> 
                    <th scope="col">Description</th> 
                    <th scope="col">Qty</th> 
                    <th scope="col">S.no</th>
                    <th scope="col">Cost</th>
                    <th scope="col">Bldg</th>
                    <th scope="col">Room</th>
                    <th scope="col">Owner Code</th>
                    <th scope="col">Comment</th>
                    <th scope="col">Finance</th>
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




























          

           






       
        </div> <!--page content-->
    </div> <!--wrapper-->

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>
  $(document).ready(function() {
    let offset = 0; // Initial offset
    const limit = 10; // Number of rows per page
    const $dataBody = $('#data-body');
    const $paginationControls = $('#pagination-controls');
    const $filterInput = $('#filter');

    function loadData() {
      $.ajax({
        url: 'fetchData_transfer.php', // Adjust this URL to your backend script
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
</script>    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>



 
    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
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