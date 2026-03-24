<?php include "header.php"; ?>

<style>
/* ===== Page background ===== */
body{
  background-color: #f2f3f5;
}

/* ===== Header (dark → light blue gradient) ===== */
.wt-header{
  border-radius: 18px;
  padding: 22px 24px;
  background: linear-gradient(
    135deg,
    #0f172a,   /* dark blue */
    #1e3a8a,   /* deep blue */
    #3b82f6    /* light blue */
  );
  border: 1px solid rgba(255,255,255,.15);
  box-shadow: 0 18px 40px rgba(15,23,42,.45);
  margin-bottom: 22px;
}
.wt-header h5{
  font-weight: 900;
  margin-bottom: 4px;
  color: #ffffff;
}
.wt-header small{
  color: #dbeafe;
}
.wt-header-icon{
  font-size: 40px;
  color: #bfdbfe;
  opacity: .95;
}

/* ===== Cards ===== */
.wt-card{
  background: #ffffff;
  border-radius: 16px;
  padding: 18px;
  border: 1px solid #e5e7eb;
  box-shadow: 0 14px 32px rgba(0,0,0,.12);
  transition: all .22s ease;
  height: 100%;
}
.wt-card:hover{
  transform: translateY(-6px);
  box-shadow: 0 26px 55px rgba(0,0,0,.20);
}

/* Icon circle */
.wt-icon{
  width: 48px;
  height: 48px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  color: #ffffff;
  margin-bottom: 10px;
}

/* Icon colors */
.bg-green{ background: #22c55e; }
.bg-blue{ background: #3b82f6; }
.bg-orange{ background: #f59e0b; }

/* Text */
.wt-title{
  font-weight: 700;
  margin-bottom: 4px;
}
.wt-desc{
  font-size: 13px;
  color: #64748b;
  line-height: 1.45;
}

/* Links */
.wt-link{
  text-decoration: none;
  color: inherit;
}
</style>

<div class="container py-4">

  <!-- ===== Header ===== -->
  <div class="wt-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h5 class="fw-bold">Milk</h5>
        <small>Manage milk records, dashboard and updates</small>
      </div>
      <div class="wt-header-icon">
        <i class="fa-solid fa-cow"></i>
      </div>
    </div>
  </div>

  <!-- ===== Cards (4 in a row) ===== -->
  <div class="row g-3">

    <!-- Create Record -->
    <div class="col-lg-3 col-md-4 col-sm-6">
      <a href="milk_form.php" class="wt-link">
        <div class="wt-card text-center">
          <div class="wt-icon bg-green mx-auto">
            <i class="fa-solid fa-plus"></i>
          </div>
          <h6 class="wt-title">Create Record</h6>
          <div class="wt-desc">
            Add new milk entry with morning/evening qty and date.
          </div>
        </div>
      </a>
    </div>

    <!-- Dashboard -->
    <div class="col-lg-3 col-md-4 col-sm-6">
      <a href="milk_dashboard.php" class="wt-link">
        <div class="wt-card text-center">
          <div class="wt-icon bg-blue mx-auto">
            <i class="fa-solid fa-chart-line"></i>
          </div>
          <h6 class="wt-title">Dashboard</h6>
          <div class="wt-desc">
            View usage summary, monthly totals and milk statistics.
          </div>
        </div>
      </a>
    </div>

    <!-- Edit Records -->
    <div class="col-lg-3 col-md-4 col-sm-6">
      <a href="milk_record_list.php" class="wt-link">
        <div class="wt-card text-center">
          <div class="wt-icon bg-orange mx-auto">
            <i class="fa-solid fa-pen-to-square"></i>
          </div>
          <h6 class="wt-title">Edit Records</h6>
          <div class="wt-desc">
            update existing milk records safely.
          </div>
        </div>
      </a>
    </div>

  </div>
</div>

<?php include "footer.php"; ?>
