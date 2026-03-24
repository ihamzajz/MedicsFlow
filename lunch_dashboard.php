<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

require_once "dbconfig.php";
date_default_timezone_set("Asia/Karachi");

/* ----------------- Helpers ----------------- */
function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function isValidDateYmd($d): bool {
    if (!$d) return false;
    $dt = DateTime::createFromFormat('Y-m-d', $d);
    return $dt && $dt->format('Y-m-d') === $d;
}

function monthRange(int $year, int $month): array {
    $start = sprintf('%04d-%02d-01', $year, $month);
    $end = (new DateTime($start))->modify('last day of this month')->format('Y-m-d');
    return [$start, $end];
}

function buildQuery(array $overrides = []): string {
    $q = $_GET;
    foreach ($overrides as $k=>$v) {
        if ($v === null) unset($q[$k]);
        else $q[$k] = $v;
    }
    return http_build_query($q);
}

function formatDateLabel($ymd, $monthsMap) {
    if (!$ymd || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $ymd)) return '';
    $y = (int)substr($ymd,0,4);
    $m = (int)substr($ymd,5,2);
    $d = (int)substr($ymd,8,2);
    $mn = $monthsMap[$m] ?? '';
    return trim($d . " " . $mn . " " . $y);
}

/* UI display only */
function formatDateDMY($ymd): string {
    if (!$ymd || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $ymd)) return (string)$ymd;
    $dt = DateTime::createFromFormat('Y-m-d', $ymd);
    return $dt ? $dt->format('d-m-Y') : (string)$ymd;
}

/* ----------------- Month map ----------------- */
$monthsMap = [
    1=>"January",2=>"February",3=>"March",4=>"April",5=>"May",6=>"June",
    7=>"July",8=>"August",9=>"September",10=>"October",11=>"November",12=>"December"
];

/* ----------------- Read Filters (GET) ----------------- */
$month     = trim($_GET['month'] ?? '');
$year      = trim($_GET['year'] ?? '');
$date_from = trim($_GET['date_from'] ?? '');
$date_to   = trim($_GET['date_to'] ?? '');
$search    = trim($_GET['search'] ?? '');

$isApply = (isset($_GET['apply']) && $_GET['apply'] === '1');

$page = (int)($_GET['page'] ?? 1);
if ($page < 1) $page = 1;

$perPage = 100;
$offset  = ($page - 1) * $perPage;

$errors = [];

/* ----------------- Validation ----------------- */
if ($year !== '' && !ctype_digit($year)) $errors[] = "Invalid year.";
if ($month !== '' && (!ctype_digit($month) || (int)$month < 1 || (int)$month > 12)) $errors[] = "Invalid month.";

if ($date_from !== '' && !isValidDateYmd($date_from)) $errors[] = "Invalid Date From.";
if ($date_to !== '' && !isValidDateYmd($date_to)) $errors[] = "Invalid Date To.";
if ($date_from !== '' && $date_to !== '' && $date_from > $date_to) $errors[] = "Date From cannot be after Date To.";

/* Rule: Apply with no filters => error (same as tanker) */
$hasAnyFilter = ($month!=='' || $year!=='' || $date_from!=='' || $date_to!=='' || $search!=='');
if (!$errors && $isApply && !$hasAnyFilter) {
    $errors[] = "Please apply filter.";
}

/* If month+year selected AND user provides date_from/date_to (both) => dates must be within that month/year */
if (!$errors && $month !== '' && $year !== '' && $date_from !== '' && $date_to !== '') {
    [$ms, $me] = monthRange((int)$year, (int)$month);
    if ($date_from < $ms || $date_from > $me) $errors[] = "Date From must be within selected Month/Year.";
    if ($date_to < $ms || $date_to > $me) $errors[] = "Date To must be within selected Month/Year.";
}

/* ----------------- Build WHERE ----------------- */
$where = [];
$types = "";
$params = [];

if (!$errors) {
    if ($month !== '' && $year === '') {
        $where[] = "MONTH(`date`) = ?";
        $types .= "i";
        $params[] = (int)$month;
    }

    if ($year !== '' && $month === '') {
        $where[] = "YEAR(`date`) = ?";
        $types .= "i";
        $params[] = (int)$year;
    }

    if ($month !== '' && $year !== '') {
        $where[] = "MONTH(`date`) = ?";
        $types .= "i";
        $params[] = (int)$month;

        $where[] = "YEAR(`date`) = ?";
        $types .= "i";
        $params[] = (int)$year;
    }

    // Date Range (optional)
    if ($date_from !== '' && $date_to !== '') {
        $where[] = "`date` BETWEEN ? AND ?";
        $types .= "ss";
        $params[] = $date_from;
        $params[] = $date_to;
    } elseif ($date_from !== '') {
        $where[] = "`date` >= ?";
        $types .= "s";
        $params[] = $date_from;
    } elseif ($date_to !== '') {
        $where[] = "`date` <= ?";
        $types .= "s";
        $params[] = $date_to;
    }

    // Search across most useful columns
    if ($search !== '') {
        $where[] = "(
            `day` LIKE ?
            OR remarks LIKE ?
            OR form_user LIKE ?
        )";
        $types .= "sss";
        $like = "%{$search}%";
        $params[] = $like;
        $params[] = $like;
        $params[] = $like;
    }
}

$whereSql = $where ? ("WHERE " . implode(" AND ", $where)) : "";

/* ----------------- Fetch ALL filtered rows (for exports) ----------------- */
function fetchAllFilteredRows($conn, $whereSql, $types, $params) {
    $sql = "
        SELECT
            `date`, `day`,
            no_of_employee, no_of_guest, total_part1,
            total_head_counts_hr, security_guards_part2, guests_part2, total_part2, diff_part2, diff_percent_part2,
            attendance, security_guards_part3, guests_part3, total_part3, diff_part3, diff_percent_part3,
            remarks, form_user, created_at
        FROM lunch_form
        {$whereSql}
        ORDER BY `date` DESC, created_at DESC
    ";
    $stmt = $conn->prepare($sql);
    if ($types !== "") {
        $bind = [];
        $bind[] = $types;
        for ($i=0; $i<count($params); $i++) $bind[] = &$params[$i];
        call_user_func_array([$stmt, 'bind_param'], $bind);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = [];
    while ($r = $result->fetch_assoc()) $rows[] = $r;
    $stmt->close();
    return $rows;
}

/* ----------------- Report title parts ----------------- */
$parts = [];
if ($month !== '' && isset($monthsMap[(int)$month])) {
    if ($year !== '') $parts[] = $monthsMap[(int)$month] . " " . $year;
    else $parts[] = $monthsMap[(int)$month];
} elseif ($year !== '') {
    $parts[] = $year;
}
if ($date_from !== '' && $date_to !== '') {
    $parts[] = formatDateLabel($date_from, $monthsMap) . " to " . formatDateLabel($date_to, $monthsMap);
}
$reportTitle = "Lunch Report" . ($parts ? " (" . implode(", ", $parts) . ")" : "");

/* ----------------- Showing message ----------------- */
$showingHtml = "Showing all records";

if ($month !== '' && $year === '' && isset($monthsMap[(int)$month])) {
    $showingHtml = 'Showing data for <strong>'.h($monthsMap[(int)$month]).'</strong>';
} elseif ($month !== '' && $year !== '' && isset($monthsMap[(int)$month])) {
    $showingHtml = 'Showing data for <strong>'.h($monthsMap[(int)$month].' '.$year).'</strong>';
} elseif ($year !== '' && $month === '') {
    $showingHtml = 'Showing data for <strong>'.h($year).'</strong>';
}
if ($date_from !== '' && $date_to !== '') {
    $df = formatDateLabel($date_from, $monthsMap);
    $dt = formatDateLabel($date_to, $monthsMap);
    $showingHtml = 'Showing data for <strong>'.h($df).'</strong> to <strong>'.h($dt).'</strong>';
}

/* ----------------- EXPORT: EXCEL (CSV) ----------------- */
$export = strtolower(trim($_GET['export'] ?? ''));
if (!$errors && $export === 'excel') {
    $exportRows = fetchAllFilteredRows($conn, $whereSql, $types, $params);

    // Like tanker grand total: here we total Total Part1
    $grandTotal = 0;
    foreach ($exportRows as $r) $grandTotal += (int)$r['total_part1'];

    $filename = "lunch_report_" . date("Y-m-d_H-i") . ".csv";
    header("Content-Type: text/csv; charset=UTF-8");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    echo "\xEF\xBB\xBF";

    $out = fopen("php://output", "w");
    fputcsv($out, [$reportTitle]);
    fputcsv($out, []);

    fputcsv($out, [
        "Ref#","Date","Day",
        "Emp","Guest","Total P1",
        "HR Headcount","Sec(P2)","Guest(P2)","Total P2","Diff2","Diff2%",
        "Attendance","Sec(P3)","Guest(P3)","Total P3","Diff3","Diff3%",
        "Remarks","User","Created At"
    ]);

    $ref = 1;
    foreach ($exportRows as $r) {
        fputcsv($out, [
            $ref++,
            formatDateDMY((string)$r['date']),
            (string)$r['day'],

            (int)$r['no_of_employee'],
            (int)$r['no_of_guest'],
            (int)$r['total_part1'],

            (int)$r['total_head_counts_hr'],
            (int)$r['security_guards_part2'],
            (int)$r['guests_part2'],
            (int)$r['total_part2'],
            (int)$r['diff_part2'],
            number_format((float)$r['diff_percent_part2'], 2, '.', ''),

            (int)$r['attendance'],
            (int)$r['security_guards_part3'],
            (int)$r['guests_part3'],
            (int)$r['total_part3'],
            (int)$r['diff_part3'],
            number_format((float)$r['diff_percent_part3'], 2, '.', ''),

            (string)$r['remarks'],
            (string)$r['form_user'],
            (string)$r['created_at'],
        ]);
    }

    fputcsv($out, []);
    fputcsv($out, ["", "", "", "", "", "TOTAL (Total P1)", $grandTotal]);

    fclose($out);
    exit;
}

/* ----------------- Year dropdown: past 50 / future 50 ----------------- */
$currentYear = (int)date('Y');
$yearStart = $currentYear - 50;
$yearEnd   = $currentYear + 50;

/* ----------------- Run Queries (pagination view) ----------------- */
$total = 0;
$totalPages = 1;
$rows = [];
$sumPage = 0;

$exportRows = [];
$grandTotal = 0;

if (!$errors) {
    // Count
    $stmtC = $conn->prepare("SELECT COUNT(*) FROM lunch_form {$whereSql}");
    if ($types !== "") $stmtC->bind_param($types, ...$params);
    $stmtC->execute();
    $stmtC->bind_result($total);
    $stmtC->fetch();
    $stmtC->close();

    $totalPages = max(1, (int)ceil($total / $perPage));
    if ($page > $totalPages) $page = $totalPages;
    $offset = ($page - 1) * $perPage;

    // Page rows
    $sqlRows = "
        SELECT
            `date`, `day`,
            no_of_employee, no_of_guest, total_part1,
            total_head_counts_hr, security_guards_part2, guests_part2, total_part2, diff_part2, diff_percent_part2,
            attendance, security_guards_part3, guests_part3, total_part3, diff_part3, diff_percent_part3,
            remarks, form_user, created_at
        FROM lunch_form
        {$whereSql}
        ORDER BY `date` DESC, created_at DESC
        LIMIT ? OFFSET ?
    ";
    $stmt = $conn->prepare($sqlRows);

    $types2 = $types . "ii";
    $params2 = $params;
    $params2[] = (int)$perPage;
    $params2[] = (int)$offset;

    $bind = [];
    $bind[] = $types2;
    for ($i=0; $i<count($params2); $i++) $bind[] = &$params2[$i];
    call_user_func_array([$stmt, 'bind_param'], $bind);

    $stmt->execute();
    $result = $stmt->get_result();
    while ($r = $result->fetch_assoc()) {
        $sumPage += (int)$r['total_part1'];
        $rows[] = $r;
    }
    $stmt->close();

    // For PDF export (all rows)
    $exportRows = fetchAllFilteredRows($conn, $whereSql, $types, $params);
    foreach ($exportRows as $r) $grandTotal += (int)$r['total_part1'];
}

$hasFilter = $hasAnyFilter;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lunch Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />

    <style>
        :root{
            --bg:#ffffff!important;
            --card:#ffffff;
            --border:#e7ebf2;
            --text:#0f172a;
            --brand:#0e6ba8;
            --brand2:#1f7a8c;

            --soft:#eef6ff;
            --softBorder:#dbeafe;
            --softText:#0b5e95;

            --clear:#3b82f6;
            --clearHover:#2563eb;

            --excel:#1D6F42;
            --excelHover:#155a35;

            --pdf:#DC3545;
            --pdfHover:#b02a37;
        }
        body{ font-family:'Poppins',sans-serif; background:var(--bg); color:var(--text); }

        .bg-menu { background-color:#393E46 !important; }
        .btn-menu { font-size:12.5px; background-color:#FFB22C !important; padding:5px 10px; font-weight:600; border:none !important; }

        .dash-card{ border:1px solid var(--border); border-radius:14px; background:var(--card); box-shadow:0 14px 36px rgba(15,23,42,.08); overflow:hidden; }
        .dash-header{ background:linear-gradient(90deg,var(--brand),var(--brand2)); color:#fff; padding:14px 16px; display:flex; align-items:center; justify-content:space-between; }
        .dash-header h6{ margin:0; font-weight:700; letter-spacing:.2px; }

        .btn-sq{ border-radius:2px !important; font-weight:800; font-size:11px; padding:6px 8px; }

        .panel{ border:1px solid #adb5bd; border-radius:14px; background:#fff; box-shadow: 0 14px 28px rgba(15,23,42,.08), 0 0 0 1px rgba(231,235,242,.75); }
        .panel-pad{ padding:14px; }

        .badge-soft{
            background:var(--soft); color:var(--softText); border:1px solid var(--softBorder);
            font-size:12px; font-weight:800; border-radius:999px; padding:6px 10px;
            display:inline-flex; align-items:center; gap:8px; white-space:nowrap;
        }

        label{ font-size:12px; font-weight:800; color:#0f172a; margin-bottom:6px; }
        .form-control, .form-select{ border:1px solid #d6dde8; border-radius:12px; height:38px; font-size:13px !important; padding:6px 10px; }

        .btn-clear{ background:var(--clear); border:1px solid var(--clear); color:#fff; }
        .btn-clear:hover{ background:var(--clearHover); border-color:var(--clearHover); color:#fff; }

        .btn-excel{ background:var(--excel); border:1px solid var(--excel); color:#fff; }
        .btn-excel:hover{ background:var(--excelHover); border-color:var(--excelHover); color:#fff; }

        .btn-pdf{ background:var(--pdf); border:1px solid var(--pdf); color:#fff; }
        .btn-pdf:hover{ background:var(--pdfHover); border-color:var(--pdfHover); color:#fff; }

        .error-box{ margin-top:10px; border:1px solid #fecaca; background:#fff1f2; color:#9f1239; padding:10px 12px; border-radius:12px; font-size:12.5px; font-weight:700; }

        /* Responsive + Scrollable table */
        .table-responsive{
            max-height: 68vh; /* vertical scroll */
            overflow: auto;
        }
        table{ margin:0; min-width: 1600px; } /* forces horizontal scroll on small screens */
        .table thead th{
            position: sticky;
            top: 0;
            z-index: 5;
            background:var(--soft) !important;
            color:var(--softText);
            font-size:12px !important;
            font-weight:900;
            padding:12px 14px !important;
            border:0 !important;
            white-space:nowrap;
        }
        .table tbody td{
            font-size:12px;
            padding:8px 14px !important;
            border:0 !important;
            border-top:1px solid #eef2f7 !important;
            color:#0f172a;
            vertical-align:middle;
            white-space:nowrap;
        }
        .table-hover tbody tr:hover{ background:#f8fafc; }
        .amount{ font-weight:900; }

        .filter-actions{
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap:8px;
            margin-top:10px;
            padding:0;
            flex-wrap:wrap;
        }

        .filter-actions .left{
            display:flex;
            align-items:center;
        }
        .filter-actions .left .btnrow{
            display:flex;
            gap:8px;
            align-items:center;
            flex-wrap:wrap;
        }
        .showing-msg{
            font-size:12px;
            color:#334155;
            font-weight:700;
            white-space:nowrap;
        }

        .filter-actions .right{
            display:flex;
            justify-content:flex-end;
            align-items:center;
        }
        a{ text-decoration: none; }
    </style>

    <?php include 'sidebarcss.php'; ?>
</head>
<body>
<div class="wrapper">
    <?php include 'sidebar1.php'; ?>

    <div id="content" class="content-wrap">
        <nav class="navbar navbar-expand-lg bg-menu">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn-menu">
                    <i class="fas fa-align-left"></i> <span>Menu</span>
                </button>
            </div>
        </nav>

        <div class="container-fluid mt-4">
            <div class="row justify-content-center">
                <div class="col-12">

                    <div class="dash-card">
                        <div class="dash-header">
                            <h6>Lunch Dashboard</h6>
                            <a href="lunch_home.php" class="btn btn-light btn-sm btn-sq">
                                <i class="fa-solid fa-house"></i> Home
                            </a>
                        </div>

                        <div class="p-3 p-md-4">

                            <!-- FILTERS -->
                            <div class="panel panel-pad">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                                    <span class="badge-soft"><i class="fa-solid fa-sliders"></i> Filters</span>
                                    <span class="badge-soft"><i class="fa-solid fa-database"></i> Records: <?php echo (int)$total; ?></span>
                                </div>

                                <form method="GET">
                                    <input type="hidden" name="apply" value="1">

                                    <div class="row g-2 align-items-end">
                                        <div class="col-12 col-md-2">
                                            <label>Month</label>
                                            <select class="form-select" name="month">
                                                <option value="">All</option>
                                                <?php foreach ($monthsMap as $k=>$m): ?>
                                                    <option value="<?php echo (int)$k; ?>" <?php echo ($month==(string)$k?'selected':''); ?>>
                                                        <?php echo h($m); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-2">
                                            <label>Year</label>
                                            <select class="form-select" name="year" id="yearSelect">
                                                <option value="">All</option>
                                                <?php for ($y=$yearStart; $y<=$yearEnd; $y++): ?>
                                                    <option value="<?php echo (int)$y; ?>" <?php echo ($year===(string)$y?'selected':''); ?>>
                                                        <?php echo (int)$y; ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-2">
                                            <label>Date From</label>
                                            <input type="date" class="form-control" name="date_from" value="<?php echo h($date_from); ?>">
                                        </div>

                                        <div class="col-12 col-md-2">
                                            <label>Date To</label>
                                            <input type="date" class="form-control" name="date_to" value="<?php echo h($date_to); ?>">
                                        </div>

                                        <div class="col-12 col-md-3">
                                            <label>Search</label>
                                            <input type="text" class="form-control" name="search"
                                                   placeholder="day, remarks, user..."
                                                   value="<?php echo h($search); ?>">
                                        </div>

                                        <div class="col-12 col-md-1 d-grid">
                                            <button class="btn btn-dark btn-sm btn-sq" type="submit">
                                                <i class="fa-solid fa-filter"></i> Apply
                                            </button>
                                        </div>
                                    </div>

                                    <div class="filter-actions">
                                        <div class="left">
                                            <div class="btnrow">
                                                <a class="btn btn-sm btn-sq btn-excel"
                                                   href="?<?php echo h(buildQuery(['export'=>'excel','page'=>null])); ?>">
                                                    <i class="fa-solid fa-file-excel"></i> Excel
                                                </a>

                                                <a class="btn btn-sm btn-sq btn-pdf"
                                                   href="javascript:void(0)"
                                                   onclick="downloadPDF()">
                                                    <i class="fa-solid fa-file-pdf"></i> PDF
                                                </a>

                                                <span class="showing-msg"><?php echo $showingHtml; ?></span>
                                            </div>
                                        </div>

                                        <div class="right">
                                            <?php if ($hasFilter): ?>
                                                <a class="btn btn-sm btn-sq btn-clear" href="lunch_dashboard.php">
                                                    <i class="fa-solid fa-rotate-left"></i> Clear
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </form>

                                <?php if ($errors): ?>
                                    <div class="error-box"><?php echo h(implode(" ", $errors)); ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- TABLE -->
                            <div class="panel mt-3">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                        <tr>
                                            <th>Ref#</th>
                                            <th>Date</th>
                                            <th>Day</th>

                                            <th class="text-end" style="background-color:#ffedd8!important;color:black!important">No. Of Emp</th>
                                            <th class="text-end" style="background-color:#ffedd8!important;color:black!important">No Of Guest</th>
                                            <th class="text-end" style="background-color:#ffedd8!important;color:black!important">Total:</th>

                                            <th class="text-end" style="background-color:#bde0fe!important;color:black!important">Total HR Headcount</th>
                                            <th class="text-end" style="background-color:#bde0fe!important;color:black!important">Security Guards</th>
                                            <th class="text-end" style="background-color:#bde0fe!important;color:black!important">Guest</th>
                                            <th class="text-end" style="background-color:#bde0fe!important;color:black!important">Total</th>
                                            <th class="text-end" style="background-color:#bde0fe!important;color:black!important">Diff</th>
                                            <th class="text-end" style="background-color:#bde0fe!important;color:black!important">Diff%</th>

                                            <th class="text-end" style="background-color:#b2f7ef!important;color:black!important">Attendance</th>
                                            <th class="text-end" style="background-color:#b2f7ef!important;color:black!important">Security Guards</th>
                                            <th class="text-end" style="background-color:#b2f7ef!important;color:black!important">Guest</th>
                                            <th class="text-end" style="background-color:#b2f7ef!important;color:black!important">Total</th>
                                            <th class="text-end" style="background-color:#b2f7ef!important;color:black!important">Diff</th>
                                            <th class="text-end" style="background-color:#b2f7ef!important;color:black!important">Diff%</th>

                                            <th>Remarks</th>
                                            <th>User</th>
                                            <th>Created</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php if ($errors): ?>
                                            <tr><td colspan="21" class="text-center text-muted py-4">Fix filter errors and click Apply.</td></tr>
                                        <?php elseif (!$rows): ?>
                                            <tr><td colspan="21" class="text-center text-muted py-4">No records found</td></tr>
                                        <?php else: ?>
                                            <?php
                                            $refStart = ($page - 1) * $perPage + 1;
                                            $ref = $refStart;
                                            ?>
                                            <?php foreach ($rows as $r): ?>
                                                <tr>
                                                    <td><?php echo (int)$ref++; ?></td>
                                                    <td><?php echo h(formatDateDMY($r['date'])); ?></td>
                                                    <td><?php echo h($r['day']); ?></td>

                                                    <td class="text-end"><?php echo (int)$r['no_of_employee']; ?></td>
                                                    <td class="text-end"><?php echo (int)$r['no_of_guest']; ?></td>
                                                    <td class="text-end amount"><?php echo (int)$r['total_part1']; ?></td>

                                                    <td class="text-end"><?php echo (int)$r['total_head_counts_hr']; ?></td>
                                                    <td class="text-end"><?php echo (int)$r['security_guards_part2']; ?></td>
                                                    <td class="text-end"><?php echo (int)$r['guests_part2']; ?></td>
                                                    <td class="text-end"><?php echo (int)$r['total_part2']; ?></td>
                                                    <td class="text-end"><?php echo (int)$r['diff_part2']; ?></td>
                                                    <td class="text-end"><?php echo number_format((float)$r['diff_percent_part2'], 2); ?>%</td>

                                                    <td class="text-end"><?php echo (int)$r['attendance']; ?></td>
                                                    <td class="text-end"><?php echo (int)$r['security_guards_part3']; ?></td>
                                                    <td class="text-end"><?php echo (int)$r['guests_part3']; ?></td>
                                                    <td class="text-end"><?php echo (int)$r['total_part3']; ?></td>
                                                    <td class="text-end"><?php echo (int)$r['diff_part3']; ?></td>
                                                    <td class="text-end"><?php echo number_format((float)$r['diff_percent_part3'], 2); ?>%</td>

                                                    <td><?php echo h($r['remarks']); ?></td>
                                                    <td><?php echo h($r['form_user']); ?></td>
                                                    <td><?php echo h($r['created_at']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        </tbody>

                                        <tfoot>
                                        <!-- <tr>
                                            <td colspan="5" class="text-end fw-bold" style="font-size:12px;">Total </td>
                                            <td class="text-end fw-bold" style="font-size:12px;"><?php echo (int)$sumPage; ?></td>
                                            <td colspan="15"></td>
                                        </tr> -->
                                        </tfoot>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 p-3">
                                    <div class="d-flex gap-2 flex-wrap">
                                        <?php
                                        $first = 1;
                                        $last  = $totalPages;
                                        $prev  = max(1, $page - 1);
                                        $next  = min($totalPages, $page + 1);

                                        $btn = function($label, $p, $disabled=false, $active=false) {
                                            $cls = "btn btn-sm " . ($active ? "btn-dark" : "btn-outline-dark") . ($disabled ? " disabled" : "");
                                            echo '<a class="'.$cls.'" href="?'.h(buildQuery(["page"=>$p])).'">'.$label.'</a>';
                                        };

                                        $btn("First", $first, $page==1);
                                        $btn("Prev", $prev, $page==1);

                                        $start = max(1, $page - 2);
                                        $end   = min($totalPages, $start + 4);
                                        $start = max(1, $end - 4);

                                        for ($i=$start; $i<=$end; $i++) $btn((string)$i, $i, false, $i==$page);

                                        $btn("Next", $next, $page==$totalPages);
                                        $btn("Last", $last, $page==$totalPages);
                                        ?>
                                    </div>

                                    <div class="text-muted" style="font-weight:900; font-size:12px;">
                                        Page: <?php echo (int)$page; ?> / <?php echo (int)$totalPages; ?> (100 per page)
                                    </div>
                                </div>
                            </div>

                        </div><!-- /padding -->
                    </div><!-- /dash-card -->

                </div>
            </div>
        </div>

        <?php include 'footer.php'; ?>
    </div>
</div>

<!-- PDF (CDN) using jsPDF + AutoTable -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

<script>
const REPORT_TITLE = <?php echo json_encode($reportTitle, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
const HAS_ERRORS = <?php echo $errors ? 'true' : 'false'; ?>;
const GRAND_TOTAL = <?php echo json_encode((int)$grandTotal, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

const EXPORT_ROWS = <?php
// Build rows safely in PHP (no JS concatenation bugs)
$payload = [];
$ref = 1;
foreach ($exportRows as $r) {
    $payload[] = [
        (string)$ref++,
        formatDateDMY((string)$r['date']),
        (string)$r['day'],

        (string)(int)$r['no_of_employee'],
        (string)(int)$r['no_of_guest'],
        (string)(int)$r['total_part1'],

        (string)(int)$r['total_head_counts_hr'],
        (string)(int)$r['security_guards_part2'],
        (string)(int)$r['guests_part2'],
        (string)(int)$r['total_part2'],
        (string)(int)$r['diff_part2'],
        number_format((float)$r['diff_percent_part2'], 2, '.', '') . "%",

        (string)(int)$r['attendance'],
        (string)(int)$r['security_guards_part3'],
        (string)(int)$r['guests_part3'],
        (string)(int)$r['total_part3'],
        (string)(int)$r['diff_part3'],
        number_format((float)$r['diff_percent_part3'], 2, '.', '') . "%",

        (string)$r['remarks'],
        (string)$r['form_user'],
        (string)$r['created_at'],
    ];
}
echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>;

function downloadPDF() {
    if (HAS_ERRORS) {
        alert("Fix filter errors first.");
        return;
    }

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'mm', 'a4'); // landscape

    doc.setFontSize(14);
    doc.text(REPORT_TITLE, 14, 14);

    doc.autoTable({
        startY: 20,
        head: [[
            "Ref#","Date","Day",
            "Emp","Guest","Total P1",
            "HR","Sec(P2)","Guest(P2)","Total P2","Diff2","Diff2%",
            "Att","Sec(P3)","Guest(P3)","Total P3","Diff3","Diff3%",
            "Remarks","User","Created"
        ]],
        body: EXPORT_ROWS,
        styles: { fontSize: 7 },
        headStyles: { fillColor: [33, 37, 41], textColor: 255 },
        columnStyles: {
            3:{ halign:'right' },4:{ halign:'right' },5:{ halign:'right' },
            6:{ halign:'right' },7:{ halign:'right' },8:{ halign:'right' },9:{ halign:'right' },10:{ halign:'right' },11:{ halign:'right' },
            12:{ halign:'right' },13:{ halign:'right' },14:{ halign:'right' },15:{ halign:'right' },16:{ halign:'right' },17:{ halign:'right' }
        }
    });

    const finalY = doc.lastAutoTable.finalY || 20;
    doc.setFontSize(11);
    // doc.text("TOTAL (Total P1): " + GRAND_TOTAL, 285, finalY + 10, { align: "right" });

    doc.save("lunch_report.pdf");
}
</script>

<!-- Year dropdown auto-jump to current year when opened (if All selected) -->
<script>
(function () {
  const yearSelect = document.getElementById('yearSelect');
  if (!yearSelect) return;

  const currentYear = new Date().getFullYear();

  function jumpToCurrentYearIfAll() {
    if (yearSelect.value === '') {
      const opt = yearSelect.querySelector('option[value="' + currentYear + '"]');
      if (opt) opt.selected = true;
    }
  }

  yearSelect.addEventListener('mousedown', jumpToCurrentYearIfAll);
  yearSelect.addEventListener('focus', jumpToCurrentYearIfAll);
})();
</script>

</body>
</html>
