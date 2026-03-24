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
    <title>Digital Form</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>

 <!-- Bootstrap CSS CDN -->
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <style>
        th{
            font-size: 14px!important;
        }
        td{
            font-size: 13px!important;
        }
    </style>
    <link rel="stylesheet" href="assets/css/style.css">



    <style>
    /* Define a class to hide elements when printing */
    @media print {
        body * {
            visibility: visible !important;
        }

        /* Hide CEO and Download columns during print */
        #myTable th:nth-last-child(2),
        #myTable td:nth-last-child(2),
        #myTable th:last-child,
        #myTable td:last-child {
            display: none !important;
        }

        /* Hide the Excel button during print */
        #excel {
            display: none !important;
        }

        /* Hide table body of the second-last column during print */
        #myTable tbody td:nth-last-child(3),
        #myTable tbody th:nth-last-child(3) {
            display: none !important;
        }
    }
</style>


<script>
    function getPrint() {
        var printBtn = document.getElementById('print1');
        if (printBtn) {
            printBtn.style.display = 'none';
        }

        var excelBtn = document.getElementById('excel');
        if (excelBtn) {
            excelBtn.style.display = 'none'; // Hide Excel button
        }

        var table = document.getElementById('myTable');
        if (table) {
            var rows = table.getElementsByTagName('tr');
            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName('td');
                if (cells.length >= 12) { // Assuming CEO and Download are at index 10 and 11, change the index accordingly
                    cells[10].style.display = 'none'; // Hide CEO column
                    cells[11].style.display = 'none'; // Hide Download column
                }
            }
        }

        window.print();

        if (printBtn) {
            printBtn.style.display = 'block';
        }

        if (excelBtn) {
            excelBtn.style.display = 'block'; // Show Excel button after printing
        }

        if (table) {
            var rows = table.getElementsByTagName('tr');
            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName('td');
                if (cells.length >= 12) {
                    cells[10].style.display = ''; // Show CEO column
                    cells[11].style.display = ''; // Show Download column
                }
            }
        }
    }
</script>

<!-- ... (Remaining code remains the same) ... -->


<script>
 function printRow(rowId) {
    var rowToPrint = document.getElementById("row_" + rowId);
    var printButton = document.querySelector("#row_" + rowId + " button");

    if (printButton) {
        printButton.style.display = 'none';
    }

    var table = rowToPrint.closest('table');
    var cells = rowToPrint.getElementsByTagName('td');

    // Hide CEO and Download columns
    if (cells.length >= 12) {
        cells[10].style.display = 'none'; // Hide CEO column
        cells[11].style.display = 'none'; // Hide Download column
        table.rows[0].cells[10].style.display = 'none'; // Hide CEO header
        table.rows[0].cells[11].style.display = 'none'; // Hide Download header
    }

    var printContent = "<table style='border-collapse: collapse; border: 1px solid black;'>" + document.getElementsByTagName('thead')[0].outerHTML + rowToPrint.outerHTML + "</table>";
    var originalContents = document.body.innerHTML;

    // Create a hidden iframe
    var printIframe = document.createElement('iframe');
    printIframe.style.position = 'fixed';
    printIframe.style.top = '-99999px';
    document.body.appendChild(printIframe);
    var printDocument = printIframe.contentWindow || printIframe.contentDocument;
    if (printDocument.document) printDocument = printDocument.document;

    // Set content to be printed in the iframe
    printDocument.body.innerHTML = '<html><head><title>Print</title><style>@media print{table {border-collapse: collapse; width: 100%;}th, td {border: 1px solid black; padding: 8px;} button { display: none; }}</style></head><body>' + printContent + '</body></html>';

    // Print the content in the iframe
    printIframe.contentWindow.focus();
    printIframe.contentWindow.print();

    // Remove the iframe after printing
    printIframe.onload = function () {
        if (printButton) {
            printButton.style.display = 'inline-block';
        }
        // Show CEO and Download columns
        if (cells.length >= 12) {
            cells[10].style.display = ''; // Show CEO column
            cells[11].style.display = ''; // Show Download column
            table.rows[0].cells[10].style.display = ''; // Show CEO header
            table.rows[0].cells[11].style.display = ''; // Show Download header
        }
        document.body.removeChild(printIframe);
    };

    // Show the print button of the specific row again after a delay
    setTimeout(function () {
        if (printButton) {
            printButton.style.display = 'inline-block';
        }
    }, 500); // Adjust the delay timing as needed
}


</script>

        

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

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </nav>

             <h3 class="text-center pb-3" style="font-size: 32px;">Pending (CEO) Workorder Requests</h3>
             <button id="print1" type="button" class="btn btn-danger" onclick="getPrint()">PDF</button>
             <button id="excel" class="btn btn-success dataExport" data-type="excel">Excel</button>
             <input id="filter" type="text" class="form-control w-25" placeholder="Search here..." style="height: 30px; display:inline;">

                <?php

                include 'dbconfig.php';

                $head_depart = $_SESSION['department'];
                // $requester_depart

                $select = "SELECT * FROM workorder_form WHERE
                role = 'Head of department' AND
                ceo_status = 'Pending' AND
                status = '1'";
                $select_q = mysqli_query($conn,$select);
                $data = mysqli_num_rows($select_q);
                ?>

                <div id="dataTableCont">

                <table  class="table table-responsive table-bordered mt-1" id="myTable">
                    <thead class="thead-dark">
                        <tr >
                      <th scope="col">Id</th>
                      <th scope="col">Name</th>
                      <!-- <th scope="col">Email</th> -->
                      <!-- <th scope="col">Date</th> -->
                      <th scope="col">Department</th>
                      <th scope="col">Role</th>
                      <th scope="col">Type </th>
                      <th scope="col">Desc</th>
<!--                       <th scope="col">Amount</th>
                      <th scope="col">M Date</th>
                      <th scope="col">Closeout</th> -->
                      <!-- <th scope="col">Head</th> -->
<!--                       <th scope="col">Engineering</th>
                      <th scope="col">Finance</th> -->
                      <th colspan="2">CEO</th>
                      <th>Download</th>
                        </tr>
                    </thead>
            
                    <?php 
                    if($data){
                        while ($row=mysqli_fetch_array($select_q)) {
                            ?>
                            <tbody class="searchable">
                                <tr id="row_<?php echo $row['id']; ?>">
                                    <td><?php echo $row['id']?>
                                    </td>
                                      <td><?php echo $row['name']?></td>
                                      <!-- <td><?php echo $row['email']?></td> -->
                                      <!-- <td><?php echo $row['date']?></td> -->
                                      <td><?php echo $row['department']?></td>
                                      <td><?php echo $row['role']?></td>
                                      <td><?php echo $row['type']?></td>
                                      <td><?php echo $row['description']?></td>
<!--                                       <td><?php echo $row['amount']?></td>
                                      <td><?php echo $row['m_date_time']?></td>
                                      <td><?php echo $row['closeout']?></td> -->
                                      <!-- <td><?php echo $row['head']?></td> -->
                                  <!--     <td><?php echo $row['engineering']?></td>
                                      <td><?php echo $row['finance']?></td> -->


                                      <td><a href="workorder_ceo_approve.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email']; ?>&name=<?php echo $row['name']; ?>" class="text-success" style="text-decoration: none;color: green;">Approve<a/>
                                    </td>
                                    <td ><a href="workorder_ceo_reject.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email'];?>&name=<?php echo $row['name']; ?>" style="text-decoration: none;color: red;">Reject<a/>
                                    </td>
                                    <td><button id="print2"class="btn btn-danger btn-sm hide-on-print" onclick="printRow(<?php echo $row['id']; ?>)">PDF</button>
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
                
 



      </div><!--content-->
    </div><!--wrapper-->





    

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
            $('#myTable').tableExport({ type: 'excel',ignoreColumn: [6,7,8] });
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