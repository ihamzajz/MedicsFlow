<?php
include "header.php";
?>

<style>
  body {
    background: #c7ccdb !important;
  }

  /* ===== Outer main box ===== */
  .home-shell {
    background: #fff;
    border: .5px solid #ced4da;
    border-radius: 14px;
    box-shadow: 0 10px 26px rgba(0, 0, 0, 0.08);
    padding: 14px;
  }

  /* Main heading */
  .home-heading {
    font-size: 17px;
    font-weight: 700;
    color: black;
    margin: 2px 0 10px;
  }

  /* ===== Inner box ===== */
  .inner-card {
    background: #fff;
    border: 1px solid #eef1f4;
    border-radius: 12px;
    overflow: hidden;
  }

  /* Section title */
  .section-title {
    padding: 10px 12px;
    font-size: 11px;
    font-weight: 700;
    color: black;
    background: #dee2e6 !important;
    border-top: 1px solid #eef1f4;
    letter-spacing: .3px;
    text-transform: uppercase;
    background-color: #dee2e6;
  }

  .section-title.first {
    border-top: 0;
  }

  /* Item row */
  .menu-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 5px 12px;
    text-decoration: none;
    color: #212529;
    font-size: 11px;
    font-weight: 600;
    border-top: 1px solid #eef1f4;
    transition: background .15s ease, color .15s ease;
  }

  .menu-item:hover {
    background: #f7faff;
    color: #0d6efd;
  }

  /* Icon badge */
  .menu-icon {
    width: 28px;
    height: 28px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 28px;
    font-size: 12px;
    background: #f1f3f5;
    color: #0d6efd;
  }

  /* Optional color variants */
  .icon-green {
    color: #198754;
    background: rgba(25, 135, 84, 0.12);
  }

  .icon-blue {
    color: #0d6efd;
    background: rgba(13, 110, 253, 0.12);
  }

  .icon-amber {
    color: #f59f00;
    background: rgba(245, 159, 0, 0.14);
  }
</style>

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

          <a class="menu-item" href="workorderForm.php">
            <span class="menu-icon icon-green"><i class="fa-solid fa-plus"></i></span>
            <span class="menu-label">Submit Form</span>
            <span class="menu-desc">Create a new maintenance request quickly.</span>
          </a>

          <a class="menu-item" href="workorder_userlist.php">
            <span class="menu-icon icon-blue"><i class="fa-solid fa-clock-rotate-left"></i></span>
            <span class="menu-label">Request History</span>
            <span class="menu-desc">Review all previously submitted workorders.</span>
          </a>

          <?php if ($be_role == 'approver' or $be_depart == 'super') { ?>
            <!-- Department Head -->
            <div class="section-title">Department Head</div>

            <a class="menu-item" href="workorder_head_list.php">
              <span class="menu-icon icon-amber"><i class="fa-solid fa-check"></i></span>
              <span class="menu-label">Head Pending Workorder</span>
              <span class="menu-desc">Approve or reject department pending requests.</span>
            </a>

            <a class="menu-item" href="workorder_departmenthead_list.php">
              <span class="menu-icon icon-blue"><i class="fa-solid fa-chart-line"></i></span>
              <span class="menu-label">Department History</span>
              <span class="menu-desc">Track department wise workorder records.</span>
            </a>
          <?php } ?>

          <?php if (($department == 'Engineering' && $role == 'Head of department') or $be_depart == 'it' or $be_depart == 'super') { ?>
            <!-- Engineering Department -->
            <div class="section-title">Engineering Department</div>

            <a class="menu-item" href="workorder_engineering_estimatecost.php">
              <span class="menu-icon icon-amber"><i class="fa-solid fa-calculator"></i></span>
              <span class="menu-label">Cost Evaluation</span>
              <span class="menu-desc">Estimate repair cost before processing.</span>
            </a>

            <a class="menu-item" href="workorder_engineering_list.php">
              <span class="menu-icon icon-blue"><i class="fa-solid fa-list"></i></span>
              <span class="menu-label">Cost less than 10,000</span>
              <span class="menu-desc">Handle lower value engineering workorders.</span>
            </a>

            <a class="menu-item" href="workorder_engineering_closeout.php">
              <span class="menu-icon icon-amber"><i class="fa-solid fa-circle-check"></i></span>
              <span class="menu-label">Closeout</span>
              <span class="menu-desc">Mark completed engineering jobs properly.</span>
            </a>

            <a class="menu-item" href="eng_workorder_rp.php">
              <span class="menu-icon icon-blue"><i class="fa-solid fa-gauge-high"></i></span>
              <span class="menu-label">Dashboard</span>
              <span class="menu-desc">View engineering workorder status summaries.</span>
            </a>
          <?php } ?>

          <?php if (($be_depart == 'eng' && $be_role == 'user') or $be_depart == 'it' or $be_depart == 'super') { ?>
            <!-- Engineering (User) -->
            <div class="section-title">Engineering</div>

            <a class="menu-item" href="workorder_engineering_closeout.php">
              <span class="menu-icon icon-amber"><i class="fa-solid fa-circle-check"></i></span>
              <span class="menu-label">Closeout</span>
              <span class="menu-desc">Close assigned engineering requests fast.</span>
            </a>

            <a class="menu-item" href="eng_workorder_rp.php">
              <span class="menu-icon icon-blue"><i class="fa-solid fa-gauge-high"></i></span>
              <span class="menu-label">Dashboard</span>
              <span class="menu-desc">Monitor engineering queue and progress.</span>
            </a>
          <?php } ?>

          <?php if (($department == 'Administration' && $role == 'Manager Administration') or $be_depart == 'it' or $be_depart == 'super') { ?>
            <!-- Admin Department -->
            <div class="section-title">Admin Department</div>

            <a class="menu-item" href="workorder_admin_estimatecost.php">
              <span class="menu-icon icon-amber"><i class="fa-solid fa-calculator"></i></span>
              <span class="menu-label">Cost Evaluation</span>
              <span class="menu-desc">Assess admin workorder cost approvals.</span>
            </a>

            <a class="menu-item" href="workorder_admin_list.php">
              <span class="menu-icon icon-blue"><i class="fa-solid fa-list"></i></span>
              <span class="menu-label">Cost less than 10,000</span>
              <span class="menu-desc">Review lower value admin requests.</span>
            </a>

            <a class="menu-item" href="workorder_admin_closeout.php">
              <span class="menu-icon icon-amber"><i class="fa-solid fa-circle-check"></i></span>
              <span class="menu-label">Closeout</span>
              <span class="menu-desc">Finalize completed admin work orders.</span>
            </a>

            <a class="menu-item" href="admin_workorder_rp.php">
              <span class="menu-icon icon-blue"><i class="fa-solid fa-gauge-high"></i></span>
              <span class="menu-label">Dashboard</span>
              <span class="menu-desc">See admin workorder activity at a glance.</span>
            </a>
          <?php } ?>

          <?php if ($role == 'Manager Financial Planning and Analysis' or $be_depart == 'it' or ($be_role == 'approver' and $be_depart == 'finance') or $be_depart == 'super') { ?>
            <!-- Finance Department -->
            <div class="section-title">Finance Department</div>

            <a class="menu-item" href="workorder_finance_list.php">
              <span class="menu-icon icon-amber"><i class="fa-solid fa-file-invoice-dollar"></i></span>
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
