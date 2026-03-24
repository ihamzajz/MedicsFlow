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

/* ===== Inner box ===== */
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
  border-top:1px solid #eef1f4;
  letter-spacing:.3px;
  text-transform:uppercase;
  background:#dee2e6;
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

/* Color variants */
.icon-green { color:#198754; background:rgba(25,135,84,0.12); }
.icon-blue  { color:#0d6efd; background:rgba(13,110,253,0.12); }
.icon-amber { color:#f59f00; background:rgba(245,159,0,0.14); }
</style>

<div class="container">
  <div class="row">
    <div class="col-md-5">

      <div class="home-shell mb-3">
        <div class="home-heading">Change Control Workflow</div>

        <div class="inner-card">

          <!-- Forms -->
          <div class="section-title first">Forms</div>

          <a class="menu-item" href="cc_form.php">
            <span class="menu-icon icon-green"><i class="fa-solid fa-plus"></i></span>
            <span>Submit Form</span>
          </a>

          <a class="menu-item" href="cc_user_forms.php">
            <span class="menu-icon icon-blue"><i class="fa-solid fa-clock-rotate-left"></i></span>
            <span>Record History</span>
          </a>

          <!-- Approval -->
          <?php if ($be_role == 'approver' || $be_depart == 'it' || $be_role == 'ceo' || $be_depart == 'super') { ?>
            <div class="section-title">Approval</div>

            <?php if ($be_role == 'approver' || $be_depart == 'it' || $be_depart == 'super') { ?>
              <a class="menu-item" href="cc_depthead_list.php">
                <span class="menu-icon icon-amber"><i class="fa-solid fa-user-check"></i></span>
                <span>Dept. Head Approval</span>
              </a>
            <?php } ?>

            <?php if ($be_depart == 'it' || ($be_role == 'approver' && $be_depart == 'qaqc') || $be_depart == 'super') { ?>
              <a class="menu-item" href="cc_qchead_list.php">
                <span class="menu-icon icon-amber"><i class="fa-solid fa-flask"></i></span>
                <span>Quality Head Approval</span>
              </a>
            <?php } ?>

            <?php if ($be_depart == 'it' || $be_role == 'ceo' || $be_depart == 'super') { ?>
              <a class="menu-item" href="cc_ceo_list.php">
                <span class="menu-icon icon-amber"><i class="fa-solid fa-stamp"></i></span>
                <span>CEO Approval</span>
              </a>
            <?php } ?>
          <?php } ?>

          <!-- Data Input -->
          <div class="section-title">Data Input</div>

          <a class="menu-item" href="cc_dept_input_list.php">
            <span class="menu-icon icon-blue"><i class="fa-solid fa-keyboard"></i></span>
            <span>Dept. Input</span>
          </a>

          <?php if ($fname == 'Ehtesham Ul Haq' || $be_depart == 'sc' || $be_depart == 'it' || ($be_role == 'approver' && $be_depart == 'qaqc') || $be_depart == 'super') { ?>
            <a class="menu-item" href="cc_add_stock_list.php">
              <span class="menu-icon icon-blue"><i class="fa-solid fa-boxes-stacked"></i></span>
              <span>Add Stock</span>
            </a>
          <?php } ?>

          <a class="menu-item" href="cc_add_action_plan_list.php">
            <span class="menu-icon icon-blue"><i class="fa-solid fa-list-check"></i></span>
            <span>Action Plan</span>
          </a>

          <!-- QA -->
          <?php if (($be_role == 'approver' && $be_depart == 'qaqc') || $be_depart == 'it' || $be_depart == 'super') { ?>
            <div class="section-title">QA Department</div>

            <a class="menu-item" href="cc_edit_list.php">
              <span class="menu-icon icon-amber"><i class="fa-solid fa-pen-to-square"></i></span>
              <span>Edit</span>
            </a>
          <?php } ?>

          <!-- Dashboard -->
          <div class="section-title">Dashboard</div>

          <a class="menu-item" href="cc_dashboard.php">
            <span class="menu-icon icon-blue"><i class="fa-solid fa-gauge-high"></i></span>
            <span>Dashboard</span>
          </a>

        </div><!-- /inner-card -->
      </div><!-- /home-shell -->

    </div>
  </div>
</div>

<?php
include 'footer.php';
?>
