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
        <title>Overtime - HR Form</title>
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
                        <button type="button" id="sidebarCollapse" class="btn btn-dark">
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
                    <table class="table">
                        <thead style="background-color:#0D9276;color:white">
                            <tr>
                                <th style="width:5px!important">Sno</th>
                                <th style="width:15px!important">Emp #</th>
                                <th>Emp Name</th>
                                <th>Sub Department</th>
                                <th style="width:15px!important">Time From</th>
                                <th style="width:15px!important">Time To</th>
                                <th style="width:15px!important">Total Time</th>
                                <th>OT Justification</th>
                                <th colspan="1">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- 1 start -->
                            <form method="POST" action="">
                                <?php if (!empty($row['emp_name_1'])): ?>
                                <tr>
                                    <td><input type="text" placeholder="<?php echo $row['sno_1']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['empno_1']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['emp_name_1']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['sub_dept_1']; ?>" readonly class="mb-2"></td>
                                    <td>
                                        <input type="text" id="time1_from" name="time1_from" value="<?php echo $row['time1_from']; ?>" class="mb-2 time-input"  pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$" 
                                            title="Please enter a valid time (HH:MM)" 
                                            maxlength="5">
                                    </td>
                                    <td>
                                        <input type="text" id="time1_to" name="time1_to" value="<?php echo $row['time1_to']; ?>" class="mb-2 time-input"  pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$" 
                                            title="Please enter a valid time (HH:MM)" 
                                            maxlength="5">
                                    </td>
                                    <td>
                                        <input type="text" id="time1_difference" class="mb-2 time-input" placeholder="HH:MM" readonly>
                                    </td>
                                    <td><input type="text" placeholder="<?php echo $row['ot_justification_1']; ?>" readonly class="mb-2"></td>
                                    <td>
                                        <?php if ($row['status1_1'] === 'Approved'): ?>
                                        <p><?php echo htmlspecialchars($row['status1_2'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <?php elseif ($row['status1_1'] === 'Rejected'): ?>
                                        <p><?php echo htmlspecialchars($row['status1_2'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <?php else: ?>
                                        <!-- <a href="ot_hr_approve_1.php?id=<?php echo $row['id']; ?>" style="text-decoration: none;">
                                        <button class="btn btn-success btn-sm">Approve</button>
                                        </a> -->
                                        <button type="button" class="btn btn-success btn-sm" onclick="window.location.href='ot_hr_approve_1.php?id=<?php echo $row['id']; ?>'">Approve</button>
                                        <a href="#" class="btn btn-danger btn-sm" onclick="promptReason1(<?php echo $row['id']; ?>)">Reject</a>
                                        <?php endif; ?>
                                        <!-- Update Button with AJAX -->
                                        <button class="btn btn-primary btn-sm" name="update1">Update</button>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </form>
                            <?php
                                include 'dbconfig.php';
                                
                                // Check if form is submitted
                                if (isset($_POST['update1'])) {
                                    // Retrieve form data
                                    $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                                    $name =  $_SESSION['fullname'];
                                
                                    $time1_from = isset($_POST['time1_from']) && $_POST['time1_from'] !== $row['time1_from'] ? $_POST['time1_from'] : $row['time1_from'];
                                    $time1_to = isset($_POST['time1_to']) && $_POST['time1_to'] !== $row['time1_to'] ? $_POST['time1_to'] : $row['time1_to'];
                                
                                
                                  
                                    $update_query = "UPDATE ot SET 
                                
                                                      time1_from = '$time1_from',
                                                      time1_to = '$time1_to'
                                                    
                                
                                                        WHERE id = '$id'";
                                
                                    // Execute update query
                                    $result = mysqli_query($conn, $update_query);
                                
                                    if ($result) {
                                        // Update successful
                                        echo "<script>
                                alert('Data updated successfully.');
                                window.location.href = window.location.href; // Reload the page
                                </script>";
                                        // Redirect or perform additional actions as needed
                                    } else {
                                        // Update failed
                                        echo "<script>
                                alert('Failed.');
                                window.location.href = window.location.href; // Reload the page
                                </script>";
                                        // Redirect or handle error as needed
                                    }
                                }
                                ?>
                            <!-- 1 end -->
                            <!-- 2 start -->
                            <form method="POST" action="">
                                <?php if (!empty($row['emp_name_2'])): ?>
                                <tr>
                                    <td><input type="text" placeholder="<?php echo $row['sno_2']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['empno_2']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['emp_name_2']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['sub_dept_2']; ?>" readonly class="mb-2"></td>
                                    <td>
                                        <input type="text" id="time2_from" name="time2_from" value="<?php echo $row['time2_from']; ?>" class="mb-2 time-input"  pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$" 
                                            title="Please enter a valid time (HH:MM)" 
                                            maxlength="5">
                                    </td>
                                    <td>
                                        <input type="text" id="time2_to" name="time2_to" value="<?php echo $row['time2_to']; ?>" class="mb-2 time-input"  pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$" 
                                            title="Please enter a valid time (HH:MM)" 
                                            maxlength="5">
                                    </td>
                                    <td>
                                        <input type="text" id="time2_difference" class="mb-2 time-input" placeholder="HH:MM" readonly>
                                    </td>
                                    <td><input type="text" placeholder="<?php echo $row['ot_justification_2']; ?>" readonly class="mb-2"></td>
                                    <td>
                                        <?php if ($row['status2_1'] === 'Approved'): ?>
                                        <p><?php echo htmlspecialchars($row['status2_2'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <?php elseif ($row['status2_1'] === 'Rejected'): ?>
                                        <p><?php echo htmlspecialchars($row['status2_2'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <?php else: ?>
                                        <!-- <a href="ot_hr_approve_2.php?id=<?php echo $row['id']; ?>" style="text-decoration: none;">
                                        <button class="btn btn-success btn-sm">Approve</button>
                                        </a> -->
                                        <button type="button" class="btn btn-success btn-sm" onclick="window.location.href='ot_hr_approve_2.php?id=<?php echo $row['id']; ?>'">Approve</button>

                                        <a href="#" class="btn btn-danger btn-sm" onclick="promptReason2(<?php echo $row['id']; ?>)">Reject</a>
                                        <?php endif; ?>
                                        <!-- Update Button with AJAX -->
                                        <button class="btn btn-primary btn-sm" name="update2">Update</button>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </form>
                            <?php
                                include 'dbconfig.php';
                                
                                // Check if form is submitted
                                if (isset($_POST['update2'])) {
                                    // Retrieve form data
                                    $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                                    $name =  $_SESSION['fullname'];
                                
                                    $time2_from = isset($_POST['time2_from']) && $_POST['time2_from'] !== $row['time2_from'] ? $_POST['time2_from'] : $row['time2_from'];
                                    $time2_to = isset($_POST['time2_to']) && $_POST['time2_to'] !== $row['time2_to'] ? $_POST['time2_to'] : $row['time2_to'];
                                
                                
                                  
                                    $update_query = "UPDATE ot SET 
                                
                                                      time2_from = '$time2_from',
                                                      time2_to = '$time2_to'
                                                    
                                
                                                        WHERE id = '$id'";
                                
                                    // Execute update query
                                    $result = mysqli_query($conn, $update_query);
                                
                                    if ($result) {
                                        // Update successful
                                        echo "<script>
                                alert('Data updated successfully.');
                                window.location.href = window.location.href; // Reload the page
                                </script>";
                                        // Redirect or perform additional actions as needed
                                    } else {
                                        // Update failed
                                        echo "<script>
                                alert('Failed.');
                                window.location.href = window.location.href; // Reload the page
                                </script>";
                                        // Redirect or handle error as needed
                                    }
                                }
                                ?>
                            <!-- 2 end -->
                            <!-- 3 start -->
                            <form method="POST" action="">
                                <?php if (!empty($row['emp_name_3'])): ?>
                                <tr>
                                    <td><input type="text" placeholder="<?php echo $row['sno_3']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['empno_3']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['emp_name_3']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['sub_dept_3']; ?>" readonly class="mb-2"></td>
                                    <td>
                                        <input type="text" id="time3_from" name="time3_from" value="<?php echo $row['time3_from']; ?>" class="mb-2 time-input"  pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$" 
                                            title="Please enter a valid time (HH:MM)" 
                                            maxlength="5">
                                    </td>
                                    <td>
                                        <input type="text" id="time3_to" name="time3_to" value="<?php echo $row['time3_to']; ?>" class="mb-2 time-input"  pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$" 
                                            title="Please enter a valid time (HH:MM)" 
                                            maxlength="5">
                                    </td>
                                    <td>
                                        <input type="text" id="time3_difference" class="mb-2 time-input" placeholder="HH:MM" readonly>
                                    </td>
                                    <td><input type="text" placeholder="<?php echo $row['ot_justification_3']; ?>" readonly class="mb-2"></td>
                                    <td>
                                        <?php if ($row['status3_1'] === 'Approved'): ?>
                                        <p><?php echo htmlspecialchars($row['status3_2'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <?php elseif ($row['status3_1'] === 'Rejected'): ?>
                                        <p><?php echo htmlspecialchars($row['status3_2'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <?php else: ?>
                                        <!-- <a href="ot_hr_approve_3.php?id=<?php echo $row['id']; ?>" style="text-decoration: none;">
                                        <button class="btn btn-success btn-sm">Approve</button>
                                        </a> -->
                                        <button type="button" class="btn btn-success btn-sm" onclick="window.location.href='ot_hr_approve_3.php?id=<?php echo $row['id']; ?>'">Approve</button>

                                        <a href="#" class="btn btn-danger btn-sm" onclick="promptReason3(<?php echo $row['id']; ?>)">Reject</a>
                                        <?php endif; ?>
                                        <!-- Update Button with AJAX -->
                                        <button class="btn btn-primary btn-sm" name="update3">Update</button>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </form>
                            <?php
                                include 'dbconfig.php';
                                
                                // Check if form is submitted
                                if (isset($_POST['update3'])) {
                                    // Retrieve form data
                                    $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                                    $name =  $_SESSION['fullname'];
                                
                                    $time3_from = isset($_POST['time3_from']) && $_POST['time3_from'] !== $row['time3_from'] ? $_POST['time3_from'] : $row['time3_from'];
                                    $time3_to = isset($_POST['time3_to']) && $_POST['time3_to'] !== $row['time3_to'] ? $_POST['time3_to'] : $row['time3_to'];
                                
                                
                                  
                                    $update_query = "UPDATE ot SET 
                                
                                                      time3_from = '$time3_from',
                                                      time3_to = '$time3_to'
                                                    
                                
                                                        WHERE id = '$id'";
                                
                                    // Execute update query
                                    $result = mysqli_query($conn, $update_query);
                                
                                    if ($result) {
                                        // Update successful
                                        echo "<script>
                                alert('Data updated successfully.');
                                window.location.href = window.location.href; // Reload the page
                                </script>";
                                        // Redirect or perform additional actions as needed
                                    } else {
                                        // Update failed
                                        echo "<script>
                                alert('Failed.');
                                window.location.href = window.location.href; // Reload the page
                                </script>";
                                        // Redirect or handle error as needed
                                    }
                                }
                                ?>
                            <!-- 3 end -->
                            <!-- 4 start -->
                            <form method="POST" action="">
                                <?php if (!empty($row['emp_name_4'])): ?>
                                <tr>
                                    <td><input type="text" placeholder="<?php echo $row['sno_4']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['empno_4']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['emp_name_4']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['sub_dept_4']; ?>" readonly class="mb-2"></td>
                                    <td>
                                        <input type="text" id="time4_from" name="time4_from" value="<?php echo $row['time4_from']; ?>" class="mb-2 time-input"  pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$" 
                                            title="Please enter a valid time (HH:MM)" 
                                            maxlength="5">
                                    </td>
                                    <td>
                                        <input type="text" id="time4_to" name="time4_to" value="<?php echo $row['time4_to']; ?>" class="mb-2 time-input"  pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$" 
                                            title="Please enter a valid time (HH:MM)" 
                                            maxlength="5">
                                    </td>
                                    <td>
                                        <input type="text" id="time4_difference" class="mb-2 time-input" placeholder="HH:MM" readonly>
                                    </td>
                                    <td><input type="text" placeholder="<?php echo $row['ot_justification_4']; ?>" readonly class="mb-2"></td>
                                    <td>
                                        <?php if ($row['status4_1'] === 'Approved'): ?>
                                        <p><?php echo htmlspecialchars($row['status4_2'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <?php elseif ($row['status4_1'] === 'Rejected'): ?>
                                        <p><?php echo htmlspecialchars($row['status4_2'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <?php else: ?>
                                        <!-- <a href="ot_hr_approve_4.php?id=<?php echo $row['id']; ?>" style="text-decoration: none;">
                                        <button class="btn btn-success btn-sm">Approve</button>
                                        </a> -->
                                        <button type="button" class="btn btn-success btn-sm" onclick="window.location.href='ot_hr_approve_4.php?id=<?php echo $row['id']; ?>'">Approve</button>

                                        <a href="#" class="btn btn-danger btn-sm" onclick="promptReason4(<?php echo $row['id']; ?>)">Reject</a>
                                        <?php endif; ?>
                                        <!-- Update Button with AJAX -->
                                        <button class="btn btn-primary btn-sm" name="update4">Update</button>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </form>
                            <?php
                                include 'dbconfig.php';
                                
                                // Check if form is submitted
                                if (isset($_POST['update4'])) {
                                    // Retrieve form data
                                    $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                                    $name =  $_SESSION['fullname'];
                                
                                    $time4_from = isset($_POST['time4_from']) && $_POST['time4_from'] !== $row['time4_from'] ? $_POST['time4_from'] : $row['time4_from'];
                                    $time4_to = isset($_POST['time4_to']) && $_POST['time4_to'] !== $row['time4_to'] ? $_POST['time4_to'] : $row['time4_to'];
                                
                                
                                  
                                    $update_query = "UPDATE ot SET 
                                
                                                      time4_from = '$time4_from',
                                                      time4_to = '$time4_to'
                                                    
                                
                                                        WHERE id = '$id'";
                                
                                    // Execute update query
                                    $result = mysqli_query($conn, $update_query);
                                
                                    if ($result) {
                                        // Update successful
                                        echo "<script>
                                alert('Data updated successfully.');
                                window.location.href = window.location.href; // Reload the page
                                </script>";
                                        // Redirect or perform additional actions as needed
                                    } else {
                                        // Update failed
                                        echo "<script>
                                alert('Failed.');
                                window.location.href = window.location.href; // Reload the page
                                </script>";
                                        // Redirect or handle error as needed
                                    }
                                }
                                ?>
                            <!-- 2 end -->
                            <!-- 5 start -->
                            <form method="POST" action="">
                                <?php if (!empty($row['emp_name_5'])): ?>
                                <tr>
                                    <td><input type="text" placeholder="<?php echo $row['sno_5']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['empno_5']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['emp_name_5']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['sub_dept_5']; ?>" readonly class="mb-2"></td>
                                    <td>
                                        <input type="text" id="time5_from" name="time5_from" value="<?php echo $row['time5_from']; ?>" class="mb-2 time-input"  pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$" 
                                            title="Please enter a valid time (HH:MM)" 
                                            maxlength="5">
                                    </td>
                                    <td>
                                        <input type="text" id="time5_to" name="time5_to" value="<?php echo $row['time5_to']; ?>" class="mb-2 time-input"  pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$" 
                                            title="Please enter a valid time (HH:MM)" 
                                            maxlength="5">
                                    </td>
                                    <td>
                                        <input type="text" id="time5_difference" class="mb-2 time-input" placeholder="HH:MM" readonly>
                                    </td>
                                    <td><input type="text" placeholder="<?php echo $row['ot_justification_5']; ?>" readonly class="mb-2"></td>
                                    <td>
                                        <?php if ($row['status5_1'] === 'Approved'): ?>
                                        <p><?php echo htmlspecialchars($row['status5_2'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <?php elseif ($row['status5_1'] === 'Rejected'): ?>
                                        <p><?php echo htmlspecialchars($row['status5_2'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <?php else: ?>
                                        <!-- <a href="ot_hr_approve_5.php?id=<?php echo $row['id']; ?>" style="text-decoration: none;">
                                        <button class="btn btn-success btn-sm">Approve</button>
                                        </a> -->
                                        <button type="button" class="btn btn-success btn-sm" onclick="window.location.href='ot_hr_approve_5.php?id=<?php echo $row['id']; ?>'">Approve</button>

                                        <a href="#" class="btn btn-danger btn-sm" onclick="promptReason5(<?php echo $row['id']; ?>)">Reject</a>
                                        <?php endif; ?>
                                        <!-- Update Button with AJAX -->
                                        <button class="btn btn-primary btn-sm" name="update5">Update</button>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </form>
                            <?php
                                include 'dbconfig.php';
                                
                                // Check if form is submitted
                                if (isset($_POST['update5'])) {
                                    // Retrieve form data
                                    $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                                    $name =  $_SESSION['fullname'];
                                
                                    $time5_from = isset($_POST['time5_from']) && $_POST['time5_from'] !== $row['time5_from'] ? $_POST['time5_from'] : $row['time5_from'];
                                    $time5_to = isset($_POST['time5_to']) && $_POST['time5_to'] !== $row['time5_to'] ? $_POST['time5_to'] : $row['time5_to'];
                                
                                
                                  
                                    $update_query = "UPDATE ot SET 
                                
                                                      time5_from = '$time5_from',
                                                      time5_to = '$time5_to'
                                                    
                                
                                                        WHERE id = '$id'";
                                
                                    // Execute update query
                                    $result = mysqli_query($conn, $update_query);
                                
                                    if ($result) {
                                        // Update successful
                                        echo "<script>
                                alert('Data updated successfully.');
                                window.location.href = window.location.href; // Reload the page
                                </script>";
                                        // Redirect or perform additional actions as needed
                                    } else {
                                        // Update failed
                                        echo "<script>
                                alert('Failed.');
                                window.location.href = window.location.href; // Reload the page
                                </script>";
                                        // Redirect or handle error as needed
                                    }
                                }
                                ?>
                            <!-- 5 end -->
                            <!-- 6 start -->
                            <form method="POST" action="">
                                <?php if (!empty($row['emp_name_6'])): ?>
                                <tr>
                                    <td><input type="text" placeholder="<?php echo $row['sno_6']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['empno_6']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['emp_name_6']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['sub_dept_6']; ?>" readonly class="mb-2"></td>
                                    <td>
                                        <input type="text" id="time6_from" name="time6_from" value="<?php echo $row['time6_from']; ?>" class="mb-2 time-input"  pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$" 
                                            title="Please enter a valid time (HH:MM)" 
                                            maxlength="5">
                                    </td>
                                    <td>
                                        <input type="text" id="time6_to" name="time6_to" value="<?php echo $row['time6_to']; ?>" class="mb-2 time-input"  pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$" 
                                            title="Please enter a valid time (HH:MM)" 
                                            maxlength="5">
                                    </td>
                                    <td>
                                        <input type="text" id="time6_difference" class="mb-2 time-input" placeholder="HH:MM" readonly>
                                    </td>
                                    <td><input type="text" placeholder="<?php echo $row['ot_justification_6']; ?>" readonly class="mb-2"></td>
                                    <td>
                                        <?php if ($row['status6_1'] === 'Approved'): ?>
                                        <p><?php echo htmlspecialchars($row['status6_2'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <?php elseif ($row['status6_1'] === 'Rejected'): ?>
                                        <p><?php echo htmlspecialchars($row['status6_2'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <?php else: ?>
                                        <!-- <a href="ot_hr_approve_6.php?id=<?php echo $row['id']; ?>" style="text-decoration: none;">
                                        <button class="btn btn-success btn-sm">Approve</button>
                                        </a> -->
                                        <button type="button" class="btn btn-success btn-sm" onclick="window.location.href='ot_hr_approve_6.php?id=<?php echo $row['id']; ?>'">Approve</button>

                                        <a href="#" class="btn btn-danger btn-sm" onclick="promptReason6(<?php echo $row['id']; ?>)">Reject</a>
                                        <?php endif; ?>
                                        <!-- Update Button with AJAX -->
                                        <button class="btn btn-primary btn-sm" name="update6">Update</button>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </form>
                            <?php
                                include 'dbconfig.php';
                                
                                // Check if form is submitted
                                if (isset($_POST['update6'])) {
                                    // Retrieve form data
                                    $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                                    $name =  $_SESSION['fullname'];
                                
                                    $time6_from = isset($_POST['time6_from']) && $_POST['time6_from'] !== $row['time6_from'] ? $_POST['time6_from'] : $row['time6_from'];
                                    $time6_to = isset($_POST['time6_to']) && $_POST['time6_to'] !== $row['time6_to'] ? $_POST['time6_to'] : $row['time6_to'];
                                
                                
                                  
                                    $update_query = "UPDATE ot SET 
                                
                                                      time6_from = '$time6_from',
                                                      time6_to = '$time6_to'
                                                    
                                
                                                        WHERE id = '$id'";
                                
                                    // Execute update query
                                    $result = mysqli_query($conn, $update_query);
                                
                                    if ($result) {
                                        // Update successful
                                        echo "<script>
                                alert('Data updated successfully.');
                                window.location.href = window.location.href; // Reload the page
                                </script>";
                                        // Redirect or perform additional actions as needed
                                    } else {
                                        // Update failed
                                        echo "<script>
                                alert('Failed.');
                                window.location.href = window.location.href; // Reload the page
                                </script>";
                                        // Redirect or handle error as needed
                                    }
                                }
                                ?>
                            <!-- 6 end -->
                            <!-- 7 start -->
                            <form method="POST" action="">
                                <?php if (!empty($row['emp_name_7'])): ?>
                                <tr>
                                    <td><input type="text" placeholder="<?php echo $row['sno_7']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['empno_7']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['emp_name_7']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['sub_dept_7']; ?>" readonly class="mb-2"></td>
                                    <td>
                                        <input type="text" id="time7_from" name="time7_from" value="<?php echo $row['time7_from']; ?>" class="mb-2 time-input"  pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$" 
                                            title="Please enter a valid time (HH:MM)" 
                                            maxlength="5">
                                    </td>
                                    <td>
                                        <input type="text" id="time7_to" name="time7_to" value="<?php echo $row['time7_to']; ?>" class="mb-2 time-input"  pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$" 
                                            title="Please enter a valid time (HH:MM)" 
                                            maxlength="5">
                                    </td>
                                    <td>
                                        <input type="text" id="time7_difference" class="mb-2 time-input" placeholder="HH:MM" readonly>
                                    </td>
                                    <td><input type="text" placeholder="<?php echo $row['ot_justification_7']; ?>" readonly class="mb-2"></td>
                                    <td>
                                        <?php if ($row['status7_1'] === 'Approved'): ?>
                                        <p><?php echo htmlspecialchars($row['status7_2'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <?php elseif ($row['status7_1'] === 'Rejected'): ?>
                                        <p><?php echo htmlspecialchars($row['status7_2'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <?php else: ?>
                                        <!-- <a href="ot_hr_approve_7.php?id=<?php echo $row['id']; ?>" style="text-decoration: none;">
                                        <button class="btn btn-success btn-sm">Approve</button>
                                        </a> -->
                                        <button type="button" class="btn btn-success btn-sm" onclick="window.location.href='ot_hr_approve_7.php?id=<?php echo $row['id']; ?>'">Approve</button>

                                        <a href="#" class="btn btn-danger btn-sm" onclick="promptReason7(<?php echo $row['id']; ?>)">Reject</a>
                                        <?php endif; ?>
                                        <!-- Update Button with AJAX -->
                                        <button class="btn btn-primary btn-sm" name="update7">Update</button>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </form>
                            <?php
                                include 'dbconfig.php';
                                
                                // Check if form is submitted
                                if (isset($_POST['update7'])) {
                                    // Retrieve form data
                                    $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                                    $name =  $_SESSION['fullname'];
                                
                                    $time7_from = isset($_POST['time7_from']) && $_POST['time7_from'] !== $row['time7_from'] ? $_POST['time7_from'] : $row['time7_from'];
                                    $time7_to = isset($_POST['time7_to']) && $_POST['time7_to'] !== $row['time7_to'] ? $_POST['time7_to'] : $row['time7_to'];
                                
                                
                                  
                                    $update_query = "UPDATE ot SET 
                                
                                                      time7_from = '$time7_from',
                                                      time7_to = '$time7_to'
                                                    
                                
                                                        WHERE id = '$id'";
                                
                                    // Execute update query
                                    $result = mysqli_query($conn, $update_query);
                                
                                    if ($result) {
                                        // Update successful
                                        echo "<script>
                                alert('Data updated successfully.');
                                window.location.href = window.location.href; // Reload the page
                                </script>";
                                        // Redirect or perform additional actions as needed
                                    } else {
                                        // Update failed
                                        echo "<script>
                                alert('Failed.');
                                window.location.href = window.location.href; // Reload the page
                                </script>";
                                        // Redirect or handle error as needed
                                    }
                                }
                                ?>
                            <!-- 7 end -->
                            <!-- 8 start -->
                            <form method="POST" action="">
                                <?php if (!empty($row['emp_name_8'])): ?>
                                <tr>
                                    <td><input type="text" placeholder="<?php echo $row['sno_8']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['empno_8']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['emp_name_8']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['sub_dept_8']; ?>" readonly class="mb-2"></td>
                                    <td>
                                        <input type="text" id="time8_from" name="time8_from" value="<?php echo $row['time8_from']; ?>" class="mb-2 time-input"  pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$" 
                                            title="Please enter a valid time (HH:MM)" 
                                            maxlength="5">
                                    </td>
                                    <td>
                                        <input type="text" id="time8_to" name="time8_to" value="<?php echo $row['time8_to']; ?>" class="mb-2 time-input"  pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$" 
                                            title="Please enter a valid time (HH:MM)" 
                                            maxlength="5">
                                    </td>
                                    <td>
                                        <input type="text" id="time8_difference" class="mb-2 time-input" placeholder="HH:MM" readonly>
                                    </td>
                                    <td><input type="text" placeholder="<?php echo $row['ot_justification_8']; ?>" readonly class="mb-2"></td>
                                    <td>
                                        <?php if ($row['status8_1'] === 'Approved'): ?>
                                        <p><?php echo htmlspecialchars($row['status8_2'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <?php elseif ($row['status8_1'] === 'Rejected'): ?>
                                        <p><?php echo htmlspecialchars($row['status8_2'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <?php else: ?>
                                        <!-- <a href="ot_hr_approve_8.php?id=<?php echo $row['id']; ?>" style="text-decoration: none;">
                                        <button class="btn btn-success btn-sm">Approve</button>
                                        </a> -->
                                        <button type="button" class="btn btn-success btn-sm" onclick="window.location.href='ot_hr_approve_8.php?id=<?php echo $row['id']; ?>'">Approve</button>

                                        <a href="#" class="btn btn-danger btn-sm" onclick="promptReason8(<?php echo $row['id']; ?>)">Reject</a>
                                        <?php endif; ?>
                                        <!-- Update Button with AJAX -->
                                        <button class="btn btn-primary btn-sm" name="update8">Update</button>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </form>
                            <?php
                                include 'dbconfig.php';
                                
                                // Check if form is submitted
                                if (isset($_POST['update8'])) {
                                    // Retrieve form data
                                    $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                                    $name =  $_SESSION['fullname'];
                                
                                    $time8_from = isset($_POST['time8_from']) && $_POST['time8_from'] !== $row['time8_from'] ? $_POST['time8_from'] : $row['time8_from'];
                                    $time8_to = isset($_POST['time8_to']) && $_POST['time8_to'] !== $row['time8_to'] ? $_POST['time8_to'] : $row['time8_to'];
                                
                                
                                  
                                    $update_query = "UPDATE ot SET 
                                
                                                      time8_from = '$time8_from',
                                                      time8_to = '$time8_to'
                                                    
                                
                                                        WHERE id = '$id'";
                                
                                    // Execute update query
                                    $result = mysqli_query($conn, $update_query);
                                
                                    if ($result) {
                                        // Update successful
                                        echo "<script>
                                alert('Data updated successfully.');
                                window.location.href = window.location.href; // Reload the page
                                </script>";
                                        // Redirect or perform additional actions as needed
                                    } else {
                                        // Update failed
                                        echo "<script>
                                alert('Failed.');
                                window.location.href = window.location.href; // Reload the page
                                </script>";
                                        // Redirect or handle error as needed
                                    }
                                }
                                ?>
                            <!-- 8 end -->
                            <!-- 9 start -->
                            <form method="POST" action="">
                                <?php if (!empty($row['emp_name_9'])): ?>
                                <tr>
                                    <td><input type="text" placeholder="<?php echo $row['sno_9']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['empno_9']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['emp_name_9']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['sub_dept_9']; ?>" readonly class="mb-2"></td>
                                    <td>
                                        <input type="text" id="time9_from" name="time9_from" value="<?php echo $row['time9_from']; ?>" class="mb-2 time-input"  pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$" 
                                            title="Please enter a valid time (HH:MM)" 
                                            maxlength="5">
                                    </td>
                                    <td>
                                        <input type="text" id="time9_to" name="time9_to" value="<?php echo $row['time9_to']; ?>" class="mb-2 time-input"  pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$" 
                                            title="Please enter a valid time (HH:MM)" 
                                            maxlength="5">
                                    </td>
                                    <td>
                                        <input type="text" id="time9_difference" class="mb-2 time-input" placeholder="HH:MM" readonly>
                                    </td>
                                    <td><input type="text" placeholder="<?php echo $row['ot_justification_9']; ?>" readonly class="mb-2"></td>
                                    <td>
                                        <?php if ($row['status9_1'] === 'Approved'): ?>
                                        <p><?php echo htmlspecialchars($row['status9_2'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <?php elseif ($row['status9_1'] === 'Rejected'): ?>
                                        <p><?php echo htmlspecialchars($row['status9_2'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <?php else: ?>
                                        <!-- <a href="ot_hr_approve_9.php?id=<?php echo $row['id']; ?>" style="text-decoration: none;">
                                        <button class="btn btn-success btn-sm">Approve</button>
                                        </a> -->
                                        <button type="button" class="btn btn-success btn-sm" onclick="window.location.href='ot_hr_approve_9.php?id=<?php echo $row['id']; ?>'">Approve</button>

                                        <a href="#" class="btn btn-danger btn-sm" onclick="promptReason9(<?php echo $row['id']; ?>)">Reject</a>
                                        <?php endif; ?>
                                        <!-- Update Button with AJAX -->
                                        <button class="btn btn-primary btn-sm" name="update9">Update</button>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </form>
                            <?php
                                include 'dbconfig.php';
                                
                                // Check if form is submitted
                                if (isset($_POST['update9'])) {
                                    // Retrieve form data
                                    $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                                    $name =  $_SESSION['fullname'];
                                
                                    $time9_from = isset($_POST['time9_from']) && $_POST['time9_from'] !== $row['time9_from'] ? $_POST['time9_from'] : $row['time9_from'];
                                    $time9_to = isset($_POST['time9_to']) && $_POST['time9_to'] !== $row['time9_to'] ? $_POST['time9_to'] : $row['time9_to'];
                                
                                
                                  
                                    $update_query = "UPDATE ot SET 
                                
                                                      time9_from = '$time9_from',
                                                      time9_to = '$time9_to'
                                                    
                                
                                                        WHERE id = '$id'";
                                
                                    // Execute update query
                                    $result = mysqli_query($conn, $update_query);
                                
                                    if ($result) {
                                        // Update successful
                                        echo "<script>
                                alert('Data updated successfully.');
                                window.location.href = window.location.href; // Reload the page
                                </script>";
                                        // Redirect or perform additional actions as needed
                                    } else {
                                        // Update failed
                                        echo "<script>
                                alert('Failed.');
                                window.location.href = window.location.href; // Reload the page
                                </script>";
                                        // Redirect or handle error as needed
                                    }
                                }
                                ?>
                            <!-- 9 end -->
                            <!-- 9 start -->
                            <form method="POST" action="">
                                <?php if (!empty($row['emp_name_10'])): ?>
                                <tr>
                                    <td><input type="text" placeholder="<?php echo $row['sno_10']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['empno_10']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['emp_name_10']; ?>" readonly class="mb-2"></td>
                                    <td><input type="text" placeholder="<?php echo $row['sub_dept_10']; ?>" readonly class="mb-2"></td>
                                    <td>
                                        <input type="text" id="time10_from" name="time10_from" value="<?php echo $row['time10_from']; ?>" class="mb-2 time-input"  pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$" 
                                            title="Please enter a valid time (HH:MM)" 
                                            maxlength="5">
                                    </td>
                                    <td>
                                        <input type="text" id="time10_to" name="time10_to" value="<?php echo $row['time10_to']; ?>" class="mb-2 time-input"  pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$" 
                                            title="Please enter a valid time (HH:MM)" 
                                            maxlength="5">
                                    </td>
                                    <td>
                                        <input type="text" id="time10_difference" class="mb-2 time-input" placeholder="HH:MM" readonly>
                                    </td>
                                    <td><input type="text" placeholder="<?php echo $row['ot_justification_10']; ?>" readonly class="mb-2"></td>
                                    <td>
                                        <?php if ($row['status10_1'] === 'Approved'): ?>
                                        <p><?php echo htmlspecialchars($row['status9_2'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <?php elseif ($row['status10_1'] === 'Rejected'): ?>
                                        <p><?php echo htmlspecialchars($row['status10_2'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <?php else: ?>
                                        <!-- <a href="ot_hr_approve_10.php?id=<?php echo $row['id']; ?>" style="text-decoration: none;">
                                        <button class="btn btn-success btn-sm">Approve</button>
                                        </a> -->
                                        <button type="button" class="btn btn-success btn-sm" onclick="window.location.href='ot_hr_approve_10.php?id=<?php echo $row['id']; ?>'">Approve</button>

                                        <a href="#" class="btn btn-danger btn-sm" onclick="promptReason10(<?php echo $row['id']; ?>)">Reject</a>
                                        <?php endif; ?>
                                        <!-- Update Button with AJAX -->
                                        <button class="btn btn-primary btn-sm" name="update10">Update</button>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </form>
                            <?php
                                include 'dbconfig.php';
                                
                                // Check if form is submitted
                                if (isset($_POST['update10'])) {
                                    // Retrieve form data
                                    $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                                    $name =  $_SESSION['fullname'];
                                
                                    $time10_from = isset($_POST['time10_from']) && $_POST['time10_from'] !== $row['time10_from'] ? $_POST['time10_from'] : $row['time10_from'];
                                    $time10_to = isset($_POST['time10_to']) && $_POST['time10_to'] !== $row['time10_to'] ? $_POST['time10_to'] : $row['time10_to'];
                                
                                
                                  
                                    $update_query = "UPDATE ot SET 
                                
                                                      time10_from = '$time10_from',
                                                      time10_to = '$time10_to'
                                                    
                                
                                                        WHERE id = '$id'";
                                
                                    // Execute update query
                                    $result = mysqli_query($conn, $update_query);
                                
                                    if ($result) {
                                        // Update successful
                                        echo "<script>
                                alert('Data updated successfully.');
                                window.location.href = window.location.href; // Reload the page
                                </script>";
                                        // Redirect or perform additional actions as needed
                                    } else {
                                        // Update failed
                                        echo "<script>
                                alert('Failed.');
                                window.location.href = window.location.href; // Reload the page
                                </script>";
                                        // Redirect or handle error as needed
                                    }
                                }
                                ?>
                            <!-- 9 end -->
                        </tbody>
                    </table>
                    <div class="row pb-1" >
                        <div class="col-md-1">
                            <a href="ot_hr_approve.php?id=<?php echo $row['id']; ?>" style="text-decoration: none;"><button class="btn btn-success btn-sm">Approve</button></a>
                        </div>
                        <div class="col-md-1">
                            <a href="#" class="btn btn-danger btn-sm" onclick="promptReason(<?php echo $row['id']; ?>)">Reject</a>
                        </div>
                    </div>
                    <!-- row 2.1 start-->
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
        <!-- General Reason -->
        <script>
            function promptReason(itemId) {
                var reason = prompt("Enter reason for rejection:");
                if (reason != null && reason.trim() !== "") {
                    window.location.href = "ot_hr_reject.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
                }
            }
        </script>
        <script>
            function submitRejectionReason(itemId, reason) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload(); 
                    }
                };
                xhr.open("POST", "update_rejection_reason.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + itemId + "&reason=" + encodeURIComponent(reason));
            }
        </script>
        <!-- 1-->
        <script>
            function promptReason1(itemId) {
                var reason = prompt("Enter reason for rejection:");
                if (reason != null && reason.trim() !== "") {
                    window.location.href = "ot_hr_reject_1.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
                }
            }
        </script>
        <script>
            function submitRejectionReason(itemId, reason) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload(); 
                    }
                };
                xhr.open("POST", "update_rejection_reason.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + itemId + "&reason=" + encodeURIComponent(reason));
            }
        </script>
        <!-- 2-->
        <script>
            function promptReason2(itemId) {
                var reason = prompt("Enter reason for rejection:");
                if (reason != null && reason.trim() !== "") {
                    window.location.href = "ot_hr_reject_2.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
                }
            }
        </script>
        <script>
            function submitRejectionReason(itemId, reason) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload(); 
                    }
                };
                xhr.open("POST", "update_rejection_reason.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + itemId + "&reason=" + encodeURIComponent(reason));
            }
        </script>
        <!-- 3-->
        <script>
            function promptReason3(itemId) {
                var reason = prompt("Enter reason for rejection:");
                if (reason != null && reason.trim() !== "") {
                    window.location.href = "ot_hr_reject_3.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
                }
            }
        </script>
        <script>
            function submitRejectionReason(itemId, reason) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload(); 
                    }
                };
                xhr.open("POST", "update_rejection_reason.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + itemId + "&reason=" + encodeURIComponent(reason));
            }
        </script>
        <!-- 4-->
        <script>
            function promptReason4(itemId) {
                var reason = prompt("Enter reason for rejection:");
                if (reason != null && reason.trim() !== "") {
                    window.location.href = "ot_hr_reject_4.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
                }
            }
        </script>
        <script>
            function submitRejectionReason(itemId, reason) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload(); 
                    }
                };
                xhr.open("POST", "update_rejection_reason.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + itemId + "&reason=" + encodeURIComponent(reason));
            }
        </script>
        <!-- 5-->
        <script>
            function promptReason5(itemId) {
                var reason = prompt("Enter reason for rejection:");
                if (reason != null && reason.trim() !== "") {
                    window.location.href = "ot_hr_reject_5.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
                }
            }
        </script>
        <script>
            function submitRejectionReason(itemId, reason) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload(); 
                    }
                };
                xhr.open("POST", "update_rejection_reason.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + itemId + "&reason=" + encodeURIComponent(reason));
            }
        </script>
        <!-- 6-->
        <script>
            function promptReason6(itemId) {
                var reason = prompt("Enter reason for rejection:");
                if (reason != null && reason.trim() !== "") {
                    window.location.href = "ot_hr_reject_6.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
                }
            }
        </script>
        <script>
            function submitRejectionReason(itemId, reason) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload(); 
                    }
                };
                xhr.open("POST", "update_rejection_reason.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + itemId + "&reason=" + encodeURIComponent(reason));
            }
        </script>
        <!-- 7-->
        <script>
            function promptReason7(itemId) {
                var reason = prompt("Enter reason for rejection:");
                if (reason != null && reason.trim() !== "") {
                    window.location.href = "ot_hr_reject_7.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
                }
            }
        </script>
        <script>
            function submitRejectionReason(itemId, reason) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload(); 
                    }
                };
                xhr.open("POST", "update_rejection_reason.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + itemId + "&reason=" + encodeURIComponent(reason));
            }
        </script>
        <!-- 8-->
        <script>
            function promptReason8(itemId) {
                var reason = prompt("Enter reason for rejection:");
                if (reason != null && reason.trim() !== "") {
                    window.location.href = "ot_hr_reject_8.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
                }
            }
        </script>
        <script>
            function submitRejectionReason(itemId, reason) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload(); 
                    }
                };
                xhr.open("POST", "update_rejection_reason.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + itemId + "&reason=" + encodeURIComponent(reason));
            }
        </script>
        <!-- 9-->
        <script>
            function promptReason9(itemId) {
                var reason = prompt("Enter reason for rejection:");
                if (reason != null && reason.trim() !== "") {
                    window.location.href = "ot_hr_reject_9.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
                }
            }
        </script>
        <script>
            function submitRejectionReason(itemId, reason) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload(); 
                    }
                };
                xhr.open("POST", "update_rejection_reason.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + itemId + "&reason=" + encodeURIComponent(reason));
            }
        </script>
        <!-- 10-->
        <script>
            function promptReason10(itemId) {
                var reason = prompt("Enter reason for rejection:");
                if (reason != null && reason.trim() !== "") {
                    window.location.href = "ot_hr_reject_10.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
                }
            }
        </script>
        <script>
            function submitRejectionReason(itemId, reason) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload(); 
                    }
                };
                xhr.open("POST", "update_rejection_reason.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + itemId + "&reason=" + encodeURIComponent(reason));
            }
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Get all inputs with the "time-input" class
                const timeInputs = document.querySelectorAll('.time-input');
            
                // Add event listener to each input
                timeInputs.forEach(input => {
                    input.addEventListener('input', function () {
                        const value = input.value;
            
                        // Match valid HH:MM format
                        const isValid = /^([01][0-9]|2[0-3]):[0-5][0-9]$/.test(value);
            
                        // If invalid, set input background to light red
                        if (!isValid && value.length === 5) {
                            input.style.backgroundColor = '#f8d7da'; // Light red
                        } else {
                            input.style.backgroundColor = ''; // Reset background
                        }
            
                        // Optional: Remove invalid characters
                        if (!/^(\d{0,2}:?\d{0,2})$/.test(value)) {
                            input.value = value.slice(0, -1);
                        }
                    });
                });
            });
        </script>
        <!-- time difference -->
        <!-- <script>
            document.addEventListener("DOMContentLoaded", function () {
                const timeFromInput = document.getElementById("time1_from");
                const timeToInput = document.getElementById("time1_to");
                const timeDifferenceInput = document.getElementById("time_difference");
            
                // Function to calculate the time difference
                function calculateTimeDifference(startTime, endTime) {
                    const start = startTime.split(":");
                    const end = endTime.split(":");
            
                    // Convert times to total minutes
                    const startMinutes = parseInt(start[0]) * 60 + parseInt(start[1]);
                    const endMinutes = parseInt(end[0]) * 60 + parseInt(end[1]);
            
                    let diffMinutes = endMinutes - startMinutes;
            
                    // If the difference is negative (invalid range), show a message
                    if (diffMinutes < 0) {
                        return "Invalid Time Range";
                    }
            
                    // Calculate hours and minutes
                    const hours = Math.floor(diffMinutes / 60);
                    const minutes = diffMinutes % 60;
            
                    return `${String(hours).padStart(2, "0")}:${String(minutes).padStart(2, "0")}`;
                }
            
                // Function to update the time difference in the input field
                function updateTimeDifference() {
                    const startTime = timeFromInput.value;
                    const endTime = timeToInput.value;
            
                    // Ensure the times are in the correct format
                    const timePattern = /^([01][0-9]|2[0-3]):[0-5][0-9]$/;
            
                    if (timePattern.test(startTime) && timePattern.test(endTime)) {
                        timeDifferenceInput.value = calculateTimeDifference(startTime, endTime);
                    } else {
                        timeDifferenceInput.value = "Please enter valid times (HH:MM)";
                    }
                }
            
                // Event listeners for input changes
                timeFromInput.addEventListener("input", updateTimeDifference);
                timeToInput.addEventListener("input", updateTimeDifference);
            
                // Initial check in case there are default values
                updateTimeDifference();
            });
        </script> -->



        <!-- time difference -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Function to calculate the time difference
        function calculateTimeDifference(startTime, endTime) {
            const start = startTime.split(":");
            const end = endTime.split(":");

            // Convert times to total minutes
            const startMinutes = parseInt(start[0]) * 60 + parseInt(start[1]);
            const endMinutes = parseInt(end[0]) * 60 + parseInt(end[1]);

            let diffMinutes = endMinutes - startMinutes;

            // If the difference is negative (invalid range), show a message
            if (diffMinutes < 0) {
                return "Invalid Time Range";
            }

            // Calculate hours and minutes
            const hours = Math.floor(diffMinutes / 60);
            const minutes = diffMinutes % 60;

            return `${String(hours).padStart(2, "0")}:${String(minutes).padStart(2, "0")}`;
        }

        // Function to update the time difference in the input field
        function updateTimeDifference(timeFromInput, timeToInput, timeDifferenceInput) {
            const startTime = timeFromInput.value;
            const endTime = timeToInput.value;

            // Ensure the times are in the correct format
            const timePattern = /^([01][0-9]|2[0-3]):[0-5][0-9]$/;

            if (timePattern.test(startTime) && timePattern.test(endTime)) {
                timeDifferenceInput.value = calculateTimeDifference(startTime, endTime);
            } else {
                timeDifferenceInput.value = "Please enter valid times (HH:MM)";
            }
        }

        // Time Field 1
        const timeFromInput1 = document.getElementById("time1_from");
        const timeToInput1 = document.getElementById("time1_to");
        const timeDifferenceInput1 = document.getElementById("time1_difference");

        if (timeFromInput1 && timeToInput1 && timeDifferenceInput1) {
            timeFromInput1.addEventListener("input", function() {
                updateTimeDifference(timeFromInput1, timeToInput1, timeDifferenceInput1);
            });
            timeToInput1.addEventListener("input", function() {
                updateTimeDifference(timeFromInput1, timeToInput1, timeDifferenceInput1);
            });

            updateTimeDifference(timeFromInput1, timeToInput1, timeDifferenceInput1);
        }

        // Time Field 2
        const timeFromInput2 = document.getElementById("time2_from");
        const timeToInput2 = document.getElementById("time2_to");
        const timeDifferenceInput2 = document.getElementById("time2_difference");

        if (timeFromInput2 && timeToInput2 && timeDifferenceInput2) {
            timeFromInput2.addEventListener("input", function() {
                updateTimeDifference(timeFromInput2, timeToInput2, timeDifferenceInput2);
            });
            timeToInput2.addEventListener("input", function() {
                updateTimeDifference(timeFromInput2, timeToInput2, timeDifferenceInput2);
            });

            updateTimeDifference(timeFromInput2, timeToInput2, timeDifferenceInput2);
        }

        // Time Field 3
        const timeFromInput3 = document.getElementById("time3_from");
        const timeToInput3 = document.getElementById("time3_to");
        const timeDifferenceInput3 = document.getElementById("time3_difference");

        if (timeFromInput3 && timeToInput3 && timeDifferenceInput3) {
            timeFromInput3.addEventListener("input", function() {
                updateTimeDifference(timeFromInput3, timeToInput3, timeDifferenceInput3);
            });
            timeToInput3.addEventListener("input", function() {
                updateTimeDifference(timeFromInput3, timeToInput3, timeDifferenceInput3);
            });

            updateTimeDifference(timeFromInput3, timeToInput3, timeDifferenceInput3);
        }

        // Time Field 4
        const timeFromInput4 = document.getElementById("time4_from");
        const timeToInput4 = document.getElementById("time4_to");
        const timeDifferenceInput4 = document.getElementById("time4_difference");

        if (timeFromInput4 && timeToInput4 && timeDifferenceInput4) {
            timeFromInput4.addEventListener("input", function() {
                updateTimeDifference(timeFromInput4, timeToInput4, timeDifferenceInput4);
            });
            timeToInput4.addEventListener("input", function() {
                updateTimeDifference(timeFromInput4, timeToInput4, timeDifferenceInput4);
            });

            updateTimeDifference(timeFromInput4, timeToInput4, timeDifferenceInput4);
        }

        // Time Field 5
        const timeFromInput5 = document.getElementById("time5_from");
        const timeToInput5 = document.getElementById("time5_to");
        const timeDifferenceInput5 = document.getElementById("time5_difference");

        if (timeFromInput5 && timeToInput5 && timeDifferenceInput5) {
            timeFromInput5.addEventListener("input", function() {
                updateTimeDifference(timeFromInput5, timeToInput5, timeDifferenceInput5);
            });
            timeToInput5.addEventListener("input", function() {
                updateTimeDifference(timeFromInput5, timeToInput5, timeDifferenceInput5);
            });

            updateTimeDifference(timeFromInput5, timeToInput5, timeDifferenceInput5);
        }

        // Time Field 6
        const timeFromInput6 = document.getElementById("time6_from");
        const timeToInput6 = document.getElementById("time6_to");
        const timeDifferenceInput6 = document.getElementById("time6_difference");

        if (timeFromInput6 && timeToInput6 && timeDifferenceInput6) {
            timeFromInput6.addEventListener("input", function() {
                updateTimeDifference(timeFromInput6, timeToInput6, timeDifferenceInput6);
            });
            timeToInput6.addEventListener("input", function() {
                updateTimeDifference(timeFromInput6, timeToInput6, timeDifferenceInput6);
            });

            updateTimeDifference(timeFromInput6, timeToInput6, timeDifferenceInput6);
        }

        // Time Field 7
        const timeFromInput7 = document.getElementById("time7_from");
        const timeToInput7 = document.getElementById("time7_to");
        const timeDifferenceInput7 = document.getElementById("time7_difference");

        if (timeFromInput7 && timeToInput7 && timeDifferenceInput7) {
            timeFromInput7.addEventListener("input", function() {
                updateTimeDifference(timeFromInput7, timeToInput7, timeDifferenceInput7);
            });
            timeToInput7.addEventListener("input", function() {
                updateTimeDifference(timeFromInput7, timeToInput7, timeDifferenceInput7);
            });

            updateTimeDifference(timeFromInput7, timeToInput7, timeDifferenceInput7);
        }

        // Time Field 8
        const timeFromInput8 = document.getElementById("time8_from");
        const timeToInput8 = document.getElementById("time8_to");
        const timeDifferenceInput8 = document.getElementById("time8_difference");

        if (timeFromInput8 && timeToInput8 && timeDifferenceInput8) {
            timeFromInput8.addEventListener("input", function() {
                updateTimeDifference(timeFromInput8, timeToInput8, timeDifferenceInput8);
            });
            timeToInput8.addEventListener("input", function() {
                updateTimeDifference(timeFromInput8, timeToInput8, timeDifferenceInput8);
            });

            updateTimeDifference(timeFromInput8, timeToInput8, timeDifferenceInput8);
        }

        // Time Field 9
        const timeFromInput9 = document.getElementById("time9_from");
        const timeToInput9 = document.getElementById("time9_to");
        const timeDifferenceInput9 = document.getElementById("time9_difference");

        if (timeFromInput9 && timeToInput9 && timeDifferenceInput9) {
            timeFromInput9.addEventListener("input", function() {
                updateTimeDifference(timeFromInput9, timeToInput9, timeDifferenceInput9);
            });
            timeToInput9.addEventListener("input", function() {
                updateTimeDifference(timeFromInput9, timeToInput9, timeDifferenceInput9);
            });

            updateTimeDifference(timeFromInput9, timeToInput9, timeDifferenceInput9);
        }

        // Time Field 10
        const timeFromInput10 = document.getElementById("time10_from");
        const timeToInput10 = document.getElementById("time10_to");
        const timeDifferenceInput10 = document.getElementById("time10_difference");

        if (timeFromInput10 && timeToInput10 && timeDifferenceInput10) {
            timeFromInput10.addEventListener("input", function() {
                updateTimeDifference(timeFromInput10, timeToInput10, timeDifferenceInput10);
            });
            timeToInput10.addEventListener("input", function() {
                updateTimeDifference(timeFromInput10, timeToInput10, timeDifferenceInput10);
            });

            updateTimeDifference(timeFromInput10, timeToInput10, timeDifferenceInput10);
        }
    });
</script>

    </body>
</html>