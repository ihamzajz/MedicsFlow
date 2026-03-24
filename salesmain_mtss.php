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
    $all_count_query = "SELECT COUNT(*) AS all_count FROM raheel1 WHERE product_name = 'MEDICS TOOT SIAH PLUS 120ML'";
    
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
        <title>Medics Toot Siah Plus 120ML</title>
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


                <button class="nav-link" id="nav-disabled-tab" data-bs-toggle="tab" data-bs-target="#nav-disabled" type="button" role="tab" aria-controls="nav-disabled" aria-selected="false" disabled>Medics Toot Siah Plus 120ML</button>
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Slab</button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">All</button>
                <button class="nav-link" id="nav-group-tab" data-bs-toggle="tab" data-bs-target="#nav-group" type="button" role="tab" aria-controls="nav-group" aria-selected="false">Group Inv</button>
                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Discrepancy</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <!-- <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="0">...</div> -->
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                    <!-- a start  -->

                    <div class="table-wrapper row justify-content-center">
    <div class="table-responsive table-container col-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Purchase Quantity</th>
                    <th>Free Products</th>
                </tr>
            </thead>
            <tbody id="reportBody">
                <!-- Rows will be inserted here by JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<div class="pagination-controls">
    <button id="prevPage" onclick="prevPage()">Previous</button>
    <span id="pageInfo"></span>
    <button id="nextPage" onclick="nextPage()">Next</button>
</div>

<script>
    const maxQuantity = 5000;
    const recordsPerPage = 100;
    let currentPage = 1;
    let totalPages = Math.ceil(maxQuantity / recordsPerPage);
    let data = [];

    function calculateFreeProducts(quantity) {
                            let freeProducts = 0;
                        
                            while (quantity >= 100) {
                                freeProducts += 40;
                                quantity -= 100;
                            }
                            while (quantity >= 50) {
                                freeProducts += 18;
                                quantity -= 50;
                            }
                            while (quantity >= 20) {
                                freeProducts += 7;
                                quantity -= 20;
                            }
                        
                            while (quantity >= 7) {
                                freeProducts += 1;
                                quantity -= 7;
                            }
                        
                            return freeProducts;
                        }

    function generateData() {
        for (let i = 1; i <= maxQuantity; i++) {
            const freeProducts = calculateFreeProducts(i);
            data.push({ purchaseQuantity: i, freeProducts: freeProducts });
        }
    }

    function renderTable(page) {
        const reportBody = document.getElementById('reportBody');
        reportBody.innerHTML = '';

        const start = (page - 1) * recordsPerPage;
        const end = Math.min(start + recordsPerPage, data.length);

        for (let i = start; i < end; i++) {
            const row = `<tr><td>${data[i].purchaseQuantity}</td><td>${data[i].freeProducts}</td></tr>`;
            reportBody.innerHTML += row;
        }

        document.getElementById('pageInfo').textContent = `Page ${page} of ${totalPages}`;
    }

    function nextPage() {
        if (currentPage < totalPages) {
            currentPage++;
            renderTable(currentPage);
        }
    }

    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            renderTable(currentPage);
        }
    }

    generateData();
    renderTable(currentPage);
</script>












                    <!-- a end -->
                </div>



                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
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
                    <?php
                        include 'dbconfig.php';
                        
                        // Initial query (optional) or leave this out if you only load data via AJAX
                        $select = "SELECT * FROM raheel1 WHERE product_name = 'MEDICS TOOT SIAH PLUS 120ML'";
                        
                        
                        
                        
                        $select_q = mysqli_query($conn, $select);
                        $data = mysqli_num_rows($select_q);
                        ?>
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
                                        <th>Actual Bonus Quantity</th>
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




                <div class="tab-pane fade" id="nav-group" role="tabpanel" aria-labelledby="nav-group-tab" tabindex="0">
                    <!-- b start  -->
                    <h6 class="text-center py-1">Group Inv
                        <!-- <span>
                        All Data ::::::: <?php echo htmlspecialchars($all_count); ?>
                        </span>     -->
                        <span style='float:right!important'>
                        <button id="excel3" class="btn btn-success btn-sm dataExport" data-type="excel">Excel</button>
                        <input id="filter3" type="text" class="form-control w-50" placeholder="Search here..." style="height: 25px; display:inline;font-size:11px!important">
                        </span>
                    </h6>
                    <?php
                        include 'dbconfig.php';
                        
                        // Define the SQL query to retrieve data
                        $select = "
                            SELECT depot_name, inv, COUNT(*) as count
                            FROM raheel1 
                             WHERE product_name = 'MEDICS TOOT SIAH PLUS 120ML'
                            GROUP BY depot_name, inv
                            HAVING COUNT(*) > 1
                        ";
                        
                        // Execute the query
                        $select_q = mysqli_query($conn, $select);
                        
                        // Check if query execution was successful
                        if (!$select_q) {
                            die("Query failed: " . mysqli_error($conn));
                        }
                        
                        // Fetch the results
                        $data = mysqli_fetch_all($select_q, MYSQLI_ASSOC);
                        ?>
                    <div class="table-wrapper">
                        <div class="table-responsive table-container">
                            <table class="table table-striped" id="myTable2">
                                <thead>
                                    <tr>
                                        <!-- Table Headers -->
                                        <th>Depot Name</th>
                                        <th>Inv #</th>
                                        <th>Count</th>
                                    </tr>
                                </thead>
                                <tbody class="searchable3">
                                    <?php
                                        // Check if data exists
                                        if (!empty($data)) {
                                            foreach ($data as $row) {
                                                ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['depot_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['inv']); ?></td>
                                        <td><?php echo htmlspecialchars($row['count']); ?></td>
                                        <!-- Additional columns should be added based on your requirements -->
                                    </tr>
                                    <?php
                                        }
                                        } else {
                                        echo "<tr><td colspan='19' class='text-center'>No data found</td></tr>";
                                        }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
             
                <!-- b end -->
            </div>
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
                <!-- b start  -->
                <?php
                    include 'dbconfig.php';
                    
                    // Fetch product name from the h1 element (in practice, you'd pass this via POST or GET)
                    $product_name = "Rumol Cream 25 G";
                    
                    // First, retrieve all records
                    $sql = "SELECT inv, SUM(sales_qty) as total_sales_qty, SUM(bounty_qty) as total_bounty_qty, dp, depot_name, cust, customer_name, address, class, ivc_date, prd, pack, batch, sales_value, tp_medics, cp_medics, cp_value, deff, product_name 
                            FROM raheel1 
                            WHERE product_name = 'MEDICS TOOT SIAH PLUS 120ML'
                            GROUP BY inv";
                    $result = $conn->query($sql);
                    
                   // Function to calculate the free products (PHP version of your JavaScript function)
                    // function calculateFreeProducts($quantity) {
                    //     $freeProducts = 0;
                    
                    //     while ($quantity >= 50) {
                    //         $freeProducts += 18;
                    //         $quantity -= 50;
                    //     }
                    //     while ($quantity >= 20) {
                    //         $freeProducts += 7;
                    //         $quantity -= 20;
                    //     }
                    //     while ($quantity >= 10) {
                    //         $freeProducts += 3;
                    //         $quantity -= 10;
                    //     }
                    //     while ($quantity >= 5) {
                    //         $freeProducts += 1;
                    //         $quantity -= 5;
                    //     }
                    
                    //     return $freeProducts;
                    // }

                    function calculateFreeProducts($quantity) {
                        $freeProducts = 0;
                    
                        while ($quantity >= 100) {
                            $freeProducts += 40;
                            $quantity -= 100;
                        }
                        while ($quantity >= 50) {
                            $freeProducts += 18;
                            $quantity -= 50;
                        }
                        while ($quantity >= 20) {
                            $freeProducts += 7;
                            $quantity -= 20;
                        }
                        while ($quantity >= 7) {
                            $freeProducts += 1;
                            $quantity -= 7;
                        }
                    
                        return $freeProducts;
                    }
                    

                    $discrepancies = [];
                    $discrepancyCount = 0;
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $totalSalesQty = $row['total_sales_qty'];
                            $totalBountyQty = $row['total_bounty_qty'];
                    
                            // Calculate the expected bonus quantity based on total sales quantity for this inv
                            $expectedBonusQty = calculateFreeProducts($totalSalesQty);
                    
                            // Check if the totalBountyQty doesn't match the expected value
                            if ($totalBountyQty != $expectedBonusQty) {
                                $discrepancies[] = array_merge($row, ['expected_bonus_qty' => $expectedBonusQty]);
                                $discrepancyCount++;
                            }
                        }
                    }
                    
                    // Display the count of discrepancies
                    echo "<div class='container-fluid'>";
                    // echo "<h6 class='text-center py-2'>Discrepancies Found: $discrepancyCount</h6>";
                    echo "</div>";
                    
                    // Display the discrepancies table if any discrepancies are found
                    if (!empty($discrepancies)) {
                        echo "<div class='container-fluid'><row><col>";
                        echo "<h6 class='text-center py-2'>Discrepancies Found: $discrepancyCount
                        <span style='float:right!important'>
                        <button id='excel4' class='btn btn-success btn-sm dataExport' data-type='excel'>Excel</button>
                        <input id='filter4' type='text' class='form-control w-50' placeholder='Search here...' style='height: 25px; display:inline;font-size:'11px!important''>
                        </span></h6>";
                    
                        echo "<div class='table-wrapper'>";
                        echo "<div class='table-responsive table-container'>";
                    
                        echo "<table class='table table-striped' id='myTable1'>";
                        echo "<thead>";
                        echo "<tr><th>Dp</th> <th>Depot Name</th> <th>Cust#</th> <th>CustomerName</th> <th>Address</th><th>Class</th><th>Inv#</th><th>Inv Date</th><th>Prd</th><th>Pack</th><th>Batch</th><th>Sales Value</th> <th>TP Medics</th><th>CP Medics</th><th>CP Value</th><th>Deff</th><th>Product Name</th><th>Total Sales Qty</th><th>Expected Bonus Qty</th><th>Total Actual Bonus Qty</th></tr>";
                        echo "</thead>";
                        echo "<tbody  class='searchable4'>";
                        
                        foreach ($discrepancies as $discrepancy) {
                            echo "<tr>";
                            echo "<td>" . $discrepancy['dp'] . "</td>";
                            echo "<td>" . $discrepancy['depot_name'] . "</td>";
                            echo "<td>" . $discrepancy['cust'] . "</td>";
                            echo "<td>" . $discrepancy['customer_name'] . "</td>";
                            echo "<td>" . $discrepancy['address'] . "</td>";
                            echo "<td>" . $discrepancy['class'] . "</td>";
                            echo "<td>" . $discrepancy['inv'] . "</td>";
                            echo "<td>" . $discrepancy['ivc_date'] . "</td>";
                            echo "<td>" . $discrepancy['prd'] . "</td>";
                            echo "<td>" . $discrepancy['pack'] . "</td>";
                            echo "<td>" . $discrepancy['batch'] . "</td>";
                            echo "<td>" . $discrepancy['sales_value'] . "</td>";
                            echo "<td>" . $discrepancy['tp_medics'] . "</td>";
                            echo "<td>" . $discrepancy['cp_medics'] . "</td>";
                            echo "<td>" . $discrepancy['cp_value'] . "</td>";
                            echo "<td>" . $discrepancy['deff'] . "</td>";
                            echo "<td>" . $discrepancy['product_name'] . "</td>";
                            echo "<td>" . $discrepancy['total_sales_qty'] . "</td>";
                            echo "<td>" . $discrepancy['expected_bonus_qty'] . "</td>";
                            echo "<td>" . $discrepancy['total_bounty_qty'] . "</td>";
                            echo "</tr>";
                        }
                        
                        echo "</tbody>";
                        echo "</table>";
                    
                        echo "</div>";
                        echo "</div>";
                    
                    } else {
                        echo "<h5>No discrepancies found</h5>";
                    }
                    echo "</div>";
                    ?>
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
        $(document).ready(function() {
            let offset = 0; // Initial offset
            const limit = 100; // Number of rows per page
            const $dataBody = $('#data-body');
            const $paginationControls = $('#pagination-controls');
            const $filterInput = $('#filter2');
        
            function loadData() {
                $.ajax({
                    url: 'fetchData_mtss.php', // Adjust this URL to your backend script
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
    </body>
</html>