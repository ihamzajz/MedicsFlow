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
        body {
            font-family: 'Poppins', sans-serif;
        }

        .btn {
            border-radius: 0px;
        }

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

        .btn-menu {
            font-size: 11px;
        }

        .cbox {
            height: 13px !important;
            width: 13px !important;
        }

        td,
        p {
            font-size: 12.5px !important;
            padding: 0px !important;
            margin: 0px !important;
            font-weight: 500;
        }

        input,
        textarea,
        select,
        option {
            width: 100% !important;
            font-size: 12px;
            border-radius: 0px;
            border: 1px solid grey;
            transition: border-color 0.3s ease;
            padding: 2.5px 5px;
            letter-spacing: 0.4px;
            height: 25px !important;
            color: black !important;
        }

        input:focus {
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
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
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-success" style="font-size:11px!important">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </nav>

            <div class="container">

                <form class="form pb-3" method="POST"
                    style="border: 1px solid grey; padding: 25px; padding-bottom: 0px; border-radius: 5px; background-color: white;">

                    <h5 class="text-center pb-3">Travel Request Form</h5>

                    <div class="row pb-3">

                        <div class="col-md-6">
                            <p for="purpose">Purpose of Travel *</p>
                            <input type="text" name="purpose" required autocomplete="off" class="w-100">
                        </div>

                        <div class="col-md-6">
                            <p for="reason">Reason *</p>
                            <input type="text" name="reason" required autocomplete="off" class="w-100">
                        </div>

                    </div>

                    <div class="row pb-3">

                        <div class="col-md-3">

                            <p for="to_1">Departure from *</p>
                            <select id="to_1" name="to_1" class="w-100">
                                <option value="Select">Select</option>
                                <option value="Karachi">Karachi</option>
                                <option value="Lahore">Lahore</option>
                                <option value="Peshawar">Peshawar</option>
                                <option value="Islamabad">Islamabad</option>
                            </select>

                        </div>


                        <div class="col-md-3">

                            <p for="to_2">To</p>
                            <select id="to_2" name="to_2" class="w-100">
                                <option value="Select">Select</option>
                                <option value="Karachi">Karachi</option>
                                <option value="Lahore">Lahore</option>
                                <option value="Peshawar">Peshawar</option>
                                <option value="Islamabad">Islamabad</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <p for="to_3">To</p>
                            <select id="to_3" name="to_3" class="w-100">
                                <option value="Select">Select</option>
                                <option value="Karachi">Karachi</option>
                                <option value="Lahore">Lahore</option>
                                <option value="Peshawar">Peshawar</option>
                                <option value="Islamabad">Islamabad</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <p for="to_4">To</p>
                            <select id="to_4" name="to_4" class="w-100">
                                <option value="Select">Select</option>
                                <option value="Karachi">Karachi</option>
                                <option value="Lahore">Lahore</option>
                                <option value="Peshawar">Peshawar</option>
                                <option value="Islamabad">Islamabad</option>
                            </select>
                        </div>

                    </div>

                    <div class="row pb-3">

                        <div class="col-md-3">
                            <p for="date_1">Preferable Date From</p>
                            <input type="date" name="date_1" id="date_1" class="w-100">
                        </div>
                        <div class="col-md-3">
                            <p for="date_2">To</p>
                            <input type="date" name="date_2" id="date_2" class="w-100">
                        </div>
                        <div class="col-md-3">
                            <p for="date_3">To</p>
                            <input type="date" name="date_3" id="date_3" class="w-100">
                        </div>
                        <div class="col-md-3">
                            <p for="date_4">To</p>
                            <input type="date" name="date_4" id="date_4" class="w-100">
                        </div>

                    </div>



                    <div class="row pb-3">

                        <div class="col-md-3">
                            <p for="date_1">Preferable Time From</p>
                            <input type="time" name="time_1" id="time_1" class="w-100">
                        </div>

                        <div class="col-md-3">
                            <p for="time_2">To</p>
                            <input type="time" name="time_2" id="time_2" class="w-100">
                        </div>

                        <div class="col-md-3">
                            <p for="time_3">To</p>
                            <input type="time" name="time_3" id="time_3" class="w-100">
                        </div>

                        <div class="col-md-3">
                            <p for="time_4">To</p>
                            <input type="time" name="time_4" id="time_4" class="w-100">
                        </div>

                    </div>




                    <div class="row pb-3">

                        <div class="col-md-4">
                            <p for="preferable_flight">Preferable Flight</p>
                            <select id="preferable_flight" name="preferable_flight" class="w-100">
                                <option value="Select">Select</option>
                                <option value="Air Blue">Air Blue</option>
                                <option value="Emirates">Emirates</option>
                                <option value="PIA">PIA</option>
                                <option value="Serene Air">Serene Air</option>
                                <option value="Shaheen">Shaheen</option>
                                <option value="Thai Airline">Thai Airline</option>
                            </select>

                        </div>

                        <div class="col-md-4">
                            <p for="duration">Duration Of Stay(In days)</p>
                            <input type="text" id="duration" name="duration" autocomplete="off" class="w-100">
                        </div>

                        <div class="col-md-4">
                            <p for="expected_days">Expected day of return</p>
                            <input type="date" id="expected_days" name="expected_days" class="w-100">
                        </div>
                    </div>

                    <div class="row pb-3">

                        <div class="col-md-4">
                            <p for="mode_of_travel">Mode Of Travel</p>
                            <select id="mode_of_travel" name="mode_of_travel" class="w-100">
                                <option value="Select">Select</option>
                                <option value="Domestic">Domestic</option>
                                <option value="International">International</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <p for="hotel_booking">Hotel Booking Required</p>
                            <select id="hotel_booking" name="hotel_booking" class="w-100">
                                <option value="Select">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <p for="visa_required">Visa Required</p>
                            <select id="visa_required" name="visa_required" class="w-100">
                                <option value="Select">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                    </div>

                    <div class="row pb-3">

                        <div class="col-md-6">
                            <p for="rent_car">Rent car Required</p>
                            <select id="rent_car" name="rent_car" class="w-100">
                                <option value="Select">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <p for="rent_car">Other Arrangement</p>
                            <textarea name="other_arrangement" id="other_arrangement" rows="1" cols="20" class="w-100"
                                autocomplete="off"></textarea>
                        </div>

                    </div>

                    <h6 class="py-2" style="font-size:14px!important">Traveling Advance (For Finance Department)</h6>

                    <div class="row">
                        <div class="col-md-6">
                            <p for="advance_required">Advance Required</p>
                            <select id="advance_required" name="advance_required" class="w-100">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <p for="advance_amount">Advance Amount (PKR)</p>
                            <input type="text" name="advance_amount" autocomplete="off" class="w-100">
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button class="slide" name="submit" style="font-size: 17px; height: 36px; width: 150px;">
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
                    // $head_name =  $_SESSION['head_name'];
                    $head_email = $_SESSION['head_email'];
                    $be_depart = $_SESSION['be_depart'];
                    $be_role = $_SESSION['be_role'];

                    $date = date('Y-m-d H:i:s');

                    $purpose = $_POST['purpose'];
                    $reason = $_POST['reason'];

                    $to_1 = $_POST['to_1'];
                    $to_2 = $_POST['to_2'];
                    $to_3 = $_POST['to_3'];
                    $to_4 = $_POST['to_4'];

                    $date_1 = $_POST['date_1'];
                    $date_2 = $_POST['date_2'];
                    $date_3 = $_POST['date_3'];
                    $date_4 = $_POST['date_4'];

                    $time_1 = $_POST['time_1'];
                    $time_2 = $_POST['time_2'];
                    $time_3 = $_POST['time_3'];
                    $time_4 = $_POST['time_4'];

                    $preferable_flight = $_POST['preferable_flight'];

                    $duration = $_POST['duration'];
                    $expected_days = $_POST['expected_days'];

                    $mode_of_travel = $_POST['mode_of_travel'];
                    $hotel_booking = $_POST['hotel_booking'];
                    $visa_required = $_POST['visa_required'];
                    $rent_car = $_POST['rent_car'];
                    $other_arrangement = $_POST['other_arrangement'];
                    $advance_required = $_POST['advance_required'];
                    $advance_amount = $_POST['advance_amount'];

                    $insert = "INSERT INTO trf 
                        (name,email,username,department,role,head_email,date,be_depart,be_role,purpose,reason,to_1,to_2,to_3,to_4,date_1,date_2,date_3,date_4,time_1,time_2,time_3,time_4,preferable_flight,duration,expected_days,mode_of_travel,hotel_booking,visa_required,rent_car,other_arrangement,advance_required,advance_amount,head_status,admin_status,finance_status) VALUES 
                        ('$name','$email','$username','$department','$role','$head_email','$date','$be_depart','$be_role','$purpose','$reason','$to_1','$to_2','$to_3','$to_4','$date_1','$date_2','$date_3','$date_4','$time_1','$time_2','$time_3','$time_4','$preferable_flight','$duration','$expected_days','$mode_of_travel','$hotel_booking','$visa_required','$rent_car','$other_arrangement','$advance_required','$advance_amount'
                        ,'Pending','Pending','Pending')";

                    $insert_q = mysqli_query($conn, $insert);
                    if ($insert_q) {
                        //ceo ke pass jaegi hod ki
                        if ($role == 'Head of department') {
                            try {
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
                                $mail->addAddress('ihamzajz@gmail.com', 'CEO');
                                $mail->isHTML(true);
                                $mail->Subject = "Travel Request Form";
                                $mail->Body = '
                                    ';
                                $mail->send();
                            } catch (Exception $e) {
                                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                            }
                            ?>
                            <script type="text/javascript">
                                alert("Request has been submitted")
                            </script>
                            <?php
                        } else {
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
                                $mail->setFrom('medicsdigitalform@gmail.com', 'Medics Digital form');
                                //  $mail->addAddress($head_email,'Head');  
                
                                $mail->addAddress('ihamzajz@gmail.com', 'Head');

                                $mail->isHTML(true);
                                $mail->Subject = "New Travel Request Form";
                                $mail->Body = 'There is new Travel Request Form waiting for your Approval
                         ';
                                $mail->send();
                            } catch (Exception $e) {
                                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                            }
                        }
                        ?>
                        <script type="text/javascript">
                            alert("Your Request has been submitted!")
                            window.location.href = "trf.php";
                        </script>
                        <?php
                    } else {
                        ?>
                        <script type="text/javascript">
                            alert("Request submition failed!")
                            window.location.href = "trf.php";
                        </script>
                        <?php
                    }
                }

                ?>
            </div>
            <!--col-->
        </div>
        <!--row-->
    </div>
    <!--container-->
    <?php
    include 'footer.php'
        ?>