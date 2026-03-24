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
<title>New Hiring – CEO Approval Details</title>
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

/* ===== Menu ===== */
.bg-menu{ background:#393E46 !important; }
.btn-menu{
    font-size:12.5px;
    background:#FFB22C !important;
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
}
.nh-actions{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
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

/* ===== Fields ===== */
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

/* ===== KV Layout ===== */
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
    <h1>CEO Approval – Details</h1>
    <div class="nh-actions">
        <a href="new_hiring_home.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="new_hiring_form_ceo_list.php"><i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="p-3">

<!-- Approve / Reject -->
<div class="text-center mb-3">
    <a href="#" class="btn btn-success btn-sm"
       onclick="promptReason(<?= (int)$row['id'] ?>)">
        <i class="fa-regular fa-circle-check"></i> Approve
    </a>
    <a href="#" class="btn btn-danger btn-sm"
       onclick="promptReason2(<?= (int)$row['id'] ?>)">
        <i class="fa-regular fa-circle-xmark"></i> Reject
    </a>
</div>

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

<!-- Replacement -->
<?php if ($row['reason_of_request'] === 'Replacement') { ?>
<div class="section-title">Replacement Details</div>
<div class="kv-box">
    <div class="kv-row"><div class="k">Emp Name</div><div class="v"><?= $row['emp_name'] ?></div></div>
    <div class="kv-row"><div class="k">Emp Code</div><div class="v"><?= $row['emp_code'] ?></div></div>
    <div class="kv-row"><div class="k">Designation</div><div class="v"><?= $row['designation'] ?></div></div>
</div>
<?php } ?>

<!-- Job -->
<div class="section-title">Job & Requirements</div>
<div class="kv-box">
    <div class="kv-row"><div class="k">Required Education</div><div class="v"><?= $row['required_education'] ?></div></div>
    <div class="kv-row"><div class="k">Salary Range</div><div class="v"><?= $row['salary_range'] ?></div></div>
    <div class="kv-row"><div class="k">Job Type</div><div class="v"><?= $row['job_type'] ?></div></div>
    <div class="kv-row"><div class="k">Job Responsibilities</div><div class="v"><?= $row['job_responsibilities'] ?></div></div>
</div>

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
function promptReason(id){
    var r = prompt("Enter remarks:");
    if(r && r.trim() !== ""){
        window.location.href =
            "new_hiring_form_ceo_approve.php?id="+id+"&reason="+encodeURIComponent(r);
    }
}
function promptReason2(id){
    var r = prompt("Enter remarks:");
    if(r && r.trim() !== ""){
        window.location.href =
            "new_hiring_form_ceo_reject.php?id="+id+"&reason="+encodeURIComponent(r);
    }
}
</script>
<script src="assets/js/main.js"></script>
</body>
</html>
