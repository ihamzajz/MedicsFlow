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
        <div class="home-heading">IT Accessories Workflow</div>

        <!-- INNER BOX -->
        <div class="inner-card">

          <!-- Forms -->
          <div class="section-title first">Forms</div>

          <a class="menu-item" href="it_accessories_form.php">
            <span class="menu-icon icon-form">
              <i class="fa-solid fa-plus"></i>
            </span>
            <span class="menu-label">Submit Form</span>
            <span class="menu-desc">Request required IT accessory items.</span>
          </a>

          <a class="menu-item" href="itacc_userlist.php">
            <span class="menu-icon icon-history">
              <i class="fa-solid fa-clock-rotate-left"></i>
            </span>
            <span class="menu-label">Request History</span>
            <span class="menu-desc">Review your IT accessory requests.</span>
          </a>

          <?php if ($be_depart == 'it' or $be_depart == 'super') { ?>
            <!-- IT Approval -->
            <div class="section-title">IT Approval</div>

            <a class="menu-item" href="itacc_it.php">
              <span class="menu-icon icon-approval">
                <i class="fa-solid fa-hourglass-half"></i>
              </span>
              <span class="menu-label">Pending Request</span>
              <span class="menu-desc">Approve outstanding accessory requests.</span>
            </a>

            <a class="menu-item" href="itacc_dashboard.php">
              <span class="menu-icon icon-dashboard">
                <i class="fa-solid fa-gauge-high"></i>
              </span>
              <span class="menu-label">Dashboard</span>
              <span class="menu-desc">Track IT accessory request activity.</span>
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
