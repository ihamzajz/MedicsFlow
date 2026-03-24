<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

include 'dbconfig.php';

/* =========================================================
   AJAX endpoints for Select2 (no full preloading)
   - ?ajax=users&term=ali
   - ?ajax=roles&product=XYZ&term=pack
========================================================= */
if (isset($_GET['ajax'])) {
    header('Content-Type: application/json; charset=utf-8');

    $term = isset($_GET['term']) ? trim((string)$_GET['term']) : '';
    $termLike = '%' . $term . '%';

    $LIMIT = 50;

    if ($_GET['ajax'] === 'users') {
        $sql = "SELECT emp_id, fullname
                FROM users
                WHERE sa_user='yes' AND fullname LIKE ?
                ORDER BY fullname
                LIMIT $LIMIT";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $termLike);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        $out = [];
        while ($r = mysqli_fetch_assoc($res)) {
            $out[] = [
                "id" => (string)($r['fullname'] ?? ''),
                "text" => (string)($r['fullname'] ?? ''),
                "emp_id" => (string)($r['emp_id'] ?? '')
            ];
        }
        mysqli_stmt_close($stmt);

        echo json_encode(["results" => $out]);
        exit;
    }

    if ($_GET['ajax'] === 'roles') {
        $product = isset($_GET['product']) ? trim((string)$_GET['product']) : '';
        $productSafe = $product; // prepared stmt

        $sql = "SELECT role
                FROM staff_allo_pro
                WHERE product = ? AND role LIKE ?
                ORDER BY role
                LIMIT $LIMIT";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $productSafe, $termLike);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        $out = [];
        while ($r = mysqli_fetch_assoc($res)) {
            $role = (string)($r['role'] ?? '');
            $out[] = ["id" => $role, "text" => $role];
        }
        mysqli_stmt_close($stmt);

        echo json_encode(["results" => $out]);
        exit;
    }

    echo json_encode(["results" => []]);
    exit;
}

/* =========================================================
   Normal page logic
========================================================= */
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) die("Invalid ID");

// Fetch record
$stmt = mysqli_prepare($conn, "SELECT * FROM staff_allocation WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = $res ? mysqli_fetch_assoc($res) : null;
mysqli_stmt_close($stmt);

if (!$row) die("No record found!");

// Helpers
$getVal = function ($key) use (&$row) {
    return array_key_exists($key, $_POST) ? $_POST[$key] : ($row[$key] ?? '');
};
$esc = function ($v) use ($conn) {
    return mysqli_real_escape_string($conn, (string)$v);
};

/* =========================================================
   AJAX submit (HEAD EDIT) - Toast + No Reload
========================================================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    $isAjax = isset($_POST['ajax_submit']) && $_POST['ajax_submit'] === '1';

    if ($isAjax) {
        header('Content-Type: application/json; charset=utf-8');
    }

    $setParts = [];

    // 40 staff rows
    for ($i = 1; $i <= 40; $i++) {
        $fields = [
            "sno_$i",
            "name_$i",
            "id_$i",
            "jobs_$i",
            "checkin_$i",
            "checkout_$i",
            "checkin_{$i}_2",
            "checkout_{$i}_2",
            "remarks_$i",
        ];

        foreach ($fields as $f) {
            $val = $esc($getVal($f));
            $setParts[] = "$f = '$val'";
        }
    }

    // Downtime mapping
    $dt1_start   = $esc($_POST['down_time1_start'] ?? ($row['dt1_start'] ?? ''));
    $dt1_end     = $esc($_POST['down_time1_end']   ?? ($row['dt1_end'] ?? ''));
    $dt1_comment = $esc($_POST['dt1_comment']      ?? ($row['dt1_comment'] ?? ''));

    $dt2_start   = $esc($_POST['down_time2_start'] ?? ($row['dt2_start'] ?? ''));
    $dt2_end     = $esc($_POST['down_time2_end']   ?? ($row['dt2_end'] ?? ''));
    $dt2_comment = $esc($_POST['dt2_comment']      ?? ($row['dt2_comment'] ?? ''));

    $dt3_start   = $esc($_POST['down_time3_start'] ?? ($row['dt3_start'] ?? ''));
    $dt3_end     = $esc($_POST['down_time3_end']   ?? ($row['dt3_end'] ?? ''));
    $dt3_comment = $esc($_POST['dt3_comment']      ?? ($row['dt3_comment'] ?? ''));

    $setParts[] = "dt1_start = '$dt1_start'";
    $setParts[] = "dt1_end = '$dt1_end'";
    $setParts[] = "dt1_comment = '$dt1_comment'";

    $setParts[] = "dt2_start = '$dt2_start'";
    $setParts[] = "dt2_end = '$dt2_end'";
    $setParts[] = "dt2_comment = '$dt2_comment'";

    $setParts[] = "dt3_start = '$dt3_start'";
    $setParts[] = "dt3_end = '$dt3_end'";
    $setParts[] = "dt3_comment = '$dt3_comment'";

    // Packing units (1..5)
    for ($d = 1; $d <= 5; $d++) {
        $k = "packing_unit$d";
        $setParts[] = "$k = '" . $esc($getVal($k)) . "'";
    }

    // Electricity (1..5)
    for ($d = 1; $d <= 5; $d++) {
        $k = "electricity$d";
        $setParts[] = "$k = '" . $esc($getVal($k)) . "'";
    }

    $update_query = "UPDATE staff_allocation SET " . implode(", ", $setParts) . " WHERE id = $id";
    $result = mysqli_query($conn, $update_query);

    if ($isAjax) {
        echo json_encode([
            "ok" => (bool)$result,
            "type" => $result ? "success" : "danger",
            "title" => $result ? "Updated" : "Failed",
            "msg" => $result ? "Data updated successfully." : ("Update Failed: " . mysqli_error($conn))
        ]);
        exit;
    }

    // fallback
    if ($result) {
        echo "<script>alert('Data updated successfully.'); window.location.href=window.location.href;</script>";
    } else {
        echo "<script>alert('Update Failed: " . addslashes(mysqli_error($conn)) . "'); window.location.href=window.location.href;</script>";
    }
    exit;
}

// Determine visible rows: 5,10,15... based on filled rows
$filled = 0;
for ($i = 1; $i <= 40; $i++) {
    $keys = ["name_$i", "id_$i", "jobs_$i", "checkin_$i", "checkout_$i", "checkin_{$i}_2", "checkout_{$i}_2", "remarks_$i"];
    $hasAny = false;
    foreach ($keys as $k) {
        if (trim((string)($row[$k] ?? '')) !== '') {
            $hasAny = true;
            break;
        }
    }
    if ($hasAny) $filled++;
}
$visibleRows = max(5, (int)(ceil($filled / 5) * 5));
if ($visibleRows > 40) $visibleRows = 40;

$productVal = (string)($row['product'] ?? '');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Staff Allocation - Head Edit</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />

    <?php include 'cdncss.php' ?>
    <?php include 'sidebarcss.php'; ?>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Poppins', sans-serif !important;
            background: #c7ccdb !important;
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

        .card {
            border-radius: 16px;
        }

        .btn {
            font-weight: 500 !important;
            font-size: 13px !important;
        }

        .topbar-card .card-body {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }

        .title-center {
            flex: 1;
            text-align: center;
            font-weight: 800;
            color: #111827;
            font-size: 16px;
            margin: 0;
        }

        .title-spacer {
            width: 92px;
        }

        label {
            font-size: 11.5px !important;
            font-weight: 700;
            color: #495057;
        }

        /* FORCE ALL INPUTS + SELECTS TO 28px */
        input,
        select,
        .form-control,
        .form-select {
            height: 28px !important;
            min-height: 28px !important;
            padding: 2px 8px !important;
            font-size: 12px !important;
            border-radius: 8px !important;
        }

        input[readonly] {
            background: #f8fafc !important;
        }

        .form-control-sm,
        .form-select-sm {
            height: 28px !important;
            min-height: 28px !important;
            padding: 2px 8px !important;
        }

        /* TABLE */
        .table-responsive.dt-wrap {
            max-height: 90vh;
            overflow: auto;
            border-radius: 14px;
            border: 1px solid #d8dee6;
            background: #fff;
        }

        .table-responsive.dt-wrap table {
            width: max-content;
            min-width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-responsive.dt-wrap thead th {
            position: sticky;
            top: 0;
            z-index: 5;
            white-space: nowrap;
            font-size: 11.5px;
            border: none !important;
            background-color: #3a506b !important;
            color: white !important;
            font-weight: 600;
            padding: 10px 12px !important;
        }

        .table-responsive.dt-wrap tbody td {
            font-size: 11px;
            font-weight: 400;
            vertical-align: middle;
            white-space: nowrap;
            padding: 6px 8px !important;
            border-bottom: 1px solid #e5e7eb !important;
        }

        .table-responsive.dt-wrap tbody tr:nth-child(even) td {
            background: #fbfdff;
        }

        .table-responsive.dt-wrap tbody tr:hover td {
            background: #f8fbff;
        }

        /* Ensure table inputs also 28px */
        .dt-wrap input,
        .dt-wrap select,
        .dt-wrap .form-control,
        .dt-wrap .form-select {
            height: 28px !important;
            min-height: 28px !important;
            padding: 2px 6px !important;
        }

        /* COLUMN WIDTHS */
        th.col-clear,
        td.col-clear {
            width: 60px;
        }

        th.col-sno,
        td.col-sno {
            width: 60px;
        }

        th.col-name,
        td.col-name {
            min-width: 260px;
        }

        th.col-emp,
        td.col-emp {
            width: 110px;
        }

        th.col-jobs,
        td.col-jobs {
            min-width: 220px;
        }

        th.col-t,
        td.col-t {
            width: 120px;
        }

        th.col-rem,
        td.col-rem {
            min-width: 260px;
        }

        .btn-icon {
            width: 28px;
            height: 28px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .row-hidden {
            display: none;
        }

        .mint-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            background: #d1fae5;
            color: #065f46;
            font-weight: 700;
            font-size: 12px;
            border: 1px solid #a7f3d0;
        }

        .mint-badge i {
            color: #0f766e;
        }

        /* SELECT2 FORCED TO 28px */
        .select2-container--default .select2-selection--single {
            height: 28px !important;
            min-height: 28px !important;
            border-radius: 8px !important;
            border: 1px solid #ced4da !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px !important;
            font-size: 12px !important;
            padding-left: 8px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px !important;
        }

        .select2-results__option {
            font-size: 12px !important;
        }

        .box1-heading {
            font-weight: 800 !important;
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

            <div class="container-fluid py-3">
                <div class="container-xxl">

                    <!-- 1) Header -->
                    <div class="card shadow-sm border-0 mb-3 topbar-card">
                        <div class="card-body">
                            <a href="sa_forms" class="btn btn-dark btn-sm">
                                <i class="fa-solid fa-home me-1"></i> Home
                            </a>
                            <a href="sa_head_list.php" class="btn btn-secondary btn-sm">
                                <i class="fa-solid fa-list me-1"></i> Back
                            </a>

                            <h4 class="title-center">Staff Allocation - Head Edit</h4>
                            <div class="title-spacer"></div>
                        </div>
                    </div>

                    <!-- 2) Batch Details -->
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body">
                            <h6 class="box1-heading mb-3"><i class="fa-solid fa-circle-info me-2"></i>Batch Details</h6>

                            <div class="row g-2">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold small">Product</label>
                                    <input class="form-control form-control-sm" type="text" value="<?= htmlspecialchars($row['product'] ?? '') ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold small">Department</label>
                                    <input class="form-control form-control-sm" type="text" value="<?= htmlspecialchars($row['department'] ?? '') ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold small">Batch Size</label>
                                    <input class="form-control form-control-sm" type="text" value="<?= htmlspecialchars($row['batch_size'] ?? '') ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold small">Batch No</label>
                                    <input class="form-control form-control-sm" type="text" value="<?= htmlspecialchars($row['batch_no'] ?? '') ?>" readonly>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-bold small">Pack Size</label>
                                    <input class="form-control form-control-sm" type="text" value="<?= htmlspecialchars($row['pack_size'] ?? '') ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold small">Process</label>
                                    <input class="form-control form-control-sm" type="text" value="<?= htmlspecialchars($row['process'] ?? '') ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold small">Incharge</label>
                                    <input class="form-control form-control-sm" type="text" value="<?= htmlspecialchars($row['incharge'] ?? '') ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold small">Date</label>
                                    <input class="form-control form-control-sm" type="text" value="<?= htmlspecialchars($row['date'] ?? '') ?>" readonly>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-bold small">Day</label>
                                    <input class="form-control form-control-sm" type="text" value="<?= htmlspecialchars($row['day'] ?? '') ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FORM -->
                    <form method="POST" id="staffForm">

                        <!-- 3) Table -->
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-body">

                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                    <h6 class="box1-heading mb-0">
                                        <i class="fa-solid fa-table me-2"></i>Staff Details
                                    </h6>

                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <div class="mint-badge" id="rowsBadge">
                                            <i class="fa-solid fa-list"></i> Showing <?= (int)$visibleRows ?>/40 Rows
                                        </div>

                                        <button type="button" class="btn btn-primary btn-sm" id="btnAdd5"
                                            data-visible="<?= (int)$visibleRows ?>">
                                            <i class="fa-solid fa-plus me-1"></i> Add 5 more
                                        </button>
                                    </div>
                                </div>

                                <div class="table-responsive dt-wrap">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th class="col-clear">Clear</th>
                                                <th class="col-sno">Sno#</th>
                                                <th class="col-name">Name</th>
                                                <th class="col-emp">Emp#</th>
                                                <th class="col-jobs">Jobs</th>
                                                <th class="col-t">Check-In</th>
                                                <th class="col-t">Check-Out</th>
                                                <th class="col-t">Check-In</th>
                                                <th class="col-t">Check-Out</th>
                                                <th class="col-rem">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for ($i = 1; $i <= 40; $i++): ?>
                                                <?php
                                                $snoKey       = "sno_$i";
                                                $nameKey      = "name_$i";
                                                $idKey        = "id_$i";
                                                $jobsKey      = "jobs_$i";
                                                $checkinKey   = "checkin_$i";
                                                $checkoutKey  = "checkout_$i";
                                                $checkin2Key  = "checkin_{$i}_2";
                                                $checkout2Key = "checkout_{$i}_2";
                                                $remarksKey   = "remarks_$i";

                                                $snoVal       = $row[$snoKey] ?? '';
                                                $nameVal      = $row[$nameKey] ?? '';
                                                $idVal        = $row[$idKey] ?? '';
                                                $jobsVal      = $row[$jobsKey] ?? '';
                                                $checkinVal   = $row[$checkinKey] ?? '';
                                                $checkoutVal  = $row[$checkoutKey] ?? '';
                                                $checkin2Val  = $row[$checkin2Key] ?? '';
                                                $checkout2Val = $row[$checkout2Key] ?? '';
                                                $remarksVal   = $row[$remarksKey] ?? '';

                                                $hiddenClass = ($i > $visibleRows) ? 'row-hidden' : '';
                                                ?>
                                                <tr id="row_<?= $i ?>" class="<?= $hiddenClass ?>" data-row="<?= $i ?>">
                                                    <td class="col-clear">
                                                        <button type="button" class="btn btn-danger btn-sm btn-icon" onclick="clearRow(<?= $i ?>)" title="Clear row">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </button>
                                                    </td>

                                                    <td class="col-sno">
                                                        <input type="text" class="form-control form-control-sm" name="sno_<?= $i ?>" id="sno_<?= $i ?>"
                                                            value="<?= htmlspecialchars($snoVal) ?>">
                                                    </td>

                                                    <td class="col-name">
                                                        <select class="form-select form-select-sm w-100 sel-name"
                                                            name="name_<?= $i ?>" id="name_<?= $i ?>">
                                                            <option value=""></option>
                                                            <?php if (trim((string)$nameVal) !== ''): ?>
                                                                <option value="<?= htmlspecialchars($nameVal) ?>" selected><?= htmlspecialchars($nameVal) ?></option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </td>

                                                    <td class="col-emp">
                                                        <input type="text" class="form-control form-control-sm" name="id_<?= $i ?>" id="id_<?= $i ?>"
                                                            value="<?= htmlspecialchars($idVal) ?>">
                                                    </td>

                                                    <td class="col-jobs">
                                                        <select class="form-select form-select-sm w-100 sel-jobs"
                                                            name="jobs_<?= $i ?>" id="jobs_<?= $i ?>">
                                                            <option value=""></option>
                                                            <?php if (trim((string)$jobsVal) !== ''): ?>
                                                                <option value="<?= htmlspecialchars($jobsVal) ?>" selected><?= htmlspecialchars($jobsVal) ?></option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </td>

                                                    <td class="col-t"><input type="time" class="form-control form-control-sm" name="checkin_<?= $i ?>" id="checkin_<?= $i ?>" value="<?= htmlspecialchars($checkinVal) ?>"></td>
                                                    <td class="col-t"><input type="time" class="form-control form-control-sm" name="checkout_<?= $i ?>" id="checkout_<?= $i ?>" value="<?= htmlspecialchars($checkoutVal) ?>"></td>
                                                    <td class="col-t"><input type="time" class="form-control form-control-sm" name="checkin_<?= $i ?>_2" id="checkin_<?= $i ?>_2" value="<?= htmlspecialchars($checkin2Val) ?>"></td>
                                                    <td class="col-t"><input type="time" class="form-control form-control-sm" name="checkout_<?= $i ?>_2" id="checkout_<?= $i ?>_2" value="<?= htmlspecialchars($checkout2Val) ?>"></td>

                                                    <td class="col-rem">
                                                        <input type="text" class="form-control form-control-sm" name="remarks_<?= $i ?>" id="remarks_<?= $i ?>"
                                                            value="<?= htmlspecialchars($remarksVal) ?>">
                                                    </td>
                                                </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <!-- 4) Downtime -->
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-body">
                                <h6 class="box1-heading mb-3"><i class="fa-regular fa-circle-pause me-2"></i>Machine Downtime</h6>

                                <div class="row g-2 align-items-end mb-2">
                                    <div class="col-lg-2 col-md-3 col-6">
                                        <label class="form-label fw-bold small">DT 1 Start</label>
                                        <input type="time" class="form-control form-control-sm" name="down_time1_start" value="<?= htmlspecialchars($row['dt1_start'] ?? '') ?>">
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-6">
                                        <label class="form-label fw-bold small">DT 1 End</label>
                                        <input type="time" class="form-control form-control-sm" name="down_time1_end" value="<?= htmlspecialchars($row['dt1_end'] ?? '') ?>">
                                    </div>
                                    <div class="col-lg-8 col-md-6 col-12">
                                        <label class="form-label fw-bold small">DT 1 Comment</label>
                                        <input type="text" class="form-control form-control-sm" name="dt1_comment" placeholder="Enter comment" value="<?= htmlspecialchars($row['dt1_comment'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="row g-2 align-items-end mb-2">
                                    <div class="col-lg-2 col-md-3 col-6">
                                        <label class="form-label fw-bold small">DT 2 Start</label>
                                        <input type="time" class="form-control form-control-sm" name="down_time2_start" value="<?= htmlspecialchars($row['dt2_start'] ?? '') ?>">
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-6">
                                        <label class="form-label fw-bold small">DT 2 End</label>
                                        <input type="time" class="form-control form-control-sm" name="down_time2_end" value="<?= htmlspecialchars($row['dt2_end'] ?? '') ?>">
                                    </div>
                                    <div class="col-lg-8 col-md-6 col-12">
                                        <label class="form-label fw-bold small">DT 2 Comment</label>
                                        <input type="text" class="form-control form-control-sm" name="dt2_comment" placeholder="Enter comment" value="<?= htmlspecialchars($row['dt2_comment'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="row g-2 align-items-end">
                                    <div class="col-lg-2 col-md-3 col-6">
                                        <label class="form-label fw-bold small">DT 3 Start</label>
                                        <input type="time" class="form-control form-control-sm" name="down_time3_start" value="<?= htmlspecialchars($row['dt3_start'] ?? '') ?>">
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-6">
                                        <label class="form-label fw-bold small">DT 3 End</label>
                                        <input type="time" class="form-control form-control-sm" name="down_time3_end" value="<?= htmlspecialchars($row['dt3_end'] ?? '') ?>">
                                    </div>
                                    <div class="col-lg-8 col-md-6 col-12">
                                        <label class="form-label fw-bold small">DT 3 Comment</label>
                                        <input type="text" class="form-control form-control-sm" name="dt3_comment" placeholder="Enter comment" value="<?= htmlspecialchars($row['dt3_comment'] ?? '') ?>">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- 5) Totals (SHOW ALL DAYS) -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-body">
                                        <h6 class="box1-heading mb-2"><i class="fa-solid fa-box me-2"></i>Total Unit Pack (All Days)</h6>

                                        <?php for ($d = 1; $d <= 5; $d++): ?>
                                            <div class="mb-2">
                                                <label class="form-label fw-bold small">Unit Pack Day <?= $d ?></label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="packing_unit<?= $d ?>"
                                                    maxlength="6" pattern="\d{1,6}" title="Enter up to 6 digits"
                                                    value="<?= htmlspecialchars($row["packing_unit$d"] ?? '') ?>">
                                            </div>
                                        <?php endfor; ?>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-body">
                                        <h6 class="box1-heading mb-2"><i class="fa-solid fa-bolt me-2"></i>Total Electricity Unit (All Days)</h6>

                                        <?php for ($d = 1; $d <= 5; $d++): ?>
                                            <div class="mb-2">
                                                <label class="form-label fw-bold small">Electricity Unit Day <?= $d ?></label>
                                                <input type="number" class="form-control form-control-sm"
                                                    name="electricity<?= $d ?>"
                                                    value="<?= htmlspecialchars($row["electricity$d"] ?? '') ?>">
                                            </div>
                                        <?php endfor; ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-body d-flex justify-content-center gap-2 flex-wrap">
                                <button type="submit" name="submit" class="btn btn-success btn-sm">
                                    <i class="fa-solid fa-floppy-disk me-1"></i> Update
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Toast container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 99999;">
        <div id="liveToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong id="toastTitle">Done</strong><br>
                    <span id="toastMsg">Saved</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        const PRODUCT_VAL = <?= json_encode($productVal) ?>;

        // Sidebar
        $(document).ready(function() {
            $('#sidebar1').addClass('active');
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar1').toggleClass('active');
            });
        });

        // Clear row (clears Select2 properly, including preselected option)
        function clearRow(i) {
            const row = document.getElementById('row_' + i);
            if (!row) return;

            // clear all inputs
            row.querySelectorAll('input').forEach(inp => {
                inp.value = '';
            });

            // clear all selects (Select2)
            row.querySelectorAll('select').forEach(sel => {
                const $sel = window.jQuery ? jQuery(sel) : null;

                // ensure empty option exists
                if (!sel.querySelector('option[value=""]')) {
                    const emptyOpt = document.createElement('option');
                    emptyOpt.value = '';
                    emptyOpt.textContent = '';
                    sel.insertBefore(emptyOpt, sel.firstChild);
                }

                // remove all non-empty options (removes preselected option from PHP)
                Array.from(sel.options).forEach(opt => {
                    if (opt.value !== '') opt.remove();
                });

                // set blank
                sel.value = '';

                // refresh select2 UI if initialized
                if ($sel && $sel.data('select2')) {
                    $sel.val('').trigger('change.select2');
                } else {
                    sel.selectedIndex = 0;
                }
            });
        }

        // AJAX Select2 init for a specific row
        function initSelect2ForRow(i) {
            const $name = $('#name_' + i);
            const $jobs = $('#jobs_' + i);

            // Name: live search users
            if ($name.length && !$name.data('select2')) {
                $name.select2({
                    placeholder: "Search name...",
                    allowClear: true,
                    width: '100%',
                    minimumInputLength: 1,
                    ajax: {
                        url: window.location.pathname + window.location.search
                            .replace(/([&?])ajax=[^&]*/g, '')
                            .replace(/[?&]$/, '') +
                            (window.location.search.includes('?') ? '&' : '?') + 'ajax=users',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                term: params.term || ''
                            };
                        },
                        processResults: function(data) {
                            return data;
                        },
                        cache: true
                    }
                });

                // When selected: set emp id + sno
                $name.on('select2:select', function(e) {
                    const d = e.params.data || {};
                    const empId = d.emp_id || '';
                    $('#id_' + i).val(empId);
                    $('#sno_' + i).val(i);
                });

                // When cleared
                $name.on('select2:clear', function() {
                    $('#id_' + i).val('');
                    $('#sno_' + i).val('');
                });
            }

            // Jobs: live search roles by product
            if ($jobs.length && !$jobs.data('select2')) {
                $jobs.select2({
                    placeholder: "Search jobs...",
                    allowClear: true,
                    width: '100%',
                    minimumInputLength: 0,
                    ajax: {
                        url: function() {
                            const base = window.location.pathname + window.location.search
                                .replace(/([&?])ajax=[^&]*/g, '')
                                .replace(/[?&]$/, '');
                            return base + (base.includes('?') ? '&' : '?') + 'ajax=roles';
                        },
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                term: params.term || '',
                                product: PRODUCT_VAL
                            };
                        },
                        processResults: function(data) {
                            return data;
                        },
                        cache: true
                    }
                });
            }
        }

        function initSelect2UpTo(n) {
            for (let i = 1; i <= n; i++) initSelect2ForRow(i);
        }

        function setVisibleRows(n) {
            n = Math.max(5, Math.min(40, n));

            for (let i = 1; i <= 40; i++) {
                const tr = document.getElementById('row_' + i);
                if (!tr) continue;
                if (i <= n) tr.classList.remove('row-hidden');
                else tr.classList.add('row-hidden');
            }

            $('#rowsBadge').html('<i class="fa-solid fa-list"></i> Showing ' + n + '/40 Rows');
            $('#btnAdd5').attr('data-visible', n);

            // init select2 only for visible rows
            initSelect2UpTo(n);

            if (n >= 40) {
                $('#btnAdd5').prop('disabled', true).html('<i class="fa-solid fa-check me-1"></i> All rows shown');
            } else {
                $('#btnAdd5').prop('disabled', false).html('<i class="fa-solid fa-plus me-1"></i> Add 5 more');
            }
        }

        // Toast helper
        function showToast(type, title, msg) {
            const toastEl = document.getElementById('liveToast');
            const tTitle = document.getElementById('toastTitle');
            const tMsg = document.getElementById('toastMsg');

            toastEl.classList.remove('text-bg-success', 'text-bg-danger', 'text-bg-warning', 'text-bg-info');
            toastEl.classList.add('text-bg-' + (type || 'success'));

            tTitle.textContent = title || 'Done';
            tMsg.textContent = msg || '';

            const toast = bootstrap.Toast.getOrCreateInstance(toastEl, {
                delay: 2500
            });
            toast.show();
        }

        $(document).ready(function() {
            const initialVisible = parseInt($('#btnAdd5').attr('data-visible') || '5', 10);
            setVisibleRows(initialVisible);

            $('#btnAdd5').on('click', function() {
                const current = parseInt($(this).attr('data-visible') || '5', 10);
                setVisibleRows(current + 5);
            });

            // AJAX submit (no reload)
            $('#staffForm').on('submit', function(e) {
                e.preventDefault();

                const fd = new FormData(this);
                fd.set('submit', '1');
                fd.set('ajax_submit', '1');

                fetch(window.location.href, {
                        method: 'POST',
                        body: fd
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data && data.ok) {
                            showToast(data.type || 'success', data.title || 'Updated', data.msg || '');
                        } else {
                            showToast((data && data.type) ? data.type : 'danger', (data && data.title) ? data.title : 'Failed', (data && data.msg) ? data.msg : 'Something went wrong.');
                        }
                    })
                    .catch(() => {
                        showToast('danger', 'Failed', 'Network error. Please try again.');
                    });
            });
        });
    </script>

    <script src="assets/js/main.js"></script>
</body>

</html>
