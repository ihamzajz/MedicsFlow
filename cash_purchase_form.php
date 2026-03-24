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
    <link rel="stylesheet" href="assets/css/style.css">
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
            background-color: #f5f6fa;
        }

        .card {
            border-radius: 10px;
        }



        .cbox {
            height: 13px !important;
            width: 13px !important;
        }

        table th {
            font-size: 12.5px !important;
            border: none !important;
            background-color: #3a506b !important;
            color: white !important;
            font-weight: 600;
            padding: 6px 5px !important;
        }

        table td {
            font-size: 12px;
            color: black;
            padding: 0px !important;
            /* Adjust padding as needed */
            /* border: 1px solid #ddd; */
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
            /* color:#2c2c2c!important; */
        }

        input:focus {
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
        }

        .labelp {
            padding: 0px !important;
            margin: 0px !important;
            font-size: 12.5px !important;
            font-weight: 600 !important;
            padding-bottom: 5px !important;
            ;
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
            <nav class="navbar navbar-expand-lg bg-menu">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn-menu">
                        <i class="fas fa-align-left"></i> <span>Menu</span> </button>
                </div>
            </nav>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <form class="form px-5 py-3 m-5" method="POST">
                            <div class="card shadow">
                                <div class="card-header bg-header text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Cash Purchase Form</h6>
                                    <a href="cash_purchase_home.php" class="btn btn-light btn-sm" style="font-size:12px!important">
                                        <i class="fa-solid fa-home"></i> Home
                                    </a>
                                </div>

                                <div class="card-body">
                                    <div class="row mt-5 mb-4">
                                        <div class="col-md-4">
                                            <div>
                                                <p class="labelp">Requestor Name</p>
                                                <input type="text" style="display: inline;background-color:#F5F5F5!important"
                                                    value="<?php echo htmlspecialchars($fname); ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div>
                                                <p class="labelp">Department</p>
                                                <input type="text" style="display: inline;background-color:#F5F5F5!important"
                                                    value="<?php echo htmlspecialchars($department); ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div>
                                                <p class="labelp">Designation</p>
                                                <input type="text" style="display: inline;background-color:#F5F5F5!important"
                                                    value="<?php echo htmlspecialchars($role); ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="width:20px!important">S.R</th>
                                                <th>Description</th>
                                                <th>Purpose</th>
                                                <th style="width:70px!important">Qty</th>
                                                <th style="width:120px!important">Price</th>
                                                <th style="width:120px!important">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="tr1" class="tr1">
                                                <td><input type="text" name="sr_1" id="sr_1" value="1" readonly></td>
                                                <td><input type="text" name="description_1" id="description_1"></td>
                                                <td><input type="text" name="purpose_1" id="purpose_1"></td>
                                                <td><input type="number" name="qty_1" id="qty_1"></td>
                                                <td><input type="number" name="price_1" id="price_1"></td>
                                                <td><input type="number" name="amount_1" id="amount_1" readonly></td>
                                            </tr>
                                            <tr id="tr2" class="tr2">
                                                <td><input type="text" name="sr_2" id="sr_2" value="2" readonly></td>
                                                <td><input type="text" name="description_2" id="description_2"></td>
                                                <td><input type="text" name="purpose_2" id="purpose_2"></td>
                                                <td><input type="number" name="qty_2" id="qty_2"></td>
                                                <td><input type="number" name="price_2" id="price_2"></td>
                                                <td><input type="number" name="amount_2" id="amount_2" readonly></td>
                                            </tr>
                                            <tr id="tr3" class="tr3">
                                                <td><input type="text" name="sr_3" id="sr_3" value="3"></td>
                                                <td><input type="text" name="description_3" id="description_3"></td>
                                                <td><input type="text" name="purpose_3" id="purpose_3"></td>
                                                <td><input type="number" name="qty_3" id="qty_3"></td>
                                                <td><input type="number" name="price_3" id="price_3"></td>
                                                <td><input type="number" name="amount_3" id="amount_3"></td>
                                            </tr>
                                            <tr id="tr4" class="tr4">
                                                <td><input type="text" name="sr_4" id="sr_4" value="4"></td>
                                                <td><input type="text" name="description_4" id="description_4"></td>
                                                <td><input type="text" name="purpose_4" id="purpose_4"></td>
                                                <td><input type="number" name="qty_4" id="qty_4"></td>
                                                <td><input type="number" name="price_4" id="price_4"></td>
                                                <td><input type="number" name="amount_4" id="amount_4"></td>
                                            </tr>
                                            <tr id="tr5" class="tr5">
                                                <td><input type="text" name="sr_5" id="sr_5" value="5"></td>
                                                <td><input type="text" name="description_5" id="description_5"></td>
                                                <td><input type="text" name="purpose_5" id="purpose_5"></td>
                                                <td><input type="number" name="qty_5" id="qty_5"></td>
                                                <td><input type="number" name="price_5" id="price_5"></td>
                                                <td><input type="number" name="amount_5" id="amount_5"></td>
                                            </tr>
                                            <tr id="tr6" class="tr6">
                                                <td><input type="text" name="sr_6" id="sr_6" value="6"></td>
                                                <td><input type="text" name="description_6" id="description_6"></td>
                                                <td><input type="text" name="purpose_6" id="purpose_6"></td>
                                                <td><input type="number" name="qty_6" id="qty_6"></td>
                                                <td><input type="number" name="price_6" id="price_6"></td>
                                                <td><input type="number" name="amount_6" id="amount_6"></td>
                                            </tr>
                                            <tr id="tr7" class="tr7">
                                                <td><input type="text" name="sr_7" id="sr_7" value="7"></td>
                                                <td><input type="text" name="description_7" id="description_7"></td>
                                                <td><input type="text" name="purpose_7" id="purpose_7"></td>
                                                <td><input type="number" name="qty_7" id="qty_7"></td>
                                                <td><input type="number" name="price_7" id="price_7"></td>
                                                <td><input type="number" name="amount_7" id="amount_7"></td>
                                            </tr>
                                            <tr id="tr8" class="tr8">
                                                <td><input type="text" name="sr_8" id="sr_8" value="8"></td>
                                                <td><input type="text" name="description_8" id="description_8"></td>
                                                <td><input type="text" name="purpose_8" id="purpose_8"></td>
                                                <td><input type="number" name="qty_8" id="qty_8"></td>
                                                <td><input type="number" name="price_8" id="price_8"></td>
                                                <td><input type="number" name="amount_8" id="amount_8"></td>
                                            </tr>
                                            <tr id="tr9" class="tr9">
                                                <td><input type="text" name="sr_9" id="sr_9" value="9"></td>
                                                <td><input type="text" name="description_9" id="description_9"></td>
                                                <td><input type="text" name="purpose_9" id="purpose_9"></td>
                                                <td><input type="number" name="qty_9" id="qty_9"></td>
                                                <td><input type="number" name="price_9" id="price_9"></td>
                                                <td><input type="number" name="amount_9" id="amount_9"></td>
                                            </tr>
                                            <tr id="tr10" class="tr10">
                                                <td><input type="text" name="sr_10" id="sr_10" value="10"></td>
                                                <td><input type="text" name="description_10" id="description_10"></td>
                                                <td><input type="text" name="purpose_10" id="purpose_10"></td>
                                                <td><input type="number" name="qty_10" id="qty_10"></td>
                                                <td><input type="number" name="price_10" id="price_10"></td>
                                                <td><input type="number" name="amount_10" id="amount_10"></td>
                                            </tr>
                                            <tr id="total" class="total" style="border:none!important">
                                                <td colspan="4"></td>
                                                <td style="text-align:center; font-weight: bold;" class="pt-1">Total Amount</td>
                                                <td>
                                                    <input type="number" name="total_amount" id="total_amount"
                                                        style="color:red; font-weight:bold;border:none!important" value="00"
                                                        readonly>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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


                            $id = $_SESSION['id'];
                            $name = $_SESSION['fullname'];
                            $email = $_SESSION['email'];
                            $username = $_SESSION['username'];
                            $department = $_SESSION['department'];
                            $role = $_SESSION['role'];
                            $date = date('Y-m-d');

                            $sr_1 = mysqli_real_escape_string($conn, $_POST['sr_1']);
                            $description_1 = mysqli_real_escape_string($conn, $_POST['description_1']);
                            $purpose_1 = mysqli_real_escape_string($conn, $_POST['purpose_1']);
                            $qty_1 = mysqli_real_escape_string($conn, $_POST['qty_1']);
                            $price_1 = mysqli_real_escape_string($conn, $_POST['price_1']);
                            $amount_1 = mysqli_real_escape_string($conn, $_POST['amount_1']);

                            $sr_2 = mysqli_real_escape_string($conn, $_POST['sr_2']);
                            $description_2 = mysqli_real_escape_string($conn, $_POST['description_2']);
                            $purpose_2 = mysqli_real_escape_string($conn, $_POST['purpose_2']);
                            $qty_2 = mysqli_real_escape_string($conn, $_POST['qty_2']);
                            $price_2 = mysqli_real_escape_string($conn, $_POST['price_2']);
                            $amount_2 = mysqli_real_escape_string($conn, $_POST['amount_2']);

                            $sr_3 = mysqli_real_escape_string($conn, $_POST['sr_3']);
                            $description_3 = mysqli_real_escape_string($conn, $_POST['description_3']);
                            $purpose_3 = mysqli_real_escape_string($conn, $_POST['purpose_3']);
                            $qty_3 = mysqli_real_escape_string($conn, $_POST['qty_3']);
                            $price_3 = mysqli_real_escape_string($conn, $_POST['price_3']);
                            $amount_3 = mysqli_real_escape_string($conn, $_POST['amount_3']);

                            $sr_4 = mysqli_real_escape_string($conn, $_POST['sr_4']);
                            $description_4 = mysqli_real_escape_string($conn, $_POST['description_4']);
                            $purpose_4 = mysqli_real_escape_string($conn, $_POST['purpose_4']);
                            $qty_4 = mysqli_real_escape_string($conn, $_POST['qty_4']);
                            $price_4 = mysqli_real_escape_string($conn, $_POST['price_4']);
                            $amount_4 = mysqli_real_escape_string($conn, $_POST['amount_4']);

                            $sr_5 = mysqli_real_escape_string($conn, $_POST['sr_5']);
                            $description_5 = mysqli_real_escape_string($conn, $_POST['description_5']);
                            $purpose_5 = mysqli_real_escape_string($conn, $_POST['purpose_5']);
                            $qty_5 = mysqli_real_escape_string($conn, $_POST['qty_5']);
                            $price_5 = mysqli_real_escape_string($conn, $_POST['price_5']);
                            $amount_5 = mysqli_real_escape_string($conn, $_POST['amount_5']);

                            $sr_6 = mysqli_real_escape_string($conn, $_POST['sr_6']);
                            $description_6 = mysqli_real_escape_string($conn, $_POST['description_6']);
                            $purpose_6 = mysqli_real_escape_string($conn, $_POST['purpose_6']);
                            $qty_6 = mysqli_real_escape_string($conn, $_POST['qty_6']);
                            $price_6 = mysqli_real_escape_string($conn, $_POST['price_6']);
                            $amount_6 = mysqli_real_escape_string($conn, $_POST['amount_6']);

                            $sr_7 = mysqli_real_escape_string($conn, $_POST['sr_7']);
                            $description_7 = mysqli_real_escape_string($conn, $_POST['description_7']);
                            $purpose_7 = mysqli_real_escape_string($conn, $_POST['purpose_7']);
                            $qty_7 = mysqli_real_escape_string($conn, $_POST['qty_7']);
                            $price_7 = mysqli_real_escape_string($conn, $_POST['price_7']);
                            $amount_7 = mysqli_real_escape_string($conn, $_POST['amount_7']);

                            $sr_8 = mysqli_real_escape_string($conn, $_POST['sr_8']);
                            $description_8 = mysqli_real_escape_string($conn, $_POST['description_8']);
                            $purpose_8 = mysqli_real_escape_string($conn, $_POST['purpose_8']);
                            $qty_8 = mysqli_real_escape_string($conn, $_POST['qty_8']);
                            $price_8 = mysqli_real_escape_string($conn, $_POST['price_8']);
                            $amount_8 = mysqli_real_escape_string($conn, $_POST['amount_8']);

                            $sr_9 = mysqli_real_escape_string($conn, $_POST['sr_9']);
                            $description_9 = mysqli_real_escape_string($conn, $_POST['description_9']);
                            $purpose_9 = mysqli_real_escape_string($conn, $_POST['purpose_9']);
                            $qty_9 = mysqli_real_escape_string($conn, $_POST['qty_9']);
                            $price_9 = mysqli_real_escape_string($conn, $_POST['price_9']);
                            $amount_9 = mysqli_real_escape_string($conn, $_POST['amount_9']);

                            $sr_10 = mysqli_real_escape_string($conn, $_POST['sr_10']);
                            $description_10 = mysqli_real_escape_string($conn, $_POST['description_10']);
                            $purpose_10 = mysqli_real_escape_string($conn, $_POST['purpose_10']);
                            $qty_10 = mysqli_real_escape_string($conn, $_POST['qty_10']);
                            $price_10 = mysqli_real_escape_string($conn, $_POST['price_10']);
                            $amount_10 = mysqli_real_escape_string($conn, $_POST['amount_10']);

                            $total_amount = mysqli_real_escape_string($conn, $_POST['total_amount']);


                            $insert = "INSERT INTO cash_purchase
                                (sr_1,sr_2,sr_3,sr_4,sr_5,sr_6,sr_7,sr_8,sr_9,sr_10,
                                description_1,description_2,description_3,description_4,description_5,description_6,description_7,description_8,description_9,description_10,
                                purpose_1,purpose_2,purpose_3,purpose_4,purpose_5,purpose_6,purpose_7,purpose_8,purpose_9,purpose_10,
                                qty_1,qty_2,qty_3,qty_4,qty_5,qty_6,qty_7,qty_8,qty_9,qty_10,
                                price_1,price_2,price_3,price_4,price_5,price_6,price_7,price_8,price_9,price_10,
                                amount_1,amount_2,amount_3,amount_4,amount_5,amount_6,amount_7,amount_8,amount_9,amount_10,total_amount,
                                name,department,role,date,status,admin_status,finance_status,head_status,ceo_status) 
                                VALUES 
                                ('$sr_1','$sr_2','$sr_3','$sr_4','$sr_5','$sr_6','$sr_7','$sr_8','$sr_9','$sr_10',
                                '$description_1','$description_2','$description_3','$description_4','$description_5','$description_6','$description_7','$description_8','$description_9','$description_10',
                                '$purpose_1','$purpose_2','$purpose_3','$purpose_4','$purpose_5','$purpose_6','$purpose_7','$purpose_8','$purpose_9','$purpose_10',
                                '$qty_1','$qty_2','$qty_3','$qty_4','$qty_5','$qty_6','$qty_7','$qty_8','$qty_9','$qty_10',
                                '$price_1','$price_2','$price_3','$price_4','$price_5','$price_6','$price_7','$price_8','$price_9','$price_10',
                                '$amount_1','$amount_2','$amount_3','$amount_4','$amount_5','$amount_6','$amount_7','$amount_8','$amount_9','$amount_10','$total_amount',
                                '$name','$department','$role','$date','Open','Pending','Pending','Pending','Pending')";

                            $insert_q = mysqli_query($conn, $insert);

                            if ($insert_q) {
                                // ✅ Output a loading message *before* sending emails
                                echo '
        <div id="loadingMsg" style="
            position:fixed;
            top:0;left:0;width:100%;height:100%;
            display:flex;align-items:center;justify-content:center;
            background:rgba(0,0,0,0.6);
            color:white;font-size:22px;z-index:9999;
            flex-direction:column;">
            <div style="padding:20px;background:#222;border-radius:10px;">
                <p>📨 Please wait, your request is being processed...</p>
                <p>Email is sending, this may take a few seconds.</p>
            </div>
        </div>
        ';

                                // ✅ Flush this message immediately so user sees it
                                ob_flush();
                                flush();

                                // ✅ Now send emails (this can take a few seconds)
                                try {
                                    $mail = new PHPMailer(true);
                                    $mail->isSMTP();
                                    $mail->Host = 'smtp.office365.com';
                                    $mail->SMTPAuth = true;
                                    $mail->Username = 'info@medicslab.com';
                                    $mail->Password = 'kcmzrskfgmwzzshz';
                                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                    $mail->Port = 587;

                                    $subject = "Cash Purchase Form";
                                    $bodyTemplate = function ($user, $department) {
                                        return "
                    <p>Dear {$department} Department,</p>
                    <p>A new Cash Purchase Request has been submitted by <strong>{$user}</strong>.</p>
                    <p>Kindly review and process the request in MedicsFlow</p>
                    <br>
                    <p>Thanks,<br>MedicsFlow</p>
                ";
                                    };

                                    // ✅ 1. Admin Department
                                    $mail->setFrom('info@medicslab.com', 'Medics Digital Form');
                                    $mail->addAddress('syed.owais@medicslab.com', 'Finance Department');
                                    $mail->isHTML(true);
                                    $mail->Subject = $subject;
                                    $mail->Body = $bodyTemplate($name, 'Finance');
                                    $mail->send();

                                    // ✅ 2. Finance Department
                                    $mail->clearAddresses();
                                    $mail->addAddress('jawwad.ali@medicslab.com', 'Admin Department');
                                    $mail->Subject = $subject;
                                    $mail->Body = $bodyTemplate($name, 'Admin');
                                    $mail->send();

                                    // ✅ Success message after email send
                                    echo '
            <script>
                document.getElementById("loadingMsg").remove();
                alert("✅ Form submitted successfully and emails sent!");
                window.location.href = "cash_purchase_form.php";
            </script>';
                                } catch (Exception $e) {
                                    echo '
            <script>
                document.getElementById("loadingMsg").remove();
                alert("⚠️ Form saved but email failed to send. Please contact IT.");
                window.location.href = "cash_purchase_form.php";
            </script>';
                                    error_log("Mailer Error: " . $mail->ErrorInfo);
                                }
                            } else {
                                echo '<script>alert("❌ Form submission failed!"); window.location.href="cash_purchase_form.php";</script>';
                            }
                            exit;
                        }
                        ?>



                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include 'cdnjs.php'
    ?>
    <script>
        $(document).ready(function() {
            // Ensure the sidebar is active (visible) by default
            $('#sidebar').addClass('active'); // Change to addClass to show sidebar initially

            // Handle sidebar collapse toggle
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });

            // Update the icon when collapsing/expanding
            $('[data-bs-toggle="collapse"]').on('click', function() {
                var target = $(this).find('.toggle-icon');
                if ($(this).attr('aria-expanded') === 'true') {
                    target.removeClass('fa-plus').addClass('fa-minus');
                } else {
                    target.removeClass('fa-minus').addClass('fa-plus');
                }
            });
        });
    </script>
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Hide all rows except the first one initially
            for (let i = 2; i <= 10; i++) {
                document.getElementById("tr" + i).style.display = "none";
            }

            // Attach events to qty and price fields
            for (let i = 1; i <= 10; i++) {
                const qty = document.getElementById("qty_" + i);
                const price = document.getElementById("price_" + i);

                qty.addEventListener("input", () => calculateAmount(i));
                price.addEventListener("input", () => calculateAmount(i));

                // Detect if the row is filled to show the next one
                const inputs = [
                    document.getElementById("description_" + i),
                    document.getElementById("purpose_" + i),
                    qty,
                    price
                ];
                inputs.forEach(input => {
                    input.addEventListener("input", () => checkAndShowNextRow(i));
                });
            }

            function calculateAmount(index) {
                const qty = parseFloat(document.getElementById("qty_" + index).value) || 0;
                const price = parseFloat(document.getElementById("price_" + index).value) || 0;
                const amount = qty * price;

                // Show without decimals if it's an integer
                document.getElementById("amount_" + index).value =
                    Number.isInteger(amount) ? amount : amount.toFixed(2);

                updateTotal();
            }


            function checkAndShowNextRow(index) {
                if (index >= 10) return;

                const description = document.getElementById("description_" + index).value.trim();
                const purpose = document.getElementById("purpose_" + index).value.trim();
                const qty = document.getElementById("qty_" + index).value.trim();
                const price = document.getElementById("price_" + index).value.trim();

                if (description && purpose && qty && price) {
                    const nextRow = document.getElementById("tr" + (index + 1));
                    if (nextRow && nextRow.style.display === "none") {
                        nextRow.style.display = "table-row";
                    }
                }
            }

            function updateTotal() {
                let total = 0;
                for (let i = 1; i <= 10; i++) {
                    const amount = parseFloat(document.getElementById("amount_" + i).value) || 0;
                    total += amount;
                }
                // Keep full precision internally, format for display only
                document.getElementById("total_amount").value =
                    Number.isInteger(total) ? total : total.toFixed(2);
            }

        });
    </script>
</body>

</html>