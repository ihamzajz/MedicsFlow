<?php
ob_start();
session_start();
include "dbconfig.php";

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

date_default_timezone_set("Asia/Karachi");

/* =========================
   Session
========================= */
$id         = $_SESSION['id'] ?? '';
$fullname   = $_SESSION['fullname'] ?? '';
$username   = $_SESSION['username'] ?? '';
$password   = $_SESSION['password'] ?? '';
$email      = $_SESSION['email'] ?? '';
$gender     = $_SESSION['gender'] ?? '';
$department = $_SESSION['department'] ?? '';
$role       = $_SESSION['role'] ?? '';

$be_depart  = $_SESSION['be_depart'] ?? '';
$bc_role    = $_SESSION['be_role'] ?? '';

/* =========================================================
   ✅ Approve / Reject (SAME PAGE + saves admin_msg/admin_date)
   - NO message
   - PRG redirect to same URL to avoid resubmit
========================================================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cp_action'], $_POST['cp_id'])) {
    $cpid = (int)($_POST['cp_id'] ?? 0);
    $act  = (string)($_POST['cp_action'] ?? '');

    if ($cpid > 0 && ($act === 'approve' || $act === 'reject')) {
        $approver_name = $_SESSION['fullname'] ?? '';
        $now = date('Y-m-d H:i:s');

        if ($act === 'approve') {
            $newStatus = 'Approved';
            $msg = "Approved By $approver_name";
        } else {
            $newStatus = 'Rejected';
            $msg = "Rejected By $approver_name";
        }

        $status_safe = mysqli_real_escape_string($conn, $newStatus);
        $msg_safe    = mysqli_real_escape_string($conn, $msg);
        $now_safe    = mysqli_real_escape_string($conn, $now);

        $update = "UPDATE cash_purchase
               SET admin_status = '{$status_safe}',
                   admin_msg    = '{$msg_safe}',
                   admin_date   = '{$now_safe}'
               WHERE id = {$cpid}";
        mysqli_query($conn, $update);
    }

    $redirect = strtok($_SERVER["REQUEST_URI"], '?');
    $qs = $_SERVER['QUERY_STRING'] ?? '';
    header("Location: " . $redirect . ($qs ? ("?" . $qs) : ""));
    exit;
}

/* =========================================================
   ✅ Server-side Pagination + Search + Date Range + Status Filters
========================================================= */
$perPage = 50;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$qRaw      = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
$dateFrom  = isset($_GET['dateFrom']) ? trim((string)$_GET['dateFrom']) : '';
$dateTo    = isset($_GET['dateTo']) ? trim((string)$_GET['dateTo']) : '';

/* ✅ NEW filters */
$adminFilter   = isset($_GET['adminStatus']) ? trim((string)$_GET['adminStatus']) : 'All';
$financeFilter = isset($_GET['financeStatus']) ? trim((string)$_GET['financeStatus']) : 'All';
$finalFilter   = isset($_GET['finalStatus']) ? trim((string)$_GET['finalStatus']) : 'All';

$dateError = '';

$whereParts = [];
$whereParts[] = "1=1";

/* Search */
if ($qRaw !== '') {
    $q = mysqli_real_escape_string($conn, $qRaw);
    $like = "%{$q}%";
    $whereParts[] = "(
      CAST(id AS CHAR) LIKE '{$like}'
      OR name LIKE '{$like}'
      OR department LIKE '{$like}'
      OR admin_status LIKE '{$like}'
      OR finance_status LIKE '{$like}'
      OR status LIKE '{$like}'
      OR total_amount LIKE '{$like}'
      OR date LIKE '{$like}'
    )";
}

/* ✅ Admin status filter */
$validAR = ['All','Pending','Approved','Rejected'];
if (!in_array($adminFilter, $validAR, true)) $adminFilter = 'All';
if ($adminFilter !== 'All') {
    $a = mysqli_real_escape_string($conn, $adminFilter);
    $whereParts[] = "admin_status = '{$a}'";
}

/* ✅ Finance status filter */
$validFR = ['All','Pending','Approved','Rejected'];
if (!in_array($financeFilter, $validFR, true)) $financeFilter = 'All';
if ($financeFilter !== 'All') {
    $f = mysqli_real_escape_string($conn, $financeFilter);
    $whereParts[] = "finance_status = '{$f}'";
}

/* ✅ Final status filter (Open/Closed) */
$validFinal = ['All','Open','Closed'];
if (!in_array($finalFilter, $validFinal, true)) $finalFilter = 'All';
if ($finalFilter !== 'All') {
    $s = mysqli_real_escape_string($conn, $finalFilter);
    $whereParts[] = "status = '{$s}'";
}

/* Date range validation + filter */
$hasFrom = ($dateFrom !== '');
$hasTo   = ($dateTo !== '');

if (($hasFrom && !$hasTo) || (!$hasFrom && $hasTo)) {
    $dateError = "Please select both Date From and Date To.";
} else if ($hasFrom && $hasTo) {
    $dfOk = (bool)preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateFrom);
    $dtOk = (bool)preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateTo);

    if (!$dfOk || !$dtOk) {
        $dateError = "Invalid date format. Please re-select dates.";
    } else {
        if (strtotime($dateTo) < strtotime($dateFrom)) {
            $dateError = "End date cannot be earlier than start date.";
        } else {
            $df = mysqli_real_escape_string($conn, $dateFrom);
            $dt = mysqli_real_escape_string($conn, $dateTo);
            $whereParts[] = "DATE(`date`) BETWEEN '{$df}' AND '{$dt}'";
        }
    }
}

$whereSql = implode(" AND ", $whereParts);

/* Count */
$countSql = "SELECT COUNT(*) AS total FROM cash_purchase WHERE {$whereSql}";
$countQ = mysqli_query($conn, $countSql);
$countRow = mysqli_fetch_assoc($countQ);
$totalRows = (int)($countRow['total'] ?? 0);
$totalPages = ($totalRows > 0) ? (int)ceil($totalRows / $perPage) : 1;

if ($page > $totalPages) $page = $totalPages;
$offset = ($page - 1) * $perPage;

/* Fetch page */
$select = "SELECT * FROM cash_purchase
           WHERE {$whereSql}
           ORDER BY date DESC, id DESC
           LIMIT {$perPage} OFFSET {$offset}";
$select_q = mysqli_query($conn, $select);
$data = mysqli_num_rows($select_q);

/* Helper: keep filters in pagination */
function pageUrl($p)
{
    $params = $_GET;
    $params['page'] = $p;
    $path = strtok($_SERVER["REQUEST_URI"], '?');
    return $path . '?' . http_build_query($params);
}

/* for reset button visibility */
$anyFilterOn = !(
    $qRaw === '' &&
    $dateFrom === '' &&
    $dateTo === '' &&
    $adminFilter === 'All' &&
    $financeFilter === 'All' &&
    $finalFilter === 'All'
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cash Purchase - Admin Approval</title>
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

        th {
            white-space: nowrap;
            font-size: 11.5px;
            border: none !important;
            background-color: #3a506b !important;
            color: white !important;
            font-weight: 600;
        }

        .table tbody td {
            font-size: 11px;
            border: none !important;
            font-weight: 400;
            vertical-align: middle;
        }

        tr {
            border-bottom: 0.5px solid lightgray !important;
        }

        a {
            text-decoration: none !important;
        }

        .btn-details {
            font-size: 11px;
            font-weight: 600 !important;
            color: white;
            background-color: #7c3aed;
            padding: 7px 10px !important;
            border-radius: 3px !important;
            display: inline-block;
            white-space: nowrap;
        }

        label {
            font-size: 12px !important;
            font-weight: 700;
        }

        input,
        select {
            border: 0.5px solid #ced4da !important;
            font-size: 12px !important;
        }

        .btn-reset {
            background-color: #ced4da !important;
        }

        .mint-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: #d1fae5;
            color: #065f46;
            font-weight: 700;
            font-size: 12px;
            border: 1px solid #a7f3d0;
            white-space: nowrap;
            line-height: 1;
        }

        .mint-badge i {
            color: #0f766e;
        }

        .btn-success,
        .btn-danger {
            font-size: 11px !important;
            font-weight: 600 !important;
        }

        /* ✅ table 90vh + scrollbars + sticky header */
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
        }

        .table-responsive.dt-wrap th,
        .table-responsive.dt-wrap td {
            padding: 12px 12px !important;
            vertical-align: middle !important;
        }

        .table-responsive.dt-wrap td {
            white-space: nowrap;
        }

        .table-responsive.dt-wrap tbody tr:hover td {
            background: #f8fbff;
        }

        .table-responsive.dt-wrap tbody tr:nth-child(even) td {
            background: #fbfdff;
        }

        .table-responsive.dt-wrap tbody td {
            border-bottom: 1px solid #e5e7eb !important;
        }

        .table-responsive.dt-wrap::-webkit-scrollbar {
            height: 10px;
            width: 10px;
        }

        .table-responsive.dt-wrap::-webkit-scrollbar-thumb {
            background: #c7ced8;
            border-radius: 999px;
        }

        .table-responsive.dt-wrap::-webkit-scrollbar-track {
            background: #eef2f7;
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
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </nav>

            <div class="container-fluid py-3">
                <div class="container-xxl">

                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div>
                                <h5 class="mb-0" style="font-weight:700;">Admin Approval</h5>
                            </div>
                            <div class="d-flex gap-2 align-items-center flex-wrap">
                                <a class="btn btn-dark btn-sm" href="cash_purchase_home.php">
                                    <i class="fa-solid fa-home me-1"></i> Home
                                </a>
                                <button id="exportBtn" class="btn btn-success btn-sm">
                                    <i class="fa-solid fa-file-excel me-1"></i> Export to Excel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- ✅ Filters row (NEW: Admin/Finance/Final status dropdowns) -->
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body">
                            <form id="searchForm" method="GET" action="" class="row g-2 align-items-end">

                                <div class="col-12 col-lg-3">
                                    <label class="form-label small mb-1">Search</label>
                                    <input class="form-control form-control-sm" id="q" name="q" type="text"
                                        placeholder="Type and press Search..."
                                        value="<?php echo htmlspecialchars($qRaw); ?>">
                                </div>

                                <div class="col-6 col-lg-2">
                                    <label class="form-label small mb-1">Date From</label>
                                    <input class="form-control form-control-sm" type="date" id="dateFrom" name="dateFrom"
                                        value="<?php echo htmlspecialchars($dateFrom); ?>">
                                </div>

                                <div class="col-6 col-lg-2">
                                    <label class="form-label small mb-1">Date To</label>
                                    <input class="form-control form-control-sm" type="date" id="dateTo" name="dateTo"
                                        value="<?php echo htmlspecialchars($dateTo); ?>">
                                </div>

                                <div class="col-6 col-lg-2">
                                    <label class="form-label small mb-1">Admin Status</label>
                                    <select class="form-select form-select-sm" id="adminStatus" name="adminStatus">
                                        <option value="All" <?php echo ($adminFilter === 'All' ? 'selected' : ''); ?>>All</option>
                                        <option value="Pending" <?php echo ($adminFilter === 'Pending' ? 'selected' : ''); ?>>Pending</option>
                                        <option value="Approved" <?php echo ($adminFilter === 'Approved' ? 'selected' : ''); ?>>Approved</option>
                                        <option value="Rejected" <?php echo ($adminFilter === 'Rejected' ? 'selected' : ''); ?>>Rejected</option>
                                    </select>
                                </div>

                                <div class="col-6 col-lg-2">
                                    <label class="form-label small mb-1">Finance Status</label>
                                    <select class="form-select form-select-sm" id="financeStatus" name="financeStatus">
                                        <option value="All" <?php echo ($financeFilter === 'All' ? 'selected' : ''); ?>>All</option>
                                        <option value="Pending" <?php echo ($financeFilter === 'Pending' ? 'selected' : ''); ?>>Pending</option>
                                        <option value="Approved" <?php echo ($financeFilter === 'Approved' ? 'selected' : ''); ?>>Approved</option>
                                        <option value="Rejected" <?php echo ($financeFilter === 'Rejected' ? 'selected' : ''); ?>>Rejected</option>
                                    </select>
                                </div>

                                <div class="col-6 col-lg-2">
                                    <label class="form-label small mb-1">Final Status</label>
                                    <select class="form-select form-select-sm" id="finalStatus" name="finalStatus">
                                        <option value="All" <?php echo ($finalFilter === 'All' ? 'selected' : ''); ?>>All</option>
                                        <option value="Open" <?php echo ($finalFilter === 'Open' ? 'selected' : ''); ?>>Open</option>
                                        <option value="Closed" <?php echo ($finalFilter === 'Closed' ? 'selected' : ''); ?>>Closed</option>
                                    </select>
                                </div>

                                <div class="col-6 col-lg-1 d-grid">
                                    <button id="searchBtn" type="submit" class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-magnifying-glass me-1"></i> Search
                                    </button>
                                </div>

                                <div class="col-6 col-lg-1 d-grid">
                                    <button
                                        id="resetBtn"
                                        type="button"
                                        class="btn btn-reset btn-sm border"
                                        style="<?php echo ($anyFilterOn ? '' : 'display:none;'); ?>">
                                        <i class="fa-solid fa-rotate-left me-1"></i> Reset
                                    </button>
                                </div>

                                <div class="col-12 col-lg-3 d-flex">
                                    <div class="mint-badge">
                                        <i class="fa-solid fa-database"></i>
                                        Total: <?php echo (int)$totalRows; ?>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <?php if ($dateError !== '') { ?>
                                        <div id="dateErrorBox" class="alert alert-danger py-2 mb-0 small fw-semibold">
                                            <?php echo htmlspecialchars($dateError); ?>
                                        </div>
                                    <?php } else { ?>
                                        <div id="dateErrorBox" class="alert alert-danger py-2 mb-0 small fw-semibold" style="display:none;"></div>
                                    <?php } ?>
                                </div>

                            </form>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body">

                            <div class="table-responsive dt-wrap">
                                <table class="table table-hover align-middle mb-0" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>Details</th>
                                            <th colspan="2">Action</th>
                                            <th>Ref#</th>
                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>Date</th>
                                            <th>Total Requested Amount</th>
                                            <th>Total Evidence Amount</th>
                                            <th>Admin Status</th>
                                            <th>Finance Status</th>
                                            <th>Final Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        if ($data) {
                                            while ($row = mysqli_fetch_assoc($select_q)) {
                                                $rid = (int)$row['id'];

                                                $evidenceNumbers = json_decode($row['evidence_numbers'] ?? '[]', true);
                                                $sumEvidence = 0;
                                                if (is_array($evidenceNumbers) && !empty($evidenceNumbers)) {
                                                    $sumEvidence = array_sum(array_map('floatval', $evidenceNumbers));
                                                }

                                                $adminStatusVal = trim((string)($row['admin_status'] ?? 'Pending'));
                                                if ($adminStatusVal === '') $adminStatusVal = 'Pending';

                                                $dateOnly = '';
                                                if (!empty($row['date'])) {
                                                    $dateOnly = date('d-m-Y', strtotime($row['date']));
                                                }
                                        ?>
                                                <tr id="row_<?php echo $rid; ?>">
                                                    <td style="white-space:nowrap;">
                                                        <a href="cash_purchase_admin_details.php?id=<?php echo $rid; ?>" class="btn-details">
                                                            <i class="fa-solid fa-arrow-up me-1"></i> Details
                                                        </a>
                                                    </td>

                                                    <?php if (strcasecmp($adminStatusVal, 'Pending') === 0) { ?>
                                                        <td style="white-space:nowrap;">
                                                            <form method="POST" action="" class="m-0">
                                                                <input type="hidden" name="cp_id" value="<?php echo $rid; ?>">
                                                                <input type="hidden" name="cp_action" value="approve">
                                                                <button type="submit" class="btn btn-success btn-sm">
                                                                    <i class="fa-solid fa-check me-1"></i> Approve
                                                                </button>
                                                            </form>
                                                        </td>
                                                        <td style="white-space:nowrap;">
                                                            <form method="POST" action="" class="m-0">
                                                                <input type="hidden" name="cp_id" value="<?php echo $rid; ?>">
                                                                <input type="hidden" name="cp_action" value="reject">
                                                                <button type="submit" class="btn btn-danger btn-sm">
                                                                    <i class="fa-solid fa-xmark me-1"></i> Reject
                                                                </button>
                                                            </form>
                                                        </td>
                                                    <?php } else if (strcasecmp($adminStatusVal, 'Approved') === 0) { ?>
                                                        <td style="white-space:nowrap;">
                                                            <span class="text-success fw-bold">Approved</span>
                                                        </td>
                                                        <td></td>
                                                    <?php } else if (strcasecmp($adminStatusVal, 'Rejected') === 0) { ?>
                                                        <td style="white-space:nowrap;">
                                                            <span class="text-danger fw-bold">Rejected</span>
                                                        </td>
                                                        <td></td>
                                                    <?php } else { ?>
                                                        <td style="white-space:nowrap;"><?php echo htmlspecialchars($adminStatusVal); ?></td>
                                                        <td></td>
                                                    <?php } ?>

                                                    <td><?php echo htmlspecialchars((string)$row['id']); ?></td>
                                                    <td><?php echo htmlspecialchars((string)$row['name']); ?></td>
                                                    <td><?php echo htmlspecialchars((string)$row['department']); ?></td>
                                                    <td style="white-space:nowrap;"><?php echo htmlspecialchars($dateOnly); ?></td>
                                                    <td><?php echo htmlspecialchars((string)$row['total_amount']); ?></td>
                                                    <td><?php echo htmlspecialchars((string)$sumEvidence); ?></td>
                                                    <td><?php echo htmlspecialchars((string)$row['admin_status']); ?></td>
                                                    <td><?php echo htmlspecialchars((string)$row['finance_status']); ?></td>
                                                    <td><?php echo htmlspecialchars((string)$row['status']); ?></td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='12' class='text-muted fw-semibold p-3'>No record found!</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- ✅ Pagination -->
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
                                <div class="text-muted small fw-semibold">
                                    <?php
                                    $from = ($totalRows === 0) ? 0 : ($offset + 1);
                                    $to = min($offset + $perPage, $totalRows);
                                    echo "Showing {$from}-{$to} of {$totalRows} | Page {$page} of {$totalPages}";
                                    ?>
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
                    </div>

                </div>
            </div>

        </div>
    </div>

    <?php include 'footer.php'; ?>
    <?php include 'cdnjs.php'; ?>

    <script>
        $(document).ready(function() {
            $('#sidebar1').addClass('active');
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar1').toggleClass('active');
            });
            $('[data-bs-toggle="collapse"]').on('click', function() {
                var target = $(this).find('.toggle-icon');
                if ($(this).attr('aria-expanded') === 'true') {
                    target.removeClass('fa-plus').addClass('fa-minus');
                } else {
                    target.removeClass('fa-minus').addClass('fa-plus');
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

    <!-- ✅ Export visible rows (this page) -->
    <script>
        document.getElementById('exportBtn').addEventListener('click', function() {
            var data = [];

            data.push([
                'Ref#',
                'Name',
                'Department',
                'Date',
                'Total Requested Amount',
                'Total Evidence Amount',
                'Admin Status',
                'Finance Status',
                'Final Status'
            ]);

            $('#myTable tbody tr:visible').each(function() {
                var cols = $(this).find('td');

                data.push([
                    cols.eq(3).text().trim(), // Ref#
                    cols.eq(4).text().trim(), // Name
                    cols.eq(5).text().trim(), // Department
                    cols.eq(6).text().trim(), // Date
                    cols.eq(7).text().trim(), // Total Requested
                    cols.eq(8).text().trim(), // Evidence
                    cols.eq(9).text().trim(), // Admin Status
                    cols.eq(10).text().trim(), // Finance Status
                    cols.eq(11).text().trim() // Final Status
                ]);
            });

            if (data.length === 1) {
                alert('No data to export');
                return;
            }

            var wb = XLSX.utils.book_new();
            var ws = XLSX.utils.aoa_to_sheet(data);
            XLSX.utils.book_append_sheet(wb, ws, 'Admin Approval');

            XLSX.writeFile(wb, 'admin_approval_list.xlsx');
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("searchForm");
            const q = document.getElementById("q");
            const dateFrom = document.getElementById("dateFrom");
            const dateTo = document.getElementById("dateTo");
            const resetBtn = document.getElementById("resetBtn");
            const errBox = document.getElementById("dateErrorBox");

            function showErr(msg) {
                errBox.textContent = msg;
                errBox.style.display = msg ? "block" : "none";
            }

            function validateDates() {
                const df = (dateFrom.value || "").trim();
                const dt = (dateTo.value || "").trim();

                if ((df && !dt) || (!df && dt)) {
                    showErr("Please select both Date From and Date To.");
                    return false;
                }
                if (df && dt && dt < df) {
                    showErr("End date cannot be earlier than start date.");
                    return false;
                }
                showErr("");
                return true;
            }

            dateFrom.addEventListener("change", validateDates);
            dateTo.addEventListener("change", validateDates);

            form.addEventListener("submit", function(e) {
                e.preventDefault();
                if (!validateDates()) return;

                const url = new URL(window.location.href);

                const term = (q.value || "").trim();
                const df = (dateFrom.value || "").trim();
                const dt = (dateTo.value || "").trim();

                const a = (document.getElementById("adminStatus").value || "All").trim();
                const f = (document.getElementById("financeStatus").value || "All").trim();
                const s = (document.getElementById("finalStatus").value || "All").trim();

                if (term === "") url.searchParams.delete("q");
                else url.searchParams.set("q", term);

                if (df === "") url.searchParams.delete("dateFrom");
                else url.searchParams.set("dateFrom", df);

                if (dt === "") url.searchParams.delete("dateTo");
                else url.searchParams.set("dateTo", dt);

                if (a === "All") url.searchParams.delete("adminStatus");
                else url.searchParams.set("adminStatus", a);

                if (f === "All") url.searchParams.delete("financeStatus");
                else url.searchParams.set("financeStatus", f);

                if (s === "All") url.searchParams.delete("finalStatus");
                else url.searchParams.set("finalStatus", s);

                url.searchParams.set("page", "1");
                window.location.href = url.toString();
            });

            resetBtn.addEventListener("click", function() {
                const url = new URL(window.location.href);
                url.searchParams.delete("q");
                url.searchParams.delete("dateFrom");
                url.searchParams.delete("dateTo");
                url.searchParams.delete("adminStatus");
                url.searchParams.delete("financeStatus");
                url.searchParams.delete("finalStatus");
                url.searchParams.set("page", "1");
                window.location.href = url.toString();
            });
        });
    </script>

</body>

</html>
