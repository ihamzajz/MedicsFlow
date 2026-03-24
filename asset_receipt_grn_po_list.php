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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    <!-- Our Custom CSS -->
<!-- Poppins Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- font awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <style>
        body {
font-family: 'Poppins', sans-serif;
}

            input::placeholder {
            color: black!important; /* Placeholder text color */
            }
        </style>
        <style>
     .btn{
            font-size: 11px!important;
            color:white!important;
            border-radius:0px!important;
            }
            a{
            text-decoration:none!important;
            }
            .table-container1 {
            overflow-y: auto;
            height: 93vh; 
            margin: 0;
            padding: 0;
            }
            table {
            width: 100%;
            border-collapse: collapse;
            }
            table th {
            background-color: #0D9276!important;;
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
            color: black!important;
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
            #filter {
            font-size: 14px;
            max-width: 150px;
            height: 28px;
            border-radius: 0px;
            }
            .btn {
            font-size: 11px !important;
            border-radius: 0px !important;
            }
            p {
            font-size: 13px;
            padding: 2px;
            margin: 0px;
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
            h6 {
            font-size: 16px !important;
            }
            th.hidden,
            td.hidden {
            display: none;
            }
            .btn-dark,
            .btn-success,
            .btn-danger,
            .btn-info {
            font-size: 11px;
            }
            .labelm {
            font-size: 11px;
            font-weight: bold;
            }
            select,
            select option,
            input[type=date] {
            font-size: 13px !important;
            height: 10px: !important;
            }
        </style>
        <style>
            .heading-main {
            font-size: 22px !important;
            color: black !important;
            padding: 0px;
            margin:0px;
            font-weight:bold!important;
            }
        </style>
        <style>
            th {
            background-color: #0d9276;
            position: sticky;
            top: 0;
            z-index: 1000;
            font-size: 10px !important;
            border: none !important;
            }
            td {
            font-size: 10px !important;
            color: black;
            padding: 1px !important;
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
</head>
<body>
    <div class="wrapper d-flex align-items-stretch">

    <?php
            include 'sidebar1.php';
        ?>
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-info btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </nav>
            

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col">

                    <a class="btn btn-dark btn-sm" href="assets_management_home.php" style="font-size:11px!important"><i class="fa-solid fa-arrow-left"></i> Home</a>
             <button id="excel" class="btn btn-success btn-sm dataExport" data-type="excel">Excel</button>
             <input id="filter" type="text" class="form-control w-25" placeholder="Search here..." style="height: 30px; display:inline;">

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
                $select = "SELECT * FROM assets 
                WHERE 
                finance_status = 'Pending' AND
                grn_status = 'Pending' AND
                po_no_status = 'Pending' AND
                po_date_status = 'Pending'
                ORDER BY user_date DESC";

                $select_q = mysqli_query($conn,$select);
                $data = mysqli_num_rows($select_q);
                   ?>
                
                <div class="table-wrapper">
                <div class="table-container1">
                    <table  class="table table-bordered mt-1 " id="myTable" style="background-color: #fefefe;box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
                  <thead style="background-color:#0D9276;color:white">
                    <tr id="row_<?php echo $row['id']; ?>">
                      <th scope="col">Edit</th>
                      <th scope="col">id</th> 
                      <th scope="col">Name</th>  
                      <th scope="col">Department</th>  
                      <th scope="col">Role</th>  
                      <th scope="col">Date</th>  

                      <th scope="col">Purchase&nbsp;Date</th> 
                      <th scope="col">Invoice&nbsp;Number</th> 
                      <th scope="col">Asset&nbsp;Location</th> 
                      <th scope="col">Supplier&nbsp;Name</th> 

                      <th scope="col">Asset&nbsp;tag&nbsp;number</th> 
                      <th scope="col">Qty</th>
                      <th scope="col">Model</th> 
                      <th scope="col">Usage</th> 

                      <th scope="col">Cost</th>
                      <th scope="col">Location</th> 
                      <th scope="col">Owner&nbsp;Code</th>
                      <th scope="col">PO&nbsp;Approval</th>

                      <th scope="col">Comments</th>
                     
                    </tr>
                  </thead>
              
                  <?php 
                  if($data){
                    while ($row=mysqli_fetch_array($select_q)) {
                      ?>
                      <tbody class="searchable">
                        <tr id="row_<?php echo $row['id']; ?>"> 
                     
                          <td><a href="asset_receipt_grn_po_details.php?id=<?php echo $row['id']; ?>"><button class="btn btn-sm btn-danger">Edit</button></a></td>                          </td>
    
                          <td><?php echo $row['id']?></td>  

                          <td><?php echo $row['user_name']?></td>
                          <td><?php echo $row['user_department']?></td>
                          <td><?php echo $row['user_role']?></td>
                          <td><?php echo $row['user_date']?></td>

                          <td><?php echo $row['purchase_date']?></td>  
                          <td><?php echo $row['invoice_number']?></td>  
                          <td><?php echo $row['asset_location']?></td>  
                          <td><?php echo $row['supplier_name']?></td> 

                          <td><?php echo $row['asset_tag_number']?></td>  
                          <td><?php echo $row['quantity']?></td>  
                          <td><?php echo $row['model']?></td>  
                          <td><?php echo $row['usage']?></td>

                          <td><?php echo $row['cost']?></td>
                          <td><?php echo $row['location']?></td>
                          <td><?php echo $row['owner_code']?></td>
                          <td><?php echo $row['po_approve_status']?></td>  

                          <td><?php echo $row['comments']?></td>          
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
          </div>
            <!--ander ka kaam khatam-->
                    </div>
                </div>
            </div>
       
        </div> <!--page content-->
    </div> <!--wrapper-->

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