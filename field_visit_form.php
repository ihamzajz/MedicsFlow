<?php 
session_start (); 
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php'); // Redirect to the login page
    exit;
}
$head_email = $_SESSION['head_email'];
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
$mail = new PHPMailer(true);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Field Visit Form</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
    .section-4{
    background-image: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.7)),url('assets/images/banner.png');
    height: 100vh;
    background-size: cover;
    }
    </style>
 <style>
         .wrapper {
         display: flex;
         width: 100%;
         align-items: stretch;
         }
         #sidebar {
         min-width: 250px;
         max-width: 250px;
         background: #263144!important;
         color: #fff;
         transition: all 0.3s;
         }
         #sidebar.active {
         margin-left: -250px;
         }
         #sidebar .sidebar-header {
         padding: 20px;
         background: yellow!important;
         }
         #sidebar ul.components {
         padding: 10px 0;
         }
         #sidebar ul p {
         color: #fff;
         padding: 8px!important;
         }
         #sidebar ul li a {
         padding: 8px!important;
         font-size: 11px !important;
         display: block;
         color: white!important;
         }
         #sidebar ul li a:hover {
         text-decoration: none;
         }
         #sidebar ul li.active>a,
         a[aria-expanded="true"] {
         color: cyan!important;
         background: #1c9be7!important;
         }
         a[data-toggle="collapse"] {
         position: relative;
         }
         .dropdown-toggle::after {
         display: block;
         position: absolute;
         color: #1c9be7!important;
         top: 50%;
         right: 20px;
         transform: translateY(-50%);
         background: transparent!important;
         }
         ul ul a {
         font-size: 11px!important;
         padding-left: 15px !important;
         background: yellow!important;
         color: yellow!important;
         }
         ul.CTAs {
         font-size: 11px !important;
         }
         ul.CTAs a {
         text-align: center;
         font-size: 11px!important;
         display: block;
         margin-bottom: 5px;
         }
         a.download {
         background: #fff;
         color: yellow;
         }
         a.article,
         a.article:hover {
         background: yellow;
         color: yellow!important ;
         }
         #content {
         width: 100%;
         padding: 20px;
         min-height: 100vh;
         transition: all 0.3s;
         }
         @media (max-width: 768px) {
         #sidebar {
            margin-left: -250px;
         }
         #sidebar.active {
            margin-left: 0;
         }
         #sidebarCollapse span {
            display: none;
         }
         }
      </style>
      <style>
        .width{
            width: 100%;
        }
        .pro-width{
            width: 85%;
        }
        .numbering{
            font-size: 15px;
        }
        th{
            font-size: 13px!important;
        }

        .pro_th{
            font-size: 12px!important;
            color: white;
            background-color: #2F89FC!important;
        }
      </style>
</head>
<body>
    <div class="wrapper">
    <?php
            include 'sidebar.php';
        ?>
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </nav>
                <section class="section-4">
        <div class="container">
            <div class="row">
            <div class="col-md-12 ml-auto pt-md-5">
            <form class="form pb-3" method="POST" id="bonusForm" style="border: 2px solid white; padding: 25px; padding-bottom: 0px; border-radius: 5px; background-color: #f2f2f2;">
            <h2 class="text-center pb-3" style="font-size: 25px; color: #2f89fc; font-weight: bolder;">Field Visit Form</h2>
            <table class="table table-bordered table-responsive">
                <tbody id="table-body">
                    <tr>
                        <th>Customer Name</th>
                        <td colspan="6"><input type="text" name="customer_name" placeholder="Enter customer name" class="width" required></td>
                    </tr>
                    <tr>
                        <th>Customer Code</th>
                        <td colspan="6"><input type="text" name="customer_code" placeholder="Enter customer code" class="width"></td>
                    </tr>
                    <tr>
                        <th>Depot</th>
                        <td colspan="6">
                            <select name="depot" id="depot" class="width">
                                <!-- Populate options from database -->
                                <?php
                                $name =  $_SESSION['fullname'];
                                $zone =  $_SESSION['zone'];
                                include 'dbconfig.php';
                                $select = "SELECT * FROM depot where zone = '$zone' AND (asm = '$name' OR zsm = '$name')";
                                $select_q = mysqli_query($conn, $select);
                                if (mysqli_num_rows($select_q) > 0) {
                                    while ($row = mysqli_fetch_assoc($select_q)) {
                                        echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No products found</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td >
                        Joint Visit: 
                        </td>

                        <td>
                        <div class="">
            <label class="mr-2">
            <input type="checkbox" class="add-remove-checkbox0" name="joint_visit" id="" value="ZSM"> ZSM
            </label>
            <label class="mr-2">
            <input type="checkbox" class="add-remove-checkbox0" name="joint_visit" id="" value="RSM"> RSM
            </label>
            <label class="mr-2">
            <input type="checkbox" class="add-remove-checkbox0" name="joint_visit" id="" value="HO1"> HO1
            </label>
            <label class="mr-2">
            <input type="checkbox" class="add-remove-checkbox0" name="joint_visit" id="" value="HO2"> HO2
            </label>
            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="pro_th">Products</th>
                        <th class="pro_th">Quantity</th>
                        <th class="pro_th">Action</th>
                    </tr>
                    <tr id="row_1">
                        <td>1
                            <select name="products[]" class="pro-width">
                                <?php
                                $select = "SELECT name FROM products";
                                $select_q = mysqli_query($conn, $select);
                                if (mysqli_num_rows($select_q) > 0) {
                                    while ($row = mysqli_fetch_assoc($select_q)) {
                                        echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No products found</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td><input type="number" name="product_qty[]" class="width" required autocomplete="off"></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center mt-3">
                <button type="button" id="addRow" class="btn btn-primary btn-sm">Add Product</button>
                <button type="submit" class="btn btn-success btn-sm" name="submit">Submit</button>
            </div>
        </form>
    </div>
    <?php
include 'dbconfig.php';
if (isset($_POST['submit'])) {
    $customer_name = $_POST['customer_name'];
    $customer_code = $_POST['customer_code'];
    $depot = $_POST['depot'];

    $products = $_POST['products'];
    $product_qty = $_POST['product_qty'];

    $name = $_SESSION['fullname'];
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $department = $_SESSION['department'];
    $role = $_SESSION['role'];
    $zone = $_SESSION['zone'];
    $be_depart = $_SESSION['be_depart'];
    $be_role = $_SESSION['be_role'];
    $date = date('Y-m-d');

    $joint_visit =  $_POST['joint_visit'];


    $insert_query = "INSERT INTO field_visit_form (name, username, email, date, department, role, zone, customer_name, customer_code, depot,be_depart,be_role,joint_visit";
    for ($i = 1; $i <= 15; $i++) {
        $insert_query .= ", products_$i, order_qty_$i";
    }
    $insert_query .= ") VALUES ('$name', '$username', '$email', '$date', '$department', '$role', '$zone', '$customer_name', '$customer_code', '$depot', '$be_depart','$be_role','$joint_visit'";
for ($i = 0; $i < 15; $i++) {
    $product = isset($products[$i]) ? $products[$i] : '';
    $qty = isset($product_qty[$i]) ? $product_qty[$i] : '';
    if ($qty === '') $qty = NULL;
    $insert_query .= ", '$product', '$qty'";
}
    $insert_query .= ")";

    if (mysqli_query($conn, $insert_query)) {
        echo "<script>alert('Request has been submitted'); window.location.href = 'field_visit_form.php';</script>";
    } else {
        echo "<script>alert('Error submitting request'); window.location.href = 'field_visit_form.php';</script>";
    }
}
?>
            </div>
            </div> 
        </div> 
    </section>
        </div> 
    </div> 
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <script>
            document.addEventListener('DOMContentLoaded', function () {
                const checkboxes = document.querySelectorAll('.add-remove-checkbox');
            
                checkboxes.forEach(function (checkbox) {
                    checkbox.addEventListener('change', function () {
                        const groupName = this.name.split('_')[0]; // Extract the group name
            
                        // Uncheck other checkboxes in the same group
                        checkboxes.forEach(function (cb) {
                            if (cb !== checkbox && cb.name.startsWith(groupName)) {
                                cb.checked = false;
                            }
                        });
                    });
                });
            });
        </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
<script>
    $(document).ready(function() {
        var rowNumber = 2; 
        var maxRows = 17;   
        $('#addRow').click(function() {
            if ($('#table-body tr').length - 2 < maxRows) {
                var newRow = $('#row_1').clone().attr('id', 'row_' + rowNumber);
                newRow.find('td:first').html(rowNumber + '<select name="products[]" class="pro-width">' + $('#row_1 select').html() + '</select>');
                newRow.find('input').each(function() {
                    var name = $(this).attr('name').replace('1_', rowNumber + '_');
                    $(this).attr('name', name);
                    $(this).val('');
                });
                newRow.find('td:last').html('<button type="button" class="btn btn-danger btn-sm removeRow">Remove</button>');
                $('#table-body').append(newRow);
                rowNumber++;
            } else {
                alert('6 Products limit');
            }
        });
        $(document).on('click', '.removeRow', function() {
            $(this).closest('tr').remove();
            rowNumber--;  
        });
});
</script>
    <script src="assets/js/main.js"></script>
</body>
</html>