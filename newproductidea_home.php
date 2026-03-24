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
        <title>New Product Idea Workflow</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <!-- Bootstrap CSS CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Poppins Font -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
       
        <style>
            body {
  font-family: 'Poppins', sans-serif;
     }
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
            color:white!important;
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
                            <h6 class="pb-2" style="font-weight:600">New Product Idea Workflow</h6>
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
                                       
                                        <td>
                                            <a href="newproductidea_form.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; Submit Form</p>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                      
                                        <td>
                                            <a href="newproductidea_userlist.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; Request History</i></p>
                                            </a>
                                        </td>
                                    </tr>

                          






                                    <tr>
                                        <th colspan="2" style="text-align:left; background-color:#f2f2f2; padding:5px;">BD Department</th>
                                    </tr>


                                    <!-- Deparment Head start  -->
                                    <tr>
                                       
                                        <td>
                                            <a href="newproductidea_bd_list.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; BD Approval</i></p>
                                            </a>
                                        </td>
                                      
                                    </tr>




                                    
                                    <tr>
                                        <th colspan="2" style="text-align:left; background-color:#f2f2f2; padding:5px;">RND Approval</th>
                                    </tr>


                                    <!-- Deparment Head start -->
                                    <tr>
                                        <td>
                                            <a href="newproductidea_rnd_list.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; RND Approval</i></p>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a href="newproductidea_npd_list.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; NPD</i></p>
                                            </a>
                                        </td>
                                    </tr>










                                    <tr>
                                        <th colspan="2" style="text-align:left; background-color:#f2f2f2; padding:5px;">Dashboard</th>
                                    </tr>


                                    <!-- Deparment Head start  -->
                                    <tr>
                                       
                                        <td>
                                            <a href="newproductidea_dashboard_list.php">
                                                <p><i class="fa-solid fa-arrow-right-long"></i> &nbsp; Dashboard</i></p>
                                            </a>
                                        </td>
                                    </tr>

                                    


                                

                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--page content-->
        </div>
        <!--wrapper-->
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
        <script src="assets/js/main.js"></script>
    </body>
</html>