<?php
session_start();
include("dbconfig.php");

// Handle login before any HTML is output
if (isset($_POST['login_btn'])) {
    $a = trim($_POST['login_username']);
    $b = $_POST['login_pwd'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    if (!$stmt) {
        error_log("Login prepare failed: " . $conn->error);
        header("Location: login.php?db_err=1");
        exit;
    }

    $stmt->bind_param("ss", $a, $b);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $_SESSION['loggedin'] = true;

        $_SESSION['id'] = $user['id'] ?? '';
        $_SESSION['fullname'] = $user['fullname'] ?? '';
        $_SESSION['username'] = $user['username'] ?? '';
        $_SESSION['password'] = $user['password'] ?? '';
        $_SESSION['email'] = $user['email'] ?? '';
        $_SESSION['gender'] = $user['gender'] ?? '';
        $_SESSION['department'] = $user['department'] ?? '';
        $_SESSION['role'] = $user['role'] ?? '';
        $_SESSION['added_date'] = $user['added_date'] ?? '';
        $_SESSION['head_email'] = $user['head_email'] ?? '';
        $_SESSION['be_depart'] = $user['be_depart'] ?? '';
        $_SESSION['be_role'] = $user['be_role'] ?? '';
        $_SESSION['be_role2'] = $user['be_role2'] ?? '';
        $_SESSION['zone'] = $user['zone'] ?? '';
        $_SESSION['emp_id'] = $user['emp_id'] ?? '';
        $_SESSION['sub_dept'] = $user['sub_dept'] ?? '';
        $_SESSION['sa_user'] = $user['sa_user'] ?? '';
        $_SESSION['sa_depart'] = $user['sa_depart'] ?? '';
        $_SESSION['sa_depart2'] = $user['sa_depart2'] ?? '';
        $_SESSION['sa_depart3'] = $user['sa_depart3'] ?? '';
        $_SESSION['sa_role'] = $user['sa_role'] ?? '';
        $_SESSION['be_depart_nh'] = $user['be_depart_nh'] ?? '';
        $_SESSION['asset_user'] = $user['asset_user'] ?? '';
        $_SESSION['it_dashboard'] = $user['it_dashboard'] ?? 'No';
        $_SESSION['sc_dashboard'] = $user['sc_dashboard'] ?? 'No';
        $_SESSION['sales_dashboard'] = $user['sales_dashboard'] ?? 'No';
        $_SESSION['finance_dashboard'] = $user['finance_dashboard'] ?? 'No';
        $_SESSION['expense_finance'] = $user['expense_finance'] ?? 'No';

        header("Location: profile.php");
        exit;
    } else {
        header("Location: login.php?errr=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />

  <?php include 'cdncss.php' ?>

  <style>
    a {
      text-decoration: none !important
    }

    body {
      font-family: 'Poppins', sans-serif;
    }

    .section-4 {
      background-image: url('assets/images/banner.png');
      height: 100vh;
      background-size: cover;
    }

    .slide {
      position: relative;
      overflow: hidden;
      background-color: #14C38E;
      border: 2px solid black;
      color: white;
      font-weight: 600;
      border-radius: 4px;
      cursor: pointer;
      padding: 0 35px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .text {
      position: relative;
      z-index: 2;
      transition: color 0.4s ease;
    }

    .slide::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 130%;
      height: 100%;
      background-color: white;
      transform: translateX(-110%) skew(-30deg);
      transition: transform 0.5s ease;
      z-index: 1;
    }

    .slide:hover::before {
      transform: translateX(-5%) skew(-15deg);
    }

    .slide:hover .text {
      color: #4B2C91;
    }

    input {
      border: 0.5px solid grey !important;
    }
  </style>
</head>

<body>

  <div class="section-4">
    <div class="container-fluid">
      <div class="row min-vh-100 d-flex justify-content-md-end justify-content-center align-items-center">
        <div class="col-12 col-md-4 d-flex flex-column justify-content-center align-items-center">
          <form class="form pb-2 w-100 bg-light-subtle" method="POST"
            style="max-width: 300px; border: 1.5px solid black; padding: 25px; padding-bottom: 0px; border-radius: 5px;">

            <h2 class="text-center" style="color:#14C38E!important;font-weight:bolder!important">MedicsFlow</h2>

            <div class="mb-1 form-group">
              <label class="form-label labelf">Username:</label>
              <input type="text" class="form-control" name="login_username" required autocomplete="off">
            </div>

            <div class="mb-1 form-group">
              <label class="form-label labelf">Password:</label>
              <input type="password" class="form-control" name="login_pwd" required autocomplete="off">
            </div>

            <div class="text-center mt-3 mb-3">
              <button class="slide" name="login_btn" style="font-size: 20px; height: 36px; width: 150px;">
                <span class="text">Login</span>
              </button>
            </div>

            <?php if (isset($_GET["errr"])): ?>
              <p style="color:red; text-align: center;">Invalid username or Password</p>
            <?php endif; ?>

            <?php if (isset($_GET["db_err"])): ?>
              <p style="color:red; text-align: center;">Login is temporarily unavailable. Please try again.</p>
            <?php endif; ?>

          </form>
        </div>
      </div>
    </div>
  </div>

  <?php include 'footer.php' ?>
</body>
</html>
