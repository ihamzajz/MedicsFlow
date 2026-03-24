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
        <title>Workorder Workflow</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <!-- Our Custom CSS -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
       
        <style>
            table{
            border:1px solid black!important;
            }
            th{
            font-size: 12px!important;
            background-color:#0D9276!important;
            color:white!important;
            }
            td{
            font-size: 11px!important;
            padding:0px!important;
            margin:0px!important;
            border:1px solid black!important;
            padding-top:3px!important;
            padding-bottom:0px!important;
            padding-left:8px!important;
            font-weight: 500!important;
            margin: 0px!important;
            }
            td{
                background: white!important;
            }
            .btn{
            font-size: 11px;
            border-radius:0px;
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
                include 'sidebar1.php';
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
                <div class="container">
                    <div class="row">
                        <div class="col-md-5">
                            <h6 class="pb-2" style="font-weight:600">Work Order Workflow</h6>
                            <table class="table">
                                <thead>
                                    <tr>
                            
                                        <th>
                                            Forms
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                <tr>
                                        <th colspan="2" style="text-align:left; background-color:#f2f2f2; padding:5px;">Asset Receipt</th>
                                    </tr>
                                    <tr>
                                       
                                        <td>
                                            <a href="workorderForm.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; Submit Form</p>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                      
                                        <td>
                                            <a href="workorder_userlist.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; Request History</i></p>
                                            </a>
                                        </td>
                                    </tr>



                                    <tr>
                                        <th colspan="2" style="text-align:left; background-color:#f2f2f2; padding:5px;">Department Head</th>
                                    </tr>


                                    <?php if($be_role = 'approver')
            { ?>
                                    <!-- Deparment Head start  -->
                                    <tr>
                                       
                                        <td>
                                            <a href="workorder_head_list.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; Head Pending Workorder</i></p>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                       
                                        <td>
                                            <a href="workorder_departmenthead_list.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; Department History</i></p>
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- Department head end -->
                                    <?php } ?>


                                    <tr>
                                        <th colspan="2" style="text-align:left; background-color:#f2f2f2; padding:5px;">Engineering Department</th>
                                    </tr>




                                    <?php if($department == 'Engineering' && $role == 'Head of department' OR $be_depart == 'it')
                                     { ?>
                                    <!-- Engineering start  -->
                                    <tr>
                                       
                                        <td>
                                            <a href="workorder_engineering_estimatecost.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; Cost Evaluation</i></p>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                      
                                        <td>
                                            <a href="workorder_engineering_list.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; Cost less than 10,000</i></p>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                     
                                        <td>
                                            <a href="workorder_engineering_closeout.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; Closeout</i></p>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a href="workorder_engineeringall_list.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; All Engineering Workorder</i></p>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a href="eng_workorder_rp.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; Dashboard</i></p>
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- Engineering end -->
                                    <?php } ?> 















                                    <?php if($be_depart == 'eng' && $be_role == 'user' OR $be_depart == 'it')
                                      { ?>
                                    <tr>
                                        <td>
                                            <a href="workorder_engineering_closeout.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; Closeout</i></p>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="workorder_all_list.php.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; All Workorder Requests</i></p>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?> <!-- workorder engineering ends -->






                                    <?php if($department == 'Administration' && $role == 'Manager Administration' OR $username == 'super')
                                        { ?>
                                    <tr>
                                        <th colspan="2" style="text-align:left; background-color:#f2f2f2; padding:5px;">Admin Department</th>
                                    </tr>
                                    <!-- Admin start  -->
                                    <tr>
                                       
                                        <td>
                                            <a href="workorder_admin_estimatecost.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; Cost Evaluation</i></p>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                       
                                        <td>
                                            <a href="workorder_admin_list.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; Cost less than 10,000</i></p>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        
                                        <td>
                                            <a href="workorder_admin_closeout.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; Closeout</i></p>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        
                                        <td>
                                            <a href="workorder_adminall_list.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; All Admin Workorder</i></p>
                                            </a>
                                        </td>
                                    </tr>
                                  


                                    <tr>
                                        <td>
                                            <a href="admin_workorder_rp.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; Dashboard</i></p>
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- Admin end -->
                                    <?php } ?> 

                                    <?php if($role == 'Manager Financial Planning and Analysis' OR $be_depart == 'it' OR ($be_role == 'approver' AND $be_depart == 'finance'))
                    { ?>

                                    <tr>
                                        <th colspan="2" style="text-align:left; background-color:#f2f2f2; padding:5px;">Finance Department</th>
                                    </tr>
                                    <!-- Finance start  -->
                                    <tr>
                                       
                                        <td>
                                            <a href="workorder_finance_list.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; Finance Workorder Requests</i></p>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                       
                                        <td>
                                            <a href="workorder_all_list.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; All Workorder Requests</i></p>
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- Finance end -->
                                    <?php } ?> 

                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--page content-->
        </div>
        <!--wrapper-->
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