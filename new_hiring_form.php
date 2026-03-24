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

// DB
require 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

/* =========================
   Helpers (for validation + old values)
========================= */
$errors = [];
$old = [];

function oldv($key, $default = '')
{
    global $old;
    return isset($old[$key]) ? $old[$key] : $default;
}
function has_error($key)
{
    global $errors;
    return isset($errors[$key]) && $errors[$key] !== '';
}
function err($key)
{
    global $errors;
    return isset($errors[$key]) ? $errors[$key] : '';
}
function get_post($key, $default = '')
{
    return isset($_POST[$key]) ? (is_string($_POST[$key]) ? trim($_POST[$key]) : $_POST[$key]) : $default;
}
function validate_text(&$errors, $key, $label, $value, $min = 2, $max = 500)
{
    $v = trim((string)$value);
    if ($v === '') {
        $errors[$key] = "$label is required.";
        return;
    }
    $len = mb_strlen($v);
    if ($len < $min) {
        $errors[$key] = "$label must be at least {$min} characters.";
        return;
    }
    if ($len > $max) {
        $errors[$key] = "$label must be at most {$max} characters.";
        return;
    }
}

// Default date for display (dd-mm-yyyy)
$todayDisplay = date('d-m-Y');

// ===============================
// ✅ Handle POST (Validation + Insert via Prepared Statement + Email logic unchanged)
// ===============================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    // keep old values for repopulate
    foreach ($_POST as $k => $v) {
        $old[$k] = is_string($v) ? trim($v) : $v;
    }

    // Session user info
    $id = $_SESSION['id'];
    $name = $_SESSION['fullname'];
    $email = $_SESSION['email'];
    $username = $_SESSION['username'];
    $department2 = $_SESSION['department'];
    $role = $_SESSION['role'];
    $date = date('Y-m-d H:i:s');

    $be_depart = $_SESSION['be_depart'];
    $be_role = $_SESSION['be_role'];
    $be_role2 = $_SESSION['be_role2'];

    // =========================
    // ✅ Read inputs
    // =========================
    $form_for = get_post('form_for', ''); // Head Office OR Sales
    $date_of_request_display = get_post('date_of_request', $todayDisplay); // dd-mm-yyyy
    $position_title = get_post('position_title');
    $department = get_post('department');
    $division = get_post('division');
    $location = get_post('location');

    $reason_of_request = get_post('reason_of_request', ''); // New Position OR Replacement
    $emp_name = get_post('emp_name');
    $emp_code = get_post('emp_code');
    $designation = get_post('designation');

    $required_education = get_post('required_education');
    $salary_range = get_post('salary_range');
    $job_type = get_post('job_type');
    $job_responsibilities = get_post('job_responsibilities');

    // Sales Qs (your INSERT uses these, but your old code never read them)
    $q1 = get_post('q1');
    $q2 = get_post('q2');
    $q3 = get_post('q3');

    // Years (FIX: ensure Sept = year9, Oct = year10)
    $year1 = get_post('year1');
    $year2 = get_post('year2');
    $year3 = get_post('year3');
    $year4 = get_post('year4');
    $year5 = get_post('year5');
    $year6 = get_post('year6');
    $year7 = get_post('year7');
    $year8 = get_post('year8');
    $year9 = get_post('year9');   // September
    $year10 = get_post('year10'); // October
    $year11 = get_post('year11');
    $year12 = get_post('year12');
    $year13 = get_post('year13');

    $customer_1 = get_post('customer_1');
    $customer_2 = get_post('customer_2');
    $customer_3 = get_post('customer_3');
    $customer_4 = get_post('customer_4');
    $customer_5 = get_post('customer_5');
    $customer_6 = get_post('customer_6');
    $customer_7 = get_post('customer_7');
    $customer_8 = get_post('customer_8');
    $customer_9 = get_post('customer_9');
    $customer_10 = get_post('customer_10');
    $customer_11 = get_post('customer_11');
    $customer_12 = get_post('customer_12');
    $customer_13 = get_post('customer_13');

    $existing_sales_1 = get_post('existing_sales_1');
    $existing_sales_2 = get_post('existing_sales_2');
    $existing_sales_3 = get_post('existing_sales_3');
    $existing_sales_4 = get_post('existing_sales_4');
    $existing_sales_5 = get_post('existing_sales_5');
    $existing_sales_6 = get_post('existing_sales_6');
    $existing_sales_7 = get_post('existing_sales_7');
    $existing_sales_8 = get_post('existing_sales_8');
    $existing_sales_9 = get_post('existing_sales_9');
    $existing_sales_10 = get_post('existing_sales_10');
    $existing_sales_11 = get_post('existing_sales_11');
    $existing_sales_12 = get_post('existing_sales_12');
    $existing_sales_13 = get_post('existing_sales_13');

    $exp_sales_1 = get_post('exp_sales_1');
    $exp_sales_2 = get_post('exp_sales_2');
    $exp_sales_3 = get_post('exp_sales_3');
    $exp_sales_4 = get_post('exp_sales_4');
    $exp_sales_5 = get_post('exp_sales_5');
    $exp_sales_6 = get_post('exp_sales_6');
    $exp_sales_7 = get_post('exp_sales_7');
    $exp_sales_8 = get_post('exp_sales_8');
    $exp_sales_9 = get_post('exp_sales_9');
    $exp_sales_10 = get_post('exp_sales_10');
    $exp_sales_11 = get_post('exp_sales_11');
    $exp_sales_12 = get_post('exp_sales_12');
    $exp_sales_13 = get_post('exp_sales_13');

    $bdo_1 = get_post('bdo_1');
    $bdo_2 = get_post('bdo_2');
    $bdo_3 = get_post('bdo_3');
    $bdo_4 = get_post('bdo_4');
    $bdo_5 = get_post('bdo_5');
    $bdo_6 = get_post('bdo_6');
    $bdo_7 = get_post('bdo_7');
    $bdo_8 = get_post('bdo_8');
    $bdo_9 = get_post('bdo_9');
    $bdo_10 = get_post('bdo_10');
    $bdo_11 = get_post('bdo_11');
    $bdo_12 = get_post('bdo_12');
    $bdo_13 = get_post('bdo_13');

    // =========================
    // ✅ Server-side validation (as you requested)
    // =========================

    // Form For (Head Office / Sales) - required exactly one
    if ($form_for !== 'Head Office' && $form_for !== 'Sales') {
        $errors['form_for'] = "Please select exactly one option (Head Office OR Sales).";
    }

    // Date (display dd-mm-yyyy, save yyyy-mm-dd)
    if ($date_of_request_display === '') {
        $errors['date_of_request'] = "Date Of Request is required.";
    } else {
        $dt = DateTime::createFromFormat('d-m-Y', $date_of_request_display);
        if (!$dt || $dt->format('d-m-Y') !== $date_of_request_display) {
            $errors['date_of_request'] = "Date Of Request must be in dd-mm-yyyy format.";
        }
    }

    validate_text($errors, 'position_title', 'Position Title', $position_title, 2, 500);
    validate_text($errors, 'department', 'Department', $department, 2, 500);
    validate_text($errors, 'division', 'Division', $division, 2, 500);
    validate_text($errors, 'location', 'Location', $location, 2, 500);

    // Reason (New Position / Replacement) - required exactly one
    if ($reason_of_request !== 'New Position' && $reason_of_request !== 'Replacement') {
        $errors['reason_of_request'] = "Please select exactly one option (New Position OR Replacement).";
    }

    // Conditional required fields
    if ($reason_of_request === 'New Position') {
        validate_text($errors, 'required_education', 'Required Education / Certification', $required_education, 2, 500);
        validate_text($errors, 'salary_range', 'Salary Range', $salary_range, 2, 500);
        validate_text($errors, 'job_type', 'Job Type', $job_type, 2, 500);
        validate_text($errors, 'job_responsibilities', 'Job Responsibilities', $job_responsibilities, 2, 500);
    } elseif ($reason_of_request === 'Replacement') {
        validate_text($errors, 'emp_name', 'Emp Name', $emp_name, 2, 500);
        validate_text($errors, 'emp_code', 'Emp Code', $emp_code, 2, 500);
        validate_text($errors, 'designation', 'Designation', $designation, 2, 500);

        validate_text($errors, 'required_education', 'Required Education / Certification', $required_education, 2, 500);
        validate_text($errors, 'salary_range', 'Salary Range', $salary_range, 2, 500);
        validate_text($errors, 'job_type', 'Job Type', $job_type, 2, 500);
        validate_text($errors, 'job_responsibilities', 'Job Responsibilities', $job_responsibilities, 2, 500);
    }

    // If errors -> do NOT insert, just show errors in form
    if (count($errors) === 0) {

        // Convert date to yyyy-mm-dd for DB
        $date_of_request = DateTime::createFromFormat('d-m-Y', $date_of_request_display)->format('Y-m-d');

        // =========================
        // ✅ INSERT using Prepared Statement (bind parameters)
        // =========================
        $sql = "INSERT INTO new_hiring (
            date_of_request, position_title, department, division, location,
            reason_of_request, emp_name, emp_code, designation,
            required_education, salary_range, job_type, job_responsibilities,
            user_name, user_department, user_role, user_email, user_be_department, user_be_role, user_be_role2,
            form_for, q1, q2, q3,
            january1, february1, march1, april1, may1, june1, july1, august1, september1, october1, november1, december1, average_sales1,
            customer_1,customer_2,customer_3,customer_4,customer_5,customer_6,customer_7,customer_8,customer_9,customer_10,customer_11,customer_12,customer_13,
            existing_sales_1, existing_sales_2, existing_sales_3, existing_sales_4, existing_sales_5, existing_sales_6, existing_sales_7, existing_sales_8, existing_sales_9, existing_sales_10, existing_sales_11, existing_sales_12, existing_sales_13,
            exp_sales_1, exp_sales_2, exp_sales_3, exp_sales_4, exp_sales_5, exp_sales_6, exp_sales_7, exp_sales_8, exp_sales_9, exp_sales_10, exp_sales_11, exp_sales_12, exp_sales_13,
            bdo_1, bdo_2, bdo_3, bdo_4, bdo_5, bdo_6, bdo_7, bdo_8, bdo_9, bdo_10, bdo_11, bdo_12, bdo_13,
            hod_status, hr_status, ceo_status
        ) VALUES (
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?
        )";

        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            echo '<script>alert("❌ Submission failed!"); window.location.href="new_hiring_form.php";</script>';
            exit;
        }

        $values = [
            $date_of_request, $position_title, $department, $division, $location,
            $reason_of_request, $emp_name, $emp_code, $designation,
            $required_education, $salary_range, $job_type, $job_responsibilities,
            $name, $department2, $role, $email, $be_depart, $be_role, $be_role2,
            $form_for, $q1, $q2, $q3,
            $year1, $year2, $year3, $year4, $year5, $year6, $year7, $year8, $year9, $year10, $year11, $year12, $year13,
            $customer_1, $customer_2, $customer_3, $customer_4, $customer_5, $customer_6, $customer_7, $customer_8, $customer_9, $customer_10, $customer_11, $customer_12, $customer_13,
            $existing_sales_1, $existing_sales_2, $existing_sales_3, $existing_sales_4, $existing_sales_5, $existing_sales_6, $existing_sales_7, $existing_sales_8, $existing_sales_9, $existing_sales_10, $existing_sales_11, $existing_sales_12, $existing_sales_13,
            $exp_sales_1, $exp_sales_2, $exp_sales_3, $exp_sales_4, $exp_sales_5, $exp_sales_6, $exp_sales_7, $exp_sales_8, $exp_sales_9, $exp_sales_10, $exp_sales_11, $exp_sales_12, $exp_sales_13,
            $bdo_1, $bdo_2, $bdo_3, $bdo_4, $bdo_5, $bdo_6, $bdo_7, $bdo_8, $bdo_9, $bdo_10, $bdo_11, $bdo_12, $bdo_13,
            'Pending', 'Pending', 'Pending'
        ];

        $types = str_repeat('s', count($values));
        mysqli_stmt_bind_param($stmt, $types, ...$values);

        $insert_q = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        if ($insert_q) {

            /* ===============================
               SHOW LOADER FIRST (UNCHANGED)
            =============================== */
            echo '
            <div id="loadingMsg" style="
                position:fixed;
                top:0;left:0;width:100%;height:100%;
                display:flex;
                align-items:center;
                justify-content:center;
                background:rgba(0,0,0,0.6);
                color:white;
                font-size:22px;
                z-index:9999;
                flex-direction:column;">
                <div style="padding:25px;background:#222;border-radius:10px;text-align:center;">
                    <p>📨 Please wait...</p>
                    <p>Your request is being processed.</p>
                    <p>Email is sending, this may take a few seconds.</p>
                </div>
            </div>
            ';

            // ✅ FORCE browser to show loader
            if (function_exists('ob_flush')) { @ob_flush(); }
            if (function_exists('flush')) { @flush(); }

            // Sending email (DO NOT TOUCH)
            try {
                // Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->Host = 'smtp.office365.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'info@medicslab.com';
                $mail->Password = 'kcmzrskfgmwzzshz';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // ====== First Email to HOD ======
                $mail->setFrom('info@medicslab.com', 'Medics Digital Form');
                $mail->addAddress($head_email, 'HOD');

                $mail->isHTML(true);
                $mail->Subject = "New Hiring Requisition Form";
                $mail->Body = "
                    <p>Dear HOD,</p>
                    <p>A new (New Hiring Form) has been submitted by <strong>{$_SESSION['fullname']}</strong>. Kindly review the request and proceed with either approval or rejection.</p>
                    <p>You can access the form through the following link: <a href=\"http://43.245.128.46:9090/medicsflow\" target=\"_blank\">MedicsFlow</a></p>
                    <p>Thank you.</p>
                ";

                $mail->send();
                $mail->clearAddresses(); // Clear previous recipients

                // ====== Second Email to HR Head ======
                $mail->addAddress('taha.ahmed@medicslab.com', 'HR - Head');
                $mail->addAddress('shaukat.ali@medicslab.com', 'HR - DM');
                $mail->addAddress('rabisha.asim@medicslab.com', 'HR - Officer');

                $mail->Subject = "New Hiring Submission Notification";
                $mail->Body = "
                    <p>Dear HR Department,</p>
                    <p>A new <strong>New Hiring Form</strong> has been submitted by <strong>{$_SESSION['fullname']}</strong>.</p>
                    <p>Please check the portal to review the submission.</p>
                    <p><a href=\"http://43.245.128.46:9090/medicsflow\" target=\"_blank\">Go to MedicsFlow</a></p>
                    <p>Thank you.</p>
                ";

                $mail->send();

                echo '
                <script>
                    document.getElementById("loadingMsg").remove();
                    alert("✅ Your request has been submitted successfully!");
                    window.location.href = "new_hiring_form.php";
                </script>';
            } catch (Exception $e) {

                echo '
                <script>
                    document.getElementById("loadingMsg").remove();
                    alert("⚠️ Request saved but email failed. Please contact IT.");
                    window.location.href = "new_hiring_form.php";
                </script>';

                error_log("Mailer Error: " . $mail->ErrorInfo);
            }

            exit;
        } else {
            echo '<script>alert("❌ Submission failed!"); window.location.href="new_hiring_form.php";</script>';
            exit;
        }
    }
}
// end POST handling
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New Hiring</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"
        integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .textp { font-size: 12px !important; }
        .th_secondary {
            font-size: 12px !important;
            color: white !important;
            background-color: #3D3D3D !important;
            text-transform: capitalize !important;
        }
        body { font-family: 'Poppins', sans-serif; background-color: #f5f6fa; }
        .card { border-radius: 10px; }
        .bg-menu { background-color: #393E46 !important; }
        .btn-menu {
            font-size: 12.5px;
            background-color: #FFB22C !important;
            padding: 5px 10px;
            font-weight: 600;
            border: none !important;
        }
        .cbox { height: 13px !important; width: 13px !important; }
        td, .labelf { font-size: 12.5px !important; padding: 0px !important; margin: 0px !important; font-weight: 500; }
        .labelf { font-size: 13.5px !important; }
        label { font-size: 13px !important; font-weight: 600 !important; letter-spacing: 0.2px !important; }
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

        /* ✅ error msg style */
        .field-error { display:none; font-size:12px; margin-top:4px; }
        .is-invalid-field { border-color: #dc3545 !important; background: #fff0f0 !important; }
    </style>

    <style>
        .table1 tr, .table1 td, .table1 th,
        .table2 tr, .table2 td, .table2 th,
        .table3 tr, .table3 td, .table3 th,
        .table4 tr, .table4 td, .table4 th,
        .table5 tr, .table5 td { border: none !important; }

        .table1 th, .table2 th, .table3 th, .table4 th, .table5 th { width: 250px !important; font-size: 13px !important; }
        .table4 th { font-size: 12.5px !important; }
        .table5 th { background-color: #AEDEFC !important; }
        .table1 td input, .table2 td input, .table3 td input, .table4 td input { height: 32px !important; }
        .table5 td input { height: 25px !important; }

        select, option { height: 25px !important; font-size: 11px !important; }
    </style>

    <style>
            .bg-header { background-color: #1f7a8c; }
        .btn-form, .btn-form:hover { background-color: #0e6ba8; border-radius: 20px; color: white; }

    </style>

    <?php include 'sidebarcss.php' ?>
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar1.php'; ?>

        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-menu">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </nav>

            <div class="container-fluid">
                <div class="row justify-content-center mt-2">
                    <div class="col-md-10 pt-md-2">

                        <form class="form pb-3" method="POST" id="emailForm" enctype="multipart/form-data">

                            <div class="card shadow">
                                  <div class="card-header bg-header text-white d-flex justify-content-between align-items-center">
                                <h6 class="mb-0" style="font-weight:600!important">New Hiring Form</h6>
                                <a href="new_hiring_home.php" class="btn btn-light btn-sm" style="font-size:13px">
                                    <i class="fa-solid fa-home"></i> Home
                                </a>
                            </div>

                                <div class="card-body">

                                    <div class="pb-3 d-flex align-items-start flex-column" style="gap: 10px;">
                                        <p style="font-size:18px!important; margin: 0;" class="text-primary"><b>Form For</b></p>
                                        <div>
                                            <label style="font-size:15px; margin: 0;">
                                                <input type="checkbox" class="for-checkbox cbox" name="form_for"
                                                    value="Head Office" id="head_office"
                                                    <?php echo (oldv('form_for') === 'Head Office') ? 'checked' : ''; ?>
                                                > Head Office
                                            </label>
                                            <label style="font-size:15px; margin: 0; margin-left: 10px;">
                                                <input type="checkbox" class="for-checkbox cbox" name="form_for" value="Sales"
                                                    id="sales"
                                                    <?php echo (oldv('form_for') === 'Sales') ? 'checked' : ''; ?>
                                                > Sales
                                            </label>

                                            <!-- ✅ error below checkbox group -->
                                            <div class="text-danger field-error" id="err_form_for"><?php echo err('form_for'); ?></div>
                                        </div>
                                    </div>

                                    <div style="border:0.1px solid grey!important;padding:15px!important">
                                        <table class="table table1">
                                            <tbody>
                                                <tr>
                                                    <th>Date Of Request</th>
                                                    <td>
                                                        <input type="text" name="date_of_request" id="date_of_request" readonly
                                                            value="<?php echo htmlspecialchars(oldv('date_of_request', $todayDisplay)); ?>">
                                                        <div class="text-danger field-error" id="err_date_of_request"><?php echo err('date_of_request'); ?></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Position Title</th>
                                                    <td>
                                                        <input type="text" name="position_title" id="position_title" value="<?php echo htmlspecialchars(oldv('position_title')); ?>">
                                                        <div class="text-danger field-error" id="err_position_title"><?php echo err('position_title'); ?></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Department</th>
                                                    <td>
                                                        <input type="text" name="department" id="department" value="<?php echo htmlspecialchars(oldv('department')); ?>">
                                                        <div class="text-danger field-error" id="err_department"><?php echo err('department'); ?></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Division</th>
                                                    <td>
                                                        <input type="text" name="division" id="division" value="<?php echo htmlspecialchars(oldv('division')); ?>">
                                                        <div class="text-danger field-error" id="err_division"><?php echo err('division'); ?></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Location</th>
                                                    <td>
                                                        <input type="text" name="location" id="location" value="<?php echo htmlspecialchars(oldv('location')); ?>">
                                                        <div class="text-danger field-error" id="err_location"><?php echo err('location'); ?></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div>
                                        <p style="font-size:13px!important" class="mt-3"><b>Reason of Request:</b><br>
                                            (In case of new hiring HOD should provide proper justification and value addition)
                                        </p>
                                        <label>
                                            <input type="checkbox" class="type-checkbox cbox" name="reason_of_request"
                                                value="New Position" id="new_position"
                                                <?php echo (oldv('reason_of_request') === 'New Position') ? 'checked' : ''; ?>
                                            > New Position&nbsp;
                                        </label>
                                        <label>
                                            <input type="checkbox" class="type-checkbox cbox" name="reason_of_request"
                                                value="Replacement" id="replacement"
                                                <?php echo (oldv('reason_of_request') === 'Replacement') ? 'checked' : ''; ?>
                                            > Replacement
                                        </label>

                                        <!-- ✅ error below checkbox group -->
                                        <div class="text-danger field-error" id="err_reason_of_request"><?php echo err('reason_of_request'); ?></div>
                                    </div>

                                    <!-- Replacement Table -->
                                    <div style="border:0.1px solid grey!important;padding:15px!important;display:none"
                                        class="mt-3 table2-wrap" id="replacementBlock">
                                        <table class="table table2">
                                            <tbody>
                                                <tr>
                                                    <td colspan="2" class="text-center pb-3">
                                                        <b> Fill In case of Replacement Hiring</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Emp Name</th>
                                                    <td>
                                                        <input type="text" name="emp_name" id="emp_name" value="<?php echo htmlspecialchars(oldv('emp_name')); ?>">
                                                        <div class="text-danger field-error" id="err_emp_name"><?php echo err('emp_name'); ?></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Emp Code</th>
                                                    <td>
                                                        <input type="text" name="emp_code" id="emp_code" value="<?php echo htmlspecialchars(oldv('emp_code')); ?>">
                                                        <div class="text-danger field-error" id="err_emp_code"><?php echo err('emp_code'); ?></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Designation</th>
                                                    <td>
                                                        <input type="text" name="designation" id="designation" value="<?php echo htmlspecialchars(oldv('designation')); ?>">
                                                        <div class="text-danger field-error" id="err_designation"><?php echo err('designation'); ?></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Remaining Form -->
                                    <div style="border:0.1px solid grey!important;padding:15px!important" class="mt-3">
                                        <table class="table table3">
                                            <tbody>
                                                <tr>
                                                    <th style="width:70px!important">Required Education / Certification:</th>
                                                    <td>
                                                        <input type="text" name="required_education" id="required_education" value="<?php echo htmlspecialchars(oldv('required_education')); ?>">
                                                        <div class="text-danger field-error" id="err_required_education"><?php echo err('required_education'); ?></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Salary Range</th>
                                                    <td>
                                                        <input type="text" name="salary_range" id="salary_range" value="<?php echo htmlspecialchars(oldv('salary_range')); ?>">
                                                        <div class="text-danger field-error" id="err_salary_range"><?php echo err('salary_range'); ?></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Job Type</th>
                                                    <td>
                                                        <input type="text" name="job_type" id="job_type" value="<?php echo htmlspecialchars(oldv('job_type')); ?>">
                                                        <div class="text-danger field-error" id="err_job_type"><?php echo err('job_type'); ?></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Job Responsibilities:</th>
                                                    <td>
                                                        <textarea name="job_responsibilities" id="job_responsibilities" rows="4" style="width: 100%;"><?php echo htmlspecialchars(oldv('job_responsibilities')); ?></textarea>
                                                        <div class="text-danger field-error" id="err_job_responsibilities"><?php echo err('job_responsibilities'); ?></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Sales Qs -->
                                    <div style="border:0.1px solid grey!important;padding:15px!important" class="mt-3" id="salesQBlock">
                                        <p style="font-size:13px!important" class="mt-1"><b>Mandatory Responses:</b><br>
                                        <table class="table table4">
                                            <tbody>
                                                <tr>
                                                    <th><b>Q1.</b> How many field force team do you have and which area they are covering?</th>
                                                    <td><textarea name="q1" id="q1" rows="3" style="width: 100%;"><?php echo htmlspecialchars(oldv('q1')); ?></textarea></td>
                                                </tr>
                                                <tr>
                                                    <th><b>Q2.</b> Which area will be covered by this new position?</th>
                                                    <td><textarea name="q2" id="q2" rows="3" style="width: 100%;"><?php echo htmlspecialchars(oldv('q2')); ?></textarea></td>
                                                </tr>
                                                <tr>
                                                    <th><b>Q3.</b> What are current sales of subjected area?</th>
                                                    <td><textarea name="q3" id="q3" rows="3" style="width: 100%;"><?php echo htmlspecialchars(oldv('q3')); ?></textarea></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Sales table (months) -->
                                    <div style="border:0.1px solid grey!important;padding:15px!important" class="mt-3" id="salesMonthBlock">
                                        <p style="font-size:13px!important" class="mt-1"><b>Mandatory Responses:</b><br>
                                        <table class="table table5">
                                            <thead>
                                                <tr>
                                                    <th style="width:150px!important">Month </th>
                                                    <th style="width:80px!important">(Mention Year)</th>
                                                    <th>No. of Customers</th>
                                                    <th>Existing Sales / month</th>
                                                    <th>Expected Sales / month</th>
                                                    <th>Current BDO Assigned</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $currentYear = date("Y");
                                                $start = $currentYear - 5;
                                                $end = $currentYear + 5;
                                                function yearOptions($start,$end,$selected){
                                                    $html = '<option value="" disabled '.($selected===''?'selected':'').'>Select Year</option>';
                                                    for($i=$start;$i<=$end;$i++){
                                                        $sel = ((string)$selected === (string)$i) ? 'selected' : '';
                                                        $html .= "<option value=\"$i\" $sel>$i</option>";
                                                    }
                                                    return $html;
                                                }
                                                ?>
                                                <tr>
                                                    <td>January</td>
                                                    <td><select name="year1" id="year1"><?php echo yearOptions($start,$end,oldv('year1')); ?></select></td>
                                                    <td><input type="text" name="customer_1" id="customer_1" value="<?php echo htmlspecialchars(oldv('customer_1')); ?>"></td>
                                                    <td><input type="text" name="existing_sales_1" id="existing_sales_1" value="<?php echo htmlspecialchars(oldv('existing_sales_1')); ?>"></td>
                                                    <td><input type="text" name="exp_sales_1" id="exp_sales_1" value="<?php echo htmlspecialchars(oldv('exp_sales_1')); ?>"></td>
                                                    <td><input type="text" name="bdo_1" id="bdo_1" value="<?php echo htmlspecialchars(oldv('bdo_1')); ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td>February</td>
                                                    <td><select name="year2" id="year2"><?php echo yearOptions($start,$end,oldv('year2')); ?></select></td>
                                                    <td><input type="text" name="customer_2" id="customer_2" value="<?php echo htmlspecialchars(oldv('customer_2')); ?>"></td>
                                                    <td><input type="text" name="existing_sales_2" id="existing_sales_2" value="<?php echo htmlspecialchars(oldv('existing_sales_2')); ?>"></td>
                                                    <td><input type="text" name="exp_sales_2" id="exp_sales_2" value="<?php echo htmlspecialchars(oldv('exp_sales_2')); ?>"></td>
                                                    <td><input type="text" name="bdo_2" id="bdo_2" value="<?php echo htmlspecialchars(oldv('bdo_2')); ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td>March</td>
                                                    <td><select name="year3" id="year3"><?php echo yearOptions($start,$end,oldv('year3')); ?></select></td>
                                                    <td><input type="text" name="customer_3" id="customer_3" value="<?php echo htmlspecialchars(oldv('customer_3')); ?>"></td>
                                                    <td><input type="text" name="existing_sales_3" id="existing_sales_3" value="<?php echo htmlspecialchars(oldv('existing_sales_3')); ?>"></td>
                                                    <td><input type="text" name="exp_sales_3" id="exp_sales_3" value="<?php echo htmlspecialchars(oldv('exp_sales_3')); ?>"></td>
                                                    <td><input type="text" name="bdo_3" id="bdo_3" value="<?php echo htmlspecialchars(oldv('bdo_3')); ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td>April</td>
                                                    <td><select name="year4" id="year4"><?php echo yearOptions($start,$end,oldv('year4')); ?></select></td>
                                                    <td><input type="text" name="customer_4" id="customer_4" value="<?php echo htmlspecialchars(oldv('customer_4')); ?>"></td>
                                                    <td><input type="text" name="existing_sales_4" id="existing_sales_4" value="<?php echo htmlspecialchars(oldv('existing_sales_4')); ?>"></td>
                                                    <td><input type="text" name="exp_sales_4" id="exp_sales_4" value="<?php echo htmlspecialchars(oldv('exp_sales_4')); ?>"></td>
                                                    <td><input type="text" name="bdo_4" id="bdo_4" value="<?php echo htmlspecialchars(oldv('bdo_4')); ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td>May</td>
                                                    <td><select name="year5" id="year5"><?php echo yearOptions($start,$end,oldv('year5')); ?></select></td>
                                                    <td><input type="text" name="customer_5" id="customer_5" value="<?php echo htmlspecialchars(oldv('customer_5')); ?>"></td>
                                                    <td><input type="text" name="existing_sales_5" id="existing_sales_5" value="<?php echo htmlspecialchars(oldv('existing_sales_5')); ?>"></td>
                                                    <td><input type="text" name="exp_sales_5" id="exp_sales_5" value="<?php echo htmlspecialchars(oldv('exp_sales_5')); ?>"></td>
                                                    <td><input type="text" name="bdo_5" id="bdo_5" value="<?php echo htmlspecialchars(oldv('bdo_5')); ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td>June</td>
                                                    <td><select name="year6" id="year6"><?php echo yearOptions($start,$end,oldv('year6')); ?></select></td>
                                                    <td><input type="text" name="customer_6" id="customer_6" value="<?php echo htmlspecialchars(oldv('customer_6')); ?>"></td>
                                                    <td><input type="text" name="existing_sales_6" id="existing_sales_6" value="<?php echo htmlspecialchars(oldv('existing_sales_6')); ?>"></td>
                                                    <td><input type="text" name="exp_sales_6" id="exp_sales_6" value="<?php echo htmlspecialchars(oldv('exp_sales_6')); ?>"></td>
                                                    <td><input type="text" name="bdo_6" id="bdo_6" value="<?php echo htmlspecialchars(oldv('bdo_6')); ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td>July</td>
                                                    <td><select name="year7" id="year7"><?php echo yearOptions($start,$end,oldv('year7')); ?></select></td>
                                                    <td><input type="text" name="customer_7" id="customer_7" value="<?php echo htmlspecialchars(oldv('customer_7')); ?>"></td>
                                                    <td><input type="text" name="existing_sales_7" id="existing_sales_7" value="<?php echo htmlspecialchars(oldv('existing_sales_7')); ?>"></td>
                                                    <td><input type="text" name="exp_sales_7" id="exp_sales_7" value="<?php echo htmlspecialchars(oldv('exp_sales_7')); ?>"></td>
                                                    <td><input type="text" name="bdo_7" id="bdo_7" value="<?php echo htmlspecialchars(oldv('bdo_7')); ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td>August</td>
                                                    <td><select name="year8" id="year8"><?php echo yearOptions($start,$end,oldv('year8')); ?></select></td>
                                                    <td><input type="text" name="customer_8" id="customer_8" value="<?php echo htmlspecialchars(oldv('customer_8')); ?>"></td>
                                                    <td><input type="text" name="existing_sales_8" id="existing_sales_8" value="<?php echo htmlspecialchars(oldv('existing_sales_8')); ?>"></td>
                                                    <td><input type="text" name="exp_sales_8" id="exp_sales_8" value="<?php echo htmlspecialchars(oldv('exp_sales_8')); ?>"></td>
                                                    <td><input type="text" name="bdo_8" id="bdo_8" value="<?php echo htmlspecialchars(oldv('bdo_8')); ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td>September</td>
                                                    <td><select name="year9" id="year9"><?php echo yearOptions($start,$end,oldv('year9')); ?></select></td>
                                                    <td><input type="text" name="customer_9" id="customer_9" value="<?php echo htmlspecialchars(oldv('customer_9')); ?>"></td>
                                                    <td><input type="text" name="existing_sales_9" id="existing_sales_9" value="<?php echo htmlspecialchars(oldv('existing_sales_9')); ?>"></td>
                                                    <td><input type="text" name="exp_sales_9" id="exp_sales_9" value="<?php echo htmlspecialchars(oldv('exp_sales_9')); ?>"></td>
                                                    <td><input type="text" name="bdo_9" id="bdo_9" value="<?php echo htmlspecialchars(oldv('bdo_9')); ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td>October</td>
                                                    <td><select name="year10" id="year10"><?php echo yearOptions($start,$end,oldv('year10')); ?></select></td>
                                                    <td><input type="text" name="customer_10" id="customer_10" value="<?php echo htmlspecialchars(oldv('customer_10')); ?>"></td>
                                                    <td><input type="text" name="existing_sales_10" id="existing_sales_10" value="<?php echo htmlspecialchars(oldv('existing_sales_10')); ?>"></td>
                                                    <td><input type="text" name="exp_sales_10" id="exp_sales_10" value="<?php echo htmlspecialchars(oldv('exp_sales_10')); ?>"></td>
                                                    <td><input type="text" name="bdo_10" id="bdo_10" value="<?php echo htmlspecialchars(oldv('bdo_10')); ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td>November</td>
                                                    <td><select name="year11" id="year11"><?php echo yearOptions($start,$end,oldv('year11')); ?></select></td>
                                                    <td><input type="text" name="customer_11" id="customer_11" value="<?php echo htmlspecialchars(oldv('customer_11')); ?>"></td>
                                                    <td><input type="text" name="existing_sales_11" id="existing_sales_11" value="<?php echo htmlspecialchars(oldv('existing_sales_11')); ?>"></td>
                                                    <td><input type="text" name="exp_sales_11" id="exp_sales_11" value="<?php echo htmlspecialchars(oldv('exp_sales_11')); ?>"></td>
                                                    <td><input type="text" name="bdo_11" id="bdo_11" value="<?php echo htmlspecialchars(oldv('bdo_11')); ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td>December</td>
                                                    <td><select name="year12" id="year12"><?php echo yearOptions($start,$end,oldv('year12')); ?></select></td>
                                                    <td><input type="text" name="customer_12" id="customer_12" value="<?php echo htmlspecialchars(oldv('customer_12')); ?>"></td>
                                                    <td><input type="text" name="existing_sales_12" id="existing_sales_12" value="<?php echo htmlspecialchars(oldv('existing_sales_12')); ?>"></td>
                                                    <td><input type="text" name="exp_sales_12" id="exp_sales_12" value="<?php echo htmlspecialchars(oldv('exp_sales_12')); ?>"></td>
                                                    <td><input type="text" name="bdo_12" id="bdo_12" value="<?php echo htmlspecialchars(oldv('bdo_12')); ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td>Average Sales</td>
                                                    <td><select name="year13" id="year13"><?php echo yearOptions($start,$end,oldv('year13')); ?></select></td>
                                                    <td><input type="text" name="customer_13" id="customer_13" value="<?php echo htmlspecialchars(oldv('customer_13')); ?>"></td>
                                                    <td><input type="text" name="existing_sales_13" id="existing_sales_13" value="<?php echo htmlspecialchars(oldv('existing_sales_13')); ?>"></td>
                                                    <td><input type="text" name="exp_sales_13" id="exp_sales_13" value="<?php echo htmlspecialchars(oldv('exp_sales_13')); ?>"></td>
                                                    <td><input type="text" name="bdo_13" id="bdo_13" value="<?php echo htmlspecialchars(oldv('bdo_13')); ?>"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="text-center mt-4">
                                        <button type="submit" name="submit"  class="btn btn-form px-4">
                                            Submit
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'cdnjs.php' ?>

    <script>
        $(document).ready(function() {
            $('#sidebar').removeClass('active');
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

    <!-- ✅ Keep your checkbox single-select logic, but remove JS alert and show errors via messages -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forBoxes = document.querySelectorAll('.for-checkbox');
            const typeBoxes = document.querySelectorAll('.type-checkbox');

            const replacementBlock = document.getElementById('replacementBlock');
            const salesQBlock = document.getElementById('salesQBlock');
            const salesMonthBlock = document.getElementById('salesMonthBlock');

            // ✅ Date on page load (dd-mm-yyyy)
            const dateInput = document.getElementById("date_of_request");
            if (!dateInput.value) {
                const d = new Date();
                const dd = String(d.getDate()).padStart(2,'0');
                const mm = String(d.getMonth()+1).padStart(2,'0');
                const yyyy = d.getFullYear();
                dateInput.value = `${dd}-${mm}-${yyyy}`;
            }

            // ✅ show/hide sales blocks based on old selection
            function syncSalesBlocks() {
                const selected = document.querySelector('.for-checkbox:checked');
                if (selected && selected.value === 'Sales') {
                    salesQBlock.style.display = 'block';
                    salesMonthBlock.style.display = 'block';
                } else {
                    salesQBlock.style.display = 'none';
                    salesMonthBlock.style.display = 'none';
                }
            }

            // ✅ show/hide replacement block based on old selection
            function syncReplacementBlock() {
                const selected = document.querySelector('.type-checkbox:checked');
                if (selected && selected.value === 'Replacement') {
                    replacementBlock.style.display = 'block';
                } else {
                    replacementBlock.style.display = 'none';
                }
            }

            syncSalesBlocks();
            syncReplacementBlock();

            // Enforce single checkbox for "form_for"
            forBoxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    forBoxes.forEach(x => { if (x !== cb) x.checked = false; });
                    syncSalesBlocks();
                    if (attemptedSubmit) validateFormFor();
                });
            });

            // Enforce single checkbox for "reason_of_request"
            typeBoxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    typeBoxes.forEach(x => { if (x !== cb) x.checked = false; });
                    syncReplacementBlock();
                    if (attemptedSubmit) validateReason();
                    if (attemptedSubmit) validateConditional();
                });
            });

            // =========================
            // ✅ Frontend validation (show after first submit, hide as user fixes)
            // =========================
            let attemptedSubmit = <?php echo (count($errors) > 0) ? 'true' : 'false'; ?>;

            const form = document.getElementById('emailForm');

            function showError(id, msg) {
                const el = document.getElementById(id);
                if (!el) return;
                el.textContent = msg;
                el.style.display = msg ? 'block' : 'none';
            }

            function markInvalid(input, isInvalid) {
                if (!input) return;
                if (isInvalid) input.classList.add('is-invalid-field');
                else input.classList.remove('is-invalid-field');
            }

            function lenBetween(v, min, max) {
                const s = (v || '').trim();
                return s.length >= min && s.length <= max;
            }

            function validateFormFor() {
                const checked = document.querySelectorAll('.for-checkbox:checked');
                if (checked.length !== 1) {
                    showError('err_form_for', 'Please select exactly one option (Head Office OR Sales).');
                    return false;
                }
                showError('err_form_for', '');
                return true;
            }

            function validateReason() {
                const checked = document.querySelectorAll('.type-checkbox:checked');
                if (checked.length !== 1) {
                    showError('err_reason_of_request', 'Please select exactly one option (New Position OR Replacement).');
                    return false;
                }
                showError('err_reason_of_request', '');
                return true;
            }

            function validateTextField(fieldId, errId, label, min=2, max=500) {
                const input = document.getElementById(fieldId);
                const v = (input && input.value) ? input.value.trim() : '';
                if (!v) {
                    showError(errId, `${label} is required.`);
                    markInvalid(input, true);
                    return false;
                }
                if (!lenBetween(v, min, max)) {
                    showError(errId, `${label} must be between ${min} and ${max} characters.`);
                    markInvalid(input, true);
                    return false;
                }
                showError(errId, '');
                markInvalid(input, false);
                return true;
            }

            function validateDate() {
                const input = document.getElementById('date_of_request');
                const v = input.value.trim();
                // dd-mm-yyyy
                const ok = /^(\d{2})-(\d{2})-(\d{4})$/.test(v);
                if (!v) { showError('err_date_of_request', 'Date Of Request is required.'); markInvalid(input,true); return false; }
                if (!ok) { showError('err_date_of_request', 'Date Of Request must be in dd-mm-yyyy format.'); markInvalid(input,true); return false; }
                showError('err_date_of_request', ''); markInvalid(input,false); return true;
            }

            function validateConditional() {
                const checked = document.querySelector('.type-checkbox:checked');
                const reason = checked ? checked.value : '';

                let ok = true;

                if (reason === 'New Position') {
                    ok = validateTextField('required_education','err_required_education','Required Education / Certification') && ok;
                    ok = validateTextField('salary_range','err_salary_range','Salary Range') && ok;
                    ok = validateTextField('job_type','err_job_type','Job Type') && ok;
                    ok = validateTextField('job_responsibilities','err_job_responsibilities','Job Responsibilities') && ok;

                    // clear replacement errors UI
                    showError('err_emp_name',''); showError('err_emp_code',''); showError('err_designation','');
                    markInvalid(document.getElementById('emp_name'), false);
                    markInvalid(document.getElementById('emp_code'), false);
                    markInvalid(document.getElementById('designation'), false);
                }

                if (reason === 'Replacement') {
                    ok = validateTextField('emp_name','err_emp_name','Emp Name') && ok;
                    ok = validateTextField('emp_code','err_emp_code','Emp Code') && ok;
                    ok = validateTextField('designation','err_designation','Designation') && ok;

                    ok = validateTextField('required_education','err_required_education','Required Education / Certification') && ok;
                    ok = validateTextField('salary_range','err_salary_range','Salary Range') && ok;
                    ok = validateTextField('job_type','err_job_type','Job Type') && ok;
                    ok = validateTextField('job_responsibilities','err_job_responsibilities','Job Responsibilities') && ok;
                }

                return ok;
            }

            function validateAll() {
                let ok = true;
                ok = validateFormFor() && ok;
                ok = validateDate() && ok;
                ok = validateTextField('position_title','err_position_title','Position Title') && ok;
                ok = validateTextField('department','err_department','Department') && ok;
                ok = validateTextField('division','err_division','Division') && ok;
                ok = validateTextField('location','err_location','Location') && ok;
                ok = validateReason() && ok;
                ok = validateConditional() && ok;
                return ok;
            }

            // show server-side errors (if any) on load
            if (attemptedSubmit) {
                // display any PHP error that already exists (already in HTML) + show blocks
                const errEls = document.querySelectorAll('.field-error');
                errEls.forEach(el => { if (el.textContent.trim() !== '') el.style.display = 'block'; });
                // mark invalid fields based on those messages (basic)
                ['position_title','department','division','location','date_of_request','required_education','salary_range','job_type','job_responsibilities','emp_name','emp_code','designation']
                    .forEach(id => {
                        const errEl = document.getElementById('err_' + id);
                        const input = document.getElementById(id);
                        if (errEl && errEl.textContent.trim() !== '') markInvalid(input,true);
                    });
            }

            // realtime validation after first submit
            const watchIds = [
                'position_title','department','division','location',
                'required_education','salary_range','job_type','job_responsibilities',
                'emp_name','emp_code','designation'
            ];
            watchIds.forEach(id => {
                const el = document.getElementById(id);
                if (!el) return;
                el.addEventListener('input', function() {
                    if (!attemptedSubmit) return;
                    // validate only this field (and conditional if needed)
                    if (id === 'position_title') validateTextField('position_title','err_position_title','Position Title');
                    if (id === 'department') validateTextField('department','err_department','Department');
                    if (id === 'division') validateTextField('division','err_division','Division');
                    if (id === 'location') validateTextField('location','err_location','Location');

                    if (['required_education','salary_range','job_type','job_responsibilities','emp_name','emp_code','designation'].includes(id)) {
                        validateConditional();
                    }
                });
            });

            form.addEventListener('submit', function(e) {
                attemptedSubmit = true;
                const ok = validateAll();
                if (!ok) {
                    e.preventDefault();
                }
            });

        });
    </script>

    <script src="assets/js/main.js"></script>
</body>

</html>
