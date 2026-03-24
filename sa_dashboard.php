<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$head_email = $_SESSION['head_email'] ?? '';

include 'dbconfig.php';
date_default_timezone_set("Asia/Karachi");

// ------------------------
// Get batch_no
// ------------------------
$batch_no = isset($_GET['batch_no']) ? trim((string)$_GET['batch_no']) : '';
$batch_no_safe = mysqli_real_escape_string($conn, $batch_no);

// ------------------------
// Helpers
// ------------------------
function formatSecondsToHoursMinutes($totalSeconds)
{
    $totalSeconds = max(0, (int)$totalSeconds);
    $hours = floor($totalSeconds / 3600);
    $minutes = floor(($totalSeconds % 3600) / 60);
    return "{$hours}h {$minutes}m";
}

function safeDiffSeconds($start, $end)
{
    $s = strtotime($start);
    $e = strtotime($end);
    if (!$s || !$e) return 0;
    if ($e <= $s) return 0;
    return (int)($e - $s);
}

function dayNumberFromString($dayStr)
{
    if (!$dayStr) return null;
    if (preg_match('/(\d+)/', $dayStr, $m)) return (int)$m[1];
    return null;
}

function statusBadgeClass($s)
{
    $s = strtolower(trim((string)$s));
    if ($s === 'approved' || $s === 'approve') return 'bg-success';
    if ($s === 'rejected' || $s === 'reject') return 'bg-danger';
    if ($s === 'pending') return 'bg-warning text-dark';
    if ($s === '') return 'bg-secondary';
    return 'bg-primary';
}

// ------------------------
// Fetch all rows for batch (ONCE)
// ------------------------
$rows = [];
$sql = "SELECT * FROM staff_allocation WHERE batch_no = '$batch_no_safe' ORDER BY id ASC";
$res = mysqli_query($conn, $sql);
if ($res) {
    while ($r = mysqli_fetch_assoc($res)) {
        $rows[] = $r;
    }
}

$totalRecords = count($rows);
$lastRow = $totalRecords ? $rows[$totalRecords - 1] : null;

// ------------------------
// Build Day Data + Stats in one pass
// ✅ 40 workers for ALL days
// ------------------------
$daysData = [];  // daysData[dayNo] = [rows...]
$dayStats = [];  // dayStats[dayNo] = calc stats

$overallWorkers = 0;
$overallSeconds = 0;
$overallDowntimeSeconds = 0;
$overallPacking = 0;
$overallElectricity = 0;

foreach ($rows as $row) {
    $dayNo = dayNumberFromString($row['day'] ?? '');
    if (!$dayNo) continue;

    $daysData[$dayNo][] = $row;

    if (!isset($dayStats[$dayNo])) {
        $dayStats[$dayNo] = [
            'workers' => 0,
            'seconds' => 0,
            'dt_seconds' => 0,
            'packing' => 0,
            'electricity' => 0,
        ];
    }

    $maxWorkers = 40;

    for ($i = 1; $i <= $maxWorkers; $i++) {
        if (!empty($row["name_$i"])) {
            $overallWorkers++;
            $dayStats[$dayNo]['workers']++;
        }

        $sec1 = safeDiffSeconds($row["checkin_$i"] ?? '', $row["checkout_$i"] ?? '');
        $sec2 = safeDiffSeconds($row["checkin_{$i}_2"] ?? '', $row["checkout_{$i}_2"] ?? '');

        $overallSeconds += ($sec1 + $sec2);
        $dayStats[$dayNo]['seconds'] += ($sec1 + $sec2);
    }

    for ($j = 1; $j <= 3; $j++) {
        $dtSec = safeDiffSeconds($row["dt{$j}_start"] ?? '', $row["dt{$j}_end"] ?? '');
        $overallDowntimeSeconds += $dtSec;
        $dayStats[$dayNo]['dt_seconds'] += $dtSec;
    }

    $packKey = "packing_unit$dayNo";
    $elecKey = "electricity$dayNo";
    if (!array_key_exists($packKey, $row)) $packKey = "packing_unit1";
    if (!array_key_exists($elecKey, $row)) $elecKey = "electricity1";

    $packVal = (isset($row[$packKey]) && is_numeric($row[$packKey])) ? (float)$row[$packKey] : 0;
    $elecVal = (isset($row[$elecKey]) && is_numeric($row[$elecKey])) ? (float)$row[$elecKey] : 0;

    $dayStats[$dayNo]['packing'] += $packVal;
    $dayStats[$dayNo]['electricity'] += $elecVal;

    for ($k = 1; $k <= 4; $k++) {
        $overallPacking += (isset($row["packing_unit$k"]) && is_numeric($row["packing_unit$k"])) ? (float)$row["packing_unit$k"] : 0;
        $overallElectricity += (isset($row["electricity$k"]) && is_numeric($row["electricity$k"])) ? (float)$row["electricity$k"] : 0;
    }
}

ksort($daysData);
$existingDays = array_keys($daysData);
sort($existingDays);
$totalDays = count($existingDays);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Staff Allocation Dashboard</title>

    <?php include 'cdncss.php'; ?>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
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

        /* ✅ Base theme */
        :root {
            --bg-body: #f1f3f5;
            /* light grey body */
            --card: #ffffff;
            /* white panels */
            --border: #d7dbe0;
            --shadow: 0 6px 18px rgba(17, 24, 39, 0.08);
            --shadow2: 0 2px 10px rgba(17, 24, 39, 0.06);

            /* ✅ Requested colors */
            --overall-bg: #2ec4b6;
            /* overall summary */
            --day-bg: #cbf3f0;
            /* day cards */
        }

        body {
            font-family: "Poppins", sans-serif;
            background: #e9ecef !important;
            color: #111827;
        }

        .btn-back {
            font-size: 11px !important;
            padding: 4px 10px !important;
            border-radius: 6px !important;
        }

        /* Header panel */
        .page-topbar {
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: var(--card);
            box-shadow: var(--shadow2);
        }

        .topbar-row {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 10px;
        }

        .page-title {
            font-size: 18px;
            font-weight: 900;
            margin: 8px 0 0 0;
            letter-spacing: .2px;
            text-align: center;
        }

        /* Chips grid (kept your pill style) */
        .chips-grid {
            margin-top: 12px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        @media (max-width: 992px) {
            .chips-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 576px) {
            .chips-grid {
                grid-template-columns: 1fr;
            }
        }

        .chip {
            background: #BCCCDC;
            color: #111827;
            border: 1px solid #d7dbe0;
            font-size: 12px;
            font-weight: 800;
            border-radius: 999px;
            padding: 6px 10px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            box-shadow: var(--shadow2);
        }

        .chip i {
            opacity: .85;
        }

        /* ✅ Summary cards base */
        .summary-card {
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: var(--shadow2);
            padding: 12px;
            background: var(--card);
        }

        /* ✅ Overall Summary: #2ec4b6 + white text */
        .summary-card.overall {
            background: #EDDCC6 !important;
            border-color: #EDDCC6 !important;
            color: black !important;
        }

        .summary-card.overall h6,
        .summary-card.overall .kv .k,
        .summary-card.overall .kv .v {
            color: black !important;
        }

        /* ✅ Day cards: #cbf3f0 + black text */
        .summary-card.day {
            background: #d6e3f8 !important;
            border-color: #d6e3f8 !important;
            color: black !important;
        }

        .summary-card.day h6,
        .summary-card.day .kv .k,
        .summary-card.day .kv .v {
            color: #111827 !important;
        }

        .summary-card h6 {
            font-size: 13px;
            font-weight: 900;
            margin: 0 0 10px 0;
            color: #111827;
        }

        .kv {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            font-size: 12px;
            margin: 6px 0;
        }

        .kv .k {
            color: #374151;
            font-weight: 800;
        }

        .kv .v {
            font-weight: 900;
            color: #111827;
        }

        /* Tabs */
        .nav-tabs .nav-link {
            font-size: 12px;
            font-weight: 900;
            border-radius: 12px 12px 0 0;
        }

        .nav-tabs .nav-link.active {
            background: #0d9276 !important;
            color: #fff !important;
            border-color: #0d9276 !important;
        }

        /* Table wrap */
        .day-table-wrap {
            max-height: 70vh;
            overflow: auto;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: var(--card);
            box-shadow: var(--shadow);
        }

        .day-table {
            min-width: 1400px;
            margin: 0;
            background: var(--card);
        }

        .day-table th,
        .day-table td {
            font-size: 11px !important;
        }

        .day-table thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            background: #023e8a !important;
            font-weight: 700;
            color: #fff !important;
            white-space: nowrap;
            border: none !important
        }

        .day-table td {
            vertical-align: top;
            background: var(--card) !important;
        }

        .col-remarks {
            min-width: 420px !important;
            white-space: normal;
        }

        .col-job {
            min-width: 240px !important;
        }

        /* Section cards */
        .section-card {
            border: 1px solid var(--border);
            border-radius: 14px;
            background: var(--card);
            box-shadow: var(--shadow2);
            padding: 12px;
        }

        .section-title {
            font-size: 13px;
            font-weight: 900;
            margin: 0 0 10px 0;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #111827;
        }

        .dt-row {
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 10px;
            margin-bottom: 10px;
            background: #f8f9fa;
        }

        .small-label {
            font-size: 11px;
            font-weight: 900;
            color: #6b7280;
        }

        .small-val {
            font-size: 12px;
            font-weight: 900;
            color: #111827;
        }

        /* Approvals */
        .approval-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        @media (max-width: 768px) {
            .approval-grid {
                grid-template-columns: 1fr;
            }
        }

        .approval-card {
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 12px;
            background: var(--card);
            box-shadow: var(--shadow2);
        }

        .approval-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .approval-head .name {
            font-size: 13px;
            font-weight: 900;
            margin: 0;
            color: #111827;
        }

        .meta {
            font-size: 12px;
            margin: 4px 0;
            color: #374151;
        }

        .meta strong {
            font-weight: 900;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar1.php'; ?>

        <div id="content">
            <!-- navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-menu">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn-menu">
                        <i class="fas fa-align-left"></i> <span>Menu</span>
                    </button>
                </div>
            </nav>

            <div class="container-fluid">

                <!-- Top header -->
                <div class="page-topbar mb-3 mt-2">


                    <div class="d-flex align-items-center">

                        <!-- Left: Back Button -->
                        <a href="sa_dashboard_list.php" class="btn btn-dark btn-back">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>

                        <!-- Center: Heading -->
                        <div class="flex-grow-1 text-center">
                            <p class="page-title m-0">Staff Allocation Dashboard</p>
                        </div>

                    </div>





                    <?php if ($lastRow): ?>
                        <div class="chips-grid">
                            <div class="chip"><i class="fa-solid fa-box"></i> Product: <?php echo htmlspecialchars($lastRow['product'] ?? ''); ?></div>
                            <div class="chip"><i class="fa-solid fa-hashtag"></i> Batch: <?php echo htmlspecialchars($lastRow['batch_no'] ?? ''); ?></div>
                            <div class="chip"><i class="fa-solid fa-layer-group"></i> Size: <?php echo htmlspecialchars($lastRow['batch_size'] ?? ''); ?></div>
                            <div class="chip"><i class="fa-solid fa-gears"></i> Process: <?php echo htmlspecialchars($lastRow['process'] ?? ''); ?></div>
                            <div class="chip"><i class="fa-solid fa-user"></i> Incharge: <?php echo htmlspecialchars($lastRow['incharge'] ?? ''); ?></div>
                        </div>
                    <?php else: ?>
                        <div class="text-danger fw-bold mt-2">No records found for batch: <?php echo htmlspecialchars($batch_no); ?></div>
                    <?php endif; ?>
                </div>

                <div class="row g-3">
                    <!-- LEFT SUMMARY -->
                    <div class="col-lg-4">

                        <div class="summary-card overall mb-3">
                            <h6 class="mb-2"><i class="fa-solid fa-chart-column me-1"></i> Overall Summary</h6>
                            <div class="kv">
                                <div class="k">Total Days</div>
                                <div class="v"><?php echo (int)$totalDays; ?></div>
                            </div>
                            <div class="kv">
                                <div class="k">Total Workers</div>
                                <div class="v"><?php echo (int)$overallWorkers; ?></div>
                            </div>
                            <div class="kv">
                                <div class="k">Total Time Spent</div>
                                <div class="v"><?php echo htmlspecialchars(formatSecondsToHoursMinutes($overallSeconds)); ?></div>
                            </div>
                            <div class="kv">
                                <div class="k">Total Downtime</div>
                                <div class="v"><?php echo htmlspecialchars(formatSecondsToHoursMinutes($overallDowntimeSeconds)); ?></div>
                            </div>
                            <div class="kv">
                                <div class="k">Total Packing Unit</div>
                                <div class="v"><?php echo number_format((float)$overallPacking, 2); ?></div>
                            </div>
                            <div class="kv">
                                <div class="k">Total Electricity</div>
                                <div class="v"><?php echo number_format((float)$overallElectricity, 2); ?></div>
                            </div>
                        </div>

                        <h6 class="text-danger mb-2" style="font-size:14px;font-weight:700;">
                            <i class="fa-solid fa-calendar-days me-1"></i> Day-wise Summary
                        </h6>

                        <?php if (empty($existingDays)): ?>
                            <div class="alert alert-warning">No day-wise data found.</div>
                        <?php else: ?>
                            <?php foreach ($existingDays as $d):
                                $st = $dayStats[$d];
                            ?>
                                <!-- ✅ FIX: use summary-card day -->
                                <div class="summary-card day mb-2">
                                    <h6 class="mb-2">Day <?php echo (int)$d; ?></h6>
                                    <div class="kv">
                                        <div class="k">Workers</div>
                                        <div class="v"><?php echo (int)$st['workers']; ?></div>
                                    </div>
                                    <div class="kv">
                                        <div class="k">Time Spent</div>
                                        <div class="v"><?php echo htmlspecialchars(formatSecondsToHoursMinutes($st['seconds'])); ?></div>
                                    </div>
                                    <div class="kv">
                                        <div class="k">Downtime</div>
                                        <div class="v"><?php echo htmlspecialchars(formatSecondsToHoursMinutes($st['dt_seconds'])); ?></div>
                                    </div>
                                    <div class="kv">
                                        <div class="k">Packing</div>
                                        <div class="v"><?php echo number_format((float)$st['packing'], 2); ?></div>
                                    </div>
                                    <div class="kv">
                                        <div class="k">Electricity</div>
                                        <div class="v"><?php echo number_format((float)$st['electricity'], 2); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- RIGHT DETAILS -->
                    <div class="col-lg-8">
                        <h6 class="text-danger mb-2" style="font-size:14px;font-weight:700;">
                            <i class="fa-solid fa-table me-1"></i> Day-wise Details
                        </h6>

                        <?php if (empty($daysData)): ?>
                            <div class="alert alert-warning">No day-wise data found for this batch.</div>
                        <?php else: ?>

                            <!-- Tabs -->
                            <ul class="nav nav-tabs" id="dayTabs" role="tablist">
                                <?php $first = true;
                                foreach ($daysData as $dayNo => $drows): ?>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?php echo $first ? 'active' : ''; ?>"
                                            id="day-<?php echo (int)$dayNo; ?>-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#day-<?php echo (int)$dayNo; ?>"
                                            type="button"
                                            role="tab"
                                            aria-controls="day-<?php echo (int)$dayNo; ?>"
                                            aria-selected="<?php echo $first ? 'true' : 'false'; ?>">
                                            Day <?php echo (int)$dayNo; ?>
                                        </button>
                                    </li>
                                <?php $first = false;
                                endforeach; ?>
                            </ul>

                            <div class="tab-content" id="dayTabsContent">
                                <?php $first = true;
                                foreach ($daysData as $dayNo => $drows): ?>
                                    <div class="tab-pane fade <?php echo $first ? 'show active' : ''; ?>"
                                        id="day-<?php echo (int)$dayNo; ?>"
                                        role="tabpanel"
                                        aria-labelledby="day-<?php echo (int)$dayNo; ?>-tab">

                                        <?php foreach ($drows as $row): ?>

                                            <div class="day-table-wrap mt-3">
                                                <table class="table table-bordered day-table">
                                                    <thead>
                                                        <tr>
                                                            <th style="min-width:220px;">Name</th>
                                                            <th style="min-width:110px;">Emp ID</th>
                                                            <th class="col-job">Job</th>
                                                            <th style="min-width:140px;">Check-In</th>
                                                            <th style="min-width:140px;">Check-Out</th>
                                                            <th style="min-width:140px;">Check-In</th>
                                                            <th style="min-width:140px;">Check-Out</th>
                                                            <th class="col-remarks">Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $maxWorkers = 40;
                                                        for ($i = 1; $i <= $maxWorkers; $i++):
                                                            if (!empty($row["name_$i"])):
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo htmlspecialchars($row["name_$i"]); ?></td>
                                                                    <td><?php echo htmlspecialchars($row["id_$i"]); ?></td>
                                                                    <td><?php echo htmlspecialchars($row["jobs_$i"]); ?></td>
                                                                    <td><?php echo htmlspecialchars($row["checkin_$i"]); ?></td>
                                                                    <td><?php echo htmlspecialchars($row["checkout_$i"]); ?></td>
                                                                    <td><?php echo htmlspecialchars($row["checkin_{$i}_2"]); ?></td>
                                                                    <td><?php echo htmlspecialchars($row["checkout_{$i}_2"]); ?></td>
                                                                    <td class="col-remarks"><?php echo nl2br(htmlspecialchars($row["remarks_$i"])); ?></td>
                                                                </tr>
                                                        <?php
                                                            endif;
                                                        endfor;
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="section-card mt-3">
                                                <div class="section-title">
                                                    <i class="fa-regular fa-circle-pause"></i> Machine Downtime
                                                </div>

                                                <?php
                                                $hasDowntime = false;
                                                for ($j = 1; $j <= 3; $j++) {
                                                    $st = trim((string)($row["dt{$j}_start"] ?? ''));
                                                    $en = trim((string)($row["dt{$j}_end"] ?? ''));
                                                    $cm = trim((string)($row["dt{$j}_comment"] ?? ''));

                                                    if ($st !== '' || $en !== '' || $cm !== '') {
                                                        $hasDowntime = true;
                                                        $sec = safeDiffSeconds($st, $en);
                                                        $dur = $sec > 0 ? formatSecondsToHoursMinutes($sec) : '—';
                                                ?>
                                                        <div class="dt-row">
                                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                                <div class="small-val">Downtime <?php echo $j; ?></div>
                                                                <span class="badge bg-dark"><?php echo htmlspecialchars($dur); ?></span>
                                                            </div>

                                                            <div class="row g-2">
                                                                <div class="col-md-3">
                                                                    <div class="small-label">Start</div>
                                                                    <div class="small-val"><?php echo htmlspecialchars($st !== '' ? $st : '—'); ?></div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="small-label">End</div>
                                                                    <div class="small-val"><?php echo htmlspecialchars($en !== '' ? $en : '—'); ?></div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="small-label">Reason</div>
                                                                    <div class="small-val"><?php echo htmlspecialchars($cm !== '' ? $cm : '—'); ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php
                                                    }
                                                }

                                                if (!$hasDowntime) {
                                                    echo '<div class="text-muted" style="font-size:12px;font-weight:800;">No downtime recorded.</div>';
                                                }
                                                ?>
                                            </div>

                                            <div class="section-card mt-3">
                                                <div class="section-title">
                                                    <i class="fa-regular fa-circle-check"></i> Approvals
                                                </div>

                                                <div class="approval-grid">
                                                    <?php
                                                    $hs = $row['head_status'] ?? '';
                                                    $hd = $row['head_date'] ?? '';
                                                    $hm = $row['head_msg'] ?? '';
                                                    ?>
                                                    <div class="approval-card">
                                                        <div class="approval-head">
                                                            <p class="name">Head Approval</p>
                                                            <span class="badge <?php echo statusBadgeClass($hs); ?>">
                                                                <?php echo htmlspecialchars($hs !== '' ? $hs : 'N/A'); ?>
                                                            </span>
                                                        </div>
                                                        <div class="meta"><strong>Date:</strong> <?php echo htmlspecialchars($hd !== '' ? $hd : '—'); ?></div>
                                                        <div class="meta"><strong>Message:</strong> <?php echo htmlspecialchars($hm !== '' ? $hm : '—'); ?></div>
                                                    </div>

                                                    <?php
                                                    $fs = $row['fpna_status'] ?? '';
                                                    $fd = $row['fpna_date'] ?? '';
                                                    $fm = $row['fpna_msg'] ?? '';
                                                    ?>
                                                    <div class="approval-card">
                                                        <div class="approval-head">
                                                            <p class="name">Finance Approval</p>
                                                            <span class="badge <?php echo statusBadgeClass($fs); ?>">
                                                                <?php echo htmlspecialchars($fs !== '' ? $fs : 'N/A'); ?>
                                                            </span>
                                                        </div>
                                                        <div class="meta"><strong>Date:</strong> <?php echo htmlspecialchars($fd !== '' ? $fd : '—'); ?></div>
                                                        <div class="meta"><strong>Message:</strong> <?php echo htmlspecialchars($fm !== '' ? $fm : '—'); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php endforeach; ?>

                                    </div>
                                <?php $first = false;
                                endforeach; ?>
                            </div>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>

    <script>
        $(function() {
            $('#sidebar1').addClass('active');
            $('#sidebarCollapse').on('click', function() {
                $('#sidebarq').toggleClass('active');
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            function activateTabFromHash() {
                var hash = window.location.hash;
                if (!hash) return;
                var tabBtn = document.querySelector('[data-bs-target="' + hash + '"]');
                if (tabBtn) new bootstrap.Tab(tabBtn).show();
            }

            document.querySelectorAll('#dayTabs button[data-bs-toggle="tab"]').forEach(function(btn) {
                btn.addEventListener('shown.bs.tab', function(e) {
                    var target = e.target.getAttribute('data-bs-target');
                    if (target) history.replaceState(null, '', target);
                });
            });

            activateTabFromHash();
            window.addEventListener('hashchange', activateTabFromHash);
        });
    </script>
</body>

</html>