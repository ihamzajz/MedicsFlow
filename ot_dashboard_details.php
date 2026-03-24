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
        <title>Workorder Detail</title>
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

.btn{
                font-size: 11px;
                border-radius:0px;
            }
            th{
            font-size: 10.5px!important;
            border:none!important;
        }
        td{
            font-size: 10.5px!important;
            background-color:White!important;
            color:black!important;
            padding:2px!important;
            margin:2px!important;
        }
        tr{

        }
            p{
         font-size: 12.5px!important;
         padding: 0px!important;
         margin: 0px!important;
         font-weight: 500;
         }
            input,textarea {
         width: 100% !important;
         font-size: 10.5px!important; 
         border-radius: 0px;
         border: 1px solid grey;
         transition: border-color 0.3s ease;
         padding: 2.5px 5px;
         letter-spacing: 0.4px; 
         height:25px!important;
         }
         input:focus {
         outline: none;
         border: 1px solid black;
         background-color: #FFF4B5;
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
                        <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                        </button>
                    </div>
                </nav>
                <?php
                    include 'dbconfig.php';
                    
                    
                    $id=$_GET['id'];
                    $select = "SELECT * FROM ot WHERE id = '$id'";
                    
                    $select_q = mysqli_query($conn,$select);
                    $data = mysqli_num_rows($select_q);
                    ?>
                <?php 
                    if($data){
                    	while ($row=mysqli_fetch_array($select_q)) {
                    		?>
                <div class="container" style="background-color:White;border:1px solid black">
                    <h6 class="text-center pb-5 pt-3" style="font-weight:bold">Overtime # <?php echo $row['id']?> Details</h6>
                    <div class="row pb-1">



                        <!-- row 1 start-->
                        <div class="col-md-3">
                            <p>Name:</p>
                            <input type="text" placeholder="<?php echo $row['user_name']?>" readonly>
                        </div>
                        <div class="col-md-3">
                            <p>Department:</p>
                            <input type="text" placeholder="<?php echo $row['user_department']?>" readonly>
                        </div>
                        <div class="col-md-3">
                            <p>Role:</p>
                            <input type="text" placeholder="<?php echo $row['user_role']?>" readonly>
                        </div>
                        <div class="col-md-3">
                            <p>Sumbit Date:</p>
                            <input type="text" placeholder="<?php echo $row['user_date']?>" readonly>
                        </div>
                    </div>
        
                    <div class="row pb-1">
                        <!-- row 1 start-->
                        <div class="col-md-3">
                            <p>Date:</p>
                            <input type="text" placeholder="<?php echo $row['ot_date']?>" readonly>
                        </div>
                        <div class="col-md-3">
                            <p>Day:</p>
                            <input type="text" placeholder="<?php echo $row['ot_day']?>" readonly>
                        </div>
                    </div>
                    <hr>
                    <!-- row 1 end-->

                    <table class="table table-responsive">
                    <thead style="background-color:#0D9276;color:white">
                            <tr>
                                <th>Sno</th>
                                <th>Emp #</th>
                                <th>Emp Name</th>
                                <th>Sub Department</th>

                                <th>Time From</th>
                                <th>Time To</th>

                                <th>OT Justification</th>

                                <th colspan="1" style="background-color:grey!important">Status</th>
                                <th colspan="1" style="background-color:grey!important">Status By</th>
                                <th colspan="1" style="background-color:grey!important">Date</th>
                                <th colspan="1" style="background-color:grey!important">Reject Reason</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php if (!empty($row['emp_name_1'])): ?>

                            <tr>
                                <td><input type="text" placeholder="<?php echo $row['sno_1']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['empno_1']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['emp_name_1']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['sub_dept_1']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['time1_from']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['time1_to']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['ot_justification_1']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['status1_1']; ?>" readonly class="mb-2"  title="<?php echo $row['status1_1']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status1_2']; ?>" readonly class="mb-2"  title="<?php echo $row['status1_2']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status1_3']; ?>" readonly class="mb-2"  title="<?php echo $row['status1_3']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status1_4']; ?>" readonly class="mb-2"  title="<?php echo $row['status1_4']; ?>"></td>
                            </tr>

                            <?php endif; ?>

                            <?php if (!empty($row['emp_name_2'])): ?>

                            <tr>
                                <td><input type="text" placeholder="<?php echo $row['sno_2']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['empno_2']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['emp_name_2']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['sub_dept_2']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['time2_from']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['time2_to']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['ot_justification_2']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['status2_1']; ?>" readonly class="mb-2"  title="<?php echo $row['status2_1']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status2_2']; ?>" readonly class="mb-2"  title="<?php echo $row['status2_2']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status2_3']; ?>" readonly class="mb-2"  title="<?php echo $row['status2_3']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status2_4']; ?>" readonly class="mb-2"  title="<?php echo $row['status2_4']; ?>"></td>
                            </tr>
                            </tr>

                            <?php endif; ?>

                            <?php if (!empty($row['emp_name_3'])): ?>

                            <tr>
                                <td><input type="text" placeholder="<?php echo $row['sno_3']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['empno_3']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['emp_name_3']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['sub_dept_3']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['time3_from']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['time3_to']?>" readonly class="mb-2"></td>


                                <td><input type="text" placeholder="<?php echo $row['ot_justification_3']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['status3_1']; ?>" readonly class="mb-2"  title="<?php echo $row['status3_1']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status3_2']; ?>" readonly class="mb-2"  title="<?php echo $row['status3_2']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status3_3']; ?>" readonly class="mb-2"  title="<?php echo $row['status3_3']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status3_4']; ?>" readonly class="mb-2"  title="<?php echo $row['status3_4']; ?>"></td>
                            </tr>
                            </tr>

                            <?php endif; ?>

                            <?php if (!empty($row['emp_name_4'])): ?>

                            <tr>
                                <td><input type="text" placeholder="<?php echo $row['sno_4']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['empno_4']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['emp_name_4']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['sub_dept_4']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['time4_from']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['time4_to']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['ot_justification_4']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['status4_1']; ?>" readonly class="mb-2"  title="<?php echo $row['status4_1']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status4_2']; ?>" readonly class="mb-2"  title="<?php echo $row['status4_2']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status4_3']; ?>" readonly class="mb-2"  title="<?php echo $row['status4_3']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status4_4']; ?>" readonly class="mb-2"  title="<?php echo $row['status4_4']; ?>"></td>
                            </tr>
                            </tr>

                            <?php endif; ?>

                            <?php if (!empty($row['emp_name_5'])): ?>

                            <tr>
                                <td><input type="text" placeholder="<?php echo $row['sno_5']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['empno_5']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['emp_name_5']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['sub_dept_5']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['time5_from']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['time5_to']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['ot_justification_5']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['status5_1']; ?>" readonly class="mb-2"  title="<?php echo $row['status5_1']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status5_2']; ?>" readonly class="mb-2"  title="<?php echo $row['status5_2']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status5_3']; ?>" readonly class="mb-2"  title="<?php echo $row['status5_3']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status5_4']; ?>" readonly class="mb-2"  title="<?php echo $row['status5_4']; ?>"></td>
                            </tr>
                            </tr>

                            <?php endif; ?>

                            <?php if (!empty($row['emp_name_6'])): ?>

                            <tr>
                                <td><input type="text" placeholder="<?php echo $row['sno_6']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['empno_6']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['emp_name_6']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['sub_dept_6']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['time6_from']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['time6_to']?>" readonly class="mb-2"></td>


                                
                                <td><input type="text" placeholder="<?php echo $row['ot_justification_6']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['status6_1']; ?>" readonly class="mb-2"  title="<?php echo $row['status6_1']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status6_2']; ?>" readonly class="mb-2"  title="<?php echo $row['status6_2']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status6_3']; ?>" readonly class="mb-2"  title="<?php echo $row['status6_3']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status6_4']; ?>" readonly class="mb-2"  title="<?php echo $row['status6_4']; ?>"></td>
                            </tr>
                            </tr>

                            <?php endif; ?>

                            <?php if (!empty($row['emp_name_7'])): ?>

                            <tr>
                                <td><input type="text" placeholder="<?php echo $row['sno_7']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['empno_7']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['emp_name_7']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['sub_dept_7']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['time7_from']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['time7_to']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['ot_justification_7']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['status7_1']; ?>" readonly class="mb-2"  title="<?php echo $row['status7_1']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status7_2']; ?>" readonly class="mb-2"  title="<?php echo $row['status7_2']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status7_3']; ?>" readonly class="mb-2"  title="<?php echo $row['status7_3']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status7_4']; ?>" readonly class="mb-2"  title="<?php echo $row['status7_4']; ?>"></td>
                            </tr>
                            </tr>

                            <?php endif; ?>

                            <?php if (!empty($row['emp_name_8'])): ?>

                            <tr>
                                <td><input type="text" placeholder="<?php echo $row['sno_8']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['empno_8']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['emp_name_8']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['sub_dept_8']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['time8_from']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['time8_to']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['ot_justification_8']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['status8_1']; ?>" readonly class="mb-2"  title="<?php echo $row['status8_1']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status8_2']; ?>" readonly class="mb-2"  title="<?php echo $row['status8_2']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status8_3']; ?>" readonly class="mb-2"  title="<?php echo $row['status8_3']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status8_4']; ?>" readonly class="mb-2"  title="<?php echo $row['status8_4']; ?>"></td>
                            </tr>
                            </tr>

                            <?php endif; ?>

                            <?php if (!empty($row['emp_name_9'])): ?>

                            <tr>
                                <td><input type="text" placeholder="<?php echo $row['sno_9']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['empno_9']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['emp_name_9']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['sub_dept_9']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['time9_from']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['time9_to']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['ot_justification_9']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['status9_1']; ?>" readonly class="mb-2"  title="<?php echo $row['status9_1']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status9_2']; ?>" readonly class="mb-2"  title="<?php echo $row['status9_2']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status9_3']; ?>" readonly class="mb-2"  title="<?php echo $row['status9_3']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status9_4']; ?>" readonly class="mb-2"  title="<?php echo $row['status9_4']; ?>"></td>
                            </tr>
                            </tr>

                            <?php endif; ?>

                            <?php if (!empty($row['emp_name_10'])): ?>

                            <tr>
                                <td><input type="text" placeholder="<?php echo $row['sno_10']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['empno_10']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['emp_name_10']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['sub_dept_10']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['time10_from']?>" readonly class="mb-2"></td>
                                <td><input type="text" placeholder="<?php echo $row['time10_to']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['ot_justification_10']?>" readonly class="mb-2"></td>

                                <td><input type="text" placeholder="<?php echo $row['status10_1']; ?>" readonly class="mb-2"  title="<?php echo $row['status10_1']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status10_2']; ?>" readonly class="mb-2"  title="<?php echo $row['status10_2']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status10_3']; ?>" readonly class="mb-2"  title="<?php echo $row['status10_3']; ?>"></td>
                                <td><input type="text" placeholder="<?php echo $row['status10_4']; ?>" readonly class="mb-2"  title="<?php echo $row['status10_4']; ?>"></td>
                            </tr>
                            </tr>

                            <?php endif; ?>

                        </tbody>
                    </table>
                    <div>
                        <h6 class="pb-2">HR Details</h6>
                        <p>HR Status: <?php echo $row['hr_status']?></p>
                        <p>HR Date: <?php echo $row['hr_date']?></p>
                        <p>HR Msg: <?php echo $row['hr_msg']?></p>
                        <p>HR Reject Reason: <?php echo $row['hr_reason']?></p>
                    </div>

                    <div>
                        <h6 class="pb-2 pt-2">FPNA Details</h6>
                        <p>FPNA Status: <?php echo $row['fpna_status']?></p>
                        <p>FPNA Date: <?php echo $row['fpna_date']?></p>
                        <p>FPNA Msg: <?php echo $row['fpna_msg']?></p>
                        <p>FPNA Reject Reason: <?php echo $row['fpna_reason']?></p>
                    </div>
                    <!-- <div>
                        <p><a href="ot_hr_approve.php?id=<?php echo $row['id']; ?>" style="text-decoration: none;"><button class="btn btn-success btn-sm">Approve</button></a>
                        </p>

                        <p><a href="#" class="btn btn-danger btn-sm" onclick="promptReason(<?php echo $row['id']; ?>)">Reject</a>
                        </p>
                    </div> -->
                
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