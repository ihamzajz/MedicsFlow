<?php 
    session_start (); 
    
    
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php'); // Redirect to the login page
        exit;
    }
    
    $head_email = $_SESSION['head_email'];
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    //Load Composer's autoloader
    require 'vendor/autoload.php';
    
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    ?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Home</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/style.css">
        <!-- Font Awesome JS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"  rel="stylesheet">
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
 


        <style>
            .headings{
                font-size: 15px;
                font-weight: 600;
                padding-top: 15px;
            }
            .welcome-to{
            font-size: 15px;
            font-weight: 500;
            margin: 0;
            padding: 0;
            }
            .dawam-corp{
            font-size: 30px;
            font-weight: 700;
            margin: 0;
            padding: 0;
            }
            .digital-app{
            font-size:18px!important;
            font-weight: 600;
            margin: 0;
            padding: 0;
            }
            .fa-square-plus, .fa-user, .fa-users-gear, .fa-user-nurse , .fa-user-plus .fa-clone , .fa-table-columns{
            font-size: 20px!important;
            padding-bottom: 10px!important;
            }
            a{
            text-decoration:none;
            color:black;
            }
            p{
                font-size: 12.5px!important;
            }
            .main-box{
            background-color:white;
            
            text-align:center;
            border:1px solid black;
            padding:10px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            }
            body{
            background-color: #F6F6F6;
            }
        </style>







         <style>
            .btn-menu {
            letter-spacing: 0.45px !important; 
            background-color: #49AF45 !important;
            color: white !important;
            font-size: 11.43px !important; 
            font-weight: 500;
            border: 1px solid #49AF45 !important;
            border-radius: 0px !important;
            }
            .btn-menu:hover {
            letter-spacing: 0.45px !important; 
            background-color: #49AF45 !important;
            color: white !important;
            font-size: 11.43px !important; 
            font-weight: 500;
            border: 1px solid #49AF45 !important;
            border-radius: 0px !important;
            }
            .bg-grey{
    background-color: #FAFAFA;
 }
 a{
    text-decoration: none!important;
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
        <div class="wrapper">
            <?php
                include('sidebar1.php');
                ?>
            <!-- Page Content  -->
            <div id="content">
                <!-- navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-grey">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                        </button>
                    </div>
                </nav>
                <?php
                    include 'dbconfig.php';
                    
                     //echo $_SESSION['role'];
                    
                    
         
                    
                    
                   
                    
                    ?>
                <div class="container">

                <!-- row 1 starts -->
                    <div class="row">
                        <div class="col-md-5">
                            <div class="p2-4" style="width: fit-content; white-space: nowrap;">
                                <!-- <h6 class="welcome-to">Welcome to</h6> -->
                                <h4 class="dawam-corp">MedicsFlow</h4>
                                <p class="digital-app">Digital App</p>
                            </div>
                        </div>
                    </div>
                    <h6 class="headings">Forms</h6>
                    <div class="row">
          
                        <div class="col-md-2 pb-1 pb-md-0">
                            <a href="site_open_form.php">
                                <div class="main-box">
                                    <p> <i class="fa-regular fa-square-plus"></i> <br><span>Workorder</span><br><span>Form</span></p>
                                </div>
                            </a>
                        </div>
                
                        <div class="col-md-2 pb-1 pb-md-0">
                            <a href="vendor_site_list.php">
                                <div class="main-box">
                                    <p><i class="fa-solid fa-user"></i><br><span>IT Accessories</span><br><span> Form</span></p>
                                </div>
                            </a>
                        </div>
               
                        <div class="col-md-2 pb-1 pb-md-0">
                            <a href="vendor_team_site_list.php">
                                <div class="main-box">
                                    <p><i class="fa-solid fa-users-gear"></i><br><span>New User</span><br><span> Form</span></p>
                                </div>
                            </a>
                        </div>
                    
                        <div class="col-md-2 pb-1 pb-md-0">
                            <a href="sitesupervisor_site_list.php">
                                <div class="main-box">
                                    <p><i class="fa-solid fa-user-nurse"></i><br><span>ERP Access </span><br><span> Form</span></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 pb-1 pb-md-0">
              <a href="site_open_form.php">
                  <div class="main-box">
                      <p> <i class="fa-regular fa-square-plus"></i> <br><span>Change Control </span><br><span> Form</span></p>
                  </div>
              </a>
          </div>

          
          <div class="col-md-2 pb-1 pb-md-0">
              <a href="vendor_site_list.php">
                  <div class="main-box">
                      <p><i class="fa-solid fa-user"></i><br><span>Staff Allocation </span><br><span> Form</span></p>
                  </div>
              </a>
          </div>
                    </div>
                    <!-- row 1 ends -->




                    <!-- row 2 start  -->
                    <div class="row pt-2">
          
          
  
 
          <div class="col-md-2 pb-1 pb-md-0">
              <a href="vendor_team_site_list.php">
                  <div class="main-box">
                      <p><i class="fa-solid fa-users-gear"></i><br><span>Over Time</span><br><span> Form</span></p>
                  </div>
              </a>
          </div>
      
          <!-- <div class="col-md-3 pb-1 pb-md-0">
              <a href="sitesupervisor_site_list.php">
                  <div class="main-box">
                      <p><i class="fa-solid fa-user-nurse"></i><br><span>ERP Access </span><br><span> Form</span></p>
                  </div>
              </a>
          </div> -->
      </div>
      <!-- row 1 ends -->
                    <!-- row 2 end -->







                         <!-- row 3 starts  -->
        <h6 class="headings mt-3">Automation Apps</h6>
                    <div class="row pb-md-1">
                  
                        <div class="col-md-2 pb-1 pb-md-0">
                            <a href="admin_manage_users.php">
                                <div class="main-box">
                                    <p><i class="fa-solid fa-user-plus"></i><br><span>Vehicle</span><br><span>Management</span></p>
                                </div>
                            </a>
                        </div>
     
                        <div class="col-md-2 pb-1 pb-md-0">
                            <a href="admin_manage_sites_list.php">
                                <div class="main-box">
                                    <p><i class="fa-solid fa-clone"></i><br><span>Meter</span><br><span>Reading</span></p>
                                </div>
                            </a>
                        </div>
                
                        <div class="col-md-2 pb-1 pb-md-0">
                            <a href="management_manage_users.php">
                                <div class="main-box">
                                    <p><i class="fa-solid fa-user-plus"></i><br><span>Scheme </span><br><span> Verification</span></p>
                                </div>
                            </a>
                        </div>
 
                        <div class="col-md-2 pb-1 pb-md-0">
                            <a href="vendor_manage_users.php">
                                <div class="main-box">
                                    <p><i class="fa-solid fa-user-plus"></i><br><span>Labb</span><br><span>Manage Users</span></p>
                                </div>
                            </a>
                        </div>
                       
                       
                    </div>






                    <!-- row 2 starts  -->
                    <h6 class="headings mt-3">PowerBI Dashboards</h6>
                    <div class="row">
                     
                        <div class="col-md-2 pb-1 pb-md-0">
                            <a href="management_dashboard_listt.php">
                                <div class="main-box">
                                    <p><i class="fa-solid fa-table-columns"></i><br><span>Technology</span><br><span>.</span></p>
                                </div>
                            </a>
                        </div>
           
                        <div class="col-md-2 pb-1 pb-md-0">
                            <a href="vendor_dashboard_list.php">
                                <div class="main-box">
                                    <p><i class="fa-solid fa-table-columns"></i><br><span>Online </span><br><span>Booking</span></p>
                                </div>
                            </a>
                        </div>
                    
                        <div class="col-md-2 pb-1 pb-md-0">
                            <a href="vendor_team_dashboard_list.php">
                                <div class="main-box">
                                    <p><i class="fa-solid fa-table-columns"></i><br><span>Supply</span><br><span> Chain</span></p>
                                </div>
                            </a>
                        </div>
               
                        <div class="col-md-2 pb-1 pb-md-0">
                            <a href="site_supervisor_dashboard_list.php">
                                <div class="main-box">
                                    <p><i class="fa-solid fa-table-columns"></i><br><span>Finance </span><br><span>.</span></p>
                                </div>
                            </a>
                        </div>
              
                    </div>
                    <!-- row 2 ends -->


                      <!-- row 2 starts  -->
                      <h6 class="headings mt-3">Sales Forms</h6>
                    <div class="row">
                     
                        <div class="col-md-2 pb-1 pb-md-0">
                            <a href="management_dashboard_listt.php">
                                <div class="main-box">
                                    <p><i class="fa-solid fa-table-columns"></i><br><span>Bonus </span><br><span>Approval</span></p>
                                </div>
                            </a>
                        </div>
           
                        <div class="col-md-2 pb-1 pb-md-0">
                            <a href="vendor_dashboard_list.php">
                                <div class="main-box">
                                    <p><i class="fa-solid fa-table-columns"></i><br><span>Field </span><br><span> Visit</span></p>
                                </div>
                            </a>
                        </div>
                    
                        <div class="col-md-2 pb-1 pb-md-0">
                            <a href="vendor_team_dashboard_list.php">
                                <div class="main-box">
                                    <p><i class="fa-solid fa-table-columns"></i><br><span>Joint </span><br><span> Visit</span></p>
                                </div>
                            </a>
                        </div>
               
                        <div class="col-md-2 pb-1 pb-md-0">
                            <a href="site_supervisor_dashboard_list.php">
                                <div class="main-box">
                                    <p><i class="fa-solid fa-table-columns"></i><br><span>Finance </span><br><span>.</span></p>
                                </div>
                            </a>
                        </div>
              
                    </div>






   
                    <!-- row 3 ends -->

                </div>



          
            </div>
            <!-- container -->
        </div>
        </div>
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

        <script src="../assets/js/main.js"></script>
    </body>
</html>