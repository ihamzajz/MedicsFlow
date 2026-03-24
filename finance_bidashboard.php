<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php'); // Redirect to the login page
    exit;
}

include 'dbconfig.php';
$username = $_SESSION['username'];


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Online Booking - Power Bi Dashboard</title>
    <?php
    include 'cdncss.php'
        ?>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
  <style>
        .bg-menu {
            background-color: #393E46 !important;
        }

        .btn-menu {
            font-size: 12.5px;
            background-color: #FFB22C !important;
            padding: 5px 10px;
            font-weight: 600;
            border: none !important;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        .btn {
            border-radius: 0px;
            font-size: 11px !important;
        }

        .btn-home {
            background-color: #62CDFF;
            border: 1px solid #62CDFF;
            color: black;
            padding: 5px 10px;
            font-weight: 600;
            border: none !important;
            font-size: 12px;
        }

        .btn-back {
            background-color: #56DFCF;
            color: black;
            padding: 5px 10px;
            font-weight: 600;
            border: 1px solid #56DFCF;
            font-size: 12px;
        }
    </style>

    <?php
    include 'sidebarcss.php'
        ?>
</head>

<body>
    <div class="wrapper" style="background-color: #FAFAFA!important;">
        <?php
        include 'sidebar1.php';
        ?>
        <!-- Page Content  -->
        <div id="content" style="background-color: #FAFAFA!important;">
            <!-- navbar -->
            <nav class="navbar navbar-expand-lg bg-menu">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </nav>
            <?php
            include 'dbconfig.php';

            //echo $_SESSION['role'];
            
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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div style="width: 100vw; height: 100vh; overflow: hidden;">
                            <iframe title="FinanceDashboard"
                                src="https://app.powerbi.com/view?r=eyJrIjoiY2JkNzc5ZWItMTRiNi00ODZkLTg3MjctNTJlNTAwYjNlY2RjIiwidCI6IjkyN2JlMGZhLTM1NzUtNDc3ZC05ZmQ4LTNkNDBjMjM3ZTI3NiIsImMiOjl9"
                                frameborder="0" allowFullScreen="true" style="width: 100%; height: 100%; border: none;">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    <?php
    include 'footer.php'
        ?>