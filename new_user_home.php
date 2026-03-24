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
            <span class="menu-icon icon-green">
              <i class="fa-solid fa-plus"></i>
            </span>
            <span class="menu-label">Submit Form</span>
            <span class="menu-desc">Create a new user onboarding request.</span>
          </a>

          <?php if ($fname == 'Taha Ahmed' || $be_depart == 'it' || $be_depart == 'super') { ?>
            <!-- HR Head Approval -->
            <div class="section-title">HR Head Approval</div>

            <a class="menu-item" href="newuserhr.php">
              <span class="menu-icon icon-amber">
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
              <span class="menu-icon icon-amber">
                <i class="fa-solid fa-user-gear"></i>
              </span>
              <span class="menu-label">IT Approval</span>
              <span class="menu-desc">Prepare accounts and access approvals.</span>
            </a>

            <!-- Dashboard -->
            <div class="section-title">Dashboard</div>

            <a class="menu-item" href="newuser_rp.php">
              <span class="menu-icon icon-blue">
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
