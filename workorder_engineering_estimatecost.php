<?php
ob_start();
session_start();
include "dbconfig.php";

$head_email = $_SESSION['head_email'] ?? '';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$mail = new PHPMailer(true);

/* =========================================================
   ✅ Keep your EXISTING "submit cost" logic (same behavior)
   ✅ Only change: do NOT echo PHPMailer error to user
   ========================================================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'])) {
  $reqid = (int)($_POST['request_id'] ?? 0);
  $budgetKey = 'budget_' . $reqid;
  $btnKey    = 'budget_btn_' . $reqid;

  if ($reqid > 0 && isset($_POST[$btnKey])) {
    $budget = $_POST[$budgetKey] ?? '';
    $budget_safe = mysqli_real_escape_string($conn, (string)$budget);

    $update = "UPDATE workorder_form SET amount = '$budget_safe' WHERE id = '$reqid'";
    $update_q = mysqli_query($conn, $update);

    if ($update_q) {

      if ((float)$budget <= 10000) {
        try {
          $mail->SMTPDebug = 0;
          $mail->Debugoutput = 'error_log';
          $mail->isSMTP();
          $mail->Host = 'smtp.office365.com';
          $mail->SMTPAuth = true;
          $mail->Username = 'info@medicslab.com';
          $mail->Password = 'kcmzrskfgmwzzshz';
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
          $mail->Port = 587;

          $mail->setFrom('info@medicslab.com', 'Medics Digital form');
          $mail->addAddress('taha.khan@medicslab.com', 'Engineering Head');

          $mail->isHTML(true);
          $mail->Subject = "Workorder Notification";
          $mail->Body = '
            <p>Dear Engineering Team,</p>
            <p>A new Work Order request has been submitted and is currently awaiting your review and approval. Please log in to MedicsFlow to review the details and take the required action at your earliest convenience.</p>
            <p>Regards,<br>MedicsFlow</p>
          ';
          $mail->send();
        } catch (Exception $e) {
          error_log("PHPMailer error (<=10000): " . $mail->ErrorInfo);
          header("Location: workorder_engineering_estimatecost.php");
          exit;
        }
      } else {
        try {
          $mail->SMTPDebug = 0;
          $mail->Debugoutput = 'error_log';
          $mail->isSMTP();
          $mail->Host = 'smtp.office365.com';
          $mail->SMTPAuth = true;
          $mail->Username = 'info@medicslab.com';
          $mail->Password = 'kcmzrskfgmwzzshz';
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
          $mail->Port = 587;

          $mail->setFrom('info@medicslab.com', 'Medics Digital form');
          $mail->addAddress('danish.tanveer@medicslab.com', 'Danish Tanveer');

          $mail->isHTML(true);
          $mail->Subject = "Workorder Notification";
          $mail->Body = '
            <p>Dear Finance Team,</p>
            <p>A new Work Order request has been submitted and is currently awaiting your review and approval. Please log in to MedicsFlow to review the details and take the required action at your earliest convenience.</p>
            <p>Regards,<br>MedicsFlow</p>
          ';
          $mail->send();
        } catch (Exception $e) {
          error_log("PHPMailer error (>10000): " . $mail->ErrorInfo);
          header("Location: workorder_engineering_estimatecost.php");
          exit;
        }
      }

      header("Location: workorder_engineering_estimatecost.php");
      exit;
    } else {
      echo '<script>alert("failed!"); window.location.href="workorder_engineering_estimatecost.php";</script>';
      exit;
    }
  }
}

/* =========================================================
   ✅ Server-side Pagination + Search + Date Range (UNCHANGED)
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
  ((head_status = 'Approved' OR be_role = 'Approver') OR
   (ceo_status = 'Approved' AND ceo_status != 'Rejected')) AND
  engineering_status = 'Pending' AND
  depart_type = 'Engineering' AND
  amount = 'TBD'
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
    OR head_msg LIKE '{$like}'
    OR amount LIKE '{$like}'
  )";
}

/* Date filter validation + apply */
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

/* Fetch page */
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
  <title>Work Order - Cost Evaluation</title>
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

    .btn-details {
      font-size: 11px;
      font-weight: 600 !important;
      color: white;
      background-color: #7c3aed;
      padding: 7px 10px !important;
      border-radius: 3px !important;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      white-space: nowrap;
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

    /* ✅ Total badge EXACT style */
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

    /* ✅ Estimate input 75% and submit button next to it */
    .budget-wrap {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: nowrap;
      min-width: 220px;
    }

    .budget-input {
      width: 75%;
      min-width: 140px;
      height: 30px;
      border-radius: 8px;
      border: 0.5px solid #ced4da !important;
      padding: 0 10px;
      font-size: 11px !important;
      font-weight: 500;
    }

    .btn-tick {
      width: 15%;
      min-width: 30px;
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

    .col-estimate {
      min-width: 240px;
    }

    /* =========================================================
       ✅ FIXES YOU ASKED:
       1) TABLE HEIGHT = 90vh (scroll inside table)
       2) NO MORE "Urgent" going next line: keep nowrap for most cells
       3) Professional horizontal scrollbar for wide table
       4) Sticky header
    ========================================================= */
    .table-responsive.dt-wrap {
      max-height: 90vh;
      overflow: auto;
      border-radius: 14px;
      border: 1px solid #d8dee6;
      background: #fff;
    }

    .table-responsive.dt-wrap table {
      width: max-content;  /* allow table to be wide */
      min-width: 100%;     /* but not smaller than container */
      border-collapse: separate;
      border-spacing: 0;
    }

    .table-responsive.dt-wrap thead th {
      position: sticky;
      top: 0;
      z-index: 5;
    }

    /* Keep most columns single-line (prevents "Urgen" "t") */
    .table-responsive.dt-wrap td {
      white-space: nowrap;
    }

    /* Wrap only for long text columns */
    .table-responsive.dt-wrap td.td-wrap {
      white-space: normal !important;
      max-width: 520px;
      word-break: break-word;
      overflow-wrap: anywhere;
    }

    /* Zebra + hover */
    .table-responsive.dt-wrap tbody tr:hover td {
      background: #f8fbff;
    }

    .table-responsive.dt-wrap tbody tr:nth-child(even) td {
      background: #fbfdff;
    }

    .table-responsive.dt-wrap tbody td {
      border-bottom: 1px solid #e5e7eb !important;
    }

    /* Optional scrollbar styling */
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
                <h5 class="mb-0 box1-heading">Engineering - Cost Evaluation</h5>
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
                  <button id="searchBtn" type="submit" class="btn btn-primary btn-sm">
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

              <!-- ✅ IMPORTANT: dt-wrap added -->
              <div class="table-responsive dt-wrap">
                <table class="table table-hover align-middle mb-0" id="myTable">
                  <thead>
                    <tr>
                      <th>Send</th>
                      <th class="col-estimate">Estimate Amount</th>
                      <th>Ref#</th>
                      <th>Name</th>
                      <th>Department</th>
                      <th>Date</th>
                      <th>Type</th>
                      <th>Category</th>
                      <th>Desc</th>
                      <th>Head</th>
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
                    ?>
                        <tr id="row_<?php echo $rid; ?>">

                          <td style="white-space:nowrap;">
                            <a href="sendtoadmin.php?id=<?php echo $rid; ?>" class="btn-details">
                              <i class="fa-solid fa-infinity"></i> Admin
                            </a>
                          </td>

                          <td>
                            <form method="post" class="budget-wrap">
                              <input type="hidden" name="request_id" value="<?php echo $rid; ?>">
                              <input
                                type="number"
                                class="budget-input"
                                name="budget_<?php echo $rid; ?>"
                                placeholder="Estimate Amount"
                                required>
                              <button
                                class="btn btn-success btn-sm btn-tick"
                                type="submit"
                                name="budget_btn_<?php echo $rid; ?>">
                                ✓
                              </button>
                            </form>
                          </td>

                          <td><?php echo htmlspecialchars((string)$row['id']); ?></td>

                          <!-- ✅ Wrap only where needed -->
                          <td class="td-wrap"><?php echo htmlspecialchars((string)$row['name']); ?></td>
                          <td class="td-wrap"><?php echo htmlspecialchars((string)$row['department']); ?></td>

                          <td style="white-space:nowrap;"><?php echo htmlspecialchars($dateOnly); ?></td>

                          <!-- ✅ Type should NOT wrap (fix Urgen / t) -->
                          <td style="white-space:nowrap;"><?php echo htmlspecialchars((string)$row['type']); ?></td>

                          <td class="td-wrap"><?php echo htmlspecialchars((string)$row['category']); ?></td>
                          <td class="td-wrap"><?php echo htmlspecialchars((string)$row['description']); ?></td>
                          <td class="td-wrap"><?php echo htmlspecialchars((string)$row['head_msg']); ?></td>

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

          if (term === "") url.searchParams.delete("q");
          else url.searchParams.set("q", term);

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
          url.searchParams.delete("dateFrom");
          url.searchParams.delete("dateTo");
          url.searchParams.set("page", "1");
          window.location.href = url.toString();
        });
      });
    </script>

    <?php include 'footer.php' ?>
</body>

</html>
<?php ob_end_flush(); ?>

