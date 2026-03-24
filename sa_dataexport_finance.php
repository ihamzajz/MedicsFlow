<?php
ob_start();
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

include 'dbconfig.php';

// ===== Session =====
$fullname   = $_SESSION['fullname'] ?? '';
$be_depart  = $_SESSION['be_depart'] ?? '';
$bc_role    = $_SESSION['be_role'] ?? '';

// =========================================================
// Tabs (server-side) so page DOES NOT flash wrong tab
// =========================================================
$tab = isset($_GET['tab']) ? trim((string)$_GET['tab']) : 'one';
if ($tab !== 'one' && $tab !== 'two') $tab = 'one';

// =========================================================
// TAB 1: Server-side pagination + filters + export
// =========================================================
$perPage = 50;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$qRaw       = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
$productRaw = isset($_GET['product']) ? trim((string)$_GET['product']) : '';
$fromDate   = isset($_GET['fromDate']) ? trim((string)$_GET['fromDate']) : '';
$toDate     = isset($_GET['toDate']) ? trim((string)$_GET['toDate']) : '';

$whereParts = ["1=1"];

// Product filter
if ($productRaw !== '') {
    $pSafe = mysqli_real_escape_string($conn, $productRaw);
    $whereParts[] = "product = '{$pSafe}'";
}

// Date range (works for DATE or DATETIME)
if ($fromDate !== '') {
    $fd = mysqli_real_escape_string($conn, $fromDate);
    $whereParts[] = "DATE(`date`) >= '{$fd}'";
}
if ($toDate !== '') {
    $td = mysqli_real_escape_string($conn, $toDate);
    $whereParts[] = "DATE(`date`) <= '{$td}'";
}

// Search (base columns only, fast)
if ($qRaw !== '') {
    $q = mysqli_real_escape_string($conn, $qRaw);
    $like = "%{$q}%";
    $whereParts[] = "(
        CAST(id AS CHAR) LIKE '{$like}'
        OR department LIKE '{$like}'
        OR batch_size LIKE '{$like}'
        OR product LIKE '{$like}'
        OR batch_no LIKE '{$like}'
        OR incharge LIKE '{$like}'
        OR `date` LIKE '{$like}'
    )";
}

$whereSql = implode(" AND ", $whereParts);

// Count (pagination count based on staff_allocation records)
$countSql = "SELECT COUNT(*) AS total FROM staff_allocation WHERE {$whereSql}";
$countQ = mysqli_query($conn, $countSql);
$countRow = mysqli_fetch_assoc($countQ);
$totalRows = (int)($countRow['total'] ?? 0);
$totalPages = ($totalRows > 0) ? (int)ceil($totalRows / $perPage) : 1;

if ($page > $totalPages) $page = $totalPages;
$offset = ($page - 1) * $perPage;

// Products dropdown
$products = [];
$prodQ = mysqli_query($conn, "SELECT DISTINCT product FROM staff_allo_pro ORDER BY product ASC");
if ($prodQ) {
    while ($r = mysqli_fetch_assoc($prodQ)) {
        $products[] = (string)($r['product'] ?? '');
    }
}

// Helper: build page url preserving filters + tab
function pageUrl($p)
{
    $params = $_GET;
    $params['page'] = $p;
    $path = strtok($_SERVER["REQUEST_URI"], '?');
    return $path . '?' . http_build_query($params);
}

// Helpers for working hours formatting
function formatHMS($total_seconds)
{
    if ($total_seconds < 0) $total_seconds = 0;
    $h = floor($total_seconds / 3600);
    $m = floor(($total_seconds % 3600) / 60);
    $s = $total_seconds % 60;
    return $h . "h" . str_pad((string)$m, 2, "0", STR_PAD_LEFT) . "m" . str_pad((string)$s, 2, "0", STR_PAD_LEFT) . "s";
}

function secondsBetween($start, $end)
{
    $st = strtotime($start);
    $en = strtotime($end);
    if ($st === false || $en === false) return 0;
    $diff = $en - $st;
    return ($diff > 0) ? $diff : 0;
}

// Export (CSV) for TAB 1 (exports ALL filtered rows, not just current page)
if (isset($_GET['export']) && $_GET['export'] === '1' && $tab === 'one') {

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=finance_staff_allocation_export_' . date('Y-m-d_H-i-s') . '.csv');

    $out = fopen('php://output', 'w');

    fputcsv($out, [
        'Department',
        'Batch Size',
        'Product',
        'Batch No',
        'Incharge',
        'Date',
        'Emp ID',
        'Emp Name',
        'Job',
        'Checkin',
        'Checkout',
        'Checkin 2',
        'Checkout 2',
        'Total working hour',
        'Total packing unit',
        'Ref #'
    ]);

    $exportSql = "SELECT * FROM staff_allocation
                  WHERE {$whereSql}
                  ORDER BY `date` DESC, id DESC";
    $exportQ = mysqli_query($conn, $exportSql);

    if ($exportQ) {
        while ($row = mysqli_fetch_assoc($exportQ)) {

            $totalPackingUnit = (int)($row['packing_unit1'] ?? 0)
                + (int)($row['packing_unit2'] ?? 0)
                + (int)($row['packing_unit3'] ?? 0)
                + (int)($row['packing_unit4'] ?? 0);

            for ($i = 1; $i <= 40; $i++) {
                $empId = $row["id_$i"] ?? '';
                $empName = $row["name_$i"] ?? '';
                $empJob = $row["jobs_$i"] ?? '';
                $checkin1 = $row["checkin_$i"] ?? '';
                $checkout1 = $row["checkout_$i"] ?? '';
                $checkin2 = $row["checkin_{$i}_2"] ?? '';
                $checkout2 = $row["checkout_{$i}_2"] ?? '';

                if ($empId === '' && $empName === '') continue;

                $total_seconds = secondsBetween($checkin1, $checkout1) + secondsBetween($checkin2, $checkout2);
                $twh = formatHMS($total_seconds);

                fputcsv($out, [
                    $row['department'] ?? '',
                    $row['batch_size'] ?? '',
                    $row['product'] ?? '',
                    $row['batch_no'] ?? '',
                    $row['incharge'] ?? '',
                    $row['date'] ?? '',
                    $empId,
                    $empName,
                    $empJob,
                    $checkin1,
                    $checkout1,
                    $checkin2,
                    $checkout2,
                    $twh,
                    $totalPackingUnit,
                    $row['id'] ?? '',
                ]);
            }
        }
    }

    fclose($out);
    exit;
}

// Fetch page (TAB 1)
$tab1_sql = "SELECT * FROM staff_allocation
             WHERE {$whereSql}
             ORDER BY `date` DESC, id DESC
             LIMIT {$perPage} OFFSET {$offset}";
$tab1_q = mysqli_query($conn, $tab1_sql);
$tab1_has = ($tab1_q) ? mysqli_num_rows($tab1_q) : 0;

$from = ($totalRows === 0) ? 0 : ($offset + 1);
$to   = min($offset + $perPage, $totalRows);

$anyFilterOn = !(
    $qRaw === '' &&
    $productRaw === '' &&
    $fromDate === '' &&
    $toDate === ''
);

// =========================================================
// TAB 2: Total hours by employee for selected date
// =========================================================
$selectedDate = isset($_GET['date']) ? trim((string)$_GET['date']) : '';
$empTotals = [];
$totalAllSeconds = 0;

if ($selectedDate !== '') {
    // faster date filter: range (works for DATETIME too)
    $d1 = DateTime::createFromFormat('Y-m-d', $selectedDate);
    if ($d1) {
        $start = $d1->format('Y-m-d') . " 00:00:00";
        $d2 = clone $d1;
        $d2->modify('+1 day');
        $end = $d2->format('Y-m-d') . " 00:00:00";

        $startSafe = mysqli_real_escape_string($conn, $start);
        $endSafe   = mysqli_real_escape_string($conn, $end);

        $tab2_sql = "SELECT * FROM staff_allocation
                     WHERE `date` >= '{$startSafe}' AND `date` < '{$endSafe}'
                     ORDER BY `date` DESC, id DESC";
        $tab2_q = mysqli_query($conn, $tab2_sql);

        if ($tab2_q && mysqli_num_rows($tab2_q) > 0) {
            while ($row = mysqli_fetch_assoc($tab2_q)) {
                for ($i = 1; $i <= 40; $i++) {
                    $empName = $row["name_$i"] ?? '';
                    if ($empName === '') continue;

                    $checkin1 = $row["checkin_$i"] ?? '';
                    $checkout1 = $row["checkout_$i"] ?? '';
                    $checkin2 = $row["checkin_{$i}_2"] ?? '';
                    $checkout2 = $row["checkout_{$i}_2"] ?? '';

                    $sec = secondsBetween($checkin1, $checkout1) + secondsBetween($checkin2, $checkout2);

                    $empTotals[$empName] = ($empTotals[$empName] ?? 0) + $sec;
                    $totalAllSeconds += $sec;
                }
            }
        }
    }
}

// If user selected date, force active tab TWO (server-side)
if ($selectedDate !== '') {
    $tab = 'two';
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Finance - Data Export</title>

    <?php include 'cdncss.php'; ?>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
    <?php include 'sidebarcss.php'; ?>

    <style>
        a {
            text-decoration: none !important;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #c7ccdb !important;
        }

        .btn {
            font-size: 12px !important;
            border-radius: 0px !important;
            font-weight: 600;
        }

        .nav-tabs .nav-link {
            background-color: white;
            border: 1px solid black;
            color: black;
            border-radius: 0;
            margin-right: 2px;
            padding: 8px 15px;
        }

        .nav-tabs .nav-link:hover {
            background-color: #f0f0f0;
        }

        .nav-tabs .nav-link.active {
            background-color: #8ABB6C;
            color: white;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            border: 1px solid #8ABB6C;
        }

        /* ✅ Total badge */
        .mint-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: #d1fae5;
            color: #065f46;
            font-weight: 800;
            font-size: 12px;
            border: 1px solid #a7f3d0;
            white-space: nowrap;
            line-height: 1;
        }

        /* ✅ 90vh scroll table + sticky header */
        .dt-wrap {
            max-height: 90vh;
            overflow: auto;
            border-radius: 12px;
            border: 1px solid #d8dee6;
            background: #fff;
            white-space: nowrap;
        }

        .dt-wrap table {
            width: max-content;
            min-width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .dt-wrap th {
            position: sticky;
            top: 0;
            z-index: 5;
            font-size: 12px !important;
            border: none !important;
            background-color: #1B7BBC !important;
            color: white !important;
            padding: 6px 8px !important;
        }

        .dt-wrap td {
            font-size: 11px !important;
            padding: 7px 8px !important;
            border: none !important;
            border-bottom: 0.5px solid #e5e7eb !important;
            font-weight: 500;
        }

        .filter-card {
            background: #fff;
            border: 1px solid #d8dee6;
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 12px;
        }

        label {
            font-size: 12px !important;
            font-weight: 700;
        }

        input,
        select {
            height: 32px !important;
            font-size: 12px !important;
            border: 1px solid #ced4da !important;
            border-radius: 6px !important;
        }

        .btn-reset {
            background: #ced4da !important;
            border: 1px solid #bfc7d1 !important;
        }

        .btn-export {
            background: #198754 !important;
            color: #fff !important;
            border: none !important;
        }

        .bg-menu {
            background: #393E46 !important;
        }

        .btn-menu {
            background: #FFB22C !important;
            border: none !important;
        }
    </style>
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <?php include 'sidebar1.php'; ?>

        <div id="content">
            <nav class="navbar navbar-expand-lg bg-menu">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </nav>

            <div class="container-fluid py-2">

                <nav class="mt-2">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">

                        <button class="nav-link <?php echo ($tab === 'one' ? 'active' : ''); ?>"
                            id="nav-one-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-one" type="button" role="tab"
                            aria-controls="nav-one"
                            aria-selected="<?php echo ($tab === 'one' ? 'true' : 'false'); ?>">
                            All Record
                        </button>

                        <button class="nav-link <?php echo ($tab === 'two' ? 'active' : ''); ?>"
                            id="nav-two-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-two" type="button" role="tab"
                            aria-controls="nav-two"
                            aria-selected="<?php echo ($tab === 'two' ? 'true' : 'false'); ?>">
                            Total Hours
                        </button>

                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">

                    <!-- ================= TAB 1 ================= -->
                    <div class="tab-pane fade <?php echo ($tab === 'one' ? 'show active' : ''); ?>"
                        id="nav-one" role="tabpanel" aria-labelledby="nav-one-tab" tabindex="0">

                        <div class="filter-card mt-3">
                            <form id="filterFormTab1" method="GET">
                                <input type="hidden" name="tab" value="one">

                                <!-- ===================== ROW 1 ===================== -->
                                <div class="row g-2 align-items-end">

                                    <!-- Home -->
                                    <div class="col-12 col-lg-auto">
                                        <a href="sa_home" class="btn btn-dark btn-sm">
                                            <i class="fa-solid fa-home me-1"></i> Home
                                        </a>
                                    </div>

                                    <!-- Search -->
                                    <div class="col-12 col-lg-3">
                                        <label>Search</label>
                                        <input class="form-control form-control-sm"
                                            name="q"
                                            type="text"
                                            value="<?php echo htmlspecialchars($qRaw); ?>"
                                            placeholder="Type and press Apply...">
                                    </div>

                                    <!-- Product -->
                                    <div class="col-12 col-lg-2">
                                        <label>Select Product</label>
                                        <select class="form-select form-select-sm" name="product">
                                            <option value="">All</option>
                                            <?php foreach ($products as $p):
                                                $pTrim = trim($p);
                                                if ($pTrim === '') continue; ?>
                                                <option value="<?php echo htmlspecialchars($pTrim); ?>"
                                                    <?php echo ($productRaw === $pTrim ? 'selected' : ''); ?>>
                                                    <?php echo htmlspecialchars($pTrim); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- From Date -->
                                    <div class="col-6 col-lg-2">
                                        <label>From Date</label>
                                        <input class="form-control form-control-sm"
                                            type="date"
                                            name="fromDate"
                                            value="<?php echo htmlspecialchars($fromDate); ?>">
                                    </div>

                                    <!-- To Date -->
                                    <div class="col-6 col-lg-2">
                                        <label>To Date</label>
                                        <input class="form-control form-control-sm"
                                            type="date"
                                            name="toDate"
                                            value="<?php echo htmlspecialchars($toDate); ?>">
                                    </div>

                                </div>

                                <!-- ===================== ROW 2 ===================== -->
                                <div class="row mt-3">
                                    <div class="col-12 d-flex align-items-center gap-2 flex-wrap">

                                        <!-- Apply -->
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa-solid fa-filter me-1"></i> Apply
                                        </button>

                                        <!-- Reset -->
                                        <button id="resetBtnTab1"
                                            type="button"
                                            class="btn btn-reset btn-sm"
                                            style="<?php echo ($anyFilterOn ? '' : 'display:none;'); ?>">
                                            <i class="fa-solid fa-rotate-left me-1"></i> Reset
                                        </button>

                                        <!-- Export Excel -->
                                        <?php
                                        $exportParams = $_GET;
                                        $exportParams['tab'] = 'one';
                                        $exportParams['export'] = '1';
                                        $exportUrl = strtok($_SERVER["REQUEST_URI"], '?') . '?' . http_build_query($exportParams);
                                        ?>
                                        <a href="<?php echo htmlspecialchars($exportUrl); ?>"
                                            class="btn btn-export btn-sm">
                                            <i class="fa-solid fa-file-excel me-1"></i> Export CSV
                                        </a>

                                        <!-- Total badge -->
                                        <div class="mint-badge ms-2">
                                            <i class="fa-solid fa-database"></i>
                                            Total: <?php echo (int)$totalRows; ?>
                                        </div>

                                    </div>
                                </div>

                            </form>
                        </div>




                        <div class="dt-wrap">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>Department</th>
                                        <th>Batch Size</th>
                                        <th>Product</th>
                                        <th>Batch No</th>
                                        <th>Incharge</th>
                                        <th>Date</th>
                                        <th>Emp ID</th>
                                        <th>Emp Name</th>
                                        <th>Job</th>
                                        <th>Checkin</th>
                                        <th>Checkout</th>
                                        <th>Checkin 2</th>
                                        <th>Checkout 2</th>
                                        <th>Total working hour</th>
                                        <th>Total packing unit</th>
                                        <th>Ref #</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    if ($tab1_has) {
                                        while ($row = mysqli_fetch_assoc($tab1_q)) {

                                            $totalPackingUnit = (int)($row['packing_unit1'] ?? 0)
                                                + (int)($row['packing_unit2'] ?? 0)
                                                + (int)($row['packing_unit3'] ?? 0)
                                                + (int)($row['packing_unit4'] ?? 0);

                                            for ($i = 1; $i <= 40; $i++) {
                                                $empId = $row["id_$i"] ?? '';
                                                $empName = $row["name_$i"] ?? '';
                                                $empJob = $row["jobs_$i"] ?? '';
                                                $checkin1 = $row["checkin_$i"] ?? '';
                                                $checkout1 = $row["checkout_$i"] ?? '';
                                                $checkin2 = $row["checkin_{$i}_2"] ?? '';
                                                $checkout2 = $row["checkout_{$i}_2"] ?? '';

                                                if ($empId === '' && $empName === '') continue;

                                                $total_seconds = secondsBetween($checkin1, $checkout1) + secondsBetween($checkin2, $checkout2);
                                                $twh = formatHMS($total_seconds);
                                    ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars((string)($row['department'] ?? '')); ?></td>
                                                    <td><?php echo htmlspecialchars((string)($row['batch_size'] ?? '')); ?></td>
                                                    <td><?php echo htmlspecialchars((string)($row['product'] ?? '')); ?></td>
                                                    <td><?php echo htmlspecialchars((string)($row['batch_no'] ?? '')); ?></td>
                                                    <td><?php echo htmlspecialchars((string)($row['incharge'] ?? '')); ?></td>
                                                    <td><?php echo htmlspecialchars((string)($row['date'] ?? '')); ?></td>
                                                    <td><?php echo htmlspecialchars((string)$empId); ?></td>
                                                    <td><?php echo htmlspecialchars((string)$empName); ?></td>
                                                    <td><?php echo htmlspecialchars((string)$empJob); ?></td>
                                                    <td><?php echo htmlspecialchars((string)$checkin1); ?></td>
                                                    <td><?php echo htmlspecialchars((string)$checkout1); ?></td>
                                                    <td><?php echo htmlspecialchars((string)$checkin2); ?></td>
                                                    <td><?php echo htmlspecialchars((string)$checkout2); ?></td>
                                                    <td><?php echo htmlspecialchars((string)$twh); ?></td>
                                                    <td><?php echo (int)$totalPackingUnit; ?></td>
                                                    <td><?php echo htmlspecialchars((string)($row['id'] ?? '')); ?></td>
                                                </tr>
                                    <?php
                                            }
                                        }
                                    } else {
                                        echo "<tr><td colspan='16' class='text-muted fw-bold p-3'>No record found!</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
                            <div class="text-muted small fw-bold">
                                <?php echo "Showing {$from}-{$to} of {$totalRows} | Page {$page} of {$totalPages}"; ?>
                            </div>

                            <div class="btn-group" role="group" aria-label="Pagination">
                                <?php
                                $isFirst = ($page <= 1);
                                $isLast  = ($page >= $totalPages);

                                $firstUrl = htmlspecialchars(pageUrl(1));
                                $prevUrl  = htmlspecialchars(pageUrl(max(1, $page - 1)));
                                $nextUrl  = htmlspecialchars(pageUrl(min($totalPages, $page + 1)));
                                $lastUrl  = htmlspecialchars(pageUrl($totalPages));

                                echo '<a class="btn btn-sm btn-outline-secondary ' . ($isFirst ? 'disabled' : '') . '" href="' . $firstUrl . '">First</a>';
                                echo '<a class="btn btn-sm btn-outline-secondary ' . ($isFirst ? 'disabled' : '') . '" href="' . $prevUrl . '">Prev</a>';

                                $window = 5;
                                $half = intdiv($window, 2);
                                $start = max(1, $page - $half);
                                $end = min($totalPages, $start + $window - 1);
                                $start = max(1, $end - $window + 1);

                                for ($i = $start; $i <= $end; $i++) {
                                    $active = ($i === $page) ? 'btn-primary' : 'btn-outline-primary';
                                    echo '<a class="btn btn-sm ' . $active . '" href="' . htmlspecialchars(pageUrl($i)) . '">' . $i . '</a>';
                                }

                                echo '<a class="btn btn-sm btn-outline-secondary ' . ($isLast ? 'disabled' : '') . '" href="' . $nextUrl . '">Next</a>';
                                echo '<a class="btn btn-sm btn-outline-secondary ' . ($isLast ? 'disabled' : '') . '" href="' . $lastUrl . '">Last</a>';
                                ?>
                            </div>
                        </div>

                    </div>

                    <!-- ================= TAB 2 ================= -->
                    <div class="tab-pane fade <?php echo ($tab === 'two' ? 'show active' : ''); ?>"
                        id="nav-two" role="tabpanel" aria-labelledby="nav-two-tab" tabindex="0">

                        <div class="filter-card mt-3">
                            <form method="GET" class="row g-2 align-items-end">
                                <input type="hidden" name="tab" value="two">

                                <div class="col-12 col-lg-2">
                                    <a href="sa_forms" class="btn btn-dark btn-sm w-100">
                                        <i class="fa-solid fa-home me-1"></i> Home
                                    </a>
                                </div>

                                <div class="col-12 col-lg-3">
                                    <label>Select Date</label>
                                    <input type="date" class="form-control form-control-sm" name="date"
                                        value="<?php echo htmlspecialchars($selectedDate); ?>">
                                </div>

                                <div class="col-12 col-lg-2 d-grid">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-filter me-1"></i> Filter
                                    </button>
                                </div>
                            </form>

                            <?php if ($selectedDate !== ''): ?>
                                <div class="mt-2 fw-bold text-success">
                                    Showing results for: <?php echo htmlspecialchars(date('d-M-Y', strtotime($selectedDate))); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="dt-wrap">
                            <table class="table table-bordered mb-0">
                                <thead style="background-color:#0D9276;color:white">
                                    <tr>
                                        <th style="min-width:80px">S.No</th>
                                        <th>Employee Name</th>
                                        <th>Total Working Hours</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    if ($selectedDate === '') {
                                        echo "<tr><td colspan='3' class='p-3 fw-bold'>Please select a date to view records.</td></tr>";
                                    } elseif (empty($empTotals)) {
                                        echo "<tr><td colspan='3' class='p-3 fw-bold'>No records found for selected date.</td></tr>";
                                    } else {
                                        $sno = 1;
                                        foreach ($empTotals as $emp => $seconds) {
                                            $formatted = formatHMS((int)$seconds);
                                            $link = "single_emp_record.php?date=" . urlencode($selectedDate) . "&emp=" . urlencode($emp);

                                            echo "<tr>
                                            <td>{$sno}</td>
                                            <td><u><a href='{$link}' target='_blank' style='color:black!important;font-size:12px!important;font-weight:600'>" . htmlspecialchars($emp) . "</a></u></td>
                                            <td>{$formatted}</td>
                                          </tr>";
                                            $sno++;
                                        }

                                        $formattedTotal = formatHMS((int)$totalAllSeconds);

                                        echo "<tr style='font-weight:bold; background-color:#f2f2f2;font-size:13px!important'>
                                        <td colspan='2' style='text-align:right;'>Total Working Hours:</td>
                                        <td class='text-success'>{$formattedTotal}</td>
                                      </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ✅ Sidebar CLOSED by default
            document.getElementById('sidebar')?.classList.remove('active');

            document.getElementById('sidebarCollapse')?.addEventListener('click', function() {
                document.getElementById('sidebar')?.classList.toggle('active');
            });

            // ✅ Tab1 Reset
            const resetBtn = document.getElementById("resetBtnTab1");
            resetBtn?.addEventListener("click", function() {
                const url = new URL(window.location.href);
                url.searchParams.set('tab', 'one');
                url.searchParams.delete('q');
                url.searchParams.delete('product');
                url.searchParams.delete('fromDate');
                url.searchParams.delete('toDate');
                url.searchParams.set('page', '1');
                url.searchParams.delete('export');
                window.location.href = url.toString();
            });
        });
    </script>

    <script>
        // ✅ Keep correct tab in URL (so reload stays on same tab)
        document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(btn => {
            btn.addEventListener('shown.bs.tab', (e) => {
                const id = e.target.id;
                const url = new URL(window.location.href);
                url.searchParams.set('tab', id === 'nav-two-tab' ? 'two' : 'one');
                history.replaceState(null, '', url.toString());
            });
        });
    </script>

    <script src="assets/js/main.js"></script>
</body>

</html>
<?php ob_end_flush(); ?>