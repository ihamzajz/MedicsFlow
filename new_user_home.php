<?php
include "header.php";
?>

<?php include "workflow_home_theme.php"; ?>

<div class="container">
  <div class="row">
    <div class="col-md-5">

      <!-- MAIN OUTER BOX -->
      <div class="home-shell mb-3">

        <!-- MAIN HEADING -->
        <div class="home-heading">New User Workflow</div>

        <!-- INNER BOX -->
        <div class="inner-card">

          <!-- Forms -->
          <div class="section-title first">Forms</div>

          <a class="menu-item" href="newuserform.php">
            <span class="menu-icon icon-form">
              <i class="fa-solid fa-plus"></i>
            </span>
            <span class="menu-label">Submit Form</span>
            <span class="menu-desc">Create a new user onboarding request.</span>
          </a>

          <?php if ($fname == 'Taha Ahmed' || $be_depart == 'it' || $be_depart == 'super') { ?>
            <!-- HR Head Approval -->
            <div class="section-title">HR Head Approval</div>

            <a class="menu-item" href="newuserhr.php">
              <span class="menu-icon icon-approval">
                <i class="fa-solid fa-list-check"></i>
              </span>
              <span class="menu-label">Pending Requests</span>
              <span class="menu-desc">Review HR side onboarding requests.</span>
            </a>
          <?php } ?>

          <?php if ($be_depart == 'it' || $be_depart == 'super') { ?>
            <!-- IT Department -->
            <div class="section-title">IT Department</div>

            <a class="menu-item" href="newuserit.php">
              <span class="menu-icon icon-approval">
                <i class="fa-solid fa-user-gear"></i>
              </span>
              <span class="menu-label">IT Approval</span>
              <span class="menu-desc">Prepare accounts and access approvals.</span>
            </a>

            <!-- Dashboard -->
            <div class="section-title">Dashboard</div>

            <a class="menu-item" href="newuser_rp.php">
              <span class="menu-icon icon-dashboard">
                <i class="fa-solid fa-gauge-high"></i>
              </span>
              <span class="menu-label">Dashboard</span>
              <span class="menu-desc">Track onboarding status and reports.</span>
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
