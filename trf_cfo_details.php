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
        <title>TRF - Head Approval</title>
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

.ready{
            background-color: #efefef;
            border: none!important;
            border: 1px solid grey!important;
            padding-left: 5px !important;
            }
              p{
            font-size: 14px;
            margin: 0;
            padding: 0;
        }
        select , input, textarea{
            width: 100%;
            font-size: 14px;
            height: 25px;
            color: black!important;
        }
        ::placeholder {
            color: black; 
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
                        <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                        </button>
                    </div>
                </nav>
                <?php
                    include 'dbconfig.php';
                    
                    
                    $id=$_GET['id'];
                    $select = "SELECT * FROM trf WHERE
                    id = '$id' ";
                    
                    $select_q = mysqli_query($conn,$select);
                    $data = mysqli_num_rows($select_q);
                    ?>
                <?php 
                    if($data){
                    	while ($row=mysqli_fetch_array($select_q)) {
                    		?>
                <div class="container">
                    <h4 class="text-center pb-md-4">Travel Request <?php echo $row['id']?> Details</h4>
                    <div class="row pb-1">
                        <!-- row 1 start-->
                        <div class="col-md-3 pb-2">
                            <p>Name:</p>
                            <input type="text" placeholder="<?php echo $row['name']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>Department:</p>
                            <input type="text" placeholder="<?php echo $row['department']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>Role:</p>
                            <input type="text" placeholder="<?php echo $row['role']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>Submission Date:</p>
                            <input type="text" placeholder="<?php echo $row['date']?>" readonly class="ready">
                        </div>
                    </div>
                    <!-- row 1 end-->
                    <div class="row pb-2">
                        <div class="col-md-6">
                            <p>Purpose of Travel</p>
                            <input type="text" placeholder="<?php echo $row['purpose']?>" readonly class="ready">
                        </div>
                        <div class="col-md-6">
                            <p>Reason</p>
                            <input type="text" placeholder="<?php echo $row['reason']?>" readonly class="ready">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 pb-2">
                            <p>Departure From</p>
                            <input type="text" placeholder="<?php echo $row['to_1']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>To</p>
                            <input type="text" placeholder="<?php echo $row['to_2']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>To</p>
                            <input type="text" placeholder="<?php echo $row['to_3']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>To</p>
                            <input type="text" placeholder="<?php echo $row['to_4']?>" readonly class="ready">
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-3">
                            <p>Preferable Date From</p>
                            <input type="text" placeholder="<?php echo $row['date_1']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>To</p>
                            <input type="text" placeholder="<?php echo $row['date_2']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>To</p>
                            <input type="text" placeholder="<?php echo $row['date_3']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>To</p>
                            <input type="text" placeholder="<?php echo $row['date_4']?>" readonly class="ready">
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-3">
                            <p>Preferable Time From</p>
                            <input type="text" placeholder="<?php echo $row['time_1']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>To</p>
                            <input type="text" placeholder="<?php echo $row['time_2']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>To</p>
                            <input type="text" placeholder="<?php echo $row['time_3']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>To</p>
                            <input type="text" placeholder="<?php echo $row['time_4']?>" readonly class="ready">
                        </div>
                    </div>      
                    <div class="row pb-2">
                        <div class="col-md-4">
                            <p>Preferable Flight</p>
                            <input type="text" placeholder="<?php echo $row['preferable_flight']?>" readonly class="ready">
                        </div>
                        <div class="col-md-4">
                            <p>Duration of Visit (In Days)</p>
                            <input type="text" placeholder="<?php echo $row['duration']?>" readonly class="ready">
                        </div>
                        <div class="col-md-4">
                            <p>Expected day of return</p>
                            <input type="text" placeholder="<?php echo $row['expected_days']?>" readonly class="ready">
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-4">
                            <p>Mode Of Travel</p>
                            <input type="text" placeholder="<?php echo $row['mode_of_travel']?>" readonly class="ready">
                        </div>
                        <div class="col-md-4">
                            <p>Hotel Booking Required</p>
                            <input type="text" placeholder="<?php echo $row['hotel_booking']?>" readonly class="ready">
                        </div>
                        <div class="col-md-4">
                            <p>Visa Required</p>
                            <input type="text" placeholder="<?php echo $row['visa_required']?>" readonly class="ready">
                        </div>
                    </div>
                    <h6 class=" py-2">Traveling Advance (For Finance Department)</h6>
                    <div class="row pb-2">
                        <div class="col-md-6">
                            <p for="advance_required">Advance Required</p>
                            <input type="text" placeholder="<?php echo $row['advance_required']?>" readonly class="ready">
                        </div>
                        <div class="col-md-6">
                            <p for="advance_amount">Advance Amount (PKR)</p>
                            <input type="text" placeholder="<?php echo $row['advance_amount']?>" readonly class="ready">
                        </div>
                    </div>

                    <h6><?php echo $row['head_msg']?><<?php echo $row['head_date']?></h6>
                    <div class="row pb-1" >
                        <div class="col-md-1">
                        <a href="trf_cfo_approve.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email']; ?>&name=<?php echo $row['name']; ?>" style="text-decoration: none;"><button class="btn btn-success btn-sm">Approve</button></a>
                        </div>

                        <div class="col-md-1">
                        <a href="trf_cfo_reject.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email'];?>&name=<?php echo $row['name']; ?>" style="text-decoration: none;color: red;"><button class="btn btn-danger btn-sm">Reject</button></a>
                        </div>
                    </div>





                    </div>
                    </div>
                    <!-- row 6 end-->

                </div><!-- container end-->
                
                
                <?php
                    }
                    }
                    else{
                    echo "No record found!";
                    }
                    ?>
            </div>
        </div>
        <!--content-->
        </div> <!--wrapper--> 
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