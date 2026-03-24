<?php
    session_start();
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php');
        exit;
    }
    
    include 'dbconfig.php';
    ?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <title>Bonus Approval Dashboard</title>
        <style>
            #dataTableCont {
    overflow-x: auto;
    white-space: nowrap;
}

#myTable th,
#myTable td {
    min-width: 120px; /* adjust as needed */
    vertical-align: top;
    word-break: break-word;
}
#myTable th:nth-child(9), /* Products */
#myTable td:nth-child(9) {
    min-width: 200px;
}
#myTable th, #myTable td {
    padding: 8px 12px;
    font-size: 14px;
}

        </style>
        <style>
            body {
            font-family: 'Poppins', sans-serif;
            }
            .btn{
            font-size: 11px;
            border-radius:0px;
            color:white!important;
            }
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
            .row1-cols {
            background-color: #fefffe;
            padding-top: 15px;
            padding-bottom: 10px;
            margin-right: 20px!important;
            margin-left: 20px!important;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            }
            .form-control {
            max-width: 100%;
            }
            .row2-cols{
            background-color: #fefffe;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            padding: 15px;
            }
            th{
            font-size: 10.5px!important;
            border:none!important;
            background-color: #0D9276!important;
            color:white!important;
            }
            td{
            font-size: 10.5px!important;
            padding: 5px!important;
            background-color: white!important;
            }
            tr, td{
            border-color: grey;
            }
        </style>
        <style>
            button{
            padding: 6px!important;
            }
            .heading-main{
            padding-top: 10px;
            padding-bottom: 10px;
            font-size: 20px;
            font-weight:700;
            color: white;
            background-color: grey;
            /* background-image: linear-gradient( 109.6deg,  rgba(254,87,98,1) 11.2%, rgba(255,107,161,1) 99.1% ); */
            }
        </style>
        <style>
            th.hidden, td.hidden {
            display: none;
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
            margin-left: -250px;
            }
            #sidebar.active {
            margin-left: 0;
            }
            #sidebar .sidebar-header {
            padding: 20px;
            background: #0d9276!important;
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
            padding-bottom:4px!important;
            font-size: 10.6px !important;
            display: block;
            color: white!important;
            position: relative;
            }
            #sidebar ul li a:hover {
            text-decoration: none;
            }
            #sidebar ul li.active>a,
            a[aria-expanded="true"] {
            color: cyan!important;
            background: #1c9be7!important;
            }
            #sidebar a {
            position: relative;
            padding-right: 40px; 
            }
            .toggle-icon {
            font-size: 12px;
            color: #fff;
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            transition: transform 0.3s;
            }
            .collapse.show + a .toggle-icon {
            transform: translateY(-50%) rotate(45deg); 
            }
            .collapse:not(.show) + a .toggle-icon {
            transform: translateY(-50%) rotate(0deg); 
            }
            ul ul a {
            font-size: 11px!important;
            padding-left: 15px !important;
            background: #263144!important;
            color: #fff!important;
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
            color: #0d9276!important;
            }
            a.article,
            a.article:hover {
            background: #0d9276!important;
            color: #fff!important;
            }
            #content {
            width: 100%;
            padding: 0px;
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
            .filter-container {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-top: 10px;
            }
            .filter-box {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px 15px;
            background-color: #D8D2C2;
            width: 160px;
            }
            .filter-box p {
            margin: 0 0 6px;
            font-weight: 500;
            font-size: 14px;
            }
            .filter-box input,
            .filter-box select {
            width: 100%;
            padding: 6px 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            }
        </style>
    </head>
    <body style="background-color:#fafafa">
        <div class="container-fluid">
        <ul class="nav nav-pills" id="pills-tab" role="tablist"></ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <h4 class="text-center heading-main">
                    <span style="float:left;">
                    <a href="bonus_approval_home.php"><button class="btn btn-sm" style="color: white;font-weight:bold">Back</button></a>
                    </span>
                    Bonus Approval Dashboard
                </h4>
            </div>
            <div class="row">
                <div class="filter-container">
                    <div class="filter-box">
                        <p>Date From</p>
                        <input type="date" name="date_from" id="date_from" onchange="applyFilter()">
                    </div>
                    <div class="filter-box">
                        <p>Date To</p>
                        <input type="date" name="date_to" id="date_to" onchange="applyFilter()">
                    </div>
                    <div class="filter-box">
                        <p>Delivery Status</p>
                        <select name="delivery_status" id="delivery_status">
                            <option value="">All</option>
                            <option value="Delivered">Delivered</option>
                            <option value="Undelivered">Undelivered</option>
                        </select>
                    </div>
                    <div class="filter-box">
                        <p>Zone</p>
                        <select name="zone" id="zone" onchange="applyFilter()">
                            <option value="">All</option>
                            <option value="Zone 1">Zone 1</option>
                            <option value="Zone 2">Zone 2</option>
                            <option value="Zone 3">Zone 3</option>
                            <option value="Zone 4">Zone 4</option>
                            <!-- etc. -->
                        </select>
                    </div>
                    <div class="filter-box">
                        <p>Depot</p>
                        <!-- <select name="depot" id="depot" onchange="applyFilter()">
                        <option value="">Select Zone</option>
                            <option value="M&P Kasur Depot (Smart)">M&P Kasur Depot (Smart)</option>
                            <option value="M&P Kasur Depot (Dumb)">M&P Kasur Depot (Dumb)</option>
                        </select> -->
                        <select  name="depot" id="depot" onchange="applyFilter()">
                        <option value="" >All</option>
                            <?php
                                // Fetch users with role2 == 'Vendor' from the database
                                $query = "SELECT DISTINCT depot_name FROM customer_details ORDER BY depot_name ASC";
                                $result = $conn->query($query);
                                
                                if ($result) {
                                    if ($result->num_rows > 0) {
                                        // Loop through each user and create an option in the dropdown
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . htmlspecialchars($row['depot_name']) . "'>" . htmlspecialchars($row['depot_name']) . "</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled>No Depot Available</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>Error fetching Depot</option>";
                                }
                                ?>
                        </select>
                    </div>
                    <div class="filter-box">
                        <p>Download</p>
                        <button type="button" onclick="downloadExcel()" class="btn btn-sm btn-success">Excel</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php
                        include 'dbconfig.php';
                        $zone = $_SESSION['zone'];
                        $select = "SELECT * FROM bonus_form WHERE zone = '$zone' ORDER BY date DESC";
                        $select_q = mysqli_query($conn, $select);
                        $data = mysqli_num_rows($select_q);
                        ?>
                  <div id="dataTableCont" class="table-responsive" style="overflow-x: auto;">

                        <table class="table table-bordered mt-1" id="myTable">
                            <thead style="background-color: #0D9276;color:white">
                                <tr>
                                    <th scope="col">Ref&nbsp;No</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Asm</th>
                                    <th scope="col">Depot</th>
                                    <th scope="col">zone</th>
                                    <th scope="col">Town</th>
                                    <th scope="col">Customer&nbsp;Name</th>
                                    <th scope="col">Customer&nbsp;Code</th>
                                    <th scope="col">Products</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Actual&nbsp;B</th>
                                    <th scope="col">Additional&nbsp;B</th>
                                    <th scope="col">Total&nbsp;B</th>
                                    <th scope="col">Gift</th>
                                    <th scope="col">withdrawal</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col">Approval</th>
                                    <th scope="col">Rjt&nbsp;Rsn</th>
                                    <th scope="col">Invoice</th>
                                    <th scope="col">Delivery Status</th>
                                </tr>
                            </thead>
                            <tbody class="searchable">
                                <?php 
                                    if ($data) {
                                        while ($row = mysqli_fetch_array($select_q)) {
                                            $products = array();
                                            $quantities = array();
                                            $actual = array();
                                            $additional_bonuses = array();
                                            $total_bonuses = array();
                                            $gifts = array();
                                            $withdrawal = array();
                                            $remarks = array();
                                            
                                            for ($i = 1; $i <= 6; $i++) {
                                                if (!empty($row['products_' . $i])) {
                                                    $products[] = $row['products_' . $i];
                                                    $quantities[] = $row['order_qty_' . $i];
                                                    $actual[] = $row['actual_bonus_' . $i];
                                                    $additional_bonuses[] = $row['additional_bonus_' . $i];
                                                    $total_bonuses[] = $row['total_bonus_' . $i];
                                                    $gifts[] = $row['gift_' . $i];
                                                    $withdrawal[] = $row['withdrawal_' . $i];
                                                    $remarks[] = $row['remarks_' . $i];
                                                }
                                            }
                                            
                                            ?>
                                <tr>
                                    <td><?php echo $row['custom_id']; ?></td>
                                    <td><?php echo $row['date']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['depot']; ?></td>
                                    <td><?php echo $row['zone']; ?></td>
                                    <td><?php echo $row['town']; ?></td>
                                    <td><?php echo $row['customer_name']; ?></td>
                                    <td><?php echo $row['customer_code']; ?></td>
                                    <td><?php echo implode('<br>', $products); ?></td>
                                    <td><?php echo implode('<br>', $quantities); ?></td>
                                    <td><?php echo implode('<br>', $actual); ?></td>
                                    <td><?php echo implode('<br>', $additional_bonuses); ?></td>
                                    <td><?php echo implode('<br>', $total_bonuses); ?></td>
                                    <td><?php echo implode('<br>', $gifts); ?></td>
                                    <td><?php echo implode('<br>', $withdrawal); ?></td>
                                    <td><?php echo implode('<br>', $remarks); ?></td>
                                    <td><?php echo $row['ho_msg']; ?><br><?php echo $row['zsm_msg']; ?></td>
                                    <td><?php echo $row['reason']; ?></td>
                                    <td><?php echo $row['invoice_number']; ?></td>
                                    <td><?php echo $row['delivery_status']; ?></td>
                                </tr>
                                <?php
                                    }
                                    } else {
                                    echo "<tr><td colspan='13'>No record found!</td></tr>";
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function () {
            // Ensure the sidebar is active (visible) by default
            $('#sidebar').addClass('active'); // Change to addClass to show sidebar initially
            
            // Handle sidebar collapse toggle
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
            
            // Update the icon when collapsing/expanding
            $('[data-bs-toggle="collapse"]').on('click', function () {
                var target = $(this).find('.toggle-icon');
                if ($(this).attr('aria-expanded') === 'true') {
                    target.removeClass('fa-plus').addClass('fa-minus');
                } else {
                    target.removeClass('fa-minus').addClass('fa-plus');
                }
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
    function applyFilter() {
        // Retrieve filter values.
        var deliveryStatus = $('#delivery_status').val().trim();
        var dateFromVal = $('#date_from').val();
        var dateToVal = $('#date_to').val();
        var zone = $('#zone').val().trim();
        var depot = $('#depot').val().trim();

        // Convert the date filter inputs to Date objects (if provided)
        var dateFrom = dateFromVal ? new Date(dateFromVal) : null;
        if (dateFrom) { 
            dateFrom.setHours(0,0,0,0); 
        }
        var dateTo = dateToVal ? new Date(dateToVal) : null;
        if (dateTo) { 
            dateTo.setHours(0,0,0,0); 
        }
        
        // Loop through each row in the table.
        $('#myTable tbody tr').each(function() {
            var match = true; // Assume the row matches initially.

            // Delivery Status: now assumed to be in the 20th column.
            var rowDeliveryStatus = $(this).find('td:nth-child(20)').text().trim();

            // Date: assumed to be in the 2nd column.
            var rowDateStr = $(this).find('td:nth-child(2)').text().trim();
            var rowDate = new Date(rowDateStr);
            rowDate.setHours(0,0,0,0);

            // Depot: assumed to be in the 4th column.
            var rowDepot = $(this).find('td:nth-child(4)').text().trim();

            // Zone: assumed to be in the 5th column.
            var rowZone = $(this).find('td:nth-child(5)').text().trim();

            // Apply delivery status filter.
            if (deliveryStatus !== "" && rowDeliveryStatus !== deliveryStatus) {
                match = false;
            }
            // Apply date filters.
            if (dateFrom && rowDate < dateFrom) {
                match = false;
            }
            if (dateTo && rowDate > dateTo) {
                match = false;
            }
            // Apply depot filter.
            if (depot !== "" && rowDepot !== depot) {
                match = false;
            }
            // Apply zone filter (case-insensitive).
            if (zone !== "" && rowZone.toLowerCase() !== zone.toLowerCase()) {
                match = false;
            }

            // Show or hide the row based on whether it matches all filters.
            if (match) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    // Bind the filter function to the change event for all filter inputs.
    $('#delivery_status, #date_from, #date_to, #zone, #depot').on('change', applyFilter);
    
    // Run filtering on page load.
    applyFilter();
    
    // Download Excel function: converts only visible rows to CSV and triggers a download.
    window.downloadExcel = function() {
        var csv = "";
        // First, add the header row: retrieve from the table's thead.
        $('#myTable thead tr').each(function() {
            var row = [];
            $(this).find('th').each(function() {
                row.push('"' + $(this).text().trim().replace(/"/g, '""') + '"');
            });
            csv += row.join(",") + "\n";
        });

        // Then, add each visible row from tbody.
        $('#myTable tbody tr:visible').each(function() {
            var row = [];
            $(this).find('td').each(function() {
                row.push('"' + $(this).text().trim().replace(/"/g, '""') + '"');
            });
            csv += row.join(",") + "\n";
        });

        // Create a Blob object with CSV MIME type.
        var csvFile = new Blob([csv], { type: "text/csv" });

        // Create a temporary link element and trigger the download.
        var downloadLink = document.createElement("a");
        downloadLink.download = "ccdata.csv";  // File name.
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    };
});
</script>









    </body>
</html>