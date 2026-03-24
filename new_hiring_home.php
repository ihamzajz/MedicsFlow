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
        <div class="home-heading">New Hiring Workflow</div>

        <!-- INNER BOX (sections/items) -->
        <div class="inner-card">

          <!-- Forms -->
          <div class="section-title first">Forms</div>

          <a class="menu-item" href="new_hiring_form.php">
            <span class="menu-icon icon-form"><i class="fa-solid fa-plus"></i></span>
            <span class="menu-label">Submit Form</span>
            <span class="menu-desc">Start a new hiring requisition.</span>
          </a>

          <a class="menu-item" href="new_hiring_form_request_history.php">
            <span class="menu-icon icon-history"><i class="fa-solid fa-clock-rotate-left"></i></span>
            <span class="menu-label">Request History</span>
            <span class="menu-desc">Review previous hiring form requests.</span>
          </a>

          <?php if ($be_role == 'approver' or $be_depart == 'it' or $be_depart == 'super') { ?>
            <!-- HOD -->
            <div class="section-title">HOD</div>

            <a class="menu-item" href="new_hiring_form_head_list.php">
              <span class="menu-icon icon-approval"><i class="fa-solid fa-check"></i></span>
              <span class="menu-label">HOD Approval</span>
              <span class="menu-desc">Approve department manpower requirements.</span>
            </a>

            <a class="menu-item" href="new_hiring_form_dashboard_department.php">
              <span class="menu-icon icon-history"><i class="fa-solid fa-chart-line"></i></span>
              <span class="menu-label">Department History</span>
              <span class="menu-desc">See department hiring request history.</span>
            </a>
          <?php } ?>

          <?php if ($be_role2 == 'ceo' or $be_depart == 'it' or $be_depart == 'super') { ?>
            <!-- CEO -->
            <div class="section-title">CEO</div>

            <a class="menu-item" href="new_hiring_form_ceo_list.php">
              <span class="menu-icon icon-approval"><i class="fa-solid fa-stamp"></i></span>
              <span class="menu-label">CEO Approval</span>
              <span class="menu-desc">Review executive hiring approvals here.</span>
            </a>

            <a class="menu-item" href="new_hiring_form_dashboard.php">
              <span class="menu-icon icon-dashboard"><i class="fa-solid fa-gauge-high"></i></span>
              <span class="menu-label">Dashboard</span>
              <span class="menu-desc">Track hiring progress and decisions.</span>
            </a>
          <?php } ?>

          <?php if ($be_depart == 'hr' or $be_depart == 'it' or $be_depart == 'super') { ?>
            <!-- HR -->
            <div class="section-title">HR</div>

            <a class="menu-item" href="new_hiring_form_hr_list.php">
              <span class="menu-icon icon-approval"><i class="fa-solid fa-user-check"></i></span>
              <span class="menu-label">HR Approval</span>
              <span class="menu-desc">Handle HR review and recruitment flow.</span>
            </a>

            <a class="menu-item" href="new_hiring_form_dashboard.php">
              <span class="menu-icon icon-dashboard"><i class="fa-solid fa-gauge-high"></i></span>
              <span class="menu-label">Dashboard</span>
              <span class="menu-desc">View hiring pipeline and status.</span>
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
