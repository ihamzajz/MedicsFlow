<?php
session_start();


if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php'); // Redirect to the login page
    exit;
}

$head_email = $_SESSION['head_email'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Asset Receipt Form</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        p {
            font-size: 12.5px !important;
            padding: 0px !important;
            margin: 0px !important;
            font-weight: 500;
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

        .btn-submit {
            font-size: 15px !important;
            color: white;
            background-color: #0D9276;
            padding: 5px 35px;
            border-radius: 2px;
            border: 2px solid #0D9276;
            letter-spacing: 1px;
            font-weight: 500;
            transition: all 0.3s ease;
            /* Smooth transition effect */
        }

        .btn-submit:hover {
            color: #0D9276;
            background-color: white;
            border: 2px solid #0D9276;
        }



        .cbox {
            height: 13px !important;
            width: 13px !important;
        }

        table th {
            font-size: 12.5px !important;
            border: none !important;
            background-color: #1B7BBC !important;
            color: white !important;
            padding: 6px 5px !important;
        }

        table td {
            font-size: 12px;
            color: black;
            padding: 0px !important;
            /* Adjust padding as needed */
            /* border: 1px solid #ddd; */
        }

        input,
        select,
        option {
            width: 100% !important;
            font-size: 12px !important;
            border-radius: 0px !important;
            border: 0.5px solid black !important;
            transition: border-color 0.3s ease;
            padding: 2.5px 5px !important;
            letter-spacing: 0.4px !important;
            height: auto !important;
            min-height: 25px !important;
            /* adjust based on your design */
            background-color: white;
            /* color:#2c2c2c!important; */
        }

        input:focus {
            outline: none;
            border: 0.5px solid black !important;
            background-color: #FFF4B5;
        }

        .labelp {
            padding: 0px !important;
            margin: 0px !important;
            font-size: 12.5px !important;
            font-weight: 600 !important;
            padding-bottom: 5px !important;
            ;
        }



        .slide {
            position: relative;
            overflow: hidden;
            background-color: #7868E6;
            /* initial purple */
            border: 2px solid #4B2C91;
            /* dark purple border */
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
            /* text color matches border on hover */
        }
    </style>
    <?php
    include 'sidebarcss.php'
    ?>

    <style>
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

        .btn-submit:hover {
            font-size: 14.4px !important;
            color: white;
            background-color: #0D9276;
            padding: 5px 35px;
            border-radius: 2px;
            border: 2px solid #0D9276;
            letter-spacing: 1.35px;
            font-weight: 500;
        }
    </style>
</head>

<body background-color="white">
    <div class="wrapper">
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
            <section>
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col">
                            <form class="form pb-2" method="POST">
                                <div class="container">




                                    <div class="row justify-content-center">
                                        <div class="col-xl-10 p-5 mt-2" style="background-color:White;border:1px solid black">
                                            <div class="position-relative pb-5 text-center">
                                                <!-- Home button (left) -->
                                                <a class="btn-home position-absolute start-0 top-50 translate-middle-y"
                                                    href="assets_management_home.php">
                                                    <i class="fa-solid fa-home"></i> Home
                                                </a>

                                                <!-- Center heading -->
                                                <h5 class="m-0 position-absolute top-50 start-50 translate-middle"
                                                    style="font-size:18px!important; font-weight:600!important;">
                                                    Asset Receipt Form
                                                </h5>
                                            </div>



                                            <div class="row pb-2 pt-4">
                                                <div class="col-md-4">
                                                    <p>Purchase Date</p>
                                                    <input type="date" name="ar_date" class="w-100">
                                                </div>
                                                <div class="col-md-4">
                                                    <p>Invoice Number</p>
                                                    <input type="text" name="ar_invoice_number" class="w-100">
                                                </div>
                                            </div>

                                            <div class="row pb-2 ">
                                                <div class="col-md-4">
                                                    <p>Asset Location</p>
                                                    <input type="text" name="asset_location" class="w-100">
                                                </div>
                                                <div class="col-md-4">
                                                    <p>Supplier Name</p>
                                                    <input type="text" name="supplier_name" class="w-100">
                                                </div>
                                            </div>

                                            <p class="py-3"><b>Following Assets Received</b></p>

                                            <div class="row pb-2">
                                                <div class="col-md-4">
                                                    <p>Asset Tag Number</p>
                                                    <input type="text" name="asset_tag_number" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <p>Quantity</p>
                                                    <input type="number" name="qty">
                                                </div>
                                                <div class="col-md-4">
                                                    <p>Serial Number</p>
                                                    <input type="text" name="s_no">
                                                </div>
                                            </div>

                                            <div class="row pb-2">
                                                <div class="col">
                                                    <p>Asset Name</p>
                                                    <input type="text" autocomplete="off" name="desc" class="w-100">
                                                </div>
                                            </div>

                                            <div class="row pb-2">
                                                <div class="col-md-4">
                                                    <p>Model</p>
                                                    <input type="text" autocomplete="off" name="model">
                                                </div>
                                                <div class="col-md-4">
                                                    <p>Capacity/Usage</p>
                                                    <input type="text" autocomplete="off" name="usage">
                                                </div>
                                                <div class="col-md-4">
                                                    <p>Cost</p>
                                                    <input type="number" autocomplete="off" name="cost">
                                                </div>
                                            </div>

                                            <div class="row pb-2">
                                                <div class="col-md-4">
                                                    <p>Department Location</p>
                                                    <input type="text" autocomplete="off" name="department_location">
                                                </div>
                                                <div class="col-md-4">
                                                    <p>Owner Code</p>
                                                    <input type="text" autocomplete="off" name="owner_code">
                                                </div>
                                                <div class="col-md-4">
                                                    <p>Status</p>
                                                    <select name="final_status" class="form-select" required>
                                                        <option value="" disabled selected hidden>Please select</option>
                                                        <option value="Active">Active</option>
                                                        <option value="Available">Available</option>
                                                        <option value="Disposed">Disposed</option>
                                                        <option value="Damaged">Damaged</option>
                                                        <option value="Under Maintenance">Under Maintenance</option>
                                                        <option value="Pending Approval">Pending Approval</option>
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="row pb-2">
                                                <div class="col-12 pb-2">
                                                    <p>Comments</p>
                                                    <input type="text" autocomplete="off" name="comments" class="w-100">
                                                </div>
                                            </div>

                                            <div class="row pb-2">
                                                <div class="col-12">
                                                    <p class="pb-1">Po Approved By Finance</p>
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th style="background-color:#697565;color:white;font-size:11px">Yes</th>
                                                                <th style="background-color:#697565;color:white;font-size:11px">No</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <input type="checkbox" class="add-remove-checkbox" name="po_approve_status" value="Yes" <?= isset($_POST['po_approve_status']) && $_POST['po_approve_status'] == 'Yes' ? 'checked' : '' ?>>
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" class="add-remove-checkbox" name="po_approve_status" value="No" <?= isset($_POST['po_approve_status']) && $_POST['po_approve_status'] == 'No' ? 'checked' : '' ?>>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="text-center mt-3">
                                                <button class="slide" name="submit"
                                                    style="font-size: 17px; height: 36px; width: 150px;">
                                                    <span class="text">Submit</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                       <?php
include 'dbconfig.php';

if (isset($_POST['submit'])) {
    date_default_timezone_set("Asia/Karachi");

    // Session data
    $id = $_SESSION['id'];
    $name = $_SESSION['fullname'];
    $email = $_SESSION['email'];
    $username = $_SESSION['username'];
    $department = $_SESSION['department'];
    $date = date('Y-m-d');
    $head_email = $_SESSION['head_email'];
    $update_date = date('Y-m-d');
    $be_depart = $_SESSION['be_depart'];
    $be_role = $_SESSION['be_role'];

    // Form inputs
    $ar_date = $_POST['ar_date'];
    $ar_invoice_number = $_POST['ar_invoice_number'];
    $asset_location = $_POST['asset_location'];
    $supplier_name = $_POST['supplier_name'];
    $asset_tag_number = $_POST['asset_tag_number'];
    $qty = $_POST['qty'];
    $s_no = $_POST['s_no'];
    $desc = $_POST['desc'];
    $cost = $_POST['cost'];
    $model = $_POST['model'];
    $usage = $_POST['usage'];
    $department_location = $_POST['department_location'];
    $owner_code = $_POST['owner_code'];
    $comment = $_POST['comments'];
    $po_approve_status = $_POST['po_approve_status'];
    $final_status = $_POST['final_status'];

    // ✅ Check if asset tag number already exists
    $check_query = "SELECT id FROM assets WHERE asset_tag_number = '$asset_tag_number'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>
            alert('Asset tag number already exists! Please enter a unique asset tag number.');
            window.location.href = window.location.href;
        </script>";
    } else {
        // ✅ Normal INSERT query (no bind_param)
        $insert = "INSERT INTO assets (
            purchase_date, supplier_name, invoice_number, asset_location, department_location,
            asset_tag_number, quantity, s_no, name_description, cost, `usage`, model, owner_code,
            comments, user_name, user_date, user_department, user_role, finance_status, po_approve_status,
            status, grn_status, po_no_status, po_date_status, update_date, fullname, final_status, department_be
        ) VALUES (
            '$ar_date', '$supplier_name', '$ar_invoice_number', '$asset_location', '$department_location',
            '$asset_tag_number', '$qty', '$s_no', '$desc', '$cost', '$usage', '$model', '$owner_code',
            '$comment', '$username', '$date', '$department', '$be_role', 'Pending', '$po_approve_status',
            'Pending', 'Pending', 'Pending', 'Pending', '$update_date', '$name', '$final_status', '$be_depart'
        )";

        if (mysqli_query($conn, $insert)) {
            echo "<script>
                alert('Form has been submitted successfully!');
                window.location.href = 'asset_receipt_form.php';
            </script>";
        } else {
            echo "<script>
                alert('Form submission failed: " . addslashes(mysqli_error($conn)) . "');
            </script>";
        }
    }
}
?>




                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            // Ensure the sidebar is active (visible) by default
            $('#sidebar').addClass('active'); // Change to addClass to show sidebar initially

            // Handle sidebar collapse toggle
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });

            // Update the icon when collapsing/expanding
            $('[data-bs-toggle="collapse"]').on('click', function() {
                var target = $(this).find('.toggle-icon');
                if ($(this).attr('aria-expanded') === 'true') {
                    target.removeClass('fa-plus').addClass('fa-minus');
                } else {
                    target.removeClass('fa-minus').addClass('fa-plus');
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.add-remove-checkbox');

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const groupName = this.name.split('_')[0]; // Extract the group name

                    // Uncheck other checkboxes in the same group
                    checkboxes.forEach(function(cb) {
                        if (cb !== checkbox && cb.name.startsWith(groupName)) {
                            cb.checked = false;
                        }
                    });
                });
            });
        });
    </script>

    <script src="assets/js/main.js"></script>
</body>

</html>