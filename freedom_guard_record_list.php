<?php
/* ============================================================
   FILE: freedom_guard_record_list.php
   PURPOSE: List Freedom Guards (same layout as transport_guard_record_list)
            + AJAX delete handler
   ============================================================ */
session_start();
if (!isset($_SESSION['loggedin'])) { header('Location: login.php'); exit; }

include 'dbconfig.php';
date_default_timezone_set("Asia/Karachi");

// ===== AJAX delete handler =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax']) && $_POST['ajax'] === '1' && ($_POST['action'] ?? '') === 'delete') {
    header('Content-Type: application/json; charset=utf-8');

    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) { echo json_encode(['ok'=>false,'msg'=>'Invalid record.']); exit; }

    $stmt = $conn->prepare("DELETE FROM freedom_guards WHERE id = ?");
    if (!$stmt) { echo json_encode(['ok'=>false,'msg'=>'Delete failed!']); exit; }

    $stmt->bind_param("i", $id);
    $exec = $stmt->execute();
    $stmt->close();

    if ($exec) echo json_encode(['ok'=>true,'msg'=>'Record deleted!']);
    else echo json_encode(['ok'=>false,'msg'=>'Delete failed!']);
    exit;
}

// Fetch records
$rows = [];
$res = $conn->query("SELECT id, name, duty_location, duty_type, status FROM freedom_guards ORDER BY id DESC");
if ($res) {
    while ($r = $res->fetch_assoc()) $rows[] = $r;
    $res->free();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MedicsFlow</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />

    <?php include 'cdncss.php'; ?>

    <style>
        .bg-menu { background-color: #393E46 !important; }
        .btn-menu { font-size: 12.5px; background-color: #FFB22C !important; padding: 5px 10px; font-weight: 600; border: none !important; }
        body { font-family: 'Poppins', sans-serif; background-color: #f5f6fa; }
        .card { border-radius: 10px; }
        .bg-header { background-color: #1f7a8c; }

        /* ===== Toast ===== */
        .toast-custom {
            background: #ffffff !important;
            color: #111 !important;
            border: 1px solid #dee2e6 !important;
            border-left-width: 6px !important;
            border-radius: 10px !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }
        .toast-success { border-color: #28a745 !important; border-left-color: #28a745 !important; }
        .toast-error   { border-color: #dc3545 !important; border-left-color: #dc3545 !important; }
        .toast-warning { border-color: #ffc107 !important; border-left-color: #ffc107 !important; }
        .toast-custom .btn-close { filter: none !important; opacity: 0.6; }
        .toast-custom .btn-close:hover { opacity: 1; }

        /* ===== Modern Interactive Table UI ===== */
        .table-wrap{
            background:#fff;
            border:1px solid #e5e7eb;
            border-radius:14px;
            overflow:hidden;
            box-shadow: 0 12px 28px rgba(0,0,0,.08);
        }
        .table-modern{
            width:100%;
            border-collapse:separate;
            border-spacing:0;
            margin:0;
        }
        .table-modern thead th{
            position:sticky;
            top:0;
            z-index:2;
            background: linear-gradient(180deg, #f8fafc, #eef2ff);
            color:#0f172a;
            font-size:12.5px;
            text-transform:uppercase;
            letter-spacing:.5px;
            padding:12px 12px;
            border-bottom:1px solid #e5e7eb;
            white-space:nowrap;
        }
        .table-modern tbody td{
            padding:12px 12px;
            font-size:13px;
            border-bottom:1px solid #f1f5f9;
            vertical-align:middle;
        }
        .table-modern tbody tr{
            transition: background .15s ease, transform .15s ease;
        }
        .table-modern tbody tr:hover{
            background:#f8fafc;
        }
        .td-actions .btn{ border-radius:10px; }

        .id-pill{
            display:inline-block;
            padding:5px 10px;
            border-radius:999px;
            background:#f1f5f9;
            border:1px solid #e2e8f0;
            font-weight:600;
            color:#0f172a;
        }
        .status-pill{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:6px 10px;
            border-radius:999px;
            font-weight:700;
            font-size:12px;
            border:1px solid transparent;
        }
        .status-pill i{ font-size:8px; }
        .status-pill.active{
            background:#ecfdf5;
            border-color:#bbf7d0;
            color:#166534;
        }
        .status-pill.inactive{
            background:#fef2f2;
            border-color:#fecaca;
            color:#991b1b;
        }

        /* Toolbar controls */
        .searchbox{
            display:flex;
            align-items:center;
            gap:10px;
            background:#fff;
            border:1px solid #e5e7eb;
            border-radius:12px;
            padding:8px 12px;
            min-width:260px;
            box-shadow: 0 6px 18px rgba(0,0,0,.06);
        }
        .searchbox i{ color:#64748b; }
        .searchbox input{
            border:none !important;
            height:auto !important;
            padding:0 !important;
            outline:none !important;
            background:transparent !important;
            font-size:13px;
        }
        .filter-select{
            border:1px solid #e5e7eb;
            border-radius:12px;
            padding:8px 12px;
            font-size:13px;
            background:#fff;
            box-shadow: 0 6px 18px rgba(0,0,0,.06);
            height:auto !important;
        }

        /* Sorting header */
        .sortable{
            cursor:pointer;
            user-select:none;
        }
        .sortable i{
            margin-left:8px;
            opacity:.5;
        }
        .sortable.active i{
            opacity:1;
        }

        .no-results{
            padding:18px;
            text-align:center;
            color:#64748b;
            font-size:13px;
            border-top:1px solid #e5e7eb;
            background:#fff;
        }
        .no-results i{ margin-right:8px; }

          .btn-cancel,
        .btn-cancel:hover {
            border-radius: 20px;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
    </style>

    <?php include 'sidebarcss.php'; ?>
</head>

<body>
<div class="wrapper">
    <?php include 'sidebar1.php'; ?>

    <div id="content">
        <nav class="navbar navbar-expand-lg bg-menu">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn-menu">
                    <i class="fas fa-align-left"></i> <span>Menu</span>
                </button>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row justify-content-center mt-5">
                <div class="col-12 pt-md-2">

                    <div class="card shadow">
                        <div class="card-header bg-header text-white d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Freedom Guards</h6>
                            <div class="d-flex gap-2">
                                <a href="freedom_guard_form.php" class="btn btn-info btn-sm">
                                    <i class="fa-solid fa-plus"></i> Add New
                                </a>
                                    <a href="freedom_home.php" class="btn btn-light btn-sm">
                                    <i class="fa-solid fa-home"></i> Home
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <?php if (count($rows) === 0): ?>
                                <div class="alert alert-warning mb-0">No records found.</div>
                            <?php else: ?>

                                <!-- ===== Toolbar ===== -->
                                <div class="d-flex flex-column flex-md-row gap-2 align-items-md-center justify-content-between mb-3">
                                    <div class="d-flex gap-2 flex-wrap">
                                        <div class="searchbox">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            <input type="text" id="tableSearch" placeholder="Search guard name...">
                                        </div>

                                        <select id="statusFilter" class="filter-select">
                                            <option value="all" selected>All Status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>

                                    <div class="small text-muted">
                                        Showing: <span id="rowCount"><?php echo count($rows); ?></span>
                                    </div>
                                </div>

                                <!-- ===== Modern Table ===== -->
                                <div class="table-wrap">
                                    <table class="table-modern" id="guardTable">
                                        <thead>
                                            <tr>
                                                <th class="sortable" data-sort="id" style="width:90px;">
                                                    ID <i class="fa-solid fa-sort"></i>
                                                </th>
                                                <th class="sortable" data-sort="name">
                                                    Guard Name <i class="fa-solid fa-sort"></i>
                                                </th>
                                                <th class="sortable" data-sort="location">
                                                    Duty Location <i class="fa-solid fa-sort"></i>
                                                </th>
                                                <th class="sortable" data-sort="type" style="width:140px;">
                                                    Duty Type <i class="fa-solid fa-sort"></i>
                                                </th>
                                                <th class="sortable" data-sort="status" style="width:160px;">
                                                    Status <i class="fa-solid fa-sort"></i>
                                                </th>
                                                <th style="width:180px;">Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody id="tableBody">
                                            <?php foreach ($rows as $r): ?>
                                                <tr id="row_<?php echo (int)$r['id']; ?>"

                                                    data-id="<?php echo (int)$r['id']; ?>"
                                                    data-name="<?php echo htmlspecialchars(mb_strtolower($r['name'])); ?>"
                                                    data-location="<?php echo htmlspecialchars(mb_strtolower($r['duty_location'])); ?>"
                                                    data-type="<?php echo htmlspecialchars(mb_strtolower($r['duty_type'])); ?>"
                                                    data-status="<?php echo (int)$r['status']; ?>">

                                                    <td class="td-id">
                                                        <span class="id-pill">#<?php echo (int)$r['id']; ?></span>
                                                    </td>

                                                    <td class="td-name">
                                                        <?php echo htmlspecialchars($r['name']); ?>
                                                    </td>

                                                    <td class="td-location">
                                                        <?php echo htmlspecialchars($r['duty_location']); ?>
                                                    </td>

                                                    <td class="td-type">
                                                        <?php echo htmlspecialchars($r['duty_type']); ?>
                                                    </td>

                                                    <td class="td-status">
                                                        <?php if ((int)$r['status'] === 1): ?>
                                                            <span class="status-pill active"><i class="fa-solid fa-circle"></i> Active</span>
                                                        <?php else: ?>
                                                            <span class="status-pill inactive"><i class="fa-solid fa-circle"></i> Inactive</span>
                                                        <?php endif; ?>
                                                    </td>

                                                    <td class="td-actions">
                                                        <a class="btn btn-sm btn-primary"
                                                           href="freedom_guard_record_edit.php?id=<?php echo (int)$r['id']; ?>">
                                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                                        </a>
                                                        <button class="btn btn-sm btn-danger btnDel"
                                                                data-id="<?php echo (int)$r['id']; ?>">
                                                            <i class="fa-solid fa-trash"></i> Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                    <div id="noResults" class="no-results d-none">
                                        <i class="fa-regular fa-face-frown"></i>
                                        No matching records found.
                                    </div>
                                </div>

                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Toast -->
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;">
            <div id="statusToast" class="toast toast-custom align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body" id="toastMsg">...</div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <?php include 'footer.php'; ?>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function(){

    // ===== Toast helper =====
    const toastEl = document.getElementById("statusToast");
    const toastMsg = document.getElementById("toastMsg");
    function setToastType(type) {
        toastEl.classList.remove("toast-success", "toast-error", "toast-warning");
        if (type) toastEl.classList.add(type);
    }
    function showToast(type, msg){
        toastMsg.textContent = msg;
        setToastType(type);
        new bootstrap.Toast(toastEl, { delay: 2500 }).show();
    }

    // ===== Delete handler (AJAX) =====
    function bindDeleteButtons(){
        document.querySelectorAll(".btnDel").forEach(btn => {
            btn.onclick = async () => {
                const id = btn.getAttribute("data-id");
                if (!id) return;

                if (!confirm("Are you sure you want to delete this record?")) return;

                try {
                    const fd = new FormData();
                    fd.append("ajax", "1");
                    fd.append("action", "delete");
                    fd.append("id", id);

                    const res = await fetch(window.location.href, { method:"POST", body: fd });
                    const data = await res.json();

                    if (data.ok) {
                        showToast("toast-success", data.msg || "Deleted!");
                        const row = document.getElementById("row_" + id);
                        if (row) row.remove();
                        applyFilters();
                    } else {
                        showToast("toast-error", data.msg || "Delete failed!");
                    }
                } catch (e) {
                    showToast("toast-error", "Network error!");
                }
            };
        });
    }
    bindDeleteButtons();

    // ===== Interactive table =====
    const searchEl = document.getElementById("tableSearch");
    const filterEl = document.getElementById("statusFilter");
    const tbody = document.getElementById("tableBody");
    const noResults = document.getElementById("noResults");
    const rowCount = document.getElementById("rowCount");

    if (!tbody) return;

    function getRows(){
        return Array.from(tbody.querySelectorAll("tr"));
    }

    function applyFilters(){
        const q = (searchEl?.value || "").trim().toLowerCase();
        const status = (filterEl?.value || "all");

        let visible = 0;
        getRows().forEach(tr => {
            const name = tr.getAttribute("data-name") || "";
            const matchQ = (q === "") || name.includes(q);

            const st = tr.getAttribute("data-status") || "";
            const matchS = (status === "all") || (st === status);

            const show = matchQ && matchS;
            tr.style.display = show ? "" : "none";
            if (show) visible++;
        });

        if (rowCount) rowCount.textContent = String(visible);

        if (noResults) {
            if (visible === 0) noResults.classList.remove("d-none");
            else noResults.classList.add("d-none");
        }
    }

    if (searchEl) searchEl.addEventListener("input", applyFilters);
    if (filterEl) filterEl.addEventListener("change", applyFilters);

    // ===== Sorting =====
    let sortState = { key: null, dir: "asc" };

    function sortRows(key){
        const rows = getRows();

        if (sortState.key === key) sortState.dir = (sortState.dir === "asc") ? "desc" : "asc";
        else { sortState.key = key; sortState.dir = "asc"; }

        document.querySelectorAll(".sortable").forEach(th => th.classList.remove("active"));
        const activeTh = document.querySelector('.sortable[data-sort="'+key+'"]');
        if (activeTh) activeTh.classList.add("active");

        rows.sort((a,b) => {
            let av, bv;

            if (key === "id") {
                av = parseInt(a.getAttribute("data-id") || "0", 10);
                bv = parseInt(b.getAttribute("data-id") || "0", 10);
            } else if (key === "name") {
                av = a.getAttribute("data-name") || "";
                bv = b.getAttribute("data-name") || "";
            } else if (key === "location") {
                av = a.getAttribute("data-location") || "";
                bv = b.getAttribute("data-location") || "";
            } else if (key === "type") {
                av = a.getAttribute("data-type") || "";
                bv = b.getAttribute("data-type") || "";
            } else if (key === "status") {
                av = parseInt(a.getAttribute("data-status") || "0", 10);
                bv = parseInt(b.getAttribute("data-status") || "0", 10);
            } else {
                av = ""; bv = "";
            }

            if (av < bv) return sortState.dir === "asc" ? -1 : 1;
            if (av > bv) return sortState.dir === "asc" ? 1 : -1;
            return 0;
        });

        rows.forEach(r => tbody.appendChild(r));
        applyFilters();
    }

    document.querySelectorAll(".sortable").forEach(th => {
        th.addEventListener("click", () => {
            const key = th.getAttribute("data-sort");
            if (key) sortRows(key);
        });
    });

    // Init
    applyFilters();

});
</script>

</body>
</html>
