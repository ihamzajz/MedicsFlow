<?php
include "header.php";
?>

<?php include "workflow_home_theme.php"; ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-5">

      <!-- MAIN OUTER BOX -->
      <div class="home-shell mb-3">

        <!-- MAIN HEADING -->
        <div class="home-heading">Workorder Workflow</div>

        <!-- INNER BOX -->
        <div class="inner-card">

          <!-- Forms -->
          <div class="section-title first">Forms</div>

          <a class="menu-item" href="workorder_form.php">
            <span class="menu-icon icon-form"><i class="fa-solid fa-plus"></i></span>
            <span class="menu-label">Submit Form</span>
            <span class="menu-desc">Create a new maintenance request quickly.</span>
          </a>

          <a class="menu-item" href="workorder_userlist.php">
            <span class="menu-icon icon-history"><i class="fa-solid fa-clock-rotate-left"></i></span>
            <span class="menu-label">Request History</span>
            <span class="menu-desc">Review all previously submitted workorders.</span>
          </a>

          <?php if ($be_role == 'approver' or $be_depart == 'super') { ?>
            <!-- Department Head -->
            <div class="section-title">Department Head</div>

            <a class="menu-item" href="workorder_head_list.php">
              <span class="menu-icon icon-approval"><i class="fa-solid fa-check"></i></span>
              <span class="menu-label">Head Pending Workorder</span>
              <span class="menu-desc">Approve or reject department pending requests.</span>
            </a>

            <a class="menu-item" href="workorder_departmenthead_list.php">
              <span class="menu-icon icon-history"><i class="fa-solid fa-chart-line"></i></span>
              <span class="menu-label">Department History</span>
              <span class="menu-desc">Track department wise workorder records.</span>
            </a>
          <?php } ?>

          <?php if (($department == 'Engineering' && $role == 'Head of department') or $be_depart == 'it' or $be_depart == 'super') { ?>
            <!-- Engineering Department -->
            <div class="section-title">Engineering Department</div>

            <a class="menu-item" href="workorder_engineering_estimatecost.php">
              <span class="menu-icon icon-cost"><i class="fa-solid fa-calculator"></i></span>
              <span class="menu-label">Cost Evaluation</span>
              <span class="menu-desc">Estimate repair cost before processing.</span>
            </a>

            <a class="menu-item" href="workorder_engineering_list.php">
              <span class="menu-icon icon-listing"><i class="fa-solid fa-list"></i></span>
              <span class="menu-label">Cost less than 10,000</span>
              <span class="menu-desc">Handle lower value engineering workorders.</span>
            </a>

            <a class="menu-item" href="workorder_engineering_closeout.php">
              <span class="menu-icon icon-closeout"><i class="fa-solid fa-circle-check"></i></span>
              <span class="menu-label">Closeout</span>
              <span class="menu-desc">Mark completed engineering jobs properly.</span>
            </a>

            <a class="menu-item" href="eng_workorder_rp.php">
              <span class="menu-icon icon-dashboard"><i class="fa-solid fa-gauge-high"></i></span>
              <span class="menu-label">Dashboard</span>
              <span class="menu-desc">View engineering workorder status summaries.</span>
            </a>
          <?php } ?>

          <?php if (($be_depart == 'eng' && $be_role == 'user') or $be_depart == 'it' or $be_depart == 'super') { ?>
            <!-- Engineering (User) -->
            <div class="section-title">Engineering</div>

            <a class="menu-item" href="workorder_engineering_closeout.php">
              <span class="menu-icon icon-closeout"><i class="fa-solid fa-circle-check"></i></span>
              <span class="menu-label">Closeout</span>
              <span class="menu-desc">Close assigned engineering requests fast.</span>
            </a>

            <a class="menu-item" href="eng_workorder_rp.php">
              <span class="menu-icon icon-dashboard"><i class="fa-solid fa-gauge-high"></i></span>
              <span class="menu-label">Dashboard</span>
              <span class="menu-desc">Monitor engineering queue and progress.</span>
            </a>
          <?php } ?>

          <?php if (($department == 'Administration' && $role == 'Manager Administration') or $be_depart == 'it' or $be_depart == 'super') { ?>
            <!-- Admin Department -->
            <div class="section-title">Admin Department</div>

            <a class="menu-item" href="workorder_admin_estimatecost.php">
              <span class="menu-icon icon-cost"><i class="fa-solid fa-calculator"></i></span>
              <span class="menu-label">Cost Evaluation</span>
              <span class="menu-desc">Assess admin workorder cost approvals.</span>
            </a>

            <a class="menu-item" href="workorder_admin_list.php">
              <span class="menu-icon icon-listing"><i class="fa-solid fa-list"></i></span>
              <span class="menu-label">Cost less than 10,000</span>
              <span class="menu-desc">Review lower value admin requests.</span>
            </a>

            <a class="menu-item" href="workorder_admin_closeout.php">
              <span class="menu-icon icon-closeout"><i class="fa-solid fa-circle-check"></i></span>
              <span class="menu-label">Closeout</span>
              <span class="menu-desc">Finalize completed admin work orders.</span>
            </a>

            <a class="menu-item" href="admin_workorder_rp.php">
              <span class="menu-icon icon-dashboard"><i class="fa-solid fa-gauge-high"></i></span>
              <span class="menu-label">Dashboard</span>
              <span class="menu-desc">See admin workorder activity at a glance.</span>
            </a>
          <?php } ?>

          <?php if ($role == 'Manager Financial Planning and Analysis' or $be_depart == 'it' or ($be_role == 'approver' and $be_depart == 'finance') or $be_depart == 'super') { ?>
            <!-- Finance Department -->
            <div class="section-title">Finance Department</div>

            <a class="menu-item" href="workorder_finance_list.php">
              <span class="menu-icon icon-approval"><i class="fa-solid fa-file-invoice-dollar"></i></span>
              <span class="menu-label">Finance Workorder Requests</span>
              <span class="menu-desc">Review finance stage workorder approvals.</span>
            </a>
          <?php } ?>

        </div><!-- /inner-card -->

      </div><!-- /home-shell -->

    </div>
  </div>
</div>

<?php
include "footer.php";
?>
