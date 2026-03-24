<?php
include "header.php";
?>

<style>
body {
    background: linear-gradient(
        225deg,
        #E9EDF5 0%,
        #C0C8DB 25%,
        #8A96B2 50%,
        #586581 75%,
        #3A4259 100%
    ) !important;
}

/* ===== Outer main box ===== */
.home-shell{
  background:#fff;
  border:.5px solid #ced4da;
  border-radius:14px;
  box-shadow:0 10px 26px rgba(0,0,0,0.08);
  padding:14px;
}

/* Main heading */
.home-heading{
  font-size:17px;
  font-weight:700;
  color:black;
  margin:2px 0 10px;
}

/* ===== Inner box that contains sections/items ===== */
.inner-card{
  background:#fff;
  border:1px solid #eef1f4;
  border-radius:12px;
  overflow:hidden;
}

/* Section heading */
.section-title{
  padding:10px 12px;
  font-size:11px;
  font-weight:700;
  color:black;
  background:#f8f9fa;
  border-top:1px solid #eef1f4;
  letter-spacing:.3px;
  text-transform:uppercase;
  background-color:#dee2e6;
}
.section-title.first{
  border-top:0;
}

/* Item rows */
.menu-item{
  display:flex;
  align-items:center;
  gap:10px;
  padding:5px 12px;
  text-decoration:none;
  color:#212529;
  font-size:11px;
  font-weight:600;
  border-top:1px solid #eef1f4;
  transition:background .15s ease, color .15s ease;
}
.menu-item:hover{
  background:#f7faff;
  color:#0d6efd;
}

/* Icon badge */
.menu-icon{
  width:28px;
  height:28px;
  border-radius:10px;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  flex:0 0 28px;
  font-size:12px;
  background:#f1f3f5;
  color:#0d6efd;
}

/* Optional color variants */
.icon-green { color:#198754; background:rgba(25,135,84,0.12); }
.icon-blue  { color:#0d6efd; background:rgba(13,110,253,0.12); }
.icon-amber { color:#f59f00; background:rgba(245,159,0,0.14); }
</style>

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
              <span class="menu-icon icon-blue"><i class="fa-solid fa-boxes-stacked"></i></span>
              <span class="menu-label">Assets</span>
              <span class="menu-desc">Browse and manage asset records.</span>
            </a>

          <?php } elseif ($asset_user == 'no') { ?>
            <div class="section-title first">Asset Management</div>

            <a class="menu-item" href="assets_list_user.php">
              <span class="menu-icon icon-blue"><i class="fa-solid fa-list"></i></span>
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
