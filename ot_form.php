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
    ?> <?php
    include 'dbconfig.php';
    
     //echo $_SESSION['role'];
    
    $id = $_SESSION['id'];
    $fname = $_SESSION['fullname'];
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    $password = $_SESSION['password'];
    $gender = $_SESSION['gender'];
    $department = $_SESSION['department'];
    
    $be_depart = $_SESSION['be_depart'];
    $be_role = $_SESSION['be_role'];
    
    $emp_id = $_SESSION['emp_id'];
    $sub_dept = $_SESSION['sub_dept'];
    ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Over Time Request Form</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" /> <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous"> <!-- Our Custom CSS -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
         .btn-submit {
            font-size: 14.4px !important; 
            color: white;
            background-color: #0d6efd;
            padding: 5px 35px;
            border-radius: 2px;
            border: 2px solid #0D9276;
            letter-spacing: 1.35px; 
            font-weight: 500;
            }
        .btn{
        border-radius:0px!important;
        }
        select{
        font-size: 11px !important;
        height:25px!important;
        width: 100%!important;
        }
        option{
        font-size: 11px !important;
        width: 100%!important;
        }
        p{
        font-size: 12px!important;
        }
        tr{
            padding:0px!important;
            margin:0px!important;
        }
        th {
        font-size: 10.5px !important;
        }
        td {
        font-size: 11.5px !important;
        padding: 10px !important;
        /* border: 1px solid black !important; */
        /* border: 0.5px solid black!important; */
        }
        .btn-menu {
        font-size: 11px;
        }
        .cbox {
        height: 13px !important;
        width: 13px !important;
        }
        td,
        .labelf {
        font-size: 12.5px !important;
        padding: 0px !important;
        margin: 0px !important;
        font-weight: 500;
        }
        .labelf {
        font-size: 13.5px !important;
        padding: 0px !important;
        margin: 0px !important;
        font-weight: 500;
        }
        input {
        width: 100% !important;
        font-size: 10.5px !important;
        border-radius: 0px;
        border: 1px solid grey;
        transition: border-color 0.3s ease;
        padding: 10px;
        letter-spacing: 0.4px;
        height: 25px !important;
        }
        input:focus {
        outline: none;
        border: 1px solid black;
        background-color: #FFF4B5;
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
        background: #263144 !important;
        color: #fff;
        transition: all 0.3s;
        }
        #sidebar.active {
        margin-left: -250px;
        }
        #sidebar .sidebar-header {
        padding: 20px;
        background: yellow !important;
        }
        #sidebar ul.components {
        padding: 10px 0;
        }
        #sidebar ul p {
        color: #fff;
        padding: 8px !important;
        }
        #sidebar ul li a {
        padding: 8px !important;
        font-size: 11px !important;
        display: block;
        color: white !important;
        }
        #sidebar ul li a:hover {
        text-decoration: none;
        }
        #sidebar ul li.active>a,
        a[aria-expanded="true"] {
        color: cyan !important;
        background: #1c9be7 !important;
        }
        a[data-toggle="collapse"] {
        position: relative;
        }
        .dropdown-toggle::after {
        display: block;
        position: absolute;
        color: #1c9be7 !important;
        top: 50%;
        right: 20px;
        transform: translateY(-50%);
        background: transparent !important;
        }
        ul ul a {
        font-size: 11px !important;
        padding-left: 15px !important;
        background: yellow !important;
        color: yellow !important;
        }
        ul.CTAs {
        font-size: 11px !important;
        }
        ul.CTAs a {
        text-align: center;
        font-size: 11px !important;
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
        color: yellow !important;
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
    <div class="wrapper"> <?php
                include 'sidebar.php';
                ?>
        <!-- Page Content  -->
        <div id="content">
            <!-- navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid"> <button type="button" id="sidebarCollapse" class="btn btn-info btn-menu"> <i class="fas fa-align-left"></i> <span>Menu</span> </button> </div>
            </nav>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12 pt-md-2">
                        <form class="form mb-3" method="POST" style="border: 1px solid black; padding: 25px; border-radius: 2px;background-color:white!important">
                            <h6 class="text-center pb-3" style="font-weight:600">Overtime Request Form</h6>
                          
                                <div style="display: flex; gap: 20px; align-items: center;padding:20px: 10px;">

                                    <div style="width:200px!important;padding:10px 20px;background-color:#8576FF;">
                                        <p style="color:White;font-weight;600!important;font-size:12px!important">Overtime Date:</p>
                                         <input type="date" style="display: inline;background-color:#F5F5F5!important" name="ot_date">
                                    </div>

                                    <div style="width:200px!important;padding:10px 20px;background-color:#8576FF;">
                                        <p style="color:White;font-weight;600!important;font-size:12px!important">Overtime Day:</p> 
                                        <select id="day-select" name="ot_day">
                                            <option value="" disabled selected>Select a Day</option>
                                            <option value="sunday">Sunday</option>
                                            <option value="monday">Monday</option>
                                            <option value="tuesday">Tuesday</option>
                                            <option value="wednesday">Wednesday</option>
                                            <option value="thursday">Thursday</option>
                                            <option value="friday">Friday</option>
                                            <option value="saturday">Saturday</option>
                                        </select>
                                    </div>
                                </div>
                    </div>
                    <table class="table">
                    <thead style="background-color:#0D9276;color:white">
                            <tr>
                                <th style="width:5%!important">S. No</th>
                                <th style="width:10%!important">Emp #</th>
                                <th style="width:20%!important">Emp Name</th>
                                <th style="width:20%!important">Sub Department</th>
                                <th style="width:10%!important">Time From</th>
                                <th style="width:10%!important">Time To</th>
                                <th style="width:20%!important">Overtime Justification</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td><input type="text" name="sno_1" value="1"></td>
                                <td><input type="text" name="empno_1" id="emp_code" readonly></td>
                                <td> <select name="emp_name_1" id="emp_name" class="mb-2" onchange="updateEmpDetails()">
                                        <option value="">Select Employee</option> <?php
                            include 'dbconfig.php';
                            
                            // Fetch employees based on session filters
                            $query = "SELECT * FROM users WHERE be_depart = '$be_depart' AND be_role2 = 'user'";
                            $result = mysqli_query($conn, $query);
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['fullname']}' data-emp-id='{$row['emp_id']}' data-sub-dept='{$row['sub_dept']}'>{$row['fullname']}</option>";
                            }
                            ?>
                                    </select> </td>
                                <td><input type="text" name="sub_dept_1" id="sub_dept" readonly></td>

                                <td><input type="time" name="ot_from_1"></td>
                                <td><input type="time" name="ot_to_1"></td>
                                <td><input type="text" name="ot_justification_1"></td>
                            </tr>



                            <tr>
                                <td><input type="text" name="sno_2" value="2"></td>
                                <td><input type="text" name="empno_2" id="emp_code_2" readonly></td>
                                <td> <select name="emp_name_2" id="emp_name_2" class="mb-2" onchange="updateEmpDetails2()">
                                    <option value="">Select Employee</option> <?php
                                    include 'dbconfig.php';
                                    
                                    // Fetch employees based on session filters
                                    $query = "SELECT * FROM users WHERE be_depart = '$be_depart' AND be_role2 = 'user'";
                                    $result = mysqli_query($conn, $query);
                                    
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$row['fullname']}' data-emp-id='{$row['emp_id']}' data-sub-dept='{$row['sub_dept']}'>{$row['fullname']}</option>";
                                    }
                                    ?>
                                    </select> 
                                </td>
                                <td><input type="text" name="sub_dept_2" id="sub_dept_2" readonly></td>

                                <td><input type="time" name="ot_from_2"></td>
                                <td><input type="time" name="ot_to_2"></td>
                                <td><input type="text" name="ot_justification_2"></td>
                            </tr>


                            <tr>
                                <td><input type="text" name="sno_3" value="3"></td>
                                <td><input type="text" name="empno_3" id="emp_code_3" readonly></td>
                                <td> <select name="emp_name_3" id="emp_name_3" class="mb-2" onchange="updateEmpDetails3()">
                                        <option value="">Select Employee</option> <?php
                            include 'dbconfig.php';
                            
                            // Fetch employees based on session filters
                            $query = "SELECT * FROM users WHERE be_depart = '$be_depart' AND be_role2 = 'user'";
                            $result = mysqli_query($conn, $query);
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['fullname']}' data-emp-id='{$row['emp_id']}' data-sub-dept='{$row['sub_dept']}'>{$row['fullname']}</option>";
                            }
                            ?>
                                    </select> </td>
                                <td><input type="text" name="sub_dept_3" id="sub_dept_3" readonly></td>
                                <td><input type="time" name="ot_from_3"></td>
                                <td><input type="time" name="ot_to_3"></td>
                                <td><input type="text" name="ot_justification_3"></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="sno_4" value="4"></td>
                                <td><input type="text" name="empno_4" id="emp_code_4" readonly></td>
                                <td> <select name="emp_name_4" id="emp_name_4" class="mb-2" onchange="updateEmpDetails4()">
                                        <option value="">Select Employee</option> <?php
                            include 'dbconfig.php';
                            
                            // Fetch employees based on session filters
                            $query = "SELECT * FROM users WHERE be_depart = '$be_depart' AND be_role2 = 'user'";
                            $result = mysqli_query($conn, $query);
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['fullname']}' data-emp-id='{$row['emp_id']}' data-sub-dept='{$row['sub_dept']}'>{$row['fullname']}</option>";
                            }
                            ?>
                                    </select> </td>
                                <td><input type="text" name="sub_dept_4" id="sub_dept_4" readonly></td>
                                <td><input type="time" name="ot_from_4"></td>
                                <td><input type="time" name="ot_to_4"></td>
                                <td><input type="text" name="ot_justification_4"></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="sno_5" value="5"></td>
                                <td><input type="text" name="empno_5" id="emp_code_5" readonly></td>
                                <td> <select name="emp_name_5" id="emp_name_5" class="mb-2" onchange="updateEmpDetails5()">
                                        <option value="">Select Employee</option> <?php
                            include 'dbconfig.php';
                            
                            // Fetch employees based on session filters
                            $query = "SELECT * FROM users WHERE be_depart = '$be_depart' AND be_role2 = 'user'";
                            $result = mysqli_query($conn, $query);
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['fullname']}' data-emp-id='{$row['emp_id']}' data-sub-dept='{$row['sub_dept']}'>{$row['fullname']}</option>";
                            }
                            ?>
                                    </select> </td>
                                <td><input type="text" name="sub_dept_5" id="sub_dept_5" readonly></td>
                                <td><input type="time" name="ot_from_5"></td>
                                <td><input type="time" name="ot_to_5"></td>
                                <td><input type="text" name="ot_justification_5"></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="sno_6" value="6"></td>
                                <td><input type="text" name="empno_6" id="emp_code_6" readonly></td>
                                <td> <select name="emp_name_6" id="emp_name_6" class="mb-2" onchange="updateEmpDetails6()">
                                        <option value="">Select Employee</option> <?php
                            include 'dbconfig.php';
                            
                            // Fetch employees based on session filters
                            $query = "SELECT * FROM users WHERE be_depart = '$be_depart' AND be_role2 = 'user'";
                            $result = mysqli_query($conn, $query);
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['fullname']}' data-emp-id='{$row['emp_id']}' data-sub-dept='{$row['sub_dept']}'>{$row['fullname']}</option>";
                            }
                            ?>
                                    </select> </td>
                                <td><input type="text" name="sub_dept_6" id="sub_dept_6" readonly></td>
                                <td><input type="time" name="ot_from_6"></td>
                                <td><input type="time" name="ot_to_6"></td>
                                <td><input type="text" name="ot_justification_6"></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="sno_7" value="7"></td>
                                <td><input type="text" name="empno_7" id="emp_code_7" readonly></td>
                                <td> <select name="emp_name_7" id="emp_name_7" class="mb-2" onchange="updateEmpDetails7()">
                                        <option value="">Select Employee</option> <?php
                            include 'dbconfig.php';
                            
                            // Fetch employees based on session filters
                            $query = "SELECT * FROM users WHERE be_depart = '$be_depart' AND be_role2 = 'user'";
                            $result = mysqli_query($conn, $query);
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['fullname']}' data-emp-id='{$row['emp_id']}' data-sub-dept='{$row['sub_dept']}'>{$row['fullname']}</option>";
                            }
                            ?>
                                    </select> </td>
                                <td><input type="text" name="sub_dept_7" id="sub_dept_7" readonly></td>
                                <td><input type="time" name="ot_from_7"></td>
                                <td><input type="time" name="ot_to_7"></td>
                                <td><input type="text" name="ot_justification_7"></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="sno_8" value="8"></td>
                                <td><input type="text" name="empno_8" id="emp_code_8" readonly></td>
                                <td> <select name="emp_name_8" id="emp_name_8" class="mb-2" onchange="updateEmpDetails8()">
                                        <option value="">Select Employee</option> <?php
                            include 'dbconfig.php';
                            
                            // Fetch employees based on session filters
                            $query = "SELECT * FROM users WHERE be_depart = '$be_depart' AND be_role2 = 'user'";
                            $result = mysqli_query($conn, $query);
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['fullname']}' data-emp-id='{$row['emp_id']}' data-sub-dept='{$row['sub_dept']}'>{$row['fullname']}</option>";
                            }
                            ?>
                                    </select> </td>
                                <td><input type="text" name="sub_dept_8" id="sub_dept_8" readonly></td>
                                <td><input type="time" name="ot_from_8"></td>
                                <td><input type="time" name="ot_to_8"></td>
                                <td><input type="text" name="ot_justification_8"></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="sno_9" value="9"></td>
                                <td><input type="text" name="empno_9" id="emp_code_9" readonly></td>
                                <td> <select name="emp_name_9" id="emp_name_9" class="mb-2" onchange="updateEmpDetails9()">
                                        <option value="">Select Employee</option> <?php
                            include 'dbconfig.php';
                            
                            // Fetch employees based on session filters
                            $query = "SELECT * FROM users WHERE be_depart = '$be_depart' AND be_role2 = 'user'";
                            $result = mysqli_query($conn, $query);
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['fullname']}' data-emp-id='{$row['emp_id']}' data-sub-dept='{$row['sub_dept']}'>{$row['fullname']}</option>";
                            }
                            ?>
                                    </select> </td>
                                <td><input type="text" name="sub_dept_9" id="sub_dept_9" readonly></td>
                                <td><input type="time" name="ot_from_9"></td>
                                <td><input type="time" name="ot_to_9"></td>
                                <td><input type="text" name="ot_justification_9"></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="sno_10" value="10"></td>
                                <td><input type="text" name="empno_10" id="emp_code_10" readonly></td>
                                <td> <select name="emp_name_10" id="emp_name_10" class="mb-2" onchange="updateEmpDetails10()">
                                        <option value="">Select Employee</option> <?php
                            include 'dbconfig.php';
                            
                            // Fetch employees based on session filters
                            $query = "SELECT * FROM users WHERE be_depart = '$be_depart' AND be_role2 = 'user'";
                            $result = mysqli_query($conn, $query);
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['fullname']}' data-emp-id='{$row['emp_id']}' data-sub-dept='{$row['sub_dept']}'>{$row['fullname']}</option>";
                            }
                            ?>
                                    </select> </td>
                                <td><input type="text" name="sub_dept_10" id="sub_dept_10" readonly></td>
                                <td><input type="time" name="ot_from_10"></td>
                                <td><input type="time" name="ot_to_10"></td>
                                <td><input type="text" name="ot_justification_10"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center mt-3"> <button type="submit" class="btn btn-submit" name="submit" style="font-size: 20px">Submit</button> </div>
                    </form> 
                    <?php
                            include 'dbconfig.php';
                            if (isset($_POST['submit'])) {
                            
                            date_default_timezone_set("Asia/Karachi");
                            
                            
                            $id =  $_SESSION['id'];
                            $fullname =  $_SESSION['fullname'];
                            $email =  $_SESSION['email'];
                            $username =  $_SESSION['username'];
                            $department = $_SESSION['department'];
                            $role =  $_SESSION['role'];
                            $date =  date('Y-m-d H:i:s');
                            
                            
                            $ot_date =   $_POST['ot_date'];
                            $ot_day =   $_POST['ot_day'];
                            // $time_from =  $_POST['time_from'];
                            // $time_to =   $_POST['time_to'];
                            
                            
                            
                            $sno_1 = $_POST['sno_1'];
                            $empno_1 = $_POST['empno_1'];
                            $emp_name_1 = $_POST['emp_name_1'];
                            $sub_dept_1 = $_POST['sub_dept_1'];
                            $ot_justification_1 = $_POST['ot_justification_1'];
                            $time1_from =  $_POST['ot_from_1'];
                            $time1_to =   $_POST['ot_to_1'];
                            
                            $sno_2 =  $_POST['sno_2'];
                            $empno_2 =  $_POST['empno_2'];
                            $emp_name_2 =  $_POST['emp_name_2'];
                            $sub_dept_2 =  $_POST['sub_dept_2'];
                            $ot_justification_2 =  $_POST['ot_justification_2'];
                            $time2_from =  $_POST['ot_from_2'];
                            $time2_to =   $_POST['ot_to_2'];
                            
                            $sno_3 = $_POST['sno_3'];
                            $empno_3 = $_POST['empno_3'];
                            $emp_name_3 = $_POST['emp_name_3'];
                            $sub_dept_3 = $_POST['sub_dept_3'];
                            $ot_justification_3 = $_POST['ot_justification_3'];
                            $time3_from =  $_POST['ot_from_3'];
                            $time3_to =   $_POST['ot_to_3'];
                            
                            $sno_4 = $_POST['sno_4'];
                            $empno_4 = $_POST['empno_4'];
                            $emp_name_4 = $_POST['emp_name_4'];
                            $sub_dept_4 = $_POST['sub_dept_4'];
                            $ot_justification_4 = $_POST['ot_justification_4'];
                            $time4_from =  $_POST['ot_from_4'];
                            $time4_to =   $_POST['ot_to_4'];
                            
                            $sno_5 = $_POST['sno_5'];
                            $empno_5 = $_POST['empno_5'];
                            $emp_name_5 = $_POST['emp_name_5'];
                            $sub_dept_5 = $_POST['sub_dept_5'];
                            $ot_justification_5 = $_POST['ot_justification_5'];
                            $time5_from =  $_POST['ot_from_5'];
                            $time5_to =   $_POST['ot_to_5'];
                            
                            $sno_6 = $_POST['sno_6'];
                            $empno_6 = $_POST['empno_6'];
                            $emp_name_6 = $_POST['emp_name_6'];
                            $sub_dept_6 = $_POST['sub_dept_6'];
                            $ot_justification_6 = $_POST['ot_justification_6'];
                            $time6_from =  $_POST['ot_from_6'];
                            $time6_to =   $_POST['ot_to_6'];
                            
                            $sno_7 = $_POST['sno_7'];
                            $empno_7 = $_POST['empno_7'];
                            $emp_name_7 = $_POST['emp_name_7'];
                            $sub_dept_7 = $_POST['sub_dept_7'];
                            $ot_justification_7 = $_POST['ot_justification_7'];
                            $time7_from =  $_POST['ot_from_7'];
                            $time7_to =   $_POST['ot_to_7'];
                            
                            $sno_8 = $_POST['sno_8'];
                            $empno_8 = $_POST['empno_8'];
                            $emp_name_8 = $_POST['emp_name_8'];
                            $sub_dept_8 = $_POST['sub_dept_8'];
                            $ot_justification_8 = $_POST['ot_justification_8'];
                            $time8_from =  $_POST['ot_from_8'];
                            $time8_to =   $_POST['ot_to_8'];
                            
                            $sno_9 = $_POST['sno_9'];
                            $empno_9 = $_POST['empno_9'];
                            $emp_name_9 = $_POST['emp_name_9'];
                            $sub_dept_9 = $_POST['sub_dept_9'];
                            $ot_justification_9 = $_POST['ot_justification_9'];
                            $time9_from =  $_POST['ot_from_9'];
                            $time9_to =   $_POST['ot_to_9'];
                            
                            $sno_10 =   $_POST['sno_10'];
                            $empno_10 =  $_POST['empno_10'];
                            $emp_name_10 =  $_POST['emp_name_10'];
                            $sub_dept_10 =  $_POST['sub_dept_10'];
                            $ot_justification_10 =  $_POST['ot_justification_10'];
                            $time10_from =  $_POST['ot_from_10'];
                            $time10_to =   $_POST['ot_to_10'];
                            
                            $insert = "INSERT INTO ot
                            (user_name, user_department, user_role, user_date, ot_date, ot_day, sno_1, sno_2, sno_3, sno_4, sno_5, sno_6, sno_7, sno_8, sno_9, sno_10, empno_1, empno_2, empno_3, empno_4, empno_5, empno_6, empno_7, empno_8, empno_9, empno_10, emp_name_1, emp_name_2, emp_name_3, emp_name_4, emp_name_5, emp_name_6, emp_name_7, emp_name_8, emp_name_9, emp_name_10, sub_dept_1, sub_dept_2, sub_dept_3, sub_dept_4, sub_dept_5, sub_dept_6, sub_dept_7, sub_dept_8, sub_dept_9, sub_dept_10, ot_justification_1, ot_justification_2, ot_justification_3, ot_justification_4, ot_justification_5, ot_justification_6, ot_justification_7, ot_justification_8, ot_justification_9, ot_justification_10, hr_msg, hr_date, hr_status, fpna_msg, fpna_date, fpna_status,hr_submission,fpna_submission, time1_from, time2_from, time3_from, time4_from, time5_from, time6_from, time7_from, time8_from, time9_from, time10_from, time1_to, time2_to, time3_to, time4_to, time5_to, time6_to, time7_to, time8_to, time9_to, time10_to) 
                            VALUES 
                            ('$username', '$department', '$role', '$date', '$ot_date', '$ot_day', '$sno_1', '$sno_2', '$sno_3', '$sno_4', '$sno_5', '$sno_6', '$sno_7', '$sno_8', '$sno_9', '$sno_10', '$empno_1', '$empno_2', '$empno_3', '$empno_4', '$empno_5', '$empno_6', '$empno_7', '$empno_8', '$empno_9', '$empno_10', '$emp_name_1', '$emp_name_2', '$emp_name_3', '$emp_name_4', '$emp_name_5', '$emp_name_6', '$emp_name_7', '$emp_name_8', '$emp_name_9', '$emp_name_10', '$sub_dept_1', '$sub_dept_2', '$sub_dept_3', '$sub_dept_4', '$sub_dept_5', '$sub_dept_6', '$sub_dept_7', '$sub_dept_8', '$sub_dept_9', '$sub_dept_10', '$ot_justification_1', '$ot_justification_2', '$ot_justification_3', '$ot_justification_4', '$ot_justification_5', '$ot_justification_6', '$ot_justification_7', '$ot_justification_8', '$ot_justification_9', '$ot_justification_10', 'Pending', 'Pending', 'Pending', 'Pending', 'Pending', 'Pending', 'Pending', 'Pending','$time1_from','$time2_from','$time3_from','$time4_from','$time5_from','$time6_from','$time7_from','$time8_from','$time9_from','$time10_from','$time1_to','$time2_to','$time3_to','$time4_to','$time5_to','$time6_to','$time7_to','$time8_to','$time9_to','$time10_to')";
                            
                            
                            $insert_q = mysqli_query($conn, $insert);
                            if ($insert_q) {
                                ?> <script type="text/javascript">
                                    alert("Form has been submitted!");
                                    window.location.href = "ot_form.php"; 
                                </script> <?php
                            } else {
                                ?> <script type="text/javascript">
                                    alert("Form submission failed!");
                                    window.location.href = "ot_form.php";
                                </script> <?php
                            }
                            }
                            ?>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.category-checkbox');
        checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
        const groupName = this.name.split('_')[0]; // Extract the group name
        // Uncheck other checkboxes in the same group
        checkboxes.forEach(function(cb) {
        if (cb !== checkbox && cb.name.startsWith(groupName)) {
        cb.checked = false;
        }
        });
        });
        });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.type-checkbox');
        checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
        const groupName = this.name.split('_')[0]; // Extract the group name
        // Uncheck other checkboxes in the same group
        checkboxes.forEach(function(cb) {
        if (cb !== checkbox && cb.name.startsWith(groupName)) {
        cb.checked = false;
        }
        });
        });
        });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.depart_type-checkbox');
        checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
        const groupName = this.name.split('_')[0]; // Extract the group name
        // Uncheck other checkboxes in the same group
        checkboxes.forEach(function(cb) {
        if (cb !== checkbox && cb.name.startsWith(groupName)) {
        cb.checked = false;
        }
        });
        });
        });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
        });
        });
    </script>
    <script src="assets/js/main.js"></script>
    <script>
        // row 1
        function updateEmpDetails() {
        const empNameDropdown = document.getElementById("emp_name");
        const selectedOption = empNameDropdown.options[empNameDropdown.selectedIndex];
        
        const empCode = selectedOption.getAttribute("data-emp-id"); 
        const subDept = selectedOption.getAttribute("data-sub-dept"); 
        
        document.getElementById("emp_code").value = empCode; 
        document.getElementById("sub_dept").value = subDept;
        }
        
        // row 2
        function updateEmpDetails2() {
        const empNameDropdown = document.getElementById("emp_name_2");
        const selectedOption = empNameDropdown.options[empNameDropdown.selectedIndex];
        
        // Fetch attributes for employee code and sub-department
        const empCode = selectedOption.getAttribute("data-emp-id");
        const subDept = selectedOption.getAttribute("data-sub-dept");
        
        // Update the respective fields
        document.getElementById("emp_code_2").value = empCode;
        document.getElementById("sub_dept_2").value = subDept;
        }
        
        
        
        
        
        // row 3
        function updateEmpDetails3() {
        const empNameDropdown = document.getElementById("emp_name_3");
        const selectedOption = empNameDropdown.options[empNameDropdown.selectedIndex];
        
        // Fetch attributes for employee code and sub-department
        const empCode = selectedOption.getAttribute("data-emp-id");
        const subDept = selectedOption.getAttribute("data-sub-dept");
        
        // Update the respective fields
        document.getElementById("emp_code_3").value = empCode;
        document.getElementById("sub_dept_3").value = subDept;
        }
        
        // row 4
        function updateEmpDetails4() {
        const empNameDropdown = document.getElementById("emp_name_4");
        const selectedOption = empNameDropdown.options[empNameDropdown.selectedIndex];
        
        // Fetch attributes for employee code and sub-department
        const empCode = selectedOption.getAttribute("data-emp-id");
        const subDept = selectedOption.getAttribute("data-sub-dept");
        
        // Update the respective fields
        document.getElementById("emp_code_4").value = empCode;
        document.getElementById("sub_dept_4").value = subDept;
        }
        
        
        
        
        // row 5
        function updateEmpDetails5() {
        const empNameDropdown = document.getElementById("emp_name_5");
        const selectedOption = empNameDropdown.options[empNameDropdown.selectedIndex];
        
        // Fetch attributes for employee code and sub-department
        const empCode = selectedOption.getAttribute("data-emp-id");
        const subDept = selectedOption.getAttribute("data-sub-dept");
        
        // Update the respective fields
        document.getElementById("emp_code_5").value = empCode;
        document.getElementById("sub_dept_5").value = subDept;
        }
        
        
        // row 6
        function updateEmpDetails6() {
        const empNameDropdown = document.getElementById("emp_name_6");
        const selectedOption = empNameDropdown.options[empNameDropdown.selectedIndex];
        
        // Fetch attributes for employee code and sub-department
        const empCode = selectedOption.getAttribute("data-emp-id");
        const subDept = selectedOption.getAttribute("data-sub-dept");
        
        // Update the respective fields
        document.getElementById("emp_code_6").value = empCode;
        document.getElementById("sub_dept_6").value = subDept;
        }
        
        
        // row 7
        function updateEmpDetails7() {
        const empNameDropdown = document.getElementById("emp_name_7");
        const selectedOption = empNameDropdown.options[empNameDropdown.selectedIndex];
        
        // Fetch attributes for employee code and sub-department
        const empCode = selectedOption.getAttribute("data-emp-id");
        const subDept = selectedOption.getAttribute("data-sub-dept");
        
        // Update the respective fields
        document.getElementById("emp_code_7").value = empCode;
        document.getElementById("sub_dept_7").value = subDept;
        }
        
        
        // row 8
        function updateEmpDetails8() {
        const empNameDropdown = document.getElementById("emp_name_8");
        const selectedOption = empNameDropdown.options[empNameDropdown.selectedIndex];
        
        // Fetch attributes for employee code and sub-department
        const empCode = selectedOption.getAttribute("data-emp-id");
        const subDept = selectedOption.getAttribute("data-sub-dept");
        
        // Update the respective fields
        document.getElementById("emp_code_8").value = empCode;
        document.getElementById("sub_dept_8").value = subDept;
        }
        
        
        // row 9
        function updateEmpDetails9() {
        const empNameDropdown = document.getElementById("emp_name_9");
        const selectedOption = empNameDropdown.options[empNameDropdown.selectedIndex];
        
        // Fetch attributes for employee code and sub-department
        const empCode = selectedOption.getAttribute("data-emp-id");
        const subDept = selectedOption.getAttribute("data-sub-dept");
        
        // Update the respective fields
        document.getElementById("emp_code_9").value = empCode;
        document.getElementById("sub_dept_9").value = subDept;
        }
        
        
        // row 10
        function updateEmpDetails10() {
        const empNameDropdown = document.getElementById("emp_name_10");
        const selectedOption = empNameDropdown.options[empNameDropdown.selectedIndex];
        
        // Fetch attributes for employee code and sub-department
        const empCode = selectedOption.getAttribute("data-emp-id");
        const subDept = selectedOption.getAttribute("data-sub-dept");
        
        // Update the respective fields
        document.getElementById("emp_code_10").value = empCode;
        document.getElementById("sub_dept_10").value = subDept;
        }
        
          
    </script>
</body>

</html>