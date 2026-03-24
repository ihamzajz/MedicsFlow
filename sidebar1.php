<?php
include 'dbconfig.php';

$id = $_SESSION['id'] ?? '';
$fname = $_SESSION['fullname'] ?? '';
$username = $_SESSION['username'] ?? '';
$role = $_SESSION['role'] ?? '';
$password = $_SESSION['password'] ?? '';
$gender = $_SESSION['gender'] ?? '';
$department = $_SESSION['department'] ?? '';

$be_depart = $_SESSION['be_depart'] ?? '';
$be_role = $_SESSION['be_role'] ?? '';
$be_role2 = $_SESSION['be_role2'] ?? '';
$be_depart_nh = $_SESSION['be_depart_nh'] ?? '';

$sa_user = $_SESSION['sa_user'] ?? '';
$sa_depart = $_SESSION['sa_depart'] ?? '';
$sa_depart2 = $_SESSION['sa_depart2'] ?? '';
$sa_depart3 = $_SESSION['sa_depart3'] ?? '';
$sa_role = $_SESSION['sa_role'] ?? '';
$email = $_SESSION['email'] ?? '';
$asset_user = $_SESSION['asset_user'] ?? '';

$it_dashboard = $_SESSION['it_dashboard'] ?? 'No';
$sc_dashboard = $_SESSION['sc_dashboard'] ?? 'No';
$sales_dashboard = $_SESSION['sales_dashboard'] ?? 'No';
$finance_dashboard = $_SESSION['finance_dashboard'] ?? 'No';

$expense_finance = $_SESSION['expense_finance'] ?? 'No';
?>

<nav id="sidebar">
    <div class="sidebar-header" style="background-color:#292E34!important">
        <h4 style="font-weight:600">MedicsFlow 2.0</h4>
        <p
            style="color:white!important;font-size:12.5px!important;color:yellow!important;font-weight:400;padding:0px!important;margin:0px!important">
            <?php echo $fname; ?>
        </p>
    </div>

    <ul class="list-unstyled components">
        <li class="text-center mb-2" style="background: #5c6f87; background: -webkit-linear-gradient(to right, #eef2f3, #5c6f87); background: linear-gradient(to right, #eef2f3, #5c6f87);">
            <a href="tutorials.php" style="font-size:12.5px!important;font-weight:600;color:#1f2937!important;padding:8px!important;display:block;">Tutorials</a>
        </li>

        <li class="main-xt text-center mb-2">
            <a href=" http://localhost:9090/MExtractor/login.php" target="_blank" style="font-size:12.5px!important;font-weight:600;color:#ffffff!important;padding:8px!important;display:block;">MExtractor</a>
        </li>

        <li style="background-color:#292E34!important;" class="text-center main-1">
            <a href="#" style="font-size:12.5px!important">PowerBI Dashboards</a>
        </li>

        <li class="mb-1">
            <a href="#pageSubmenu8" data-bs-toggle="collapse" aria-expanded="false"
                style="letter-spacing:0.5px;text-align:left">
                Dashboards <i class="fa-solid fa-arrows-up-down"></i>
                <i class="fas fa-plus toggle-icon" data-target="#pageSubmenu8"></i>
            </a>
            <ul class="collapse list-unstyled" id="pageSubmenu8">
                <?php if ($sales_dashboard == 'Yes' or $be_depart == 'super') { ?>
                    <li><a href="online_booking_bidashboard.php" class="sub-menu-a-bg"
                            style="letter-spacing:0.5px;text-align:left">○ Online Booking</a></li>
                <?php } ?>

                <?php if ($sc_dashboard == 'Yes' or $be_depart == 'super') { ?>
                    <li><a href="supply_chain_bidashboard.php" class="sub-menu-a-bg"
                            style="letter-spacing:0.5px;text-align:left">○ Supply Chain</a></li>
                <?php } ?>

                <?php if ($it_dashboard == 'Yes' or $be_depart == 'super') { ?>
                    <li><a href="technology_bidashboard.php" class="sub-menu-a-bg"
                            style="letter-spacing:0.5px;text-align:left">○ Technology</a></li>
                <?php } ?>

                <?php if ($finance_dashboard == 'Yes' or $be_depart == 'super') { ?>
                    <li><a href="finance_bidashboard.php" class="sub-menu-a-bg"
                            style="letter-spacing:0.5px;text-align:left">○ Finance</a></li>
                <?php } ?>
            </ul>
        </li>

        <li class="text-center main-2">
            <a href="#" style="letter-spacing:0.5px;font-size:12.5px!important">WorkFlow</a>
        </li>

        <li class="">
            <a href="assets_management_home.php" style="letter-spacing:0.5px">
                Asset Management
                <i class="fas fa-plus toggle-icon"></i>
            </a>
        </li>

        <li class="">
            <a href="cc_home.php" style="letter-spacing:0.5px">
                Change Control
                <i class="fas fa-plus toggle-icon"></i>
            </a>
        </li>

        <li class="">
            <a href="erp_access_home.php" style="letter-spacing:0.5px">
                ERP Access
                <i class="fas fa-plus toggle-icon"></i>
            </a>
        </li>

        <li class="mb-1">
            <a href="#pageSubmenu19" data-bs-toggle="collapse" aria-expanded="false"
                style="letter-spacing:0.5px;text-align:left">
                Expense Forms
                <i class="fa-solid fa-arrows-up-down"></i>
                <i class="fas fa-plus toggle-icon" data-target="#pageSubmenu19"></i>
            </a>

            <ul class="collapse list-unstyled" id="pageSubmenu19">
                <li class="mb-1">
                    <a href="cash_purchase_home.php" class="sub-menu-a-bg"
                        style="letter-spacing:0.5px;text-align:left">
                        ○ Cash Purchase
                    </a>
                </li>

                <li class="mb-1">
                    <a href="expense_claim_home.php" class="sub-menu-a-bg"
                        style="letter-spacing:0.5px;text-align:left">
                        ○ Expense Claim
                    </a>
                </li>
            </ul>
        </li>

        <li class="">
            <a href="gatepass.php" style="letter-spacing:0.5px">
                Gatepass
                <i class="fas fa-plus toggle-icon"></i>
            </a>
        </li>

        <li class="">
            <a href="it_accessories_home.php" style="letter-spacing:0.5px">
                IT Accessories
                <i class="fas fa-plus toggle-icon"></i>
            </a>
        </li>

        <li class="">
            <a href="new_hiring_home.php" style="letter-spacing:0.5px">
                New Hiring Form
                <i class="fas fa-plus toggle-icon"></i>
            </a>
        </li>

        <?php if ($be_depart == 'it' or $be_depart == 'hr' or $be_depart == 'super') { ?>
            <li class="">
                <a href="new_user_home.php" style="letter-spacing:0.5px">
                    New User
                    <i class="fas fa-plus toggle-icon"></i>
                </a>
            </li>
        <?php } ?>

        <?php if (($fname == 'Zaighum Hasan') or ($fname == 'Taha Khan') or ($be_depart == 'it') or ($be_depart == 'dir') or ($fname === 'Kaleem Ullah') or ($fname === 'Zeeshan Ahmed') or ($fname == 'Mustafa Ahmed Jamal') or ($be_depart == 'dir' or $be_depart == 'super')) { ?>
            <li class="">
                <a href="ecs" style="letter-spacing:0.5px">
                    Smart Meter Reading
                    <i class="fas fa-plus toggle-icon"></i>
                </a>
            </li>
        <?php } ?>

        <li class="">
            <a href="sa_home.php" style="letter-spacing:0.5px">
                Staff Allocation
                <i class="fas fa-plus toggle-icon"></i>
            </a>
        </li>

        <?php if ($be_depart == 'it' or $be_depart == 'dir' or $be_depart == 'super') { ?>
            <li class="">
                <a href="trf_home.php" style="letter-spacing:0.5px">
                    Travel Request
                    <i class="fas fa-plus toggle-icon"></i>
                </a>
            </li>
        <?php } ?>

        <?php if (($username == 'admin' && $fname == 'Jawaid Iqbal') or ($username == 'farhan' && $fname == 'Farhan Abid') or $be_depart == 'it' or $be_depart == 'dir' or $fname == 'Mustafa Ahmed Jamal' or $fname == 'Syed Jawwad Ali' or $be_depart == 'admin' or $be_depart == 'super') { ?>
            <li class="">
                <a href="vehicle_listall" style="letter-spacing:0.5px">
                    Vehicle Management
                    <i class="fas fa-plus toggle-icon"></i>
                </a>
            </li>
        <?php } ?>

        <li class="">
            <a href="workorder_home.php" style="letter-spacing:0.5px">
                Work Order
                <i class="fas fa-plus toggle-icon"></i>
            </a>
        </li>
    </ul>
    <ul class="list-unstyled CTAs">
        <li class="main-3">
            <a href="logout.php" style="letter-spacing:0.5px;font-size:12.5px!important">Logout</a>
        </li>
        <li><a href="profile.php" class="main-4" style="letter-spacing:0.5px;font-size:13px!important">Profile</a></li>

        <?php if ($be_depart == 'it') { ?>
            <li><a href="admin_panel.php" class="mt-3" style="letter-spacing:0.5px;font-size:13px!important;background-color:#FFFCFB!important;color:black!important">Admin Panel</a></li>
        <?php } ?>
    </ul>

</nav>
