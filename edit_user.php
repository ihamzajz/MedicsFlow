
<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php'); 
    exit;
}

include 'dbconfig.php';

// Get user id
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch user data
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User not found!");
}

// Handle form submission
if (isset($_POST['submit'])) {
    $fullname   = !empty($_POST['fullname']) ? $_POST['fullname'] : $user['fullname'];
    $username   = $user['username']; // readonly
    $email      = !empty($_POST['email']) ? $_POST['email'] : $user['email'];
    $department = !empty($_POST['department']) ? $_POST['department'] : $user['department'];
    $role       = !empty($_POST['role']) ? $_POST['role'] : $user['role'];
    $be_depart  = !empty($_POST['be_depart']) ? $_POST['be_depart'] : $user['be_depart'];
    $be_role    = !empty($_POST['be_role']) ? $_POST['be_role'] : $user['be_role'];
    $head_name  = !empty($_POST['head_name']) ? $_POST['head_name'] : $user['head_name'];
    $head_email = !empty($_POST['head_email']) ? $_POST['head_email'] : $user['head_email'];

    // New dashboard fields
    // $it_dashboard      = isset($_POST['it_dashboard']) ? $_POST['it_dashboard'] : $user['it_dashboard'];
    // $sales_dashboard   = isset($_POST['sales_dashboard']) ? $_POST['sales_dashboard'] : $user['sales_dashboard'];
    // $finance_dashboard = isset($_POST['finance_dashboard']) ? $_POST['finance_dashboard'] : $user['finance_dashboard'];
    // $sc_dashboard      = isset($_POST['sc_dashboard']) ? $_POST['sc_dashboard'] : $user['sc_dashboard'];
    // New dashboard fields (ignore "Please Select")
$it_dashboard      = (!empty($_POST['it_dashboard']) && $_POST['it_dashboard'] != "Please Select") ? $_POST['it_dashboard'] : $user['it_dashboard'];
$sales_dashboard   = (!empty($_POST['sales_dashboard']) && $_POST['sales_dashboard'] != "Please Select") ? $_POST['sales_dashboard'] : $user['sales_dashboard'];
$finance_dashboard = (!empty($_POST['finance_dashboard']) && $_POST['finance_dashboard'] != "Please Select") ? $_POST['finance_dashboard'] : $user['finance_dashboard'];
$sc_dashboard      = (!empty($_POST['sc_dashboard']) && $_POST['sc_dashboard'] != "Please Select") ? $_POST['sc_dashboard'] : $user['sc_dashboard'];


    // Password check
    if (!empty($_POST['password'])) {
        $password = $_POST['password'];
        if (strlen($password) < 5 || strlen($password) > 10) {
            echo "<script>alert('Password must be between 5 and 10 characters!');</script>";
            $password = $user['password']; 
        }
    } else {
        $password = $user['password'];
    }

    // Update query
    $update = "UPDATE users 
               SET fullname=?, username=?, email=?, password=?, department=?, role=?, 
                   be_depart=?, be_role=?, head_name=?, head_email=?, 
                   it_dashboard=?, sales_dashboard=?, finance_dashboard=?, sc_dashboard=?
               WHERE id=?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param(
        "ssssssssssssssi",
        $fullname, $username, $email, $password,
        $department, $role, $be_depart, $be_role, $head_name, $head_email,
        $it_dashboard, $sales_dashboard, $finance_dashboard, $sc_dashboard, $id
    );

    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully!'); window.location='all_users.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MedicsFlow</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon1.png" />
        <!-- Bootstrap CSS CDN -->
        <?php
            include 'cdncss.php'
                ?>
        <style>
           .bg-menu {
            background-color: #393E46 !important;
        }

        .btn-menu {
            font-size: 12.5px;
            background-color: #FFB22C !important;
            padding: 5px 10px;
            font-weight: 600;
            border: none !important;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        .btn {
            border-radius: 0px;
            font-size: 11px !important;
        }

        .btn-home {
            background-color: #62CDFF;
            border: 1px solid #62CDFF;
            color: black;
            padding: 5px 10px;
            font-weight: 600;
            border: none !important;
            font-size: 12px;
        }

        .btn-back {
            background-color: #56DFCF;
            color: black;
            padding: 5px 10px;
            font-weight: 600;
            border: 1px solid #56DFCF;
            font-size: 12px;
        }
            p {
            font-size: 13px !important;
            padding: 0px !important;
            margin: 0px !important;
            font-weight: 600;
            }
            input[type="text"],input[type="text"][readonly],textarea,input[type="email"],input[type="password"],placeholder {
            font-size: 12.3px !important;
            width: 100% !important;
            height: 24px !important;
            padding: 5px 5px !important;
            }
            select,option{
            font-size: 12.3px !important;
            width: 100% !important;
            height: 27px !important;
            padding: 5px 5px !important;
            }
 
      
            /* Approve Button  */
            .btn-approve {
            white-space: nowrap !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            background-color: #D1E7DD;
            color: white !important;
            border-radius: 15px !important;
            transition: all 0.3s ease !important;
            padding: 4px 15px !important;
            color: black !important;
            border: 1px solid #198754 !important;
            }
            .btn-approve:hover {
            filter: brightness(85%);
            }
            /* Reject Button */
            .btn-reject {
            white-space: nowrap !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            background-color: #F8D7DA;
            color: white !important;
            border-radius: 15px !important;
            transition: all 0.3s ease !important;
            padding: 4px 15px !important;
            color: black !important;
            border: 1px solid #DC3545 !important;
            }
            .btn-reject:hover {
            filter: brightness(85%);
            }




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
        <?php
            include 'sidebarcss.php'
                ?>
    </head>
    </head>
    <body>
        <?php
            include 'dbconfig.php';
            ?>
        <div class="wrapper d-flex align-items-stretch">
        <?php
            include 'sidebar1.php';
            ?>
        <!-- Page Content  -->
        <div id="content">
        <!-- navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-menu">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn-menu">
                <i class="fas fa-align-left"></i>
                <span>Menu</span>
                </button>
            </div>
        </nav>
        <div class="container">
            <div style="background-color: white!important;border:1px solid black!important; padding:20px!important" class="mt-3">
                <h5 class="text-center fw-bold pb-3">Edit User</h5>
                <form method="POST">
                    <div class="row pb-1">
                        <div class="col-md-4">
                            <p>Full Name:</p>
                            <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>">
                        </div>
                        <div class="col-md-4">
                            <p>Username (readonly):</p>
                            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <p>Email:</p>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                        </div>
                    </div>
                    <div class="row pb-1">
                        <div class="col-md-4">
                            <p>Password:</p>
                            <input type="password" name="password" placeholder="Leave blank to keep old">
                        </div>
                        <div class="col-md-4">
                            <p>Department:</p>
                            <input type="text" name="department" value="<?php echo htmlspecialchars($user['department']); ?>">
                        </div>
                        <div class="col-md-4">
                            <p>Role:</p>
                            <input type="text" name="role" value="<?php echo htmlspecialchars($user['role']); ?>">                     
                        </div>
                    </div>
                    <div class="row pb-1">
                        <div class="col-md-4">
                            <p>BE Department:</p>
                            <input type="text" name="be_depart" value="<?php echo htmlspecialchars($user['be_depart']); ?>">
                        </div>
                        <div class="col-md-4">
                            <p>BE Role:</p>
                            <input type="text" name="be_role" value="<?php echo htmlspecialchars($user['be_role']); ?>">
                        </div>
                        <div class="col-md-4">
                            <p>Head Name:</p>
                            <input type="text" name="head_name" value="<?php echo htmlspecialchars($user['head_name']); ?>">
                        </div>
                    </div>
                    <div class="row pb-1">
                        <div class="col-md-4">
                            <p>Head Email:</p>
                            <input type="email" name="head_email" value="<?php echo htmlspecialchars($user['head_email']); ?>">      
                        </div>
                    </div>


                    <h6 class="fw-bold mt-5 text-primary">Dashboards Access</h6>
<div class="row pb-1">
    <div class="col-md-3">
        <p>IT Dashboard:</p>
        <select name="it_dashboard" class="form-control">
            <option value="Please Select" disabled <?php if(empty($user['it_dashboard'])) echo "selected"; ?>>Please Select</option>
            <option value="Yes" <?php if($user['it_dashboard']=="Yes") echo "selected"; ?>>Yes</option>
            <option value="No" <?php if($user['it_dashboard']=="No") echo "selected"; ?>>No</option>
        </select>
    </div>
    <div class="col-md-3">
        <p>Sales Dashboard:</p>
        <select name="sales_dashboard" class="form-control">
            <option value="Please Select" disabled <?php if(empty($user['sales_dashboard'])) echo "selected"; ?>>Please Select</option>
            <option value="Yes" <?php if($user['sales_dashboard']=="Yes") echo "selected"; ?>>Yes</option>
            <option value="No" <?php if($user['sales_dashboard']=="No") echo "selected"; ?>>No</option>
        </select>
    </div>
    <div class="col-md-3">
        <p>Finance Dashboard:</p>
        <select name="finance_dashboard" class="form-control">
            <option value="Please Select" disabled <?php if(empty($user['finance_dashboard'])) echo "selected"; ?>>Please Select</option>
            <option value="Yes" <?php if($user['finance_dashboard']=="Yes") echo "selected"; ?>>Yes</option>
            <option value="No" <?php if($user['finance_dashboard']=="No") echo "selected"; ?>>No</option>
        </select>
    </div>
    <div class="col-md-3">
        <p>SC Dashboard:</p>
        <select name="sc_dashboard" class="form-control">
            <option value="Please Select" disabled <?php if(empty($user['sc_dashboard'])) echo "selected"; ?>>Please Select</option>
            <option value="Yes" <?php if($user['sc_dashboard']=="Yes") echo "selected"; ?>>Yes</option>
            <option value="No" <?php if($user['sc_dashboard']=="No") echo "selected"; ?>>No</option>
        </select>
    </div>
</div>



                    <div class="text-center mt-5">
                                <button class="slide" name="submit"
                                    style="font-size: 17px; height: 36px; width: 150px;">
                                    <span class="text">Submit</span>
                                </button>
                            </div>
                </form>
            </div>
        </div>
    </body>
</html>
<?php
    include "footer.php";
    ?>