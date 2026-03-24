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
<title>New Hiring – Request Details</title>
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
.btn{
    border-radius:2px;
}
/* ===== Top Bar ===== */
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
}

.nh-head h1{
    margin:0;
    font-size:18px;
    font-weight:800;
    letter-spacing:.2px;
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

/* ===== Grid KV layout (previous layout style) ===== */
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

.k{
    font-size:12px;
    font-weight:700;
}

.v{
    font-size:12px;
    font-weight:500;
    white-space:pre-wrap;
}

@media(max-width:600px){
    .kv-row{ grid-template-columns:1fr; }
}

/* ===== Status Table (minimal lines) ===== */
.status-table{
    width:100%;
    border:1px solid #000;
    border-radius:12px;
    border-collapse:separate;
    border-spacing:0;
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
</style>
</head>

<body>
<div class="wrapper d-flex align-items-stretch">
<?php include 'sidebar1.php'; ?>

<div id="content">
<nav class="navbar navbar-light bg-menu">
    <div class="container-fluid">
        <button id="sidebarCollapse" class="btn btn-menu">
            <i class="fas fa-bars"></i> Menu
        </button>
    </div>
</nav>

<div class="container-fluid p-3">
<div class="nh-card">

<!-- Header -->
<div class="nh-head">
    <h1>Request Details</h1>
    <div class="nh-actions">
        <a href="new_hiring_home.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="new_hiring_form_request_history.php"><i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="p-3">

<!-- Submitter -->
<div class="section-title">Submitter Info</div>
<div class="row g-3">
    <div class="col-md-3">
        <div class="label">Name</div>
        <div class="value-box"><?= htmlspecialchars($row['user_name']) ?></div>
    </div>
    <div class="col-md-3">
        <div class="label">Department</div>
        <div class="value-box"><?= htmlspecialchars($row['user_department']) ?></div>
    </div>
    <div class="col-md-3">
        <div class="label">Role</div>
        <div class="value-box"><?= htmlspecialchars($row['user_role']) ?></div>
    </div>
    <div class="col-md-3">
        <div class="label">Submission Date</div>
        <div class="value-box"><?= htmlspecialchars($row['date_of_request']) ?></div>
    </div>
</div>

<!-- Request -->
<div class="section-title">Request Details</div>
<div class="kv-box">
    <div class="kv-row"><div class="k">Position Title</div><div class="v"><?= $row['position_title'] ?></div></div>
    <div class="kv-row"><div class="k">Department</div><div class="v"><?= $row['department'] ?></div></div>
    <div class="kv-row"><div class="k">Division</div><div class="v"><?= $row['division'] ?></div></div>
    <div class="kv-row"><div class="k">Location</div><div class="v"><?= $row['location'] ?></div></div>
    <div class="kv-row"><div class="k">Reason of Request</div><div class="v"><?= $row['reason_of_request'] ?></div></div>
</div>

<!-- Job -->
<div class="section-title">Job & Requirements</div>
<div class="kv-box">
    <div class="kv-row"><div class="k">Required Education</div><div class="v"><?= $row['required_education'] ?></div></div>
    <div class="kv-row"><div class="k">Salary Range</div><div class="v"><?= $row['salary_range'] ?></div></div>
    <div class="kv-row"><div class="k">Job Type</div><div class="v"><?= $row['job_type'] ?></div></div>
    <div class="kv-row"><div class="k">Job Responsibilities</div><div class="v"><?= $row['job_responsibilities'] ?></div></div>
</div>

<!-- Status -->
<div class="section-title">Approval Status</div>
<table class="status-table">
<thead>
<tr>
    <th>Department</th>
    <th>Status</th>
    <th>Action By</th>
    <th>Remarks</th>
    <th>Date</th>
</tr>
</thead>
<tbody>
<tr>
    <td><b>HOD</b></td>
    <td><span class="badge-status"><?= $row['hod_status'] ?></span></td>
    <td><?= $row['hod_msg'] ?></td>
    <td><?= $row['hod_comment'] ?></td>
    <td><?= $row['hod_date'] ?></td>
</tr>
<tr>
    <td><b>CEO</b></td>
    <td><span class="badge-status"><?= $row['ceo_status'] ?></span></td>
    <td><?= $row['ceo_msg'] ?></td>
    <td><?= $row['ceo_comment'] ?></td>
    <td><?= $row['ceo_date'] ?></td>
</tr>
<tr>
    <td><b>HR</b></td>
    <td><span class="badge-status"><?= $row['hr_status'] ?></span></td>
    <td><?= $row['hr_msg'] ?></td>
    <td><?= $row['hr_comment'] ?></td>
    <td><?= $row['hr_date'] ?></td>
</tr>
</tbody>
</table>

</div>
</div>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$('#sidebarCollapse').on('click',function(){
    $('#sidebar').toggleClass('active');
});
</script>
<script src="assets/js/main.js"></script>
</body>
</html>
