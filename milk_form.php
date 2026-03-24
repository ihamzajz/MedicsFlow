<?php
session_start();
if (!isset($_SESSION['loggedin'])) { header('Location: login.php'); exit; }

include 'dbconfig.php';
date_default_timezone_set("Asia/Karachi");

function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function isValidDateYmd($d): bool {
    if (!$d) return false;
    $dt = DateTime::createFromFormat('Y-m-d', $d);
    return $dt && $dt->format('Y-m-d') === $d;
}
function dayNameFromYmd($ymd): string {
    $dt = DateTime::createFromFormat('Y-m-d', $ymd);
    return $dt ? $dt->format('l') : '';
}

$form_user = $_SESSION['fullname'] ?? ($_SESSION['username'] ?? ($_SESSION['email'] ?? 'unknown'));

// ===== AJAX submit handler (no reload) =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax']) && $_POST['ajax'] === '1') {
    header('Content-Type: application/json; charset=utf-8');

    $date = trim($_POST['date'] ?? '');
    $rate = trim($_POST['rate'] ?? '220');

    $qty_morning  = trim($_POST['qty_morning'] ?? '');
    $time_morning = trim($_POST['time_morning'] ?? '');

    $qty_evening  = trim($_POST['qty_evening'] ?? '');
    $time_evening = trim($_POST['time_evening'] ?? '');

    $remarks = trim($_POST['remarks'] ?? '');

    if (!isValidDateYmd($date)) { echo json_encode(['ok'=>false,'msg'=>'Invalid date']); exit; }
    $day = dayNameFromYmd($date);
    if ($day === '') { echo json_encode(['ok'=>false,'msg'=>'Invalid date']); exit; }

    if ($rate === '' || !is_numeric($rate) || (float)$rate < 0) {
        echo json_encode(['ok'=>false,'msg'=>'Invalid rate']); exit;
    }

    if (strlen($remarks) > 500) {
        echo json_encode(['ok'=>false,'msg'=>'Remarks max 500 characters']); exit;
    }

    $qm = ($qty_morning === '' ? 0 : (is_numeric($qty_morning) ? (float)$qty_morning : -1));
    $qe = ($qty_evening === '' ? 0 : (is_numeric($qty_evening) ? (float)$qty_evening : -1));
    if ($qm < 0 || $qe < 0) { echo json_encode(['ok'=>false,'msg'=>'Invalid quantity']); exit; }

    $morningOk = ($qm > 0 && $time_morning !== '');
    $eveningOk = ($qe > 0 && $time_evening !== '');
    if (!$morningOk && !$eveningOk) {
        echo json_encode(['ok'=>false,'msg'=>'Enter at least Morning (Qty+Time) OR Evening (Qty+Time).']); exit;
    }

    if ($qm <= 0) $time_morning = '';
    if ($qe <= 0) $time_evening = '';

    $total_qty = $qm + $qe;
    $rt = (float)$rate;
    $amount = $total_qty * $rt;

    $qm2 = number_format($qm, 2, '.', '');
    $qe2 = number_format($qe, 2, '.', '');
    $tq2 = number_format($total_qty, 2, '.', '');
    $rt2 = number_format($rt, 2, '.', '');
    $am2 = number_format($amount, 2, '.', '');

    $stmt = $conn->prepare("
        INSERT INTO milk_form
        (`date`,`day`,qty_morning,time_morning,qty_evening,time_evening,total_qty,rate,amount,remarks,form_user)
        VALUES (?,?,?,?,?,?,?,?,?,?,?)
    ");
    if (!$stmt) { echo json_encode(['ok'=>false,'msg'=>'DB error']); exit; }

    $stmt->bind_param(
        "ssdsdsdddss",
        $date,
        $day,
        $qm2, $time_morning,
        $qe2, $time_evening,
        $tq2,
        $rt2,
        $am2,
        $remarks,
        $form_user
    );

    $ok = $stmt->execute();
    $stmt->close();

    echo json_encode($ok
        ? ['ok'=>true,'msg'=>'Form submitted successfully!']
        : ['ok'=>false,'msg'=>'Form submission failed!']
    );
    exit;
}

$today_db  = date('Y-m-d');
$today_day = date('l');
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
            padding: 2.5px 5px;
            height: 25px !important;
            color: black !important;
        }
        input:focus { outline: none; border: 1px solid black; background-color: #FFF4B5; }
        textarea { border: 0.5px solid #adb5bd !important; border-radius: 0px !important; font-size:13px; }
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

        .two-col-title{ font-weight: 800; font-size: 13px; margin: 10px 0 6px; color:#0f172a; }
        .small-err{ font-size: 12px; }
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

                    <form class="form pb-3" method="POST" autocomplete="off" id="milkForm">
                        <div class="card shadow">
                            <div class="card-header bg-header text-white d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Milk Form</h6>
                                <a href="milk_home.php" class="btn btn-light btn-sm">
                                    <i class="fa-solid fa-home"></i> Home
                                </a>
                            </div>

                            <div class="card-body">

                                <!-- Date, Day, Rate -->
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label labelf">Date</label>
                                        <input type="date" id="date" name="date" value="<?php echo h($today_db); ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label labelf">Day</label>
                                        <input type="text" id="day" name="day" value="<?php echo h($today_day); ?>" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label labelf">Rate</label>
                                        <input type="text" id="rate" name="rate" value="220">
                                    </div>
                                </div>

                                <!-- Morning & Evening side by side -->
                                <div class="row g-4 mt-2">
                                    <div class="col-md-6">
                                        <div class="two-col-title">Morning</div>
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <label class="form-label labelf">Qty</label>
                                                <input type="text" id="qty_morning" name="qty_morning" placeholder="0">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label labelf">Time</label>
                                                <input type="time" id="time_morning" name="time_morning">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="two-col-title">Evening</div>
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <label class="form-label labelf">Qty</label>
                                                <input type="text" id="qty_evening" name="qty_evening" placeholder="0">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label labelf">Time</label>
                                                <input type="time" id="time_evening" name="time_evening">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Totals (no heading) -->
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

                                <!-- Remarks (no heading) -->
                                <div class="row g-3 mt-2">
                                    <div class="col-md-12">
                                        <label class="form-label labelf">Remarks (optional)</label>
                                        <input type="text" id="remarks" name="remarks" maxlength="500" placeholder="Optional">
                                    </div>
                                </div>

                                <div class="text-danger small-err mt-2 d-none" id="formError"></div>

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
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("milkForm");

    const date = document.getElementById("date");
    const day  = document.getElementById("day");
    const rate = document.getElementById("rate");

    const qm = document.getElementById("qty_morning");
    const tm = document.getElementById("time_morning");

    const qe = document.getElementById("qty_evening");
    const te = document.getElementById("time_evening");

    const totalQty = document.getElementById("total_qty");
    const amount   = document.getElementById("amount");
    const remarks  = document.getElementById("remarks");

    const err = document.getElementById("formError");
    const submitBtn = document.getElementById("submitBtn");

    const toastEl = document.getElementById("statusToast");
    const toastMsg = document.getElementById("toastMsg");

    function setToast(type, msg){
        toastEl.classList.remove("toast-success","toast-error","toast-warning");
        toastEl.classList.add(type);
        toastMsg.textContent = msg;
        new bootstrap.Toast(toastEl, { delay: 2500 }).show();
    }

    function clearInvalid(){
        [rate,qm,qe,tm,te,remarks].forEach(i => i.classList.remove("is-invalid"));
        err.classList.add("d-none");
        err.textContent = "";
    }

    function toNum(v){
        const n = Number(String(v).trim());
        return Number.isFinite(n) ? n : NaN;
    }

    function updateDay(){
        if(!date.value) return;
        const dt = new Date(date.value + "T00:00:00");
        day.value = dt.toLocaleDateString('en-US', { weekday:'long' });
    }

    function recalcTotals(){
        const nqm = toNum(qm.value || "0");
        const nqe = toNum(qe.value || "0");
        const rt  = toNum(rate.value || "0");

        const safeQm = (Number.isFinite(nqm) && nqm >= 0) ? nqm : 0;
        const safeQe = (Number.isFinite(nqe) && nqe >= 0) ? nqe : 0;
        const safeRt = (Number.isFinite(rt)  && rt  >= 0) ? rt  : 0;

        const tq = safeQm + safeQe;
        totalQty.value = tq.toFixed(2);
        amount.value   = (tq * safeRt).toFixed(2);
    }

    date.addEventListener("change", updateDay);
    [qm, qe, rate].forEach(el => el.addEventListener("input", recalcTotals));
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

            const res = await fetch(window.location.href, { method:"POST", body: fd });
            const data = await res.json();

            if (data.ok) {
                setToast("toast-success", data.msg || "Submitted!");
                // Clear fields after success (keep date/day/rate)
                qm.value = ""; tm.value = "";
                qe.value = ""; te.value = "";
                remarks.value = "";
                recalcTotals();
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
