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

    <title>Asset Data</title>
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
           h6{
        font-size: 16px!important;
    }
        th.hidden, td.hidden {
        display: none;
    }
    .btn-dark,.btn-success,.btn-danger, .btn-info{
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


    <style>
        p{
            font-size: 13px;
            padding: 2px;
            margin:0px;
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
    </style>
    <style>
        .heading-main{
            padding-top: 10px;
            padding-bottom: 10px;
            font-size: 22px;
            font-weight:700;
            color: white;
            background-color: #8576FF;
            }
    </style>
    <style>
        th{
            background-color:#0d9276;
            position: sticky;
            top: 0;
            z-index: 1000; /* Ensure it stays above other content */
            font-size: 10px!important;
            border:none!important;
        }
        td{
            font-size: 12px!important;
            border:1px solid black;
            color:black;
            padding:5px!important;
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

            <h6 class="text-center heading-main px-2 py-3">
                        <span style="float:left;">
                        <a href="profile.php"><button class="btn btn-sm btn-dark" >Back</button></a>
                        </span>
                        Active Batch
                       <span style="float:right;">
                       <a href="new_batch.php"><button class="btn btn-sm btn-dark">New Batch</button></a>
                        <a href="active_batch.php"><button class="btn btn-sm btn-dark">Active batch</button></a>
                        <a href="inactive_batch.php"><button class="btn btn-sm btn-dark">Inactive batch</button></a>
                        </span> 
            </h6>



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
                    <button id="excel" class="btn btn-success btn-sm dataExport mb-2 mr-2" style="float: left;">Excel</button>
                    <input id="filter" type="text" class="form-control" placeholder="Search here..." style="display:inline; font-size:14px;">
                    </div>

                  
                </div>

             <?php
                include 'dbconfig.php';
                $id = $_SESSION['id'];
                $name = $_SESSION['fullname'];
                $email = $_SESSION['email'];
                $username = $_SESSION['username'];
                $password = $_SESSION['password'];
                $gender = $_SESSION['gender'];
                $department = $_SESSION['department'];
                $role = $_SESSION['role'];
                $email = $_SESSION['email'];

                $be_depart = $_SESSION['be_depart'];
                $bc_role = $_SESSION['be_role'];

                // $select = "SELECT * FROM workorder_form where username = '$username'";
                $select = "SELECT * FROM batch WHERE status = 'inactive'";

                $select_q = mysqli_query($conn,$select);
                $data = mysqli_num_rows($select_q);
                   ?>
                
              
           
                        <div id="dataTableCont ">
                    <table  class="table table-bordered mt-1 table-striped" id="myTable" style="background-color: #fefefe;box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
                  <thead style="background-color:#0d9276;color:white">
                    <tr id="row_<?php echo $row['id']; ?>">
                    

                    <th scope="col">Id</th> 
                    <th scope="col">Name</th>  
                      <th scope="col">Start&nbsp;Date</th>  
                      <th scope="col">End&nbsp;Date</th> 
                      <th scope="col">Added&nbsp;By</th>
                      <th scope="col">Added&nbsp;Date</th>
                      <th scope="col">Active</th>
                    </tr>
                  </thead>
              
                  <?php 
                  if($data){
                    while ($row=mysqli_fetch_array($select_q)) {
                      ?>
                      <tbody class="searchable">
                        <tr id="row_<?php echo $row['id']; ?>">
                        


                        <td><?php echo $row['id']?></td>
                        <td><?php echo $row['name']?></td>
                          <td><?php echo $row['start_date']?></td>
                          <td><?php echo $row['end_date']?></td>  
                          <td><?php echo $row['user_name']?></td>  
                          <td><?php echo $row['user_date']?></td>
                          <td><a href="batch_make_active.php?id=<?php echo $row['id']; ?>"><button class="btn btn-sm" style=";color:green;font-size:12px">Active</button></a></td>
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
          </div>
       
        </div> <!--page content-->
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
    <!-- <script type="text/javascript">
            $(document).ready(function() {
        $('#excel').click(function() {
            $('#myTable').tableExport({ type: 'excel'});
            //$('#table_report').tableExport({ type: 'excel',escape:'false',ignoreColumn: [15]});
        });
    });
    </script> -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>

<script type="text/javascript">
    document.getElementById('excel').addEventListener('click', function() {
        var table = document.getElementById('myTable');
        var workbook = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
        XLSX.writeFile(workbook, 'export.xlsx');
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











<!-- <script>
    function applyFilters() {
        var fromDate = document.getElementById("fromDate").value;
        var toDate = document.getElementById("toDate").value;
        var taskStatus = document.getElementById("taskStatus").value.toLowerCase().trim();
        var taskDepartment = document.getElementById("taskDepartment").value.toLowerCase().trim();
        var table = document.getElementById("myTable");
        var tr = table.getElementsByTagName("tr");

        for (var i = 1; i < tr.length; i++) {
            var tdDate = tr[i].getElementsByTagName("td")[5];
            var tdStatus = tr[i].getElementsByTagName("td")[0];
            var tdDepartment = tr[i].getElementsByTagName("td")[3];
            var dateValue = tdDate.textContent || tdDate.innerText;
            var statusValue = tdStatus.textContent || tdStatus.innerText;
            var departmentValue = tdDepartment.textContent || tdDepartment.innerText;
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
            if (taskDepartment !== "all" && departmentValue.trim().toLowerCase() !== taskDepartment) {
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





<script>
    function applyFilters() {
        var fromDate = document.getElementById("fromDate").value;
        var toDate = document.getElementById("toDate").value;
        var taskStatus = document.getElementById("taskStatus").value.toLowerCase().trim();
        var taskDepartment = document.getElementById("taskDepartment").value.toLowerCase().trim();
        var table = document.getElementById("myTable");
        var tr = table.getElementsByTagName("tr");

        for (var i = 1; i < tr.length; i++) {
            var tdDate = tr[i].getElementsByTagName("td")[5];
            var tdStatus = tr[i].getElementsByTagName("td")[0];
            var tdDepartment = tr[i].getElementsByTagName("td")[3];
            var dateValue = tdDate.textContent || tdDate.innerText;
            var statusValue = tdStatus.textContent || tdStatus.innerText;
            var departmentValue = tdDepartment.textContent || tdDepartment.innerText;
            var showRow = true;
            var date = new Date(dateValue);
            var from = fromDate ? new Date(fromDate) : null;
            var to = toDate ? new Date(toDate) : null;

            // Ensure the date is valid
            if (!isNaN(date)) {
                if (from && date < from) {
                    showRow = false;
                }
                if (to && date > to) {
                    showRow = false;
                }
            } else {
                showRow = false;
            }

            if (taskStatus !== "all" && statusValue.trim().toLowerCase() !== taskStatus) {
                showRow = false;
            }
            if (taskDepartment !== "all" && departmentValue.trim().toLowerCase() !== taskDepartment) {
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



    <script src="assets/js/main.js"></script>


</body>

</html>