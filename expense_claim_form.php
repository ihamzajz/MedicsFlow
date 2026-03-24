<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$head_email = $_SESSION['head_email'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$mail = new PHPMailer(true);

/* =========================
   ✅ VALIDATION (server-side)
========================= */
$errors = [
    'user_name' => '',
    'user_department' => '',
    'user_role' => '',
    'emp_id' => '',
    'user_date' => '',
    'amount' => '',
    'reason_for_claim' => '',
];

function mb_len($s) {
    return function_exists('mb_strlen') ? mb_strlen($s ?? '', 'UTF-8') : strlen($s ?? '');
}
function is_valid_amount($v) {
    $v = trim((string)$v);
    if ($v === '') return false;
    if (stripos($v, 'e') !== false) return false; // block scientific notation
    return (bool)preg_match('/^\d+(\.\d+)?$/', $v);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Expense Claim</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
    <?php include 'cdncss.php'; ?>

    <style>
        .bg-menu { background-color: #393E46 !important; }
        .btn-menu {
            font-size: 12.5px;
            background-color: #FFB22C !important;
            padding: 5px 10px;
            font-weight: 600;
            border: none !important;
        }
        body { font-family: 'Poppins', sans-serif; background-color: #f5f6fa; }
        .card { border-radius: 10px; }
        table th {
            font-size: 12.5px !important;
            border: none !important;
            background-color: #1B7BBC !important;
            color: white !important;
            padding: 6px 5px !important;
        }
        table td { font-size: 12px; color: black; padding: 0px !important; }
        input {
            width: 100% !important;
            font-size: 13px;
            border-radius: 0px;
            border: 1px solid grey;
            transition: border-color 0.3s ease;
            padding: 2.5px 5px;
            letter-spacing: 0.4px;
            height: 25px !important;
            background-color: white;
        }
        input:focus { outline: none; border: 1px solid black; background-color: #FFF4B5; }
        .labelp {
            padding: 0px !important;
            margin: 0px !important;
            font-size: 12.5px !important;
            font-weight: 600 !important;
            padding-bottom: 5px !important;
        }
        .bg-header { background-color: #1f7a8c; }
        .btn-form, .btn-form:hover {
            background-color: #0e6ba8;
            border-radius: 20px;
            color: white;
        }

        /* ✅ validation message */
        .field-error {
            font-size: 11.5px;
            margin-top: 4px;
            color: #dc3545;
            font-weight: 600;
        }

        /* ✅ toast */
        .toast-wrap { position: fixed; top: 18px; right: 18px; z-index: 10000; }
        .toastx {
            min-width: 280px;
            max-width: 420px;
            background: #111;
            color: #fff;
            border-radius: 10px;
            padding: 12px 14px;
            box-shadow: 0 10px 25px rgba(0,0,0,.25);
            display: none;
            align-items: flex-start;
            gap: 10px;
        }
        .toastx.show { display: flex; animation: toastIn .18s ease-out; }
        .toastx .ticon { font-size: 18px; line-height: 1; margin-top: 1px; }
        .toastx .ttext { font-size: 13px; line-height: 1.35; }
        .toastx .tclose {
            margin-left: auto;
            background: transparent;
            border: 0;
            color: rgba(255,255,255,.8);
            font-size: 18px;
            line-height: 1;
            cursor: pointer;
        }
        @keyframes toastIn { from { transform: translateY(-6px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    </style>

    <?php include 'sidebarcss.php'; ?>
</head>

<body>
    <!-- ✅ Toast container -->
    <div class="toast-wrap">
        <div id="toastx" class="toastx" role="status" aria-live="polite">
            <div class="ticon" id="toastIcon">✅</div>
            <div class="ttext" id="toastText">Done</div>
            <button type="button" class="tclose" aria-label="Close" onclick="hideToast()">×</button>
        </div>
    </div>

    <div class="wrapper">
        <?php include 'sidebar1.php'; ?>

        <div id="content">
            <nav class="navbar navbar-expand-lg bg-menu">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn-menu">
                        <i class="fas fa-align-left"></i> <span>Menu</span>
                    </button>
                </div>
            </nav>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 pt-md-2">

                        <form id="expenseForm" class="form px-5 py-3 mt-3" method="POST" action="" novalidate>
                            <div class="card shadow">
                                <div class="card-header bg-header text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Expense Claim Form</h6>
                                    <a href="expense_claim_home.php" class="btn btn-light btn-sm" style="font-size:11.5px!important;font-weight:500">
                                        <i class="fa-solid fa-home"></i> Home
                                    </a>
                                </div>

                                <div class="card-body">

                                    <div class="row mb-2 mt-3">
                                        <div class="col-md-4">
                                            <p class="labelp">Name<span class="text-danger">*</span></p>
                                            <input type="text" name="user_name" id="user_name"
                                                value="<?php echo htmlspecialchars($_POST['user_name'] ?? ($fname ?? '')); ?>">
                                            <div class="field-error" id="err_user_name"><?php echo $errors['user_name']; ?></div>
                                        </div>

                                        <div class="col-md-4">
                                            <p class="labelp">Department<span class="text-danger">*</span></p>
                                            <input type="text" name="user_department" id="user_department"
                                                value="<?php echo htmlspecialchars($_POST['user_department'] ?? ($department ?? '')); ?>">
                                            <div class="field-error" id="err_user_department"><?php echo $errors['user_department']; ?></div>
                                        </div>

                                        <div class="col-md-4">
                                            <p class="labelp">Designation<span class="text-danger">*</span></p>
                                            <input type="text" name="user_role" id="user_role"
                                                value="<?php echo htmlspecialchars($_POST['user_role'] ?? ($role ?? '')); ?>">
                                            <div class="field-error" id="err_user_role"><?php echo $errors['user_role']; ?></div>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-md-4">
                                            <p class="labelp">Emp #<span class="text-danger">*</span></p>

                                            <!-- ✅ Restrict typing to digits only + mobile numeric keypad -->
                                            <input type="text" name="emp_id" id="emp_id"
                                                inputmode="numeric" autocomplete="off"
                                                pattern="\d{3,10}"
                                                value="<?php echo htmlspecialchars($_POST['emp_id'] ?? ''); ?>">

                                            <div class="field-error" id="err_emp_id"><?php echo $errors['emp_id']; ?></div>
                                        </div>

                                        <div class="col-md-4">
                                            <p class="labelp">Date<span class="text-danger">*</span></p>
                                            <input type="date" name="user_date" id="user_date"
                                                value="<?php echo htmlspecialchars($_POST['user_date'] ?? date('Y-m-d')); ?>">
                                            <div class="field-error" id="err_user_date"><?php echo $errors['user_date']; ?></div>
                                        </div>

                                        <div class="col-md-4">
                                            <p class="labelp">Amount<span class="text-danger">*</span></p>
                                            <input type="number" name="amount" id="amount" inputmode="decimal" step="any"
                                                value="<?php echo htmlspecialchars($_POST['amount'] ?? ''); ?>">
                                            <div class="field-error" id="err_amount"><?php echo $errors['amount']; ?></div>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <p class="labelp">Reason For Claim<span class="text-danger">*</span></p>
                                            <input type="text" name="reason_for_claim" id="reason_for_claim"
                                                value="<?php echo htmlspecialchars($_POST['reason_for_claim'] ?? ''); ?>">
                                            <div class="field-error" id="err_reason_for_claim"><?php echo $errors['reason_for_claim']; ?></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <p class="labelp">Any Remarks (Optional)</p>
                                            <input type="text" name="amount_breakup" id="amount_breakup"
                                                value="<?php echo htmlspecialchars($_POST['amount_breakup'] ?? ''); ?>">
                                        </div>
                                    </div>

                                    <div class="text-center mt-3">
                                        <button type="submit" name="submit" class="btn btn-form px-4">
                                            Submit
                                        </button>
                                        <p style="font-size:14px" class="pt-2">(Evidence Upload Option will appear after saving information)</p>
                                    </div>

                                </div>
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

                            $user_name_raw = trim((string)($_POST['user_name'] ?? ''));
                            $user_department_raw = trim((string)($_POST['user_department'] ?? ''));
                            $user_role_raw = trim((string)($_POST['user_role'] ?? ''));
                            $emp_id_raw = trim((string)($_POST['emp_id'] ?? ''));
                            $user_date_raw = trim((string)($_POST['user_date'] ?? ''));
                            $amount_raw = trim((string)($_POST['amount'] ?? ''));
                            $reason_raw = trim((string)($_POST['reason_for_claim'] ?? ''));
                            $remarks_raw = trim((string)($_POST['amount_breakup'] ?? ''));

                            $hasError = false;

                            if ($emp_id_raw === '') { $errors['emp_id'] = 'Emp # is required.'; $hasError = true; }
                            elseif (!preg_match('/^\d{3,10}$/', $emp_id_raw)) { $errors['emp_id'] = 'Emp # must be 3 to 10 digits (numbers only).'; $hasError = true; }

                            if ($amount_raw === '') { $errors['amount'] = 'Amount is required.'; $hasError = true; }
                            elseif (!is_valid_amount($amount_raw)) { $errors['amount'] = 'Amount must be a valid number (E/e not allowed).'; $hasError = true; }

                            if ($user_name_raw === '') { $errors['user_name'] = 'Name is required.'; $hasError = true; }
                            elseif (mb_len($user_name_raw) < 7 || mb_len($user_name_raw) > 500) { $errors['user_name'] = 'Name must be between 7 and 500 characters.'; $hasError = true; }

                            if ($user_department_raw === '') { $errors['user_department'] = 'Department is required.'; $hasError = true; }
                            elseif (mb_len($user_department_raw) < 7 || mb_len($user_department_raw) > 500) { $errors['user_department'] = 'Department must be between 7 and 500 characters.'; $hasError = true; }

                            if ($user_role_raw === '') { $errors['user_role'] = 'Designation is required.'; $hasError = true; }
                            elseif (mb_len($user_role_raw) < 7 || mb_len($user_role_raw) > 500) { $errors['user_role'] = 'Designation must be between 7 and 500 characters.'; $hasError = true; }

                            if ($user_date_raw === '') { $errors['user_date'] = 'Date is required.'; $hasError = true; }

                            // ✅ reason now 5 to 1000
                            if ($reason_raw === '') { $errors['reason_for_claim'] = 'Reason for claim is required.'; $hasError = true; }
                            elseif (mb_len($reason_raw) < 5 || mb_len($reason_raw) > 1000) { $errors['reason_for_claim'] = 'Reason must be between 5 and 1000 characters.'; $hasError = true; }

                            if (!$hasError) {

                                $user_name = mysqli_real_escape_string($conn, $user_name_raw);
                                $user_department = mysqli_real_escape_string($conn, $user_department_raw);
                                $user_role = mysqli_real_escape_string($conn, $user_role_raw);
                                $emp_id = mysqli_real_escape_string($conn, $emp_id_raw);
                                $user_date = mysqli_real_escape_string($conn, $user_date_raw);
                                $amount = mysqli_real_escape_string($conn, $amount_raw);
                                $reason_for_claim = mysqli_real_escape_string($conn, $reason_raw);
                                $amount_breakup = mysqli_real_escape_string($conn, $remarks_raw);
                                $evidence = mysqli_real_escape_string($conn, $_POST['evidence'] ?? '');
                                $evidence_numbers = mysqli_real_escape_string($conn, $_POST['evidence_numbers'] ?? '');

                                $insert = "INSERT INTO expense_claim 
                                    (user_name, user_department, user_role, emp_id, user_date,date, amount, reason_for_claim, amount_breakup,admin_status,finance_status,status) 
                                    VALUES 
                                    ('$user_name','$user_department','$user_role','$emp_id','$user_date','$date','$amount','$reason_for_claim','$amount_breakup','Pending','Pending','Open')";

                                $insert_q = mysqli_query($conn, $insert);

                                if ($insert_q) {
                                    $new_id = mysqli_insert_id($conn);

                                    echo '
                                    <div id="loadingMsg" style="
                                        position:fixed;top:0;left:0;width:100%;height:100%;
                                        display:flex;align-items:center;justify-content:center;
                                        background:rgba(0,0,0,0.6);
                                        color:white;font-size:22px;z-index:9999;flex-direction:column;">
                                        <div style="padding:20px;background:#222;border-radius:10px;">
                                            <p>📨 Please wait, your request is being processed...</p>
                                            <p>Email is sending, this may take a few seconds.</p>
                                        </div>
                                    </div>';
                                    ob_flush(); flush();

                                    try {
                                        $mail = new PHPMailer(true);
                                        $mail->isSMTP();
                                        $mail->Host = 'smtp.office365.com';
                                        $mail->SMTPAuth = true;
                                        $mail->Username = 'info@medicslab.com';
                                        $mail->Password = 'kcmzrskfgmwzzshz';
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                        $mail->Port = 587;

                                        $subject = "Expense Claim Form Submitted";
                                        $bodyTemplate = function ($user, $department) {
                                            return "
                                                <p>Dear {$department} Department,</p>
                                                <p>A new Expense Claim has been submitted by <strong>{$user}</strong>.</p>
                                                <p>Kindly review and process the request in MedicsFlow.</p>
                                                <br>
                                                <p>Thanks,<br>MedicsFlow</p>
                                            ";
                                        };

                                        $mail->setFrom('info@medicslab.com', 'Medics Digital Form');
                                        $mail->addAddress('syed.owais@medicslab.com', 'Finance Department');
                                        $mail->isHTML(true);
                                        $mail->Subject = $subject;
                                        $mail->Body = $bodyTemplate($name, 'Finance');
                                        $mail->send();

                                        $mail->clearAddresses();
                                        $mail->addAddress('jawwad.ali@medicslab.com', 'Admin Department');
                                        $mail->Subject = $subject;
                                        $mail->Body = $bodyTemplate($name, 'Admin');
                                        $mail->send();

                                        echo '
                                        <script>
                                            (function(){
                                                var loading = document.getElementById("loadingMsg");
                                                if (loading) loading.remove();
                                                showToast("✅", "Expense Claim submitted successfully and emails sent!", 1400);
                                                setTimeout(function(){
                                                    window.location.href = "expense_claim_form_evidence_upload.php?id=' . $new_id . '";
                                                }, 900);
                                            })();
                                        </script>';

                                    } catch (Exception $e) {
                                        echo '
                                        <script>
                                            (function(){
                                                var loading = document.getElementById("loadingMsg");
                                                if (loading) loading.remove();
                                                showToast("⚠️", "Form saved but email failed to send. Please contact IT.", 2000);
                                                setTimeout(function(){
                                                    window.location.href = "expense_claim_form_evidence_upload.php?id=' . $new_id . '";
                                                }, 1100);
                                            })();
                                        </script>';
                                        error_log("Mailer Error: " . $mail->ErrorInfo);
                                    }

                                    exit;
                                } else {
                                    echo '<script>showToast("❌","Form submission failed!",2000);</script>';
                                }
                            }
                        }
                        ?>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php include 'cdnjs.php'; ?>

    <script>
        // ✅ Toast
        function showToast(icon, msg, ms) {
            var t = document.getElementById("toastx");
            var ti = document.getElementById("toastIcon");
            var tt = document.getElementById("toastText");
            if (!t || !ti || !tt) return;
            ti.textContent = icon || "✅";
            tt.textContent = msg || "";
            t.classList.add("show");
            window.clearTimeout(window.__toastTimer);
            window.__toastTimer = setTimeout(function(){ t.classList.remove("show"); }, ms || 1800);
        }
        function hideToast() {
            var t = document.getElementById("toastx");
            if (t) t.classList.remove("show");
        }

        // ✅ Sidebar (unchanged)
        $(document).ready(function() {
            $('#sidebar').removeClass('active');
            $('#sidebarCollapse').on('click', function() { $('#sidebar').toggleClass('active'); });
            $('[data-bs-toggle="collapse"]').on('click', function() {
                var target = $(this).find('.toggle-icon');
                if ($(this).attr('aria-expanded') === 'true') target.removeClass('fa-plus').addClass('fa-minus');
                else target.removeClass('fa-minus').addClass('fa-plus');
            });
        });

        // ✅ Stop "e/E" + +/- in amount
        document.addEventListener('DOMContentLoaded', function() {
            var amount = document.getElementById('amount');
            if (amount) {
                amount.addEventListener('keydown', function(e) {
                    if (e.key === 'e' || e.key === 'E' || e.key === '+' || e.key === '-') e.preventDefault();
                });
                amount.addEventListener('input', function() {
                    if (this.value && /e/i.test(this.value)) this.value = this.value.replace(/e/ig, '');
                });
            }
        });

        // ✅ Emp ID: block non-digits LIVE + prevent paste non-digits
        document.addEventListener('DOMContentLoaded', function() {
            var emp = document.getElementById('emp_id');
            if (!emp) return;

            emp.addEventListener('keydown', function(e) {
                // allow control keys
                var allowed = ['Backspace','Delete','Tab','Escape','Enter','ArrowLeft','ArrowRight','Home','End'];
                if (allowed.indexOf(e.key) !== -1) return;

                // allow Ctrl/Command combos (copy/paste/select all)
                if ((e.ctrlKey || e.metaKey) && ['a','c','v','x'].indexOf(e.key.toLowerCase()) !== -1) return;

                // block non-digits
                if (!/^\d$/.test(e.key)) e.preventDefault();
            });

            emp.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '');
            });

            emp.addEventListener('paste', function(e) {
                e.preventDefault();
                var text = (e.clipboardData || window.clipboardData).getData('text') || '';
                text = text.replace(/\D/g, '');
                document.execCommand('insertText', false, text);
            });
        });

        // ✅ Client-side validation + LIVE clearing of errors
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('expenseForm');
            if (!form) return;

            function setErr(id, msg) {
                var el = document.getElementById(id);
                if (el) el.textContent = msg || '';
            }
            function len(v){ return (v || '').trim().length; }

            function validateField(fieldId) {
                var v, ok = true;

                if (fieldId === 'user_name') {
                    v = document.getElementById('user_name').value.trim();
                    if (!v) { setErr('err_user_name','Name is required.'); ok = false; }
                    else if (len(v) < 7 || len(v) > 500) { setErr('err_user_name','Name must be between 7 and 500 characters.'); ok = false; }
                    else setErr('err_user_name','');
                }

                if (fieldId === 'user_department') {
                    v = document.getElementById('user_department').value.trim();
                    if (!v) { setErr('err_user_department','Department is required.'); ok = false; }
                    else if (len(v) < 7 || len(v) > 500) { setErr('err_user_department','Department must be between 7 and 500 characters.'); ok = false; }
                    else setErr('err_user_department','');
                }

                if (fieldId === 'user_role') {
                    v = document.getElementById('user_role').value.trim();
                    if (!v) { setErr('err_user_role','Designation is required.'); ok = false; }
                    else if (len(v) < 7 || len(v) > 500) { setErr('err_user_role','Designation must be between 7 and 500 characters.'); ok = false; }
                    else setErr('err_user_role','');
                }

                if (fieldId === 'emp_id') {
                    v = document.getElementById('emp_id').value.trim();
                    if (!v) { setErr('err_emp_id','Emp # is required.'); ok = false; }
                    else if (!/^\d{3,10}$/.test(v)) { setErr('err_emp_id','Emp # must be 3 to 10 digits (numbers only).'); ok = false; }
                    else setErr('err_emp_id','');
                }

                if (fieldId === 'user_date') {
                    v = document.getElementById('user_date').value.trim();
                    if (!v) { setErr('err_user_date','Date is required.'); ok = false; }
                    else setErr('err_user_date','');
                }

                if (fieldId === 'amount') {
                    v = document.getElementById('amount').value.trim();
                    if (!v) { setErr('err_amount','Amount is required.'); ok = false; }
                    else if (/e/i.test(v)) { setErr('err_amount','Amount must be a valid number (E/e not allowed).'); ok = false; }
                    else if (!/^\d+(\.\d+)?$/.test(v)) { setErr('err_amount','Amount must be a valid number.'); ok = false; }
                    else setErr('err_amount','');
                }

                if (fieldId === 'reason_for_claim') {
                    v = document.getElementById('reason_for_claim').value.trim();
                    if (!v) { setErr('err_reason_for_claim','Reason for claim is required.'); ok = false; }
                    else if (len(v) < 5 || len(v) > 1000) { setErr('err_reason_for_claim','Reason must be between 5 and 1000 characters.'); ok = false; }
                    else setErr('err_reason_for_claim','');
                }

                return ok;
            }

            // ✅ LIVE error removal (on input/change)
            var liveFields = ['user_name','user_department','user_role','emp_id','user_date','amount','reason_for_claim'];
            liveFields.forEach(function(id){
                var el = document.getElementById(id);
                if (!el) return;
                el.addEventListener('input', function(){ validateField(id); });
                el.addEventListener('change', function(){ validateField(id); });
                el.addEventListener('blur', function(){ validateField(id); });
            });

            // ✅ validate on submit
            form.addEventListener('submit', function(e) {
                var okAll = true;
                liveFields.forEach(function(id){
                    if (!validateField(id)) okAll = false;
                });

                if (!okAll) {
                    e.preventDefault();
                    showToast("⚠️", "Please fix the highlighted errors.", 1600);
                }
            });
        });
    </script>

    <script src="assets/js/main.js"></script>
</body>
</html>
