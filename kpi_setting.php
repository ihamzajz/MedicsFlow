<?php
session_start();


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
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MedicsFlow</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
    <?php
    include 'cdncss.php'
        ?>
    <style>
        .slide {
            position: relative;
            overflow: hidden;
            background-color: #7868E6;
            border: 2px solid #4B2C91;
            color: white;
            font-weight: 600;
            border-radius: 4px;
            cursor: pointer;
            padding: 0 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .text {
            position: relative;
            z-index: 2;
            transition: color 0.4s ease;
        }

        .slide::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 130%;
            height: 100%;
            background-color: white;
            /* white overlay */
            transform: translateX(-110%) skew(-30deg);
            transition: transform 0.5s ease;
            z-index: 1;
        }

        .slide:hover::before {
            transform: translateX(-5%) skew(-15deg);
        }

        .slide:hover .text {
            color: #4B2C91;
        }

        .btn {
             font-size: 11px !important;
            border-radius: 0px !important;
        }



        .cbox {
            height: 13px !important;
            width: 13px !important;
        }

        .table1 th {
            background-color: white !important;
            position: sticky;
            top: 0;
            z-index: 1000;
            font-size: 11.5px;
            text-align: left;
            letter-spacing: 0.4px;
            font-weight: 500;
            font-size: 14px;
            letter-spacing: 0.5px;
            border: none
        }

        .table1 td {
            font-size: 11px;
            color: black !important;
            padding: 5px 10px !important;
            border: none !important;
            letter-spacing: 0.2px;
        }


        .table2 th {
            font-size: 12px !important;
            border: none !important;
            background-color: #1B7BBC !important;
            color: white
        }

        .table2 td {
            font-size: 11px;
            color: black !important;
            padding: 5px 10px !important;
            border: none !important;
            letter-spacing: 0.2px;
        }

        .labelf {
            font-size: 13.5px !important;
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
    </style>
    <?php
    include 'sidebarcss.php'
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
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-success btn-success">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </nav>

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col pt-md-2">
                        <form class="form pb-3" method="POST"
                            style="border: 1px solid black; padding: 20px; padding-bottom: 0px; border-radius: 2px;background-color:white!important">
                            <!-- <h5 class="text-center" style="font-weight: 600;">
                                    <span style="float:left!important">
                                         <a class="btn btn-dark btn-sm me-2" href="kpi_setting.php" style="font-size:11px!important">
                                            <i class="fa-solid fa-home"></i> Home
                                            </a>
                                    </span>
                                    KPI Setting</h5> -->

                            <div style="position: relative; text-align: center; padding: 10px 0;">
                                <!-- Button on left side -->
                                <a class="btn btn-dark btn-sm" href="appraisal_forms.php"
                                    style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); font-size:11px;">
                                    <i class="fa-solid fa-home"></i> Home
                                </a>

                                <!-- Centered Heading -->
                                <h5 class="text-center py-3" style="font-weight: 600;">KPI Setting</h5>
                            </div>



                            <div class="table-responsive mt-5">
                                <table class="table table1">
                                    <tr>
                                        <th style="width:30%!important">Employee Name</th>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <th>Employee ID</th>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <th>Designation</th>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <th>Department</th>
                                        <td><input type="text"></td>
                                    </tr>
                                </table>
                            </div>


                            <div class="table-responsive">
                                <table class="table table2">
                                    <thead>
                                        <tr>
                                            <th>KPI Description</th>
                                            <th>Benchmark</th>
                                            <th>Actual</th>
                                            <th>Measuring Tool</th>
                                            <th>Achievement</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <tr>
                                            <td
                                                style="font-size:10.7px!important;background-color:#F5F5F5;padding:5px!important;font-weight:500">
                                                <span>A quantifiable measure of</span><br><span>performance over
                                                    time</span>
                                            </td>
                                            <td
                                                style="font-size:10.7px!important;background-color:#F5F5F5;padding:5px!important;font-weight:500">
                                                Desired target</td>
                                            <td
                                                style="font-size:10.7px!important;background-color:#F5F5F5;padding:5px!important;font-weight:500">
                                                Current Baseline</td>
                                            <td
                                                style="font-size:10.7px!important;background-color:#F5F5F5;padding:5px!important;font-weight:500">
                                                Quantifiable Framework</td>
                                            <td
                                                style="font-size:10.7px!important;background-color:#F5F5F5;padding:5px!important;font-weight:500">
                                                Achieved value</td>
                                            <td
                                                style="font-size:10.7px!important;background-color:#F5F5F5;padding:5px!important;font-weight:500">
                                                Any additional notes pertaining to each KPI</td>
                                        </tr>
                                        <tr>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                            <td><input type="text"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                                <div class="text-center mt-3">
                                <button class="slide" name="submit"
                                    style="font-size: 17px; height: 36px; width: 150px;">
                                    <span class="text">Submit</span>
                                </button>
                            </div>
                        </form>
                        <?php
                        include 'dbconfig.php';
                        if (isset($_POST['submit'])) {

                            date_default_timezone_set("Asia/Karachi");


                            $id = $_SESSION['id'];
                            $name = $_SESSION['fullname'];
                            $email = $_SESSION['email'];
                            $username = $_SESSION['username'];
                            $department = $_SESSION['department'];
                            $role = $_SESSION['role'];
                            $date = date('Y-m-d H:i:s');
                            $desc = mysqli_real_escape_string($conn, $_POST['desc']);
                            $head_email = $_SESSION['head_email'];

                            $be_depart = $_SESSION['be_depart'];
                            $be_role = $_SESSION['be_role'];

                            $type = $_POST['type'];
                            $category = $_POST['category'];
                            $depart_type = $_POST['depart_type'];        

                            $insert = "INSERT INTO workorder_form (name,username,email,date,department,role,be_depart,be_role,type,category,description,head_status,engineering_status,finance_status,ceo_status,amount,task_status,admin_status,depart_type) VALUES 
                                       ('$name','$username','$email','$date','$department','$role','$be_depart','$be_role','$type','$category','$desc','Pending','Pending','Pending','Pending','TBD','Task is going through approval','Pending','$depart_type')";

                            $insert_q = mysqli_query($conn, $insert);
                            if ($insert_q) {
                                // Sending email
                                try {
                                    //Server settings
                                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                                    $mail->isSMTP();
                                    $mail->Host = 'smtp.gmail.com';
                                    $mail->SMTPAuth = true;
                                    $mail->Username = 'medicsdigitalform@gmail.com';
                                    $mail->Password = 'loirscdzztpgbmpa';
                                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                                    $mail->Port = 465;

                                    //Recipients
                                    $mail->setFrom('medicsdigitalform@gmail.com', 'Medics Digital form');
                                    $mail->addAddress($head_email, 'HOD');

                                    //Content
                                    $mail->isHTML(true);                                  //Set email format to HTML
                                    $mail->Subject = "Workorder Form Submission";
                                    $mail->Body = "
                                            <p>Dear HOD,</p>
                                            <p>A new workorder form has been submitted by {$name}.</p>
                                            ";

                                    $mail->send();
                                } catch (Exception $e) {
                                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                                }

                                ?>
                                <script type="text/javascript">
                                    alert("Form has been submitted!");
                                    window.location.href = "workorderForm.php";
                                </script>
                                <?php
                            } else {
                                ?>
                                <script type="text/javascript">
                                    alert("Form submission failed!");
                                    window.location.href = "workorderForm.php";
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
    include 'footer.php'
        ?>