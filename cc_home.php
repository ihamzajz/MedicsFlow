<?php
include "header.php";
?>

<?php include "workflow_home_theme.php"; ?>

<div class="container">
  <div class="row">
    <div class="col-md-5">

      <div class="home-shell mb-3">
        <div class="home-heading">Change Control Workflow</div>

        <div class="inner-card">

          <!-- Forms -->
          <div class="section-title first">Forms</div>

          <a class="menu-item" href="cc_form.php">
            <span class="menu-icon icon-form"><i class="fa-solid fa-plus"></i></span>
            <span class="menu-label">Submit Form</span>
            <span class="menu-desc">Raise a new change control request.</span>
          </a>

          <a class="menu-item" href="cc_user_forms.php">
            <span class="menu-icon icon-history"><i class="fa-solid fa-clock-rotate-left"></i></span>
            <span class="menu-label">Record History</span>
            <span class="menu-desc">Browse submitted change control records.</span>
          </a>

          <!-- Approval -->
          <?php if ($be_role == 'approver' || $be_depart == 'it' || $be_role == 'ceo' || $be_depart == 'super') { ?>
            <div class="section-title">Approval</div>

            <?php if ($be_role == 'approver' || $be_depart == 'it' || $be_depart == 'super') { ?>
              <a class="menu-item" href="cc_depthead_list.php">
                <span class="menu-icon icon-approval"><i class="fa-solid fa-user-check"></i></span>
                <span class="menu-label">Dept. Head Approval</span>
                <span class="menu-desc">Approve department level change requests.</span>
              </a>
            <?php } ?>

            <?php if ($be_depart == 'it' || ($be_role == 'approver' && $be_depart == 'qaqc') || $be_depart == 'super') { ?>
              <a class="menu-item" href="cc_qchead_list.php">
                <span class="menu-icon icon-approval"><i class="fa-solid fa-flask"></i></span>
                <span class="menu-label">Quality Head Approval</span>
                <span class="menu-desc">Review QA and compliance submissions.</span>
              </a>
            <?php } ?>

            <?php if ($be_depart == 'it' || $be_role == 'ceo' || $be_depart == 'super') { ?>
              <a class="menu-item" href="cc_ceo_list.php">
                <span class="menu-icon icon-approval"><i class="fa-solid fa-stamp"></i></span>
                <span class="menu-label">CEO Approval</span>
                <span class="menu-desc">Finalize executive approval for changes.</span>
              </a>
            <?php } ?>
          <?php } ?>

          <!-- Data Input -->
          <div class="section-title">Data Input</div>

          <a class="menu-item" href="cc_dept_input_list.php">
            <span class="menu-icon icon-data"><i class="fa-solid fa-keyboard"></i></span>
            <span class="menu-label">Dept. Input</span>
            <span class="menu-desc">Enter department follow-up details here.</span>
          </a>

          <?php if ($fname == 'Ehtesham Ul Haq' || $be_depart == 'sc' || $be_depart == 'it' || ($be_role == 'approver' && $be_depart == 'qaqc') || $be_depart == 'super') { ?>
            <a class="menu-item" href="cc_add_stock_list.php">
              <span class="menu-icon icon-listing"><i class="fa-solid fa-boxes-stacked"></i></span>
              <span class="menu-label">Add Stock</span>
              <span class="menu-desc">Update stock usage against requests.</span>
            </a>
          <?php } ?>

          <a class="menu-item" href="cc_add_action_plan_list.php">
            <span class="menu-icon icon-report"><i class="fa-solid fa-list-check"></i></span>
            <span class="menu-label">Action Plan</span>
            <span class="menu-desc">Manage actions and assigned activities.</span>
          </a>

          <!-- QA -->
          <?php if (($be_role == 'approver' && $be_depart == 'qaqc') || $be_depart == 'it' || $be_depart == 'super') { ?>
            <div class="section-title">QA Department</div>

            <a class="menu-item" href="cc_edit_list.php">
              <span class="menu-icon icon-edit"><i class="fa-solid fa-pen-to-square"></i></span>
              <span class="menu-label">Edit</span>
              <span class="menu-desc">Modify approved QA change records.</span>
            </a>
          <?php } ?>

          <!-- Dashboard -->
          <div class="section-title">Dashboard</div>

          <a class="menu-item" href="cc_dashboard.php">
            <span class="menu-icon icon-dashboard"><i class="fa-solid fa-gauge-high"></i></span>
            <span class="menu-label">Dashboard</span>
            <span class="menu-desc">View change control activity summaries.</span>
          </a>

        </div><!-- /inner-card -->
      </div><!-- /home-shell -->

    </div>
  </div>
</div>

<?php
include 'footer.php';
?>
