<?php
ob_start(); // ✅ needed so loading overlay can flush before email sending
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
    <?php include 'cdncss.php' ?>

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

        .btn {
            border-radius: 0px
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #c7ccdb !important;
        }

        .cbox {
            height: 13px !important;
            width: 13px !important;
        }

        th {
            font-size: 10.5px !important;
            border: none !important;
            background-color: #3a506b !important;
            color: white !important;
            padding: 6px 5px !important;
        }

        td {
            font-size: 11px;
            color: black;
            padding: 7px 5px !important;
            font-weight: 500;
            border: none !important
        }

        input {
            width: 100% !important;
            font-size: 11px !important;
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

    <?php include 'sidebarcss.php'; ?>
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <?php include 'sidebar1.php'; ?>

        <!-- Page Content  -->
        <div id="content">
            <!-- navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-menu">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>
                </div>
            </nav>

            <div class="container pt-2">
                <div class="row justify-content-center">
                    <div class="col-md-8">

                        <form class="form pb-3" method="POST">
                            <div class="card shadow mt-3">
                                <div class="card-header bg-header text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">ERP Access Form</h6>
                                    <a href="erp_access_home.php" class="btn btn-light btn-sm" style="font-size:12px!important">
                                        <i class="fa-solid fa-home"></i> Home
                                    </a>
                                </div>

                                <div class="card-body">

                                    <div class="">
                                        <label class="mr-4" style="font-size:13px!important">
                                            <input type="checkbox" class="add-remove-checkbox10 cbox" name="request_type"
                                                value="New Access" style="font-size:8px!important"> New access request
                                        </label>
                                        <label style="font-size:13px!important">
                                            <input type="checkbox" class="add-remove-checkbox10 cbox" name="request_type"
                                                value="Change Of Access" style="font-size:8px!important"> Change Of access rights
                                        </label>
                                    </div>

                                    <h6 class="mt-3" style="font-weight:600;font-size:13px">Requested Roles</h6>

                                    <table class="table table-stipped" cellpadding="0" cellspacing="0">
                                        <thead class="thead-dark th">
                                            <tr>
                                                <th>Modules</th>
                                                <th>Add</th>
                                                <th>Remove</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>SCM - Purchase</td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="add-remove-checkbox cbox"
                                                            name="scm_purchase" value="add"> Add</label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="add-remove-checkbox cbox"
                                                            name="scm_purchase" value="remove"> Remove</label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>SCM - Inventory</td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="add-remove-checkbox2 cbox"
                                                            name="scm_inventory" value="add"> Add</label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="add-remove-checkbox2 cbox"
                                                            name="scm_inventory" value="remove"> Remove</label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>SCM - Production</td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="add-remove-checkbox3 cbox"
                                                            name="scm_production" value="add"> Add</label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="add-remove-checkbox3 cbox"
                                                            name="scm_production" value="remove"> Remove</label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>SCM - Sales</td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="add-remove-checkbox4 cbox"
                                                            name="scm_sales" value="add"> Add</label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="add-remove-checkbox4 cbox"
                                                            name="scm_sales" value="remove"> Remove</label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>SCM - Misc</td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="add-remove-checkbox5 cbox" name="scm_misc"
                                                            value="add"> Add</label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="add-remove-checkbox5 cbox" name="scm_misc"
                                                            value="remove"> Remove</label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>SCM - Admin Setup</td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="add-remove-checkbox6 cbox"
                                                            name="scm_admin_setup" value="add"> Add</label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="add-remove-checkbox6 cbox"
                                                            name="scm_admin_setup" value="remove"> Remove</label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>SCM - General Ledger</td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="add-remove-checkbox7 cbox"
                                                            name="scm_general_ledger" value="add"> Add</label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="add-remove-checkbox7 cbox"
                                                            name="scm_general_ledger" value="remove"> Remove</label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>SCM - Accounts Payable</td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="add-remove-checkbox8 cbox"
                                                            name="scm_accounts_payable" value="add"> Add</label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="add-remove-checkbox8 cbox"
                                                            name="scm_accounts_payable" value="remove"> Remove</label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>HCM</td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="add-remove-checkbox9 cbox" name="hcm"
                                                            value="add"> Add</label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="add-remove-checkbox9 cbox" name="hcm"
                                                            value="remove"> Remove</label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="3">
                                                    <textarea class="form-control" name="message" placeholder="Message..." rows="3"></textarea>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="text-center mt-4">
                                        <button type="submit" name="submit" class="btn btn-form px-4">
                                            Submit
                                        </button>
                                    </div>

                                </div><!-- card-body -->
                            </div><!-- card -->
                        </form>

                        <?php
                        include 'dbconfig.php';

                        if (isset($_POST['submit'])) {

                            date_default_timezone_set("Asia/Karachi");

                            $id = $_SESSION['id'];
                            $name = $_SESSION['fullname'];
                            $username = $_SESSION['username'];
                            $email = $_SESSION['email'];
                            $department = $_SESSION['department'];
                            $role = $_SESSION['role'];
                            $date = date('Y-m-d');

                            $req_type = $_POST['request_type'];
                            $head_email = $_SESSION['head_email'];

                            $scm_purchase = $_POST['scm_purchase'];
                            $scm_inventory = $_POST['scm_inventory'];
                            $scm_production = $_POST['scm_production'];
                            $scm_sales = $_POST['scm_sales'];
                            $scm_misc = $_POST['scm_misc'];
                            $scm_admin_setup = $_POST['scm_admin_setup'];
                            $scm_general_ledger = $_POST['scm_general_ledger'];
                            $scm_accounts_payable = $_POST['scm_accounts_payable'];
                            $hcm = $_POST['hcm'];

                            $message = mysqli_real_escape_string($conn, $_POST['message']);

                            $be_depart = $_SESSION['be_depart'];
                            $be_role = $_SESSION['be_role'];

                            $insert = "INSERT INTO erpaccess_form 
                                (name,email,username,date,department,role,req_type,scm_purchase,scm_inventory,scm_production,scm_sales,scm_misc,scm_admin_setup,scm_general_ledger,scm_accounts_payable,hcm,it_head_status,fc_status,department_head_status,ceo_status,feedback,message,be_depart,be_role)
                                VALUES 
                                ('$name','$email','$username','$date','$department','$role','$req_type','$scm_purchase','$scm_inventory','$scm_production','$scm_sales','$scm_misc','$scm_admin_setup','$scm_general_ledger','$scm_accounts_payable','$hcm','Pending','Pending','Pending','Pending','Pending','$message','$be_depart','$be_role ')";

                            $insert_q = mysqli_query($conn, $insert);

                            if ($insert_q) {

                                // ✅ show loading overlay BEFORE sending email
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

                                // ✅ flush so user sees overlay immediately
                                ob_flush();
                                flush();

                                // Sending email (same logic)
                                try {
                                    //Server settings
                                    $mail->SMTPDebug = 0;
                                    $mail->Debugoutput = 'error_log';
                                    $mail->isSMTP();
                                    $mail->Host = 'smtp.office365.com';
                                    $mail->SMTPAuth = true;
                                    $mail->Username = 'info@medicslab.com';
                                    $mail->Password = 'kcmzrskfgmwzzshz';
                                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                    $mail->Port = 587;

                                    //Recipients
                                    $mail->setFrom('info@medicslab.com', 'Medics Digital form');
                                    $mail->addAddress($head_email, 'HOD');

                                    //Content
                                    $mail->isHTML(true);
                                    $mail->Subject = "ERP Access Approval - Notification";
                                    $mail->Body = "
    <p>Dear Concern,</p>
    <p>
        A new <strong>ERP Access Request</strong> has been submitted by 
        <strong>{$name}</strong> ({$department} - {$role}).
    </p>
    <p>
        Kindly review and approve the request in <strong>MedicsFlow</strong> 
        at your earliest convenience so it may proceed to the IT Department for further processing.
    </p>
    <p>
        If you require any clarification, please contact the requester directly.
    </p>
    <br>
    <p>
        Best regards,<br>
        <strong>MedicsFlow System</strong>
    </p>
";


                                    $mail->send();

                                    // ✅ remove overlay after success
                                    echo '<script>
                                        var el = document.getElementById("loadingMsg");
                                        if(el) el.remove();
                                    </script>';
                                } catch (Exception $e) {

                                    // ✅ remove overlay on fail too
                                    echo '<script>
                                        var el = document.getElementById("loadingMsg");
                                        if(el) el.remove();
                                    </script>';

                                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                                }
                        ?>
                                <script type="text/javascript">
                                    alert("Form has been submitted!");
                                    window.location.href = "erpAccessForm.php";
                                </script>
                            <?php
                            } else {
                            ?>
                                <script type="text/javascript">
                                    alert("Form submission failed!");
                                    window.location.href = "erpAccessForm.php";
                                </script>
                        <?php
                            }
                            exit;
                        }
                        ?>

                    </div><!-- col -->
                </div><!-- row -->
            </div><!-- container -->
        </div><!-- content -->
    </div><!-- wrapper -->

    <?php include 'cdnjs.php' ?>

    <script>
        $(document).ready(function() {
            // Ensure the sidebar is active (visible) by default
            $('#sidebar1').addClass('active'); // Change to addClass to show sidebar initially

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

    <!-- 3 -->
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

    <!-- 4 -->
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

    <!-- 5 -->
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

    <!-- 6 -->
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

    <!-- 7 -->
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

    <!-- 8 -->
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

    <!-- 9 -->
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

    <!-- 10 -->
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

    <script src="assets/js/main.js"></script>
</body>

</html>