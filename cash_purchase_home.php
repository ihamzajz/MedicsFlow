<?php
include("header.php");
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
        <div class="home-heading">Cash Purchase Requisition Workflow</div>

        <!-- INNER BOX -->
        <div class="inner-card">

          <!-- Forms -->
          <div class="section-title first">Forms</div>

          <a class="menu-item" href="cash_purchase_form.php">
            <span class="menu-icon icon-green"><i class="fa-solid fa-plus"></i></span>
            <span class="menu-label">Submit Form</span>
            <span class="menu-desc">Create a new cash purchase request.</span>
          </a>

          <a class="menu-item" href="cash_purchase_userlist.php">
            <span class="menu-icon icon-blue"><i class="fa-solid fa-clock-rotate-left"></i></span>
            <span class="menu-label">Request History</span>
            <span class="menu-desc">Review your submitted purchase requests.</span>
          </a>

          <?php if ($fname == 'Jawaid Iqbal' || $fname == 'Syed Jawwad Ali' || $fname == 'Zohaib Uddin Ansari' || $be_depart == 'it' || $be_depart == 'super') { ?>
            <!-- Admin -->
            <div class="section-title">Admin</div>

            <a class="menu-item" href="cash_purchase_admin_list.php">
              <span class="menu-icon icon-amber"><i class="fa-solid fa-user-shield"></i></span>
              <span class="menu-label">Admin Approval</span>
              <span class="menu-desc">Process admin level purchase approvals.</span>
            </a>
          <?php } ?>

          <?php if (($fname == 'Syed Owais Ahmed' || $be_depart == 'super' || $fname == 'Danish Tanveer' || $fname == 'Mustafa Ahmed Jamal') || $be_depart == 'it') { ?>
            <!-- Finance -->
            <div class="section-title">Finance</div>

            <a class="menu-item" href="cash_purchase_finance_list.php">
              <span class="menu-icon icon-amber"><i class="fa-solid fa-file-invoice-dollar"></i></span>
              <span class="menu-label">Finance Approval</span>
              <span class="menu-desc">Verify finance side payment requests.</span>
            </a>
          <?php } ?>

          <?php if ($be_role == 'ceo' || $be_depart == 'it') { ?>
            <!-- CEO -->
            <div class="section-title">CEO</div>

            <a class="menu-item" href="cash_purchase_ceo_list.php">
              <span class="menu-icon icon-amber"><i class="fa-solid fa-stamp"></i></span>
              <span class="menu-label">CEO Approval</span>
              <span class="menu-desc">Review high level purchase decisions.</span>
            </a>
          <?php } ?>

          <?php if ($be_role == 'ceo' || $be_depart == 'it' || $be_role == 'admin' || $expense_finance == 'yes' || $be_role == 'dir' || $be_depart == 'super') { ?>
            <!-- Dashboard -->
            <div class="section-title">Dashboard</div>

            <a class="menu-item" href="cash_purchase_dashboard.php">
              <span class="menu-icon icon-blue"><i class="fa-solid fa-gauge-high"></i></span>
              <span class="menu-label">Dashboard</span>
              <span class="menu-desc">Track purchase trends and approvals.</span>
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
