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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Bonus Approval Dashboard</title>
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
            font-size: 11px!important;
            border-color: #FE6389;
        }
        td{
            font-size: 11px!important;
            padding: 5px!important;
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
            font-size: 22px;
            font-weight:700;
            color: white;
            background-color: #8576FF;
            /* background-image: linear-gradient( 109.6deg,  rgba(254,87,98,1) 11.2%, rgba(255,107,161,1) 99.1% ); */
        }
    </style>
<style>
    th.hidden, td.hidden {
        display: none;
    }
</style>

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <ul class="nav nav-pills" id="pills-tab" role="tablist"></ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <h4 class="text-center heading-main">
                    <span style="float:left;">
                        <a href="reportingtool.php"><button class="btn btn-sm" style="color: white;font-weight:bold">Back</button></a>
                    </span>
                    Bonus Approval Dashboard
                </h4>
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
                            <option value="Completed">Approval Completed</option>
                            <option value="Rejected">Rejected</option>
                            <option value="Approval Pending">Approval Pending</option>
                        </select>
                    </div>
                    <div class="col-md-2 col-12 row1-cols">
                        <button id="excel" class="btn btn-success btn-sm dataExport mb-2" data-type="excel" style="float: left;">Excel</button><br>
                        <input id="filter" type="text" class="form-control" placeholder="Search here..." style="height: 30px; display:inline; font-size:14px;">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php
                        include 'dbconfig.php';
                        $select = "SELECT * FROM bonus_form ORDER BY date DESC";
                        $select_q = mysqli_query($conn, $select);
                        $data = mysqli_num_rows($select_q);
                    ?>
                    <div id="dataTableCont" class="table-responsive">
                        <table class="table table-bordered mt-1" id="myTable">
                            <thead style="background-color: #FE6389;color:white">
                                <tr>
                                    <th scope="col" class="hidden">Final&nbsp;Status</th>
                                    <th scope="col" class="hidden">Status</th>
                                    <th scope="col">Ref&nbsp;No</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Asm</th>
                                    <th scope="col">Depot</th>
                                    <th scope="col">Customer&nbsp;Name</th>
                                    <th scope="col">Products</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Actual&nbsp;B</th>
                                    <th scope="col">Additional&nbsp;B</th>
                                    <th scope="col">Total&nbsp;B</th>
                                    <th scope="col">Gift</th>
                                    <th scope="col">Approval</th>
                                    <th scope="col">Rjt&nbsp;Rsn</th>
                                    <th scope="col">Invoice</th>
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
                                        
                                        for ($i = 1; $i <= 6; $i++) {
                                            if (!empty($row['products_' . $i])) {
                                                $products[] = $row['products_' . $i];
                                                $quantities[] = $row['order_qty_' . $i];
                                                $actual[] = $row['actual_bonus_' . $i];
                                                $additional_bonuses[] = $row['additional_bonus_' . $i];
                                                $total_bonuses[] = $row['total_bonus_' . $i];
                                                $gifts[] = $row['gift_' . $i];
                                            }
                                        }
                                        
                                        ?>
                                        <tr>
                                            <td class="hidden"><?php echo $row['final_status']; ?></td>
                                            <td class="hidden"><?php echo $row['task_status']; ?></td>
                                            <td><?php echo $row['custom_id']; ?></td>
                                            <td><?php echo $row['date']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['depot']; ?></td>
                                            <td><?php echo $row['customer_name']; ?></td>
                                            <td><?php echo implode('<br>', $products); ?></td>
                                            <td><?php echo implode('<br>', $quantities); ?></td>
                                            <td><?php echo implode('<br>', $actual); ?></td>
                                            <td><?php echo implode('<br>', $additional_bonuses); ?></td>
                                            <td><?php echo implode('<br>', $total_bonuses); ?></td>
                                            <td><?php echo implode('<br>', $gifts); ?></td>
                                            <td><?php echo $row['ho_msg']; ?><br><?php echo $row['zsm_msg']; ?></td>
                                            <td><?php echo $row['reason']; ?></td>
                                            <td><?php echo $row['invoice_number']; ?></td>
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

        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>
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
        <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/tableExport.min.js"></script>
        <script type="text/javascript" src="libs/FileSaver/FileSaver.min.js"></script>
        <script type="text/javascript" src="../libs/jsPDF/polyfills.umd.js"></script>
        <script type="text/javascript" src="tableExport.min.js"></script>
        <script>
    $(document).ready(function() {
        $('#excel').click(function() {
            $('#myTable').tableExport({
                type: 'excel',
                escape: 'false',
                ignoreColumn: [13, 14]
            });
        });
    });
</script>
        <!-- <script>
            function applyFilters() {
                var fromDate = document.getElementById("fromDate").value;
                var toDate = document.getElementById("toDate").value;
                var taskStatus = document.getElementById("taskStatus").value;
                var table = document.getElementById("myTable");
                var tr = table.getElementsByTagName("tr");

                for (var i = 1; i < tr.length; i++) {
                    var tdDate = tr[i].getElementsByTagName("td")[3];
                    var tdStatus = tr[i].getElementsByTagName("td")[1];
                    var dateValue = tdDate.textContent || tdDate.innerText;
                    var statusValue = tdStatus.textContent || tdStatus.innerText;
                    var showRow = true;
                    var date = new Date(dateValue);
                    var from = fromDate ? new Date(fromDate) : null;
                    var to = toDate ? new Date(toDate) : null;

                    if (from && date < from) {
                        showRow = false;
                    }
                    if (to && date > to) {
                        showRow = false;
                    }
                    if (fromDate && toDate && fromDate === toDate && dateValue !== fromDate) {
                        showRow = false;
                    }
                    if (taskStatus !== "All" && statusValue !== taskStatus) {
                        showRow = false;
                    }

                    if (showRow) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        </script> -->


        <!-- <script>
            function applyFilters() {
    var fromDate = document.getElementById("fromDate").value;
    var toDate = document.getElementById("toDate").value;
    var taskStatus = document.getElementById("taskStatus").value.toLowerCase(); // Convert to lowercase for consistent comparison
    var table = document.getElementById("myTable");
    var tr = table.getElementsByTagName("tr");

    for (var i = 1; i < tr.length; i++) {
        var tdDate = tr[i].getElementsByTagName("td")[3];
        var tdStatus = tr[i].getElementsByTagName("td")[1];
        var dateValue = tdDate.textContent || tdDate.innerText;
        var statusValue = tdStatus.textContent || tdStatus.innerText;
        var showRow = true;
        var date = new Date(dateValue);
        var from = fromDate ? new Date(fromDate) : null;
        var to = toDate ? new Date(toDate) : null;

        if (from && date < from) {
            showRow = false;
        }
        if (to && date > to) {
            showRow = false;
        }
        if (fromDate && toDate && fromDate === toDate && dateValue !== fromDate) {
            showRow = false;
        }
        if (taskStatus !== "all" && statusValue.trim().toLowerCase() !== taskStatus) {
            showRow = false;
        }

        if (showRow) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}

        </script> -->


        <!-- <script>
            function applyFilters() {
    var fromDate = document.getElementById("fromDate").value;
    var toDate = document.getElementById("toDate").value;
    var taskStatus = document.getElementById("taskStatus").value.toLowerCase().trim(); // Convert to lowercase and trim
    var table = document.getElementById("myTable");
    var tr = table.getElementsByTagName("tr");

    for (var i = 1; i < tr.length; i++) {
        var tdDate = tr[i].getElementsByTagName("td")[3];
        var tdStatus = tr[i].getElementsByTagName("td")[0];
        var dateValue = tdDate.textContent || tdDate.innerText;
        var statusValue = tdStatus.textContent || tdStatus.innerText;
        var showRow = true;
        var date = new Date(dateValue);
        var from = fromDate ? new Date(fromDate) : null;
        var to = toDate ? new Date(toDate) : null;

        if (from && date < from) {
            showRow = false;
        }
        if (to && date > to) {
            showRow = false;
        }
        if (fromDate && toDate && fromDate === toDate && dateValue !== fromDate) {
            showRow = false;
        }
        if (taskStatus !== "all" && statusValue.trim().toLowerCase() !== taskStatus) {
            showRow = false;
        }

        // Log the values to debug
        console.log("Row " + i + ": Status Value - " + statusValue.trim().toLowerCase() + ", Task Status - " + taskStatus);

        if (showRow) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}

        </script> -->

        <script>
    function applyFilters() {
        var fromDate = document.getElementById("fromDate").value;
        var toDate = document.getElementById("toDate").value;
        var taskStatus = document.getElementById("taskStatus").value.toLowerCase().trim(); // Convert to lowercase and trim
        var table = document.getElementById("myTable");
        var tr = table.getElementsByTagName("tr");

        for (var i = 1; i < tr.length; i++) {
            var tdDate = tr[i].getElementsByTagName("td")[3];
            var tdStatus = tr[i].getElementsByTagName("td")[1];
            var dateValue = tdDate.textContent || tdDate.innerText;
            var statusValue = tdStatus.textContent || tdStatus.innerText;
            var showRow = true;
            var date = new Date(dateValue);
            var from = fromDate ? new Date(fromDate) : null;
            var to = toDate ? new Date(toDate) : null;

            if (from && date < from) {
                showRow = false;
            }
            if (to && date > to) {
                showRow = false;
            }
            if (fromDate && toDate && fromDate === toDate && dateValue !== fromDate) {
                showRow = false;
            }
            if (taskStatus !== "all" && statusValue.trim().toLowerCase() !== taskStatus) {
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

    </body>
</html>
