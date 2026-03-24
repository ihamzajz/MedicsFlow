<?php
    session_start();
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php'); // Redirect to the login page
        exit;
    }
    include 'dbconfig.php';

    
    ?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Field Visit Search</title>
        <style>
            a{
                text-decoration:none;
            }
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
            .fetch-data{
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            padding-bottom: 15px;
            }
            .btn-search {
            background: linear-gradient(45.8deg, rgb(175, 104, 254) 9.3%, rgb(101, 223, 255) 75.1%);
            color: white;
            }
            .section-4{
            /* background-image: linear-gradient(rgba(0,0,0,0),rgba(0,0,0,0.0)),url('assets/images/bg_v1.jpg'); */
            background: linear-gradient(45.8deg, rgb(175, 104, 254) 9.3%, rgb(101, 223, 255) 75.1%);
            height: 100vh;
            background-size: cover;
            }
        </style>
        <style>
            p {
            margin-bottom: 2px; 
            padding-bottom: 0; 
            }
            .label{
            font-size: 16px;
            font-weight:500;
            padding-bottom: 5px;
            }
            .row1-cols{
            background-color: #fefffe;
            padding-top: 15px;
            padding-bottom: 10px;
            margin-right: 20px!important;
            margin-left: 20px!important;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            }
            .row2-cols{
            background-color: #fefffe;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            padding: 15px;
            }
            th{
            font-size: 12px!important;
            }
            td{
            font-size: 13px!important;
            }
            th{
            border-color: #FE6389;
            }
            tr, td{
            border-color: grey;
            }
            .modal-fullscreen {
            width: 100vw;
            max-width: 100%;
            height: 100vh;
            max-height: 100%;
            margin: 0;
            }
            .modal-fullscreen .modal-dialog {
            width: 100%;
            max-width: none;
            height: 100%;
            margin: 0;
            }
            .modal-fullscreen .modal-content {
            height: 100%;
            border: none;
            border-radius: 0;
            }
            button{
            padding: 6px!important;
            }
            .heading-main{
            padding-top: 10px;
            padding-bottom: 10px;
            font-size: 22px;
            font-weight:700;
            color: white;
            background-image: linear-gradient( 109.6deg,  rgba(254,87,98,1) 11.2%, rgba(255,107,161,1) 99.1% );
            }
        </style>
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <div class="wrapper">
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
                <section class="section-4">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-md-4 d-flex flex-column min-vh-100  justify-content-start align-items-center mt-5">
                                <div style="border: 2px solid whites; padding: 25px; padding-bottom: 0px; border-radius: 5px; background-color: white; width: 300px">
                                    <p class="fetch-data pb-3">Fetch Data!</p>
                                    <div class="form-group">
                                        <label for="asmSelect" class="label labelm">Select ASM:</label><br>
                                        <select id="asmSelect">
                                        <?php
                                            include 'dbconfig.php';
                                            $be_depart = $_SESSION['be_depart'];
                                            $be_role = $_SESSION['be_role'];
                                            
                                            $select = "SELECT * FROM users WHERE 
                                            (be_depart = 'saleszsm1' OR be_depart = 'saleszsm2' OR be_depart = 'saleszsm3' OR be_depart = 'saleszsm4') 
                                            AND be_role = 'user'";
                                            
                                            $select_q = mysqli_query($conn, $select);
                                            if (mysqli_num_rows($select_q) > 0) {
                                                while ($row = mysqli_fetch_assoc($select_q)) {
                                                    echo '<option value="' . $row['fullname'] . '">' . $row['fullname'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No user found</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group pt-3">
                                        <label for="dateInput" class="label labelm">Select Date:</label><br>
                                        <input type="date" id="dateInput" name="Date">
                                    </div>
                                    <div class="form-group pt-2">
                                        <button id="searchButton" class="btn btn-search mb-2 w-100" data-type="excel" style="float: left;">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
        <script>
                document.getElementById('searchButton').addEventListener('click', function() {
                    var asmSelect = document.getElementById('asmSelect').value;
                    var dateInput = document.getElementById('dateInput').value;
                    window.location.href = 'field_visit_rp.php?asm=' + asmSelect + '&date=' + dateInput;
                });
        </script>
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