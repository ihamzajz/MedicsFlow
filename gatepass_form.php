<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

include 'dbconfig.php';
date_default_timezone_set("Asia/Karachi");

function h($v)
{
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}
function isValidDateYmd($d): bool
{
    if (!$d) return false;
    $dt = DateTime::createFromFormat('Y-m-d', $d);
    return $dt && $dt->format('Y-m-d') === $d;
}

$form_user = $_SESSION['fullname'] ?? ($_SESSION['username'] ?? ($_SESSION['email'] ?? 'unknown'));

// ===== AJAX submit handler (no reload) =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax']) && $_POST['ajax'] === '1') {
    header('Content-Type: application/json; charset=utf-8');

    $date         = trim($_POST['date'] ?? '');
    $gate_pass    = trim($_POST['gate_pass'] ?? '');
    $returnable   = trim($_POST['returnable'] ?? 'N'); // Y / N
    $purpose_for  = trim($_POST['purpose_for'] ?? '');
    $detail       = trim($_POST['detail'] ?? '');
    $quantity     = trim($_POST['quantity'] ?? '0');
    $move_from    = trim($_POST['move_from'] ?? '');
    $move_to      = trim($_POST['move_to'] ?? '');
    $status       = trim($_POST['status'] ?? 'Open');  // Open / Close
    $date_close   = trim($_POST['date_of_close'] ?? '');
    $c_o          = trim($_POST['c_o'] ?? '');

    // Prepare By ALWAYS from session (ignore user input)
    $prepare_by = $form_user;

    // ---- Validate (collect all errors) ----
    $errors = [];

    if (!isValidDateYmd($date)) $errors[] = "Date is invalid.";

    if ($gate_pass === '' || strlen($gate_pass) > 100) $errors[] = "Gate Pass is required (max 100 chars).";

    if (!in_array($returnable, ['Y', 'N'], true)) $errors[] = "Returnable must be Yes/No.";

    if ($purpose_for === '' || strlen($purpose_for) > 150) $errors[] = "Purpose for is required (max 150 chars).";

    if (strlen($detail) > 255) $errors[] = "Detail max 255 characters.";

    if ($quantity === '' || !is_numeric($quantity) || (float)$quantity < 0) $errors[] = "Quantity must be a valid number (>= 0).";

    if ($move_from === '' || strlen($move_from) > 120) $errors[] = "Move from is required (max 120 chars).";

    if ($move_to === '' || strlen($move_to) > 120) $errors[] = "Move to is required (max 120 chars).";

    if ($prepare_by === '' || strlen($prepare_by) > 120) $errors[] = "Prepare by is required.";

    if (!in_array($status, ['Open', 'Close'], true)) $errors[] = "Status must be Open/Close.";

    if ($status === 'Close') {
        if (!isValidDateYmd($date_close)) $errors[] = "Date of close is required (and must be valid) when status is Close.";
    } else {
        $date_close = null;
    }

    if (strlen($c_o) > 120) $errors[] = "C/O max 120 characters.";

    if (!empty($errors)) {
        echo json_encode(['ok' => false, 'msg' => implode(" ", $errors)]);
        exit;
    }

    $qty2 = number_format((float)$quantity, 2, '.', '');

    $stmt = $conn->prepare("
        INSERT INTO gatepass_form
        (`date`,`gate_pass`,`returnable`,`purpose_for`,`detail`,`quantity`,`move_from`,`move_to`,`prepare_by`,`status`,`date_of_close`,`c_o`)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?)
    ");
    if (!$stmt) {
        echo json_encode(['ok' => false, 'msg' => 'DB error']);
        exit;
    }

    $stmt->bind_param(
        "sssssdssssss",
        $date,
        $gate_pass,
        $returnable,
        $purpose_for,
        $detail,
        $qty2,
        $move_from,
        $move_to,
        $prepare_by,
        $status,
        $date_close,
        $c_o
    );

    $ok = $stmt->execute();
    $stmt->close();

    echo json_encode(
        $ok
            ? ['ok' => true, 'msg' => 'Form submitted successfully!']
            : ['ok' => false, 'msg' => 'Form submission failed!']
    );
    exit;
}

$today_db = date('Y-m-d');
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
    <?php include 'sidebarcss.php'; ?>

    <!-- Flatpickr for dd-mm-yyyy display -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
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

        label {
            font-weight: 500;
            font-size: 12px;
        }

        input,
        select,
        input[type="date"] {
            width: 100% !important;
            font-size: 13px;
            border-radius: 0px;
            border: 1px solid grey;
            padding: 2.5px 5px;
            height: 25px !important;
            color: black !important;
        }

        select {
            padding: 1px 5px;
        }

        input:focus,
        select:focus {
            outline: none;
            border: 1px solid black;
        }

        .is-invalid {
            border: 1.5px solid red !important;
            background-color: #fff0f0;
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
    </style>
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

                        <form class="form pb-3" method="POST" autocomplete="off" id="gatepassForm">
                            <div class="card shadow">
                                <div class="card-header bg-header text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Gatepass Form</h6>
                                    <a href="gatepass_home.php" class="btn btn-light btn-sm">
                                        <i class="fa-solid fa-home"></i> Home
                                    </a>
                                </div>

                                <div class="card-body">

                                    <!-- Row 1 -->
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label labelf">Date</label>
                                            <!-- visible dd-mm-yyyy via flatpickr altInput, value saved Y-m-d -->
                                            <input type="text" id="date" name="date" value="<?php echo h($today_db); ?>">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label labelf">Gate Pass</label>
                                            <input type="text" id="gate_pass" name="gate_pass" placeholder="Enter gate pass no">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label labelf">Returnable (Y/N)</label>
                                            <select id="returnable" name="returnable">
                                                <option value="Y">Yes</option>
                                                <option value="N" selected>No</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Row 2 -->
                                    <div class="row g-3 mt-1">
                                        <div class="col-md-4">
                                            <label class="form-label labelf">Purpose for</label>
                                            <input type="text" id="purpose_for" name="purpose_for" placeholder="Purpose">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label labelf">Detail</label>
                                            <input type="text" id="detail" name="detail" placeholder="Detail (optional)">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label labelf">Quantity</label>
                                            <input type="text" id="quantity" name="quantity" value="0">
                                        </div>
                                    </div>

                                    <!-- Row 3 -->
                                    <div class="row g-3 mt-1">
                                        <div class="col-md-4">
                                            <label class="form-label labelf">Move from</label>
                                            <input type="text" id="move_from" name="move_from" placeholder="Move from">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label labelf">Move to</label>
                                            <input type="text" id="move_to" name="move_to" placeholder="Move to">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label labelf">Prepare by</label>
                                            <input type="text" id="prepare_by" name="prepare_by" value="<?php echo h($form_user); ?>" readonly>
                                        </div>
                                    </div>

                                    <!-- Row 4 -->
                                    <div class="row g-3 mt-1">
                                        <div class="col-md-4">
                                            <label class="form-label labelf">Status</label>
                                            <select id="status" name="status">
                                                <option value="Open" selected>Open</option>
                                                <option value="Close">Close</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label labelf">Date of close</label>
                                            <!-- empty by default; enabled only when status=Close -->
                                            <input type="text" id="date_of_close" name="date_of_close" value="" disabled>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label labelf">C/O</label>
                                            <input type="text" id="c_o" name="c_o" placeholder="C/O (optional)">
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

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById("gatepassForm");

            const date = document.getElementById("date");
            const gate_pass = document.getElementById("gate_pass");
            const returnable = document.getElementById("returnable");
            const purpose_for = document.getElementById("purpose_for");
            const detail = document.getElementById("detail");
            const quantity = document.getElementById("quantity");
            const move_from = document.getElementById("move_from");
            const move_to = document.getElementById("move_to");
            const prepare_by = document.getElementById("prepare_by");
            const status = document.getElementById("status");
            const date_of_close = document.getElementById("date_of_close");
            const c_o = document.getElementById("c_o");

            const submitBtn = document.getElementById("submitBtn");
            const toastEl = document.getElementById("statusToast");
            const toastMsg = document.getElementById("toastMsg");

            function setToast(type, msg) {
                toastEl.classList.remove("toast-success", "toast-error", "toast-warning");
                toastEl.classList.add(type);
                toastMsg.textContent = msg;
                new bootstrap.Toast(toastEl, {
                    delay: 3000
                }).show();
            }

            function clearInvalid() {
                [date, gate_pass, purpose_for, detail, quantity, move_from, move_to, prepare_by, date_of_close, c_o, status, returnable]
                .forEach(i => i.classList.remove("is-invalid"));
            }

            function toNum(v) {
                const n = Number(String(v).trim());
                return Number.isFinite(n) ? n : NaN;
            }

            // Date picker #1 (default today). Shows dd-mm-yyyy but submits Y-m-d
            flatpickr(date, {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d-m-Y",
                allowInput: false,
                defaultDate: date.value || null
            });

            // Date picker #2 (empty by default). Shows dd-mm-yyyy but submits Y-m-d
            const closePicker = flatpickr(date_of_close, {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d-m-Y",
                allowInput: false,
                defaultDate: null
            });

            function syncCloseEnabled() {
                const isClose = (status.value === "Close");

                date_of_close.disabled = !isClose;

                // altInput is the visible input - also disable/enable it
                if (date_of_close._flatpickr && date_of_close._flatpickr.altInput) {
                    date_of_close._flatpickr.altInput.disabled = !isClose;
                }

                if (!isClose) {
                    closePicker.clear();
                    date_of_close.classList.remove("is-invalid");
                    if (date_of_close._flatpickr && date_of_close._flatpickr.altInput) {
                        date_of_close._flatpickr.altInput.classList.remove("is-invalid");
                    }
                }
            }
            status.addEventListener("change", syncCloseEnabled);
            syncCloseEnabled();

            // Show ALL errors at once
            form.addEventListener("submit", async (e) => {
                e.preventDefault();
                clearInvalid();

                const errors = [];

                if (!date.value) {
                    date.classList.add("is-invalid");
                    errors.push("Date is required.");
                }

                if (!gate_pass.value.trim()) {
                    gate_pass.classList.add("is-invalid");
                    errors.push("Gate Pass is required.");
                }

                if (!["Y", "N"].includes(returnable.value)) {
                    returnable.classList.add("is-invalid");
                    errors.push("Returnable must be Yes/No.");
                }

                if (!purpose_for.value.trim()) {
                    purpose_for.classList.add("is-invalid");
                    errors.push("Purpose for is required.");
                }

                if (!move_from.value.trim()) {
                    move_from.classList.add("is-invalid");
                    errors.push("Move from is required.");
                }

                if (!move_to.value.trim()) {
                    move_to.classList.add("is-invalid");
                    errors.push("Move to is required.");
                }

                if (!prepare_by.value.trim()) {
                    prepare_by.classList.add("is-invalid");
                    errors.push("Prepare by is required.");
                }

                const q = toNum(quantity.value || "0");
                if (!Number.isFinite(q) || q < 0) {
                    quantity.classList.add("is-invalid");
                    errors.push("Quantity must be a valid number (>= 0).");
                }

                if ((detail.value || "").length > 255) {
                    detail.classList.add("is-invalid");
                    errors.push("Detail max 255 characters.");
                }

                if ((c_o.value || "").length > 120) {
                    c_o.classList.add("is-invalid");
                    errors.push("C/O max 120 characters.");
                }

                if (!["Open", "Close"].includes(status.value)) {
                    status.classList.add("is-invalid");
                    errors.push("Status must be Open/Close.");
                }

                if (status.value === "Close" && !date_of_close.value) {
                    date_of_close.classList.add("is-invalid");
                    // altInput visible field also highlight
                    if (date_of_close._flatpickr && date_of_close._flatpickr.altInput) {
                        date_of_close._flatpickr.altInput.classList.add("is-invalid");
                    }
                    errors.push("Date of close is required when status is Close.");
                }

                if (errors.length) {
                    setToast("toast-warning", errors.join(" "));
                    return;
                }

                submitBtn.disabled = true;
                try {
                    const fd = new FormData(form);
                    fd.append("ajax", "1");

                    const res = await fetch(window.location.href, {
                        method: "POST",
                        body: fd
                    });
                    const data = await res.json();

                    if (data.ok) {
                        setToast("toast-success", data.msg || "Submitted!");

                        // clear fields after success (keep date + prepare_by)
                        gate_pass.value = "";
                        returnable.value = "N";
                        purpose_for.value = "";
                        detail.value = "";
                        quantity.value = "0";
                        move_from.value = "";
                        move_to.value = "";
                        status.value = "Open";
                        syncCloseEnabled();
                        c_o.value = "";
                    } else {
                        setToast("toast-error", data.msg || "Failed!");
                    }
                } catch (ex) {
                    setToast("toast-error", "Network error!");
                } finally {
                    submitBtn.disabled = false;
                }
            });
        });
    </script>

</body>

</html>