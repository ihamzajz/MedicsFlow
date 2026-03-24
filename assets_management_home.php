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
        <div class="home-heading">Assets Management Workflow</div>

        <!-- INNER BOX -->
        <div class="inner-card">

          <?php if ($asset_user == 'yes' || $be_depart == 'super') { ?>
            <div class="section-title first">Asset Management</div>

            <a class="menu-item" href="assets_list.php">
              <span class="menu-icon icon-listing"><i class="fa-solid fa-boxes-stacked"></i></span>
              <span class="menu-label">Assets</span>
              <span class="menu-desc">Browse and manage asset records.</span>
            </a>

          <?php } elseif ($asset_user == 'no') { ?>
            <div class="section-title first">Asset Management</div>

            <a class="menu-item" href="assets_list_user.php">
              <span class="menu-icon icon-listing"><i class="fa-solid fa-list"></i></span>
              <span class="menu-label">Asset List</span>
              <span class="menu-desc">View asset items assigned to you.</span>
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
