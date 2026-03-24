<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

include 'dbconfig.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$q = mysqli_query($conn, "SELECT * FROM new_hiring WHERE id={$id} LIMIT 1");
$row = mysqli_fetch_assoc($q);
if (!$row) die("No record found");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>New Hiring – Head Approval Details</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link rel="stylesheet" href="assets/css/style.css">
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
    font-weight:700;
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
    font-weight:700;
    margin-bottom:4px;
}
.value-box{
    border:1px solid #000;
    padding:7px 10px;
    border-radius:10px;
    font-size:12px;
    font-weight:500;
    min-height:34px;
    white-space:pre-wrap;
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
}
.k{ font-size:12px; font-weight:700; }
.v{ font-size:12px; font-weight:500; white-space:pre-wrap; }
@media(max-width:600px){
    .kv-row{ grid-template-columns:1fr; }
}

/* ===== Status Table ===== */
.status-table{
    width:100%;
    border:1px solid #000;
    border-radius:12px;
    border-collapse:separate;
    border-spacing:0;
    overflow:hidden;
}
.status-table th{
    background:#000;
    color:#fff;
    font-size:12px;
    font-weight:700;
    padding:8px;
}
.status-table td{
    font-size:12px;
    padding:8px;
    vertical-align:top;
}
.badge-status{
    padding:3px 10px;
    border-radius:20px;
    border:1px solid #000;
    font-size:11px;
    font-weight:700;
    display:inline-block;
}

/* ===== Sales table ===== */
.nh-table-wrap{ overflow:auto; }
.nh-mini-table{
    width:100%;
    border:1px solid #000;
    border-radius:12px;
    border-collapse:separate;
    border-spacing:0;
    overflow:hidden;
    min-width:1100px;
}
.nh-mini-table th{
    background:#000;
    color:#fff;
    font-size:12px;
    font-weight:700;
    padding:8px;
    white-space:nowrap;
}
.nh-mini-table td{
    font-size:12px;
    padding:8px;
    border-top:1px solid #000;
    white-space:nowrap;
}
</style>
</head>

<body>
<div class="wrapper d-flex align-items-stretch">
<?php include 'sidebar1.php'; ?>

<div id="content">
<nav class="navbar navbar-light bg-menu">
    <div class="container-fluid">
        <button id="sidebarCollapse" class="btn btn-menu">
            <i class="fas fa-align-left"></i>
            <span>Menu</span>
        </button>
    </div>
</nav>

<div class="container-fluid p-3">
<div class="nh-card">

<!-- Header -->
<div class="nh-head">
    <h1>Head Approval – Details</h1>
    <div class="nh-actions">
        <a href="new_hiring_home.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="new_hiring_form_head_list.php"><i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="p-3">

<!-- Approve / Reject -->
<div class="text-center mb-2">
    <a href="#" class="btn btn-success btn-sm" onclick="promptReason(<?php echo (int)$row['id']; ?>)">
        <i class="fa-regular fa-circle-check"></i> Approve
    </a>
    <a href="#" class="btn btn-danger btn-sm" onclick="promptReason2(<?php echo (int)$row['id']; ?>)">
        <i class="fa-regular fa-circle-xmark"></i> Reject
    </a>
</div>

<!-- Submitter Info -->
<div class="section-title">Submitter Info</div>
<div class="row g-3">
    <div class="col-md-3">
        <div class="label">Name</div>
        <div class="value-box"><?php echo htmlspecialchars($row['user_name']); ?></div>
    </div>
    <div class="col-md-3">
        <div class="label">Department</div>
        <div class="value-box"><?php echo htmlspecialchars($row['user_department']); ?></div>
    </div>
    <div class="col-md-3">
        <div class="label">Role</div>
        <div class="value-box"><?php echo htmlspecialchars($row['user_role']); ?></div>
    </div>
    <div class="col-md-3">
        <div class="label">Submission Date</div>
        <div class="value-box"><?php echo htmlspecialchars($row['date_of_request']); ?></div>
    </div>
</div>

<!-- Extra quick fields (Form For / Reason) -->
<div class="row g-3 mt-1">
    <div class="col-md-3">
        <div class="label">Form For</div>
        <div class="value-box"><?php echo htmlspecialchars($row['form_for']); ?></div>
    </div>
    <div class="col-md-3">
        <div class="label">Reason of Request</div>
        <div class="value-box"><?php echo htmlspecialchars($row['reason_of_request']); ?></div>
    </div>
</div>

<!-- Request Details -->
<div class="section-title">Request Details</div>
<div class="kv-box">
    <div class="kv-row"><div class="k">Date Of Request</div><div class="v"><?php echo htmlspecialchars($row['date_of_request']); ?></div></div>
    <div class="kv-row"><div class="k">Position Title</div><div class="v"><?php echo htmlspecialchars($row['position_title']); ?></div></div>
    <div class="kv-row"><div class="k">Department</div><div class="v"><?php echo htmlspecialchars($row['department']); ?></div></div>
    <div class="kv-row"><div class="k">Division</div><div class="v"><?php echo htmlspecialchars($row['division']); ?></div></div>
    <div class="kv-row"><div class="k">Location</div><div class="v"><?php echo htmlspecialchars($row['location']); ?></div></div>
</div>

<!-- Replacement block only if Replacement -->
<?php if (($row['reason_of_request'] ?? '') === 'Replacement') { ?>
    <div class="section-title">Replacement Details</div>
    <div class="kv-box">
        <div class="kv-row"><div class="k">Emp Name</div><div class="v"><?php echo htmlspecialchars($row['emp_name']); ?></div></div>
        <div class="kv-row"><div class="k">Emp Code</div><div class="v"><?php echo htmlspecialchars($row['emp_code']); ?></div></div>
        <div class="kv-row"><div class="k">Designation</div><div class="v"><?php echo htmlspecialchars($row['designation']); ?></div></div>
    </div>
<?php } ?>

<!-- Job & Requirements -->
<div class="section-title">Job & Requirements</div>
<div class="kv-box">
    <div class="kv-row"><div class="k">Required Education / Certification</div><div class="v"><?php echo htmlspecialchars($row['required_education']); ?></div></div>
    <div class="kv-row"><div class="k">Salary Range</div><div class="v"><?php echo htmlspecialchars($row['salary_range']); ?></div></div>
    <div class="kv-row"><div class="k">Job Type</div><div class="v"><?php echo htmlspecialchars($row['job_type']); ?></div></div>
    <div class="kv-row"><div class="k">Job Responsibilities</div><div class="v"><?php echo htmlspecialchars($row['job_responsibilities']); ?></div></div>
</div>

<!-- Sales block only if Sales -->
<?php if (($row['form_for'] ?? '') === 'Sales') { ?>
    <div class="section-title">Mandatory Responses</div>
    <div class="kv-box">
        <div class="kv-row"><div class="k">Q1. Field force team & areas?</div><div class="v"><?php echo htmlspecialchars($row['q1']); ?></div></div>
        <div class="kv-row"><div class="k">Q2. Area covered by new position?</div><div class="v"><?php echo htmlspecialchars($row['q2']); ?></div></div>
        <div class="kv-row"><div class="k">Q3. Current sales of the area?</div><div class="v"><?php echo htmlspecialchars($row['q3']); ?></div></div>
    </div>

    <div class="section-title">Sales Breakdown</div>
    <div class="nh-table-wrap">
        <table class="nh-mini-table">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Year</th>
                    <th>No. of Customers</th>
                    <th>Existing Sales / month</th>
                    <th>Expected Sales / month</th>
                    <th>Current BDO Assigned</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $months = [
                    ["January","january1","customer_1","existing_sales_1","exp_sales_1","bdo_1"],
                    ["February","february1","customer_2","existing_sales_2","exp_sales_2","bdo_2"],
                    ["March","march1","customer_1","existing_sales_1","exp_sales_1","bdo_1"],
                    ["April","april1","customer_1","existing_sales_1","exp_sales_1","bdo_1"],
                    ["May","may1","customer_1","existing_sales_1","exp_sales_1","bdo_1"],
                    ["June","june1","customer_1","existing_sales_1","exp_sales_1","bdo_1"],
                    ["July","july1","customer_1","existing_sales_1","exp_sales_1","bdo_1"],
                    ["August","august1","customer_1","existing_sales_1","exp_sales_1","bdo_1"],
                    ["September","september1","customer_1","existing_sales_1","exp_sales_1","bdo_1"],
                    ["October","october1","customer_1","existing_sales_1","exp_sales_1","bdo_1"],
                    ["November","november1","customer_1","existing_sales_1","exp_sales_1","bdo_1"],
                    ["December","december1","customer_1","existing_sales_1","exp_sales_1","bdo_1"],
                    ["Average Sales","average_sales1","customer_13","existing_sales_13","exp_sales_13","bdo_13"],
                ];

                foreach ($months as $m) {
                    echo "<tr>";
                    echo "<td>".htmlspecialchars($m[0])."</td>";
                    echo "<td>".htmlspecialchars($row[$m[1]] ?? '')."</td>";
                    echo "<td>".htmlspecialchars($row[$m[2]] ?? '')."</td>";
                    echo "<td>".htmlspecialchars($row[$m[3]] ?? '')."</td>";
                    echo "<td>".htmlspecialchars($row[$m[4]] ?? '')."</td>";
                    echo "<td>".htmlspecialchars($row[$m[5]] ?? '')."</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
<?php } ?>

</div><!-- p-3 -->
</div><!-- nh-card -->
</div><!-- container -->
</div><!-- content -->
</div><!-- wrapper -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$('#sidebarCollapse').on('click',function(){
    $('#sidebar').toggleClass('active');
});
</script>
<script src="assets/js/main.js"></script>

<script>
function promptReason(itemId) {
    var reason = prompt("Enter remarks:");
    if (reason != null && reason.trim() !== "") {
        window.location.href = "new_hiring_form_head_approve.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
    }
}
function promptReason2(itemId) {
    var reason = prompt("Enter remarks:");
    if (reason != null && reason.trim() !== "") {
        window.location.href = "new_hiring_form_head_reject.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
    }
}
</script>

</body>
</html>
