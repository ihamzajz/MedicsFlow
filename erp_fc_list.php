<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php'); // Redirect to the login page
    exit;
}

include 'dbconfig.php';

$id = $_SESSION['id'];
$fullname = $_SESSION['fullname'];
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$email = $_SESSION['email'];
$gender = $_SESSION['gender'];
$department = $_SESSION['department'];
$role = $_SESSION['role'];
$added_date = $_SESSION['added_date'];
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

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <style>
        th{
            font-size: 13px!important;
        }
        td{
            font-size: 13px!important;
        }
    </style>
    
    <link rel="stylesheet" href="assets/css/style.css">

<style>
    /* Define styles for anchor tags within the table for printing */
    @media print {
        #dataTableCont tbody tr a {
            color: black !important; /* Set the color to black */
            text-decoration: none !important; /* Remove underline */
        }
    }
</style>
</style>


    <style>
    /* Define a class to hide elements when printing */
    @media print {
      body * {
        visibility: hidden;
      }

      #dataTableCont, #dataTableCont * {
        visibility: visible;
      }

  </style>
  <script>
    function getPrint() {
    // Hide the "Get Print" button before printing
    var printBtn = document.getElementById('print1');
    if (printBtn) {
        printBtn.style.display = 'none';
    }

    // Hide specific columns (Status and Downloads) in the table for printing
    var statusColumn = document.querySelectorAll('#dataTableCont th:nth-child(9), #dataTableCont td:nth-child(9)');
    var downloadsColumn = document.querySelectorAll('#dataTableCont th:nth-child(10), #dataTableCont td:nth-child(10)');

    statusColumn.forEach(function(col) {
        col.style.display = 'none';
    });

    downloadsColumn.forEach(function(col) {
        col.style.display = 'none';
    });

    // Trigger printing
    window.print();

    // Show the "Get Print" button after printing is done (when returning from print preview)
    if (printBtn) {
        printBtn.style.display = 'block';
    }

    // Show specific columns after printing
    statusColumn.forEach(function(col) {
        col.style.display = ''; // Revert to the default display style
    });

    downloadsColumn.forEach(function(col) {
        col.style.display = ''; // Revert to the default display style
    });
}
    </script>

<script>
    function printRow(rowId) {
        var rowToPrint = document.getElementById("row_" + rowId);
        var printButton = document.querySelector("#row_" + rowId + " button");

        if (printButton) {
            // Hide the print button of the specific row before initiating print
            printButton.style.display = 'none';
        }

        var clonedRow = rowToPrint.cloneNode(true);
        var elementsToHide = clonedRow.querySelectorAll('td:nth-child(9), td:nth-child(10), td:nth-child(11)');
        elementsToHide.forEach(function(element) {
            element.style.display = 'none';
        });

        var originalThead = document.getElementsByTagName('thead')[0];
        var clonedThead = originalThead.cloneNode(true);
        var statusAndDownloadHeaders = clonedThead.querySelectorAll('th:nth-child(9), th:nth-child(10), th:nth-child(11)');
        statusAndDownloadHeaders.forEach(function(header) {
            header.style.display = 'none';
        });

        var closeoutHeader = clonedThead.querySelector('th:nth-child(8)'); // Assuming Closeout is the eighth column
        closeoutHeader.style.display = 'table-cell'; // Display Closeout header

        clonedThead.style.textAlign = 'left';

        var printContent = "<table style='border-collapse: collapse; border: 1px solid black;'>" + clonedThead.outerHTML + clonedRow.outerHTML + "</table>";
        var originalContents = document.body.innerHTML;

        var printIframe = document.createElement('iframe');
        printIframe.style.position = 'fixed';
        printIframe.style.top = '-99999px';
        document.body.appendChild(printIframe);
        var printDocument = printIframe.contentWindow || printIframe.contentDocument;
        if (printDocument.document) printDocument = printDocument.document;

        printDocument.body.innerHTML = '<html><head><title>Print</title><style>@media print{table {border-collapse: collapse; width: 100%;}th, td {border: 1px solid black; padding: 8px;} button { display: none; }} thead { text-align: left; } thead th:nth-child(9), thead th:nth-child(10), thead th:nth-child(11), tbody td:nth-child(9), tbody td:nth-child(10), tbody td:nth-child(11) { display: none; } thead th:nth-child(8), tbody td:nth-child(8) { display: table-cell; }</style></head><body>' + printContent + '</body></html>';

        printIframe.contentWindow.focus();
        printIframe.contentWindow.print();

        printIframe.onload = function () {
            if (printButton) {
                printButton.style.display = 'inline-block';
            }
            document.body.removeChild(printIframe);
        };

        setTimeout(function () {
            if (printButton) {
                printButton.style.display = 'inline-block';
            }
        }, 500);
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

            <p class="text-center pb-2" style="font-size:19px;color:black">List Of Pending FC Requests</p>
                <!-- <p class="text-info" ><a href="books-create.php" style="text-decoration: none; float: right;">Add new book</a></p> -->
                <button id="print1" type="button" class="btn btn-danger btn-sm " onclick="getPrint()">PDF</button>
             <button id="excel" class="btn btn-success btn-sm dataExport" data-type="excel">Excel</button>               
             <input id="filter" type="text" class="form-control w-25" placeholder="Search here..." style="height: 30px; display:inline;">
              <?php

                include 'dbconfig.php';
                $select = "SELECT * FROM erpaccess_form Where department_head_status = 'Approved' AND
                it_head_status='Approved' AND fc_status='Pending'";
                $select_q = mysqli_query($conn,$select);
                $data = mysqli_num_rows($select_q);
                ?>

                <div id="dataTableCont">
                                    <table  class="table table-responsive table-bordered mt-1" id="myTable">
                    <thead class="thead-dark">
                        <tr>
                        <th colspan="2">FC</th>
                      <th scope="col">Id</th>
                      <th scope="col">Name</th>
                      <!-- <th scope="col">Email</th> -->
                      <th scope="col">Message</th>
                      <th scope="col">Date&nbsp;&&nbsp;Time</th>
                      <th scope="col">Department</th>
                      <th scope="col">Role</th>
                      <th scope="col">Type</th>
                      <th scope="col">Scm&nbsp;Purchase</th>
                      <th scope="col">Scm&nbsp;Inventory</th>
                      <th scope="col">ScmP&nbsp;roduction</th>
                      <th scope="col">Scm&nbsp;Sales</th>
                      <th scope="col">Scm&nbsp;Misc</th>
                      <th scope="col">Scm&nbsp;Admin&nbsp;Setup</th>
                      <th scope="col">Scm&nbsp;General&nbsp;Ledger</th>
                      <th scope="col">Scm&nbsp;Accounts&nbsp;Payable</th>
                      <th scope="col">Hcm</th>
                      <!-- <th scope="col">Download</th> -->
                        </tr>
                    </thead>
            
                    <?php 
                    if($data){
                        while ($row=mysqli_fetch_array($select_q)) {
                            ?>
                            <tbody class="searchable">
                                <tr id="row_<?php echo $row['id']; ?>">

                                <td><a href="erp_fc_approve.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email']; ?>&name=<?php echo $row['name']; ?>" class="text-success" style="text-decoration: none;color: green;">Approve<a/></td>
                                    <td ><a href="erp_it_fc.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email']; ?>&name=<?php echo $row['name']; ?>" style="text-decoration: none;color: red;">Reject<a/></td>

                                    <td><?php echo $row['id']?></td>
                                      <td><?php echo $row['name']?></td>
                                      <!-- <td><?php echo $row['email']?></td> -->
                                      <td><?php echo $row['message']?></td>
                                      <td><?php echo $row['date']?></td>
                                      <td><?php echo $row['department']?></td>
                                      <td><?php echo $row['role']?></td>
                                      <td><?php echo $row['req_type']?></td>
                                      <td><?php echo $row['scm_purchase']?></td>
                                      <td><?php echo $row['scm_inventory']?></td>
                                      <td><?php echo $row['scm_production']?></td>
                                      <td><?php echo $row['scm_sales']?></td>
                                      <td><?php echo $row['scm_misc']?></td>
                                      <td><?php echo $row['scm_admin_setup']?></td>
                                      <td><?php echo $row['scm_general_ledger']?></td>
                                      <td><?php echo $row['scm_accounts_payable']?></td>
                                      <td><?php echo $row['hcm']?></td>
                                      
                                    <!-- <td><button id="print2"class="btn btn-danger btn-sm hide-on-print" onclick="printRow(<?php echo $row['id']; ?>)">PDF</button>

                                    </td> -->
                 
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
            
        </div> <!--content-->
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
            $('#myTable').tableExport({ type: 'excel',ignoreColumn: [16,17,18] });
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