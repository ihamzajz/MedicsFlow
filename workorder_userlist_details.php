<?php
require_once __DIR__ . '/workorder_bootstrap.php';
workorder_require_login();

/* =========================
   Helpers
========================= */
function fmt_date_ddmmyyyy($val): string {
    $val = trim((string)$val);
    if ($val === '' || $val === '0000-00-00' || $val === '0000-00-00 00:00:00') return '';
    try {
        $dt = new DateTime($val);
        return $dt->format('d-m-Y');
    } catch (Exception $e) {
        return htmlspecialchars($val); // fallback if weird format
    }
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$row = $id > 0 ? workorder_fetch_request($id) : null;

if (!$row) {
    die("No record found!");
}

/* =========================
   Session vars (kept for admin/engineering logic)
========================= */
$be_depart = $_SESSION['be_depart'] ?? '';

/* =========================
   Logic rules you asked
========================= */
$amountRaw = $row['amount'] ?? '';
$amountNum = is_numeric($amountRaw) ? (float)$amountRaw : 0;

/* ✅ NEW RULE:
   - if cost >= 10000 => finance only
   - if cost < 10000  => admin/engineering based on session be_depart
*/
$goesFinance = ($amountNum >= 10000);

$departType = $row['depart_type'] ?? ''; // kept as-is for display

/* ✅ IMPORTANT: Head section visibility based on DB column be_role */
$rowBeRole = $row['be_role'] ?? '';
$headRejectReason = workorder_latest_action_note($id, 'head');
$engineeringRejectReason = workorder_latest_action_note($id, 'engineering');
$adminRejectReason = workorder_latest_action_note($id, 'admin');
$financeRejectReason = workorder_latest_action_note($id, 'finance');
$ceoRejectReason = workorder_latest_action_note($id, 'ceo');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Workorder – Details</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php include 'cdncss.php'; ?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<?php include 'sidebarcss.php'; ?>

<style>
body{
    font-family:'Poppins',sans-serif;
    background:#f5f5f5;
    color:#000;
}
.btn{ border-radius:2px; }

/* ===== Top Bar ===== */
.bg-menu { background-color:#393E46 !important; }
.btn-menu{
    font-size:12.5px;
    background-color:#FFB22C !important;
    padding:5px 10px;
    font-weight:600;
    border:none !important;
}

/* ===== Card ===== */
.nh-card{
    background:#fff;
    border:1px solid #000;
    border-radius:16px;
    overflow:hidden;
}
.nh-head{
    padding:14px 18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
}
.nh-head h1{
    margin:0;
    font-size:18px;
    font-weight:800;
    letter-spacing:.2px;
}
.nh-actions{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
    justify-content:flex-end;
}
.nh-actions a{
    font-size:12px;
    font-weight:600;
    padding:6px 12px;
    border-radius:8px;
    background:#000;
    color:#fff;
    text-decoration:none;
}

/* ===== Sections ===== */
.section-title{
    margin:18px 0 8px;
    font-size:12.5px;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:.5px;
}

/* ===== Field blocks ===== */
.label{
    font-size:11.5px;
    font-weight:600;
    margin-bottom:4px;
}
.value-box{
    border:1px solid #000;
    padding:7px 10px;
    border-radius:10px;
    font-size:12px;
    font-weight:400;
    min-height:34px;
    white-space:pre-wrap;
    word-break:break-word;
}

/* ===== Grid KV layout ===== */
.kv-box{
    border:1px solid #000;
    border-radius:14px;
    padding:8px 10px;
}
.kv-row{
    display:grid;
    grid-template-columns:220px 1fr;
    gap:10px;
    padding:6px 0;
    border-top:1px dashed rgba(0,0,0,.25);
}
.kv-row:first-child{ border-top:none; }
.k{ font-size:12px; font-weight:600; }
.v{ font-size:12px; font-weight:400; white-space:pre-wrap; word-break:break-word; }

@media(max-width:600px){
    .kv-row{ grid-template-columns:1fr; }
}
</style>
<?php include 'workorder_nav_theme.php'; ?>
</head>

<body>
<div class="wrapper d-flex align-items-stretch">
<?php include 'sidebar1.php'; ?>

<div id="content">
            <nav class="navbar navbar-expand-lg bg-menu">
        <div class="container-fluid">
<button type="button" id="sidebarCollapse" class="btn-menu my-1">
                <i class="fas fa-align-left"></i>
                <span>Menu</span>
            </button>
        </div>
    </nav>

    <div class="container-fluid p-3">
        <div class="nh-card">

            <!-- Header -->
            <div class="nh-head">
                <h1>Workorder – Details (Form # <?php echo (int)$row['id']; ?>)</h1>
                <div class="nh-actions">
                    <a href="workorder_home.php"><i class="fa-solid fa-house"></i> Home</a>
                    <a href="workorder_userlist.php"><i class="fa-solid fa-arrow-left"></i> Back</a>
                </div>
            </div>

            <div class="p-3">

                <!-- Submitter Info -->
                <div class="section-title">Submitter Info</div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="label">Name</div>
                        <div class="value-box"><?php echo htmlspecialchars($row['name'] ?? ''); ?></div>
                    </div>
                    <div class="col-md-3">
                        <div class="label">Department</div>
                        <div class="value-box"><?php echo htmlspecialchars($row['department'] ?? ''); ?></div>
                    </div>
                    <div class="col-md-3">
                        <div class="label">Role</div>
                        <div class="value-box"><?php echo htmlspecialchars($row['role'] ?? ''); ?></div>
                    </div>
                    <div class="col-md-3">
                        <div class="label">Submission Date</div>
                        <div class="value-box"><?php echo htmlspecialchars(fmt_date_ddmmyyyy($row['date'] ?? '')); ?></div>
                    </div>
                </div>

                <!-- Request Details -->
                <div class="section-title">Request Details</div>
                <div class="kv-box">
                    <div class="kv-row"><div class="k">Request For Department</div><div class="v"><?php echo htmlspecialchars($departType); ?></div></div>
                    <div class="kv-row"><div class="k">Type</div><div class="v"><?php echo htmlspecialchars($row['type'] ?? ''); ?></div></div>
                    <div class="kv-row"><div class="k">Category</div><div class="v"><?php echo htmlspecialchars($row['category'] ?? ''); ?></div></div>
                    <div class="kv-row"><div class="k">Amount</div><div class="v"><?php echo htmlspecialchars($row['amount'] ?? ''); ?></div></div>
                    <div class="kv-row"><div class="k">Description</div><div class="v"><?php echo htmlspecialchars($row['description'] ?? ''); ?></div></div>
                </div>

                <!-- ✅ Head Approval: show ONLY if DB be_role is NOT approver -->
                <?php if ($rowBeRole !== 'approver'): ?>
                    <div class="section-title">Head Approval</div>
                    <div class="kv-box">
                        <div class="kv-row">
                            <div class="k">Head Status</div>
                            <div class="v"><?php echo htmlspecialchars($row['head_status'] ?? ''); ?></div>
                        </div>
                        <div class="kv-row"><div class="k">Head Message</div><div class="v"><?php echo htmlspecialchars($row['head_msg'] ?? ''); ?></div></div>
                        <div class="kv-row"><div class="k">Head Date</div><div class="v"><?php echo htmlspecialchars(fmt_date_ddmmyyyy($row['head_date'] ?? '')); ?></div></div>
                    </div>
                <?php endif; ?>

                <?php if ($goesFinance): ?>
                    <!-- ✅ cost >= 10k: Finance ONLY -->
                    <div class="section-title">Finance</div>
                    <div class="kv-box">
                        <div class="kv-row">
                            <div class="k">Finance Status</div>
                            <div class="v"><?php echo htmlspecialchars($row['finance_status'] ?? ''); ?></div>
                        </div>
                        <div class="kv-row"><div class="k">Finance Message</div><div class="v"><?php echo htmlspecialchars($row['finance_msg'] ?? ''); ?></div></div>
                        <div class="kv-row"><div class="k">Finance Date</div><div class="v"><?php echo htmlspecialchars(fmt_date_ddmmyyyy($row['fc_date'] ?? '')); ?></div></div>
                    </div>

                <?php else: ?>
                    <!-- ✅ cost < 10k: based on session be_depart -->
                    <?php if ($be_depart === 'engineering'): ?>
                        <div class="section-title">Engineering</div>
                        <div class="kv-box">
                            <div class="kv-row">
                                <div class="k">Engineering Status</div>
                                <div class="v"><?php echo htmlspecialchars($row['engineering_status'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row"><div class="k">Engineering Message</div><div class="v"><?php echo htmlspecialchars($row['engineering_msg'] ?? ''); ?></div></div>
                            <div class="kv-row"><div class="k">Engineering Date</div><div class="v"><?php echo htmlspecialchars(fmt_date_ddmmyyyy($row['eng_date'] ?? '')); ?></div></div>
                            <div class="kv-row"><div class="k">Engineering Reject Reason</div><div class="v"><?php echo htmlspecialchars($engineeringRejectReason); ?></div></div>
                        </div>

                    <?php elseif ($be_depart === 'admin'): ?>
                        <div class="section-title">Admin</div>
                        <div class="kv-box">
                            <div class="kv-row">
                                <div class="k">Admin Status</div>
                                <div class="v"><?php echo htmlspecialchars($row['admin_status'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row"><div class="k">Admin Message</div><div class="v"><?php echo htmlspecialchars($row['admin_msg'] ?? ''); ?></div></div>
                            <div class="kv-row"><div class="k">Admin Date</div><div class="v"><?php echo htmlspecialchars(fmt_date_ddmmyyyy($row['admin_date'] ?? '')); ?></div></div>
                            <div class="kv-row"><div class="k">Admin Reject Reason</div><div class="v"><?php echo htmlspecialchars($adminRejectReason); ?></div></div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Closeout -->
                <div class="section-title">Closeout</div>
                <div class="kv-box">
                    <div class="kv-row"><div class="k">Closeout Date</div><div class="v"><?php echo htmlspecialchars(fmt_date_ddmmyyyy($row['closeout_date'] ?? '')); ?></div></div>
                    <div class="kv-row"><div class="k">Closeout Remarks</div><div class="v"><?php echo htmlspecialchars($row['closeout'] ?? ''); ?></div></div>
                </div>

                <!-- Task Status -->
                <div class="section-title">Task Status</div>
                <div class="kv-box">
                    <div class="kv-row"><div class="k">Task Status</div><div class="v"><?php echo htmlspecialchars($row['task_status'] ?? ''); ?></div></div>
                </div>

            </div><!-- p-3 -->
        </div><!-- nh-card -->
    </div><!-- container -->
</div><!-- content -->
</div><!-- wrapper -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$('#sidebarCollapse').on('click', function(){
    $('#sidebar').toggleClass('active');
});
</script>

<script src="assets/js/main.js"></script>

<?php include "footer.php"; ?>
</body>
</html>

