<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

require 'dbconfig.php';

$head_email = $_SESSION['head_email'] ?? '';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
$mail = new PHPMailer(true);

/* =========================================================
   ✅ AJAX submit endpoint (no page reload)
========================================================= */
function json_response($arr, $code = 200)
{
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($arr);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_submit']) && $_POST['ajax_submit'] === '1') {

    $name = $_SESSION['fullname'] ?? '';

    $product    = trim((string)($_POST['product'] ?? ''));
    $department = trim((string)($_POST['department'] ?? ''));
    $batch_size = trim((string)($_POST['batch_size'] ?? ''));
    $batch_no   = trim((string)($_POST['batch_no'] ?? ''));
    $pack_size  = trim((string)($_POST['pack_size'] ?? ''));
    $process    = trim((string)($_POST['process'] ?? ''));
    $date       = trim((string)($_POST['date'] ?? ''));
    $day        = trim((string)($_POST['day'] ?? ''));

    $sa_depart  = $_SESSION['sa_depart'] ?? '';
    $sa_role    = $_SESSION['sa_role'] ?? '';

    $errors = [];

    // required
    if ($product === '')    $errors['product'] = 'Product is required.';
    if ($department === '') $errors['department'] = 'Department is required.';
    if ($date === '')       $errors['date'] = 'Date is required.';
    if ($day === '')        $errors['day'] = 'Day is required.';

    // required + length (3-100)
    $minLen = 3;
    $maxLen = 100;

    $checkLen = function ($val, $label) use ($minLen, $maxLen) {
        $len = mb_strlen($val);
        if ($val === '') return "$label is required.";
        if ($len < $minLen || $len > $maxLen) return "$label must be between $minLen and $maxLen characters.";
        return null;
    };

    if ($msg = $checkLen($batch_size, 'Batch Size')) $errors['batch_size'] = $msg;
    if ($msg = $checkLen($batch_no, 'Batch No'))     $errors['batch_no'] = $msg;
    if ($msg = $checkLen($pack_size, 'Pack Size'))   $errors['pack_size'] = $msg;
    if ($msg = $checkLen($process, 'Process'))       $errors['process'] = $msg;

    if (!empty($errors)) {
        json_response([
            'ok' => false,
            'message' => 'Please fix the errors and try again.',
            'errors' => $errors
        ], 422);
    }

    $sql = "INSERT INTO staff_allocation
            (product, department, batch_size, batch_no, pack_size, process, incharge, date, day, head_status, fpna_status, complete_status, sa_depart, sa_role)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', 'Pending', 'Pending', ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        json_response(['ok' => false, 'message' => 'Server error: prepare failed.'], 500);
    }

    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssss",
        $product,
        $department,
        $batch_size,
        $batch_no,
        $pack_size,
        $process,
        $name,
        $date,
        $day,
        $sa_depart,
        $sa_role
    );

    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($ok) {
        json_response(['ok' => true, 'message' => 'Batch created successfully.']);
    }

    json_response(['ok' => false, 'message' => 'Form submission failed. Please try again.'], 500);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Staff Allocation - Generate Form</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"
        integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #c7ccdb !important;
        }

        .card {
            border-radius: 10px;
        }

        label {
            font-size: 12px !important;
            font-weight: 600 !important;
            margin-bottom: 5px;
            padding: 0 !important;
        }

        select {
            font-size: 12px;
            width: 100%;
            height: 27px !important;
        }

        input {
            width: 100% !important;
            font-size: 13px;
            border-radius: 0px;
            border: 1px solid grey;
            transition: border-color 0.2s ease;
            padding: 2.5px 5px;
            letter-spacing: 0.4px;
            height: 25px !important;
        }

        .bg-menu {
            background-color: #393E46 !important;
        }

        .btn-menu {
            font-size: 11px !important;
            background-color: #FFB22C !important;
            padding: 5px 10px;
            font-weight: 600;
            border: none !important;
            color: black !important;
            border-radius: 0px !important;
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

        /* ✅ IMPORTANT: hide feedback UNTIL we add .is-invalid */
        .invalid-feedback {
            display: none;
            font-size: 11px;
            margin-top: 4px;
        }

        .is-invalid~.invalid-feedback {
            display: block;
        }

        .toast-container {
            position: fixed;
            top: 14px;
            right: 14px;
            z-index: 9999;
        }
    </style>

    <?php include 'sidebarcss.php'; ?>
</head>

<body>

    <!-- ✅ Toast -->
    <div class="toast-container">
        <div id="liveToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="polite"
            aria-atomic="true">
            <div class="d-flex">
                <div id="toastBody" class="toast-body">Saved.</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

    <div class="wrapper">
        <?php include 'sidebar1.php'; ?>

        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-menu">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </nav>

            <div class="container-fluid">
                <div class="row justify-content-center mt-3">
                    <div class="col-md-10 pt-md-4">

                        <!-- ✅ no was-validated, no auto errors on load -->
                        <form id="batchForm" class="form pb-3" method="POST" novalidate>
                            <div class="card shadow">
                                <div class="card-header bg-header text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Create New Batch</h6>
                                    <a href="sa_home.php" class="btn btn-light btn-sm" style="font-size:12px!important">
                                        <i class="fa-solid fa-home"></i> Home
                                    </a>
                                </div>

                                <div class="card-body">
                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <label class="form-label labelf">Product<span class="text-danger">*</span></label>
                                            <select name="product" class="w-100" required>
                                                <option value="" disabled selected>Please select</option>
                                                <?php
                                                $query = "SELECT DISTINCT product FROM staff_allo_pro";
                                                $result = $conn->query($query);

                                                if ($result && $result->num_rows > 0) {
                                                    while ($r = $result->fetch_assoc()) {
                                                        echo "<option value='" . htmlspecialchars($r['product']) . "'>" . htmlspecialchars($r['product']) . "</option>";
                                                    }
                                                } elseif ($result) {
                                                    echo "<option value='' disabled>No Products Available</option>";
                                                } else {
                                                    echo "<option value='' disabled>Error fetching Products</option>";
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">Product is required.</div>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label labelf">Department<span class="text-danger">*</span></label>
                                            <select name="department" required>
                                                <option value="" disabled selected>Please select</option>
                                                <option value="Packing">Packing</option>
                                                <option value="Printing">Printing</option>
                                            </select>
                                            <div class="invalid-feedback">Department is required.</div>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label labelf">Batch Size<span class="text-danger">*</span></label>
                                            <input type="text" name="batch_size" required minlength="3" maxlength="100">
                                            <div class="invalid-feedback">Batch Size is required (3–100 chars).</div>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label labelf">Batch no<span class="text-danger">*</span></label>
                                            <input type="text" name="batch_no" required minlength="3" maxlength="100">
                                            <div class="invalid-feedback">Batch No is required (3–100 chars).</div>
                                        </div>
                                    </div>

                                    <div class="row mt-md-2">
                                        <div class="col-md-3">
                                            <label class="form-label labelf">Pack Size<span class="text-danger">*</span></label>
                                            <input type="text" name="pack_size" required minlength="3" maxlength="100">
                                            <div class="invalid-feedback">Pack Size is required (3–100 chars).</div>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label labelf">Process<span class="text-danger">*</span></label>
                                            <input type="text" name="process" required minlength="3" maxlength="100">
                                            <div class="invalid-feedback">Process is required (3–100 chars).</div>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label labelf">Date<span class="text-danger">*</span></label>
                                            <input type="date" name="date" required>
                                            <div class="invalid-feedback">Date is required.</div>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label labelf">Day<span class="text-danger">*</span></label>
                                            <select name="day" required>
                                                <option value="" disabled selected>Please select</option>
                                                <option value="Day 1">Day 1</option>
                                                <option value="Day 2">Day 2</option>
                                                <option value="Day 3">Day 3</option>
                                                <option value="Day 4">Day 4</option>
                                                <option value="Day 5">Day 5</option>
                                                <option value="Day 6">Day 6</option>
                                                <option value="Day 7">Day 7</option>
                                            </select>
                                            <div class="invalid-feedback">Day is required.</div>
                                        </div>
                                    </div>

                                    <div class="text-center mt-4">
                                        <button id="submitBtn" type="submit" class="btn btn-form px-4">
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            // Sidebar CLOSED by default
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

    <script>
        // ✅ Toast helper
        function showToast(message, type = 'success') {
            const toastEl = document.getElementById('liveToast');
            const toastBody = document.getElementById('toastBody');

            toastBody.textContent = message;

            toastEl.classList.remove('text-bg-success', 'text-bg-danger');
            toastEl.classList.add(type === 'error' ? 'text-bg-danger' : 'text-bg-success');

            bootstrap.Toast.getOrCreateInstance(toastEl, {
                delay: 2200
            }).show();
        }

        (function() {
            const form = document.getElementById('batchForm');
            const submitBtn = document.getElementById('submitBtn');

            // ✅ ONLY after first submit attempt, we will show/hide live errors
            let submittedOnce = false;

            // custom messages (so browser default tooltip never shows)
            function setCustomMsg(el) {
                const name = el.getAttribute('name');

                if (el.validity.valueMissing) {
                    if (name === 'product') return 'Product is required.';
                    if (name === 'department') return 'Department is required.';
                    if (name === 'batch_size') return 'Batch Size is required.';
                    if (name === 'batch_no') return 'Batch No is required.';
                    if (name === 'pack_size') return 'Pack Size is required.';
                    if (name === 'process') return 'Process is required.';
                    if (name === 'date') return 'Date is required.';
                    if (name === 'day') return 'Day is required.';
                    return 'This field is required.';
                }

                if (el.validity.tooShort || el.validity.tooLong) {
                    return 'Must be between 3 and 100 characters.';
                }

                return '';
            }

            function updateFieldUI(el) {
                const fb = el.parentElement.querySelector('.invalid-feedback');
                const msg = setCustomMsg(el);

                if (!submittedOnce) {
                    // before first submit: do not show any errors
                    el.classList.remove('is-invalid', 'is-valid');
                    if (fb) fb.textContent = fb.dataset.default || fb.textContent;
                    return;
                }

                if (el.checkValidity()) {
                    el.classList.remove('is-invalid');
                    el.classList.add('is-valid');
                } else {
                    el.classList.add('is-invalid');
                    el.classList.remove('is-valid');
                }

                if (fb) {
                    // show specific msg if any
                    if (msg) fb.textContent = msg;
                }
            }

            // store defaults
            form.querySelectorAll('.invalid-feedback').forEach(fb => fb.dataset.default = fb.textContent);

            // live typing: hide errors as user fixes (only after first submit)
            const allFields = form.querySelectorAll('input, select, textarea');
            allFields.forEach(el => {
                const evt = (el.tagName.toLowerCase() === 'select') ? 'change' : 'input';
                el.addEventListener(evt, () => updateFieldUI(el));
                // also on blur
                el.addEventListener('blur', () => updateFieldUI(el));
            });

            function markAllErrors() {
                allFields.forEach(el => updateFieldUI(el));
            }

            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                submittedOnce = true;

                // show all errors at once
                markAllErrors();

                if (!form.checkValidity()) {
                    return; // stop, errors shown under fields
                }

                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Submitting...';

                try {
                    const fd = new FormData(form);
                    fd.append('ajax_submit', '1');

                    const res = await fetch(window.location.href, {
                        method: 'POST',
                        body: fd,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const data = await res.json().catch(() => ({}));

                    if (!res.ok || !data.ok) {
                        // server-side field errors (NOT toast)
                        if (data && data.errors) {
                            Object.keys(data.errors).forEach(name => {
                                const el = form.querySelector(`[name="${CSS.escape(name)}"]`);
                                if (!el) return;

                                el.classList.add('is-invalid');
                                el.classList.remove('is-valid');

                                const fb = el.parentElement.querySelector('.invalid-feedback');
                                if (fb) fb.textContent = data.errors[name];
                            });
                        }
                        showToast(data.message || 'Please fix errors and try again.', 'error');
                        return;
                    }

                    // success toast
                    showToast(data.message || 'Saved successfully.', 'success');

                    // reset form for next entry
                    form.reset();
                    submittedOnce = false;

                    allFields.forEach(el => el.classList.remove('is-valid', 'is-invalid'));
                    form.querySelectorAll('.invalid-feedback').forEach(fb => fb.textContent = fb.dataset.default);

                } catch (err) {
                    showToast('Network/server error. Please try again.', 'error');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Submit';
                }
            });
        })();
    </script>

    <!-- keeping your other scripts (unchanged) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.category-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const groupName = this.name.split('_')[0];
                    checkboxes.forEach(function(cb) {
                        if (cb !== checkbox && cb.name.startsWith(groupName)) cb.checked = false;
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
                        if (cb !== checkbox && cb.name.startsWith(groupName)) cb.checked = false;
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
                        if (cb !== checkbox && cb.name.startsWith(groupName)) cb.checked = false;
                    });
                });
            });
        });
    </script>

    <script src="assets/js/main.js"></script>
</body>

</html>
