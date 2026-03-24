<?php
    session_start();
    
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php'); // Redirect to the login page
        exit;
    }
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Asset Transfer Form - Details</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <!--Font -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
        <!-- Font Awesome JS -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="assets/css/style.css">
        <style>
            input::placeholder {
            color: black!important; /* Placeholder text color */
            }
        </style>
        <style>
            .btn, .btn-menu{
            font-size: 11px!important;
            border-radius:0px
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
        </style>
        <style>
            .btn{
            font-size: 11px;
            border-radius:0px;
            }
            input{
        font-size: 12px;
        background-color:#f2f2f2;
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 5px;
        border: 1px solid black;
        
    }
            p{
                font-size: 12px!important;
         padding: 0px!important;
         margin: 0px!important;
         font-weight: 500;
            }
            ::placeholder {
            color: black; 
            }
            textarea {
            font-size: 14px; 
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
        <?php
            include 'dbconfig.php';
            ?>
        <div class="wrapper d-flex align-items-stretch">
        <?php
            include 'sidebar.php';
            ?>
        <!-- Page Content  -->
        <div id="content">
        <!-- navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <div class="container-fluid">
                  <button type="button" id="sidebarCollapse" class="btn btn-info btn-menu">
                  <i class="fas fa-align-left"></i>
                  <span>Menu</span>
                  </button>
               </div>
            </nav>
        <?php
            include 'dbconfig.php';
            
            
            $id=$_GET['id'];
            $select = "SELECT * FROM intercompanytransfer_form WHERE
            id = '$id' ";
            
            $select_q = mysqli_query($conn,$select);
            $data = mysqli_num_rows($select_q);
            ?>
        <?php 
            if($data){
            	while ($row=mysqli_fetch_array($select_q)) {
            		?>
        <div class="row justify-content-center">
            <div class="col-12">
                <form class="form pb-3" method="POST">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-10 p-5" Style="border:1px solid black;background-color:White">
                            <h5 class="text-center pb-md-4 pb-3 font-weight-bold"><span style="float:right"><a href="interCompanyTransfer_dashboard.php" class="btn btn-warning btn-sm">Back</a></span>Asset Transfer Form #<?php echo $row['id']?></h5>
                            <!-- row 0 starts -->
                            <div class="row pb-2 justify-content-center" >
                                <div class="col-md-4 pb-md-0 pb-2">
                                    <p>Submitter Name</p>
                                    <input type="text" placeholder="<?php echo $row['transfer_prepared_by']?>" readonly class="w-100">
                                </div>
                                <div class="col-md-4 pb-md-0 pb-2">
                                    <p>Submitter Department</p>
                                    <input type="text" placeholder="<?php echo $row['user_department']?>" readonly class="w-100">
                                </div>
                                <div class="col-md-4 pb-md-0 pb-2">
                                    <p>Form Submission Date</p>
                                    <input type="text" placeholder="<?php echo $row['user_date']?>" readonly class="w-100">
                                </div>
                            </div>
                            <hr>
                            <!-- <h6 class="text-center pb-3">Disposal Content</h6> -->
                            <div class="row pb-2 justify-content-center" >
                                <div class="col-md-4 pb-md-0 pb-2">
                                    <p>Receiving Custodian Name</p>
                                    <input type="text" placeholder="<?php echo $row['rc_name']?>" readonly class="w-100">
                                </div>
                                <div class="col-md-4 pb-md-0 pb-2">
                                    <p>Receiving Custodian No.</p>
                                    <input type="text" placeholder="<?php echo $row['rc_no']?>" readonly class="w-100">
                                </div>
                                <div class="col-md-4 pb-md-0 pb-2">
                                    <p>Department Code</p>
                                    <input type="text" placeholder="<?php echo $row['department']?>" readonly class="w-100">
                                </div>
                            </div>
                            <div class="row pb-2 justify-content-center">
                                <div class="col-md-4 pb-md-0 pb-2">
                                    <p>Date</p>
                                    <input type="text" placeholder="<?php echo $row['date_prepared']?>" readonly class="w-100">
                                </div>
                                <div class="col-md-4 pb-md-0 pb-2">
                                    <p>Asset Tag Number</p>
                                    <input type="text" placeholder="<?php echo $row['asset_tag_number']?>" readonly class="w-100">
                                </div>
                                <div class="col-md-4 pb-md-0 pb-2">
                                    <p>Qty</p>
                                    <input type="text" placeholder="<?php echo $row['qty']?>" readonly class="w-100">
                                </div>
                            </div>
                            <div class="row pb-2 justify-content-center">
                                <div class="col-12">
                                    <p>Description</p>
                                    <input type="text" placeholder="<?php echo $row['description']?>" readonly class="w-100">
                                </div>
                            </div>
                            <div class="row pb-2 justify-content-center">
                                <div class="col-md-4 pb-md-0 pb-2">
                                    <p>S.no</p>
                                    <input type="text" placeholder="<?php echo $row['s_no']?>" readonly class="w-100">
                                </div>
                                <div class="col-md-4 pb-md-0 pb-2">
                                    <p>Cost</p>
                                    <input type="text" placeholder="<?php echo $row['cost']?>" readonly class="w-100">
                                </div>
                                <div class="col-md-4 pb-md-0 pb-2">
                                    <p>Bldg</p>
                                    <input type="text" placeholder="<?php echo $row['bldg']?>" readonly class="w-100">
                                </div>
                            </div>
                            <!-- row 0 ends -->
                            <!-- row 1 starts -->
                            <div class="row pb-2">
                                <div class="col-md-6 pb-md-0 pb-2">
                                    <p>Room</p>
                                    <input type="text" placeholder="<?php echo $row['room']?>" readonly class="w-100">
                                </div>
                                <div class="col-md-6 pb-md-0 pb-2">
                                    <p>Owner Code</p>
                                    <input type="text" placeholder="<?php echo $row['owner_code']?>" readonly class="w-100">
                                </div>
                            </div>
                            <!-- row 1 ends -->
                            <!-- row 2 starts -->
                            <div class="row">
                                <div class="col-md-6 pb-md-0 pb-2">
                                    <p>Comments</p>
                                    <input type="text" placeholder="<?php echo $row['comments']?>" readonly class="w-100">
                                </div>
                                <div class="col-md-6 pb-md-0 pb-2">
                                    <p>Finance</p>
                                    <input type="text" placeholder="<?php echo $row['finance_msg']?>" readonly class="w-100">
                                </div>
                            </div>
                            <!-- row 2 ends -->
                            <!-- <div class="row">
                                <div class="col-12">
                                    <p>Po Approved By Finance</p><span><input type="text" placeholder="<?php echo $row['po_approval_status']?>" readonly class="w-100">
                                    </span>
                                </div>
                                </div> -->
                        </div>
                    </div>
                    <?php
                        }
                        }
                        else{
                        echo "No record found!";
                        }
                        ?>
                </div>
            </div>
        </div>
        <!--wrapper--> 
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
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
        <!-- table export -->
        <script src="
            https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/tableExport.min.js
            "></script>
        <script type="text/javascript" src="libs/FileSaver/FileSaver.min.js"></script>
        <script type="text/javascript" src="../libs/jsPDF/polyfills.umd.js"></script>
        <script type="text/javascript" src="tableExport.min.js"></script>
        <!-- TABLE EXPORT -->
        <!-- ALL -->
        <script type="text/javascript">
            $(document).ready(function() {
            $('#excel').click(function() {
            $('#myTable').tableExport({ type: 'excel',ignoreColumn: [16] });
            });
            });
        </script>
        <!-- ALL -->
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
        <script src="assets/js/main.js"></script>
    </body>
</html>