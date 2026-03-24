<?php
session_start();
if (!isset($_SESSION['loggedin'])) { header('Location: login.php'); exit; }

include 'dbconfig.php';
date_default_timezone_set("Asia/Karachi");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax']) && $_POST['ajax'] === '1') {
    header('Content-Type: application/json; charset=utf-8');

    $transport_name = trim($_POST['transport_name'] ?? '');
    $status = trim($_POST['status'] ?? '1');

    $ok = true;
    if ($transport_name === '' || mb_strlen($transport_name) > 150) $ok = false;
    if (!in_array($status, ['0','1'], true)) $ok = false;

    if (!$ok) {
        echo json_encode(['ok'=>false,'msg'=>'Please fill all fields correctly.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO transport_guard (transport_name, status) VALUES (?, ?)");
    if (!$stmt) { echo json_encode(['ok'=>false,'msg'=>'Save failed!']); exit; }

    $stmt->bind_param("ss", $transport_name, $status);
    $exec = $stmt->execute();

    if (!$exec) {
        // Duplicate name (unique key)
        if ((int)$conn->errno === 1062) {
            echo json_encode(['ok'=>false,'msg'=>'Transport name already exists!']);
        } else {
            echo json_encode(['ok'=>false,'msg'=>'Save failed!']);
        }
        $stmt->close();
        exit;
    }

    $stmt->close();
    echo json_encode(['ok'=>true,'msg'=>'Transport guard has been added!']);
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
        .bg-menu { background-color: #393E46 !important; }
        .btn-menu { font-size: 12.5px; background-color: #FFB22C !important; padding: 5px 10px; font-weight: 600; border: none !important; }
        body { font-family: 'Poppins', sans-serif; background-color: #f5f6fa; }
        .card { border-radius: 10px; }
        label { font-weight: 500; font-size: 12px; }
        input, select {
            width: 100% !important;
            font-size: 13px;
            border-radius: 0px;
            border: 1px solid grey;
            transition: border-color 0.3s ease;
            padding: 2.5px 5px;
            letter-spacing: 0.4px;
            height: 25px !important;
            color: black !important;
            background: #fff;
        }
        input:focus, select:focus { outline: none; border: 1px solid black; background-color: #FFF4B5; }
        .is-invalid { border: 1.5px solid red !important; background-color: #fff0f0; }
        .labelf { font-size: 13.5px !important; font-weight: 500; }
        .bg-header { background-color: #1f7a8c; }
        .btn-form, .btn-form:hover { background-color: #0e6ba8; border-radius: 20px; color: white; }

        .toast-custom {
            background: #ffffff !important;
            color: #111 !important;
            border: 1px solid #dee2e6 !important;
            border-left-width: 6px !important;
            border-radius: 10px !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }
        .toast-success { border-color: #28a745 !important; border-left-color: #28a745 !important; }
        .toast-error   { border-color: #dc3545 !important; border-left-color: #dc3545 !important; }
        .toast-warning { border-color: #ffc107 !important; border-left-color: #ffc107 !important; }
        .toast-custom .btn-close { filter: none !important; opacity: 0.6; }
        .toast-custom .btn-close:hover { opacity: 1; }
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
                <div class="col-md-8 pt-md-2">

                    <form class="form pb-3" method="POST" autocomplete="off" id="guardForm">
                        <div class="card shadow">
                            <div class="card-header bg-header text-white d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Transport Guard Form</h6>
                                <a href="transport_guard_record_list.php" class="btn btn-light btn-sm">
                                    <i class="fa-solid fa-list"></i> Records
                                </a>
                            </div>

                            <div class="card-body">
                                <div class="row g-3">

                                    <div class="col-md-8">
                                        <label class="form-label labelf">Transport Name</label>
                                        <input type="text" name="transport_name" id="transport_name" maxlength="150" placeholder="Enter transport name">
                                        <small id="nameError" class="text-danger d-none"></small>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label labelf">Status</label>
                                        <select name="status" id="status">
                                            <option value="1" selected>Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                        <small id="statusError" class="text-danger d-none"></small>
                                    </div>

                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-form px-4" id="submitBtn">Submit</button>
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

    const toastEl = document.getElementById("statusToast");
    const toastMsg = document.getElementById("toastMsg");
    function setToastType(type) {
        toastEl.classList.remove("toast-success", "toast-error", "toast-warning");
        if (type) toastEl.classList.add(type);
    }
    function showToast(type, msg){
        toastMsg.textContent = msg;
        setToastType(type);
        new bootstrap.Toast(toastEl, { delay: 2500 }).show();
    }

    const form = document.getElementById("guardForm");
    const submitBtn = document.getElementById("submitBtn");

    const nameEl = document.getElementById("transport_name");
    const statusEl = document.getElementById("status");

    const nameError = document.getElementById("nameError");
    const statusError = document.getElementById("statusError");

    function setError(input, errorElem, msg) {
        input.classList.add("is-invalid");
        errorElem.textContent = msg;
        errorElem.classList.remove("d-none");
    }
    function clearError(input, errorElem) {
        input.classList.remove("is-invalid");
        errorElem.textContent = "";
        errorElem.classList.add("d-none");
    }

    function validateName(){
        const v = nameEl.value.trim();
        if (!v) { setError(nameEl, nameError, "Transport name is required."); return false; }
        if (v.length > 150) { setError(nameEl, nameError, "Max 150 characters."); return false; }
        clearError(nameEl, nameError); return true;
    }

    function validateStatus(){
        const v = statusEl.value.trim();
        if (!(v === "0" || v === "1")) { setError(statusEl, statusError, "Invalid status."); return false; }
        clearError(statusEl, statusError); return true;
    }

    nameEl.addEventListener("input", validateName);
    statusEl.addEventListener("change", validateStatus);

    form.addEventListener("submit", async function(e){
        e.preventDefault();

        const ok = [validateName(), validateStatus()].every(Boolean);
        if (!ok) { if (nameEl.classList.contains("is-invalid")) nameEl.focus(); return; }

        submitBtn.disabled = true;

        try {
            const fd = new FormData(form);
            fd.append("ajax", "1");

            const res = await fetch(window.location.href, { method: "POST", body: fd });
            const data = await res.json();

            if (data.ok) {
                showToast("toast-success", data.msg || "Saved!");
                nameEl.value = "";
                statusEl.value = "1";
                clearError(nameEl, nameError);
                clearError(statusEl, statusError);
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
