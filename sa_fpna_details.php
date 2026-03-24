<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$head_email = $_SESSION['head_email'] ?? '';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
$mail = new PHPMailer(true);

include 'dbconfig.php';

/* =========================================================
   Normal page logic
========================================================= */
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) die("Invalid ID");

// Fetch record (SAFE)
$stmt = mysqli_prepare($conn, "SELECT * FROM staff_allocation WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = $res ? mysqli_fetch_assoc($res) : null;
mysqli_stmt_close($stmt);

if (!$row) die("No record found!");

// Determine visible rows: 5,10,15... based on filled rows (FPNA table keys)
$filled = 0;
for ($i = 1; $i <= 40; $i++) {
    $keys = ["name_$i", "id_$i", "jobs_$i", "checkin_$i", "checkout_$i", "remarks_$i"];
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Staff Allocation - Finance Approval</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />

    <?php include 'cdncss.php'; ?>
    <?php include 'sidebarcss.php'; ?>

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

        /* =========================================================
           FORCE ALL INPUTS + SELECTS TO 28px
        ========================================================= */
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
            color: #111827 !important;
            opacity: 1 !important;
        }

        /* =========================================================
           TABLE STYLING (same as sa_head_details)
        ========================================================= */
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

        /* Column widths */
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
            width: 140px;
        }

        th.col-rem,
        td.col-rem {
            min-width: 260px;
        }

        .row-hidden {
            display: none;
        }

        .box1-heading {
            font-weight: 800 !important;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 12px;
            border: 1px solid transparent;
        }

        .pill-pending {
            background: #fff7ed;
            color: #9a3412;
            border-color: #fed7aa;
        }

        .pill-approved {
            background: #d1fae5;
            color: #065f46;
            border-color: #a7f3d0;
        }

        .pill-rejected {
            background: #fee2e2;
            color: #991b1b;
            border-color: #fecaca;
        }

        .mono-small {
            font-size: 12px !important;
            font-weight: 600;
            color: #374151;
            word-break: break-word;
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

                    <!-- Header -->
                    <div class="card shadow-sm border-0 mb-3 topbar-card">
                        <div class="card-body">
                            <a href="sa_forms" class="btn btn-dark btn-sm">
                                <i class="fa-solid fa-home me-1"></i> Home
                            </a>

                            <h5 class="title-center">Staff Allocation - Finance Approval</h5>
                            <div class="title-spacer"></div>
                        </div>
                    </div>

                    <!-- Batch Details -->
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body">
                            <h6 class="box1-heading mb-3">
                                <i class="fa-solid fa-circle-info me-2"></i>Batch Details
                            </h6>

                            <div class="row g-2">
                                <div class="col-md-3">
                                    <label class="form-label">Product</label>
                                    <input class="form-control form-control-sm" type="text" value="<?= htmlspecialchars($row['product'] ?? '') ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Department</label>
                                    <input class="form-control form-control-sm" type="text" value="<?= htmlspecialchars($row['department'] ?? '') ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Batch Size</label>
                                    <input class="form-control form-control-sm" type="text" value="<?= htmlspecialchars($row['batch_size'] ?? '') ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Batch No</label>
                                    <input class="form-control form-control-sm" type="text" value="<?= htmlspecialchars($row['batch_no'] ?? '') ?>" readonly>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Pack Size</label>
                                    <input class="form-control form-control-sm" type="text" value="<?= htmlspecialchars($row['pack_size'] ?? '') ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Process</label>
                                    <input class="form-control form-control-sm" type="text" value="<?= htmlspecialchars($row['process'] ?? '') ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Incharge</label>
                                    <input class="form-control form-control-sm" type="text" value="<?= htmlspecialchars($row['incharge'] ?? '') ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Date</label>
                                    <input class="form-control form-control-sm" type="text" value="<?= htmlspecialchars($row['date'] ?? '') ?>" readonly>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Day</label>
                                    <input class="form-control form-control-sm" type="text" value="<?= htmlspecialchars($row['day'] ?? '') ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Staff Details Table -->
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body">

                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                <h6 class="box1-heading mb-0">
                                    <i class="fa-solid fa-table me-2"></i>Staff Details
                                </h6>
                            </div>

                            <div class="table-responsive dt-wrap">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="col-sno">Sno#</th>
                                            <th class="col-name">Name</th>
                                            <th class="col-emp">Emp#</th>
                                            <th class="col-jobs">Jobs</th>
                                            <th class="col-t">Check-In</th>
                                            <th class="col-t">Check-Out</th>
                                            <th class="col-rem">Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for ($i = 1; $i <= 40; $i++): ?>
                                            <?php
                                            $snoKey      = "sno_$i";
                                            $nameKey     = "name_$i";
                                            $idKey       = "id_$i";
                                            $jobsKey     = "jobs_$i";
                                            $checkinKey  = "checkin_$i";
                                            $checkoutKey = "checkout_$i";
                                            $remarksKey  = "remarks_$i";

                                            $snoVal      = $row[$snoKey] ?? '';
                                            $nameVal     = $row[$nameKey] ?? '';
                                            $idVal       = $row[$idKey] ?? '';
                                            $jobsVal     = $row[$jobsKey] ?? '';
                                            $checkinVal  = $row[$checkinKey] ?? '';
                                            $checkoutVal = $row[$checkoutKey] ?? '';
                                            $remarksVal  = $row[$remarksKey] ?? '';

                                            $isEmptyRow = (trim((string)$nameVal) === '');
                                            $hiddenClass = ($i > $visibleRows || $isEmptyRow) ? 'row-hidden' : '';
                                            ?>
                                            <tr class="<?= $hiddenClass ?>">
                                                <td class="col-sno">
                                                    <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($snoVal) ?>" readonly>
                                                </td>
                                                <td class="col-name">
                                                    <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($nameVal) ?>" readonly>
                                                </td>
                                                <td class="col-emp">
                                                    <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($idVal) ?>" readonly>
                                                </td>
                                                <td class="col-jobs">
                                                    <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($jobsVal) ?>" readonly>
                                                </td>
                                                <td class="col-t">
                                                    <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($checkinVal) ?>" readonly>
                                                </td>
                                                <td class="col-t">
                                                    <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($checkoutVal) ?>" readonly>
                                                </td>
                                                <td class="col-rem">
                                                    <input type="text" class="form-control form-control-sm"
                                                        value="<?= htmlspecialchars($remarksVal) ?>"
                                                        title="<?= htmlspecialchars($remarksVal) ?>"
                                                        readonly>
                                                </td>
                                            </tr>
                                        <?php endfor; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                    <!-- Downtime -->
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body">
                            <h6 class="box1-heading mb-3"><i class="fa-regular fa-circle-pause me-2"></i>Machine Downtime</h6>

                            <div class="row g-2 align-items-end mb-2">
                                <div class="col-lg-2 col-md-3 col-6">
                                    <label class="form-label">DT 1 Start</label>
                                    <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($row['dt1_start'] ?? '') ?>" readonly>
                                </div>
                                <div class="col-lg-2 col-md-3 col-6">
                                    <label class="form-label">DT 1 End</label>
                                    <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($row['dt1_end'] ?? '') ?>" readonly>
                                </div>
                                <div class="col-lg-8 col-md-6 col-12">
                                    <label class="form-label">DT 1 Comment</label>
                                    <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($row['dt1_comment'] ?? '') ?>" readonly>
                                </div>
                            </div>

                            <div class="row g-2 align-items-end mb-2">
                                <div class="col-lg-2 col-md-3 col-6">
                                    <label class="form-label">DT 2 Start</label>
                                    <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($row['dt2_start'] ?? '') ?>" readonly>
                                </div>
                                <div class="col-lg-2 col-md-3 col-6">
                                    <label class="form-label">DT 2 End</label>
                                    <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($row['dt2_end'] ?? '') ?>" readonly>
                                </div>
                                <div class="col-lg-8 col-md-6 col-12">
                                    <label class="form-label">DT 2 Comment</label>
                                    <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($row['dt2_comment'] ?? '') ?>" readonly>
                                </div>
                            </div>

                            <div class="row g-2 align-items-end">
                                <div class="col-lg-2 col-md-3 col-6">
                                    <label class="form-label">DT 3 Start</label>
                                    <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($row['dt3_start'] ?? '') ?>" readonly>
                                </div>
                                <div class="col-lg-2 col-md-3 col-6">
                                    <label class="form-label">DT 3 End</label>
                                    <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($row['dt3_end'] ?? '') ?>" readonly>
                                </div>
                                <div class="col-lg-8 col-md-6 col-12">
                                    <label class="form-label">DT 3 Comment</label>
                                    <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($row['dt3_comment'] ?? '') ?>" readonly>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Totals -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body">
                                    <h6 class="box1-heading mb-2"><i class="fa-solid fa-box me-2"></i>Total Unit Pack</h6>

                                    <?php for ($d = 1; $d <= 5; $d++): ?>
                                        <?php if (($row['day'] ?? '') === "Day $d"): ?>
                                            <label class="form-label">Unit Pack Day <?= $d ?></label>
                                            <input type="text" class="form-control form-control-sm"
                                                value="<?= htmlspecialchars($row["packing_unit$d"] ?? '') ?>" readonly>
                                        <?php endif; ?>
                                    <?php endfor; ?>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body">
                                    <h6 class="box1-heading mb-2"><i class="fa-solid fa-bolt me-2"></i>Total Electricity Unit</h6>

                                    <?php for ($d = 1; $d <= 5; $d++): ?>
                                        <?php if (($row['day'] ?? '') === "Day $d"): ?>
                                            <label class="form-label">Electricity Unit Day <?= $d ?></label>
                                            <input type="text" class="form-control form-control-sm"
                                                value="<?= htmlspecialchars($row["electricity$d"] ?? '') ?>" readonly>
                                        <?php endif; ?>
                                    <?php endfor; ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Head Info -->
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body">
                            <h6 class="box1-heading mb-3"><i class="fa-solid fa-user-check me-2"></i>Head Approval Info</h6>

                            <?php
                            $hs = trim((string)($row['head_status'] ?? ''));
                            $pillClass = 'pill-pending';
                            if (strcasecmp($hs, 'Approved') === 0) $pillClass = 'pill-approved';
                            if (strcasecmp($hs, 'Rejected') === 0) $pillClass = 'pill-rejected';
                            ?>

                            <div class="row g-2">
                                <div class="col-md-3">
                                    <label class="form-label">Head Status</label><br>
                                    <span class="status-pill <?= $pillClass ?>">
                                        <i class="fa-solid fa-circle"></i> <?= htmlspecialchars($hs === '' ? 'Pending' : $hs) ?>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Head Date</label>
                                    <div class="mono-small"><?= htmlspecialchars($row['head_date'] ?? '-') ?></div>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Head Message</label>
                                    <div class="mono-small"><?= htmlspecialchars($row['head_msg'] ?? '-') ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body d-flex justify-content-center gap-2 flex-wrap">
                            <a href="sa_fpna_approve.php?id=<?= (int)$row['id'] ?>" class="btn btn-success btn-sm">
                                <i class="fa-solid fa-check"></i> Approve
                            </a>

                            <a href="#" class="btn btn-danger btn-sm" onclick="promptReason(<?= (int)$row['id'] ?>); return false;">
                                <i class="fa-solid fa-xmark"></i> Reject
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar: support both ids (#sidebar1 or #sidebar)
        $(document).ready(function() {
            var sidebarSel = $('#sidebar1').length ? '#sidebar1' : ($('#sidebar').length ? '#sidebar' : null);

            if (sidebarSel) {
                $(sidebarSel).addClass('active');
            }

            $('#sidebarCollapse').on('click', function() {
                if (sidebarSel) $(sidebarSel).toggleClass('active');
            });
        });

        function promptReason(itemId) {
            var reason = prompt("Enter reason for rejection:");
            if (reason != null && reason.trim() !== "") {
                window.location.href = "sa_fpna_reject.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
            }
        }
    </script>

    <script src="assets/js/main.js"></script>
</body>

</html>
