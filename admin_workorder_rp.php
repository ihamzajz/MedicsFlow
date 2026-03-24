<?php
ob_start();
session_start();

if (!isset($_SESSION['loggedin'])) {
  header('Location: login.php');
  exit;
}

include 'dbconfig.php';

// ===== Session =====
$id         = $_SESSION['id'] ?? '';
$fullname   = $_SESSION['fullname'] ?? '';
$username   = $_SESSION['username'] ?? '';
$password   = $_SESSION['password'] ?? '';
$email      = $_SESSION['email'] ?? '';
$gender     = $_SESSION['gender'] ?? '';
$department = $_SESSION['department'] ?? '';
$role       = $_SESSION['role'] ?? '';
$added_date = $_SESSION['added_date'] ?? '';

/* =========================================================
   ✅ Server-side: Filters + Pagination (50/page)
   ✅ Filters work across ALL pages via GET params
========================================================= */
$perPage = 50;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$qRaw         = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
$priceRange   = isset($_GET['priceRange']) ? trim((string)$_GET['priceRange']) : 'all';
$fromDate     = isset($_GET['fromDate']) ? trim((string)$_GET['fromDate']) : '';
$toDate       = isset($_GET['toDate']) ? trim((string)$_GET['toDate']) : '';
$deptFilter   = isset($_GET['department']) ? trim((string)$_GET['department']) : 'All';
$statusFilter = isset($_GET['finalStatus']) ? trim((string)$_GET['finalStatus']) : 'All';

$whereParts = [];
$whereParts[] = "depart_type = 'Admin'";

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
    OR description LIKE '{$like}'
    OR amount LIKE '{$like}'
    OR head_msg LIKE '{$like}'
    OR final_status LIKE '{$like}'
    OR reason LIKE '{$like}'
    OR closeout LIKE '{$like}'
  )";
}

/* Department */
if ($deptFilter !== '' && $deptFilter !== 'All') {
  $deptSafe = mysqli_real_escape_string($conn, $deptFilter);
  $whereParts[] = "department = '{$deptSafe}'";
}

/* Final status */
if ($statusFilter !== '' && $statusFilter !== 'All') {
  $stSafe = mysqli_real_escape_string($conn, $statusFilter);
  $whereParts[] = "final_status = '{$stSafe}'";
}

/* Date range (based on date column) */
if ($fromDate !== '') {
  $fd = mysqli_real_escape_string($conn, $fromDate);
  $whereParts[] = "DATE(`date`) >= '{$fd}'";
}
if ($toDate !== '') {
  $td = mysqli_real_escape_string($conn, $toDate);
  $whereParts[] = "DATE(`date`) <= '{$td}'";
}

/* Price range */
if ($priceRange !== '' && $priceRange !== 'all') {
  // keep only numeric amounts when range applied
  $whereParts[] = "amount REGEXP '^[0-9]+(\\\\.[0-9]+)?$'";

  if ($priceRange === '10000') {
    $whereParts[] = "CAST(amount AS DECIMAL(12,2)) >= 10000";
  } else {
    if (preg_match('/^(\d+)\-(\d+)$/', $priceRange, $m)) {
      $min = (int)$m[1];
      $max = (int)$m[2];
      $whereParts[] = "CAST(amount AS DECIMAL(12,2)) BETWEEN {$min} AND {$max}";
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

/* Fetch page */
$select = "SELECT * FROM workorder_form
           WHERE {$whereSql}
           ORDER BY date DESC, id DESC
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
  $priceRange === 'all' &&
  $fromDate === '' &&
  $toDate === '' &&
  $deptFilter === 'All' &&
  $statusFilter === 'All'
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Workorder Reporting Tool</title>
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
    }

    /* ✅ KEEP your dashboard status badges */
    .badge-soft {
      display: inline-flex;
      align-items: center;
      padding: 4px 10px;
      border-radius: 999px;
      font-size: 11px;
      font-weight: 700;
      white-space: nowrap;
      border: 1px solid transparent;
    }

    .b-green {
      background: #ecfdf5;
      color: #065f46;
      border-color: #a7f3d0;
      font-weight: 500;
    }

    .b-red {
      background: #fef2f2;
      color: #991b1b;
      border-color: #fecaca;
      font-weight: 500;
    }

    .b-amber {
      background: #fffbeb;
      color: #92400e;
      border-color: #fde68a;
      font-weight: 500;
    }

    .b-blue {
      background: #eff6ff;
      color: #1d4ed8;
      border-color: #bfdbfe;
      font-weight: 500;
    }

    .b-gray {
      background: #f3f4f6;
      color: #374151;
      border-color: #e5e7eb;
      font-weight: 500;
    }

    /* =========================================================
       ✅ DataTable-like panel:
       - Height 90vh
       - Horizontal + Vertical scroll inside
       - Wide table (no weird squeezing)
       - Sticky header
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
    }

    .table-responsive.dt-wrap th,
    .table-responsive.dt-wrap td {
      padding: 12px 12px !important;
      vertical-align: top !important;
    }

    /* Default: keep most columns single line */
    .table-responsive.dt-wrap td {
      white-space: nowrap;
    }

    /* Wrap only where needed */
    .table-responsive.dt-wrap td.td-wrap {
      white-space: normal !important;
      max-width: 520px;
      word-break: break-word;
      overflow-wrap: anywhere;
    }

    /* Hover + zebra */
    .table-responsive.dt-wrap tbody tr:hover td {
      background: #f8fbff;
    }

    .table-responsive.dt-wrap tbody tr:nth-child(even) td {
      background: #fbfdff;
    }

    .table-responsive.dt-wrap tbody td {
      border-bottom: 1px solid #e5e7eb !important;
    }

    /* Optional nice scrollbars */
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
                <h5 class="mb-0 box1-heading">Admin Workorder Dashboard</h5>
              </div>

              <a href="workorder_home.php" class="btn btn-dark btn-sm">
                <i class="fa-solid fa-home me-1"></i> Home
              </a>
            </div>
          </div>

          <!-- Filters -->
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
                  <label class="form-label fw-bold small">Price Range</label>
                  <select class="form-select form-select-sm" id="priceRange" name="priceRange">
                    <option value="all" <?php echo ($priceRange === 'all' ? 'selected' : ''); ?>>All</option>
                    <option value="0-500" <?php echo ($priceRange === '0-500' ? 'selected' : ''); ?>>0 - 500</option>
                    <option value="500-1999" <?php echo ($priceRange === '500-1999' ? 'selected' : ''); ?>>500 - 1999</option>
                    <option value="2000-4999" <?php echo ($priceRange === '2000-4999' ? 'selected' : ''); ?>>2000 - 4999</option>
                    <option value="5000-9999" <?php echo ($priceRange === '5000-9999' ? 'selected' : ''); ?>>5000 - 9999</option>
                    <option value="10000" <?php echo ($priceRange === '10000' ? 'selected' : ''); ?>>10,000 +</option>
                  </select>
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
                    <option value="Operation - Production" <?php echo ($deptFilter === 'Operation - Production' ? 'selected' : ''); ?>>Operation - Production</option>
                    <option value="QAQC" <?php echo ($deptFilter === 'QAQC' ? 'selected' : ''); ?>>QAQC</option>
                    <option value="Administration." <?php echo ($deptFilter === 'Administration.' ? 'selected' : ''); ?>>Administration.</option>
                    <option value="Information Technology" <?php echo ($deptFilter === 'Information Technology' ? 'selected' : ''); ?>>Information Technology</option>
                    <option value="Engineering" <?php echo ($deptFilter === 'Engineering' ? 'selected' : ''); ?>>Engineering</option>
                  </select>
                </div>

                <div class="col-6 col-lg-2">
                  <label class="form-label fw-bold small">Task Status</label>
                  <select class="form-select form-select-sm" id="finalStatusFilter" name="finalStatus">
                    <option value="All" <?php echo ($statusFilter === 'All' ? 'selected' : ''); ?>>All</option>
                    <option value="Completed" <?php echo ($statusFilter === 'Completed' ? 'selected' : ''); ?>>Completed</option>
                    <option value="Rejected" <?php echo ($statusFilter === 'Rejected' ? 'selected' : ''); ?>>Rejected</option>
                    <option value="Approval Pending" <?php echo ($statusFilter === 'Approval Pending' ? 'selected' : ''); ?>>Approval Pending</option>
                    <option value="Work In Progress" <?php echo ($statusFilter === 'Work In Progress' ? 'selected' : ''); ?>>Work In Progress</option>
                  </select>
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

                <div class="col-12 col-lg-2 d-flex">
                  <div class="mint-badge">
                    <i class="fa-solid fa-database"></i>
                    Total: <?php echo (int)$totalRows; ?>
                  </div>
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
                      <th>Date</th>
                      <th>Type</th>
                      <th>Description</th>
                      <th>Amount</th>
                      <th>Head Details</th>
                      <th>Status</th>
                      <th>Reason</th>
                      <th>Closeout Remarks</th>
                      <th>Avg Completion Time</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    if ($data) {
                      while ($row = mysqli_fetch_assoc($select_q)) {

                        $dateOnly = '';
                        if (!empty($row['date'])) {
                          try {
                            $dateOnly = (new DateTime($row['date']))->format('d-m-Y');
                          } catch (Exception $e) {
                            $dateOnly = '';
                          }
                        }

                        $headDateOnly = '';
                        if (!empty($row['head_date'])) {
                          try {
                            $headDateOnly = (new DateTime($row['head_date']))->format('d-m-Y');
                          } catch (Exception $e) {
                            $headDateOnly = '';
                          }
                        }

                        $closeoutDateOnly = '';
                        if (!empty($row['closeout_date'])) {
                          try {
                            $closeoutDateOnly = (new DateTime($row['closeout_date']))->format('d-m-Y');
                          } catch (Exception $e) {
                            $closeoutDateOnly = '';
                          }
                        }

                        $completion_time = '';
                        try {
                          if (!empty($row['head_date']) && !empty($row['closeout_date'])) {
                            $head_dt = new DateTime($row['head_date']);
                            $close_dt = new DateTime($row['closeout_date']);
                            $completion_time = $head_dt->diff($close_dt)->format('%d days %h hours %i minutes');
                          }
                        } catch (Exception $e) {
                          $completion_time = '';
                        }

                        $fs = trim((string)($row['final_status'] ?? ''));
                        if ($fs === '') $fs = 'Pending';

                        $badgeClass = 'b-gray';
                        if ($fs === 'Completed') $badgeClass = 'b-green';
                        else if ($fs === 'Rejected') $badgeClass = 'b-red';
                        else if ($fs === 'Approval Pending') $badgeClass = 'b-amber';
                        else if ($fs === 'Work In Progress') $badgeClass = 'b-blue';
                    ?>
                        <tr>
                          <td><?php echo htmlspecialchars((string)$row['id']); ?></td>
                          <td class="td-wrap"><?php echo htmlspecialchars((string)$row['name']); ?></td>
                          <td class="td-wrap"><?php echo htmlspecialchars((string)$row['department']); ?></td>
                          <td style="white-space:nowrap;"><?php echo htmlspecialchars($dateOnly); ?></td>
                          <td style="white-space:nowrap;"><?php echo htmlspecialchars((string)$row['type']); ?></td>
                          <td class="td-wrap"><?php echo htmlspecialchars((string)$row['description']); ?></td>
                          <td style="white-space:nowrap;"><?php echo htmlspecialchars((string)$row['amount']); ?></td>

                          <td class="td-wrap">
                            <?php echo htmlspecialchars((string)($row['head_msg'] ?? '')); ?>
                            <?php if ($headDateOnly !== '') {
                              echo "<br>" . htmlspecialchars($headDateOnly);
                            } ?>
                          </td>

                          <td style="white-space:nowrap;">
                            <span class="badge-soft <?php echo $badgeClass; ?>">
                              <?php echo htmlspecialchars($fs); ?>
                            </span>
                          </td>

                          <td class="td-wrap"><?php echo htmlspecialchars((string)($row['reason'] ?? '')); ?></td>

                          <td class="td-wrap">
                            <?php echo htmlspecialchars((string)($row['closeout'] ?? '')); ?>
                            <?php if ($closeoutDateOnly !== '') {
                              echo "<br>" . htmlspecialchars($closeoutDateOnly);
                            } ?>
                          </td>

                          <td style="white-space:nowrap;"><?php echo htmlspecialchars((string)$completion_time); ?></td>
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

        // Apply -> force page 1
        form.addEventListener("submit", function() {
          const existing = form.querySelector('input[name="page"]');
          if (existing) existing.remove();

          const pageInput = document.createElement("input");
          pageInput.type = "hidden";
          pageInput.name = "page";
          pageInput.value = "1";
          form.appendChild(pageInput);
        });

        // Reset filters
        resetBtn?.addEventListener("click", function() {
          const url = new URL(window.location.href);
          url.searchParams.delete('q');
          url.searchParams.delete('priceRange');
          url.searchParams.delete('fromDate');
          url.searchParams.delete('toDate');
          url.searchParams.delete('department');
          url.searchParams.delete('finalStatus');
          url.searchParams.set('page', '1');
          window.location.href = url.toString();
        });
      });
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>
<?php ob_end_flush(); ?>
