<?php
ob_start();
session_start();

include "dbconfig.php";

/* =========================
   Session (SAME LOGIC)
========================= */
$id         = $_SESSION['id'] ?? '';
$fullname   = $_SESSION['fullname'] ?? '';
$username   = $_SESSION['username'] ?? '';
$email      = $_SESSION['email'] ?? '';
$department = $_SESSION['department'] ?? '';
$role       = $_SESSION['role'] ?? '';
$be_depart  = $_SESSION['be_depart'] ?? '';
$be_role    = $_SESSION['be_role'] ?? '';

/* =========================================================
   ✅ Dashboard: server-side filters + pagination (SAME LOGIC)
========================================================= */
$perPage = 50;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$qRaw      = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
$statusRaw = isset($_GET['status']) ? trim((string)$_GET['status']) : '';
$deptRaw   = isset($_GET['dept']) ? trim((string)$_GET['dept']) : '';
$dateFrom  = isset($_GET['dateFrom']) ? trim((string)$_GET['dateFrom']) : '';
$dateTo    = isset($_GET['dateTo']) ? trim((string)$_GET['dateTo']) : '';

$dateError = '';

/* Base WHERE */
$whereParts = ["1=1"];

/* Status */
if ($statusRaw !== '') {
  $st = mysqli_real_escape_string($conn, $statusRaw);
  $whereParts[] = "final_status = '{$st}'";
}

/* Department */
if ($deptRaw !== '') {
  $dp = mysqli_real_escape_string($conn, $deptRaw);
  $whereParts[] = "department = '{$dp}'";
}

/* Search */
if ($qRaw !== '') {
  $q = mysqli_real_escape_string($conn, $qRaw);
  $like = "%{$q}%";
  $whereParts[] = "(
      CAST(id AS CHAR) LIKE '{$like}'
      OR name LIKE '{$like}'
      OR username LIKE '{$like}'
      OR email LIKE '{$like}'
      OR department LIKE '{$like}'
      OR role LIKE '{$like}'
      OR description LIKE '{$like}'
      OR it_msg LIKE '{$like}'
      OR reason LIKE '{$like}'
      OR final_status LIKE '{$like}'
      OR date LIKE '{$like}'
      OR it_date LIKE '{$like}'
    )";
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

/* Count (TOTAL records after filters) */
$countSql = "SELECT COUNT(*) AS total FROM it_accessories WHERE {$whereSql}";
$countQ = mysqli_query($conn, $countSql);
$countRow = mysqli_fetch_assoc($countQ);
$totalRows = (int)($countRow['total'] ?? 0);
$totalPages = ($totalRows > 0) ? (int)ceil($totalRows / $perPage) : 1;

if ($page > $totalPages) $page = $totalPages;
$offset = ($page - 1) * $perPage;

/* Fetch page */
$select = "SELECT * FROM it_accessories
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

/* Departments */
$deptOptions = [
  "Information Technology",
  "Finance",
  "Commercial",
  "Production",
  "Research & Development",
  "Human Resource"
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>IT Accessories - Dashboard</title>
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
      white-space: normal;
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

    /* ✅ Same Total badge (mint + db icon) */
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
      white-space: nowrap;
    }

    /* ✅ Status badge (pretty) */
    .st-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 5px 10px;
      border-radius: 999px;
      font-weight: 600;
      font-size: 11px;
      border: 1px solid transparent;
      white-space: nowrap;
    }

    .st-pending {
      background: rgba(245, 158, 11, .14);
      border-color: rgba(245, 158, 11, .35);
      color: #92400e;
    }

    .st-approved {
      background: rgba(22, 163, 74, .12);
      border-color: rgba(22, 163, 74, .30);
      color: #166534;
    }

    .st-rejected {
      background: rgba(220, 38, 38, .12);
      border-color: rgba(220, 38, 38, .28);
      color: #991b1b;
    }

    /* =========================================================
       ✅ SAME TABLE FIXES (like workorder list)
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
      table-layout: auto;
    }

    .table-responsive.dt-wrap thead th {
      position: sticky;
      top: 0;
      z-index: 5;
    }

    .table-responsive.dt-wrap td {
      white-space: nowrap;
      background: #fff;
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
                <h5 class="mb-0 box1-heading">IT Accessories Dashboard</h5>
              </div>

              <a href="it_accessories_home.php" class="btn btn-dark btn-sm">
                <i class="fa-solid fa-home me-1"></i> Home
              </a>
            </div>
          </div>

          <!-- Filters -->
          <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
              <form id="searchForm" method="GET" action="" class="row g-2 align-items-end">

                <!-- Row 1 -->
                <div class="col-12 col-lg-3">
                  <label class="form-label fw-bold small">Search</label>
                  <input class="form-control form-control-sm" id="q" name="q" type="text"
                    placeholder="Type and press Search..."
                    value="<?php echo htmlspecialchars($qRaw); ?>">
                </div>

                <div class="col-6 col-lg-2">
                  <label class="form-label fw-bold small">Status</label>
                  <select class="form-select form-select-sm" id="status" name="status">
                    <option value="">All</option>
                    <option value="Pending"  <?php echo ($statusRaw === 'Pending'  ? 'selected' : ''); ?>>Pending</option>
                    <option value="Approved" <?php echo ($statusRaw === 'Approved' ? 'selected' : ''); ?>>Approved</option>
                    <option value="Rejected" <?php echo ($statusRaw === 'Rejected' ? 'selected' : ''); ?>>Rejected</option>
                  </select>
                </div>

                <div class="col-6 col-lg-3">
                  <label class="form-label fw-bold small">Department</label>
                  <select class="form-select form-select-sm" id="dept" name="dept">
                    <option value="">All</option>
                    <?php foreach ($deptOptions as $d) { ?>
                      <option value="<?php echo htmlspecialchars($d); ?>" <?php echo ($deptRaw === $d ? 'selected' : ''); ?>>
                        <?php echo htmlspecialchars($d); ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>

                <div class="col-6 col-lg-2">
                  <label class="form-label fw-bold small">Date From</label>
                  <input class="form-control form-control-sm" type="date" id="dateFrom" name="dateFrom"
                    value="<?php echo htmlspecialchars($dateFrom); ?>">
                </div>

                <div class="col-6 col-lg-2">
                  <label class="form-label fw-bold small">Date To</label>
                  <input class="form-control form-control-sm" type="date" id="dateTo" name="dateTo"
                    value="<?php echo htmlspecialchars($dateTo); ?>">
                </div>

                <!-- Row 2 -->
                <div class="col-6 col-lg-2 d-grid">
                  <button id="searchBtn" type="submit" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> Search
                  </button>
                </div>

                <div class="col-6 col-lg-2 d-grid">
                  <button
                    id="resetBtn"
                    type="button"
                    class="btn btn-reset btn-sm border"
                    style="<?php echo (($qRaw === '' && $statusRaw === '' && $deptRaw === '' && $dateFrom === '' && $dateTo === '') ? 'display:none;' : ''); ?>">
                    <i class="fa-solid fa-rotate-left me-1"></i> Reset
                  </button>
                </div>

                <div class="col-12 col-lg-8 d-flex justify-content-lg-end align-items-end">
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
                      <th>Ref#</th>
                      <th>Name</th>
                      <th>Department</th>
                      <th>Role</th>
                      <th>Date</th>
                      <th>Description</th>
                      <th>IT Approval</th>
                      <th>Reject Reason</th>
                      <th>Status</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    if ($data) {
                      while ($row = mysqli_fetch_assoc($select_q)) {
                        $rid = (int)$row['id'];

                        $reqDate = '';
                        if (!empty($row['date'])) {
                          try { $reqDate = (new DateTime($row['date']))->format('d-m-Y'); }
                          catch (Exception $e) { $reqDate = ''; }
                        }

                        $itDate = '';
                        if (!empty($row['it_date'])) {
                          try { $itDate = (new DateTime($row['it_date']))->format('d-m-Y'); }
                          catch (Exception $e) { $itDate = ''; }
                        }

                        $st = trim((string)($row['final_status'] ?? ''));
                        $stLower = strtolower($st);

                        $badgeClass = 'st-pending';
                        $dot = '🟡';
                        if ($stLower === 'approved') { $badgeClass = 'st-approved'; $dot = '🟢'; }
                        else if ($stLower === 'rejected') { $badgeClass = 'st-rejected'; $dot = '🔴'; }

                        $itMsg = (string)($row['it_msg'] ?? '');
                        $reason = (string)($row['reason'] ?? '');
                    ?>
                        <tr id="row_<?php echo $rid; ?>">
                          <td><?php echo htmlspecialchars((string)$row['id']); ?></td>
                          <td class="td-wrap"><?php echo htmlspecialchars((string)$row['name']); ?></td>
                          <td class="td-wrap"><?php echo htmlspecialchars((string)$row['department']); ?></td>
                          <td><?php echo htmlspecialchars((string)$row['role']); ?></td>
                          <td style="white-space:nowrap;"><?php echo htmlspecialchars($reqDate); ?></td>
                          <td class="td-wrap"><?php echo htmlspecialchars((string)$row['description']); ?></td>

                          <td class="td-wrap">
                            <?php echo htmlspecialchars($itMsg); ?>
                            <?php if ($itDate !== '') { ?>
                              <br><span style="color:#64748b; font-weight:700;"><?php echo htmlspecialchars($itDate); ?></span>
                            <?php } ?>
                          </td>

                          <td class="td-wrap"><?php echo htmlspecialchars($reason); ?></td>

                          <td>
                            <span class="st-badge <?php echo $badgeClass; ?>">
                              <?php echo $dot; ?> <?php echo htmlspecialchars($st !== '' ? $st : 'Pending'); ?>
                            </span>
                          </td>
                        </tr>
                    <?php
                      }
                    } else {
                      echo "<tr><td colspan='11' class='text-muted fw-semibold p-3'>No record found!</td></tr>";
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

                  echo '<a class="btn btn-sm btn-outline-secondary ' . ($isFirst ? 'disabled' : '') . '" href="' . htmlspecialchars(pageUrl(1)) . '">First</a>';
                  echo '<a class="btn btn-sm btn-outline-secondary ' . ($isFirst ? 'disabled' : '') . '" href="' . htmlspecialchars(pageUrl(max(1, $page - 1))) . '">Prev</a>';

                  $window = 5;
                  $half = intdiv($window, 2);
                  $start = max(1, $page - $half);
                  $end = min($totalPages, $start + $window - 1);
                  $start = max(1, $end - $window + 1);

                  for ($i = $start; $i <= $end; $i++) {
                    $active = ($i === $page) ? 'btn-primary' : 'btn-outline-primary';
                    echo '<a class="btn btn-sm ' . $active . '" href="' . htmlspecialchars(pageUrl($i)) . '">' . $i . '</a>';
                  }

                  echo '<a class="btn btn-sm btn-outline-secondary ' . ($isLast ? 'disabled' : '') . '" href="' . htmlspecialchars(pageUrl(min($totalPages, $page + 1))) . '">Next</a>';
                  echo '<a class="btn btn-sm btn-outline-secondary ' . ($isLast ? 'disabled' : '') . '" href="' . htmlspecialchars(pageUrl($totalPages)) . '">Last</a>';
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
        const form = document.getElementById("searchForm");
        const q = document.getElementById("q");
        const status = document.getElementById("status");
        const dept = document.getElementById("dept");
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
          const st = (status.value || "").trim();
          const dp = (dept.value || "").trim();
          const df = (dateFrom.value || "").trim();
          const dt = (dateTo.value || "").trim();

          if (term === "") url.searchParams.delete("q");
          else url.searchParams.set("q", term);

          if (st === "") url.searchParams.delete("status");
          else url.searchParams.set("status", st);

          if (dp === "") url.searchParams.delete("dept");
          else url.searchParams.set("dept", dp);

          if (df === "") url.searchParams.delete("dateFrom");
          else url.searchParams.set("dateFrom", df);

          if (dt === "") url.searchParams.delete("dateTo");
          else url.searchParams.set("dateTo", dt);

          url.searchParams.set("page", "1");
          window.location.href = url.toString();
        });

        resetBtn.addEventListener("click", function() {
          const url = new URL(window.location.href);
          url.searchParams.delete("q");
          url.searchParams.delete("status");
          url.searchParams.delete("dept");
          url.searchParams.delete("dateFrom");
          url.searchParams.delete("dateTo");
          url.searchParams.set("page", "1");
          window.location.href = url.toString();
        });
      });
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>
<?php ob_end_flush(); ?>
