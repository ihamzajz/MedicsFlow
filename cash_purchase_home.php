<?php
include("header.php");
?>

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
            <span class="menu-icon icon-form"><i class="fa-solid fa-plus"></i></span>
            <span class="menu-label">Submit Form</span>
            <span class="menu-desc">Create a new cash purchase request.</span>
          </a>

          <a class="menu-item" href="cash_purchase_userlist.php">
            <span class="menu-icon icon-history"><i class="fa-solid fa-clock-rotate-left"></i></span>
            <span class="menu-label">Request History</span>
            <span class="menu-desc">Review your submitted purchase requests.</span>
          </a>

          <?php if ($fname == 'Jawaid Iqbal' || $fname == 'Syed Jawwad Ali' || $fname == 'Zohaib Uddin Ansari' || $be_depart == 'it' || $be_depart == 'super') { ?>
            <!-- Admin -->
            <div class="section-title">Admin</div>

            <a class="menu-item" href="cash_purchase_admin_list.php">
              <span class="menu-icon icon-approval"><i class="fa-solid fa-user-shield"></i></span>
              <span class="menu-label">Admin Approval</span>
              <span class="menu-desc">Process admin level purchase approvals.</span>
            </a>
          <?php } ?>

          <?php if (($fname == 'Syed Owais Ahmed' || $be_depart == 'super' || $fname == 'Danish Tanveer' || $fname == 'Mustafa Ahmed Jamal') || $be_depart == 'it') { ?>
            <!-- Finance -->
            <div class="section-title">Finance</div>

            <a class="menu-item" href="cash_purchase_finance_list.php">
              <span class="menu-icon icon-approval"><i class="fa-solid fa-file-invoice-dollar"></i></span>
              <span class="menu-label">Finance Approval</span>
              <span class="menu-desc">Verify finance side payment requests.</span>
            </a>
          <?php } ?>

          <?php if ($be_role == 'ceo' || $be_depart == 'it') { ?>
            <!-- CEO -->
            <div class="section-title">CEO</div>

            <a class="menu-item" href="cash_purchase_ceo_list.php">
              <span class="menu-icon icon-approval"><i class="fa-solid fa-stamp"></i></span>
              <span class="menu-label">CEO Approval</span>
              <span class="menu-desc">Review high level purchase decisions.</span>
            </a>
          <?php } ?>

          <?php if ($be_role == 'ceo' || $be_depart == 'it' || $be_role == 'admin' || $expense_finance == 'yes' || $be_role == 'dir' || $be_depart == 'super') { ?>
            <!-- Dashboard -->
            <div class="section-title">Dashboard</div>

            <a class="menu-item" href="cash_purchase_dashboard.php">
              <span class="menu-icon icon-dashboard"><i class="fa-solid fa-gauge-high"></i></span>
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
