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



            <p class="text-center pb-2" style="font-size:19px;color:black">List of Requests Approved by FC</p>
                <!-- <p class="text-info" ><a href="books-create.php" style="text-decoration: none; float: right;">Add new book</a></p> -->
                <button id="print1" type="button" class="btn btn-danger btn-sm " onclick="getPrint()">PDF</button>
             <button id="excel" class="btn btn-success btn-sm dataExport" data-type="excel">Excel</button>               
             <input id="filter" type="text" class="form-control w-25" placeholder="Search here..." style="height: 30px; display:inline;">
              <?php

                include 'dbconfig.php';
                $select = "SELECT * FROM erpaccess_form Where fc_status='Approved'";
                $select_q = mysqli_query($conn,$select);
                $data = mysqli_num_rows($select_q);
                ?>

                <div id="dataTableCont">
                                    <table  class="table table-responsive table-bordered mt-1" id="myTable">
                    <thead class="thead-dark">
                        <tr>
                        <!-- <th colspan="2">FC</th> -->
                      <th scope="col">Id</th>
                      <th scope="col">Name</th>
                      <!-- <th scope="col">Email</th> -->
                      <th scope="col">Message</th>
                      <th scope="col">Date</th>
                      <th scope="col">Department</th>
                      <th scope="col">Role</th>
                      <th scope="col">Type</th>
                      <th scope="col">Scm&nbsp;Purchase</th>
                      <th scope="col">Scm&nbsp;Inventory</th>
                      <th scope="col">Scm&nbsp;Production</th>
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

                                <!-- <td><a href="erp_fc_approve.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email']; ?>&name=<?php echo $row['name']; ?>" class="text-success" style="text-decoration: none;color: green;">Approve<a/></td>
                                    <td ><a href="erp_it_fc.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email']; ?>&name=<?php echo $row['name']; ?>" style="text-decoration: none;color: red;">Reject<a/></td> -->

                                    <td><?php echo $row['id']?></td>
                                      <td><?php echo $row['name']?></td>
                                      <td><?php echo $row['email']?></td>
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