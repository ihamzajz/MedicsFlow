<?php
/* ============================================================
   FILE: freedom_guard_form.php
   PURPOSE: Create (Add) Freedom Guards (AJAX submit, no reload)
   TABLE: freedom_guards (id, name, duty_location, duty_type, status)
   ============================================================ */
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

include 'dbconfig.php';
date_default_timezone_set("Asia/Karachi");

// ===== AJAX add handler (no reload) =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax']) && $_POST['ajax'] === '1' && ($_POST['action'] ?? '') === 'add') {
    header('Content-Type: application/json; charset=utf-8');

    $name = trim($_POST['name'] ?? '');
    $duty_location = trim($_POST['duty_location'] ?? '');
    $duty_type = trim($_POST['duty_type'] ?? '');
    $status = trim($_POST['status'] ?? '1');
    $status = ($status === '0') ? 0 : 1;

    if ($name === '' || $duty_location === '' || $duty_type === '') {
        echo json_encode(['ok' => false, 'msg' => 'All fields are required.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO freedom_guards (name, duty_location, duty_type, status) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        echo json_encode(['ok' => false, 'msg' => 'Save failed!']);
        exit;
    }

    $stmt->bind_param("sssi", $name, $duty_location, $duty_type, $status);
    $exec = $stmt->execute();
    $stmt->close();

    if ($exec) echo json_encode(['ok' => true, 'msg' => 'Guard added successfully!']);
    else echo json_encode(['ok' => false, 'msg' => 'Save failed!']);
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MedicsFlow</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />

    <?php include 'cdncss.php'; ?>

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

        .bg-header {
            background-color: #1f7a8c;
        }

        label {
            font-weight: 500;
            font-size: 12px;
        }

        input,
        select {
            width: 100% !important;
            font-size: 13px;
            border-radius: 0px;
            border: 1px solid grey;
            transition: border-color 0.3s ease;
            padding: 6px 8px;
            letter-spacing: 0.4px;
            height: 34px !important;
            color: black !important;
        }

        input:focus,
        select:focus {
            outline: none;
            border: 1px solid black;
        }

        .labelf {
            font-size: 13.5px !important;
            font-weight: 500;
        }

        .btn-form,
        .btn-form:hover {
            background-color: #0e6ba8;
            border-radius: 20px;
            color: white;
        }

        /* ===== Toast ===== */
        .toast-custom {
            background: #ffffff !important;
            color: #111 !important;
            border: 1px solid #dee2e6 !important;
            border-left-width: 6px !important;
            border-radius: 10px !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .toast-success {
            border-color: #28a745 !important;
            border-left-color: #28a745 !important;
        }

        .toast-error {
            border-color: #dc3545 !important;
            border-left-color: #dc3545 !important;
        }

        .toast-warning {
            border-color: #ffc107 !important;
            border-left-color: #ffc107 !important;
        }

        .toast-custom .btn-close {
            filter: none !important;
            opacity: 0.6;
        }

        .toast-custom .btn-close:hover {
            opacity: 1;
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
                        <i class="fas fa-align-left"></i> <span>Menu</span>
                    </button>
                </div>
            </nav>

            <div class="container-fluid">
                <div class="row justify-content-center mt-5">
                    <div class="col-md-10 pt-md-2">

                        <form class="form pb-3" method="POST" autocomplete="off" id="guardAddForm">
                            <div class="card shadow">
                                <div class="card-header bg-header text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Add Freedom Guard</h6>
                                    <div class="d-flex gap-2">
                                        <a href="freedom_guard_record_list.php" class="btn btn-info btn-sm">
                                            <i class="fa-solid fa-list"></i> Records
                                        </a>

                                        <a href="freedom_home.php" class="btn btn-light btn-sm">
                                            <i class="fa-solid fa-home"></i> Home
                                        </a>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <!-- Keep 2 fields in 1 line (like you asked) -->
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label labelf">Guard Name</label>
                                            <input type="text" name="name" id="name" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label labelf">Duty Location</label>
                                            <input type="text" name="duty_location" id="duty_location" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label labelf">Duty Type</label>
                                            <select name="duty_type" id="duty_type" required>
                                                <option value="">Select</option>
                                                <option value="Day">Day</option>
                                                <option value="Night">Night</option>
                                                <option value="24Hour">24Hour</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label labelf">Status</label>
                                            <select name="status" id="status" required>
                                                <option value="1" selected>Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-form px-4" id="submitBtn">
                                            <i class="fa-solid fa-floppy-disk me-1"></i> Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- Toast -->
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                <div id="statusToast" class="toast toast-custom align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body" id="toastMsg">...</div>
                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>

            <?php include 'footer.php'; ?>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // ===== Toast helper =====
            const toastEl = document.getElementById("statusToast");
            const toastMsg = document.getElementById("toastMsg");

            function setToastType(type) {
                toastEl.classList.remove("toast-success", "toast-error", "toast-warning");
                if (type) toastEl.classList.add(type);
            }

            function showToast(type, msg) {
                toastMsg.textContent = msg;
                setToastType(type);
                new bootstrap.Toast(toastEl, {
                    delay: 2500
                }).show();
            }

            const form = document.getElementById("guardAddForm");
            const submitBtn = document.getElementById("submitBtn");

            if (!form) return;

            form.addEventListener("submit", async function(e) {
                e.preventDefault();

                submitBtn.disabled = true;

                try {
                    const fd = new FormData(form);
                    fd.append("ajax", "1");
                    fd.append("action", "add");

                    const res = await fetch(window.location.href, {
                        method: "POST",
                        body: fd
                    });
                    const data = await res.json();

                    if (data.ok) {
                        showToast("toast-success", data.msg || "Guard added successfully!");

                        // clear fields (keep status Active by default)
                        document.getElementById("name").value = "";
                        document.getElementById("duty_location").value = "";
                        document.getElementById("duty_type").value = "";
                        document.getElementById("status").value = "1";
                    } else {
                        showToast("toast-error", data.msg || "Save failed!");
                    }
                } catch (err) {
                    showToast("toast-error", "Network error!");
                } finally {
                    submitBtn.disabled = false;
                }
            });

        });
    </script>

</body>

</html>