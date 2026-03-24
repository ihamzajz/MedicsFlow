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

      <div class="home-shell mb-3">
        <div class="home-heading">Staff Allocation Workflow</div>

        <div class="inner-card">

          <!-- Forms -->
          <div class="section-title first">Forms</div>

          <a class="menu-item" href="sa_form.php">
            <span class="menu-icon icon-green"><i class="fa-solid fa-plus"></i></span>
            <span class="menu-label">Create Form</span>
            <span class="menu-desc">Start a new staff allocation request.</span>
          </a>

          <a class="menu-item" href="sa_dataentry_list.php">
            <span class="menu-icon icon-blue"><i class="fa-solid fa-keyboard"></i></span>
            <span class="menu-label">Data Input</span>
            <span class="menu-desc">Enter daily allocation and manpower data.</span>
          </a>

          <?php if ($sa_role == 'approver' || $be_depart == 'it' || $be_depart == 'super') { ?>
            <!-- Incharge Head Approval -->
            <div class="section-title">Incharge Head Approval</div>

            <a class="menu-item" href="sa_head_list.php">
              <span class="menu-icon icon-amber"><i class="fa-solid fa-check"></i></span>
              <span class="menu-label">Incharge Head Approval</span>
              <span class="menu-desc">Approve incharge and head allocations.</span>
            </a>

            <a class="menu-item" href="sa_dataexport_production.php">
              <span class="menu-icon icon-blue"><i class="fa-solid fa-file-export"></i></span>
              <span class="menu-label">Daily Report</span>
              <span class="menu-desc">Export production allocation reports daily.</span>
            </a>

            <a class="menu-item" href="sa_head_edit_list.php">
              <span class="menu-icon icon-amber"><i class="fa-solid fa-pen-to-square"></i></span>
              <span class="menu-label">Edit</span>
              <span class="menu-desc">Update staff allocation entries quickly.</span>
            </a>
          <?php } ?>

          <?php if ($be_depart == 'it' || $be_depart == 'fpaa' || $fname == 'Mustafa Ahmed Jamal' || $be_depart == 'super') { ?>
            <!-- Finance Approval -->
            <div class="section-title">Finance Approval</div>

            <a class="menu-item" href="sa_fpna_list.php">
              <span class="menu-icon icon-amber"><i class="fa-solid fa-file-invoice-dollar"></i></span>
              <span class="menu-label">Finance Approval</span>
              <span class="menu-desc">Process finance allocation verifications.</span>
            </a>

            <a class="menu-item" href="sa_dataexport_finance.php">
              <span class="menu-icon icon-blue"><i class="fa-solid fa-file-export"></i></span>
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
              <span class="menu-icon icon-blue"><i class="fa-solid fa-gauge-high"></i></span>
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
