<?php include "header.php"; ?>

<style>
  /* ===== Page background ===== */
  body {
    background-color: #f2f3f5;
  }

  /* ===== Header (dark → light blue gradient) ===== */
  .wt-header {
    border-radius: 18px;
    padding: 22px 24px;
    background: linear-gradient(135deg,
        #0f172a,
        #1e3a8a,
        #3b82f6);
    border: 1px solid rgba(255, 255, 255, .15);
    box-shadow: 0 18px 40px rgba(15, 23, 42, .45);
    margin-bottom: 22px;
  }

  .wt-header h5 {
    font-weight: 900;
    margin-bottom: 4px;
    color: #ffffff;
  }

  .wt-header small {
    color: #dbeafe;
  }

  .wt-header-icon {
    font-size: 40px;
    color: #bfdbfe;
    opacity: .95;
  }

  /* ===== Cards ===== */
  .wt-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 18px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 14px 32px rgba(0, 0, 0, .12);
    transition: all .22s ease;
    height: 100%;
  }

  .wt-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 26px 55px rgba(0, 0, 0, .20);
  }

  /* Icon circle */
  .wt-icon {
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
  .bg-green {
    background: #22c55e;
  }

  .bg-blue {
    background: #3b82f6;
  }

  .bg-orange {
    background: #f59e0b;
  }

  .bg-purple {
    background: #8b5cf6;
  }

  .bg-rose {
    background: #f43f5e;
  }

  .bg-slate {
    background: #0f172a;
  }
.bg-teal {
  background: #14b8a6; /* teal / mint shade */
}

  /* Text */
  .wt-title {
    font-weight: 700;
    margin-bottom: 4px;
  }

  .wt-desc {
    font-size: 13px;
    color: #64748b;
    line-height: 1.45;
  }

  /* Links */
  .wt-link {
    text-decoration: none;
    color: inherit;
  }
</style>

<div class="container py-4">

  <!-- ===== Header ===== -->
  <div class="wt-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h5 class="fw-bold">Gatepass In & Out Workflow</h5>
        <small>Select a module to manage records, dashboards and updates</small>
      </div>
      <div class="wt-header-icon">
        <i class="fa-solid fa-layer-group"></i>
      </div>
    </div>
  </div>

  <!-- ===== Cards (6 projects) ===== -->
  <div class="row g-3">

    <!-- Water Tanker -->
    <div class="col-lg-3 col-md-4 col-sm-6">
      <a href="water_tanker_home.php" class="wt-link">
        <div class="wt-card text-center">
          <div class="wt-icon bg-blue mx-auto">
            <i class="fa-solid fa-truck-droplet"></i>
          </div>
          <h6 class="wt-title">Water Tanker</h6>
          <div class="wt-desc">
            Add entries, view dashboard and update tanker records.
          </div>
        </div>
      </a>
    </div>

    <!-- Milk -->
    <div class="col-lg-3 col-md-4 col-sm-6">
      <a href="milk_home.php" class="wt-link">
        <div class="wt-card text-center">
          <div class="wt-icon bg-green mx-auto">
            <i class="fa-solid fa-bottle-water"></i>
          </div>
          <h6 class="wt-title">Milk</h6>
          <div class="wt-desc">
            Track milk receiving, consumption and supplier records.
          </div>
        </div>
      </a>
    </div>

    <!-- Gatepass -->
    <div class="col-lg-3 col-md-4 col-sm-6">
      <a href="gatepass_home.php" class="wt-link">
        <div class="wt-card text-center">
          <div class="wt-icon bg-orange mx-auto">
            <i class="fa-solid fa-id-card-clip"></i>
          </div>
          <h6 class="wt-title">Gatepass</h6>
          <div class="wt-desc">
            Create gate passes and track in-out movement records.
          </div>
        </div>
      </a>
    </div>

    <!-- Transport -->
    <div class="col-lg-3 col-md-4 col-sm-6">
      <a href="transport_home.php" class="wt-link">
        <div class="wt-card text-center">
          <div class="wt-icon bg-purple mx-auto">
            <i class="fa-solid fa-truck-fast"></i>
          </div>
          <h6 class="wt-title">Transport</h6>
          <div class="wt-desc">
            Vehicle schedules, trips, fuel usage and transport summaries.
          </div>
        </div>
      </a>
    </div>

    <!-- Laundary -->
    <div class="col-lg-3 col-md-4 col-sm-6">
      <a href="laundary_home.php" class="wt-link">
        <div class="wt-card text-center">
          <div class="wt-icon bg-rose mx-auto">
            <i class="fa-solid fa-soap"></i>
          </div>
          <h6 class="wt-title">Laundary</h6>
          <div class="wt-desc">
            Track laundry loads, items and delivery status.
          </div>
        </div>
      </a>
    </div>

    <!-- Freedown -->
    <div class="col-lg-3 col-md-4 col-sm-6">
      <a href="freedom_home.php" class="wt-link">
        <div class="wt-card text-center">
          <div class="wt-icon bg-slate mx-auto">
            <i class="fa-solid fa-shield-halved"></i>
          </div>
          <h6 class="wt-title">Freedom</h6>
          <div class="wt-desc">
            Maintain freedom logs, records and quick summaries.
          </div>
        </div>
      </a>
    </div>

    <!-- Lunch -->
 <!-- Lunch -->
<div class="col-lg-3 col-md-4 col-sm-6">
  <a href="lunch_home.php" class="wt-link">
    <div class="wt-card text-center">
      <div class="wt-icon bg-teal mx-auto">
        <i class="fa-solid fa-utensils"></i>
      </div>
      <h6 class="wt-title">Lunch</h6>
      <div class="wt-desc">
        Manage lunch entries, attendance and daily meal records.
      </div>
    </div>
  </a>
</div>



  </div>
</div>

<?php include "footer.php"; ?>