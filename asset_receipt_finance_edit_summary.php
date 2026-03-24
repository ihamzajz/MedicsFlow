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

    <title>Asset Receipt - Userdata</title>
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
        .btn-danger , .btn-success , input{
            font-size: 10px!important;

        }
    </style>
    <style>
        th{
            font-size: 10px!important;
            border:none!important;
        }
        td{
            font-size: 10px!important;
            border:1px solid black;
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
            

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col">
                    <button id="print1" type="button" class="btn btn-danger btn-sm" onclick="getPrint()">PDF</button>
             <button id="excel" class="btn btn-success btn-sm dataExport" data-type="excel">Excel</button>
             <input id="filter" type="text" class="form-control w-25" placeholder="Search here..." style="height: 30px; display:inline;">
             <a href="asset_receipt_finance_edit.php"><button class="btn btn-dark-outline btn-sm" style="font-size:11px;border:1px solid black">Detail View</button></a>

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
                $select = "SELECT * FROM asset_receipt_form WHERE finance_status = 'Approved' ORDER BY user_date DESC";

                $select_q = mysqli_query($conn,$select);
                $data = mysqli_num_rows($select_q);
                   ?>
                
               <div id="dataTableCont table-responsive">
                    <table  class="table table-responsive table-bordered mt-1 table-striped" id="myTable" style="background-color: #fefefe;box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
                  <thead style="background-color:#8576FF;color:white">
                    <tr id="row_<?php echo $row['id']; ?>">
                        <th scope="col">Edit</th> 
                      <th scope="col">Id</th> 

                      <th scope="col">Name</th>  
                      <th scope="col">Department</th>  
                      <!-- <th scope="col">Role</th>  
                      <th scope="col">Date</th>  -->

                      <th scope="col">Asset&nbsp;Receipt&nbsp;From</th> 
                      <!-- <th scope="col">Department</th>  -->
                      <th scope="col">Purchase&nbsp;Date</th> 
                      <th scope="col">Invoice&nbsp;Number</th> 
                      <!-- <th scope="col">Asset&nbsp;Location</th>  -->
                      <th scope="col">Supplier&nbsp;Name</th>

                      <th scope="col">Asset&nbsp;Tag&nbsp;No.</th> 
                      <th scope="col">Qty</th> 
                      <th scope="col">S.no</th>
                      <th scope="col">Description</th> 
                      
                     <th scope="col">Model</th>
                      <th scope="col">Usage</th>
                      <th scope="col">Cost</th> 
                   
                      <!-- <th scope="col">Location</th>
                      <th scope="col">Owner&nbsp;Code</th>
                      <th scope="col">PO&nbsp;Satus</th> -->

                      
                    </tr>
                  </thead>
              
                  <?php 
                  if($data){
                    while ($row=mysqli_fetch_array($select_q)) {
                      ?>
                      <tbody class="searchable">

                        <tr id="row_<?php echo $row['id']; ?>"> 


                        <td><a href="asset_receipt_finance_edit_details.php?id=<?php echo $row['id']; ?>"><button class="btn btn-sm" style="background-color:#0d9276;color:white;font-size:12px">Edit</button></a></td> 
                          <td><?php echo $row['id']?></td> 
                   
                          <td><?php echo $row['user_name']?></td>
                          <td><?php echo $row['user_department']?></td>
                          <!-- <td><?php echo $row['user_role']?></td>
                          <td><?php echo $row['user_date']?></td> -->

                          <td><?php echo $row['ar_from']?></td>  
                          <!-- <td><?php echo $row['ar_department']?></td>   -->
                          <td><?php echo $row['ar_date']?></td>  

                          <td><?php echo $row['ar_invoice_number']?></td> 
                          <!-- <td><?php echo $row['ar_location']?></td>   -->
                          <td><?php echo $row['ar_supplier_name']?></td>  

                          <td><?php echo $row['asset_tag_number']?></td>  
                          <td><?php echo $row['qty']?></td>
                          <td><?php echo $row['s_no']?></td>

                          <td><?php echo $row['description']?></td>

                          <td><?php echo $row['model']?></td>
                          <td><?php echo $row['usage']?></td>
                          <td><?php echo $row['cost']?></td>
                          
                          <!-- <td><?php echo $row['location']?></td>
                          <td><?php echo $row['owner_code']?></td>  
                          <td><?php echo $row['po_approve_status']?></td>        -->
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
            <!--ander ka kaam khatam-->
                    </div>
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
    <script type="text/javascript">
            $(document).ready(function() {
        $('#excel').click(function() {
            $('#myTable').tableExport({ type: 'excel'});
            //$('#table_report').tableExport({ type: 'excel',escape:'false',ignoreColumn: [15]});
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
            function promptReason(itemId) {
                var reason = prompt("Enter reason for rejection:");
                if (reason != null && reason.trim() !== "") {
                    window.location.href = "asset_receipt_finance_reject.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
                }
            }
        </script>
        <script>
            function submitRejectionReason(itemId, reason) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload(); 
                    }
                };
                xhr.open("POST", "update_rejection_reason.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + itemId + "&reason=" + encodeURIComponent(reason));
            }
        </script>

    <script src="assets/js/main.js"></script>


</body>

</html>