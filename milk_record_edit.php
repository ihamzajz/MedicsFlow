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
function dayNameFromYmd($ymd): string
{
    $dt = DateTime::createFromFormat('Y-m-d', $ymd);
    return $dt ? $dt->format('l') : '';
}

$form_user = $_SESSION['fullname'] ?? ($_SESSION['username'] ?? ($_SESSION['email'] ?? 'unknown'));

// ===== AJAX update handler (no reload) =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax']) && $_POST['ajax'] === '1') {
    header('Content-Type: application/json; charset=utf-8');

    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['ok' => false, 'msg' => 'Invalid record id']);
        exit;
    }

    $date = trim($_POST['date'] ?? '');
    $rate = trim($_POST['rate'] ?? '220');

    $qty_morning  = trim($_POST['qty_morning'] ?? '');
    $time_morning = trim($_POST['time_morning'] ?? '');

    $qty_evening  = trim($_POST['qty_evening'] ?? '');
    $time_evening = trim($_POST['time_evening'] ?? '');

    $remarks = trim($_POST['remarks'] ?? '');

    // Validate date
    if (!isValidDateYmd($date)) {
        echo json_encode(['ok' => false, 'msg' => 'Invalid date']);
        exit;
    }
    $day = dayNameFromYmd($date);
    if ($day === '') {
        echo json_encode(['ok' => false, 'msg' => 'Invalid date']);
        exit;
    }

    // Validate rate
    if ($rate === '' || !is_numeric($rate) || (float)$rate < 0) {
        echo json_encode(['ok' => false, 'msg' => 'Invalid rate']);
        exit;
    }

    // Remarks optional max 500
    if (strlen($remarks) > 500) {
        echo json_encode(['ok' => false, 'msg' => 'Remarks max 500 characters']);
        exit;
    }

    // qty empty => 0; invalid => error
    $qm = ($qty_morning === '' ? 0 : (is_numeric($qty_morning) ? (float)$qty_morning : -1));
    $qe = ($qty_evening === '' ? 0 : (is_numeric($qty_evening) ? (float)$qty_evening : -1));
    if ($qm < 0 || $qe < 0) {
        echo json_encode(['ok' => false, 'msg' => 'Invalid quantity']);
        exit;
    }

    // Required: at least one pair must be provided
    $morningOk = ($qm > 0 && $time_morning !== '');
    $eveningOk = ($qe > 0 && $time_evening !== '');
    if (!$morningOk && !$eveningOk) {
        echo json_encode(['ok' => false, 'msg' => 'Enter at least Morning (Qty+Time) OR Evening (Qty+Time).']);
        exit;
    }

    // Clean times if qty is 0
    if ($qm <= 0) $time_morning = '';
    if ($qe <= 0) $time_evening = '';

    // totals
    $total_qty = $qm + $qe;
    $rt = (float)$rate;
    $amount = $total_qty * $rt;

    // Make sure record exists
    $chk = $conn->prepare("SELECT id FROM milk_form WHERE id = ?");
    $chk->bind_param("i", $id);
    $chk->execute();
    $chk->store_result();
    $exists = $chk->num_rows > 0;
    $chk->close();

    if (!$exists) {
        echo json_encode(['ok' => false, 'msg' => 'Record not found']);
        exit;
    }

    // Update
    $stmt = $conn->prepare("
        UPDATE milk_form
        SET `date`=?,
            `day`=?,
            qty_morning=?,
            time_morning=?,
            qty_evening=?,
            time_evening=?,
            total_qty=?,
            rate=?,
            amount=?,
            remarks=?,
            form_user=?
        WHERE id=?
    ");
    if (!$stmt) {
        echo json_encode(['ok' => false, 'msg' => 'DB error']);
        exit;
    }

    // bind types: s s d s d s d d d s s i
    $stmt->bind_param(
        "ssdsdsdddssi",
        $date,
        $day,
        $qm,
        $time_morning,
        $qe,
        $time_evening,
        $total_qty,
        $rt,
        $amount,
        $remarks,
        $form_user,
        $id
    );

    $ok = $stmt->execute();
    $stmt->close();

    echo json_encode(
        $ok
            ? ['ok' => true, 'msg' => 'Record updated successfully!', 'day' => $day]
            : ['ok' => false, 'msg' => 'Update failed!']
    );
    exit;
}

// ===== GET: Load record =====
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    // you can redirect if you want:
    // header("Location: milk_record_list.php"); exit;
    $record = null;
} else {
    $stmt = $conn->prepare("
        SELECT id, `date`, `day`, qty_morning, time_morning, qty_evening, time_evening, rate, remarks
        FROM milk_form
        WHERE id = ?
        LIMIT 1
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $record = $res->fetch_assoc();
    $stmt->close();
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
    <?php include 'sidebarcss.php'; ?>

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

        input {
            width: 100% !important;
            font-size: 13px;
            border-radius: 0px;
            border: 1px solid grey;
            padding: 2.5px 5px;
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
            font-size: 13px;
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

        .two-col-title {
            font-weight: 800;
            font-size: 13px;
            margin: 10px 0 6px;
            color: #0f172a;
        }

        .small-err {
            font-size: 12px;
        }

        .btn-cancel,
        .btn-cancel:hover {
            border-radius: 20px;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
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
                    <div class="col-md-8 pt-md-2">

                        <?php if (!$record): ?>
                            <div class="alert alert-danger">
                                Record not found or invalid id.
                                <div class="mt-2">
                                    <a href="milk_record_list.php" class="btn btn-sm btn-dark">Back to List</a>
                                </div>
                            </div>
                        <?php else: ?>

                            <form class="form pb-3" method="POST" autocomplete="off" id="milkEditForm">
                                <input type="hidden" name="id" id="id" value="<?php echo (int)$record['id']; ?>">
                                <div class="card shadow">
                                    <div class="card-header bg-header text-white d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Edit Milk Record</h6>
                                        <a href="milk_home.php" class="btn btn-light btn-sm">
                                            <i class="fa-solid fa-home"></i> Home
                                        </a>
                                    </div>

                                    <div class="card-body">

                                        <!-- Date, Day, Rate -->
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label labelf">Date</label>
                                                <input type="date" id="date" name="date" value="<?php echo h($record['date']); ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label labelf">Day</label>
                                                <input type="text" id="day" value="<?php echo h($record['day']); ?>" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label labelf">Rate</label>
                                                <input type="text" id="rate" name="rate" value="<?php echo h($record['rate']); ?>">
                                            </div>
                                        </div>

                                        <!-- Morning & Evening side by side -->
                                        <div class="row g-4 mt-2">
                                            <div class="col-md-6">
                                                <div class="two-col-title">Morning</div>
                                                <div class="row g-3">
                                                    <div class="col-6">
                                                        <label class="form-label labelf">Qty</label>
                                                        <input type="text" id="qty_morning" name="qty_morning" value="<?php echo h($record['qty_morning']); ?>" placeholder="0">
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label labelf">Time</label>
                                                        <input type="time" id="time_morning" name="time_morning" value="<?php echo h($record['time_morning']); ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="two-col-title">Evening</div>
                                                <div class="row g-3">
                                                    <div class="col-6">
                                                        <label class="form-label labelf">Qty</label>
                                                        <input type="text" id="qty_evening" name="qty_evening" value="<?php echo h($record['qty_evening']); ?>" placeholder="0">
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label labelf">Time</label>
                                                        <input type="time" id="time_evening" name="time_evening" value="<?php echo h($record['time_evening']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Totals -->
                                        <div class="row g-3 mt-2">
                                            <div class="col-md-6">
                                                <label class="form-label labelf">Total Qty</label>
                                                <input type="text" id="total_qty" value="0.00" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label labelf">Total Amount</label>
                                                <input type="text" id="amount" value="0.00" readonly>
                                            </div>
                                        </div>

                                        <!-- Remarks -->
                                        <div class="row g-3 mt-2">
                                            <div class="col-md-12">
                                                <label class="form-label labelf">Remarks (optional)</label>
                                                <input type="text" id="remarks" name="remarks" maxlength="500" value="<?php echo h($record['remarks']); ?>" placeholder="Optional">
                                            </div>
                                        </div>

                                        <div class="text-danger small-err mt-2 d-none" id="formError"></div>

                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-form px-4" id="submitBtn">Update</button>

                                            <a href="milk_record_list.php" class="btn btn-secondary btn-cancel">
                                                Cancel
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </form>

                        <?php endif; ?>

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
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById("milkEditForm");
            if (!form) return;

            const date = document.getElementById("date");
            const day = document.getElementById("day");
            const rate = document.getElementById("rate");

            const qm = document.getElementById("qty_morning");
            const tm = document.getElementById("time_morning");

            const qe = document.getElementById("qty_evening");
            const te = document.getElementById("time_evening");

            const totalQty = document.getElementById("total_qty");
            const amount = document.getElementById("amount");
            const remarks = document.getElementById("remarks");

            const submitBtn = document.getElementById("submitBtn");

            const toastEl = document.getElementById("statusToast");
            const toastMsg = document.getElementById("toastMsg");

            function setToast(type, msg) {
                toastEl.classList.remove("toast-success", "toast-error", "toast-warning");
                toastEl.classList.add(type);
                toastMsg.textContent = msg;
                new bootstrap.Toast(toastEl, {
                    delay: 2500
                }).show();
            }

            function clearInvalid() {
                [rate, qm, qe, tm, te, remarks].forEach(i => i.classList.remove("is-invalid"));
            }

            function toNum(v) {
                const n = Number(String(v).trim());
                return Number.isFinite(n) ? n : NaN;
            }

            function updateDay() {
                if (!date.value) return;
                const dt = new Date(date.value + "T00:00:00");
                day.value = dt.toLocaleDateString('en-US', {
                    weekday: 'long'
                });
            }

            function recalcTotals() {
                const nqm = toNum(qm.value || "0");
                const nqe = toNum(qe.value || "0");
                const rt = toNum(rate.value || "0");

                const safeQm = (Number.isFinite(nqm) && nqm >= 0) ? nqm : 0;
                const safeQe = (Number.isFinite(nqe) && nqe >= 0) ? nqe : 0;
                const safeRt = (Number.isFinite(rt) && rt >= 0) ? rt : 0;

                const tq = safeQm + safeQe;
                totalQty.value = tq.toFixed(2);
                amount.value = (tq * safeRt).toFixed(2);
            }

            date.addEventListener("change", () => {
                updateDay();
            });
            [qm, qe, rate].forEach(el => el.addEventListener("input", recalcTotals));
            updateDay();
            recalcTotals();

            form.addEventListener("submit", async (e) => {
                e.preventDefault();
                clearInvalid();

                const rt = toNum(rate.value);
                if (!Number.isFinite(rt) || rt < 0) {
                    rate.classList.add("is-invalid");
                    setToast("toast-warning", "Enter valid rate.");
                    return;
                }

                const rem = String(remarks.value || "");
                if (rem.length > 500) {
                    remarks.classList.add("is-invalid");
                    setToast("toast-warning", "Remarks max 500 characters.");
                    return;
                }

                const nqm = toNum(qm.value || "0");
                const nqe = toNum(qe.value || "0");
                const morningOk = (Number.isFinite(nqm) && nqm > 0 && tm.value);
                const eveningOk = (Number.isFinite(nqe) && nqe > 0 && te.value);

                if (!morningOk && !eveningOk) {
                    qm.classList.add("is-invalid");
                    qe.classList.add("is-invalid");
                    setToast("toast-warning", "Enter at least Morning (Qty+Time) OR Evening (Qty+Time).");
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
                        setToast("toast-success", data.msg || "Record updated!");
                        // keep on same page + keep values
                        if (data.day) day.value = data.day;
                        recalcTotals();
                    } else {
                        setToast("toast-error", data.msg || "Update failed!");
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