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


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        body {
font-family: 'Poppins', sans-serif;
}
    .btn-menu{
        font-size: 11px;
    }
    .btn{
        font-size: 11px;
        border-radius:0px;
        color:white!important;
    }
            input::placeholder {
            color: black!important; /* Placeholder text color */
            }
        </style>
        <style>

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
    
th{
font-size: 10.5px!important;
border:none!important;
background-color: #0D9276!important;
color:white!important;
}
            table td {
            font-size: 10px;
            color: black!important;
            padding: 5px!important; /* Adjust padding as needed */
            border: 1px solid #ddd;
            background-color: white;
            }

        </style>





    <style>
        input{
            height:10px:!important;
        }
           h6{
        font-size: 16px!important;
    }
        th.hidden, td.hidden {
        display: none;
    }
    .btn-dark,.btn-success,.btn-danger , .btn-info{
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
        
  
        td{
            font-size: 10px!important;

            padding:1!important;
        }
    </style>
    <link rel="stylesheet" href="assets/css/style.css">

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
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </nav>
            <a class="btn btn-dark btn-sm" href="assets_management_home.php" style="font-size:11px!important"><i class="fa-solid fa-arrow-left"></i> Home</a>
             <button id="excel" class="btn btn-success btn-sm dataExport" data-type="excel">Excel</button>
             <input id="filter" type="text" class="form-control w-25" placeholder="Search here..." style="height: 27px; display:inline;font-size:11px">

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
                $select = "SELECT * FROM fixed_assets_disposal_form WHERE finance_status = 'Pending' AND jv_status = 'Approved' ORDER BY date_of_application DESC";

                $select_q = mysqli_query($conn,$select);
                $data = mysqli_num_rows($select_q);
                   ?>
                
                <div class="table-wrapper">
                <div class="table-container1">
                    <table class="table table-bordered" id="myTable">
                  <thead>
                    <tr id="row_<?php echo $row['id']; ?>">
                      <th scope="col" colspan="2">FP&nbsp;Approval</th> 
                      <th scope="col">Id</th>
                      <th scope="col">Disposal&nbsp;Department</th>
                      <th scope="col">Applicant</th> 
                      <th scope="col">Date&nbsp;Of&nbsp;Application</th> 
                      <th scope="col">Name</th> 
                      <th scope="col">Asset&nbsp;Number</th> 
                      <th scope="col">Date&nbsp;Of&nbsp;Purchase</th> 
                      <th scope="col">Qty</th> 
                      <th scope="col">Brand/Specfication</th>
                      <th scope="col">Disposal&nbsp;Date</th>
                      <th scope="col">Original&nbsp;Value</th>
                      <th scope="col">Depreciation&nbsp;Value</th>
                      <th scope="col">Networth</th>
                      <th scope="col">Disposal&nbsp;Reason</th>
                      <th scope="col">Disposal&nbsp;Method</th>
                      <th scope="col">Head&nbsp;Opinion</th>
                      
                    </tr>
                  </thead>
              
                  <?php 
                  if($data){
                    while ($row=mysqli_fetch_array($select_q)) {
                      ?>
                      <tbody class="searchable">
                        <tr id="row_<?php echo $row['id']; ?>">
                          <td>
                          <a href="fixedAssetDisposal_finance_approve.php?id=<?php echo $row['id']; ?>" style="text-decoration: none;"><button class="btn btn-success btn-sm">Approve</button></a>
                          </td>
                          <td>
                                <a href="#" class="btn btn-danger btn-sm" onclick="promptReason(<?php echo $row['id']; ?>)">Reject</a>
                          </td>
                          <td><?php echo $row['id']?></td>
                          <td><?php echo $row['disposal_department']?></td>  
                          <td><?php echo $row['applicant']?></td>  
                          <td><?php echo $row['date_of_application']?></td>  
                          <td><?php echo $row['dc_name']?></td>  
                          <td><?php echo $row['dc_asset_number']?></td>
                          <td><?php echo $row['dc_date_of_purchase']?></td>
                          <td><?php echo $row['dc_quantity']?></td>
                          <td><?php echo $row['dc_brand_specification']?></td>
                          <td><?php echo $row['dc_disposition_date']?></td>
                          <td><?php echo $row['dc_original_value']?></td>
                          <td><?php echo $row['dc_depreciation_value']?></td>     
                          <td><?php echo $row['dc_networth']?></td>
                          <td><?php echo $row['disposal_reason']?></td> 
                          <td><?php echo $row['disposal_method']?></td>
                          <td><?php echo $row['department_head_opinion']?></td>
                          
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
                    window.location.href = "fixedAssetDisposal_finance_reject.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
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