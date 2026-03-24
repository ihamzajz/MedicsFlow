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
        <title>Energy Conservation System</title>
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

                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-5">
                        <h3 class="text-center pb-3" style="font-size: 27px;">Add Meters</h3>
                <!-- <p class="text-info" ><a href="books-create.php" style="text-decoration: none; float: right;">Add new book</a></p> -->
                <!-- <button id="print1" type="button" class="btn btn-danger " onclick="getPrint()">PDF</button>
                    <button id="excel" class="btn btn-success  dataExport" data-type="excel">Excel</button>	 -->
                <?php
                    include 'dbconfig.php';

                        // Fetch departments
                        $departments_query = "SELECT id, department_name FROM department";
                        $departments_result = mysqli_query($conn, $departments_query);

                        // Fetch users
                        $users_query = "SELECT id, username FROM users";
                        $users_result = mysqli_query($conn, $users_query);
                     ?>

                <form action="" method="POST" enctype="multipart/form-data" style="border: 1px solid grey; padding:15px;border-radius:5px">
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 15px">Name</label>
                        <input type="text" class="form-control" name="mname" required autocomplete="off" placeholder="Meter name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 15px">Reading</label>
                        <input type="text" class="form-control" name="mreading" required autocomplete="off" placeholder="Initital Reading">
                    </div>
                    <!-- <div class="mb-3">
                        <label class="form-label" style="font-size: 15px">Assign Department</label>
                        <input type="text" class="form-control" name="mdepartment" required autocomplete="off" placeholder="department id">
                    </div> -->
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 15px">Assign Department</label>
                        <select class="form-select" name="mdepartment" required style="width:100%">
                            <option value="">Select Department</option>
                            <?php while ($department = mysqli_fetch_assoc($departments_result)) { ?>
                                <option value="<?php echo $department['id']; ?>"><?php echo $department['department_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <!-- <div class="mb-3">
                        <label class="form-label" style="font-size: 15px">Assign User</label>
                        <input type="text" class="form-control" name="muser" required autocomplete="off" placeholder="Assign user">
                    </div> -->
                    <div class="mb-3">
                    <label class="form-label" style="font-size: 15px">Assign User</label>
                        <select class="form-select" name="muser" required style="width:100%">
                            <option value="">Select User</option>
                            <?php while ($user = mysqli_fetch_assoc($users_result)) { ?>
                                <option value="<?php echo $user['id']; ?>"><?php echo $user['username']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-25" name="meterAdd">Add</button>
                    </div>
                </form>

                <?php
                    if (isset($_POST['meterAdd'])) {
                    $name =  $_POST['mname'];
                    $total_reading =  $_POST['mreading'];
                    $assign_department =  $_POST['mdepartment'];
                    $assign_user =  $_POST['muser'];				
                    
                    $insert = "INSERT INTO meters (name, total_reading, department_id, assigned_user_id) VALUES ('$name', '$total_reading', '$assign_department', '$assign_user')";
                    $insert_q = mysqli_query($conn, $insert);

                    if ($insert_q) {
                        echo "<script>alert('Inserted Successfully');</script>";
                    } else {
                        echo "<script>alert('Insertion Failed');</script>";
                    }
                    
                              
                    }
                    ?>
            </div>

                        </div>

                    </div>

                </div>

               
        </div>
        <!--content-->
        </div> <!--wrapper--> 
        <  <!-- jQuery CDN - Slim version (=without AJAX) -->
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
            $('#myTable').tableExport({ type: 'excel',ignoreColumn: [11,12,15] });
            });
            });
        </script>
        <script src="assets/js/main.js"></script>
    </body>
</html>