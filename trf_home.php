<?php
include "header.php";
include "workflow_home_theme.php";
?>

<div class="container">
    <div class="row">
        <div class="col-md-5">
            <div class="home-shell mb-3">
                <div class="home-heading">Travel Request Workflow</div>

                <div class="inner-card">
                    <div class="section-title first">Forms</div>

                    <a class="menu-item" href="trf.php">
                        <span class="menu-icon icon-form"><i class="fa-solid fa-plus"></i></span>
                        <span class="menu-label">Submit Form</span>
                        <span class="menu-desc">Create a new travel request.</span>
                    </a>

                    <a class="menu-item" href="trf_userlist.php">
                        <span class="menu-icon icon-history"><i class="fa-solid fa-clock-rotate-left"></i></span>
                        <span class="menu-label">Request History</span>
                        <span class="menu-desc">Review previously submitted travel forms.</span>
                    </a>

                    <div class="section-title">Department Head Approval</div>

                    <a class="menu-item" href="trf_head_list.php">
                        <span class="menu-icon icon-approval"><i class="fa-solid fa-check"></i></span>
                        <span class="menu-label">Department Head Approval</span>
                        <span class="menu-desc">Approve department travel applications.</span>
                    </a>

                    <?php if ($fname == 'Jawaid Iqbal' or $fname == 'Syed Jawwad Ali' or $fname == 'Zohaib Uddin Ansari' or $be_depart == 'it') { ?>
                        <div class="section-title">Admin Approval</div>

                        <a class="menu-item" href="trf_admin_list.php">
                            <span class="menu-icon icon-approval"><i class="fa-solid fa-user-shield"></i></span>
                            <span class="menu-label">Admin Approval</span>
                            <span class="menu-desc">Review travel logistics and admin checks.</span>
                        </a>
                    <?php } ?>

                    <?php if (($fname == 'Syed Owais Ahmed' or $fname == 'Muhammad Yaman' or $fname == 'Danish Tanveer' or $fname == 'Mustafa Ahmed Jamal' or $fname == 'Nasarullah Khan') or $be_depart == 'it') { ?>
                        <div class="section-title">Finance Approval</div>

                        <a class="menu-item" href="trf_finance_list.php">
                            <span class="menu-icon icon-approval"><i class="fa-solid fa-file-invoice-dollar"></i></span>
                            <span class="menu-label">Finance Approval</span>
                            <span class="menu-desc">Validate budget and finance approval.</span>
                        </a>
                    <?php } ?>

                    <div class="section-title">Dashboard</div>

                    <a class="menu-item" href="trf_dashboard.php">
                        <span class="menu-icon icon-dashboard"><i class="fa-solid fa-chart-line"></i></span>
                        <span class="menu-label">Dashboard</span>
                        <span class="menu-desc">Track travel requests and approvals.</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>
