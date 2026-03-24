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

    <title>Reporting Tool</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/regular.js" integrity="sha384-zTkj7ceO5jTAt7j7cB+XxSgCwVufk25wW2bquXbt6M5q/aX8WtwMjsXE1Mrn0y8j" crossorigin="anonymous"></script>
<style>

    .btn{
        border-radius:0px!important;
    }

     .div-1{
    background-color: #313639;
    color: white;
    font-size: 14px;
    font-weight: 400;
    padding: 13px;
    text-align: center;
    border-radius: 2px;
    border: 2px solid #313639;
    transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease; /* Added transition for box-shadow */
}

.div-1:hover {
    background-color: white;
    color: #313639;
    border-color: white; /* Ensure border matches the background */
    border: 2px solid #313639;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 1); /* Added box shadow */
}
</style>
    <style>
        .btn-menu{
            font-size: 11px;
        }
        th{
            font-size: 13px!important;
        }
        td{
            font-size: 13px!important;
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



<style>
    a{
        text-decoration: none;
        color: black;
    }
    a:hover{
        text-decoration: none;
        color: black;
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

                    <button type="button" id="sidebarCollapse" class="btn btn-info btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>

                </div>
            </nav>

            <h3 class="text-center">Medics Laboratories Digital Workflow</h4>
            <h5 class="text-center pb-2" style="font-weight:bold">Reporting Tool</h5> 
            <div class="text-center pb-4">
            <a href="profile.php"><button class="btn btn-sm" style="background-color: #0d9276;color:white">Back</button></a>
            </div>

            <div class="container">
                <div class="row">

                <?php if($be_depart == 'it' OR $be_depart == 'dir' OR $be_depart == 'eng' OR $username == 'abrash.khan')
                    { ?>
                    <div class="col-md-4"><a href="eng_workorder_rp.php"><p class="div-1">Engineering Workorder</p></a></div>
                    <?php } ?>


                    <?php if($be_depart == 'it' OR $be_depart == 'dir' OR $be_depart == 'admin' OR $username == 'abrash.khan')
                    { ?>
                    <div class="col-md-4"><a href="admin_workorder_rp.php"><p class="div-1">Admin Workorder</p></a></div>           
                    <?php } ?>

                    <?php if($be_depart == 'it' OR $be_depart == 'dir' OR $username == 'abrash.khan')
                    { ?>
                    <div class="col-md-4"><a href="erp_access_dashboard.php"><p class="div-1">ERP Access</p></a></div>
                    <?php } ?>


                    <?php if($be_depart == 'it' OR $be_depart == 'dir' OR $be_depart == 'admin' OR $username == 'abrash.khan')
                    { ?>
                    <div class="col-md-4"><a href="#"><p class="div-1">Travel Request</p></a></div>
                    <?php } ?>



                    <?php if($be_depart == 'it' OR $be_depart == 'dir' OR $be_depart == 'hr' OR $username == 'abrash.khan')
                    { ?>
                    <div class="col-md-4"><a href="newuser_rp.php"><p class="div-1">New User</p></a></div>
                    <?php } ?>


                    <?php if($be_depart == 'it' OR $be_depart == 'dir' OR $username == 'abrash.khan')
                    { ?>
                    <div class="col-md-4"><a href="itacc_dashboard.php"><p class="div-1">IT Accessories</p></a></div>
                    <?php } ?>

                    <?php if($be_depart == 'it' OR $be_depart == 'dir' OR $be_depart == 'fpaa' OR $be_depart == 'fc' OR $username == 'abrash.khan'  OR $be_depart == 'qaqc')
                    { ?>
                    <div class="col-md-4"><a href="assets_data_dashboard.php"><p class="div-1">Assets Management</p></a></div>
                    <div class="col-md-4"><a href="cc_dashboard.php"><p class="div-1">Change Control</p></a></div>
                    <div class="col-md-4"><a href="ot_dashboard_list.php"><p class="div-1">Over Time</p></a></div>
                    <?php } ?>

           

                </div>
                <?php if($be_depart == 'it' OR $be_depart == 'dir' OR ($be_depart == 'salesho' && $be_role == 'approver') OR $username == 'abrash.khan')
                    { ?>


                <h5 class="text-center">Sales</h5>
                <div class="row">
                    
                   <div class="col-md-4"> <a href="bonus_rp_for_all.php"><p class="div-1">Bonus Approval</p></a></div>
                   <div class="col-md-4"><a href="#"><p class="div-1">Field Visit</p></a></div>
                   <div class="col-md-4"><a href="joint_visit_rp_for_all.php"><p class="div-1">Joint Visit</p></a></div>

                </div>
                <?php } ?>
            </div>
   
        </div> <!--page content-->
    </div> <!--wrapper-->

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>

    <script src="assets/js/main.js"></script>


</body>

</html>