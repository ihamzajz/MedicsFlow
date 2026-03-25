<?php
ob_start();
require_once __DIR__ . '/workorder_bootstrap.php';

workorder_require_login();
if (!workorder_can_admin_act()) {
  workorder_abort(403, 'You are not allowed to access admin closeout.');
}

// ===== Session =====
$fullname = $_SESSION['fullname'] ?? '';
$flash = workorder_take_flash();

/* =========================================================
   ✅ DO NOT TOUCH: Admin closeout saving logic (same behavior)
========================================================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'])) {
  workorder_require_post_csrf();

  $reqid = workorder_get_request_id_from_post();
  if ($reqid > 0) {
    $btnKey    = 'budget_btn_' . $reqid;
    $budgetKey = 'budget_' . $reqid;

    if (isset($_POST[$btnKey])) {

      date_default_timezone_set("Asia/Karachi");
      $closeout_date = date('Y-m-d H:i:s');

      $closeout = trim((string)($_POST[$budgetKey] ?? ''));
      if ($closeout === '') {
        workorder_flash('danger', 'Please enter closeout remarks.');
        workorder_redirect('workorder_admin_closeout.php');
      }

      $fname = $fullname;
      $request = workorder_fetch_request($reqid);
      if (!$request || strcasecmp((string)($request['depart_type'] ?? ''), 'Admin') !== 0 || strcasecmp((string)($request['task_status'] ?? ''), 'Work in progress') !== 0 || trim((string)($request['closeout'] ?? '')) !== '') {
        workorder_flash('danger', 'This request is no longer available for closeout.');
        workorder_redirect('workorder_admin_closeout.php');
      }

      $closeoutNote = $closeout . ' / by ' . $fname;
      $taskCompleted = workorder_task_status_completed();
      $completed = workorder_final_status_completed();
      $workInProgress = workorder_task_status_work_in_progress();
      $emptyCloseout = '';

      $stmt = workorder_prepare(
        'UPDATE workorder_form
         SET closeout = ?, closeout_date = ?, task_status = ?, final_status = ?
         WHERE id = ? AND depart_type = ? AND task_status = ? AND closeout = ?'
      );
      $departType = 'Admin';
      $stmt->bind_param('ssssisss', $closeoutNote, $closeout_date, $taskCompleted, $completed, $reqid, $departType, $workInProgress, $emptyCloseout);
      $stmt->execute();
      $updated = $stmt->affected_rows > 0;
      $stmt->close();

      if ($updated) {
        workorder_log_action($reqid, 'admin', 'closeout', $closeoutNote);
        workorder_flash('success', 'Closeout saved successfully.');
      } else {
        workorder_flash('danger', 'This request was already updated by someone else.');
      }
      workorder_redirect('workorder_admin_closeout.php');
    }
  }
}

/* =========================================================
   ✅ SAME UI + LOGIC + Date Range (Admin):
========================================================= */
$perPage = 50;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$qRaw     = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
$dateFrom = isset($_GET['dateFrom']) ? trim((string)$_GET['dateFrom']) : '';
$dateTo   = isset($_GET['dateTo']) ? trim((string)$_GET['dateTo']) : '';

$dateError = '';

$whereParts = [];
$whereParts[] = "(
  depart_type = 'Admin' AND
  task_status = 'Work In Progress' AND
  closeout = ''
)";

/* Search */
if ($qRaw !== '') {
  $q = mysqli_real_escape_string($conn, $qRaw);
  $like = "%{$q}%";
  $whereParts[] = "(
      CAST(id AS CHAR) LIKE '{$like}'
      OR name LIKE '{$like}'
      OR department LIKE '{$like}'
      OR date LIKE '{$like}'
      OR type LIKE '{$like}'
      OR category LIKE '{$like}'
      OR description LIKE '{$like}'
      OR amount LIKE '{$like}'
      OR closeout LIKE '{$like}'
      OR admin_msg LIKE '{$like}'
      OR finance_msg LIKE '{$like}'
      OR eng_date LIKE '{$like}'
      OR fc_date LIKE '{$like}'
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

/* Count */
$countSql = "SELECT COUNT(*) AS total FROM workorder_form WHERE {$whereSql}";
$countQ = mysqli_query($conn, $countSql);
$countRow = mysqli_fetch_assoc($countQ);
$totalRows = (int)($countRow['total'] ?? 0);
$totalPages = ($totalRows > 0) ? (int)ceil($totalRows / $perPage) : 1;

if ($page > $totalPages) $page = $totalPages;
$offset = ($page - 1) * $perPage;

/* Fetch */
$select = "SELECT * FROM workorder_form
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Work Order - Admin Closeout</title>
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

    input {
      border: 0.5px solid #ced4da !important;
      font-size: 12px !important;
    }

    .btn-reset {
      background-color: #ced4da !important;
    }

    /* ✅ Same Total badge */
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

    /* ✅ Closeout input + save button (same as Engineering Closeout) */
    .closeout-wrap {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: nowrap;
      min-width: 260px;
    }

    .budget-input {
      width: 75%;
      min-width: 160px;
      height: 30px;
      border-radius: 8px;
      border: 0.5px solid #ced4da !important;
      padding: 0 10px;
      font-size: 11px !important;
      font-weight: 500;
    }

    .btn-tick {
      width: 15%;
      min-width: 34px;
      height: 30px;
      border-radius: 2px !important;
      padding: 0 10px !important;
      display: inline-flex !important;
      justify-content: center !important;
      align-items: center !important;
      font-size: 12px !important;
      font-weight: 700 !important;
      line-height: 1 !important;
      white-space: nowrap;
    }

    /* =========================================================
       ✅ SAME TABLE PANEL FIXES:
       - 90vh scroll panel
       - horizontal scrollbar
       - sticky header
       - prevent ugly wrapping
       - wrap ONLY .td-wrap
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
<?php include 'workorder_nav_theme.php'; ?>
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
                <h5 class="mb-0 box1-heading">Admin Dept. Closeout</h5>
              </div>

              <a href="workorder_home.php" class="btn btn-dark btn-sm">
                <i class="fa-solid fa-home me-1"></i> Home
              </a>
            </div>
          </div>

          <!-- Filters -->
          <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
              <form id="searchForm" method="GET" action="" class="row g-2 align-items-end">

                <div class="col-12 col-lg-3">
                  <label class="form-label fw-bold small">Search</label>
                  <input class="form-control form-control-sm" id="q" name="q" type="text"
                    placeholder="Type and press Search..."
                    value="<?php echo htmlspecialchars($qRaw); ?>">
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

                <div class="col-6 col-lg-1 d-grid">
                  <button id="searchBtn" type="button" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> Search
                  </button>
                </div>

                <div class="col-6 col-lg-1 d-grid">
                  <button
                    id="resetBtn"
                    type="button"
                    class="btn btn-reset btn-sm border"
                    style="<?php echo (($qRaw === '' && $dateFrom === '' && $dateTo === '') ? 'display:none;' : ''); ?>">
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

          <!-- Table -->
          <div class="card shadow-sm border-0">
            <div class="card-body">
              <?php if ($flash): ?>
                <div class="alert alert-<?php echo $flash['type'] === 'success' ? 'success' : ($flash['type'] === 'warning' ? 'warning' : 'danger'); ?> py-2 px-3 small fw-semibold">
                  <?php echo htmlspecialchars($flash['message']); ?>
                </div>
              <?php endif; ?>

              <div class="table-responsive dt-wrap">
                <table class="table table-hover align-middle mb-0" id="myTable">
                  <thead>
                    <tr>
                      <th>Closeout Remarks</th>
                      <th>Ref#</th>
                      <th>Name</th>
                      <th>Department</th>
                      <th>Date</th>
                      <th>Type</th>
                      <th>Category</th>
                      <th>Desc</th>
                      <th>Amount</th>
                      <th>Admin</th>
                      <th>Finance</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    if ($data) {
                      while ($row = mysqli_fetch_assoc($select_q)) {
                        $rid = (int)$row['id'];

                        $dateOnly = '';
                        if (!empty($row['date'])) {
                          try {
                            $dateOnly = (new DateTime($row['date']))->format('d-m-Y');
                          } catch (Exception $e) {
                            $dateOnly = '';
                          }
                        }

                        $adminCell = trim((string)($row['admin_msg'] ?? ''));
                        $engDate   = trim((string)($row['eng_date'] ?? ''));
                        $financeCell = trim((string)($row['finance_msg'] ?? ''));
                        $fcDate      = trim((string)($row['fc_date'] ?? ''));
                    ?>
                        <tr id="row_<?php echo $rid; ?>">

                          <td>
                            <form method="post" class="closeout-wrap" style="margin:0;">
                              <?php echo workorder_csrf_input(); ?>
                              <input type="hidden" name="request_id" value="<?php echo $rid; ?>">
                              <input
                                type="text"
                                class="budget-input"
                                name="budget_<?php echo $rid; ?>"
                                placeholder="Enter closeout remarks"
                                required>
                              <button
                                class="btn btn-success btn-sm btn-tick"
                                type="submit"
                                name="budget_btn_<?php echo $rid; ?>"
                                title="Save">
                                ✓
                              </button>
                            </form>
                          </td>

                          <td><?php echo htmlspecialchars((string)$row['id']); ?></td>
                          <td class="td-wrap"><?php echo htmlspecialchars((string)$row['name']); ?></td>
                          <td class="td-wrap"><?php echo htmlspecialchars((string)$row['department']); ?></td>
                          <td style="white-space:nowrap;"><?php echo htmlspecialchars($dateOnly); ?></td>
                          <td style="white-space:nowrap;"><?php echo htmlspecialchars((string)$row['type']); ?></td>
                          <td class="td-wrap"><?php echo htmlspecialchars((string)($row['category'] ?? '')); ?></td>
                          <td class="td-wrap"><?php echo htmlspecialchars((string)$row['description']); ?></td>
                          <td style="white-space:nowrap;"><?php echo htmlspecialchars((string)$row['amount']); ?></td>

                          <!-- ✅ keep readable + no ugly wrap -->
                          <td class="td-wrap">
                            <?php echo htmlspecialchars($adminCell); ?>
                            <?php if ($engDate !== '') { ?>
                              <br><small class="text-muted"><?php echo htmlspecialchars($engDate); ?></small>
                            <?php } ?>
                          </td>

                          <td class="td-wrap">
                            <?php echo htmlspecialchars($financeCell); ?>
                            <?php if ($fcDate !== '') { ?>
                              <br><small class="text-muted"><?php echo htmlspecialchars($fcDate); ?></small>
                            <?php } ?>
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
        const form = document.getElementById("searchForm");
        const searchBtn = document.getElementById("searchBtn");
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

        function applyFilters() {
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

          url.searchParams.set("page", "1");
          window.location.href = url.toString();
        }

        form.addEventListener("submit", function(e) {
          e.preventDefault();
        });

        searchBtn.addEventListener("click", applyFilters);

        resetBtn.addEventListener("click", function() {
          const url = new URL(window.location.href);
          url.searchParams.delete("q");
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

