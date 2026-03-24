<?php
include "header.php";
include "workflow_home_theme.php";
?>

<div class="container">
  <div class="row">
    <div class="col-md-5">
      <div class="home-shell mb-3">
        <div class="home-heading">Gatepass</div>

        <div class="inner-card">
          <div class="section-title first">Forms</div>

          <a href="gatepass_form.php" class="menu-item">
            <span class="menu-icon icon-form">
              <i class="fa-solid fa-plus"></i>
            </span>
            <span class="menu-label">Create Record</span>
          </a>

          <a href="gatepass_dashboard.php" class="menu-item">
            <span class="menu-icon icon-dashboard">
              <i class="fa-solid fa-chart-line"></i>
            </span>
            <span class="menu-label">Dashboard</span>
          </a>

          <a href="gatepass_record_list.php" class="menu-item">
            <span class="menu-icon icon-edit">
              <i class="fa-solid fa-pen-to-square"></i>
            </span>
            <span class="menu-label">Edit Records</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "footer.php"; ?>
