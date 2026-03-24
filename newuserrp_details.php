<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

include 'dbconfig.php';

/* =========================
   Helpers
========================= */
function fmt_date_ddmmyyyy($val): string
{
    $val = trim((string)$val);
    if ($val === '' || $val === '0000-00-00' || $val === '0000-00-00 00:00:00') return '';
    try {
        $dt = new DateTime($val);
        return $dt->format('d-m-Y');
    } catch (Exception $e) {
        return htmlspecialchars($val);
    }
}

/* =========================
   Fetch record
========================= */
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$select = "SELECT * FROM newuserform WHERE id = {$id} LIMIT 1";
$select_q = mysqli_query($conn, $select);
$row = mysqli_fetch_assoc($select_q);

if (!$row) {
    die("No record found!");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>New User Form – RP Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php include 'cdncss.php'; ?>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
    <?php include 'sidebarcss.php'; ?>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f5f5;
            color: #000;
        }

        .btn {
            border-radius: 2px;
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
        .nh-card {
            background: #fff;
            border: 1px solid #000;
            border-radius: 16px;
            overflow: hidden;
        }

        /* Header supports title row + centered action row */
        .nh-head {
            padding: 14px 18px 12px;
        }

        .nh-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .nh-head h1 {
            margin: 0;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: .2px;
        }

        .nh-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .nh-actions a {
            font-size: 12px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 8px;
            background: #000;
            color: #fff;
            text-decoration: none;
        }

        /* centered action under heading */
        .nh-center-actions {
            margin-top: 10px;
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .nh-center-actions a {
            font-size: 12px;
            font-weight: 700;
            padding: 7px 14px;
            border-radius: 10px;
            color: #fff;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #6c757d;
        }

        /* ===== Sections ===== */
        .section-title {
            margin: 18px 0 8px;
            font-size: 12.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        /* ===== Field blocks ===== */
        .label {
            font-size: 11.5px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .value-box {
            border: 1px solid #000;
            padding: 7px 10px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 400;
            min-height: 34px;
            white-space: pre-wrap;
            word-break: break-word;
        }

        /* ===== Grid KV layout ===== */
        .kv-box {
            border: 1px solid #000;
            border-radius: 14px;
            padding: 8px 10px;
        }

        .kv-row {
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 10px;
            padding: 6px 0;
            border-top: 1px dashed rgba(0, 0, 0, .25);
        }

        .kv-row:first-child {
            border-top: none;
        }

        .k {
            font-size: 12px;
            font-weight: 600;
        }

        .v {
            font-size: 12px;
            font-weight: 400;
            white-space: pre-wrap;
            word-break: break-word;
        }

        @media(max-width:600px) {
            .kv-row {
                grid-template-columns: 1fr;
            }
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
                        <div class="nh-top">
                            <h1>New User Form – RP Details (Form # <?php echo (int)$row['id']; ?>)</h1>

                            <div class="nh-actions">
                                <a href="new_user_home.php"><i class="fa-solid fa-house"></i> Home</a>
                                <a href="newuser_rp.php"><i class="fa-solid fa-arrow-left"></i> Back</a>
                            </div>
                        </div>

                    </div>

                    <div class="p-3">

                        <!-- Employee Info -->
                        <div class="section-title">Employee Info</div>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="label">Emp ID</div>
                                <div class="value-box"><?php echo htmlspecialchars($row['emp_id'] ?? ''); ?></div>
                            </div>
                            <div class="col-md-3">
                                <div class="label">Name</div>
                                <div class="value-box"><?php echo htmlspecialchars($row['name'] ?? ''); ?></div>
                            </div>
                            <div class="col-md-3">
                                <div class="label">Department</div>
                                <div class="value-box"><?php echo htmlspecialchars($row['department'] ?? ''); ?></div>
                            </div>
                            <div class="col-md-3">
                                <div class="label">Position</div>
                                <div class="value-box"><?php echo htmlspecialchars($row['position'] ?? ''); ?></div>
                            </div>
                        </div>

                        <div class="row g-3 mt-0">
                            <div class="col-md-3">
                                <div class="label">Start Date</div>
                                <div class="value-box"><?php echo htmlspecialchars(fmt_date_ddmmyyyy($row['start_date'] ?? '')); ?></div>
                            </div>
                            <div class="col-md-3">
                                <div class="label">End Date</div>
                                <div class="value-box"><?php echo htmlspecialchars(fmt_date_ddmmyyyy($row['end_date'] ?? '')); ?></div>
                            </div>
                            <div class="col-md-3">
                                <div class="label">Period</div>
                                <div class="value-box"><?php echo htmlspecialchars($row['period'] ?? ''); ?></div>
                            </div>
                            <div class="col-md-3">
                                <div class="label">Reporting To</div>
                                <div class="value-box"><?php echo htmlspecialchars($row['reporting_to'] ?? ''); ?></div>
                            </div>
                        </div>

                        <div class="row g-3 mt-0">
                            <div class="col-md-3">
                                <div class="label">Head Of Department</div>
                                <div class="value-box"><?php echo htmlspecialchars($row['head_of_department'] ?? ''); ?></div>
                            </div>
                        </div>

                        <!-- Systems & Access -->
                        <div class="section-title">Systems & Access</div>
                        <div class="kv-box">
                            <div class="kv-row">
                                <div class="k">Building Access</div>
                                <div class="v"><?php echo htmlspecialchars($row['building_access'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">Attendance</div>
                                <div class="v"><?php echo htmlspecialchars($row['attendance'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">AD User</div>
                                <div class="v"><?php echo htmlspecialchars($row['ad_user'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">Email Access</div>
                                <div class="v"><?php echo htmlspecialchars($row['email_access'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">Sharepoint Access</div>
                                <div class="v"><?php echo htmlspecialchars($row['sharepoint_access'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">Mobile Phone</div>
                                <div class="v"><?php echo htmlspecialchars($row['mobile_phone'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">Payroll System</div>
                                <div class="v"><?php echo htmlspecialchars($row['payroll_system'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">Fixed Assets</div>
                                <div class="v"><?php echo htmlspecialchars($row['fixed_assets'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">Laptop</div>
                                <div class="v"><?php echo htmlspecialchars($row['laptop'] ?? ''); ?></div>
                            </div>
                        </div>

                        <!-- HR -->
                        <div class="section-title">HR</div>
                        <div class="kv-box">
                            <div class="kv-row">
                                <div class="k">HR Status</div>
                                <div class="v"><?php echo htmlspecialchars($row['hr_status'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">HR Message</div>
                                <div class="v"><?php echo htmlspecialchars($row['hr_msg'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">HR Date</div>
                                <div class="v"><?php echo htmlspecialchars(fmt_date_ddmmyyyy($row['hr_date'] ?? '')); ?></div>
                            </div>
                        </div>

                        <!-- IT Department Info -->
                        <div class="section-title">IT Department Info</div>
                        <div class="kv-box">
                            <div class="kv-row">
                                <div class="k">Login ID</div>
                                <div class="v"><?php echo htmlspecialchars($row['login_id'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">Password</div>
                                <div class="v"><?php echo htmlspecialchars($row['password'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">Email Address</div>
                                <div class="v"><?php echo htmlspecialchars($row['email_add'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">Computer Model</div>
                                <div class="v"><?php echo htmlspecialchars($row['c_modal'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">Machine Name</div>
                                <div class="v"><?php echo htmlspecialchars($row['machine_name'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">Condition</div>
                                <div class="v"><?php echo htmlspecialchars($row['conditionnn'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">Serial No</div>
                                <div class="v"><?php echo htmlspecialchars($row['sr_no'] ?? ''); ?></div>
                            </div>
                        </div>

                    </div><!-- p-3 -->
                </div><!-- nh-card -->
            </div><!-- container -->
        </div><!-- content -->
    </div><!-- wrapper -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });
    </script>

    <script src="assets/js/main.js"></script>

    <?php include "footer.php"; ?>
</body>

</html>