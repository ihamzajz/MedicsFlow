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
   Fetch Record
========================= */
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id < 1) die("Invalid ID!");

$select   = "SELECT * FROM erpaccess_form WHERE id = {$id} LIMIT 1";
$select_q = mysqli_query($conn, $select);
$row      = mysqli_fetch_assoc($select_q);

if (!$row) {
    die("No record found!");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ERP – IT Head Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="assets/css/style.css">
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

        .nh-head {
            padding: 14px 18px;
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
                        <h1>ERP Access Form # <?php echo (int)$row['id']; ?></h1>
                        <div class="nh-actions">
                            <a href="erp_access_home.php"><i class="fa-solid fa-house"></i> Home</a>
                            <a href="erp_ithead_list.php"><i class="fa-solid fa-arrow-left"></i> Back</a>
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

                        <!-- Request Type -->
                        <div class="section-title">Request</div>
                        <div class="kv-box">
                            <div class="kv-row">
                                <div class="k">Request Type</div>
                                <div class="v"><?php echo htmlspecialchars($row['req_type'] ?? ''); ?></div>
                            </div>
                        </div>

                        <!-- ERP Access -->
                        <div class="section-title">ERP Access</div>
                        <div class="kv-box">
                            <div class="kv-row">
                                <div class="k">SCM Purchase</div>
                                <div class="v"><?php echo htmlspecialchars($row['scm_purchase'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">SCM Inventory</div>
                                <div class="v"><?php echo htmlspecialchars($row['scm_inventory'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">SCM Production</div>
                                <div class="v"><?php echo htmlspecialchars($row['scm_production'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">SCM Sales</div>
                                <div class="v"><?php echo htmlspecialchars($row['scm_sales'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">SCM Misc</div>
                                <div class="v"><?php echo htmlspecialchars($row['scm_misc'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">SCM Admin Setup</div>
                                <div class="v"><?php echo htmlspecialchars($row['scm_admin_setup'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">SCM General Ledger</div>
                                <div class="v"><?php echo htmlspecialchars($row['scm_general_ledger'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">SCM Accounts Payable</div>
                                <div class="v"><?php echo htmlspecialchars($row['scm_accounts_payable'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">HCM</div>
                                <div class="v"><?php echo htmlspecialchars($row['hcm'] ?? ''); ?></div>
                            </div>
                        </div>

                        <!-- Message -->
                        <div class="section-title">Message</div>
                        <div class="kv-box">
                            <div class="kv-row">
                                <div class="k">Message</div>
                                <div class="v"><?php echo htmlspecialchars($row['message'] ?? ($row['msg'] ?? '')); ?></div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="text-center mt-3">
                            <a
                                class="btn btn-success btn-sm"
                                href="erp_ithead_approve.php?id=<?php echo (int)$row['id']; ?>&email=<?php echo urlencode((string)($row['email'] ?? '')); ?>&name=<?php echo urlencode((string)($row['name'] ?? '')); ?>">
                                <i class="fa-solid fa-circle-check"></i> Approve
                            </a>

                            <a
                                class="btn btn-danger btn-sm"
                                href="erp_ithead_reject.php?id=<?php echo (int)$row['id']; ?>&email=<?php echo urlencode((string)($row['email'] ?? '')); ?>&name=<?php echo urlencode((string)($row['name'] ?? '')); ?>">
                                <i class="fa-solid fa-circle-xmark"></i> Reject
                            </a>
                        </div>

                    </div><!-- p-3 -->
                </div><!-- nh-card -->
            </div><!-- container -->
        </div><!-- content -->
    </div><!-- wrapper -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // ✅ IMPORTANT: your sidebar id is #sidebar (not #sidebar1)
            $('#sidebar').addClass('active');
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>

    <script src="assets/js/main.js"></script>
    <?php include "footer.php"; ?>
</body>

</html>