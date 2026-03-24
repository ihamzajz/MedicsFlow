<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php'); // Redirect to the login page
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Digital Form</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
    <?php
    include 'cdncss.php'
    ?>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .btn {
            border-radius: 0px;
            font-size: 11px;
        }

        .btn-submit {
            font-size: 14.4px !important;
            color: white;
            background-color: #0D9276;
            padding: 5px 35px;
            border-radius: 2px;
            border: 2px solid #0D9276;
            letter-spacing: 1.35px;
            font-weight: 500;
        }

        .btn-menu {
            font-size: 11px;
        }

        th {}

        p {
            margin: 0;
            margin-bottom: 2px;
            font-size: 12px !important;
            color: black;
        }

        input[type="text"] {
            font-size: 14px;
        }

        ::placeholder {
            color: black;
        }

        textarea {
            font-size: 14px;
        }

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
    </style>

    <?php
    include 'sidebarcss.php'
    ?>
    <style>
        table {
            width: 100%;
            border: none;
        }

        th,
        td {
            border: none;
            padding: 8px;
            text-align: left;
        }

        input {
            width: 100%;
            box-sizing: border-box;
        }

        th {
            font-size: 12.5px;
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
                <div class="row justify-content-center">
                    <div class="col-md-6">

                        
                        <form method="POST" action="?id=<?php echo $_GET['id']; ?>" style="border:1px solid black; background-color:white;padding:15px 20px">
                            <table class="table">




                                        <div class="position-relative pb-5 text-center">
                                <!-- Home button (left) -->
                                <a class="btn btn-dark btn-sm position-absolute start-0 top-50 translate-middle-y"
                                    href="new_user_home.php">
                                    <i class="fa-solid fa-home"></i> Home
                                </a>

                                <!-- Center heading -->
                                <h6 class="m-0 position-absolute top-50 start-50 translate-middle"
                                    style="font-size:18px!important; font-weight:600!important;">
                                    Add User Info
                                </h6>
                            </div>
                                <tbody>
                                    <tr>
                                        <th>User Login Id</th>
                                        <td><input type="text" name="login_id" required></td>
                                    </tr>
                                    <tr>
                                        <th>Password</th>
                                        <td><input type="password" name="password" required></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><input type="email" name="email_add" required></td>
                                    </tr>
                                    <tr>
                                        <th>Computer Modal</th>
                                        <td><input type="text" name="c_modal" required></td>
                                    </tr>
                                    <tr>
                                        <th>Machine name</th>
                                        <td><input type="text" name="machine_name" required></td>
                                    </tr>
                                    <tr>
                                        <th>Condition</th>
                                        <td><input type="text" name="condition" required></td>
                                    </tr>
                                    <tr>
                                        <th>Serial No.</th>
                                        <td><input type="text" name="sr_no" required></td>
                                    </tr>
                                    <tr>
                                        <th>Fixed Asset No.</th>
                                        <td><input type="text" name="fa_no" required></td>
                                    </tr>
                                    <tr>

                                    </tr>
                                    <tr>
                                        <td colspan="2">

                                            <div class="text-center mt-3">
                                                <button class="btn btn-secondary" name="submit"
                                                    style="font-size: 17px; height: 36px; width: 150px;">
                                                    <span class="text">Update</span>
                                                </button>
                                            </div>

                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </form>

                        <?php
                        if (isset($_POST['submit'])) {
                            include 'dbconfig.php';

                            if (isset($_GET['id']) && !empty($_GET['id'])) {
                                $id = $_GET['id'];
                                date_default_timezone_set("Asia/Karachi");

                                $login_id = $_POST['login_id'];
                                $password = $_POST['password'];
                                $email_add = $_POST['email_add'];
                                $c_modal = $_POST['c_modal'];
                                $machine_name = $_POST['machine_name'];
                                $condition = $_POST['condition'];
                                $sr_no = $_POST['sr_no'];
                                $fa_no = $_POST['fa_no'];

                                // Use prepared statements to prevent SQL injection
                                $stmt = $conn->prepare("UPDATE newuserform SET 
                            login_id = ?, 
                            password = ?, 
                            email_add = ?, 
                            c_modal = ?, 
                            machine_name = ?, 
                            conditionnn = ?, 
                            sr_no = ?, 
                            fa_no = ? 
                            WHERE id = ?");
                                $stmt->bind_param("ssssssssi", $login_id, $password, $email_add, $c_modal, $machine_name, $condition, $sr_no, $fa_no, $id);

                                if ($stmt->execute()) {
                                    echo "<script type='text/javascript'>
                                    alert('Information added successfully!');
                                    window.location.href='?id=$id';
                                  </script>";
                                } else {
                                    echo "<script type='text/javascript'>
                                    alert('Submission failed!');
                                    window.location.href='?id=$id';
                                  </script>";
                                }

                                $stmt->close();
                            }
                        }
                        ?>

                    </div>
                </div>
            </div>
            <
                <?php
                include 'footer.php'
                ?>