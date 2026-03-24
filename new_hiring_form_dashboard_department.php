<?php
ob_start();
session_start();

if (!isset($_SESSION['loggedin'])) {
  header('Location: login.php');
  exit;
}

include "dbconfig.php";
date_default_timezone_set("Asia/Karachi");

/* =========================
   Session
========================= */
$session_id   = $_SESSION['id'] ?? '';
$fullname     = $_SESSION['fullname'] ?? '';
$username     = $_SESSION['username'] ?? '';
$email        = $_SESSION['email'] ?? '';
$department   = $_SESSION['department'] ?? '';
$role         = $_SESSION['role'] ?? '';

$be_depart    = $_SESSION['be_depart'] ?? '';
$bc_role      = $_SESSION['be_role'] ?? '';

/* =========================================================
   ✅ Server-side: Filters + Pagination (50/page)
   ✅ Table: new_hiring
   ✅ Date column: date_of_request
========================================================= */
$perPage = 50;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$qRaw     = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
$fromDate = isset($_GET['fromDate']) ? trim((string)$_GET['fromDate']) : '';
$toDate   = isset($_GET['toDate']) ? trim((string)$_GET['toDate']) : '';

$dateError = "";

/* Base WHERE (change this if your dashboard rule is different) */
$whereParts = [];
if ($be_depart === 'super') {
  $whereParts[] = "1=1";
} else {
  // Department dashboard: show requests for my department
  $dept_safe = mysqli_real_escape_string($conn, (string)$department);
  $whereParts[] = "user_department = '{$dept_safe}'";
}

/* Search */
if ($qRaw !== '') {
  $q = mysqli_real_escape_string($conn, $qRaw);
  $like = "%{$q}%";
  $whereParts[] = "(
      CAST(id AS CHAR) LIKE '{$like}'
      OR user_name LIKE '{$like}'
      OR user_department LIKE '{$like}'
      OR user_role LIKE '{$like}'
      OR position_title LIKE '{$like}'
      OR department LIKE '{$like}'
      OR division LIKE '{$like}'
      OR location LIKE '{$like}'
      OR date_of_request LIKE '{$like}'
    )";
}

/* Date range validation + filter (DATE(date_of_request)) */
$hasFrom = ($fromDate !== '');
$hasTo   = ($toDate !== '');

if (($hasFrom && !$hasTo) || (!$hasFrom && $hasTo)) {
  $dateError = "Please select both From Date and To Date.";
} else if ($hasFrom && $hasTo) {
  $dfOk = (bool)preg_match('/^\d{4}-\d{2}-\d{2}$/', $fromDate);
  $dtOk = (bool)preg_match('/^\d{4}-\d{2}-\d{2}$/', $toDate);

  if (!$dfOk || !$dtOk) {
    $dateError = "Invalid date format. Please re-select dates.";
  } else if (strtotime($toDate) < strtotime($fromDate)) {
    $dateError = "End date cannot be earlier than start date.";
  } else {
    $df = mysqli_real_escape_string($conn, $fromDate);
    $dt = mysqli_real_escape_string($conn, $toDate);
    $whereParts[] = "DATE(`date_of_request`) BETWEEN '{$df}' AND '{$dt}'";
  }
}

$whereSql = implode(" AND ", $whereParts);

/* Count */
$countSql = "SELECT COUNT(*) AS total FROM new_hiring WHERE {$whereSql}";
$countQ = mysqli_query($conn, $countSql);
$countRow = mysqli_fetch_assoc($countQ);
$totalRows = (int)($countRow['total'] ?? 0);
$totalPages = ($totalRows > 0) ? (int)ceil($totalRows / $perPage) : 1;

if ($page > $totalPages) $page = $totalPages;
$offset = ($page - 1) * $perPage;

/* Fetch page
   ✅ FORCE correct primary key with alias ref_id
*/
$select = "SELECT
            nh.id AS ref_id,
            nh.*
          FROM new_hiring nh
          WHERE {$whereSql}
          ORDER BY nh.date_of_request DESC, nh.id DESC
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

$from = ($totalRows === 0) ? 0 : ($offset + 1);
$to   = min($offset + $perPage, $totalRows);

$anyFilterOn = !(
  $qRaw === '' &&
  $fromDate === '' &&
  $toDate === ''
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>New Hiring Dashboard - Department</title>
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

    /* ✅ 90vh scroll panel (same as eng_workorder_rp) */
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
                <h5 class="mb-0 box1-heading">New Hiring Dashboard - Department</h5>
              </div>

              <a href="new_hiring_home.php" class="btn btn-dark btn-sm">
                <i class="fa-solid fa-home me-1"></i> Home
              </a>
            </div>
          </div>

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

                <div class="col-6 col-lg-1 d-grid">
                  <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-filter me-1"></i> Apply
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

                <div class="col-12 col-lg-3 d-flex justify-content-lg-end align-items-end">
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
                      <th>Report</th>
                      <th>Ref#</th>
                      <th>Date</th>
                      <th>Requester Name</th>
                      <th>Requester Department</th>
                      <th>Requester Role</th>
                      <th>Position Title</th>
                      <th>Department</th>
                      <th>Division</th>
                      <th>Location</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    if ($data) {
                      while ($row = mysqli_fetch_assoc($select_q)) {

                        // ✅ Guaranteed correct primary key
                        $refId = (int)($row['ref_id'] ?? 0);

                        $dateOnly = '';
                        if (!empty($row['date_of_request'])) {
                          $dateOnly = date('d-m-Y', strtotime($row['date_of_request']));
                        }
                    ?>
                        <tr id="row_<?php echo $refId; ?>">
                          <td style="white-space:nowrap;">
                            <a href="new_hiring_form_dd_report.php?id=<?php echo $refId; ?>" class="btn-details">
                              <i class="fa-solid fa-file-lines me-1"></i> Report
                            </a>
                          </td>

                          <td><?php echo htmlspecialchars((string)$refId); ?></td>
                          <td style="white-space:nowrap;"><?php echo htmlspecialchars($dateOnly); ?></td>
                          <td><?php echo htmlspecialchars((string)($row['user_name'] ?? '')); ?></td>
                          <td><?php echo htmlspecialchars((string)($row['user_department'] ?? '')); ?></td>
                          <td><?php echo htmlspecialchars((string)($row['user_role'] ?? '')); ?></td>
                          <td class="td-wrap"><?php echo htmlspecialchars((string)($row['position_title'] ?? '')); ?></td>
                          <td><?php echo htmlspecialchars((string)($row['department'] ?? '')); ?></td>
                          <td><?php echo htmlspecialchars((string)($row['division'] ?? '')); ?></td>
                          <td><?php echo htmlspecialchars((string)($row['location'] ?? '')); ?></td>
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
        const fromDate = document.getElementById("fromDate");
        const toDate = document.getElementById("toDate");
        const errBox = document.getElementById("dateErrorBox");

        function showErr(msg) {
          if (!errBox) return;
          errBox.textContent = msg;
          errBox.style.display = msg ? "block" : "none";
        }

        function validateDates() {
          const df = (fromDate.value || "").trim();
          const dt = (toDate.value || "").trim();

          if ((df && !dt) || (!df && dt)) {
            showErr("Please select both From Date and To Date.");
            return false;
          }
          if (df && dt && dt < df) {
            showErr("End date cannot be earlier than start date.");
            return false;
          }
          showErr("");
          return true;
        }

        fromDate.addEventListener("change", validateDates);
        toDate.addEventListener("change", validateDates);

        // Force page=1 on Apply
        form.addEventListener("submit", function(e) {
          if (!validateDates()) {
            e.preventDefault();
            return;
          }

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
          url.searchParams.set('page', '1');
          window.location.href = url.toString();
        });
      });
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>
<?php ob_end_flush(); ?>