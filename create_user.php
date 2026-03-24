<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

include 'dbconfig.php';

// Handle form submission
if (isset($_POST['submit'])) {
    $fullname   = trim($_POST['fullname']);
    $username   = trim($_POST['username']);
    $email      = trim($_POST['email']);
    $department = trim($_POST['department']);
    $role       = trim($_POST['role']);
    $be_depart  = trim($_POST['be_depart']);
    $be_role    = trim($_POST['be_role']);
    $head_name  = trim($_POST['head_name']);
    $head_email = trim($_POST['head_email']);

    $password   = $_POST['password'];
    $confirm    = $_POST['confirm_password'];

    $it_dashboard      = (!empty($_POST['it_dashboard']) && $_POST['it_dashboard'] != "Please Select") ? $_POST['it_dashboard'] : "No";
    $sales_dashboard   = (!empty($_POST['sales_dashboard']) && $_POST['sales_dashboard'] != "Please Select") ? $_POST['sales_dashboard'] : "No";
    $finance_dashboard = (!empty($_POST['finance_dashboard']) && $_POST['finance_dashboard'] != "Please Select") ? $_POST['finance_dashboard'] : "No";
    $sc_dashboard      = (!empty($_POST['sc_dashboard']) && $_POST['sc_dashboard'] != "Please Select") ? $_POST['sc_dashboard'] : "No";


    // Password validation
    if (strlen($password) < 5 || strlen($password) > 10) {
        echo "<script>alert('Password must be between 5 and 10 characters!');</script>";
    } elseif ($password !== $confirm) {
        // echo "<script>alert('Password and Confirm Password do not match!');</script>";
        echo "<script>
    window.addEventListener('DOMContentLoaded', () => {
        var toastEl = document.getElementById('passwordToast');
        var toast = new bootstrap.Toast(toastEl);
        toast.show();
    });
</script>";
    } else {
        // 🔹 Check if username exists
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            // Username exists → Show toast
            echo "<script>
                window.addEventListener('DOMContentLoaded', () => {
                    var toastEl = document.getElementById('usernameToast');
                    var toast = new bootstrap.Toast(toastEl);
                    toast.show();
                });
            </script>";
        } else {
            // Insert query
            $insert = "INSERT INTO users 
                (fullname, username, email, password, department, role, 
                 be_depart, be_role, head_name, head_email, 
                 it_dashboard, sales_dashboard, finance_dashboard, sc_dashboard)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            $stmt = $conn->prepare($insert);
            $stmt->bind_param(
                "ssssssssssssss",
                $fullname,
                $username,
                $email,
                $password,
                $department,
                $role,
                $be_depart,
                $be_role,
                $head_name,
                $head_email,
                $it_dashboard,
                $sales_dashboard,
                $finance_dashboard,
                $sc_dashboard
            );

            if ($stmt->execute()) {
                echo "<script>
        window.addEventListener('DOMContentLoaded', () => {
            var toastEl = document.getElementById('successToast');
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        });
        setTimeout(() => { window.location = 'all_users.php'; }, 2000);
    </script>";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create User</title>
    <?php include 'cdncss.php'; ?>
    <?php include 'sidebarcss.php'; ?>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        p {
            font-size: 13px;
            font-weight: 600;
            margin: 0;
        }

        input,
        select {
            font-size: 12.3px;
            width: 100%;
            height: 27px;
            padding: 5px;
        }

        .btn {
            font-size: 11px;
            border-radius: 0px;
        }
    </style>

    <style>
        .slide {
            position: relative;
            overflow: hidden;
            background-color: #7868E6;
            border: 2px solid #4B2C91;
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
            /* white overlay */
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
    </style>
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <?php include 'sidebar1.php'; ?>
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-success">
                        <i class="fas fa-align-left"></i><span>Menu</span>
                    </button>
                </div>
            </nav>
            <div class="container">
                <div style="background:#fff; border:1px solid black; padding:20px;">
                    <h5 class="text-center fw-bold pb-3"><span style="float:left
            "><a href="admin_panel.php" class="btn btn-primary btn-sm" style="float:left!important">Admin Panel</a></span>Create User</h5>
                    <form method="POST">
                        <div class="row pb-1">
                            <div class="col-md-4">
                                <p>Full Name:</p>
                                <input type="text" name="fullname" required>
                            </div>
                            <div class="col-md-4">
                                <p>Username:</p>
                                <input type="text" name="username" required>
                            </div>
                            <div class="col-md-4">
                                <p>Email:</p>
                                <input type="email" name="email" required>
                            </div>
                        </div>
                        <div class="row pb-1">
                            <div class="col-md-4">
                                <p>Password:</p>
                                <input type="password" name="password" required>
                            </div>
                            <div class="col-md-4">
                                <p>Confirm Password:</p>
                                <input type="password" name="confirm_password" required>
                            </div>
                            <div class="col-md-4">
                                <p>Department:</p>
                                <input type="text" name="department" required>
                            </div>
                        </div>
                        <div class="row pb-1">
                            <div class="col-md-4">
                                <p>Role:</p>
                                <input type="text" name="role" required>
                            </div>
                            <div class="col-md-4">
                                <p>BE Department:</p>
                                <input type="text" name="be_depart" required>
                            </div>
                            <div class="col-md-4">
                                <p>BE Role:</p>
                                <input type="text" name="be_role" required>
                            </div>
                        </div>
                        <div class="row pb-1">
                            <div class="col-md-6">
                                <p>Head Name:</p>
                                <input type="text" name="head_name" required>
                            </div>
                            <div class="col-md-6">
                                <p>Head Email:</p>
                                <input type="email" name="head_email" required>
                            </div>
                        </div>

                        <h6 class="fw-bold mt-5 text-primary">Dashboards Access</h6>
                        <div class="row pb-1">
                            <div class="col-md-3">
                                <p>IT Dashboard:</p>
                                <select name="it_dashboard" required>
                                    <option value="Please Select" selected disabled>Please Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <p>Sales Dashboard:</p>
                                <select name="sales_dashboard" required>
                                    <option value="Please Select" selected disabled>Please Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <p>Finance Dashboard:</p>
                                <select name="finance_dashboard" required>
                                    <option value="Please Select" selected disabled>Please Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <p>SC Dashboard:</p>
                                <select name="sc_dashboard" required>
                                    <option value="Please Select" selected disabled>Please Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <button class="slide" name="submit"
                                style="font-size:17px; height:36px; width:150px;">
                                <span class="text">Create</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast for Username Exists -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <div id="usernameToast" class="toast align-items-center text-white bg-danger border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    ❌ Username already exists! Please choose another.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>


    <!-- Toast for Password Mismatch -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <div id="passwordToast" class="toast align-items-center text-white bg-danger border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    ⚠️ Password and Confirm Password do not match!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>


    <!-- Toast for Success -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    ✅ User created successfully!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

</body>

</html>
<?php include "footer.php"; ?>