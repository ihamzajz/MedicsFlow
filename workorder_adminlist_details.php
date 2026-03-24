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
   Fetch record (Admin details)
========================= */
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$select = "SELECT * FROM workorder_form WHERE id = {$id} LIMIT 1";
$select_q = mysqli_query($conn, $select);
$row = mysqli_fetch_assoc($select_q);

if (!$row) {
    die("No record found!");
}

/* =========================
   SAME LOGIC as your Engineering details page
   (only difference: Approve/Reject endpoints are ADMIN)
========================= */
$amountRaw = $row['amount'] ?? '';
$amountNum = is_numeric($amountRaw) ? (float)$amountRaw : 0;
$goesFinance = ($amountNum >= 10000);

$departType = strtolower(trim((string)($row['depart_type'] ?? ''))); // engineering/admin
$rowBeRole  = strtolower(trim((string)($row['be_role'] ?? '')));     // approver/user...

// ✅ Head Approval visible only if DB be_role is NOT approver
$showHeadApproval = ($rowBeRole !== 'approver');

// ✅ cost < 10k: show based on depart_type
$showEngineering = (!$goesFinance && $departType === 'engineering');
$showAdmin       = (!$goesFinance && $departType === 'admin');

/* =========================
   ✅ Admin endpoints (FOR BUTTONS)
   (This is what you want: admin approve/reject)
========================= */
$approveFile = 'workorder_admin_approve.php';
$rejectFile  = 'workorder_admin_reject.php';

/* Keep same params style like your list pages */
$rowEmail    = (string)($row['email'] ?? '');
$rowName     = (string)($row['name'] ?? '');
$rowType     = (string)($row['type'] ?? '');
$rowCategory = (string)($row['category'] ?? '');
$rowDepartT  = (string)($row['depart_type'] ?? '');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Workorder – Admin Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php include 'cdncss.php'; ?>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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

        /* ✅ Professional Action Buttons (SAME) */
        .action-row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center;
            padding: 12px 14px;
            margin: 14px 18px 0;
            border: 1px solid rgba(0, 0, 0, .12);
            background: #fafafa;
            border-radius: 14px;
        }

        .button-approveN,
        .button-rejectN {
            appearance: none;
            -webkit-appearance: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 38px;
            min-width: 140px;
            padding: 0 16px;
            border-radius: 12px;
            font-size: 12.5px;
            font-weight: 800;
            letter-spacing: .2px;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid transparent;
            transition: transform .12s ease, box-shadow .12s ease, filter .12s ease, background .12s ease, border-color .12s ease;
            user-select: none;
            line-height: 1;
        }

        .button-approveN:focus,
        .button-rejectN:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .18);
        }

        .button-approveN:active,
        .button-rejectN:active {
            transform: translateY(1px);
        }

        .button-approveN {
            background: linear-gradient(180deg, #22c55e 0%, #16a34a 100%);
            border-color: #15803d;
            color: #fff;
            box-shadow: 0 8px 18px rgba(22, 163, 74, .18);
        }

        .button-approveN:hover {
            filter: brightness(.98);
            box-shadow: 0 10px 22px rgba(22, 163, 74, .24);
        }

        .button-rejectN {
            background: linear-gradient(180deg, #ef4444 0%, #dc2626 100%);
            border-color: #b91c1c;
            color: #fff;
            box-shadow: 0 8px 18px rgba(220, 38, 38, .18);
        }

        .button-rejectN:hover {
            filter: brightness(.98);
            box-shadow: 0 10px 22px rgba(220, 38, 38, .24);
        }

        .button-approveN::before {
            content: "✓";
            font-weight: 900;
        }

        .button-rejectN::before {
            content: "✕";
            font-weight: 900;
        }
    </style>
<?php include 'workorder_nav_theme.php'; ?>
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
                        <h1>Workorder – Details (Form # <?php echo (int)$row['id']; ?>)</h1>
                        <div class="nh-actions">
                            <a href="workorder_home.php"><i class="fa-solid fa-house"></i> Home</a>
                            <a href="workorder_admin_list.php"><i class="fa-solid fa-arrow-left"></i> Back</a>
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
                            <div class="kv-row">
                                <div class="k">Request For Department</div>
                                <div class="v"><?php echo htmlspecialchars($row['depart_type'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">Type</div>
                                <div class="v"><?php echo htmlspecialchars($row['type'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">Category</div>
                                <div class="v"><?php echo htmlspecialchars($row['category'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">Amount</div>
                                <div class="v"><?php echo htmlspecialchars($row['amount'] ?? ''); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">Description</div>
                                <div class="v"><?php echo htmlspecialchars($row['description'] ?? ''); ?></div>
                            </div>
                        </div>

                        <!-- ✅ Head Approval -->
                        <?php if ($showHeadApproval): ?>
                            <div class="section-title">Head Approval</div>
                            <div class="kv-box">
                                <div class="kv-row">
                                    <div class="k">Head Status</div>
                                    <div class="v"><?php echo htmlspecialchars($row['head_status'] ?? ''); ?></div>
                                </div>
                                <div class="kv-row">
                                    <div class="k">Head Message</div>
                                    <div class="v"><?php echo htmlspecialchars($row['head_msg'] ?? ''); ?></div>
                                </div>
                                <div class="kv-row">
                                    <div class="k">Head Date</div>
                                    <div class="v"><?php echo htmlspecialchars(fmt_date_ddmmyyyy($row['head_date'] ?? '')); ?></div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- ✅ Finance / Engineering / Admin blocks (same display logic) -->
                        <?php if ($goesFinance): ?>
                            <div class="section-title">Finance</div>
                            <div class="kv-box">
                                <div class="kv-row">
                                    <div class="k">Finance Status</div>
                                    <div class="v"><?php echo htmlspecialchars($row['finance_status'] ?? ''); ?></div>
                                </div>
                                <div class="kv-row">
                                    <div class="k">Finance Message</div>
                                    <div class="v"><?php echo htmlspecialchars($row['finance_msg'] ?? ''); ?></div>
                                </div>
                                <div class="kv-row">
                                    <div class="k">Finance Date</div>
                                    <div class="v"><?php echo htmlspecialchars(fmt_date_ddmmyyyy($row['fc_date'] ?? '')); ?></div>
                                </div>
                            </div>
                        <?php else: ?>

                            <?php if ($showEngineering): ?>
                                <div class="section-title">Engineering</div>
                                <div class="kv-box">
                                    <div class="kv-row">
                                        <div class="k">Engineering Status</div>
                                        <div class="v"><?php echo htmlspecialchars($row['engineering_status'] ?? ''); ?></div>
                                    </div>
                                    <div class="kv-row">
                                        <div class="k">Engineering Message</div>
                                        <div class="v"><?php echo htmlspecialchars($row['engineering_msg'] ?? ''); ?></div>
                                    </div>
                                    <div class="kv-row">
                                        <div class="k">Engineering Date</div>
                                        <div class="v"><?php echo htmlspecialchars(fmt_date_ddmmyyyy($row['eng_date'] ?? '')); ?></div>
                                    </div>
                                    <div class="kv-row">
                                        <div class="k">Engineering Reject Reason</div>
                                        <div class="v"><?php echo htmlspecialchars($row['reason'] ?? ''); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($showAdmin): ?>
                                <div class="section-title">Admin</div>
                                <div class="kv-box">
                                    <div class="kv-row">
                                        <div class="k">Admin Status</div>
                                        <div class="v"><?php echo htmlspecialchars($row['admin_status'] ?? ''); ?></div>
                                    </div>
                                    <div class="kv-row">
                                        <div class="k">Admin Message</div>
                                        <div class="v"><?php echo htmlspecialchars($row['admin_msg'] ?? ''); ?></div>
                                    </div>
                                    <div class="kv-row">
                                        <div class="k">Admin Date</div>
                                        <div class="v"><?php echo htmlspecialchars(fmt_date_ddmmyyyy($row['admin_date'] ?? '')); ?></div>
                                    </div>
                                    <div class="kv-row">
                                        <div class="k">Admin Reject Reason</div>
                                        <div class="v"><?php echo htmlspecialchars($row['reason'] ?? ''); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                        <?php endif; ?>

                        <!-- Closeout -->
                        <div class="section-title">Closeout</div>
                        <div class="kv-box">
                            <div class="kv-row">
                                <div class="k">Closeout Date</div>
                                <div class="v"><?php echo htmlspecialchars(fmt_date_ddmmyyyy($row['closeout_date'] ?? '')); ?></div>
                            </div>
                            <div class="kv-row">
                                <div class="k">Closeout Remarks</div>
                                <div class="v"><?php echo htmlspecialchars($row['closeout'] ?? ''); ?></div>
                            </div>
                        </div>

                        <!-- Task Status -->
                        <div class="section-title">Task Status</div>
                        <div class="kv-box">
                            <div class="kv-row">
                                <div class="k">Task Status</div>
                                <div class="v"><?php echo htmlspecialchars($row['task_status'] ?? ''); ?></div>
                            </div>
                        </div>

                    </div><!-- p-3 -->
                </div><!-- nh-card -->
            </div><!-- container -->
        </div><!-- content -->
    </div><!-- wrapper -->


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="assets/js/main.js"></script>

    <script>
        $(document).ready(function() {
            // ✅ Sidebar CLOSED on page load
            $('#sidebar').removeClass('active'); // or just don't addClass at all

            // Handle sidebar collapse toggle
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });

            // Update the icon when collapsing/expanding
            $('[data-bs-toggle="collapse"]').on('click', function() {
                var target = $(this).find('.toggle-icon');
                if ($(this).attr('aria-expanded') === 'true') {
                    target.removeClass('fa-plus').addClass('fa-minus');
                } else {
                    target.removeClass('fa-minus').addClass('fa-plus');
                }
            });
        });


    </script>


</body>

</html>
