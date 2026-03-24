<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

include 'dbconfig.php';
date_default_timezone_set("Asia/Karachi");

$form_user = $_SESSION['fullname'] ?? ($_SESSION['username'] ?? ($_SESSION['email'] ?? 'unknown'));

// ===== AJAX submit handler (no reload) =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax']) && $_POST['ajax'] === '1') {
    header('Content-Type: application/json; charset=utf-8');

    // Date will come from <input type="date"> as YYYY-MM-DD
    $date          = trim($_POST['date'] ?? '');
    $gate_pass_no  = trim($_POST['gate_pass_no'] ?? '');
    $transport_qty = trim($_POST['transport_qty'] ?? '');
    $uniforms_qty  = trim($_POST['uniforms_qty'] ?? '');
    $caps_qty      = trim($_POST['caps_qty'] ?? '');
    $herb_bags_qty = trim($_POST['herb_bags_qty'] ?? '');

    // Basic server-side validation
    $ok = true;

    // Validate date (YYYY-MM-DD)
    $d = DateTime::createFromFormat('Y-m-d', $date);
    if (!$d || $d->format('Y-m-d') !== $date) $ok = false;

    if ($gate_pass_no === '' || strlen($gate_pass_no) > 50) $ok = false;

    // Validate numeric >= 0
    foreach ([$transport_qty, $uniforms_qty, $caps_qty, $herb_bags_qty] as $numv) {
        if ($numv === '' || !is_numeric($numv) || (float)$numv < 0) {
            $ok = false;
            break;
        }
    }

    if ($ok) {
        $stmt = $conn->prepare("
            INSERT INTO laundary_form (`date`, gate_pass_no, transport_qty, uniforms_qty, caps_qty, herb_bags_qty, form_user)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        if ($stmt) {
            $tq = number_format((float)$transport_qty, 2, '.', '');
            $uq = number_format((float)$uniforms_qty, 2, '.', '');
            $cq = number_format((float)$caps_qty, 2, '.', '');
            $hq = number_format((float)$herb_bags_qty, 2, '.', '');

            $stmt->bind_param("ssdddds", $date, $gate_pass_no, $tq, $uq, $cq, $hq, $form_user);
            $exec = $stmt->execute();
            $stmt->close();

            if ($exec) {
                echo json_encode(['ok'=>true,'msg'=>'Form has been submitted!']);
                exit;
            } else {
                echo json_encode(['ok'=>false,'msg'=>'Form submission failed!']);
                exit;
            }
        } else {
            echo json_encode(['ok'=>false,'msg'=>'Form submission failed!']);
            exit;
        }
    } else {
        echo json_encode(['ok'=>false,'msg'=>'Please fill all fields correctly.']);
        exit;
    }
}

// --- For GET render ---
$today_db = date('Y-m-d'); // default for <input type="date">
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
        input:focus { outline: none; border: 1px solid black; background-color: #FFF4B5; }
        textarea { border: 0.5px solid #adb5bd !important; border-radius: 0px !important; }
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

                    <form class="form pb-3" method="POST" autocomplete="off" id="laundaryForm">
                        <div class="card shadow">
                            <div class="card-header bg-header text-white d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Laundary Form</h6>
                                <a href="laundary_home.php" class="btn btn-light btn-sm">
                                    <i class="fa-solid fa-home"></i> Home
                                </a>
                            </div>

                            <div class="card-body">
                                <div class="row g-3">

                                    <div class="col-md-4">
                                        <label class="form-label labelf">Date</label>
                                        <!-- Native calendar, default today -->
                                        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($today_db); ?>">
                                        <small id="dateError" class="text-danger d-none"></small>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label labelf">Gate Pass No.</label>
                                        <input type="text" name="gate_pass_no" id="gate_pass_no" maxlength="50" placeholder="Enter gate pass no">
                                        <small id="gatePassError" class="text-danger d-none"></small>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label labelf">Transport</label>
                                        <input type="text" name="transport_qty" id="transport_qty" placeholder="0.00">
                                        <small id="transportQtyError" class="text-danger d-none"></small>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label labelf">Uniforms Qty</label>
                                        <input type="text" name="uniforms_qty" id="uniforms_qty" placeholder="0.00">
                                        <small id="uniformsQtyError" class="text-danger d-none"></small>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label labelf">Caps Qty</label>
                                        <input type="text" name="caps_qty" id="caps_qty" placeholder="0.00">
                                        <small id="capsQtyError" class="text-danger d-none"></small>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label labelf">Herb Bags Qty</label>
                                        <input type="text" name="herb_bags_qty" id="herb_bags_qty" placeholder="0.00">
                                        <small id="herbBagsQtyError" class="text-danger d-none"></small>
                                    </div>

                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" name="submit" class="btn btn-form px-4" id="submitBtn">Submit</button>
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
    function showToast(type, msg){
        toastMsg.textContent = msg;
        setToastType(type);
        new bootstrap.Toast(toastEl, { delay: 2500 }).show();
    }

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

    // ===== Client-side validation =====
    const form = document.getElementById("laundaryForm");
    const submitBtn = document.getElementById("submitBtn");

    const dateInput    = document.getElementById("date");
    const dateError    = document.getElementById("dateError");

    const gatePassNo   = document.getElementById("gate_pass_no");
    const transportQty = document.getElementById("transport_qty");
    const uniformsQty  = document.getElementById("uniforms_qty");
    const capsQty      = document.getElementById("caps_qty");
    const herbBagsQty  = document.getElementById("herb_bags_qty");

    const gatePassError      = document.getElementById("gatePassError");
    const transportQtyError  = document.getElementById("transportQtyError");
    const uniformsQtyError   = document.getElementById("uniformsQtyError");
    const capsQtyError       = document.getElementById("capsQtyError");
    const herbBagsQtyError   = document.getElementById("herbBagsQtyError");

    function validateDate() {
        const v = dateInput.value.trim(); // expected yyyy-mm-dd
        if (!v) { setError(dateInput, dateError, "Date is required."); return false; }
        if (!/^\d{4}-\d{2}-\d{2}$/.test(v)) { setError(dateInput, dateError, "Invalid date."); return false; }
        clearError(dateInput, dateError); return true;
    }

    function validateGatePass() {
        const v = gatePassNo.value.trim();
        if (!v) { setError(gatePassNo, gatePassError, "Gate Pass No is required."); return false; }
        if (v.length > 50) { setError(gatePassNo, gatePassError, "Max 50 characters."); return false; }
        clearError(gatePassNo, gatePassError); return true;
    }

    function validateNonNegativeNumber(input, errorElem, label) {
        const v = input.value.trim();
        if (!v) { setError(input, errorElem, `${label} is required.`); return false; }
        const num = Number(v);
        if (Number.isNaN(num) || num < 0) { setError(input, errorElem, "Enter a valid non-negative number."); return false; }
        clearError(input, errorElem); return true;
    }

    dateInput.addEventListener("change", validateDate);
    gatePassNo.addEventListener("input", validateGatePass);
    transportQty.addEventListener("input", () => validateNonNegativeNumber(transportQty, transportQtyError, "Transport Qty"));
    uniformsQty.addEventListener("input", () => validateNonNegativeNumber(uniformsQty, uniformsQtyError, "Uniforms Qty"));
    capsQty.addEventListener("input", () => validateNonNegativeNumber(capsQty, capsQtyError, "Caps Qty"));
    herbBagsQty.addEventListener("input", () => validateNonNegativeNumber(herbBagsQty, herbBagsQtyError, "Herb Bags Qty"));

    // ===== AJAX submit (no reload) =====
    form.addEventListener("submit", async function(e) {
        e.preventDefault();

        const ok = [
            validateDate(),
            validateGatePass(),
            validateNonNegativeNumber(transportQty, transportQtyError, "Transport Qty"),
            validateNonNegativeNumber(uniformsQty, uniformsQtyError, "Uniforms Qty"),
            validateNonNegativeNumber(capsQty, capsQtyError, "Caps Qty"),
            validateNonNegativeNumber(herbBagsQty, herbBagsQtyError, "Herb Bags Qty"),
        ].every(Boolean);

        if (!ok) {
            const firstInvalid = form.querySelector(".is-invalid");
            if (firstInvalid) firstInvalid.focus();
            return;
        }

        submitBtn.disabled = true;

        try {
            const fd = new FormData(form);
            fd.append("ajax", "1");

            const res = await fetch(window.location.href, { method: "POST", body: fd });
            const data = await res.json();

            if (data.ok) {
                showToast("toast-success", data.msg || "Form has been submitted!");

                // clear fields after success (keep date)
                gatePassNo.value = "";
                transportQty.value = "";
                uniformsQty.value = "";
                capsQty.value = "";
                herbBagsQty.value = "";

                // clear errors
                [dateInput, gatePassNo, transportQty, uniformsQty, capsQty, herbBagsQty].forEach(x => x.classList.remove("is-invalid"));
                [dateError, gatePassError, transportQtyError, uniformsQtyError, capsQtyError, herbBagsQtyError].forEach(x => x.classList.add("d-none"));

            } else {
                showToast("toast-error", data.msg || "Form submission failed!");
            }
        } catch (err) {
            showToast("toast-error", "Network error!");
        } finally {
            submitBtn.disabled = false;
        }
    });

    // initial
    validateDate();

});
</script>

</body>
</html>
