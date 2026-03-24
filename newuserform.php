<?php
session_start();


if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php'); // Redirect to the login page
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
// require 'PHPMailer-master/PHPMailerAutoload.php';
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New User Form</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />

    <?php
    include 'cdncss.php';
    ?>
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
            background: #c7ccdb !important;
        }

        .card {
            border-radius: 10px;
        }

        label {
            font-weight: 500;
            font-size: 12px;
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



        .cbox {
            height: 13px !important;
            width: 13px !important;
        }

        p {
            font-size: 12.5px !important;
            padding: 0px !important;
            margin: 0px !important;
            font-weight: 500;
        }

        input {
            width: 100% !important;
            font-size: 13px;
            border-radius: 0px;
            border: 1px solid grey;
            transition: border-color 0.3s ease;
            padding: 2.5px 5px;
            letter-spacing: 0.4px;
            height: 25px !important;
        }

        input:focus {
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
        }

        select {
            width: 100% !important;
            font-size: 12px;
            border-radius: 0px;
            border: 1px solid grey;
            transition: border-color 0.3s ease;
            padding: 2.5px 5px;
            letter-spacing: 0.4px;
            height: 25px !important;
        }
    </style>
    <style>
        /* Remove top and bottom padding from table data cells */
        td {
            font-size: 11px !important;
            padding: 0px !important;
            margin: 0px !important;
            font-weight: 500 !important;
            padding: 3px !important;
        }

        th {
            font-size: 11px !important;
            background-color: #3a506b !important;
            color: white !important
        }

        .bg-header {
            background-color: #1f7a8c;
        }

        .btn-form,
        .btn-form:hover {
            background-color: #0e6ba8;
            border-radius: 20px;
            color: white;
        }
    </style>

    <?php
    include 'sidebarcss.php';
    ?>
</head>

<body>
    <div class="wrapper">
        <?php
        include 'sidebar1.php';
        ?>
        <!-- Page Content  -->
        <div id="content">
            <!-- navbar -->
            <nav class="navbar navbar-expand-lg bg-menu">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>
            </nav>



            <div class="container pt-5">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-md-12">


                        <form class="form pb-3" method="POST">




                            <div class="card shadow">
                                <div class="card-header bg-header text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">New User Form</h6>
                                    <a href="new_user_home.php" class="btn btn-light btn-sm" style="font-size:12px!important">
                                        <i class="fa-solid fa-home"></i> Home
                                    </a>
                                </div>

                                <div class="card-body">




                                    <div class="text-center">
                                        <label class="mr-2" style="font-size:13.5px!important;font-weight:500!important">
                                            <input type="checkbox" class="add-remove-checkbox0 cbox" name="request_type" id=""
                                                value="Employee"> Employee
                                        </label>
                                        <label class="mr-2" style="font-size:13.5px!important;font-weight:500!important">
                                            <input type="checkbox" class="add-remove-checkbox0 cbox" name="request_type" id=""
                                                value="Management Trainee"> Management Trainee
                                        </label>
                                        <label class="mr-2" style="font-size:13.5px!important;font-weight:500!important">
                                            <input type="checkbox" class="add-remove-checkbox0 cbox" name="request_type" id=""
                                                value="Intern"> Intern
                                        </label>
                                        <label class="mr-2" style="font-size:13.5px!important;font-weight:500!important">
                                            <input type="checkbox" class="add-remove-checkbox0 cbox" name="request_type" id=""
                                                value="Contractor"> Contractor
                                        </label>
                                        <label class="mr-2" style="font-size:13.5px!important;font-weight:500!important">
                                            <input type="checkbox" class="add-remove-checkbox0 cbox" name="request_type" id=""
                                                value="Finance"> Finance
                                        </label>
                                    </div>




                                    <div class="container pt-md-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p>Employee Id:</p>
                                                <input type="text" name="emp_id" id="emp_id">

                                            </div>
                                            <div class="col-md-4">
                                                <p>Name:</p>
                                                <input type="text" name="name" id="name">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Department:</p>
                                                <input type="text" name="department" id="department">
                                            </div>




                                        </div>
                                        <div class="row pt-2">

                                            <div class="col-md-4">
                                                <p>Position:</p>
                                                <input type="text" name="position" id="position">

                                            </div>
                                            <div class="col-md-4">
                                                <p>Start Date:</p>
                                                <input type="date" name="start_date" id="start_date">

                                            </div>
                                            <div class="col-md-4">
                                                <p>End Date:</p>
                                                <input type="date" name="end_date" id="end_date">
                                            </div>
                                        </div>


                                        <div class="row pt-2">
                                            <div class="col-md-4">
                                                <p>Reporting to:</p>
                                                <input type="text" name="reporting_to" id="reporting_to">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Head Of Department:</p>
                                                <input type="text" name="head_of_department" id="head_of_department">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="container mt-3">
                                        <div class="row justify-content-center">
                                            <div class="col-md-8">


                                                <table class="table table-bordered table-striped" cellpadding="0"
                                                    cellspacing="0">
                                                    <thead class="thead-dark th">
                                                        <tr>
                                                            <th>Medics System</th>
                                                            <th>Yes</th>
                                                            <th>No</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Building Access</td>
                                                            <td>
                                                                <label>
                                                                    <input type="checkbox" class="add-remove-checkbox cbox"
                                                                        name="building_access" value="yes"> Yes</label>
                                                            </td>
                                                            <td>
                                                                <label>
                                                                    <input type="checkbox" class="add-remove-checkbox cbox"
                                                                        name="building_access" value="no"> No</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Attendance</td>
                                                            <td>
                                                                <label>
                                                                    <input type="checkbox" class="add-remove-checkbox1 cbox"
                                                                        name="attendance" value="yes"> Yes</label>
                                                            </td>
                                                            <td>
                                                                <label>
                                                                    <input type="checkbox" class="add-remove-checkbox1 cbox"
                                                                        name="attendance" value="no"> No</label>
                                                            </td>
                                                        <tr>
                                                            <td>AD User</td>
                                                            <td>
                                                                <label>
                                                                    <input type="checkbox" class="add-remove-checkbox2cbox cbox"
                                                                        name="ad_user" value="yes"> Yes</label>
                                                            </td>
                                                            <td>
                                                                <label>
                                                                    <input type="checkbox" class="add-remove-checkbox2 cbox"
                                                                        name="ad_user" value="no"> No</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Email Access</td>
                                                            <td>
                                                                <label>
                                                                    <input type="checkbox" class="add-remove-checkbox3 cbox"
                                                                        name="email_access" value="yes"> Yes</label>
                                                            </td>
                                                            <td>
                                                                <label>
                                                                    <input type="checkbox" class="add-remove-checkbox3 cbox"
                                                                        name="email_access" value="no"> No</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>SharePoint Access</td>
                                                            <td>
                                                                <label>
                                                                    <input type="checkbox" class="add-remove-checkbox4 cbox"
                                                                        name="sharepoint_access" value="yes"> Yes</label>
                                                            </td>
                                                            <td>
                                                                <label>
                                                                    <input type="checkbox" class="add-remove-checkbox4 cbox"
                                                                        name="sharepoint_access" value="no"> No</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Mobile Phone</td>
                                                            <td>
                                                                <label>
                                                                    <input type="checkbox" class="add-remove-checkbox5 cbox"
                                                                        name="mobile_phone" value="yes"> Yes</label>
                                                            </td>
                                                            <td>
                                                                <label>
                                                                    <input type="checkbox" class="add-remove-checkbox5 cbox"
                                                                        name="mobile_phone" value="no"> No</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Payroll System</td>
                                                            <td>
                                                                <label>
                                                                    <input type="checkbox" class="add-remove-checkbox6 cbox"
                                                                        name="payroll_system" value="yes"> Yes</label>
                                                            </td>
                                                            <td>
                                                                <label>
                                                                    <input type="checkbox" class="add-remove-checkbox6 cbox"
                                                                        name="payroll_system" value="no"> No</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Finance System</td>
                                                            <td>
                                                                <label>
                                                                    <input type="checkbox" class="add-remove-checkbox7 cbox"
                                                                        name="finance_system" value="yes"> Yes</label>
                                                            </td>
                                                            <td>
                                                                <label>
                                                                    <input type="checkbox" class="add-remove-checkbox7 cbox"
                                                                        name="finance_system" value="no"> No</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Fixed Assets</td>
                                                            <td>
                                                                <label>
                                                                    <input type="checkbox" class="add-remove-checkbox8 cbox"
                                                                        name="fixed_assets" value="yes"> Yes</label>
                                                            </td>
                                                            <td>
                                                                <label>
                                                                    <input type="checkbox" class="add-remove-checkbox8 cbox"
                                                                        name="fixed_assets" value="no"> No</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Laptop</td>
                                                            <td>
                                                                <label>
                                                                    <input type="checkbox" class="add-remove-checkbox9 cbox"
                                                                        name="laptop" value="yes"> Yes</label>
                                                            </td>
                                                            <td>
                                                                <label>
                                                                    <input type="checkbox" class="add-remove-checkbox9 cbox"
                                                                        name="laptop" value="no"> No</label>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>



                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center mt-4">
                                        <button type="submit" name="submit" class="btn btn-form px-4">
                                            Submit
                                        </button>
                                    </div>

                        </form>
                        <?php
                        include 'dbconfig.php';
                        if (isset($_POST['submit'])) {

                            date_default_timezone_set("Asia/Karachi");

                            $name = $_SESSION['name'];
                            $fullname = $_SESSION['fullname'];
                            $username = $_SESSION['username'];
                            $email = $_SESSION['email'];
                            $department = $_SESSION['department'];
                            $role = $_SESSION['role'];
                            $date = date('Y-m-d');

                            $name = $_POST['name'];
                            $emp_id = $_POST['emp_id'];
                            $department = $_POST['department'];
                            $position = $_POST['position'];
                            $start_date = $_POST['start_date'];
                            $period = $_POST['period'];
                            $end_date = $_POST['end_date'];
                            $reporting_to = $_POST['reporting_to'];
                            $head_of_department = $_POST['head_of_department'];

                            $req_type = $_POST['request_type'];

                            $building_access = $_POST['building_access'];
                            $attendance = $_POST['attendance'];
                            $ad_user = $_POST['ad_user'];
                            $email_access = $_POST['email_access'];
                            $sharepoint_access = $_POST['sharepoint_access'];
                            $mobile_phone = $_POST['mobile_phone'];
                            $payroll_system = $_POST['payroll_system'];
                            $finance_system = $_POST['finance_system'];
                            $fixed_assets = $_POST['fixed_assets'];
                            $laptop = $_POST['laptop'];

                            date_default_timezone_set("Asia/Karachi");
                            $date = date('Y-m-d');

                            $insert = "INSERT INTO newuserform
                   (req_type,emp_id,name,department,position,period,start_date,end_date,reporting_to,head_of_department,building_access,attendance,ad_user,email_access,sharepoint_access,mobile_phone,payroll_system,finance_system,fixed_assets,laptop,date,hr_status,hr_msg,hr_date)
                    VALUES 
                   ('$req_type','$emp_id','$name','$department','$position','$period','$start_date','$end_date','$reporting_to','$head_of_department','$building_access','$attendance','$ad_user','$email_access','$sharepoint_access','$mobile_phone','$payroll_system','$finance_system','$fixed_assets','$laptop','$date','Pending','Pending','Pending')";

                            $insert_q = mysqli_query($conn, $insert);
                            if ($insert_q) {
                                // Sending email
                                try {
                                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                                    $mail->isSMTP();
                                    $mail->Host = 'smtp.office365.com';
                                    $mail->SMTPAuth = true;
                                    $mail->Username = 'info@medicslab.com';
                                    $mail->Password = 'kcmzrskfgmwzzshz';
                                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                    $mail->Port = 587;

                                    //Recipients
                                    $mail->setFrom('info@medicslab.com', 'Medics Digital form');
                                    $mail->addAddress('taha.ahmed@medicslab.com', 'HR Head');

                                    //Content
                                    $mail->isHTML(true);                                  //Set email format to HTML
                                    $mail->Subject = "New User Form Submission";
                                    $mail->Body = "
                        <p>Dear HR Head,</p>
                        <p>A new user form has been submitted. Please approve the form to send it to the IT department.</p>
                        ";

                                    $mail->send();
                                } catch (Exception $e) {
                                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                                }

                        ?>
                                <script type="text/javascript">
                                    alert("Form has been submitted!");
                                    window.location.href = "newuserform.php";
                                </script>
                            <?php
                            } else {
                            ?>
                                <script type="text/javascript">
                                    alert("Form submission failed!");
                                    window.location.href = "newuserform.php";
                                </script>
                        <?php
                            }
                        }
                        ?>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php

    ?>
    <script>
        $(document).ready(function() {
            $('#submit').click(function() {
                checked = $("input[type=checkbox]:checked").length;

                if (!checked) {
                    alert("You must check at least one checkbox.");
                    return false;
                }
            });
        });
    </script>
    <!-- 1 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.add-remove-checkbox');

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
    <!-- 2 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.add-remove-checkbox0');

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
    <!-- 3 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.add-remove-checkbox1');

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
    <!-- 4 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.add-remove-checkbox2');

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
    <!-- 5 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.add-remove-checkbox3');

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
    <!-- 6 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.add-remove-checkbox4');

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
    <!-- 7 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.add-remove-checkbox5');

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
    <!-- 8 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.add-remove-checkbox6');

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
    <!-- 9 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.add-remove-checkbox7');

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
    <!-- 10 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.add-remove-checkbox8');

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
            const checkboxes = document.querySelectorAll('.add-remove-checkbox9');

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
            const checkboxes = document.querySelectorAll('.add-remove-checkbox10');

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





    <?php
    include 'footer.php'
    ?>