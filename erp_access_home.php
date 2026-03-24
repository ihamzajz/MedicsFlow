<?php
include "header.php";
?>

<?php include "workflow_home_theme.php"; ?>

<div class="container">
  <div class="row">
    <div class="col-md-5">

      <div class="home-shell mb-3">
        <div class="home-heading">ERP Access Workflow</div>

        <div class="inner-card">

          <!-- Forms -->
          <div class="section-title first">Forms</div>

          <a class="menu-item" href="erpAccessForm.php">
            <span class="menu-icon icon-form"><i class="fa-solid fa-plus"></i></span>
            <span class="menu-label">Submit Form</span>
            <span class="menu-desc">Request new ERP access permissions.</span>
          </a>

          <a class="menu-item" href="erp_userlist.php">
            <span class="menu-icon icon-history"><i class="fa-solid fa-clock-rotate-left"></i></span>
            <span class="menu-label">Request History</span>
            <span class="menu-desc">Check earlier ERP access submissions.</span>
          </a>

          <?php if ($be_role == 'approver' || $be_depart == 'it' || $be_depart == 'super') { ?>
            <!-- Department Head Approval -->
            <div class="section-title">Department Head Approval</div>

            <a class="menu-item" href="erp_departmenthead_list.php">
              <span class="menu-icon icon-approval"><i class="fa-solid fa-list-check"></i></span>
              <span class="menu-label">Pending Request</span>
              <span class="menu-desc">Approve department pending ERP requests.</span>
            </a>

            <a class="menu-item" href="erp_dhead_list.php">
              <span class="menu-icon icon-listing"><i class="fa-solid fa-folder-open"></i></span>
              <span class="menu-label">Department All Requests</span>
              <span class="menu-desc">Browse all department access requests.</span>
            </a>
          <?php } ?>

          <?php if ($be_depart == 'it' || $be_depart == 'super') { ?>
            <!-- IT Head Approval -->
            <div class="section-title">IT Head Approval</div>

            <a class="menu-item" href="erp_ithead_list.php">
              <span class="menu-icon icon-approval"><i class="fa-solid fa-user-gear"></i></span>
              <span class="menu-label">Pending Request</span>
              <span class="menu-desc">Handle IT side access approvals.</span>
            </a>

            <!-- Dashboard -->
            <div class="section-title">Dashboard</div>

            <a class="menu-item" href="erp_access_dashboard.php">
              <span class="menu-icon icon-dashboard"><i class="fa-solid fa-gauge-high"></i></span>
              <span class="menu-label">Dashboard</span>
              <span class="menu-desc">Monitor ERP request status and trends.</span>
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
