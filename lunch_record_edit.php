<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

include 'dbconfig.php';
date_default_timezone_set("Asia/Karachi");

$form_user = $_SESSION['fullname'] ?? ($_SESSION['username'] ?? ($_SESSION['email'] ?? 'unknown'));

// ===== Get ID =====
$id = isset($_GET['id']) ? (int)$_GET['id'] : (int)($_POST['id'] ?? 0);
if ($id <= 0) {
    header("Location: lunch_record_list.php");
    exit;
}

// ===== Fetch record =====
$stmtGet = $conn->prepare("SELECT * FROM lunch_form WHERE id = ? LIMIT 1");
$stmtGet->bind_param("i", $id);
$stmtGet->execute();
$resGet = $stmtGet->get_result();
$record = $resGet->fetch_assoc();
$stmtGet->close();

if (!$record) {
    header("Location: lunch_record_list.php");
    exit;
}

// ===== AJAX UPDATE handler (no reload) =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax']) && $_POST['ajax'] === '1') {
    header('Content-Type: application/json; charset=utf-8');
    if (ob_get_length()) {
        ob_clean();
    }

    // Required
    $date = trim($_POST['date'] ?? '');

    // Part 1
    $no_of_employee = trim($_POST['no_of_employee'] ?? '');
    $no_of_guest    = trim($_POST['no_of_guest'] ?? '');

    // Part 2
    $total_head_counts_hr   = trim($_POST['total_head_counts_hr'] ?? '');
    $security_guards_part2  = trim($_POST['security_guards_part2'] ?? '');
    $guests_part2           = trim($_POST['guests_part2'] ?? '');

    // Part 3
    $attendance             = trim($_POST['attendance'] ?? '');
    $security_guards_part3  = trim($_POST['security_guards_part3'] ?? '');
    $guests_part3           = trim($_POST['guests_part3'] ?? '');

    // Remarks (OPTIONAL)
    $remarks = trim($_POST['remarks'] ?? '');

    // ===== Basic server-side validation =====
    $ok = true;

    $d = DateTime::createFromFormat('Y-m-d', $date);
    if (!$d || $d->format('Y-m-d') !== $date) $ok = false;

    function valid_nonneg_int($v)
    {
        if ($v === '' || !is_numeric($v)) return false;
        if ((int)$v < 0) return false;
        if ((string)(int)$v !== (string)(0 + $v)) return false; // prevent decimals
        return true;
    }

    $ints = [
        $no_of_employee,
        $no_of_guest,
        $total_head_counts_hr,
        $security_guards_part2,
        $guests_part2,
        $attendance,
        $security_guards_part3,
        $guests_part3
    ];
    foreach ($ints as $v) {
        if (!valid_nonneg_int($v)) {
            $ok = false;
            break;
        }
    }

    if (strlen($remarks) > 500) $ok = false;

    if ($ok) {
        // ===== Compute totals/diffs on server =====
        $no_of_employee = (int)$no_of_employee;
        $no_of_guest    = (int)$no_of_guest;

        $total_head_counts_hr  = (int)$total_head_counts_hr;
        $security_guards_part2 = (int)$security_guards_part2;
        $guests_part2          = (int)$guests_part2;

        $attendance            = (int)$attendance;
        $security_guards_part3 = (int)$security_guards_part3;
        $guests_part3          = (int)$guests_part3;

        $total_part1 = $no_of_employee + $no_of_guest;

        $total_part2 = $total_head_counts_hr + $security_guards_part2 + $guests_part2;
        $diff_part2  = $total_part2 - $total_part1;
        $diff_percent_part2 = ($total_part1 > 0) ? (($diff_part2 / $total_part1) * 100) : 0;

        $total_part3 = $attendance + $security_guards_part3 + $guests_part3;
        $diff_part3  = $total_part1 - $total_part3;
        $diff_percent_part3 = ($total_part1 > 0) ? (($diff_part3 / $total_part1) * 100) : 0;

        $day = date('l', strtotime($date));
        // Do NOT change created_at on edit (keeps original record time)

        $dp2 = round((float)$diff_percent_part2, 2);
        $dp3 = round((float)$diff_percent_part3, 2);

        $stmtUp = $conn->prepare("
            UPDATE lunch_form SET
                `date` = ?,
                `day` = ?,

                no_of_employee = ?,
                no_of_guest = ?,
                total_part1 = ?,

                total_head_counts_hr = ?,
                security_guards_part2 = ?,
                guests_part2 = ?,
                total_part2 = ?,
                diff_part2 = ?,
                diff_percent_part2 = ?,

                attendance = ?,
                security_guards_part3 = ?,
                guests_part3 = ?,
                total_part3 = ?,
                diff_part3 = ?,
                diff_percent_part3 = ?,

                remarks = ?,
                form_user = ?
            WHERE id = ?
            LIMIT 1
        ");

        if ($stmtUp) {
            // Types: ss + 8i + d + 5i + d + ss + i  => 22 total
            $stmtUp->bind_param(
                "ssiiiiiiiidiiiiidssi",
                $date,
                $day,

                $no_of_employee,
                $no_of_guest,
                $total_part1,
                $total_head_counts_hr,
                $security_guards_part2,
                $guests_part2,
                $total_part2,
                $diff_part2,
                $dp2,

                $attendance,
                $security_guards_part3,
                $guests_part3,
                $total_part3,
                $diff_part3,
                $dp3,

                $remarks,
                $form_user,
                $id
            );

            $exec = $stmtUp->execute();
            $stmtUp->close();

            if ($exec) {
                echo json_encode(['ok' => true, 'msg' => 'Record updated successfully!']);
                exit;
            } else {
                echo json_encode(['ok' => false, 'msg' => 'Update failed!']);
                exit;
            }
        } else {
            echo json_encode(['ok' => false, 'msg' => 'Update failed!']);
            exit;
        }
    } else {
        echo json_encode(['ok' => false, 'msg' => 'Please fill all fields correctly.']);
        exit;
    }
}

// --- For GET render (load record values into form) ---
$today_db = $record['date'] ?? date('Y-m-d');
$today_day = $record['day'] ?? date('l');
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

        input:focus {
            outline: none;
            border: 1px solid black;
        }

        textarea {
            border: 0.5px solid #adb5bd !important;
            border-radius: 0px !important;
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

        .section-title {
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #111827;
        }

        .section-box {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px;
            background: #e9ecef;
            margin-bottom: 12px;
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

                        <form class="form pb-3" method="POST" autocomplete="off" id="lunchForm">
                            <input type="hidden" name="id" value="<?php echo (int)$id; ?>">

                            <div class="card shadow">
                                <div class="card-header bg-header text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Lunch Record Edit</h6>
                                    <a href="lunch_home.php" class="btn btn-light btn-sm">
                                        <i class="fa-solid fa-home"></i> Home
                                    </a>
                                </div>

                                <div class="card-body">

                                    <!-- PART 1 -->
                                    <div class="section-box">
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <label class="form-label labelf">Date</label>
                                                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($today_db); ?>">
                                                <small id="dateError" class="text-danger d-none"></small>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label labelf">Day</label>
                                                <input type="text" id="day" value="<?php echo htmlspecialchars($today_day); ?>" readonly>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label labelf">No. of Employee</label>
                                                <input type="text" id="no_of_employee" name="no_of_employee" placeholder="0"
                                                    value="<?php echo htmlspecialchars((string)$record['no_of_employee']); ?>">
                                                <small id="empError" class="text-danger d-none"></small>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label labelf">No. of Guest</label>
                                                <input type="text" id="no_of_guest" name="no_of_guest" placeholder="0"
                                                    value="<?php echo htmlspecialchars((string)$record['no_of_guest']); ?>">
                                                <small id="guestError" class="text-danger d-none"></small>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label labelf">Total</label>
                                                <input type="text" id="total_part1" value="<?php echo (int)$record['total_part1']; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- PART 2 -->
                                    <div class="section-box">
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <label class="form-label labelf">Total Head Counts by HR</label>
                                                <input type="text" id="total_head_counts_hr" name="total_head_counts_hr" placeholder="0"
                                                    value="<?php echo htmlspecialchars((string)$record['total_head_counts_hr']); ?>">
                                                <small id="hrError" class="text-danger d-none"></small>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label labelf">Security Guards</label>
                                                <input type="text" id="security_guards_part2" name="security_guards_part2" placeholder="0"
                                                    value="<?php echo htmlspecialchars((string)$record['security_guards_part2']); ?>">
                                                <small id="sec2Error" class="text-danger d-none"></small>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label labelf">Guests</label>
                                                <input type="text" id="guests_part2" name="guests_part2" placeholder="0"
                                                    value="<?php echo htmlspecialchars((string)$record['guests_part2']); ?>">
                                                <small id="g2Error" class="text-danger d-none"></small>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label labelf">Total</label>
                                                <input type="text" id="total_part2" value="<?php echo (int)$record['total_part2']; ?>" readonly>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label labelf">Diff / Diff%</label>
                                                <input type="text" id="diff_part2" value="<?php echo (int)$record['diff_part2']; ?> (<?php echo number_format((float)$record['diff_percent_part2'], 2); ?>%)" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- PART 3 -->
                                    <div class="section-box">
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <label class="form-label labelf">Attendance</label>
                                                <input type="text" id="attendance" name="attendance" placeholder="0"
                                                    value="<?php echo htmlspecialchars((string)$record['attendance']); ?>">
                                                <small id="attError" class="text-danger d-none"></small>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label labelf">Security Guards</label>
                                                <input type="text" id="security_guards_part3" name="security_guards_part3" placeholder="0"
                                                    value="<?php echo htmlspecialchars((string)$record['security_guards_part3']); ?>">
                                                <small id="sec3Error" class="text-danger d-none"></small>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label labelf">Guests</label>
                                                <input type="text" id="guests_part3" name="guests_part3" placeholder="0"
                                                    value="<?php echo htmlspecialchars((string)$record['guests_part3']); ?>">
                                                <small id="g3Error" class="text-danger d-none"></small>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label labelf">Total</label>
                                                <input type="text" id="total_part3" value="<?php echo (int)$record['total_part3']; ?>" readonly>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label labelf">Diff / Diff%</label>
                                                <input type="text" id="diff_part3" value="<?php echo (int)$record['diff_part3']; ?> (<?php echo number_format((float)$record['diff_percent_part3'], 2); ?>%)" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- REMARKS -->
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label labelf">Remarks</label>
                                            <textarea class="form-control" name="remarks" id="remarks"
                                                rows="2" maxlength="500"
                                                placeholder="Remarks..."><?php echo htmlspecialchars((string)$record['remarks']); ?></textarea>
                                            <small id="remarksError" class="text-danger d-none"></small>
                                        </div>
                                    </div>

                                    <!-- <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-form px-4" id="submitBtn">Update</button>
                                    </div> -->

                                    <div class="text-center mt-4">

                                        <button type="submit" class="btn btn-form px-4" id="submitBtn">Update</button>

                                        <a href="lunch_record_list.php" class="btn btn-secondary btn-cancel">
                                            Cancel
                                        </a>
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

            // ===== Elements =====
            const form = document.getElementById("lunchForm");
            const submitBtn = document.getElementById("submitBtn");

            const dateEl = document.getElementById("date");
            const dayEl = document.getElementById("day");

            // Part 1
            const empEl = document.getElementById("no_of_employee");
            const guestEl = document.getElementById("no_of_guest");
            const total1El = document.getElementById("total_part1");

            // Part 2
            const hrEl = document.getElementById("total_head_counts_hr");
            const sec2El = document.getElementById("security_guards_part2");
            const g2El = document.getElementById("guests_part2");
            const total2El = document.getElementById("total_part2");
            const diff2El = document.getElementById("diff_part2");

            // Part 3
            const attEl = document.getElementById("attendance");
            const sec3El = document.getElementById("security_guards_part3");
            const g3El = document.getElementById("guests_part3");
            const total3El = document.getElementById("total_part3");
            const diff3El = document.getElementById("diff_part3");

            const remarksEl = document.getElementById("remarks");

            // Errors
            const dateError = document.getElementById("dateError");
            const empError = document.getElementById("empError");
            const guestError = document.getElementById("guestError");
            const hrError = document.getElementById("hrError");
            const sec2Error = document.getElementById("sec2Error");
            const g2Error = document.getElementById("g2Error");
            const attError = document.getElementById("attError");
            const sec3Error = document.getElementById("sec3Error");
            const g3Error = document.getElementById("g3Error");
            const remarksError = document.getElementById("remarksError");

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

            // ===== Day auto based on date =====
            const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

            function updateDay() {
                const v = dateEl.value;
                if (!v) {
                    dayEl.value = "";
                    return;
                }
                const d = new Date(v + "T00:00:00");
                dayEl.value = days[d.getDay()];
            }

            // ===== numeric helpers =====
            function toInt(v) {
                v = (v ?? "").toString().trim();
                if (v === "") return 0;
                const n = Number(v);
                if (Number.isNaN(n) || n < 0) return 0;
                return Math.floor(n);
            }

            function diffPercent(diff, base) {
                if (!base || base <= 0) return 0;
                return (diff / base) * 100;
            }

            function formatDiff(diff, pct) {
                return `${diff} (${pct.toFixed(2)}%)`;
            }

            // ===== Auto calculations =====
            function recalc() {
                const emp = toInt(empEl.value);
                const gst = toInt(guestEl.value);
                const total1 = emp + gst;
                total1El.value = total1;

                const hr = toInt(hrEl.value);
                const s2 = toInt(sec2El.value);
                const g2 = toInt(g2El.value);
                const total2 = hr + s2 + g2;
                total2El.value = total2;

                const diff2 = total2 - total1;
                const pct2 = diffPercent(diff2, total1);
                diff2El.value = formatDiff(diff2, pct2);

                const att = toInt(attEl.value);
                const s3 = toInt(sec3El.value);
                const g3 = toInt(g3El.value);
                const total3 = att + s3 + g3;
                total3El.value = total3;

                const diff3 = total1 - total3;
                const pct3 = diffPercent(diff3, total1);
                diff3El.value = formatDiff(diff3, pct3);
            }

            // ===== Validation =====
            function validateDate() {
                const v = dateEl.value.trim();
                if (!v) {
                    setError(dateEl, dateError, "Date is required.");
                    return false;
                }
                clearError(dateEl, dateError);
                return true;
            }

            function validateIntField(el, errEl, label) {
                const v = el.value.trim();
                if (v === "") {
                    setError(el, errEl, label + " is required.");
                    return false;
                }
                const n = Number(v);
                if (Number.isNaN(n) || n < 0 || !Number.isInteger(n)) {
                    setError(el, errEl, "Enter valid non-negative integer.");
                    return false;
                }
                clearError(el, errEl);
                return true;
            }

            // Remarks OPTIONAL (only max length)
            function validateRemarks() {
                const v = remarksEl.value.trim();
                if (v.length > 500) {
                    setError(remarksEl, remarksError, "Max 500 characters.");
                    return false;
                }
                clearError(remarksEl, remarksError);
                return true;
            }

            dateEl.addEventListener("change", function() {
                updateDay();
            });

            [empEl, guestEl, hrEl, sec2El, g2El, attEl, sec3El, g3El].forEach(el => {
                el.addEventListener("input", function() {
                    recalc();
                });
            });

            dateEl.addEventListener("change", validateDate);

            empEl.addEventListener("input", () => validateIntField(empEl, empError, "No. of Employee"));
            guestEl.addEventListener("input", () => validateIntField(guestEl, guestError, "No. of Guest"));

            hrEl.addEventListener("input", () => validateIntField(hrEl, hrError, "Total Head Counts by HR"));
            sec2El.addEventListener("input", () => validateIntField(sec2El, sec2Error, "Security Guards (Part 2)"));
            g2El.addEventListener("input", () => validateIntField(g2El, g2Error, "Guests (Part 2)"));

            attEl.addEventListener("input", () => validateIntField(attEl, attError, "Attendance"));
            sec3El.addEventListener("input", () => validateIntField(sec3El, sec3Error, "Security Guards (Part 3)"));
            g3El.addEventListener("input", () => validateIntField(g3El, g3Error, "Guests (Part 3)"));

            remarksEl.addEventListener("input", validateRemarks);

            // initial
            updateDay();
            recalc();

            // ===== AJAX submit UPDATE =====
            form.addEventListener("submit", async function(e) {
                e.preventDefault();

                const ok =
                    validateDate() &&
                    validateIntField(empEl, empError, "No. of Employee") &&
                    validateIntField(guestEl, guestError, "No. of Guest") &&
                    validateIntField(hrEl, hrError, "Total Head Counts by HR") &&
                    validateIntField(sec2El, sec2Error, "Security Guards (Part 2)") &&
                    validateIntField(g2El, g2Error, "Guests (Part 2)") &&
                    validateIntField(attEl, attError, "Attendance") &&
                    validateIntField(sec3El, sec3Error, "Security Guards (Part 3)") &&
                    validateIntField(g3El, g3Error, "Guests (Part 3)") &&
                    validateRemarks();

                if (!ok) {
                    const firstInvalid = form.querySelector(".is-invalid");
                    if (firstInvalid) firstInvalid.focus();
                    return;
                }

                submitBtn.disabled = true;

                try {
                    const fd = new FormData(form);
                    fd.append("ajax", "1");

                    const res = await fetch(window.location.href + "?id=<?php echo (int)$id; ?>", {
                        method: "POST",
                        body: fd
                    });
                    const data = await res.json();

                    if (data.ok) {
                        showToast("toast-success", data.msg || "Record updated!");
                        // stay on same page, do NOT reset fields
                        // refresh calculated readonly fields
                        recalc();
                    } else {
                        showToast("toast-error", data.msg || "Update failed!");
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