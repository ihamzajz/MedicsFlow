<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

require_once "dbconfig.php";
date_default_timezone_set("Asia/Karachi");

/* ----------------- Helpers ----------------- */
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

/* convert DB time (HH:MM or HH:MM:SS) -> HH:MM for input[type=time] */
function timeForInput($t): string
{
    $t = trim((string)$t);
    if ($t === '') return '';
    if (preg_match('/^\d{2}:\d{2}:\d{2}$/', $t)) return substr($t, 0, 5);
    if (preg_match('/^\d{2}:\d{2}$/', $t)) return $t;
    return '';
}

/* server validation for HH:MM (or empty) */
function valid_time_or_empty($v): bool
{
    $v = trim((string)$v);
    if ($v === '') return true;
    return (bool)preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $v);
}

/* ----------------- Read & validate ID ----------------- */
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: freedom_record_list.php");
    exit;
}

$form_user = $_SESSION['fullname'] ?? ($_SESSION['username'] ?? ($_SESSION['email'] ?? 'unknown'));

/* ----------------- Guards dropdown (ALL status) ----------------- */
$guardOptions = [];
$resG = $conn->query("SELECT name, status FROM freedom_guards ORDER BY name ASC");
if ($resG) {
    while ($r = $resG->fetch_assoc()) $guardOptions[] = $r;
    $resG->free();
}

/* ----------------- Fetch record ----------------- */
$stmtR = $conn->prepare("
    SELECT id, `date`, `day`, guard_name, duty_location, duty_type, time_in, time_out, form_user
    FROM freedom_form
    WHERE id = ?
");
$stmtR->bind_param("i", $id);
$stmtR->execute();
$record = $stmtR->get_result()->fetch_assoc();
$stmtR->close();

if (!$record) {
    header("Location: freedom_record_list.php");
    exit;
}

/* ----------------- AJAX UPDATE ----------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax']) && $_POST['ajax'] === '1') {
    header('Content-Type: application/json; charset=utf-8');

    $date          = trim($_POST['date'] ?? '');
    $guard_name    = trim($_POST['guard_name'] ?? '');
    $duty_location = trim($_POST['duty_location'] ?? '');
    $duty_type     = trim($_POST['duty_type'] ?? '');
    $time_in       = trim($_POST['time_in'] ?? '');
    $time_out      = trim($_POST['time_out'] ?? '');

    // validate date
    if (!isValidDateYmd($date)) {
        echo json_encode(['ok' => false, 'msg' => 'Invalid date.']);
        exit;
    }

    // day from date
    $day_to_save = date('l', strtotime($date));

    // validate guard name (must exist in guards table)
    $exists = false;
    foreach ($guardOptions as $g) {
        if ((string)$g['name'] === $guard_name) {
            $exists = true;
            break;
        }
    }
    if (!$exists) {
        echo json_encode(['ok' => false, 'msg' => 'Invalid guard selected.']);
        exit;
    }

    // validate duty type
    $allowedDutyTypes = ['Day', 'Night', '24Hour'];
    if ($duty_type === '' || !in_array($duty_type, $allowedDutyTypes, true)) {
        echo json_encode(['ok' => false, 'msg' => 'Invalid duty type.']);
        exit;
    }

    // validate duty location
    if ($duty_location === '') {
        echo json_encode(['ok' => false, 'msg' => 'Duty location is required.']);
        exit;
    }
    if (mb_strlen($duty_location) > 255) {
        echo json_encode(['ok' => false, 'msg' => 'Duty location is too long.']);
        exit;
    }

    // validate times
    if (!valid_time_or_empty($time_in) || !valid_time_or_empty($time_out)) {
        echo json_encode(['ok' => false, 'msg' => 'Invalid time format.']);
        exit;
    }

    // must have at least one time
    if ($time_in === '' && $time_out === '') {
        echo json_encode(['ok' => false, 'msg' => 'Please enter at least one time (In or Out).']);
        exit;
    }

    // if both present, out >= in
    if ($time_in !== '' && $time_out !== '') {
        if (strtotime($time_out) < strtotime($time_in)) {
            echo json_encode(['ok' => false, 'msg' => 'Time Out must be greater than or equal to Time In.']);
            exit;
        }
    }

    // Update
    $stmtU = $conn->prepare("
        UPDATE freedom_form
        SET `date` = ?, `day` = ?, guard_name = ?, duty_location = ?, duty_type = ?, time_in = ?, time_out = ?, form_user = ?
        WHERE id = ?
    ");
    if (!$stmtU) {
        echo json_encode(['ok' => false, 'msg' => 'Update failed.']);
        exit;
    }

    $stmtU->bind_param(
        "ssssssssi",
        $date,
        $day_to_save,
        $guard_name,
        $duty_location,
        $duty_type,
        $time_in,
        $time_out,
        $form_user,
        $id
    );

    if ($stmtU->execute()) {
        $stmtU->close();
        echo json_encode(['ok' => true, 'msg' => 'Record updated successfully!']);
        exit;
    } else {
        $stmtU->close();
        echo json_encode(['ok' => false, 'msg' => 'Update failed.']);
        exit;
    }
}

/* ----------------- Pre-fill form values ----------------- */
$valDate     = (string)$record['date'];
$valDay      = (string)$record['day'];
$valGuard    = (string)$record['guard_name'];
$valLocation = (string)$record['duty_location'];
$valDutyType = (string)$record['duty_type'];
$valIn       = timeForInput($record['time_in']);
$valOut      = timeForInput($record['time_out']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Edit Freedom Record</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f6fa;
        }

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

        .dash-card {
            border: 1px solid #e7ebf2;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 14px 36px rgba(15, 23, 42, .08);
            overflow: hidden;
        }

        .dash-header {
            background: linear-gradient(90deg, #0e6ba8, #1f7a8c);
            color: #fff;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .dash-header h6 {
            margin: 0;
            font-weight: 700;
            letter-spacing: .2px;
        }

        .panel {
            border: 1px solid #adb5bd;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 14px 28px rgba(15, 23, 42, .08), 0 0 0 1px rgba(231, 235, 242, .75);
        }

        .panel-pad {
            padding: 14px;
        }

        label {
            font-size: 12px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .form-control,
        .form-select {
            border: 1px solid #d6dde8;
            border-radius: 12px;
            height: 38px;
            font-size: 13px !important;
            padding: 6px 10px;
        }

        .btn-sq {
            border-radius: 2px !important;
            font-weight: 800;
            font-size: 11px;
            padding: 6px 8px;
        }

        .btn-save {
            background: #0e6ba8;
            border: 1px solid #0e6ba8;
            color: #fff;
        }

        .btn-save:hover {
            background: #0b5e95;
            border-color: #0b5e95;
            color: #fff;
        }

        .is-invalid {
            border: 1.5px solid red !important;
            background-color: #fff0f0;
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

        .btn-cancel,
        .btn-cancel:hover {
            border-radius: 20px;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .btn-form,
        .btn-form:hover {
            background-color: #0e6ba8;
            border-radius: 20px;
            color: white;
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

            <div class="container-fluid mt-4">
                <div class="row justify-content-center">
                    <div class="col-12 col-xl-11">

                        <div class="dash-card">
                            <div class="dash-header">
                                <h6>Edit Freedom Record (Ref# <?php echo (int)$record['id']; ?>)</h6>
                                <div class="d-flex gap-2">
                                    <a href="freedom_home.php" class="btn btn-light btn-sm btn-sq">
                                        <i class="fa-solid fa-home"></i> Home
                                    </a>
                                </div>
                            </div>

                            <div class="p-3 p-md-4">
                                <div class="panel panel-pad">
                                    <form id="editForm" method="POST" autocomplete="off">
                                        <div class="row g-3 align-items-end">

                                            <div class="col-12 col-md-3">
                                                <label>Date</label>
                                                <input type="date" class="form-control" id="date" name="date" value="<?php echo h($valDate); ?>">
                                            </div>

                                            <div class="col-12 col-md-3">
                                                <label>Day</label>
                                                <input type="text" class="form-control" id="day_ui" value="<?php echo h($valDay); ?>" readonly>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label>Guard Name</label>
                                                <select class="form-select" id="guard_name" name="guard_name">
                                                    <?php foreach ($guardOptions as $g): ?>
                                                        <?php
                                                        $nm = (string)$g['name'];
                                                        $st = (int)$g['status'];
                                                        $label = $nm . ($st === 1 ? " (Active)" : " (Inactive)");
                                                        ?>
                                                        <option value="<?php echo h($nm); ?>" <?php echo ($valGuard === $nm ? 'selected' : ''); ?>>
                                                            <?php echo h($label); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label>Duty Location</label>
                                                <input type="text" class="form-control" id="duty_location" name="duty_location"
                                                    value="<?php echo h($valLocation); ?>" placeholder="Enter duty location">
                                                <small class="text-danger d-none" id="err_loc"></small>
                                            </div>

                                            <div class="col-12 col-md-3">
                                                <label>Duty Type</label>
                                                <select class="form-select" id="duty_type" name="duty_type">
                                                    <option value="Day" <?php echo ($valDutyType === 'Day' ? 'selected' : ''); ?>>Day</option>
                                                    <option value="Night" <?php echo ($valDutyType === 'Night' ? 'selected' : ''); ?>>Night</option>
                                                    <option value="24Hour" <?php echo ($valDutyType === '24Hour' ? 'selected' : ''); ?>>24Hour</option>
                                                </select>
                                            </div>

                                            <div class="col-12 col-md-3">
                                                <label>Time In</label>
                                                <input type="time" class="form-control" id="time_in" name="time_in" value="<?php echo h($valIn); ?>">
                                                <small class="text-danger d-none" id="err_in"></small>
                                            </div>

                                            <div class="col-12 col-md-3">
                                                <label>Time Out</label>
                                                <input type="time" class="form-control" id="time_out" name="time_out" value="<?php echo h($valOut); ?>">
                                                <small class="text-danger d-none" id="err_out"></small>
                                            </div>

                                            <!-- <div class="col-12 col-md-12 d-flex align-items-end justify-content-end gap-2">
                                            <button type="submit" class="btn btn-save btn-sq">
                                                <i class="fa-solid fa-floppy-disk"></i> Save Changes
                                            </button>
                                        </div> -->

                                            <div class="text-center mt-4">
                                                <button type="submit" name="update" class="btn btn-form px-4">
                                                    Update
                                                </button>

                                                <a href="freedom_record_list.php" class="btn btn-secondary btn-cancel">
                                                    Cancel
                                                </a>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div><!-- card -->

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

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

            const dateEl = document.getElementById("date");
            const dayUI = document.getElementById("day_ui");

            function updateDayFromDate(v) {
                if (!v) return;
                const dt = new Date(v + "T00:00:00");
                const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                dayUI.value = days[dt.getDay()];
            }

            if (dateEl) {
                dateEl.addEventListener("change", function() {
                    updateDayFromDate(dateEl.value);
                });
            }

            const form = document.getElementById("editForm");
            const inEl = document.getElementById("time_in");
            const outEl = document.getElementById("time_out");
            const locEl = document.getElementById("duty_location");

            const errIn = document.getElementById("err_in");
            const errOut = document.getElementById("err_out");
            const errLoc = document.getElementById("err_loc");

            function isValidTime(v) {
                if (!v) return true;
                return /^([01]\d|2[0-3]):[0-5]\d$/.test(v);
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

            function validateAll() {
                let ok = true;

                clearError(inEl, errIn);
                clearError(outEl, errOut);
                clearError(locEl, errLoc);

                const vin = (inEl.value || "").trim();
                const vout = (outEl.value || "").trim();
                const vloc = (locEl.value || "").trim();

                if (!dateEl.value || dateEl.value.length !== 10) {
                    showToast("toast-warning", "Please select a valid date.");
                    ok = false;
                }

                if (!vloc) {
                    setError(locEl, errLoc, "Duty location is required.");
                    ok = false;
                } else if (vloc.length > 255) {
                    setError(locEl, errLoc, "Max 255 characters.");
                    ok = false;
                }

                if (!isValidTime(vin)) {
                    setError(inEl, errIn, "Invalid time.");
                    ok = false;
                }
                if (!isValidTime(vout)) {
                    setError(outEl, errOut, "Invalid time.");
                    ok = false;
                }

                if (ok && !vin && !vout) {
                    showToast("toast-warning", "Please enter at least one time (In or Out).");
                    ok = false;
                }

                if (ok && vin && vout) {
                    const inM = parseInt(vin.slice(0, 2)) * 60 + parseInt(vin.slice(3, 5));
                    const outM = parseInt(vout.slice(0, 2)) * 60 + parseInt(vout.slice(3, 5));
                    if (outM < inM) {
                        setError(outEl, errOut, "Time Out must be >= Time In.");
                        ok = false;
                    }
                }

                return ok;
            }

            // live validate
            [inEl, outEl, locEl].forEach(x => x.addEventListener("change", validateAll));
            [inEl, outEl, locEl].forEach(x => x.addEventListener("keyup", validateAll));
            if (dateEl) dateEl.addEventListener("change", validateAll);

            form.addEventListener("submit", async function(e) {
                e.preventDefault();
                if (!validateAll()) return;

                try {
                    const fd = new FormData(form);
                    fd.append("ajax", "1");

                    const res = await fetch(window.location.href, {
                        method: "POST",
                        body: fd
                    });
                    const data = await res.json();

                    if (data.ok) {
                        showToast("toast-success", data.msg || "Updated!");
                        setTimeout(() => {
                            window.location.href = "freedom_record_list.php";
                        }, 900);
                    } else {
                        showToast("toast-error", data.msg || "Update failed!");
                    }
                } catch (err) {
                    showToast("toast-error", "Network error!");
                }
            });

        });
    </script>

</body>

</html>