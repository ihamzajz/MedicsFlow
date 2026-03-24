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
        <div class="home-heading">Expense Claim Workflow</div>

        <!-- INNER BOX -->
        <div class="inner-card">

          <!-- Forms -->
          <div class="section-title first">Forms</div>

          <a class="menu-item" href="expense_claim_form.php">
            <span class="menu-icon icon-form"><i class="fa-solid fa-plus"></i></span>
            <span class="menu-label">Submit Form</span>
            <span class="menu-desc">Create a new employee expense claim.</span>
          </a>

          <a class="menu-item" href="expense_claim_userlist.php">
            <span class="menu-icon icon-history"><i class="fa-solid fa-clock-rotate-left"></i></span>
            <span class="menu-label">Request History</span>
            <span class="menu-desc">Review all submitted expense claims.</span>
          </a>

          <?php if ($fname == 'Jawaid Iqbal' || $fname == 'Syed Jawwad Ali' || $fname == 'Zohaib Uddin Ansari' || $be_depart == 'it' || $be_depart == 'super') { ?>
            <!-- Admin -->
            <div class="section-title">Admin</div>

            <a class="menu-item" href="expense_claim_admin_list.php">
              <span class="menu-icon icon-approval"><i class="fa-solid fa-user-shield"></i></span>
              <span class="menu-label">Admin Approval</span>
              <span class="menu-desc">Check admin review and approvals.</span>
            </a>
          <?php } ?>

          <?php if (($fname == 'Syed Owais Ahmed' || $fname == 'Danish Tanveer' || $fname == 'Mustafa Ahmed Jamal') || $be_depart == 'it' || $be_depart == 'super') { ?>
            <!-- Finance -->
            <div class="section-title">Finance</div>

            <a class="menu-item" href="expense_claim_finance_list.php">
              <span class="menu-icon icon-approval"><i class="fa-solid fa-file-invoice-dollar"></i></span>
              <span class="menu-label">Finance Approval</span>
              <span class="menu-desc">Validate payable and reimbursement claims.</span>
            </a>
          <?php } ?>

          <?php if ($be_role == 'ceo' || $be_depart == 'it') { ?>
            <!-- CEO -->
            <div class="section-title">CEO</div>

            <a class="menu-item" href="expense_claim_ceo_list.php">
              <span class="menu-icon icon-approval"><i class="fa-solid fa-stamp"></i></span>
              <span class="menu-label">CEO Approval</span>
              <span class="menu-desc">Finalize top level claim approvals.</span>
            </a>
          <?php } ?>

          <?php if (
            $be_role == 'ceo' ||
            $be_depart == 'it' ||
            $be_depart == 'dir' ||
            $fname == 'Syed Owais Ahmed' ||
            $fname == 'Danish Tanveer' ||
            $fname == 'Mustafa Ahmed Jamal' ||
            $fname == 'Jawaid Iqbal' ||
            $fname == 'Syed Jawwad Ali' ||
            $fname == 'Zohaib Uddin Ansari' ||
            $be_depart == 'super'
          ) { ?>
            <!-- Dashboard -->
            <div class="section-title">Dashboard</div>

            <a class="menu-item" href="expense_claim_dashboard.php">
              <span class="menu-icon icon-dashboard"><i class="fa-solid fa-gauge-high"></i></span>
              <span class="menu-label">Dashboard</span>
              <span class="menu-desc">See claim volumes and approval status.</span>
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
