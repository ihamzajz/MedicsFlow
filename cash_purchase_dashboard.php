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
   ✅ Server-side: Filters + Pagination (same system as your other pages)
========================================================= */
$perPage = 50;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$qRaw        = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
$dateFrom    = isset($_GET['dateFrom']) ? trim((string)$_GET['dateFrom']) : '';
$dateTo      = isset($_GET['dateTo']) ? trim((string)$_GET['dateTo']) : '';
$amountRange = isset($_GET['amountRange']) ? trim((string)$_GET['amountRange']) : 'all';
$deptFilter  = isset($_GET['dept']) ? trim((string)$_GET['dept']) : 'all';
$finStatus   = isset($_GET['financeStatus']) ? trim((string)$_GET['financeStatus']) : 'all';
$admStatus   = isset($_GET['adminStatus']) ? trim((string)$_GET['adminStatus']) : 'all';
$finalStatus = isset($_GET['finalStatus']) ? trim((string)$_GET['finalStatus']) : 'all';

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
      OR total_amount LIKE '{$like}'
      OR admin_status LIKE '{$like}'
      OR finance_status LIKE '{$like}'
      OR status LIKE '{$like}'
      OR date LIKE '{$like}'
    )";
}

/* Date range */
$hasFrom = ($dateFrom !== '');
$hasTo   = ($dateTo !== '');

if (($hasFrom && !$hasTo) || (!$hasFrom && $hasTo)) {
  $dateError = "Please select both Date From and Date To.";
} else if ($hasFrom && $hasTo) {
  $dfOk = (bool)preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateFrom);
  $dtOk = (bool)preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateTo);

  if (!$dfOk || !$dtOk) {
    $dateError = "Invalid date format. Please re-select dates.";
  } else if (strtotime($dateTo) < strtotime($dateFrom)) {
    $dateError = "End date cannot be earlier than start date.";
  } else {
    $df = mysqli_real_escape_string($conn, $dateFrom);
    $dt = mysqli_real_escape_string($conn, $dateTo);
    $whereParts[] = "DATE(`date`) BETWEEN '{$df}' AND '{$dt}'";
  }
}

/* Amount range (total_amount) */
$minAmt = 0;
$maxAmt = PHP_INT_MAX;
$amountRange = ($amountRange === '') ? 'all' : $amountRange;

if ($amountRange !== 'all') {
  if ($amountRange === '100000+') {
    $minAmt = 100000;
    $maxAmt = PHP_INT_MAX;
  } else if (preg_match('/^\d+\-\d+$/', $amountRange)) {
    [$a, $b] = explode('-', $amountRange);
    $minAmt = (int)$a;
    $maxAmt = (int)$b;
  }
  $whereParts[] = "(CAST(total_amount AS DECIMAL(18,2)) >= {$minAmt} AND CAST(total_amount AS DECIMAL(18,2)) <= {$maxAmt})";
}

/* Department */
if ($deptFilter !== '' && $deptFilter !== 'all') {
  $deptSafe = mysqli_real_escape_string($conn, $deptFilter);
  $whereParts[] = "department = '{$deptSafe}'";
}

/* Status filters */
if ($finStatus !== '' && $finStatus !== 'all') {
  $fs = mysqli_real_escape_string($conn, $finStatus);
  $whereParts[] = "finance_status = '{$fs}'";
}
if ($admStatus !== '' && $admStatus !== 'all') {
  $as = mysqli_real_escape_string($conn, $admStatus);
  $whereParts[] = "admin_status = '{$as}'";
}
if ($finalStatus !== '' && $finalStatus !== 'all') {
  $st = mysqli_real_escape_string($conn, $finalStatus);
  $whereParts[] = "status = '{$st}'";
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

/* Helper */
function pageUrl($p)
{
  $params = $_GET;
  $params['page'] = $p;
  $path = strtok($_SERVER["REQUEST_URI"], '?');
  return $path . '?' . http_build_query($params);
}
function sel($val, $cur)
{
  return ((string)$val === (string)$cur) ? 'selected' : '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cash Purchase - Dashboard</title>
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

    /* ✅ Same modern table panel as your admin/finance pages */
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

          <!-- Header card -->
          <div class="card shadow-sm border-0 mb-3">
            <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
              <div>
                <h5 class="mb-0" style="font-weight:700;">Cash Purchase Dashboard</h5>
              </div>

              <div class="d-flex gap-2 align-items-center flex-wrap">
                <a href="cash_purchase_home.php" class="btn btn-dark btn-sm">
                  <i class="fa-solid fa-home me-1"></i> Home
                </a>
              </div>
            </div>
          </div>

          <!-- Filters card -->
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
                  <label class="form-label small mb-1">Amount Range</label>
                  <select id="amountRange" name="amountRange" class="form-select form-select-sm">
                    <option value="all" <?php echo sel('all', $amountRange); ?>>All</option>
                    <option value="0-1000" <?php echo sel('0-1000', $amountRange); ?>>0 - 1,000</option>
                    <option value="1000-10000" <?php echo sel('1000-10000', $amountRange); ?>>1,000 - 10,000</option>
                    <option value="10000-100000" <?php echo sel('10000-100000', $amountRange); ?>>10,000 - 100,000</option>
                    <option value="100000+" <?php echo sel('100000+', $amountRange); ?>>100,000+</option>
                  </select>
                </div>

                <div class="col-6 col-lg-2">
                  <label class="form-label small mb-1">Department</label>
                  <select id="dept" name="dept" class="form-select form-select-sm">
                    <option value="all" <?php echo sel('all', $deptFilter); ?>>All</option>
                    <option value="Finance" <?php echo sel('Finance', $deptFilter); ?>>Finance</option>
                    <option value="Information Technology" <?php echo sel('Information Technology', $deptFilter); ?>>Information Technology</option>
                    <option value="Director" <?php echo sel('Director', $deptFilter); ?>>Director</option>
                    <option value="Production" <?php echo sel('Production', $deptFilter); ?>>Production</option>
                    <option value="Administration." <?php echo sel('Administration.', $deptFilter); ?>>Administration.</option>
                    <option value="Engineering" <?php echo sel('Engineering', $deptFilter); ?>>Engineering</option>
                    <option value="Supply Chain" <?php echo sel('Supply Chain', $deptFilter); ?>>Supply Chain</option>
                    <option value="Marketing" <?php echo sel('Marketing', $deptFilter); ?>>Marketing</option>
                    <option value="Commercial" <?php echo sel('Commercial', $deptFilter); ?>>Commercial</option>
                  </select>
                </div>

                <div class="col-6 col-lg-2">
                  <label class="form-label small mb-1">Finance Status</label>
                  <select id="financeStatus" name="financeStatus" class="form-select form-select-sm">
                    <option value="all" <?php echo sel('all', $finStatus); ?>>All</option>
                    <option value="Pending" <?php echo sel('Pending', $finStatus); ?>>Pending</option>
                    <option value="Approved" <?php echo sel('Approved', $finStatus); ?>>Approved</option>
                    <option value="Rejected" <?php echo sel('Rejected', $finStatus); ?>>Rejected</option>
                  </select>
                </div>

                <div class="col-6 col-lg-2">
                  <label class="form-label small mb-1">Admin Status</label>
                  <select id="adminStatus" name="adminStatus" class="form-select form-select-sm">
                    <option value="all" <?php echo sel('all', $admStatus); ?>>All</option>
                    <option value="Pending" <?php echo sel('Pending', $admStatus); ?>>Pending</option>
                    <option value="Approved" <?php echo sel('Approved', $admStatus); ?>>Approved</option>
                    <option value="Rejected" <?php echo sel('Rejected', $admStatus); ?>>Rejected</option>
                  </select>
                </div>

                <div class="col-6 col-lg-2">
                  <label class="form-label small mb-1">Final Status</label>
                  <select id="finalStatus" name="finalStatus" class="form-select form-select-sm">
                    <option value="all" <?php echo sel('all', $finalStatus); ?>>All</option>
                    <option value="Open" <?php echo sel('Open', $finalStatus); ?>>Open</option>
                    <option value="Closed" <?php echo sel('Closed', $finalStatus); ?>>Closed</option>
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
                    style="<?php
                            $hasAny =
                              ($qRaw !== '' || $dateFrom !== '' || $dateTo !== '' ||
                                $amountRange !== 'all' || $deptFilter !== 'all' ||
                                $finStatus !== 'all' || $admStatus !== 'all' || $finalStatus !== 'all');
                            echo ($hasAny ? '' : 'display:none;');
                            ?>">
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

          <!-- Table card -->
          <div class="card shadow-sm border-0">
            <div class="card-body">

              <div class="table-responsive dt-wrap">
                <table class="table table-hover align-middle mb-0" id="myTable">
                  <thead>
                    <tr>
                      <th>Details</th>
                      <th>Ref#</th>
                      <th>Name</th>
                      <th>Department</th>
                      <th>Date</th>
                      <th>Total Requested</th>
                      <th>Total Evidence</th>
                      <th>Admin Status</th>
                      <th>Finance Status</th>
                      <th>Final Status</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    if ($data) {
                      while ($row = mysqli_fetch_assoc($select_q)) {
                        $rid = (int)($row['id'] ?? 0);

                        $evidenceNumbers = json_decode($row['evidence_numbers'] ?? '[]', true);
                        $sumEvidence = 0;
                        if (is_array($evidenceNumbers) && !empty($evidenceNumbers)) {
                          $sumEvidence = array_sum(array_map('floatval', $evidenceNumbers));
                        }

                        $dateOnly = '';
                        if (!empty($row['date'])) {
                          try {
                            $dateOnly = (new DateTime($row['date']))->format('d-m-Y');
                          } catch (Exception $e) {
                            $dateOnly = '';
                          }
                        }
                    ?>
                        <tr id="row_<?php echo $rid; ?>">
                          <td style="white-space:nowrap;">
                            <a href="cash_purchase_dashboard_details.php?id=<?php echo $rid; ?>" class="btn-details">
                              <i class="fa-solid fa-arrow-up me-1"></i> Details
                            </a>
                          </td>

                          <td><?php echo htmlspecialchars((string)($row['id'] ?? '')); ?></td>
                          <td><?php echo htmlspecialchars((string)($row['name'] ?? '')); ?></td>
                          <td><?php echo htmlspecialchars((string)($row['department'] ?? '')); ?></td>
                          <td style="white-space:nowrap;"><?php echo htmlspecialchars($dateOnly); ?></td>
                          <td><?php echo htmlspecialchars((string)($row['total_amount'] ?? '0')); ?></td>
                          <td><?php echo htmlspecialchars((string)$sumEvidence); ?></td>
                          <td><?php echo htmlspecialchars((string)($row['admin_status'] ?? '')); ?></td>
                          <td><?php echo htmlspecialchars((string)($row['finance_status'] ?? '')); ?></td>
                          <td><?php echo htmlspecialchars((string)($row['status'] ?? '')); ?></td>
                        </tr>
                    <?php
                      }
                    } else {
                      echo "<tr><td colspan='10' class='text-muted fw-semibold p-3'>No record found!</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>

              <!-- Pagination -->
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

  <script>
    document.addEventListener("DOMContentLoaded", function() {

      // ✅ Filters + reset + validation (preventDefault style)
      const form = document.getElementById("searchForm");
      const q = document.getElementById("q");
      const dateFrom = document.getElementById("dateFrom");
      const dateTo = document.getElementById("dateTo");
      const amountRange = document.getElementById("amountRange");
      const dept = document.getElementById("dept");
      const financeStatus = document.getElementById("financeStatus");
      const adminStatus = document.getElementById("adminStatus");
      const finalStatus = document.getElementById("finalStatus");
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

        if (term === "") url.searchParams.delete("q");
        else url.searchParams.set("q", term);

        if (df === "") url.searchParams.delete("dateFrom");
        else url.searchParams.set("dateFrom", df);

        if (dt === "") url.searchParams.delete("dateTo");
        else url.searchParams.set("dateTo", dt);

        url.searchParams.set("amountRange", amountRange.value || "all");
        url.searchParams.set("dept", dept.value || "all");
        url.searchParams.set("financeStatus", financeStatus.value || "all");
        url.searchParams.set("adminStatus", adminStatus.value || "all");
        url.searchParams.set("finalStatus", finalStatus.value || "all");

        url.searchParams.set("page", "1");
        window.location.href = url.toString();
      });

      resetBtn.addEventListener("click", function() {
        const url = new URL(window.location.href);
        url.searchParams.delete("q");
        url.searchParams.delete("dateFrom");
        url.searchParams.delete("dateTo");
        url.searchParams.delete("amountRange");
        url.searchParams.delete("dept");
        url.searchParams.delete("financeStatus");
        url.searchParams.delete("adminStatus");
        url.searchParams.delete("finalStatus");
        url.searchParams.set("page", "1");
        window.location.href = url.toString();
      });

    });
  </script>

</body>

</html>
