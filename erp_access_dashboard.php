<?php
ob_start();
session_start();

if (!isset($_SESSION['loggedin'])) {
  header('Location: login.php');
  exit;
}

include "dbconfig.php";

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
$added_date = $_SESSION['added_date'] ?? '';

$be_depart = $_SESSION['be_depart'] ?? '';
$bc_role   = $_SESSION['be_role'] ?? '';

/* =========================
   Helper: dd-mm-yyyy
========================= */
function fmt_ddmmyyyy($val): string
{
  $val = trim((string)$val);
  if ($val === '' || $val === '0000-00-00' || $val === '0000-00-00 00:00:00') return '';
  try {
    $dt = new DateTime($val);
    return $dt->format('d-m-Y');
  } catch (Exception $e) {
    return htmlspecialchars($val);
  }
}

/* =========================================================
   ✅ ERP Access Dashboard (ENG_WORKORDER_RP style)
   - Server-side filters + pagination
   - Filters persist across pages via GET
   - Sticky header + 90vh scroll table wrapper
   - Total mint badge
========================================================= */
$perPage = 50;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$qRaw      = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
$fromDate  = isset($_GET['fromDate']) ? trim((string)$_GET['fromDate']) : '';
$toDate    = isset($_GET['toDate']) ? trim((string)$_GET['toDate']) : '';
$deptFilter = isset($_GET['department']) ? trim((string)$_GET['department']) : 'All';
$roleFilter = isset($_GET['roleFilter']) ? trim((string)$_GET['roleFilter']) : 'All';

$dateError = '';

/* Base WHERE (old dashboard = show all records) */
$whereParts = ["1=1"];

/* Search */
if ($qRaw !== '') {
  $q = mysqli_real_escape_string($conn, $qRaw);
  $like = "%{$q}%";
  $whereParts[] = "(
      CAST(id AS CHAR) LIKE '{$like}'
      OR name LIKE '{$like}'
      OR department LIKE '{$like}'
      OR role LIKE '{$like}'
      OR req_type LIKE '{$like}'
      OR scm_purchase LIKE '{$like}'
      OR scm_inventory LIKE '{$like}'
      OR scm_production LIKE '{$like}'
      OR scm_sales LIKE '{$like}'
      OR scm_misc LIKE '{$like}'
      OR scm_admin_setup LIKE '{$like}'
      OR scm_general_ledger LIKE '{$like}'
      OR scm_accounts_payable LIKE '{$like}'
      OR hcm LIKE '{$like}'
      OR message LIKE '{$like}'
      OR it_head_status LIKE '{$like}'
      OR department_head_status LIKE '{$like}'
      OR fc_status LIKE '{$like}'
      OR ceo_status LIKE '{$like}'
    )";
}

/* Department filter */
if ($deptFilter !== '' && $deptFilter !== 'All') {
  $deptSafe = mysqli_real_escape_string($conn, $deptFilter);
  $whereParts[] = "department = '{$deptSafe}'";
}

/* Role filter */
if ($roleFilter !== '' && $roleFilter !== 'All') {
  $roleSafe = mysqli_real_escape_string($conn, $roleFilter);
  $whereParts[] = "role = '{$roleSafe}'";
}

/* Date range validation + filter (uses real DB date) */
$hasFrom = ($fromDate !== '');
$hasTo   = ($toDate !== '');

if (($hasFrom && !$hasTo) || (!$hasFrom && $hasTo)) {
  $dateError = "Please select both From Date and To Date.";
} else if ($hasFrom && $hasTo) {
  $dfOk = (bool)preg_match('/^\d{4}-\d{2}-\d{2}$/', $fromDate);
  $dtOk = (bool)preg_match('/^\d{4}-\d{2}-\d{2}$/', $toDate);

  if (!$dfOk || !$dtOk) {
    $dateError = "Invalid date format. Please re-select dates.";
  } else {
    if (strtotime($toDate) < strtotime($fromDate)) {
      $dateError = "End date cannot be earlier than start date.";
    } else {
      $df = mysqli_real_escape_string($conn, $fromDate);
      $dt = mysqli_real_escape_string($conn, $toDate);
      $whereParts[] = "DATE(`date`) BETWEEN '{$df}' AND '{$dt}'";
    }
  }
}

$whereSql = implode(" AND ", $whereParts);

/* Count */
$countSql = "SELECT COUNT(*) AS total FROM erpaccess_form WHERE {$whereSql}";
$countQ = mysqli_query($conn, $countSql);
$countRow = mysqli_fetch_assoc($countQ);
$totalRows = (int)($countRow['total'] ?? 0);
$totalPages = ($totalRows > 0) ? (int)ceil($totalRows / $perPage) : 1;

if ($page > $totalPages) $page = $totalPages;
$offset = ($page - 1) * $perPage;

/* Fetch page */
$select = "SELECT * FROM erpaccess_form
           WHERE {$whereSql}
           ORDER BY `date` DESC, id DESC
           LIMIT {$perPage} OFFSET {$offset}";
$select_q = mysqli_query($conn, $select);
$data = mysqli_num_rows($select_q);

function pageUrl($p)
{
  $params = $_GET;
  $params['page'] = $p;
  $path = strtok($_SERVER["REQUEST_URI"], '?');
  return $path . '?' . http_build_query($params);
}

$from = ($totalRows === 0) ? 0 : ($offset + 1);
$to   = min($offset + $perPage, $totalRows);

$anyFilterOn = !(
  $qRaw === '' &&
  $fromDate === '' &&
  $toDate === '' &&
  $deptFilter === 'All' &&
  $roleFilter === 'All'
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ERP Access Dashboard</title>
  <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />

  <?php include 'cdncss.php' ?>
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
      vertical-align: top;
    }

    tr {
      border-bottom: 0.5px solid lightgray !important;
    }

    .td-wrap {
      max-width: 520px;
      white-space: normal !important;
      word-break: break-word;
      overflow-wrap: anywhere;
    }

    .box1-heading {
      font-weight: 700 !important;
    }

    a {
      text-decoration: none !important;
    }

    label {
      font-size: 13px !important;
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

    /* ✅ DataTable-like panel (same as eng_workorder_rp) */
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
      vertical-align: top !important;
    }

    .table-responsive.dt-wrap td {
      white-space: nowrap;
    }

    .table-responsive.dt-wrap td.td-wrap {
      white-space: normal !important;
      max-width: 520px;
      word-break: break-word;
      overflow-wrap: anywhere;
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

          <!-- Header -->
          <div class="card shadow-sm border-0 mb-3">
            <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
              <div>
                <h5 class="mb-0 box1-heading">ERP Access Dashboard</h5>
              </div>

              <a href="erp_access_home.php" class="btn btn-dark btn-sm">
                <i class="fa-solid fa-home me-1"></i> Home
              </a>
            </div>
          </div>

          <!-- Filters (same layout style as eng_workorder_rp) -->
          <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">

              <form id="filterForm" method="GET" action="" class="row g-2 align-items-end">

                <div class="col-12 col-lg-3">
                  <label class="form-label fw-bold small">Search</label>
                  <input class="form-control form-control-sm" id="q" name="q" type="text"
                    placeholder="Type and press Apply..."
                    value="<?php echo htmlspecialchars($qRaw); ?>">
                </div>

                <div class="col-6 col-lg-2">
                  <label class="form-label fw-bold small">From Date</label>
                  <input class="form-control form-control-sm" type="date" id="fromDate" name="fromDate"
                    value="<?php echo htmlspecialchars($fromDate); ?>">
                </div>

                <div class="col-6 col-lg-2">
                  <label class="form-label fw-bold small">To Date</label>
                  <input class="form-control form-control-sm" type="date" id="toDate" name="toDate"
                    value="<?php echo htmlspecialchars($toDate); ?>">
                </div>

                <div class="col-6 col-lg-2">
                  <label class="form-label fw-bold small">Department</label>
                  <select class="form-select form-select-sm" id="departmentFilter" name="department">
                    <option value="All" <?php echo ($deptFilter === 'All' ? 'selected' : ''); ?>>All</option>
                    <?php
                    // ✅ Build department list dynamically (safer than hardcoding)
                    $deptRes = mysqli_query($conn, "SELECT DISTINCT department FROM erpaccess_form WHERE department <> '' ORDER BY department ASC");
                    if ($deptRes) {
                      while ($drow = mysqli_fetch_assoc($deptRes)) {
                        $dval = (string)($drow['department'] ?? '');
                        if ($dval === '') continue;
                        $sel = ($deptFilter === $dval) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($dval) . '" ' . $sel . '>' . htmlspecialchars($dval) . '</option>';
                      }
                    }
                    ?>
                  </select>
                </div>

                <div class="col-6 col-lg-2">
                  <label class="form-label fw-bold small">Role</label>
                  <select class="form-select form-select-sm" id="roleFilter" name="roleFilter">
                    <option value="All" <?php echo ($roleFilter === 'All' ? 'selected' : ''); ?>>All</option>
                    <?php
                    $roleRes = mysqli_query($conn, "SELECT DISTINCT role FROM erpaccess_form WHERE role <> '' ORDER BY role ASC");
                    if ($roleRes) {
                      while ($rrow = mysqli_fetch_assoc($roleRes)) {
                        $rval = (string)($rrow['role'] ?? '');
                        if ($rval === '') continue;
                        $sel = ($roleFilter === $rval) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($rval) . '" ' . $sel . '>' . htmlspecialchars($rval) . '</option>';
                      }
                    }
                    ?>
                  </select>
                </div>

                <div class="col-6 col-lg-1 d-grid">
                  <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-filter me-1"></i> Apply
                  </button>
                </div>

                <div class="col-6 col-lg-1 d-grid">
                  <button id="resetBtn" type="button" class="btn btn-reset btn-sm border"
                    style="<?php echo ($anyFilterOn ? '' : 'display:none;'); ?>">
                    <i class="fa-solid fa-rotate-left me-1"></i> Reset
                  </button>
                </div>

                <div class="col-12 col-lg-2 d-flex">
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

          <!-- Table -->
          <div class="card shadow-sm border-0">
            <div class="card-body">

              <div class="table-responsive dt-wrap">
                <table class="table table-hover align-middle mb-0" id="myTable">
                  <thead>
                    <tr>
                      <th>Report</th>
                      <th>Ref#</th>
                      <th>Name</th>
                      <th>Department</th>
                      <th>Role</th>
                      <th>Date</th>
                      <th>Req Type</th>
                      <th>SCM Purchase</th>
                      <th>SCM Inventory</th>
                      <th>SCM Production</th>
                      <th>SCM Sales</th>
                      <th>SCM Misc</th>
                      <th>SCM Admin Setup</th>
                      <th>SCM General Ledger</th>
                      <th>Accounts Payable</th>
                      <th>HCM</th>
                      <th>Message</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    if ($data) {
                      while ($row = mysqli_fetch_assoc($select_q)) {
                        $rid = (int)($row['id'] ?? 0);
                        $dateShow = fmt_ddmmyyyy($row['date'] ?? '');
                    ?>
                        <tr id="row_<?php echo $rid; ?>">


                          <td style="white-space:nowrap;">
                            <a href="erp_dashboard_details.php?id=<?php echo $rid; ?>" class="btn-details">
                              <i class="fa-solid fa-arrow-up me-1"></i> Report
                            </a>
                          </td>
                          <td><?php echo htmlspecialchars((string)($row['id'] ?? '')); ?></td>
                          <td class="td-wrap"><?php echo htmlspecialchars((string)($row['name'] ?? '')); ?></td>
                          <td class="td-wrap"><?php echo htmlspecialchars((string)($row['department'] ?? '')); ?></td>
                          <td class="td-wrap"><?php echo htmlspecialchars((string)($row['role'] ?? '')); ?></td>
                          <td style="white-space:nowrap;"><?php echo htmlspecialchars($dateShow); ?></td>
                          <td class="td-wrap"><?php echo htmlspecialchars((string)($row['req_type'] ?? '')); ?></td>

                          <td><?php echo htmlspecialchars((string)($row['scm_purchase'] ?? '')); ?></td>
                          <td><?php echo htmlspecialchars((string)($row['scm_inventory'] ?? '')); ?></td>
                          <td><?php echo htmlspecialchars((string)($row['scm_production'] ?? '')); ?></td>
                          <td><?php echo htmlspecialchars((string)($row['scm_sales'] ?? '')); ?></td>
                          <td><?php echo htmlspecialchars((string)($row['scm_misc'] ?? '')); ?></td>
                          <td><?php echo htmlspecialchars((string)($row['scm_admin_setup'] ?? '')); ?></td>
                          <td><?php echo htmlspecialchars((string)($row['scm_general_ledger'] ?? '')); ?></td>
                          <td><?php echo htmlspecialchars((string)($row['scm_accounts_payable'] ?? '')); ?></td>
                          <td><?php echo htmlspecialchars((string)($row['hcm'] ?? '')); ?></td>

                          <td class="td-wrap"><?php echo htmlspecialchars((string)($row['message'] ?? '')); ?></td>
                        </tr>
                    <?php
                      }
                    } else {
                      echo "<tr><td colspan='16' class='text-muted fw-semibold p-3'>No record found!</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>

              <!-- Pagination (same style as eng_workorder_rp) -->
              <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
                <div class="text-muted small fw-semibold">
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
          </div>

        </div>
      </div>
    </div>

    <script>
      document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("filterForm");
        const resetBtn = document.getElementById("resetBtn");

        // Force page=1 on Apply
        form.addEventListener("submit", function() {
          const existing = form.querySelector('input[name="page"]');
          if (existing) existing.remove();

          const pageInput = document.createElement("input");
          pageInput.type = "hidden";
          pageInput.name = "page";
          pageInput.value = "1";
          form.appendChild(pageInput);
        });

        // Reset all filters
        resetBtn?.addEventListener("click", function() {
          const url = new URL(window.location.href);
          url.searchParams.delete('q');
          url.searchParams.delete('fromDate');
          url.searchParams.delete('toDate');
          url.searchParams.delete('department');
          url.searchParams.delete('roleFilter');
          url.searchParams.set('page', '1');
          window.location.href = url.toString();
        });
      });
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>
<?php ob_end_flush(); ?>