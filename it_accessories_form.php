<?php
ob_start(); // ✅ allows showing loading overlay + flushing before email send
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$head_email = $_SESSION['head_email'] ?? '';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// ✅ create once (same style as workorder_form)
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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <?php include 'cdncss.php' ?>

    <style>
        /* ✅ SAME LOOK/FEEL as workorder_form */
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

        textarea {
            border: 0.5px solid #adb5bd !important;
            border-radius: 0px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
        }

        textarea:focus {
            outline: none !important;
            border: 1px solid darkblue !important;
            background-color: #F4F6FF !important;
        }

        .is-invalid {
            border: 1.5px solid red !important;
            background-color: #fff0f0 !important;
        }

        .labelf {
            font-size: 13.5px !important;
            font-weight: 500;
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

    <?php include 'sidebarcss.php'; ?>
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar1.php'; ?>

        <div id="content">
            <!-- navbar -->
            <nav class="navbar navbar-expand-lg bg-menu">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </nav>

            <div class="container-fluid">
                <div class="row justify-content-center mt-3">
                    <div class="col-md-8 pt-md-4">

                        <form class="form pb-3" method="POST" novalidate>
                            <div class="card shadow">
                                <div class="card-header bg-header text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">IT Accessories Form</h6>
                                    <a href="it_accessories_home.php" class="btn btn-light btn-sm" style="font-size:12px!important">
                                        <i class="fa-solid fa-home"></i> Back
                                    </a>
                                </div>

                                <div class="card-body">
                                    <div class="form-group pt-4">
                                        <label class="form-label labelf">Description:</label>
                                        <textarea class="form-control" id="desc" name="desc" rows="6" minlength="10" maxlength="500" placeholder="type here..."></textarea>
                                        <small id="descError" class="text-danger d-none"></small>
                                    </div>

                                    <div class="text-center mt-4">
                                        <button type="submit" name="submit" class="btn btn-form px-4">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <?php
                        include 'dbconfig.php';

                        if (isset($_POST['submit'])) {

                            date_default_timezone_set("Asia/Karachi");

                            $name       = $_SESSION['fullname'] ?? '';
                            $email      = $_SESSION['email'] ?? '';
                            $username   = $_SESSION['username'] ?? '';
                            $department = $_SESSION['department'] ?? '';
                            $role       = $_SESSION['role'] ?? '';
                            $be_depart  = $_SESSION['be_depart'] ?? '';
                            $be_role    = $_SESSION['be_role'] ?? '';
                            $date       = date('Y-m-d H:i:s');
                            $emailDate = date('d-m-Y', strtotime($date));


                            $desc_raw = $_POST['desc'] ?? '';
                            $desc     = mysqli_real_escape_string($conn, (string)$desc_raw);

                            $insert = "INSERT INTO it_accessories
                                (name,username,email,date,department,role,be_depart,be_role,description,it_status,final_status)
                                VALUES
                                ('$name','$username','$email','$date','$department','$role','$be_depart','$be_role','$desc','Pending','Pending')";

                            $insert_q = mysqli_query($conn, $insert);

                            if ($insert_q) {

                                // ✅ SAME overlay behavior as workorder_form
                                echo '
                                <div id="loadingMsg" style="
                                    position:fixed;
                                    top:0;left:0;width:100%;height:100%;
                                    display:flex;align-items:center;justify-content:center;
                                    background:rgba(0,0,0,0.6);
                                    color:white;font-size:22px;z-index:9999;
                                    flex-direction:column;">
                                    <div style="padding:20px;background:#222;border-radius:10px;text-align:center;">
                                        <p style=\"margin:0 0 8px 0;\">📨 Please wait, your request is being processed...</p>
                                        <p style=\"margin:0;\">Email is sending, this may take a few seconds.</p>
                                    </div>
                                </div>
                                ';

                                // ✅ flush so user sees overlay immediately
                                ob_flush();
                                flush();

                                // ✅ Send Email (slow part)
                                try {
                                    $mail->SMTPDebug  = 0;
                                    $mail->Debugoutput = 'error_log';
                                    $mail->isSMTP();
                                    $mail->Host       = 'smtp.office365.com';
                                    $mail->SMTPAuth   = true;
                                    $mail->Username   = 'info@medicslab.com';
                                    $mail->Password   = 'kcmzrskfgmwzzshz';
                                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                    $mail->Port       = 587;

                                    $mail->setFrom('info@medicslab.com', 'Medics Digital Form');
                                    $mail->isHTML(true);
                                    $mail->Subject = "IT Accessories Notification";

                                    $safeDesc = nl2br(htmlspecialchars(trim((string)$desc_raw)));

                                    $mail->Body = "
    <p>Dear IT Team,</p>

    <p>
        This is to inform you that a new <strong>IT Accessories</strong> request has been submitted
        in <strong>MedicsFlow</strong>. Please review the details below and proceed accordingly.
    </p>

    <p style='margin:0;'><strong>Requested By:</strong> {$name}</p>
    <p style='margin:0;'><strong>Department:</strong> {$department}</p>
    <p style='margin:0;'><strong>Role:</strong> {$role}</p>
    <p style='margin:0;'><strong>Date Submitted:</strong> {$emailDate}</p>

    <p style='margin-top:12px;'><strong>Description:</strong><br>{$safeDesc}</p>

    <p>
        Kindly log in to <strong>MedicsFlow</strong> to review and process this request.
    </p>

    <p>Thank you.</p>

    <p>
        Best regards,<br>
        <strong>MedicsFlow</strong>
    </p>
";



                                    // 1st recipient
                                    $mail->addAddress('bilal.ahmed@medicslab.com', 'Bilal Ahmed - IT');
                                    //$mail->addAddress('muhammad.hamza@medicslab.com', 'Bilal IT');
                                    $mail->send();

                                    // 2nd recipient
                                    $mail->clearAddresses();
                                    $mail->addAddress('syed.salman@medicslab.com', 'Muhammad Salman IT');
                                    //$mail->addAddress('ihamzajz@gmail.com', 'Muhammad Hamza');
                                    $mail->send();

                                    echo '
                                    <script>
                                        document.getElementById("loadingMsg").remove();
                                        alert("✅ Your request has been submitted successfully!");
                                        window.location.href = "it_accessories_form.php";
                                    </script>';
                                    ob_end_flush();
                                    exit;
                                } catch (Exception $e) {
                                    error_log("Mailer Error: " . $mail->ErrorInfo);

                                    echo '
                                    <script>
                                        document.getElementById("loadingMsg").remove();
                                        alert("⚠️ Request saved but email failed. Please contact IT.");
                                        window.location.href = "it_accessories_form.php";
                                    </script>';
                                    ob_end_flush();
                                    exit;
                                }
                            } else {
                                echo '
                                <script>
                                    alert("❌ Submission failed!");
                                    window.location.href = "it_accessories_form.php";
                                </script>';
                                ob_end_flush();
                                exit;
                            }
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ✅ Sidebar toggle (same as workorder_form)
        $(document).ready(function() {
            $('#sidebar').addClass('active');
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar1').toggleClass('active');
            });
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
        // ✅ Description validation (same logic style as workorder_form)
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector("form");
            const desc = document.getElementById("desc");
            const descError = document.getElementById("descError");

            const minLen = 10;
            const maxLen = 500;
            const pattern = /^[a-zA-Z0-9\s.,\-()\/']+$/;

            function showDescError(msg) {
                desc.classList.add("is-invalid");
                descError.textContent = msg;
                descError.classList.remove("d-none");
            }

            function clearDescError() {
                desc.classList.remove("is-invalid");
                descError.textContent = "";
                descError.classList.add("d-none");
            }

            function validateDesc() {
                const value = desc.value.trim();

                if (value.length < minLen || value.length > maxLen) {
                    showDescError(`Description must be between ${minLen} and ${maxLen} characters.`);
                    return false;
                }
                if (!pattern.test(value)) {
                    showDescError("Only letters, numbers and basic punctuation are allowed.");
                    return false;
                }

                clearDescError();
                return true;
            }

            // initially no error; validate live on typing
            desc.addEventListener("input", validateDesc);

            form.addEventListener("submit", function(e) {
                const ok = validateDesc();
                if (!ok) {
                    e.preventDefault();
                    desc.focus();
                }
            });
        });
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>