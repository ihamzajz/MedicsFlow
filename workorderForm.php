<?php
ob_start(); // ✅ allows showing loading overlay + flushing before email send

session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$head_email = $_SESSION['head_email'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

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
            color: black !important;
        }

        input:focus {
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
        }

        textarea {
            border: 0.5px solid #adb5bd !important;
            border-radius: 0px !important;
        }

        .is-invalid {
            border: 1.5px solid red !important;
            background-color: #fff0f0;
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

                        <form class="form pb-3" method="POST">
                            <div class="card shadow">
                                <div class="card-header bg-header text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Workorder Form</h6>
                                    <a href="workorder_home.php" class="btn btn-light btn-sm" style="font-size:12px!important">
                                        <i class="fa-solid fa-home"></i> Home
                                    </a>
                                </div>

                                <div class="card-body">
                                    <table class="table table-responsive mt-3">
                                        <tr>
                                            <td style="font-weight:700;font-size:13px!important">Type:</td>
                                            <td class="pt-3">
                                                <label><input type="checkbox" class="type-checkbox cbox" name="type" value="Urgent"> Urgent&nbsp;</label>
                                            </td>
                                            <td class="pt-3">
                                                <label><input type="checkbox" class="type-checkbox cbox" name="type" value="Non-Urgent"> Non-Urgent</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><small id="typeError" class="text-danger d-none">Please select a type</small></td>
                                        </tr>

                                        <tr>
                                            <td style="font-weight:700;font-size:13px!important">Category: &nbsp; &nbsp;</td>
                                            <td class="pt-3">
                                                <label><input type="checkbox" class="category-checkbox cbox" name="category" value="General"> General&nbsp; &nbsp; &nbsp;</label>
                                            </td>
                                            <td class="pt-3">
                                                <label><input type="checkbox" class="category-checkbox cbox" name="category" value="Machine Breakdown"> Machine Breakdown</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><small id="categoryError" class="text-danger d-none">Please select a category</small></td>
                                        </tr>

                                        <tr>
                                            <td style="font-weight:700;font-size:13px!important">For: &nbsp; &nbsp;</td>
                                            <td class="pt-3">
                                                <label><input type="checkbox" class="category-checkbox cbox" name="depart_type" value="Engineering"> Engineering&nbsp; &nbsp; &nbsp;</label>
                                            </td>
                                            <td class="pt-3">
                                                <label><input type="checkbox" class="category-checkbox cbox" name="depart_type" value="Admin"> Admin</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><small id="departError" class="text-danger d-none">Please select a department</small></td>
                                        </tr>
                                    </table>

                                    <div class="form-group pt-4">
                                        <label class="form-label labelf">Description of workorder requested:</label>
                                        <textarea class="form-control" id="desc" name="desc" rows="3" minlength="10" maxlength="500"></textarea>
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

                            $id         = $_SESSION['id'];
                            $name       = $_SESSION['fullname'];
                            $email      = $_SESSION['email'];
                            $username   = $_SESSION['username'];
                            $department = $_SESSION['department'];
                            $role       = $_SESSION['role'];
                            $date       = date('Y-m-d H:i:s');

                            $desc = mysqli_real_escape_string($conn, $_POST['desc']);

                            $head_email = $_SESSION['head_email'];

                            $be_depart = $_SESSION['be_depart'];
                            $be_role   = $_SESSION['be_role'];

                            $type        = $_POST['type'];
                            $category    = $_POST['category'];
                            $depart_type = $_POST['depart_type'];

                            $insert = "INSERT INTO workorder_form
                                (name,username,email,date,department,role,be_depart,be_role,type,category,description,head_status,engineering_status,finance_status,ceo_status,amount,task_status,admin_status,depart_type)
                                VALUES
                                ('$name','$username','$email','$date','$department','$role','$be_depart','$be_role','$type','$category','$desc','Pending','Pending','Pending','Pending','TBD','Task is going through approval','Pending','$depart_type')";

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

                                // ✅ now send email (slow part)
                                try {
                                    // $mail = new PHPMailer(true);
                                    $mail->SMTPDebug = 0;
                                    $mail->Debugoutput = 'error_log';
                                    $mail->isSMTP();
                                    $mail->Host = 'smtp.office365.com';
                                    $mail->SMTPAuth = true;
                                    $mail->Username = 'info@medicslab.com';
                                    $mail->Password = 'kcmzrskfgmwzzshz';
                                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                    $mail->Port = 587;

                                    $mail->setFrom('info@medicslab.com', 'Medics Digital form');
                                    $mail->addAddress($head_email, 'HOD');
                                    //$mail->addAddress('muhammad.hamza@medicslab.com', 'HOD');

                                    $mail->isHTML(true);
                                    $mail->Subject = "Workorder Notification";
                                    $mail->Body = "
                                        <p>Dear HOD,</p>

                                        <p>
                                        A new work order request has been submitted by
                                        <strong>{$name}</strong>.
                                        </p>

                                        <p>
                                        Kindly review and process the request in <strong>MedicsFlow</strong>.
                                        </p>

                                        <p>
                                        Thank you.
                                        </p>

                                        <p>
                                        Best regards,<br>
                                        <strong>MedicsFlow</strong>
                                        </p>
                                        ";


                                    $mail->send();

                                    // ✅ success
                                    echo '
                                    <script>
                                        document.getElementById("loadingMsg").remove();
                                        alert("✅ Form submitted successfully");
                                        window.location.href = "workorderForm.php";
                                    </script>';
                                    exit;
                                } catch (Exception $e) {
                                    // ✅ DB saved but email failed
                                    error_log("Mailer Error: " . $mail->ErrorInfo);

                                    echo '
                                    <script>
                                        document.getElementById("loadingMsg").remove();
                                        alert("⚠️ Form submitted successfully, but email failed to send. Please contact IT.");
                                        window.location.href = "workorderForm.php";
                                    </script>';
                                    exit;
                                }
                            } else {
                                echo '
                                <script>
                                    alert("❌ Form submission failed!");
                                    window.location.href = "workorderForm.php";
                                </script>';
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
        $(document).ready(function() {
            $('#sidebar').addClass('active');
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
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
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.category-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const groupName = this.name.split('_')[0];
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
                    const groupName = this.name.split('_')[0];
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
                    const groupName = this.name.split('_')[0];
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
            const form = document.querySelector("form");

            const desc = document.getElementById("desc");
            const descError = document.getElementById("descError");
            const minLen = 10;
            const maxLen = 500;
            const pattern = /^[a-zA-Z0-9\s.,\-()\/']+$/;

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

            desc.addEventListener("input", validateDesc);

            const radioGroups = [{
                    radios: document.querySelectorAll("input[name='type']"),
                    errorElem: document.getElementById("typeError")
                },
                {
                    radios: document.querySelectorAll("input[name='category']"),
                    errorElem: document.getElementById("categoryError")
                },
                {
                    radios: document.querySelectorAll("input[name='depart_type']"),
                    errorElem: document.getElementById("departError")
                }
            ];

            function validateRadios(radios, errorElem) {
                const isChecked = [...radios].some(r => r.checked);
                errorElem.classList.toggle("d-none", isChecked);
                return isChecked;
            }

            radioGroups.forEach(group => {
                group.radios.forEach(r => r.addEventListener("change", () => validateRadios(group.radios, group.errorElem)));
            });

            form.addEventListener("submit", function(e) {
                const validDesc = validateDesc();
                const validRadios = radioGroups.map(g => validateRadios(g.radios, g.errorElem)).every(v => v);

                if (!validDesc || !validRadios) {
                    e.preventDefault();

                    if (!validDesc) {
                        desc.focus();
                    } else {
                        for (let g of radioGroups) {
                            if (![...g.radios].some(r => r.checked)) {
                                g.radios[0].focus();
                                break;
                            }
                        }
                    }
                }
            });
        });
    </script>

    <?php include 'footer.php' ?>
</body>

</html>