<?php 
    session_start (); 
    include 'dbconfig.php';
    
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
    
    // Query to get the count of rows from the raheel1 table where product_name is 'RUMOL CREAM 50G'
    $all_count_query = "SELECT COUNT(*) AS all_count FROM raheel1 ";
    
    // Execute the query
    $all_count_result = mysqli_query($conn, $all_count_query);
    
    // Check if the query was successful
    if ($all_count_result) {
    // Fetch the count
    $all_count = mysqli_fetch_assoc($all_count_result)['all_count'];
    } else {
    // Set to default value if the query fails
    $all_count = '';
    }
    
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Digas Colic Drop</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>

        <!-- Bootstrap CSS CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Our Custom CSS -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <!-- DataTables CSS -->
        <!-- Font Awesome JS -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="assets/css/style.css">
        <!-- fevicon -->
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>

        
        <style>
  
            .btn{
            font-size: 11px!important;
            }
            a{
            text-decoration:none!important;
            }
            .table-container {
            overflow-y: auto;
            height: 90vh; /* Full viewport height */
            margin: 0;
            padding: 0;
            }
            table {
            width: 100%;
            border-collapse: collapse;
            }
            table th {
            background-color: black!important;;
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
            color: black;
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
    .pagination-scroll {
    overflow-x: auto; /* Enable horizontal scrolling */
    white-space: nowrap; /* Prevent wrapping of pagination buttons */
    width: 100%; /* Full width of the parent container */
}

#pagination-controls {
    display: inline-block; /* Ensure the pagination controls are displayed inline to enable scrolling */
}
</style>
    </head>

     <div class="container-fluid">

     <div class="row justify-content-center">
                <div class="col text-center">
                   <a href="profile.php" class="btn btn-dark btn-sm" style="border-radius:0px!important">Home</a>
                   <a href="salesmain_productlist.php" class="btn btn-dark btn-sm" style="border-radius:0px!important">Product List</a>
                </div>
            </div>

            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">


                <button class="nav-link" id="nav-disabled-tab" data-bs-toggle="tab" data-bs-target="#nav-disabled" type="button" role="tab" aria-controls="nav-disabled" aria-selected="false" disabled>All Data</button>
                <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">All</button>

                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
              



            <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
    <!-- b start  -->
    <h6 class="text-center py-1">
        <span>
        All Data <?php echo htmlspecialchars($all_count); ?>
        </span>    
        <span style='float:right!important'>
        <button id="excel2" class="btn btn-success btn-sm dataExport" data-type="excel">Excel</button>
        <input id="filter2" type="text" class="form-control w-50" placeholder="Search here..." style="height: 25px; display:inline;font-size:11px!important">
        </span>
    </h6>
    <div class="table-wrapper">
        <div class="table-responsive table-container">
            <table class="table table-striped" id="myTable2">
                <thead>
                    <tr>
                        <!-- Table Headers -->
                        <th>Dp</th>
                        <th>Depot Name</th>
                        <th>Cust#</th>
                        <th>Customer Name</th>
                        <th>Address</th>
                        <th>Class</th>
                        <th>Inv#</th>
                        <th>InvDate</th>
                        <th>Prd</th>
                        <th>Pack</th>
                        <th>Batch</th>
                        <th>Sales Value</th>
                        <th>TP Medics</th>
                        <th>CP Medics</th>
                        <th>CP Value</th>
                        <th>Deff</th>
                        <th>Product Name</th>
                        <th>Sales Quantity</th>
                        <th>Bonus Quantity</th>
                    </tr>
                </thead>
                <tbody class='searchable2' id="data-body">
                    <!-- Data will be loaded via AJAX -->
                </tbody>
            </table>
            <div class="container-fluid pagination-scroll">
                <div id="pagination-controls" class="text-center">
                    <!-- Pagination controls will be loaded via AJAX -->
                </div>
            </div>
        </div>
    </div>
    <!-- b end -->
</div>




                

        </div>


     </div> <!-- conatiner -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
    <script type="text/javascript">
        document.getElementById('excel1').addEventListener('click', function() {
            var table = document.getElementById('myTable1');
            var workbook = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
            XLSX.writeFile(workbook, 'export.xlsx');
        });
    </script>

<script type="text/javascript">
        document.getElementById('excel2').addEventListener('click', function() {
            var table = document.getElementById('myTable2');
            var workbook = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
            XLSX.writeFile(workbook, 'export.xlsx');
        });
    </script>

<script type="text/javascript">
        document.getElementById('excel3').addEventListener('click', function() {
            var table = document.getElementById('myTable3');
            var workbook = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
            XLSX.writeFile(workbook, 'export.xlsx');
        });
    </script>

<script type="text/javascript">
        document.getElementById('excel4').addEventListener('click', function() {
            var table = document.getElementById('myTable4');
            var workbook = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
            XLSX.writeFile(workbook, 'export.xlsx');
        });
    </script>




















    <script>
        $(document).ready(function () {
        (function ($) {
            $('#filter1').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.searchable1 tr').hide();
                $('.searchable1 tr').filter(function () {
                    return rex.test($(this).text());
                }).show();
            })
        }(jQuery));
        });
    </script>
    <script>
        $(document).ready(function () {
        (function ($) {
            $('#filter2').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.searchable2 tr').hide();
                $('.searchable2 tr').filter(function () {
                    return rex.test($(this).text());
                }).show();
            })
        }(jQuery));
        });
    </script>

<script>
        $(document).ready(function () {
        (function ($) {
            $('#filter3').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.searchable3 tr').hide();
                $('.searchable3 tr').filter(function () {
                    return rex.test($(this).text());
                }).show();
            })
        }(jQuery));
        });
    </script>

<script>
        $(document).ready(function () {
        (function ($) {
            $('#filter4').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.searchable4 tr').hide();
                $('.searchable4 tr').filter(function () {
                    return rex.test($(this).text());
                }).show();
            })
        }(jQuery));
        });
    </script>











    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
    <script src="assets/js/main.js"></script>
 
    <script>
$(document).ready(function () {
    let offset = 0; // Initial offset
    const limit = 100; // Number of rows per page
    const $dataBody = $('#data-body');
    const $paginationControls = $('#pagination-controls');
    const $filterInput = $('#filter2');

    function loadData() {
        $.ajax({
            url: 'fetchData_all.php', // URL to the backend script
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
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error); // Log AJAX errors
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

    </body>
</html>