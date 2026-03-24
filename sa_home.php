<?php
include "header.php";
?>

<?php include "workflow_home_theme.php"; ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-5">

      <div class="home-shell mb-3">
        <div class="home-heading">Staff Allocation Workflow</div>

        <div class="inner-card">

          <!-- Forms -->
          <div class="section-title first">Forms</div>

          <a class="menu-item" href="sa_form.php">
            <span class="menu-icon icon-form"><i class="fa-solid fa-plus"></i></span>
            <span class="menu-label">Create Form</span>
            <span class="menu-desc">Start a new staff allocation request.</span>
          </a>

          <a class="menu-item" href="sa_dataentry_list.php">
            <span class="menu-icon icon-data"><i class="fa-solid fa-keyboard"></i></span>
            <span class="menu-label">Data Input</span>
            <span class="menu-desc">Enter daily allocation and manpower data.</span>
          </a>

          <?php if ($sa_role == 'approver' || $be_depart == 'it' || $be_depart == 'super') { ?>
            <!-- Incharge Head Approval -->
            <div class="section-title">Incharge Head Approval</div>

            <a class="menu-item" href="sa_head_list.php">
              <span class="menu-icon icon-approval"><i class="fa-solid fa-check"></i></span>
              <span class="menu-label">Incharge Head Approval</span>
              <span class="menu-desc">Approve incharge and head allocations.</span>
            </a>

            <a class="menu-item" href="sa_dataexport_production.php">
              <span class="menu-icon icon-report"><i class="fa-solid fa-file-export"></i></span>
              <span class="menu-label">Daily Report</span>
              <span class="menu-desc">Export production allocation reports daily.</span>
            </a>

            <a class="menu-item" href="sa_head_edit_list.php">
              <span class="menu-icon icon-edit"><i class="fa-solid fa-pen-to-square"></i></span>
              <span class="menu-label">Edit</span>
              <span class="menu-desc">Update staff allocation entries quickly.</span>
            </a>
          <?php } ?>

          <?php if ($be_depart == 'it' || $be_depart == 'fpaa' || $fname == 'Mustafa Ahmed Jamal' || $be_depart == 'super') { ?>
            <!-- Finance Approval -->
            <div class="section-title">Finance Approval</div>

            <a class="menu-item" href="sa_fpna_list.php">
              <span class="menu-icon icon-approval"><i class="fa-solid fa-file-invoice-dollar"></i></span>
              <span class="menu-label">Finance Approval</span>
              <span class="menu-desc">Process finance allocation verifications.</span>
            </a>

            <a class="menu-item" href="sa_dataexport_finance.php">
              <span class="menu-icon icon-report"><i class="fa-solid fa-file-export"></i></span>
              <span class="menu-label">Daily Report</span>
              <span class="menu-desc">Export finance side allocation reports.</span>
            </a>
          <?php } ?>

          <?php if (
            $be_depart == 'it' ||
            $be_depart == 'fpaa' ||
            ($be_depart == 'pro' && $be_role == 'approver') ||
            $be_depart == 'dir' ||
            $fname == 'Mustafa Ahmed Jamal' ||
            ($sa_depart == 'yes' && $sa_role == 'approver') ||
            $be_depart == 'super'
          ) { ?>
            <!-- Dashboard -->
            <div class="section-title">Dashboard</div>

            <a class="menu-item" href="sa_dashboard_list.php">
              <span class="menu-icon icon-dashboard"><i class="fa-solid fa-gauge-high"></i></span>
              <span class="menu-label">Batch-Wise Report</span>
              <span class="menu-desc">Analyze allocation data by batch.</span>
            </a>
          <?php } ?>

        </div><!-- /inner-card -->
      </div><!-- /home-shell -->

    </div>
  </div>
</div>

<?php
include 'footer.php';
?>
