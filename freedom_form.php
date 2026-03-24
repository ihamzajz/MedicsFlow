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

    $date = trim($_POST['date'] ?? '');

    // Arrays keyed by guard_id (recommended)
    $t_in  = $_POST['time_in'] ?? [];
    $t_out = $_POST['time_out'] ?? [];

    // Validate date format YYYY-MM-DD
    $ok = true;
    $d = DateTime::createFromFormat('Y-m-d', $date);
    if (!$d || $d->format('Y-m-d') !== $date) $ok = false;

    // Day to save in DB (based on selected date)
    $day_to_save = $ok ? date('l', strtotime($date)) : '';

    // Fetch active guards from DB (source of truth)
    $guards = [];
    $res = $conn->query("
        SELECT id, name, duty_location, duty_type
        FROM freedom_guards
        WHERE status = 1
        ORDER BY name ASC
    ");
    if ($res) {
        while ($row = $res->fetch_assoc()) $guards[] = $row;
        $res->free();
    }

    if (count($guards) === 0) {
        echo json_encode(['ok'=>false,'msg'=>'No active guards found. Please add guards first.']);
        exit;
    }

    // Helper validators
    function valid_time_or_empty($v) {
        $v = trim((string)$v);
        if ($v === '') return true; // allow empty
        return (bool)preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $v); // HH:MM
    }

    // Build rows to insert:
    // - In/Out optional
    // - If both provided, out >= in
    // - Insert 1 record per guard IF at least one of in/out filled
    $rowsToInsert = [];
    foreach ($guards as $g) {
        $gid = (int)$g['id'];

        $in  = isset($t_in[$gid])  ? trim($t_in[$gid])  : '';
        $out = isset($t_out[$gid]) ? trim($t_out[$gid]) : '';

        if (!valid_time_or_empty($in) || !valid_time_or_empty($out)) {
            $ok = false;
            break;
        }

        if ($in !== '' && $out !== '') {
            if (strtotime($out) < strtotime($in)) {
                $ok = false;
                break;
            }
        }

        if ($in !== '' || $out !== '') {
            $rowsToInsert[] = [
                $date,
                $day_to_save,
                $gid,
                $g['name'],
                $g['duty_location'],
                $g['duty_type'],
                $in,
                $out,
                $form_user
            ];
        }
    }

    // Must submit at least one time anywhere
    if ($ok && count($rowsToInsert) === 0) {
        $ok = false;
    }

    if (!$ok) {
        echo json_encode(['ok'=>false,'msg'=>'Please enter at least one guard time. (Invalid time or Out earlier than In is not allowed)']);
        exit;
    }

    // Insert rows (multiple records) INCLUDING day column
    $stmt = $conn->prepare("
        INSERT INTO freedom_form
            (`date`, `day`, guard_id, guard_name, duty_location, duty_type, time_in, time_out, form_user)
        VALUES
            (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        echo json_encode(['ok'=>false,'msg'=>'Form submission failed!']);
        exit;
    }

    $conn->begin_transaction();
    try {
        foreach ($rowsToInsert as $r) {
            // date, day, gid, name, location, type, in, out, user
            $stmt->bind_param("ssissssss", $r[0], $r[1], $r[2], $r[3], $r[4], $r[5], $r[6], $r[7], $r[8]);
            if (!$stmt->execute()) {
                throw new Exception("Insert failed");
            }
        }
        $conn->commit();
        $stmt->close();

        echo json_encode(['ok'=>true,'msg'=>'Freedom form has been submitted!']);
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        $stmt->close();
        echo json_encode(['ok'=>false,'msg'=>'Form submission failed!']);
        exit;
    }
}

// --- For GET render ---
$today_db  = date('Y-m-d');
$today_day = date('l');

// Fetch active guards for showing in UI
$guards = [];
$res = $conn->query("
    SELECT id, name, duty_location, duty_type
    FROM freedom_guards
    WHERE status = 1
    ORDER BY name ASC
");
if ($res) {
    while ($row = $res->fetch_assoc()) $guards[] = $row;
    $res->free();
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
        input:focus { outline: none; border: 1px solid black; }
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

        /* ===== Compact header inputs ===== */
        .top-fields{
            background:#fff;
            border:1px solid #e5e7eb;
            border-radius:12px;
            padding:10px;
            box-shadow: 0 10px 22px rgba(0,0,0,.06);
        }
        .top-fields input{
            height: 28px !important;
            padding: 4px 8px !important;
        }

        /* ===== Interactive Row UI (1 line per guard) ===== */
        .t-row{
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 10px 12px;
            box-shadow: 0 10px 22px rgba(0,0,0,.06);
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
        }
        .t-left{
            min-width: 320px;
            display:flex;
            align-items:center;
            gap:10px;
        }
        .t-num{
            width:34px;
            height:34px;
            border-radius:999px;
            display:flex;
            align-items:center;
            justify-content:center;
            background: linear-gradient(135deg, #dbeafe, #c7d2fe);
            border: 1px solid #e5e7eb;
            color:#0f172a;
            font-weight:900;
            font-size:13px;
            flex:0 0 auto;
        }
        .t-name{
            font-weight:800;
            font-size:13px;
            color:#0f172a;
            line-height:1.2;
        }
        .t-meta{
            font-size:12px;
            color:#334155;
            margin-top:2px;
            font-weight:600;
        }
        .t-meta span{
            display:inline-block;
            margin-right:10px;
        }

        .t-right{
            display:flex;
            align-items:center;
            gap:10px;
            flex-wrap:wrap;
            justify-content:flex-end;
        }
        .time-group{
            display:flex;
            align-items:center;
            gap:8px;
            background:#e5e7eb;
            border:1px solid #cbd5e1;
            border-radius:12px;
            padding:6px 8px;
        }
        .time-label{
            font-size:11px;
            font-weight:800;
            color:#334155;
            padding:0 6px;
            border-right:1px solid #cbd5e1;
            white-space:nowrap;
        }
        .time-input{
            width:130px !important;
            height:28px !important;
            padding:4px 8px !important;
            border-radius:10px !important;
            border:1px solid #94a3b8 !important;
            background:#f8fafc !important;
        }
        .time-input:focus{
            border:1px solid #0e6ba8 !important;
            background-color:#FFF4B5 !important;
        }
        .t-errors{
            display:flex;
            gap:10px;
            justify-content:flex-end;
            margin-top:6px;
        }
        .t-errors small{
            display:block;
            font-size:11.5px;
            margin-left:auto;
        }
        .row-gap-compact{ gap:10px; }
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

                    <form class="form pb-3" method="POST" autocomplete="off" id="freedomForm">
                        <div class="card shadow">
                            <div class="card-header bg-header text-white d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Freedom Form</h6>
                                <a href="freedom_home.php" class="btn btn-light btn-sm">
                                    <i class="fa-solid fa-home"></i> Home
                                </a>
                            </div>

                            <div class="card-body">

                                <!-- ===== Date (editable) + Day (readonly) ===== -->
                                <div class="top-fields mb-3">
                                    <div class="row g-2 align-items-end">
                                        <div class="col-md-4">
                                            <label class="form-label labelf">Date</label>
                                            <input type="date" id="date_picker" value="<?php echo htmlspecialchars($today_db); ?>">
                                            <input type="hidden" id="date" name="date" value="<?php echo htmlspecialchars($today_db); ?>">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label labelf">Day</label>
                                            <input type="text" id="day_ui" value="<?php echo htmlspecialchars($today_day); ?>" readonly>
                                        </div>
                                    </div>
                                </div>

                                <?php if (count($guards) === 0): ?>
                                    <div class="alert alert-warning mb-0">
                                        No active guards found. Please add records in <b>freedom_guards</b> (status = 1).
                                    </div>
                                <?php else: ?>

                                    <div class="d-flex flex-column row-gap-compact">
                                        <?php $num = 1; foreach ($guards as $g):
                                            $gid = (int)$g['id'];
                                            $name = $g['name'];
                                            $loc  = $g['duty_location'];
                                            $type = $g['duty_type'];
                                        ?>
                                            <div class="col-12">
                                                <div class="t-row">
                                                    <div class="t-left">
                                                        <div class="t-num"><?php echo $num; ?></div>
                                                        <div>
                                                            <div class="t-name"><?php echo htmlspecialchars($name); ?></div>
                                                            <div class="t-meta">
                                                                <span><i class="fa-solid fa-location-dot me-1"></i><?php echo htmlspecialchars($loc); ?></span>
                                                                <span><i class="fa-solid fa-shield-halved me-1"></i><?php echo htmlspecialchars($type); ?></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="t-right">
                                                        <div class="time-group">
                                                            <span class="time-label"><i class="fa-solid fa-right-to-bracket me-1"></i>In</span>
                                                            <input
                                                                class="time-input"
                                                                type="time"
                                                                name="time_in[<?php echo $gid; ?>]"
                                                                id="time_in_<?php echo $gid; ?>"
                                                            >
                                                        </div>

                                                        <div class="time-group">
                                                            <span class="time-label"><i class="fa-solid fa-right-from-bracket me-1"></i>Out</span>
                                                            <input
                                                                class="time-input"
                                                                type="time"
                                                                name="time_out[<?php echo $gid; ?>]"
                                                                id="time_out_<?php echo $gid; ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="t-errors">
                                                    <small class="text-danger d-none" id="err_in_<?php echo $gid; ?>"></small>
                                                    <small class="text-danger d-none" id="err_out_<?php echo $gid; ?>"></small>
                                                </div>
                                            </div>
                                        <?php $num++; endforeach; ?>
                                    </div>

                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-form px-4" id="submitBtn">Submit</button>
                                    </div>

                                <?php endif; ?>

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

    const form = document.getElementById("freedomForm");
    const submitBtn = document.getElementById("submitBtn");
    if (!form || !submitBtn) return;

    // ===== Date change updates hidden date + day (readonly) =====
    const datePicker = document.getElementById("date_picker");
    const hiddenDate = document.getElementById("date");
    const dayUI = document.getElementById("day_ui");

    function updateDayFromDate(v){
        if (!v) return;
        hiddenDate.value = v;

        const dt = new Date(v + "T00:00:00");
        const days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
        dayUI.value = days[dt.getDay()];
    }

    if (datePicker) {
        datePicker.addEventListener("change", function(){
            updateDayFromDate(datePicker.value);
        });
        updateDayFromDate(datePicker.value);
    }

    function isValidTime(v){
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

    function validateAll(){
        let ok = true;

        const inInputs = form.querySelectorAll('input[type="time"][name^="time_in["]');
        inInputs.forEach(inEl => {
            const nameKey = inEl.name;
            const key = nameKey.substring(8, nameKey.length - 1); // guard_id
            const outEl = form.querySelector('input[type="time"][name="time_out[' + CSS.escape(key) + ']"]');

            const idSuffix = (inEl.id || "").replace("time_in_", "");
            const inErr = document.getElementById("err_in_" + idSuffix);
            const outErr = document.getElementById("err_out_" + idSuffix);

            const vin = (inEl.value || "").trim();
            const vout = (outEl.value || "").trim();

            if (inErr) clearError(inEl, inErr);
            if (outErr) clearError(outEl, outErr);

            if (!isValidTime(vin)) { if(inErr) setError(inEl, inErr, "Invalid time."); ok = false; return; }
            if (!isValidTime(vout)) { if(outErr) setError(outEl, outErr, "Invalid time."); ok = false; return; }

            // Only rule: if both filled, Out must be >= In
            if (vin && vout) {
                const inM = parseInt(vin.slice(0,2))*60 + parseInt(vin.slice(3,5));
                const outM = parseInt(vout.slice(0,2))*60 + parseInt(vout.slice(3,5));
                if (outM < inM) {
                    if(outErr) setError(outEl, outErr, "Out must be >= In.");
                    ok = false;
                    return;
                }
            }
        });

        // Must fill at least one time anywhere
        const anyFilled = Array.from(form.querySelectorAll('input[type="time"]'))
            .some(x => (x.value || "").trim() !== "");
        if (!anyFilled) {
            showToast("toast-warning", "Please enter at least one guard time.");
            ok = false;
        }

        return ok;
    }

    // Live validation
    form.querySelectorAll('input[type="time"]').forEach(inp => {
        inp.addEventListener("change", () => validateAll());
    });

    // ===== AJAX submit =====
    form.addEventListener("submit", async function(e) {
        e.preventDefault();

        if (!validateAll()) return;

        submitBtn.disabled = true;

        try {
            const fd = new FormData(form);
            fd.append("ajax", "1");

            const res = await fetch(window.location.href, { method: "POST", body: fd });
            const data = await res.json();

            if (data.ok) {
                showToast("toast-success", data.msg || "Freedom form has been submitted!");
                form.querySelectorAll('input[type="time"]').forEach(x => x.value = "");
                form.querySelectorAll(".is-invalid").forEach(x => x.classList.remove("is-invalid"));
                form.querySelectorAll("small.text-danger").forEach(x => x.classList.add("d-none"));
            } else {
                showToast("toast-error", data.msg || "Form submission failed!");
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
