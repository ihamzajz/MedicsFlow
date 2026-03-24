<?php 
    session_start (); 
    include 'dbconfig.php';
    
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
    
    
    
    
    
    
    
    // Query to get counts of rows from each table
    $all_count_query = "SELECT COUNT(*) AS all_count FROM raheel1";
    $rumol50_count_query = "SELECT COUNT(*) AS rumol50_count FROM raheel1 WHERE product_name = 'RUMOL CREAM 50GMS'";
    $rumol25_count_query = "SELECT COUNT(*) AS rumol25_count FROM raheel1 WHERE product_name = 'RUMOL CREAM 25GMS'";
    $coldeez_count_query = "SELECT COUNT(*) AS coldeez_count FROM raheel1 WHERE product_name = 'COLDEEZ SYRUP'";
    $das_count_query = "SELECT COUNT(*) AS das_count FROM raheel1 WHERE product_name = 'DIGAS ANTACID SUSPENSION 120ML'";
    $dass_count_query = "SELECT COUNT(*) AS dass_count FROM raheel1 WHERE product_name = 'DIGAS ANTACID SUSPENSION SACHET 10ML'";
    $dct_count_query = "SELECT COUNT(*) AS dct_count FROM raheel1 WHERE product_name = 'DIGAS TABLET CLASSIC 120S'";
    $dtkm_count_query = "SELECT COUNT(*) AS dtkm_count FROM raheel1 WHERE product_name = 'DIGAS TABLET KHATTI METHI 120S'";



    // total dcd starts 
    $dcd_count_query = "SELECT COUNT(*) AS dcd_count FROM raheel1 WHERE product_name = 'DIGAS COLIC DROP 20ML'";
    // total dcd ends

    // dcd1 starts
    $dcd1_count_query = "SELECT COUNT(*) AS dcd1_count FROM raheel1 WHERE product_name = 'DIGAS COLIC DROP 20ML'
         AND (
                                ivc_date = '01-Jul-24' OR
                                ivc_date = '02-Jul-24' OR
                                ivc_date = '03-Jul-24' OR
                                ivc_date = '04-Jul-24' OR
                                ivc_date = '05-Jul-24' OR
                                ivc_date = '06-Jul-24' OR
                                ivc_date = '07-Jul-24' OR
                                ivc_date = '08-Jul-24' OR
                                ivc_date = '09-Jul-24' OR
                                ivc_date = '10-Jul-24' OR
                                ivc_date = '11-Jul-24' OR
                                ivc_date = '12-Jul-24' OR
                                ivc_date = '13-Jul-24' OR
                                ivc_date = '14-Jul-24' OR
                                ivc_date = '15-Jul-24' OR
                                ivc_date = '16-Jul-24' OR
                                ivc_date = '17-Jul-24' OR
                                ivc_date = '18-Jul-24' OR
                                ivc_date = '19-Jul-24' OR
                                ivc_date = '20-Jul-24' OR
                                ivc_date = '21-Jul-24' OR
                                ivc_date = '22-Jul-24'
                                )";
    // dcd1 ends


    // dcd2 starts
    $dcd2_count_query = "SELECT COUNT(*) AS dcd2_count FROM raheel1 WHERE product_name = 'DIGAS COLIC DROP 20ML'
    AND (
                            ivc_date = '23-Jul-24' OR
                            ivc_date = '24-Jul-24' OR
                            ivc_date = '25-Jul-24' OR
                            ivc_date = '26-Jul-24' OR
                            ivc_date = '27-Jul-24' OR
                            ivc_date = '28-Jul-24' OR
                            ivc_date = '29-Jul-24' OR
                            ivc_date = '30-Jul-24' OR
                            ivc_date = '31-Jul-24'
                            )";
    // dcd2 ends




    $ds_count_query = "SELECT COUNT(*) AS ds_count FROM raheel1 WHERE product_name = 'DIGAS SYRUP 120ML'";
    $fcfs_count_query = "SELECT COUNT(*) AS fcfs_count FROM raheel1 WHERE product_name = 'FC FORTE SYRUP 120ML'";
    $hs_count_query = "SELECT COUNT(*) AS hs_count FROM raheel1 WHERE product_name = 'HERBITUSS SYRUP 120ML'";
    $ld_count_query = "SELECT COUNT(*) AS ld_count FROM raheel1 WHERE product_name = 'LIVGEN DROPS 20ML'";
    $ls_count_query = "SELECT COUNT(*) AS ls_count FROM raheel1 WHERE product_name = 'LIVGEN SYRUP 120ML'";
    $mccs_count_query = "SELECT COUNT(*) AS mccs_count FROM raheel1 WHERE product_name = 'MEDICS CHILDREN COUGH SYRUP 120ML'";
    $mtsp_count_query = "SELECT COUNT(*) AS mtsp_count FROM raheel1 WHERE product_name = 'MEDICS TOOT SIAH PLUS 120ML'";
    $mi_count_query = "SELECT COUNT(*) AS mi_count FROM raheel1 WHERE product_name = 'MEDICS INHALER 1GM'";
    
    
    








    // Execute queries
    $all_count_result = mysqli_query($conn, $all_count_query);
    $rumol50_count_result = mysqli_query($conn, $rumol50_count_query);
    $rumol25_count_result = mysqli_query($conn, $rumol25_count_query);
    $coldeez_count_result = mysqli_query($conn, $coldeez_count_query);
    $das_count_result = mysqli_query($conn, $das_count_query);
    $dass_count_result = mysqli_query($conn, $dass_count_query);
    $dct_count_result = mysqli_query($conn, $dct_count_query);
    $dtkm_count_result = mysqli_query($conn, $dtkm_count_query);

    $dcd_count_result = mysqli_query($conn, $dcd_count_query);
    $dcd1_count_result = mysqli_query($conn, $dcd1_count_query);
    $dcd2_count_result = mysqli_query($conn, $dcd2_count_query);


    $ds_count_result = mysqli_query($conn, $ds_count_query);
    $fcfs_count_result = mysqli_query($conn, $fcfs_count_query);
    $hs_count_result = mysqli_query($conn, $hs_count_query);
    $ld_count_result = mysqli_query($conn, $ld_count_query);
    $ls_count_result = mysqli_query($conn, $ls_count_query);
    $mccs_count_result = mysqli_query($conn, $mccs_count_query);
    $mtsp_count_result = mysqli_query($conn, $mtsp_count_query);
    $mi_count_result = mysqli_query($conn, $mi_count_query);
    






    // Fetch counts
    $all_count = mysqli_fetch_assoc($all_count_result)['all_count'];
    $rumol50_count = mysqli_fetch_assoc($rumol50_count_result)['rumol50_count'];
    $rumol25_count = mysqli_fetch_assoc($rumol25_count_result)['rumol25_count'];
    $coldeez_count = mysqli_fetch_assoc($coldeez_count_result)['coldeez_count'];
    $das_count = mysqli_fetch_assoc($das_count_result)['das_count'];
    $dass_count = mysqli_fetch_assoc($dass_count_result)['dass_count'];
    $dct_count = mysqli_fetch_assoc($dct_count_result)['dct_count'];
    $dtkm_count = mysqli_fetch_assoc($dtkm_count_result)['dtkm_count'];


    $dcd_count = mysqli_fetch_assoc($dcd_count_result)['dcd_count'];
    $dcd1_count = mysqli_fetch_assoc($dcd1_count_result)['dcd1_count'];
    $dcd2_count = mysqli_fetch_assoc($dcd2_count_result)['dcd2_count'];


    $ds_count = mysqli_fetch_assoc($ds_count_result)['ds_count'];
    $fcfs_count = mysqli_fetch_assoc($fcfs_count_result)['fcfs_count'];
    $hs_count = mysqli_fetch_assoc($hs_count_result)['hs_count'];
    $ld_count = mysqli_fetch_assoc($ld_count_result)['ld_count'];
    $ls_count = mysqli_fetch_assoc($ls_count_result)['ls_count'];
    $mccs_count = mysqli_fetch_assoc($mccs_count_result)['mccs_count'];
    $mtsp_count = mysqli_fetch_assoc($mtsp_count_result)['mtsp_count'];
    $mi_count = mysqli_fetch_assoc($mi_count_result)['mi_count'];
    
    
    
    
    // Initialize variables with default values if they are not set
    $all_count = isset($all_count) ? $all_count : '';
    $rumol50_count = isset($rumol50_count) ? $rumol50_count : '';
    $rumol25_count = isset($rumol25_count) ? $rumol25_count : '';
    $coldeez_count = isset($coldeez_count) ? $coldeez_count : '';
    $das_count = isset($das_count) ? $das_count : '';
    $dass_count = isset($dass_count) ? $dass_count : '';
    $dct_count = isset($dct_count) ? $dct_count : '';
    $dtkm_count = isset($dtkm_count) ? $dtkm_count : '';

    $dcd_count = isset($dcd_count) ? $dcd_count : '';
    $dcd1_count = isset($dcd1_count) ? $dcd1_count : '';
    $dcd2_count = isset($dcd2_count) ? $dcd2_count : '';

    $ds_count = isset($ds_count) ? $ds_count : '';
    $fcfs_count = isset($fcfs_count) ? $fcfs_count : '';
    $hs_count = isset($fcfs_count) ? $hs_count : '';
    $ld_count = isset($ld_count) ? $ld_count : '';
    $ls_count = isset($ls_count) ? $ls_count : '';
    $mccs_count = isset($mccs_count) ? $mccs_count : '';
    $mtsp_count = isset($mtsp_count) ? $mtsp_count : '';
    $mi_count = isset($mi_count) ? $mi_count : '';
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Bonus Scheme - Product List</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <!-- Our Custom CSS -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <!-- Font Awesome JS -->
        <!-- <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
            <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script> -->
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
            color:black!important;
            }
        </style>
        <style>
            .btn{
            font-size: 11px!important;
            }
            a{
            text-decoration:none!important;
            }
            .table-container {
            overflow-y: auto;
            height: 90vh; /* Full viewport height */
            margin: 0;
            padding: 0;
            }
            table {
            width: 100%;
            border-collapse: collapse;
            }
            table th {
            background-color: black!important;;
            position: sticky;
            top: 0;
            z-index: 1000; 
            font-size: 12px;
            border: none!important;
            text-align: left;
            color:white!important;;
            }
            table td {
            font-size: 12px;
            color: black;
            padding: 5px!important; /* Adjust padding as needed */
            border: 1px solid #ddd;
            }
            .table_add_service th{
            background-color:white!important;
            color:black!important;
            font-size: 14px;
            }
        </style>
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
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-7">
                        <h6 class="text-center">July - 2024</h6>
                        <div class="table-wrapper">
                            <div class="table-responsive table-container">
                                <table class="table table-striped" id="myTable2">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><a href="salesmain_all.php">All Data</a></td>
                                            <td><?php echo $all_count; ?></td>
                                        </tr>
                                        <tr>
                                            <td><a href="salesmain_rumol50.php">Rumol 50</a></td>
                                            <td><?php echo $rumol50_count; ?></td>
                                        </tr>
                                        <tr>
                                        <td><a href="salesmain_rumol25.php">Rumol 25</a></td>
                                            <td><?php echo $rumol25_count; ?></td>
                                        </tr>
                                        <tr>
                                            <td><a href="salesmain_coldeez_syrup.php">Coldeez Syrup</a></td>
                                            <td><?php echo $coldeez_count; ?></td>
                                        </tr>
                                        <tr>
                                            <td><a href="salesmain_das.php">Digas Antacid Suspension 120ML</a></td>
                                            <td><?php echo $das_count; ?></td>
                                        </tr>
                                        <tr>
                                            <td><a href="salesmain_dass.php">Digas Antacid Suspension SACHET 10ML</a></td>
                                            <td><?php echo $dass_count; ?></td>
                                        </tr>
                                        <tr>
                                            <td><a href="salesmain_dtc.php">Digas Classic Tab</a></td>
                                            <td><?php echo $dct_count; ?></td>
                                        </tr>
                                        <tr>
                                            <td><a href="salesmain_dtkm.php">Digas Tab. Khatti Meethi</a></td>
                                            <td><?php echo $dtkm_count; ?></td>
                                        </tr>
                                        <tr>
                                            <td><a href="salesmain_dcd.php">Digas Colic Drops <span style="color: blue">(01-Jul-24</span> to <span style="color: blue">22-Jul-24)</span></a>
                                            <br>
                                            <a href="salesmain_dcd2.php">Digas Colic Drops <span style="color: blue">(23-Jul-24</span> to <span style="color: blue">31-Jul-24)</span></a>
                                            <br>
                                            Total:
                                        </td>
                                            <td><?php echo $dcd1_count; ?>
                                            <br>
                                            <?php echo $dcd2_count; ?>
                                            <br>
                                            <?php echo $dcd_count; ?>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td><a href="salesmain_ds.php">Digas Syrup 120ML</a></td>
                                            <td><?php echo $ds_count; ?></td>
                                        </tr>
                                        <tr>
                                            <td><a href="salesmain_fcfs.php">F. C. Forte Syrup</a></td>
                                            <td><?php echo $fcfs_count; ?></td>
                                        </tr>
                                        <tr>
                                            <td><a href="salesmain_hs.php">Herbituss Syrup</a></td>
                                            <td><?php echo $hs_count; ?></td>
                                        </tr>
                                        <tr>
                                            <td><a href="salesmain_ld.php">Livgen Drops</a></td>
                                            <td><?php echo $ld_count; ?></td>
                                        </tr>
                                        <tr>
                                            <td><a href="salesmain_ls.php">Livgen Syrup</a></td>
                                            <td><?php echo $ls_count; ?></td>
                                        </tr>
                                        <tr>
                                            <td><a href="salesmain_mccs.php">Medics Children Cough Syrup</a></td>
                                            <td><?php echo $mccs_count; ?></td>
                                        </tr>
                                        <tr>
                                            <td><a href="salesmain_mtss.php">Medics Toot Siah Plus</a></td>
                                            <td><?php echo $mtsp_count; ?></td>
                                        </tr>
                                        <tr>
                                            <td><a href="salesmain_mi.php">Medics Inhaler</a></td>
                                            <td><?php echo $mi_count; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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