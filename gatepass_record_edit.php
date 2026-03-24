<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

require_once 'dbconfig.php';
date_default_timezone_set("Asia/Karachi");

function h($s)
{
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}
function isValidDateYmd($d): bool
{
    if (!$d) return false;
    $dt = DateTime::createFromFormat('Y-m-d', $d);
    return $dt && $dt->format('Y-m-d') === $d;
}

$form_user = $_SESSION['fullname'] ?? ($_SESSION['username'] ?? ($_SESSION['email'] ?? 'unknown'));

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: gatepass_record_list.php?status=notfound");
    exit;
}

/* ----------------- Fetch existing record ----------------- */
$stmt = $conn->prepare("
    SELECT
        id, `date`, gate_pass, returnable, purpose_for, detail, quantity,
        move_from, move_to, prepare_by, status, date_of_close, c_o
    FROM gatepass_form
    WHERE id = ?
    LIMIT 1
");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$record = $res->fetch_assoc();
$stmt->close();

if (!$record) {
    header("Location: gatepass_record_list.php?status=notfound");
    exit;
}

/* ----------------- AJAX Update handler (no reload) ----------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax']) && $_POST['ajax'] === '1') {
    header('Content-Type: application/json; charset=utf-8');

    $date        = trim($_POST['date'] ?? '');
    $gate_pass   = trim($_POST['gate_pass'] ?? '');
    $returnable  = trim($_POST['returnable'] ?? 'N'); // Y/N
    $purpose_for = trim($_POST['purpose_for'] ?? '');
    $detail      = trim($_POST['detail'] ?? '');
    $quantity    = trim($_POST['quantity'] ?? '0');
    $move_from   = trim($_POST['move_from'] ?? '');
    $move_to     = trim($_POST['move_to'] ?? '');
    $statusVal   = trim($_POST['status'] ?? 'Open');  // Open/Close
    $date_close  = trim($_POST['date_of_close'] ?? '');
    $c_o         = trim($_POST['c_o'] ?? '');

    // keep prepare_by same as record (you made it readonly in UI)
    $prepare_by  = (string)($record['prepare_by'] ?? $form_user);

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

    if (!in_array($statusVal, ['Open', 'Close'], true)) $errors[] = "Status must be Open/Close.";

    if ($statusVal === 'Close') {
        if (!isValidDateYmd($date_close)) $errors[] = "Date of close is required (and must be valid) when status is Close.";
    } else {
        $date_close = null;
    }

    if (strlen($c_o) > 120) $errors[] = "C/O max 120 characters.";

    if (!empty($errors)) {
        echo json_encode(['ok' => false, 'msg' => implode(" ", $errors)]);
        exit;
    }

    // ✅ FIX: bind_param needs variables only (by reference)
    $qtyStr   = number_format((float)$quantity, 2, '.', '');
    $qtyFloat = (float)$qtyStr;

    $stmtU = $conn->prepare("
        UPDATE gatepass_form
        SET
            `date`=?,
            gate_pass=?,
            returnable=?,
            purpose_for=?,
            detail=?,
            quantity=?,
            move_from=?,
            move_to=?,
            prepare_by=?,
            status=?,
            date_of_close=?,
            c_o=?,
            updated_at = CURRENT_TIMESTAMP
        WHERE id=?
        LIMIT 1
    ");

    if (!$stmtU) {
        echo json_encode(['ok' => false, 'msg' => 'DB error']);
        exit;
    }

    $stmtU->bind_param(
        "sssssdssssssi",
        $date,
        $gate_pass,
        $returnable,
        $purpose_for,
        $detail,
        $qtyFloat,
        $move_from,
        $move_to,
        $prepare_by,
        $statusVal,
        $date_close,
        $c_o,
        $id
    );

    $ok = $stmtU->execute();
    $stmtU->close();

    echo json_encode(
        $ok
            ? ['ok' => true, 'msg' => 'Record updated successfully!']
            : ['ok' => false, 'msg' => 'Update failed!']
    );
    exit;
}

/* ----------------- Prefill values ----------------- */
$val_date_db = (string)$record['date']; // Y-m-d
$dt = DateTime::createFromFormat('Y-m-d', $val_date_db);
$val_date_ui = $dt ? $dt->format('d-m-Y') : $val_date_db;

$val_gate_pass   = (string)$record['gate_pass'];
$val_returnable  = (string)$record['returnable'];
$val_purpose_for = (string)$record['purpose_for'];
$val_detail      = (string)$record['detail'];
$val_quantity    = number_format((float)$record['quantity'], 2, '.', '');
$val_move_from   = (string)$record['move_from'];
$val_move_to     = (string)$record['move_to'];
$val_prepare_by  = (string)$record['prepare_by'];
$val_status      = (string)$record['status'];
$val_date_close  = (string)($record['date_of_close'] ?? '');
$val_c_o         = (string)$record['c_o'];
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
            padding: 2.5px 5px;
            letter-spacing: 0.4px;
            height: 25px !important;
            color: black !important;
        }

        input:focus,
        select:focus {
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
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

        .toast-custom .btn-close {
            filter: none !important;
            opacity: 0.6;
        }

        .toast-custom .btn-close:hover {
            opacity: 1;
        }

        .btn-cancel,
        .btn-cancel:hover {
            border-radius: 20px;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
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

                        <form class="form pb-3" method="POST" autocomplete="off" id="gatepassEditForm">
                            <div class="card shadow">
                                <div class="card-header bg-header text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Edit Gatepass Record</h6>
                                    <a href="gatepass_home.php" class="btn btn-light btn-sm">
                                        <i class="fa-solid fa-home"></i> Home
                                    </a>
                                </div>

                                <div class="card-body">

                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label labelf">Date</label>
                                            <input type="text" id="date_ui" value="<?php echo h($val_date_ui); ?>" readonly>
                                            <input type="hidden" id="date" name="date" value="<?php echo h($val_date_db); ?>">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label labelf">Gate Pass</label>
                                            <input type="text" name="gate_pass" id="gate_pass" maxlength="100"
                                                value="<?php echo h($val_gate_pass); ?>" placeholder="Enter gate pass no">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label labelf">Returnable (Y/N)</label>
                                            <select id="returnable" name="returnable">
                                                <option value="Y" <?php echo ($val_returnable === 'Y' ? 'selected' : ''); ?>>Yes</option>
                                                <option value="N" <?php echo ($val_returnable !== 'Y' ? 'selected' : ''); ?>>No</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row g-3 mt-1">
                                        <div class="col-md-4">
                                            <label class="form-label labelf">Purpose for</label>
                                            <input type="text" name="purpose_for" id="purpose_for" maxlength="150"
                                                value="<?php echo h($val_purpose_for); ?>" placeholder="Purpose">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label labelf">Detail</label>
                                            <input type="text" name="detail" id="detail" maxlength="255"
                                                value="<?php echo h($val_detail); ?>" placeholder="Detail (optional)">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label labelf">Quantity</label>
                                            <input type="text" name="quantity" id="quantity"
                                                value="<?php echo h($val_quantity); ?>" placeholder="0.00">
                                        </div>
                                    </div>

                                    <div class="row g-3 mt-1">
                                        <div class="col-md-4">
                                            <label class="form-label labelf">Move from</label>
                                            <input type="text" name="move_from" id="move_from" maxlength="120"
                                                value="<?php echo h($val_move_from); ?>" placeholder="Move from">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label labelf">Move to</label>
                                            <input type="text" name="move_to" id="move_to" maxlength="120"
                                                value="<?php echo h($val_move_to); ?>" placeholder="Move to">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label labelf">Prepare by</label>
                                            <input type="text" name="prepare_by" id="prepare_by"
                                                value="<?php echo h($val_prepare_by); ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="row g-3 mt-1">
                                        <div class="col-md-4">
                                            <label class="form-label labelf">Status</label>
                                            <select id="status" name="status">
                                                <option value="Open" <?php echo ($val_status === 'Open' ? 'selected' : ''); ?>>Open</option>
                                                <option value="Close" <?php echo ($val_status === 'Close' ? 'selected' : ''); ?>>Close</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label labelf">Date of close</label>
                                            <input type="date" name="date_of_close" id="date_of_close"
                                                value="<?php echo h($val_date_close); ?>">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label labelf">C/O</label>
                                            <input type="text" name="c_o" id="c_o" maxlength="120"
                                                value="<?php echo h($val_c_o); ?>" placeholder="C/O (optional)">
                                        </div>
                                    </div>

                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-form px-4" id="updateBtn">Update</button>
                                        <a href="gatepass_record_list.php" class="btn btn-secondary btn-cancel">
                                            Cancel
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- Toast Container -->
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById("gatepassEditForm");

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
            const dateHidden = document.getElementById("date"); // hidden Y-m-d

            const updateBtn = document.getElementById("updateBtn");
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
                [gate_pass, purpose_for, detail, quantity, move_from, move_to, prepare_by, date_of_close, c_o, status, returnable]
                .forEach(i => i.classList.remove("is-invalid"));
            }

            function toNum(v) {
                const n = Number(String(v).trim());
                return Number.isFinite(n) ? n : NaN;
            }

            function syncCloseEnabled() {
                const isClose = (status.value === "Close");
                date_of_close.disabled = !isClose;
                if (!isClose) {
                    date_of_close.value = "";
                    date_of_close.classList.remove("is-invalid");
                }
            }
            status.addEventListener("change", syncCloseEnabled);
            syncCloseEnabled();

            form.addEventListener("submit", async (e) => {
                e.preventDefault();
                clearInvalid();

                const errors = [];

                if (!dateHidden.value) {
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
                    errors.push("Date of close is required when status is Close.");
                }

                if (errors.length) {
                    setToast("toast-warning", errors.join(" "));
                    return;
                }

                updateBtn.disabled = true;
                try {
                    const fd = new FormData(form);
                    fd.append("ajax", "1"); // ✅ same as gatepass_form

                    const res = await fetch(window.location.href, {
                        method: "POST",
                        body: fd
                    });
                    const data = await res.json();

                    if (data.ok) {
                        setToast("toast-success", data.msg || "Updated!");
                    } else {
                        setToast("toast-error", data.msg || "Update failed!");
                    }
                } catch (ex) {
                    setToast("toast-error", "Network error!");
                } finally {
                    updateBtn.disabled = false;
                }
            });
        });
    </script>

</body>

</html>