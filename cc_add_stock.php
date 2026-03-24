<?php
    session_start();
    
    
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php'); // Redirect to the login page
        exit;
    }
    
    $head_email = $_SESSION['head_email'];
    
    
    $fullname = $_SESSION['fullname'];
    // $department = $_SESSION['department'];
    // $role = $_SESSION['role'];
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
        <title>Change Control Request Form</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="assets/css/style.css">
        <style>
            y .bg-menu {
            background-color: #393E46 !important;
            }
            /* =====================
            Buttons
            ===================== */
            .btn-menu {
            font-size: 12.5px;
            font-weight: 600;
            background-color: #FFB22C !important;
            padding: 5px 10px;
            border: none !important;
            border-radius: 2px !important;
            color: black !important;
            }
            .bg-menu {
            background-color: #393E46 !important;
            }
            body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f6fa;
            }
            .card {
            border-radius: 10px;
            }
            textarea {
            resize: both;
            /* Allows resizing in both directions */
            min-height: 300px;
            /* Ensures it's not too small */
            min-width: 100px;
            /* Ensures it's not too small */
            }
            .table-1 td,
            .table-2 td,
            .table-3 td {
            padding: 7px 10px !important;
            }
            .ul-msg li {
            font-size: 12px;
            font-weight: 500;
            padding-top: 10px
            }
            /* th{
            font-size: 11px!important;
            border:none!important;
            border:1px solid grey!important;:
            }
            td{
            font-size: 11px!important;
            background-color:White!important;
            color:black!important;
            border:1px solid grey!important;:
            } */
            th {
            font-size: 11px !important;
            border: none !important;
            background-color: #ced4da !important;
            color: black !important;
            font-weight: 600 !important;
            }
            td {
            font-size: 10.5px !important;
            background-color: White !important;
            color: black !important;
            border: 1px solid grey !important;
            padding: 0px !important;
            margin: 0px !important;
            }
            thead {
            border: 1px solid #0D9276 !important;
            }
            input[type=checkbox],
            label {
            padding: 0px !important;
            margin: 0px !important;
            }
            .btn-submit {
            font-size: 16px !important;
            color: white;
            background-color: #0d6efd;
            padding: 5px 35px;
            border-radius: 2px;
            border: 2px solid #0d6efd;
            letter-spacing: 1.35px;
            font-weight: 500;
            }
            .btn-submit:hover {
            font-size: 16px !important;
            color: white;
            background-color: #0d6efd;
            padding: 5px 35px;
            border-radius: 2px;
            border: 2px solid #0d6efd;
            letter-spacing: 1.35px;
            font-weight: 500;
            }
            .cbox {
            height: 13px !important;
            width: 13px !important;
            }
            p {
            font-size: 11.7px !important;
            padding: 0px !important;
            margin: 0px !important;
            font-weight: 500 !important;
            display: inline !important;
            margin-right: 10px !important;
            }
            input,
            textarea {
            width: 100% !important;
            font-size: 11.7px !important;
            border-radius: 0px !important;
            border: none !important;
            transition: border-color 0.3s ease !important;
            padding: 5px 5px !important;
            letter-spacing: 0.4px !important;
            height: 25px !important;
            }
            textarea {
            width: 200px !important;
            }
            input:focus,
            textarea:focus {
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
            }
        </style>
        <?php
            include 'sidebarcss.php'
            ?>
    </head>
    <body>
        <div class="wrapper">
            <?php
                include 'sidebar1.php';
                ?>
            <!-- Page Content  -->
            <div id="content">
                <!-- navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-menu">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-menu text-black">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                        </button>
                    </div>
                </nav>
                <?php
                    include 'dbconfig.php';
                    
                    
                    $id = $_GET['id'];
                    $select = "SELECT * FROM qc_ccrf WHERE id = '$id'";
                    
                    $select_q = mysqli_query($conn, $select);
                    $data = mysqli_num_rows($select_q);
                    ?>
                <?php
                    if ($data) {
                        while ($row = mysqli_fetch_array($select_q)) {
                    ?>
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <form class="form pb-3" method="POST">
                                <div class="card shadow mt-3">
                                    <div class="card-header bg-dark text-white d-flex align-items-center">
                                        <h6 class="mb-0 main-heading"> Add Stock</h6>
                                        <div class="ms-auto">
                                            <a href="cc_home.php" class="btn btn-light btn-sm me-2">Home</a>
                                            <a href="cc_add_stock_list.php" class="btn btn-light btn-sm me-2">Back</a>
                                        </div>
                                    </div>
                               <div class="card-body">
    <table class="table table-bordered">
        <thead>
            <tr>
                <td colspan="8" class="py-1 pl-1">
                    <p class="m-2">In-Hand Stock Status</p>
                </td>
            </tr>
            <tr>
                <th rowspan="2">S. No.</th>
                <th rowspan="2">Material Code</th>
                <th rowspan="2">Material Name</th>
                <th colspan="4"> Stock Status as on:</th>
                <th rowspan="2">Signature Warehouse</th>
            </tr>
            <tr>
                <th>Released Qty.</th>
                <th>Artwork Code</th>
                <th>Quarantine Qty.</th>
                <th>Artwork Code</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 1; $i <= 5; $i++) { ?>
                <tr>
                    <td><input type="text" name="c_sno_<?php echo $i; ?>" value="<?php echo $row['c_sno_' . $i]; ?>"></td>
                    <td><input type="text" name="c_material_code_<?php echo $i; ?>" value="<?php echo $row['c_material_code_' . $i]; ?>"></td>
                    <td><input type="text" name="c_material_name_<?php echo $i; ?>" value="<?php echo $row['c_material_name_' . $i]; ?>"></td>
                    <td><input type="text" name="c_released_qty_<?php echo $i; ?>" value="<?php echo $row['c_released_qty_' . $i]; ?>"></td>
                    <td><input type="text" name="c_artwork_code_<?php echo $i; ?>" value="<?php echo $row['c_artwork_code_' . $i]; ?>"></td>
                    <td><input type="text" name="c_quarantine_qty_<?php echo $i; ?>" value="<?php echo $row['c_quarantine_qty_' . $i]; ?>"></td>
                    <td><input type="text" name="c_artwork_code2_<?php echo $i; ?>" value="<?php echo $row['c_artwork_code2_' . $i]; ?>"></td>
                    <td><input type="text" name="c_signature_warehouse_<?php echo $i; ?>" value="<?php echo $row['c_signature_warehouse_' . $i]; ?>"></td>
                </tr>
            <?php } ?>

            <tr>
                <td colspan="7" class="py-1 pl-1">
                    <p class="m-2">On-Order Quality</p>
                </td>
            </tr>

            <tr>
                <th>S. No.</th>
                <th>Material Code</th>
                <th>Material Name</th>
                <th>Quantity</th>
                <th>Artwork Code</th>
                <th>Expected Delivery Date</th>
                <th colspan="2">(Signature Purchase Deptt.)</th>
            </tr>

            <?php for ($i = 1; $i <= 5; $i++) { ?>
                <tr>
                    <td><input type="text" name="c2_sno_<?php echo $i; ?>" value="<?php echo $row['c2_sno_' . $i]; ?>"></td>
                    <td><input type="text" name="c2_material_code_<?php echo $i; ?>" value="<?php echo $row['c2_material_code_' . $i]; ?>"></td>
                    <td><input type="text" name="c2_material_name_<?php echo $i; ?>" value="<?php echo $row['c2_material_name_' . $i]; ?>"></td>
                    <td><input type="text" name="c2_quantity_<?php echo $i; ?>" value="<?php echo $row['c2_quantity_' . $i]; ?>"></td>
                    <td><input type="text" name="c2_artwork_code_<?php echo $i; ?>" value="<?php echo $row['c2_artwork_code_' . $i]; ?>"></td>
                    <td><input type="text" name="c2_expected_ddate_<?php echo $i; ?>" value="<?php echo $row['c2_expected_ddate_' . $i]; ?>"></td>
                    <td colspan="2">
                        <input type="text" name="c2_signature_pd_<?php echo $i; ?>" value="<?php echo $row['c2_signature_pd_' . $i]; ?>">
                    </td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
                                        <!-- form 5 -->
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <td colspan="8" class="py-1 pl-1">
                                                        <p class="m-2">Detail regarding additional order (along with code no.) to be placed (if any)</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>S. No.</th>
                                                    <th>Material Code</th>
                                                    <th>Material Name</th>
                                                    <th>Quantity</th>
                                                    <th>Artwork Code</th>
                                                    <th>Expected Delivery Date </th>
                                                    <th>Sinature Purchase</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input type="text" name="d_sno_1" value="<?php echo $row['d_sno_1']; ?>"></td>
                                                    <td><input type="text" name="d_material_code_1" value="<?php echo $row['d_material_code_1']; ?>"></td>
                                                    <td><input type="text" name="d_material_name_1" value="<?php echo $row['d_material_name_1']; ?>"></td>
                                                    <td><input type="text" name="d_quantity_1" value="<?php echo $row['d_quantity_1']; ?>"></td>
                                                    <td><input type="text" name="d_artwork_code_1" value="<?php echo $row['d_artwork_code_1']; ?>"></td>
                                                    <td><input type="text" name="d_expected_ddate_1" value="<?php echo $row['d_expected_ddate_1']; ?>"></td>
                                                    <td><input type="text" name="d_signature_purchase_1" value="<?php echo $row['d_signature_purchase_1']; ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="d_sno_2" value="<?php echo $row['d_sno_2']; ?>"></td>
                                                    <td><input type="text" name="d_material_code_2" value="<?php echo $row['d_material_code_2']; ?>"></td>
                                                    <td><input type="text" name="d_material_name_2" value="<?php echo $row['d_material_name_2']; ?>"></td>
                                                    <td><input type="text" name="d_quantity_2" value="<?php echo $row['d_quantity_2']; ?>"></td>
                                                    <td><input type="text" name="d_artwork_code_2" value="<?php echo $row['d_artwork_code_2']; ?>"></td>
                                                    <td><input type="text" name="d_expected_ddate_2" value="<?php echo $row['d_expected_ddate_2']; ?>"></td>
                                                    <td><input type="text" name="d_signature_purchase_2" value="<?php echo $row['d_signature_purchase_2']; ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="d_sno_3" value="<?php echo $row['d_sno_3']; ?>"></td>
                                                    <td><input type="text" name="d_material_code_3" value="<?php echo $row['d_material_code_3']; ?>"></td>
                                                    <td><input type="text" name="d_material_name_3" value="<?php echo $row['d_material_name_3']; ?>"></td>
                                                    <td><input type="text" name="d_quantity_3" value="<?php echo $row['d_quantity_3']; ?>"></td>
                                                    <td><input type="text" name="d_artwork_code_3" value="<?php echo $row['d_artwork_code_3']; ?>"></td>
                                                    <td><input type="text" name="d_expected_ddate_3" value="<?php echo $row['d_expected_ddate_3']; ?>"></td>
                                                    <td><input type="text" name="d_signature_purchase_3" value="<?php echo $row['d_signature_purchase_3']; ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="d_sno_4" value="<?php echo $row['d_sno_4']; ?>"></td>
                                                    <td><input type="text" name="d_material_code_4" value="<?php echo $row['d_material_code_4']; ?>"></td>
                                                    <td><input type="text" name="d_material_name_4" value="<?php echo $row['d_material_name_4']; ?>"></td>
                                                    <td><input type="text" name="d_quantity_4" value="<?php echo $row['d_quantity_4']; ?>"></td>
                                                    <td><input type="text" name="d_artwork_code_4" value="<?php echo $row['d_artwork_code_4']; ?>"></td>
                                                    <td><input type="text" name="d_expected_ddate_4" value="<?php echo $row['d_expected_ddate_4']; ?>"></td>
                                                    <td><input type="text" name="d_signature_purchase_4" value="<?php echo $row['d_signature_purchase_4']; ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="d_sno_5" value="<?php echo $row['d_sno_5']; ?>"></td>
                                                    <td><input type="text" name="d_material_code_5" value="<?php echo $row['d_material_code_5']; ?>"></td>
                                                    <td><input type="text" name="d_material_name_5" value="<?php echo $row['d_material_name_5']; ?>"></td>
                                                    <td><input type="text" name="d_quantity_5" value="<?php echo $row['d_quantity_5']; ?>"></td>
                                                    <td><input type="text" name="d_artwork_code_5" value="<?php echo $row['d_artwork_code_5']; ?>"></td>
                                                    <td><input type="text" name="d_expected_ddate_5" value="<?php echo $row['d_expected_ddate_5']; ?>"></td>
                                                    <td><input type="text" name="d_signature_purchase_5" value="<?php echo $row['d_signature_purchase_5']; ?>"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <td colspan="6" class="py-1 pl-1">
                                                        <p class="m-2">Material to be destroyed (if any)</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>S. No.</th>
                                                    <th>Material Code</th>
                                                    <th>Material Name</th>
                                                    <th>Quantity</th>
                                                    <th>Artwork Code</th>
                                                    <th>Signature Planning</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input type="text" name="d2_sno_1" value="<?php echo $row['d2_sno_1']; ?>"></td>
                                                    <td><input type="text" name="d2_material_code_1" value="<?php echo $row['d2_material_code_1']; ?>"></td>
                                                    <td><input type="text" name="d2_material_name_1" value="<?php echo $row['d2_material_name_1']; ?>"></td>
                                                    <td><input type="text" name="d2_quantity_1" value="<?php echo $row['d2_quantity_1']; ?>"></td>
                                                    <td><input type="text" name="d2_artwork_code_1" value="<?php echo $row['d2_artwork_code_1']; ?>"></td>
                                                    <td><input type="text" name="d2_signature_planning_1" value="<?php echo $row['d2_signature_planning_1']; ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="d2_sno_2" value="<?php echo $row['d2_sno_2']; ?>"></td>
                                                    <td><input type="text" name="d2_material_code_2" value="<?php echo $row['d2_material_code_2']; ?>"></td>
                                                    <td><input type="text" name="d2_material_name_2" value="<?php echo $row['d2_material_name_2']; ?>"></td>
                                                    <td><input type="text" name="d2_quantity_2" value="<?php echo $row['d2_quantity_2']; ?>"></td>
                                                    <td><input type="text" name="d2_artwork_code_2" value="<?php echo $row['d2_artwork_code_2']; ?>"></td>
                                                    <td><input type="text" name="d2_signature_planning_2" value="<?php echo $row['d2_signature_planning_2']; ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="d2_sno_3" value="<?php echo $row['d2_sno_3']; ?>"></td>
                                                    <td><input type="text" name="d2_material_code_3" value="<?php echo $row['d2_material_code_3']; ?>"></td>
                                                    <td><input type="text" name="d2_material_name_3" value="<?php echo $row['d2_material_name_3']; ?>"></td>
                                                    <td><input type="text" name="d2_quantity_3" value="<?php echo $row['d2_quantity_3']; ?>"></td>
                                                    <td><input type="text" name="d2_artwork_code_3" value="<?php echo $row['d2_artwork_code_3']; ?>"></td>
                                                    <td><input type="text" name="d2_signature_planning_3" value="<?php echo $row['d2_signature_planning_3']; ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="d2_sno_4" value="<?php echo $row['d2_sno_4']; ?>"></td>
                                                    <td><input type="text" name="d2_material_code_4" value="<?php echo $row['d2_material_code_4']; ?>"></td>
                                                    <td><input type="text" name="d2_material_name_4" value="<?php echo $row['d2_material_name_4']; ?>"></td>
                                                    <td><input type="text" name="d2_quantity_4" value="<?php echo $row['d2_quantity_4']; ?>"></td>
                                                    <td><input type="text" name="d2_artwork_code_4" value="<?php echo $row['d2_artwork_code_4']; ?>"></td>
                                                    <td><input type="text" name="d2_signature_planning_4" value="<?php echo $row['d2_signature_planning_4']; ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="d2_sno_5" value="<?php echo $row['d2_sno_5']; ?>"></td>
                                                    <td><input type="text" name="d2_material_code_5" value="<?php echo $row['d2_material_code_5']; ?>"></td>
                                                    <td><input type="text" name="d2_material_name_5" value="<?php echo $row['d2_material_name_5']; ?>"></td>
                                                    <td><input type="text" name="d2_quantity_5" value="<?php echo $row['d2_quantity_5']; ?>"></td>
                                                    <td><input type="text" name="d2_artwork_code_5" value="<?php echo $row['d2_artwork_code_5']; ?>"></td>
                                                    <td><input type="text" name="d2_signature_planning_5" value="<?php echo $row['d2_signature_planning_5']; ?>"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <td colspan="8" class="py-1 pl-1">
                                                        <p class="m-2">No. if batches to be produced with old inventory as per following details</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>S. No.</th>
                                                    <th>Material Code</th>
                                                    <th>Material Name</th>
                                                    <th>Quantity</th>
                                                    <th>Artwork Code</th>
                                                    <th>Batch No.</th>
                                                    <th>Sinature Planning</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input type="text" name="d3_sno_1" value="<?php echo $row['d3_sno_1']; ?>"></td>
                                                    <td><input type="text" name="d3_material_code_1" value="<?php echo $row['d3_material_code_1']; ?>"></td>
                                                    <td><input type="text" name="d3_material_name_1" value="<?php echo $row['d3_material_name_1']; ?>"></td>
                                                    <td><input type="text" name="d3_quantity_1" value="<?php echo $row['d3_quantity_1']; ?>"></td>
                                                    <td><input type="text" name="d3_artwork_code_1" value="<?php echo $row['d3_artwork_code_1']; ?>"></td>
                                                    <td><input type="text" name="d3_batchno_1" value="<?php echo $row['d3_batchno_1']; ?>"></td>
                                                    <td><input type="text" name="d3_signature_planning_1" value="<?php echo $row['d3_signature_planning_1']; ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="d3_sno_2" value="<?php echo $row['d3_sno_2']; ?>"></td>
                                                    <td><input type="text" name="d3_material_code_2" value="<?php echo $row['d3_material_code_2']; ?>"></td>
                                                    <td><input type="text" name="d3_material_name_2" value="<?php echo $row['d3_material_name_2']; ?>"></td>
                                                    <td><input type="text" name="d3_quantity_2" value="<?php echo $row['d3_quantity_2']; ?>"></td>
                                                    <td><input type="text" name="d3_artwork_code_2" value="<?php echo $row['d3_artwork_code_2']; ?>"></td>
                                                    <td><input type="text" name="d3_batchno_2" value="<?php echo $row['d3_batchno_2']; ?>"></td>
                                                    <td><input type="text" name="d3_signature_planning_2" value="<?php echo $row['d3_signature_planning_2']; ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="d3_sno_3" value="<?php echo $row['d3_sno_3']; ?>"></td>
                                                    <td><input type="text" name="d3_material_code_3" value="<?php echo $row['d3_material_code_3']; ?>"></td>
                                                    <td><input type="text" name="d3_material_name_3" value="<?php echo $row['d3_material_name_3']; ?>"></td>
                                                    <td><input type="text" name="d3_quantity_3" value="<?php echo $row['d3_quantity_3']; ?>"></td>
                                                    <td><input type="text" name="d3_artwork_code_3" value="<?php echo $row['d3_artwork_code_3']; ?>"></td>
                                                    <td><input type="text" name="d3_batchno_3" value="<?php echo $row['d3_batchno_3']; ?>"></td>
                                                    <td><input type="text" name="d3_signature_planning_3" value="<?php echo $row['d3_signature_planning_3']; ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="d3_sno_4" value="<?php echo $row['d3_sno_4']; ?>"></td>
                                                    <td><input type="text" name="d3_material_code_4" value="<?php echo $row['d3_material_code_4']; ?>"></td>
                                                    <td><input type="text" name="d3_material_name_4" value="<?php echo $row['d3_material_name_4']; ?>"></td>
                                                    <td><input type="text" name="d3_quantity_4" value="<?php echo $row['d3_quantity_4']; ?>"></td>
                                                    <td><input type="text" name="d3_artwork_code_4" value="<?php echo $row['d3_artwork_code_4']; ?>"></td>
                                                    <td><input type="text" name="d3_batchno_4" value="<?php echo $row['d3_batchno_4']; ?>"></td>
                                                    <td><input type="text" name="d3_signature_planning_4" value="<?php echo $row['d3_signature_planning_4']; ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="d3_sno_5" value="<?php echo $row['d3_sno_5']; ?>"></td>
                                                    <td><input type="text" name="d3_material_code_5" value="<?php echo $row['d3_material_code_5']; ?>"></td>
                                                    <td><input type="text" name="d3_material_name_5" value="<?php echo $row['d3_material_name_5']; ?>"></td>
                                                    <td><input type="text" name="d3_quantity_5" value="<?php echo $row['d3_quantity_5']; ?>"></td>
                                                    <td><input type="text" name="d3_artwork_code_5" value="<?php echo $row['d3_artwork_code_5']; ?>"></td>
                                                    <td><input type="text" name="d3_batchno_4" value="<?php echo $row['d3_batchno_5']; ?>"></td>
                                                    <td><input type="text" name="d3_signature_planning_5" value="<?php echo $row['d3_signature_planning_5']; ?>"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <tr>
                                            <div class="text-center mt-4">
                                                <button type="submit" name="submit" class="btn btn-dark px-4">
                                                Submit
                                                </button>
                                            </div>
                                        </tr>
                            </form>
                            <?php
                                include 'dbconfig.php';
                                
                                // Check if form is submitted
                                if (isset($_POST['submit'])) {
                                    // Retrieve form data
                                    $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                                    $name =  $_SESSION['fullname'];
                                
                                
                                    // form 4
                                
                                    $f_c_sno_1 = isset($_POST['c_sno_1']) && $_POST['c_sno_1'] !== $row['c_sno_1'] ? $_POST['c_sno_1'] : $row['c_sno_1'];
                                    $f_c_sno_2 = isset($_POST['c_sno_2']) && $_POST['c_sno_2'] !== $row['c_sno_2'] ? $_POST['c_sno_2'] : $row['c_sno_2'];
                                    $f_c_sno_3 = isset($_POST['c_sno_3']) && $_POST['c_sno_3'] !== $row['c_sno_3'] ? $_POST['c_sno_3'] : $row['c_sno_3'];
                                    $f_c_sno_4 = isset($_POST['c_sno_4']) && $_POST['c_sno_4'] !== $row['c_sno_4'] ? $_POST['c_sno_4'] : $row['c_sno_4'];
                                    $f_c_sno_5 = isset($_POST['c_sno_5']) && $_POST['c_sno_5'] !== $row['c_sno_5'] ? $_POST['c_sno_5'] : $row['c_sno_5'];
                                
                                    $f_c_material_code_1 = isset($_POST['c_material_code_1']) && $_POST['c_material_code_1'] !== $row['c_material_code_1'] ? $_POST['c_material_code_1'] : $row['c_material_code_1'];
                                    $f_c_material_code_2 = isset($_POST['c_material_code_2']) && $_POST['c_material_code_2'] !== $row['c_material_code_2'] ? $_POST['c_material_code_2'] : $row['c_material_code_2'];
                                    $f_c_material_code_3 = isset($_POST['c_material_code_3']) && $_POST['c_material_code_3'] !== $row['c_material_code_3'] ? $_POST['c_material_code_3'] : $row['c_material_code_3'];
                                    $f_c_material_code_4 = isset($_POST['c_material_code_4']) && $_POST['c_material_code_4'] !== $row['c_material_code_4'] ? $_POST['c_material_code_4'] : $row['c_material_code_4'];
                                    $f_c_material_code_5 = isset($_POST['c_material_code_5']) && $_POST['c_material_code_5'] !== $row['c_material_code_5'] ? $_POST['c_material_code_5'] : $row['c_material_code_5'];
                                
                                    $f_c_material_name_1 = isset($_POST['c_material_name_1']) && $_POST['c_material_name_1'] !== $row['c_material_name_1'] ? $_POST['c_material_name_1'] : $row['c_material_name_1'];
                                    $f_c_material_name_2 = isset($_POST['c_material_name_2']) && $_POST['c_material_name_2'] !== $row['c_material_name_2'] ? $_POST['c_material_name_2'] : $row['c_material_name_2'];
                                    $f_c_material_name_3 = isset($_POST['c_material_name_3']) && $_POST['c_material_name_3'] !== $row['c_material_name_3'] ? $_POST['c_material_name_3'] : $row['c_material_name_3'];
                                    $f_c_material_name_4 = isset($_POST['c_material_name_4']) && $_POST['c_material_name_4'] !== $row['c_material_name_4'] ? $_POST['c_material_name_4'] : $row['c_material_name_4'];
                                    $f_c_material_name_5 = isset($_POST['c_material_name_5']) && $_POST['c_material_name_5'] !== $row['c_material_name_5'] ? $_POST['c_material_name_5'] : $row['c_material_name_5'];
                                
                                    $f_c_released_qty_1 = isset($_POST['c_released_qty_1']) && $_POST['c_released_qty_1'] !== $row['c_released_qty_1'] ? $_POST['c_released_qty_1'] : $row['c_released_qty_1'];
                                    $f_c_released_qty_2 = isset($_POST['c_released_qty_2']) && $_POST['c_released_qty_2'] !== $row['c_released_qty_2'] ? $_POST['c_released_qty_2'] : $row['c_released_qty_2'];
                                    $f_c_released_qty_3 = isset($_POST['c_released_qty_3']) && $_POST['c_released_qty_3'] !== $row['c_released_qty_3'] ? $_POST['c_released_qty_3'] : $row['c_released_qty_3'];
                                    $f_c_released_qty_4 = isset($_POST['c_released_qty_4']) && $_POST['c_released_qty_4'] !== $row['c_released_qty_4'] ? $_POST['c_released_qty_4'] : $row['c_released_qty_4'];
                                    $f_c_released_qty_5 = isset($_POST['c_released_qty_5']) && $_POST['c_released_qty_5'] !== $row['c_released_qty_5'] ? $_POST['c_released_qty_5'] : $row['c_released_qty_5'];
                                
                                    $f_c_artwork_code_1 = isset($_POST['c_artwork_code_1']) && $_POST['c_artwork_code_1'] !== $row['c_artwork_code_1'] ? $_POST['c_artwork_code_1'] : $row['c_artwork_code_1'];
                                    $f_c_artwork_code_2 = isset($_POST['c_artwork_code_2']) && $_POST['c_artwork_code_2'] !== $row['c_artwork_code_2'] ? $_POST['c_artwork_code_2'] : $row['c_artwork_code_2'];
                                    $f_c_artwork_code_3 = isset($_POST['c_artwork_code_3']) && $_POST['c_artwork_code_3'] !== $row['c_artwork_code_3'] ? $_POST['c_artwork_code_3'] : $row['c_artwork_code_3'];
                                    $f_c_artwork_code_4 = isset($_POST['c_artwork_code_4']) && $_POST['c_artwork_code_4'] !== $row['c_artwork_code_4'] ? $_POST['c_artwork_code_4'] : $row['c_artwork_code_4'];
                                    $f_c_artwork_code_5 = isset($_POST['c_artwork_code_5']) && $_POST['c_artwork_code_5'] !== $row['c_artwork_code_5'] ? $_POST['c_artwork_code_5'] : $row['c_artwork_code_5'];
                                
                                    $f_c_quarantine_qty_1 = isset($_POST['c_quarantine_qty_1']) && $_POST['c_quarantine_qty_1'] !== $row['c_quarantine_qty_1'] ? $_POST['c_quarantine_qty_1'] : $row['c_quarantine_qty_1'];
                                    $f_c_quarantine_qty_2 = isset($_POST['c_quarantine_qty_2']) && $_POST['c_quarantine_qty_2'] !== $row['c_quarantine_qty_2'] ? $_POST['c_quarantine_qty_2'] : $row['c_quarantine_qty_2'];
                                    $f_c_quarantine_qty_3 = isset($_POST['c_quarantine_qty_3']) && $_POST['c_quarantine_qty_3'] !== $row['c_quarantine_qty_3'] ? $_POST['c_quarantine_qty_3'] : $row['c_quarantine_qty_3'];
                                    $f_c_quarantine_qty_4 = isset($_POST['c_quarantine_qty_4']) && $_POST['c_quarantine_qty_4'] !== $row['c_quarantine_qty_4'] ? $_POST['c_quarantine_qty_4'] : $row['c_quarantine_qty_4'];
                                    $f_c_quarantine_qty_5 = isset($_POST['c_quarantine_qty_5']) && $_POST['c_quarantine_qty_5'] !== $row['c_quarantine_qty_5'] ? $_POST['c_quarantine_qty_5'] : $row['c_quarantine_qty_5'];
                                
                                    $f_c_artwork_code2_1 = isset($_POST['c_artwork_code2_1']) && $_POST['c_artwork_code2_1'] !== $row['c_artwork_code2_1'] ? $_POST['c_artwork_code2_1'] : $row['c_artwork_code2_1'];
                                    $f_c_artwork_code2_2 = isset($_POST['c_artwork_code2_2']) && $_POST['c_artwork_code2_2'] !== $row['c_artwork_code2_2'] ? $_POST['c_artwork_code2_2'] : $row['c_artwork_code2_2'];
                                    $f_c_artwork_code2_3 = isset($_POST['c_artwork_code2_3']) && $_POST['c_artwork_code2_3'] !== $row['c_artwork_code2_3'] ? $_POST['c_artwork_code2_3'] : $row['c_artwork_code2_3'];
                                    $f_c_artwork_code2_4 = isset($_POST['c_artwork_code2_4']) && $_POST['c_artwork_code2_4'] !== $row['c_artwork_code2_4'] ? $_POST['c_artwork_code2_4'] : $row['c_artwork_code2_4'];
                                    $f_c_artwork_code2_5 = isset($_POST['c_artwork_code2_5']) && $_POST['c_artwork_code2_5'] !== $row['c_artwork_code2_5'] ? $_POST['c_artwork_code2_5'] : $row['c_artwork_code2_5'];
                                
                                    $f_c_signature_warehouse_1 = !empty($_POST['c_sno_1']) ? "Sign by $fullname" : '';
                                    $f_c_signature_warehouse_2 = !empty($_POST['c_sno_2']) ? "Sign by $fullname" : '';
                                    $f_c_signature_warehouse_3 = !empty($_POST['c_sno_3']) ? "Sign by $fullname" : '';
                                    $f_c_signature_warehouse_4 = !empty($_POST['c_sno_4']) ? "Sign by $fullname" : '';
                                    $f_c_signature_warehouse_5 = !empty($_POST['c_sno_5']) ? "Sign by $fullname" : '';
                                         
                                    $f_c2_sno_1 = isset($_POST['c2_sno_1']) && $_POST['c2_sno_1'] !== $row['c2_sno_1'] ? $_POST['c2_sno_1'] : $row['c2_sno_1'];
                                    $f_c2_sno_2 = isset($_POST['c2_sno_2']) && $_POST['c2_sno_2'] !== $row['c2_sno_2'] ? $_POST['c2_sno_2'] : $row['c2_sno_2'];
                                    $f_c2_sno_3 = isset($_POST['c2_sno_3']) && $_POST['c2_sno_3'] !== $row['c2_sno_3'] ? $_POST['c2_sno_3'] : $row['c2_sno_3'];
                                    $f_c2_sno_4 = isset($_POST['c2_sno_4']) && $_POST['c2_sno_4'] !== $row['c2_sno_4'] ? $_POST['c2_sno_4'] : $row['c2_sno_4'];
                                    $f_c2_sno_5 = isset($_POST['c2_sno_5']) && $_POST['c2_sno_5'] !== $row['c2_sno_5'] ? $_POST['c2_sno_5'] : $row['c2_sno_5'];
                                
                                    $f_c2_material_code_1 = isset($_POST['c2_material_code_1']) && $_POST['c2_material_code_1'] !== $row['c2_material_code_1'] ? $_POST['c2_material_code_1'] : $row['c2_material_code_1'];
                                    $f_c2_material_code_2 = isset($_POST['c2_material_code_2']) && $_POST['c2_material_code_2'] !== $row['c2_material_code_2'] ? $_POST['c2_material_code_2'] : $row['c2_material_code_2'];
                                    $f_c2_material_code_3 = isset($_POST['c2_material_code_3']) && $_POST['c2_material_code_3'] !== $row['c2_material_code_3'] ? $_POST['c2_material_code_3'] : $row['c2_material_code_3'];
                                    $f_c2_material_code_4 = isset($_POST['c2_material_code_4']) && $_POST['c2_material_code_4'] !== $row['c2_material_code_4'] ? $_POST['c2_material_code_4'] : $row['c2_material_code_4'];
                                    $f_c2_material_code_5 = isset($_POST['c2_material_code_5']) && $_POST['c2_material_code_5'] !== $row['c2_material_code_5'] ? $_POST['c2_material_code_5'] : $row['c2_material_code_5'];
                                
                                    $f_c2_material_name_1 = isset($_POST['c2_material_name_1']) && $_POST['c2_material_name_1'] !== $row['c2_material_name_1'] ? $_POST['c2_material_name_1'] : $row['c2_material_name_1'];
                                    $f_c2_material_name_2 = isset($_POST['c2_material_name_2']) && $_POST['c2_material_name_2'] !== $row['c2_material_name_2'] ? $_POST['c2_material_name_2'] : $row['c2_material_name_2'];
                                    $f_c2_material_name_3 = isset($_POST['c2_material_name_3']) && $_POST['c2_material_name_3'] !== $row['c2_material_name_3'] ? $_POST['c2_material_name_3'] : $row['c2_material_name_3'];
                                    $f_c2_material_name_4 = isset($_POST['c2_material_name_4']) && $_POST['c2_material_name_4'] !== $row['c2_material_name_4'] ? $_POST['c2_material_name_4'] : $row['c2_material_name_4'];
                                    $f_c2_material_name_5 = isset($_POST['c2_material_name_5']) && $_POST['c2_material_name_5'] !== $row['c2_material_name_5'] ? $_POST['c2_material_name_5'] : $row['c2_material_name_5'];
                                
                                    $f_c2_quantity_1 = isset($_POST['c2_quantity_1']) && $_POST['c2_quantity_1'] !== $row['c2_quantity_1'] ? $_POST['c2_quantity_1'] : $row['c2_quantity_1'];
                                    $f_c2_quantity_2 = isset($_POST['c2_quantity_2']) && $_POST['c2_quantity_2'] !== $row['c2_quantity_2'] ? $_POST['c2_quantity_2'] : $row['c2_quantity_2'];
                                    $f_c2_quantity_3 = isset($_POST['c2_quantity_3']) && $_POST['c2_quantity_3'] !== $row['c2_quantity_3'] ? $_POST['c2_quantity_3'] : $row['c2_quantity_3'];
                                    $f_c2_quantity_4 = isset($_POST['c2_quantity_4']) && $_POST['c2_quantity_4'] !== $row['c2_quantity_4'] ? $_POST['c2_quantity_4'] : $row['c2_quantity_4'];
                                    $f_c2_quantity_5 = isset($_POST['c2_quantity_5']) && $_POST['c2_quantity_5'] !== $row['c2_quantity_5'] ? $_POST['c2_quantity_5'] : $row['c2_quantity_5'];
                                
                                    $f_c2_artwork_code_1 = isset($_POST['c2_artwork_code_1']) && $_POST['c2_artwork_code_1'] !== $row['c2_artwork_code_1'] ? $_POST['c2_artwork_code_1'] : $row['c2_artwork_code_1'];
                                    $f_c2_artwork_code_2 = isset($_POST['c2_artwork_code_2']) && $_POST['c2_artwork_code_2'] !== $row['c2_artwork_code_2'] ? $_POST['c2_artwork_code_2'] : $row['c2_artwork_code_2'];
                                    $f_c2_artwork_code_3 = isset($_POST['c2_artwork_code_3']) && $_POST['c2_artwork_code_3'] !== $row['c2_artwork_code_3'] ? $_POST['c2_artwork_code_3'] : $row['c2_artwork_code_3'];
                                    $f_c2_artwork_code_4 = isset($_POST['c2_artwork_code_4']) && $_POST['c2_artwork_code_4'] !== $row['c2_artwork_code_4'] ? $_POST['c2_artwork_code_4'] : $row['c2_artwork_code_4'];
                                    $f_c2_artwork_code_5 = isset($_POST['c2_artwork_code_5']) && $_POST['c2_artwork_code_5'] !== $row['c2_artwork_code_5'] ? $_POST['c2_artwork_code_5'] : $row['c2_artwork_code_5'];
                                
                                    $f_c2_expected_ddate_1 = isset($_POST['c2_expected_ddate_1']) && $_POST['c2_expected_ddate_1'] !== $row['c2_expected_ddate_1'] ? $_POST['c2_expected_ddate_1'] : $row['c2_expected_ddate_1'];
                                    $f_c2_expected_ddate_2 = isset($_POST['c2_expected_ddate_2']) && $_POST['c2_expected_ddate_2'] !== $row['c2_expected_ddate_2'] ? $_POST['c2_expected_ddate_2'] : $row['c2_expected_ddate_2'];
                                    $f_c2_expected_ddate_3 = isset($_POST['c2_expected_ddate_3']) && $_POST['c2_expected_ddate_3'] !== $row['c2_expected_ddate_3'] ? $_POST['c2_expected_ddate_3'] : $row['c2_expected_ddate_3'];
                                    $f_c2_expected_ddate_4 = isset($_POST['c2_expected_ddate_4']) && $_POST['c2_expected_ddate_4'] !== $row['c2_expected_ddate_4'] ? $_POST['c2_expected_ddate_4'] : $row['c2_expected_ddate_4'];
                                    $f_c2_expected_ddate_5 = isset($_POST['c2_expected_ddate_5']) && $_POST['c2_expected_ddate_5'] !== $row['c2_expected_ddate_5'] ? $_POST['c2_expected_ddate_5'] : $row['c2_expected_ddate_5'];
                                
                                    $f_c2_signature_pd_1 = !empty(trim($_POST['c2_sno_1'])) ? "Sign by $fullname" : '';
                                    $f_c2_signature_pd_2 = !empty(trim($_POST['c2_sno_2'])) ? "Sign by $fullname" : '';
                                    $f_c2_signature_pd_3 = !empty(trim($_POST['c2_sno_3'])) ? "Sign by $fullname" : '';
                                    $f_c2_signature_pd_4 = !empty(trim($_POST['c2_sno_4'])) ? "Sign by $fullname" : '';
                                    $f_c2_signature_pd_5 = !empty(trim($_POST['c2_sno_5'])) ? "Sign by $fullname" : '';
                                
                                    $f_d_sno_1 = isset($_POST['d_sno_1']) && $_POST['d_sno_1'] !== $row['d_sno_1'] ? $_POST['d_sno_1'] : $row['d_sno_1'];
                                    $f_d_sno_2 = isset($_POST['d_sno_2']) && $_POST['d_sno_2'] !== $row['d_sno_2'] ? $_POST['d_sno_2'] : $row['d_sno_2'];
                                    $f_d_sno_3 = isset($_POST['d_sno_3']) && $_POST['d_sno_3'] !== $row['d_sno_3'] ? $_POST['d_sno_3'] : $row['d_sno_3'];
                                    $f_d_sno_4 = isset($_POST['d_sno_4']) && $_POST['d_sno_4'] !== $row['d_sno_4'] ? $_POST['d_sno_4'] : $row['d_sno_4'];
                                    $f_d_sno_5 = isset($_POST['d_sno_5']) && $_POST['d_sno_5'] !== $row['d_sno_5'] ? $_POST['d_sno_5'] : $row['d_sno_5'];
                                
                                    $f_d_material_code_1 = isset($_POST['d_material_code_1']) && $_POST['d_material_code_1'] !== $row['d_material_code_1'] ? $_POST['d_material_code_1'] : $row['d_material_code_1'];
                                    $f_d_material_code_2 = isset($_POST['d_material_code_2']) && $_POST['d_material_code_2'] !== $row['d_material_code_2'] ? $_POST['d_material_code_2'] : $row['d_material_code_2'];
                                    $f_d_material_code_3 = isset($_POST['d_material_code_3']) && $_POST['d_material_code_3'] !== $row['d_material_code_3'] ? $_POST['d_material_code_3'] : $row['d_material_code_3'];
                                    $f_d_material_code_4 = isset($_POST['d_material_code_4']) && $_POST['d_material_code_4'] !== $row['d_material_code_4'] ? $_POST['d_material_code_4'] : $row['d_material_code_4'];
                                    $f_d_material_code_5 = isset($_POST['d_material_code_5']) && $_POST['d_material_code_5'] !== $row['d_material_code_5'] ? $_POST['d_material_code_5'] : $row['d_material_code_5'];
                                
                                    $f_d_material_name_1 = isset($_POST['d_material_name_1']) && $_POST['d_material_name_1'] !== $row['d_material_name_1'] ? $_POST['d_material_name_1'] : $row['d_material_name_1'];
                                    $f_d_material_name_2 = isset($_POST['d_material_name_2']) && $_POST['d_material_name_2'] !== $row['d_material_name_2'] ? $_POST['d_material_name_2'] : $row['d_material_name_2'];
                                    $f_d_material_name_3 = isset($_POST['d_material_name_3']) && $_POST['d_material_name_3'] !== $row['d_material_name_3'] ? $_POST['d_material_name_3'] : $row['d_material_name_3'];
                                    $f_d_material_name_4 = isset($_POST['d_material_name_4']) && $_POST['d_material_name_4'] !== $row['d_material_name_4'] ? $_POST['d_material_name_4'] : $row['d_material_name_4'];
                                    $f_d_material_name_5 = isset($_POST['d_material_name_5']) && $_POST['d_material_name_5'] !== $row['d_material_name_5'] ? $_POST['d_material_name_5'] : $row['d_material_name_5'];
                                
                                    $f_d_quantity_1 = isset($_POST['d_quantity_1']) && $_POST['d_quantity_1'] !== $row['d_quantity_1'] ? $_POST['d_quantity_1'] : $row['d_quantity_1'];
                                    $f_d_quantity_2 = isset($_POST['d_quantity_2']) && $_POST['d_quantity_2'] !== $row['d_quantity_2'] ? $_POST['d_quantity_2'] : $row['d_quantity_2'];
                                    $f_d_quantity_3 = isset($_POST['d_quantity_3']) && $_POST['d_quantity_3'] !== $row['d_quantity_3'] ? $_POST['d_quantity_3'] : $row['d_quantity_3'];
                                    $f_d_quantity_4 = isset($_POST['d_quantity_4']) && $_POST['d_quantity_4'] !== $row['d_quantity_4'] ? $_POST['d_quantity_4'] : $row['d_quantity_4'];
                                    $f_d_quantity_5 = isset($_POST['d_quantity_5']) && $_POST['d_quantity_5'] !== $row['d_quantity_5'] ? $_POST['d_quantity_5'] : $row['d_quantity_5'];
                                
                                    $f_d_artwork_code_1 = isset($_POST['d_artwork_code_1']) && $_POST['d_artwork_code_1'] !== $row['d_artwork_code_1'] ? $_POST['d_artwork_code_1'] : $row['d_artwork_code_1'];
                                    $f_d_artwork_code_2 = isset($_POST['d_artwork_code_2']) && $_POST['d_artwork_code_2'] !== $row['d_artwork_code_2'] ? $_POST['d_artwork_code_2'] : $row['d_artwork_code_2'];
                                    $f_d_artwork_code_3 = isset($_POST['d_artwork_code_3']) && $_POST['d_artwork_code_3'] !== $row['d_artwork_code_3'] ? $_POST['d_artwork_code_3'] : $row['d_artwork_code_3'];
                                    $f_d_artwork_code_4 = isset($_POST['d_artwork_code_4']) && $_POST['d_artwork_code_4'] !== $row['d_artwork_code_4'] ? $_POST['d_artwork_code_4'] : $row['d_artwork_code_4'];
                                    $f_d_artwork_code_5 = isset($_POST['d_artwork_code_5']) && $_POST['d_artwork_code_5'] !== $row['d_artwork_code_5'] ? $_POST['d_artwork_code_5'] : $row['d_artwork_code_5'];
                                
                                    $f_d_expected_ddate_1 = isset($_POST['d_expected_ddate_1']) && $_POST['d_expected_ddate_1'] !== $row['d_expected_ddate_1'] ? $_POST['d_expected_ddate_1'] : $row['d_expected_ddate_1'];
                                    $f_d_expected_ddate_2 = isset($_POST['d_expected_ddate_2']) && $_POST['d_expected_ddate_2'] !== $row['d_expected_ddate_2'] ? $_POST['d_expected_ddate_2'] : $row['d_expected_ddate_2'];
                                    $f_d_expected_ddate_3 = isset($_POST['d_expected_ddate_3']) && $_POST['d_expected_ddate_3'] !== $row['d_expected_ddate_3'] ? $_POST['d_expected_ddate_3'] : $row['d_expected_ddate_3'];
                                    $f_d_expected_ddate_4 = isset($_POST['d_expected_ddate_4']) && $_POST['d_expected_ddate_4'] !== $row['d_expected_ddate_4'] ? $_POST['d_expected_ddate_4'] : $row['d_expected_ddate_4'];
                                    $f_d_expected_ddate_5 = isset($_POST['d_expected_ddate_5']) && $_POST['d_expected_ddate_5'] !== $row['d_expected_ddate_5'] ? $_POST['d_expected_ddate_5'] : $row['d_expected_ddate_5'];
                                
                                    $f_d_signature_purchase_1 = !empty(trim($_POST['d_sno_1'])) ? "Sign by $fullname" : '';
                                    $f_d_signature_purchase_2 = !empty(trim($_POST['d_sno_2'])) ? "Sign by $fullname" : '';
                                    $f_d_signature_purchase_3 = !empty(trim($_POST['d_sno_3'])) ? "Sign by $fullname" : '';
                                    $f_d_signature_purchase_4 = !empty(trim($_POST['d_sno_4'])) ? "Sign by $fullname" : '';
                                    $f_d_signature_purchase_5 = !empty(trim($_POST['d_sno_5'])) ? "Sign by $fullname" : '';
                                
                                    $f_d2_sno_1 = isset($_POST['d2_sno_1']) && $_POST['d2_sno_1'] !== $row['d2_sno_1'] ? $_POST['d2_sno_1'] : $row['d2_sno_1'];
                                    $f_d2_sno_2 = isset($_POST['d2_sno_2']) && $_POST['d2_sno_2'] !== $row['d2_sno_2'] ? $_POST['d2_sno_2'] : $row['d2_sno_2'];
                                    $f_d2_sno_3 = isset($_POST['d2_sno_3']) && $_POST['d2_sno_3'] !== $row['d2_sno_3'] ? $_POST['d2_sno_3'] : $row['d2_sno_3'];
                                    $f_d2_sno_4 = isset($_POST['d2_sno_4']) && $_POST['d2_sno_4'] !== $row['d2_sno_4'] ? $_POST['d2_sno_4'] : $row['d2_sno_4'];
                                    $f_d2_sno_5 = isset($_POST['d2_sno_5']) && $_POST['d2_sno_5'] !== $row['d2_sno_5'] ? $_POST['d2_sno_5'] : $row['d2_sno_5'];
                                
                                    $f_d2_material_code_1 = isset($_POST['d2_material_code_1']) && $_POST['d2_material_code_1'] !== $row['d2_material_code_1'] ? $_POST['d2_material_code_1'] : $row['d2_material_code_1'];
                                    $f_d2_material_code_2 = isset($_POST['d2_material_code_2']) && $_POST['d2_material_code_2'] !== $row['d2_material_code_2'] ? $_POST['d2_material_code_2'] : $row['d2_material_code_2'];
                                    $f_d2_material_code_3 = isset($_POST['d2_material_code_3']) && $_POST['d2_material_code_3'] !== $row['d2_material_code_3'] ? $_POST['d2_material_code_3'] : $row['d2_material_code_3'];
                                    $f_d2_material_code_4 = isset($_POST['d2_material_code_4']) && $_POST['d2_material_code_4'] !== $row['d2_material_code_4'] ? $_POST['d2_material_code_4'] : $row['d2_material_code_4'];
                                    $f_d2_material_code_5 = isset($_POST['d2_material_code_5']) && $_POST['d2_material_code_5'] !== $row['d2_material_code_5'] ? $_POST['d2_material_code_5'] : $row['d2_material_code_5'];
                                
                                    $f_d2_material_name_1 = isset($_POST['d2_material_name_1']) && $_POST['d2_material_name_1'] !== $row['d2_material_name_1'] ? $_POST['d2_material_name_1'] : $row['d2_material_name_1'];
                                    $f_d2_material_name_2 = isset($_POST['d2_material_name_2']) && $_POST['d2_material_name_2'] !== $row['d2_material_name_2'] ? $_POST['d2_material_name_2'] : $row['d2_material_name_2'];
                                    $f_d2_material_name_3 = isset($_POST['d2_material_name_3']) && $_POST['d2_material_name_3'] !== $row['d2_material_name_3'] ? $_POST['d2_material_name_3'] : $row['d2_material_name_3'];
                                    $f_d2_material_name_4 = isset($_POST['d2_material_name_4']) && $_POST['d2_material_name_4'] !== $row['d2_material_name_4'] ? $_POST['d2_material_name_4'] : $row['d2_material_name_4'];
                                    $f_d2_material_name_5 = isset($_POST['d2_material_name_5']) && $_POST['d2_material_name_5'] !== $row['d2_material_name_5'] ? $_POST['d2_material_name_5'] : $row['d2_material_name_5'];
                                
                                    $f_d2_quantity_1 = isset($_POST['d2_quantity_1']) && $_POST['d2_quantity_1'] !== $row['d2_quantity_1'] ? $_POST['d2_quantity_1'] : $row['d2_quantity_1'];
                                    $f_d2_quantity_2 = isset($_POST['d2_quantity_2']) && $_POST['d2_quantity_2'] !== $row['d2_quantity_2'] ? $_POST['d2_quantity_2'] : $row['d2_quantity_2'];
                                    $f_d2_quantity_3 = isset($_POST['d2_quantity_3']) && $_POST['d2_quantity_3'] !== $row['d2_quantity_3'] ? $_POST['d2_quantity_3'] : $row['d2_quantity_3'];
                                    $f_d2_quantity_4 = isset($_POST['d2_quantity_4']) && $_POST['d2_quantity_4'] !== $row['d2_quantity_4'] ? $_POST['d2_quantity_4'] : $row['d2_quantity_4'];
                                    $f_d2_quantity_5 = isset($_POST['d2_quantity_5']) && $_POST['d2_quantity_5'] !== $row['d2_quantity_5'] ? $_POST['d2_quantity_5'] : $row['d2_quantity_5'];
                                
                                    $f_d2_artwork_code_1 = isset($_POST['d2_artwork_code_1']) && $_POST['d2_artwork_code_1'] !== $row['d2_artwork_code_1'] ? $_POST['d2_artwork_code_1'] : $row['d2_artwork_code_1'];
                                    $f_d2_artwork_code_2 = isset($_POST['d2_artwork_code_2']) && $_POST['d2_artwork_code_2'] !== $row['d2_artwork_code_2'] ? $_POST['d2_artwork_code_2'] : $row['d2_artwork_code_2'];
                                    $f_d2_artwork_code_3 = isset($_POST['d2_artwork_code_3']) && $_POST['d2_artwork_code_3'] !== $row['d2_artwork_code_3'] ? $_POST['d2_artwork_code_3'] : $row['d2_artwork_code_3'];
                                    $f_d2_artwork_code_4 = isset($_POST['d2_artwork_code_4']) && $_POST['d2_artwork_code_4'] !== $row['d2_artwork_code_4'] ? $_POST['d2_artwork_code_4'] : $row['d2_artwork_code_4'];
                                    $f_d2_artwork_code_5 = isset($_POST['d2_artwork_code_5']) && $_POST['d2_artwork_code_5'] !== $row['d2_artwork_code_5'] ? $_POST['d2_artwork_code_5'] : $row['d2_artwork_code_5'];
                                
                                    $f_d2_signature_planning_1 = !empty(trim($_POST['d2_sno_1'])) ? "Sign by $fullname" : '';
                                    $f_d2_signature_planning_2 = !empty(trim($_POST['d2_sno_2'])) ? "Sign by $fullname" : '';
                                    $f_d2_signature_planning_3 = !empty(trim($_POST['d2_sno_3'])) ? "Sign by $fullname" : '';
                                    $f_d2_signature_planning_4 = !empty(trim($_POST['d2_sno_4'])) ? "Sign by $fullname" : '';
                                    $f_d2_signature_planning_5 = !empty(trim($_POST['d2_sno_5'])) ? "Sign by $fullname" : '';
                                
                                    $f_d3_sno_1 = isset($_POST['d3_sno_1']) && $_POST['d3_sno_1'] !== $row['d3_sno_1'] ? $_POST['d3_sno_1'] : $row['d3_sno_1'];
                                    $f_d3_sno_2 = isset($_POST['d3_sno_2']) && $_POST['d3_sno_2'] !== $row['d3_sno_2'] ? $_POST['d3_sno_2'] : $row['d3_sno_2'];
                                    $f_d3_sno_3 = isset($_POST['d3_sno_3']) && $_POST['d3_sno_3'] !== $row['d3_sno_3'] ? $_POST['d3_sno_3'] : $row['d3_sno_3'];
                                    $f_d3_sno_4 = isset($_POST['d3_sno_4']) && $_POST['d3_sno_4'] !== $row['d3_sno_4'] ? $_POST['d3_sno_4'] : $row['d3_sno_4'];
                                    $f_d3_sno_5 = isset($_POST['d3_sno_5']) && $_POST['d3_sno_5'] !== $row['d3_sno_5'] ? $_POST['d3_sno_5'] : $row['d3_sno_5'];
                                
                                    $f_d3_material_code_1 = isset($_POST['d3_material_code_1']) && $_POST['d3_material_code_1'] !== $row['d3_material_code_1'] ? $_POST['d3_material_code_1'] : $row['d3_material_code_1'];
                                    $f_d3_material_code_2 = isset($_POST['d3_material_code_2']) && $_POST['d3_material_code_2'] !== $row['d3_material_code_2'] ? $_POST['d3_material_code_2'] : $row['d3_material_code_2'];
                                    $f_d3_material_code_3 = isset($_POST['d3_material_code_3']) && $_POST['d3_material_code_3'] !== $row['d3_material_code_3'] ? $_POST['d3_material_code_3'] : $row['d3_material_code_3'];
                                    $f_d3_material_code_4 = isset($_POST['d3_material_code_4']) && $_POST['d3_material_code_4'] !== $row['d3_material_code_4'] ? $_POST['d3_material_code_4'] : $row['d3_material_code_4'];
                                    $f_d3_material_code_5 = isset($_POST['d3_material_code_5']) && $_POST['d3_material_code_5'] !== $row['d3_material_code_5'] ? $_POST['d3_material_code_5'] : $row['d3_material_code_5'];
                                
                                    $f_d3_material_name_1 = isset($_POST['d3_material_name_1']) && $_POST['d3_material_name_1'] !== $row['d3_material_name_1'] ? $_POST['d3_material_name_1'] : $row['d3_material_name_1'];
                                    $f_d3_material_name_2 = isset($_POST['d3_material_name_2']) && $_POST['d3_material_name_2'] !== $row['d3_material_name_2'] ? $_POST['d3_material_name_2'] : $row['d3_material_name_2'];
                                    $f_d3_material_name_3 = isset($_POST['d3_material_name_3']) && $_POST['d3_material_name_3'] !== $row['d3_material_name_3'] ? $_POST['d3_material_name_3'] : $row['d3_material_name_3'];
                                    $f_d3_material_name_4 = isset($_POST['d3_material_name_4']) && $_POST['d3_material_name_4'] !== $row['d3_material_name_4'] ? $_POST['d3_material_name_4'] : $row['d3_material_name_4'];
                                    $f_d3_material_name_5 = isset($_POST['d3_material_name_5']) && $_POST['d3_material_name_5'] !== $row['d3_material_name_5'] ? $_POST['d3_material_name_5'] : $row['d3_material_name_5'];
                                
                                    $f_d3_quantity_1 = isset($_POST['d3_quantity_1']) && $_POST['d3_quantity_1'] !== $row['d3_quantity_1'] ? $_POST['d3_quantity_1'] : $row['d3_quantity_1'];
                                    $f_d3_quantity_2 = isset($_POST['d3_quantity_2']) && $_POST['d3_quantity_2'] !== $row['d3_quantity_2'] ? $_POST['d3_quantity_2'] : $row['d3_quantity_2'];
                                    $f_d3_quantity_3 = isset($_POST['d3_quantity_3']) && $_POST['d3_quantity_3'] !== $row['d3_quantity_3'] ? $_POST['d3_quantity_3'] : $row['d3_quantity_3'];
                                    $f_d3_quantity_4 = isset($_POST['d3_quantity_4']) && $_POST['d3_quantity_4'] !== $row['d3_quantity_4'] ? $_POST['d3_quantity_4'] : $row['d3_quantity_4'];
                                    $f_d3_quantity_5 = isset($_POST['d3_quantity_5']) && $_POST['d3_quantity_5'] !== $row['d3_quantity_5'] ? $_POST['d3_quantity_5'] : $row['d3_quantity_5'];
                                
                                    $f_d3_artwork_code_1 = isset($_POST['d3_artwork_code_1']) && $_POST['d3_artwork_code_1'] !== $row['d3_artwork_code_1'] ? $_POST['d3_artwork_code_1'] : $row['d3_artwork_code_1'];
                                    $f_d3_artwork_code_2 = isset($_POST['d3_artwork_code_2']) && $_POST['d3_artwork_code_2'] !== $row['d3_artwork_code_2'] ? $_POST['d3_artwork_code_2'] : $row['d3_artwork_code_2'];
                                    $f_d3_artwork_code_3 = isset($_POST['d3_artwork_code_3']) && $_POST['d3_artwork_code_3'] !== $row['d3_artwork_code_3'] ? $_POST['d3_artwork_code_3'] : $row['d3_artwork_code_3'];
                                    $f_d3_artwork_code_4 = isset($_POST['d3_artwork_code_4']) && $_POST['d3_artwork_code_4'] !== $row['d3_artwork_code_4'] ? $_POST['d3_artwork_code_4'] : $row['d3_artwork_code_4'];
                                    $f_d3_artwork_code_5 = isset($_POST['d3_artwork_code_5']) && $_POST['d3_artwork_code_5'] !== $row['d3_artwork_code_5'] ? $_POST['d3_artwork_code_5'] : $row['d3_artwork_code_5'];
                                
                                    $f_d3_batchno_1 = isset($_POST['d3_batchno_1']) && $_POST['d3_batchno_1'] !== $row['d3_batchno_1'] ? $_POST['d3_batchno_1'] : $row['d3_batchno_1'];
                                    $f_d3_batchno_2 = isset($_POST['d3_batchno_2']) && $_POST['d3_batchno_2'] !== $row['d3_batchno_2'] ? $_POST['d3_batchno_2'] : $row['d3_batchno_2'];
                                    $f_d3_batchno_3 = isset($_POST['d3_batchno_3']) && $_POST['d3_batchno_3'] !== $row['d3_batchno_3'] ? $_POST['d3_batchno_3'] : $row['d3_batchno_3'];
                                    $f_d3_batchno_4 = isset($_POST['d3_batchno_4']) && $_POST['d3_batchno_4'] !== $row['d3_batchno_4'] ? $_POST['d3_batchno_4'] : $row['d3_batchno_4'];
                                    $f_d3_batchno_5 = isset($_POST['d3_batchno_5']) && $_POST['d3_batchno_5'] !== $row['d3_batchno_5'] ? $_POST['d3_batchno_5'] : $row['d3_batchno_5'];
                                
                                    $f_d3_signature_planning_1 = !empty(trim($_POST['d3_sno_1'])) ? "Sign by $fullname" : '';
                                    $f_d3_signature_planning_2 = !empty(trim($_POST['d3_sno_2'])) ? "Sign by $fullname" : '';
                                    $f_d3_signature_planning_3 = !empty(trim($_POST['d3_sno_3'])) ? "Sign by $fullname" : '';
                                    $f_d3_signature_planning_4 = !empty(trim($_POST['d3_sno_4'])) ? "Sign by $fullname" : '';
                                    $f_d3_signature_planning_5 = !empty(trim($_POST['d3_sno_5'])) ? "Sign by $fullname" : '';
                                
                                    $f_date = date('Y-m-d');
                                
                                    $update_query = "UPDATE qc_ccrf SET 
                                
                                                    c_sno_1 = '$f_c_sno_1',
                                                    c_sno_2 = '$f_c_sno_2',
                                                    c_sno_3 = '$f_c_sno_3',
                                                    c_sno_4 = '$f_c_sno_4',
                                                    c_sno_5 = '$f_c_sno_5',
                                
                                                    c_material_code_1 = '$f_c_material_code_1',
                                                    c_material_code_2 = '$f_c_material_code_2',
                                                    c_material_code_3 = '$f_c_material_code_3',
                                                    c_material_code_4 = '$f_c_material_code_4',
                                                    c_material_code_5 = '$f_c_material_code_5',
                                
                                                    c_material_name_1 = '$f_c_material_name_1',
                                                    c_material_name_2 = '$f_c_material_name_2',
                                                    c_material_name_3 = '$f_c_material_name_3',
                                                    c_material_name_4 = '$f_c_material_name_4',
                                                    c_material_name_5 = '$f_c_material_name_5',
                                
                                                    c_released_qty_1 = '$f_c_released_qty_1',
                                                    c_released_qty_2 = '$f_c_released_qty_2',
                                                    c_released_qty_3 = '$f_c_released_qty_3',
                                                    c_released_qty_4 = '$f_c_released_qty_4',
                                                    c_released_qty_5 = '$f_c_released_qty_5',
                                
                                                    c_artwork_code_1 = '$f_c_artwork_code_1',
                                                    c_artwork_code_2 = '$f_c_artwork_code_2',
                                                    c_artwork_code_3 = '$f_c_artwork_code_3',
                                                    c_artwork_code_4 = '$f_c_artwork_code_4',
                                                    c_artwork_code_5 = '$f_c_artwork_code_5',
                                
                                                    c_quarantine_qty_1 = '$f_c_quarantine_qty_1',
                                                    c_quarantine_qty_2 = '$f_c_quarantine_qty_2',
                                                    c_quarantine_qty_3 = '$f_c_quarantine_qty_3',
                                                    c_quarantine_qty_4 = '$f_c_quarantine_qty_4',
                                                    c_quarantine_qty_5 = '$f_c_quarantine_qty_5',
                                
                                                    c_artwork_code2_1 = '$f_c_artwork_code2_1',
                                                    c_artwork_code2_2 = '$f_c_artwork_code2_2',
                                                    c_artwork_code2_3 = '$f_c_artwork_code2_3',
                                                    c_artwork_code2_4 = '$f_c_artwork_code2_4',
                                                    c_artwork_code2_5 = '$f_c_artwork_code2_5',
                                
                                                    c_signature_warehouse_1 = 'Sign By $fullname',
                                                    c_signature_warehouse_2 = '$f_c_signature_warehouse_2',
                                                    c_signature_warehouse_3 = '$f_c_signature_warehouse_3',
                                                    c_signature_warehouse_4 = '$f_c_signature_warehouse_4',
                                                    c_signature_warehouse_5 = '$f_c_signature_warehouse_5',
                                
                                                    c2_sno_1 = '$f_c2_sno_1',
                                                    c2_sno_2 = '$f_c2_sno_2',
                                                    c2_sno_3 = '$f_c2_sno_3',
                                                    c2_sno_4 = '$f_c2_sno_4',
                                                    c2_sno_5 = '$f_c2_sno_5',
                                
                                                    c2_material_code_1 = '$f_c2_material_code_1',
                                                    c2_material_code_2 = '$f_c2_material_code_2',
                                                    c2_material_code_3 = '$f_c2_material_code_3',
                                                    c2_material_code_4 = '$f_c2_material_code_4',
                                                    c2_material_code_5 = '$f_c2_material_code_5',
                                
                                                    c2_material_name_1 = '$f_c2_material_name_1',
                                                    c2_material_name_2 = '$f_c2_material_name_2',
                                                    c2_material_name_3 = '$f_c2_material_name_3',
                                                    c2_material_name_4 = '$f_c2_material_name_4',
                                                    c2_material_name_5 = '$f_c2_material_name_5',
                                
                                                    c2_quantity_1 = '$f_c2_quantity_1',
                                                    c2_quantity_2 = '$f_c2_quantity_2',
                                                    c2_quantity_3 = '$f_c2_quantity_3',
                                                    c2_quantity_4 = '$f_c2_quantity_4',
                                                    c2_quantity_5 = '$f_c2_quantity_5',
                                
                                                    c2_artwork_code_1 = '$f_c2_artwork_code_1',
                                                    c2_artwork_code_2 = '$f_c2_artwork_code_2',
                                                    c2_artwork_code_3 = '$f_c2_artwork_code_3',
                                                    c2_artwork_code_4 = '$f_c2_artwork_code_4',
                                                    c2_artwork_code_5 = '$f_c2_artwork_code_5',
                                
                                                    c2_expected_ddate_1 = '$f_c2_expected_ddate_1',
                                                    c2_expected_ddate_2 = '$f_c2_expected_ddate_2',
                                                    c2_expected_ddate_3 = '$f_c2_expected_ddate_3',
                                                    c2_expected_ddate_4 = '$f_c2_expected_ddate_4',
                                                    c2_expected_ddate_5 = '$f_c2_expected_ddate_5',
                                
                                                    c2_signature_pd_1 = '$f_c2_signature_pd_1',
                                                    c2_signature_pd_2 = '$f_c2_signature_pd_2',
                                                    c2_signature_pd_3 = '$f_c2_signature_pd_3',
                                                    c2_signature_pd_4 = '$f_c2_signature_pd_4',
                                                    c2_signature_pd_5 = '$f_c2_signature_pd_5',
                                
                                                    -- form 5
                                
                                                        d_sno_1 = '$f_d_sno_1',
                                                                   d_sno_2 = '$f_d_sno_2',
                                                                   d_sno_3 = '$f_d_sno_3',
                                                                   d_sno_4 = '$f_d_sno_4',
                                                                   d_sno_5 = '$f_d_sno_5',
                                           
                                                                   d_material_code_1 = '$f_d_material_code_1',
                                                                   d_material_code_2 = '$f_d_material_code_2',
                                                                   d_material_code_3 = '$f_d_material_code_3',
                                                                   d_material_code_4 = '$f_d_material_code_4',
                                                                   d_material_code_5 = '$f_d_material_code_5',
                                           
                                                                   d_material_name_1 = '$f_d_material_name_1',
                                                                   d_material_name_2 = '$f_d_material_name_2',
                                                                   d_material_name_3 = '$f_d_material_name_3',
                                                                   d_material_name_4 = '$f_d_material_name_4',
                                                                   d_material_name_5 = '$f_d_material_name_5',
                                
                                                                   d_quantity_1 = '$f_d_quantity_1',
                                                                   d_quantity_2 = '$f_d_quantity_2',
                                                                   d_quantity_3 = '$f_d_quantity_3',
                                                                   d_quantity_4 = '$f_d_quantity_4',
                                                                   d_quantity_5 = '$f_d_quantity_5',
                                
                                                                   d_artwork_code_1 = '$f_d_artwork_code_1',
                                                                   d_artwork_code_2 = '$f_d_artwork_code_2',
                                                                   d_artwork_code_3 = '$f_d_artwork_code_3',
                                                                   d_artwork_code_4 = '$f_d_artwork_code_4',
                                                                   d_artwork_code_5 = '$f_d_artwork_code_5',
                                
                                                                   d_expected_ddate_1 = '$f_d_expected_ddate_1',
                                                                   d_expected_ddate_2 = '$f_d_expected_ddate_2',
                                                                   d_expected_ddate_3 = '$f_d_expected_ddate_3',
                                                                   d_expected_ddate_4 = '$f_d_expected_ddate_4',
                                                                   d_expected_ddate_5 = '$f_d_expected_ddate_5',
                                
                                                                   d_signature_purchase_1 = '$f_d_signature_purchase_1',
                                                                   d_signature_purchase_2 = '$f_d_signature_purchase_2',
                                                                   d_signature_purchase_3 = '$f_d_signature_purchase_3',
                                                                   d_signature_purchase_4 = '$f_d_signature_purchase_4',
                                                                   d_signature_purchase_5 = '$f_d_signature_purchase_5',
                                
                                                                    d2_sno_1 = '$f_d2_sno_1',
                                                                    d2_sno_2 = '$f_d2_sno_2',
                                                                    d2_sno_3 = '$f_d2_sno_3',
                                                                    d2_sno_4 = '$f_d2_sno_4',
                                                                    d2_sno_5 = '$f_d2_sno_5',
                                
                                                                    d2_material_code_1 = '$f_d2_material_code_1',
                                                                    d2_material_code_2 = '$f_d2_material_code_2',
                                                                    d2_material_code_3 = '$f_d2_material_code_3',
                                                                    d2_material_code_4 = '$f_d2_material_code_4',
                                                                    d2_material_code_5 = '$f_d2_material_code_5',
                                
                                                                    d2_material_name_1 = '$f_d2_material_name_1',
                                                                    d2_material_name_2 = '$f_d2_material_name_2',
                                                                    d2_material_name_3 = '$f_d2_material_name_3',
                                                                    d2_material_name_4 = '$f_d2_material_name_4',
                                                                    d2_material_name_5 = '$f_d2_material_name_5',	
                                
                                                                    d2_quantity_1 = '$f_d2_quantity_1',
                                                                    d2_quantity_2 = '$f_d2_quantity_2',
                                                                    d2_quantity_3 = '$f_d2_quantity_3',
                                                                    d2_quantity_4 = '$f_d2_quantity_4',
                                                                    d2_quantity_5 = '$f_d2_quantity_5',
                                
                                                                    d2_artwork_code_1 = '$f_d2_artwork_code_1',
                                                                    d2_artwork_code_2 = '$f_d2_artwork_code_2',
                                                                    d2_artwork_code_3 = '$f_d2_artwork_code_3',
                                                                    d2_artwork_code_4 = '$f_d2_artwork_code_4',
                                                                    d2_artwork_code_5 = '$f_d2_artwork_code_5',
                                
                                                                    d2_signature_planning_1 = '$f_d2_signature_planning_1',
                                                                    d2_signature_planning_2 = '$f_d2_signature_planning_2',
                                                                    d2_signature_planning_3 = '$f_d2_signature_planning_3',
                                                                    d2_signature_planning_4 = '$f_d2_signature_planning_4',
                                                                    d2_signature_planning_5 = '$f_d2_signature_planning_5',
                                
                                                                    d3_sno_1 = '$f_d3_sno_1',
                                                                    d3_sno_2 = '$f_d3_sno_2',
                                                                    d3_sno_3 = '$f_d3_sno_3',
                                                                    d3_sno_4 = '$f_d3_sno_4',
                                                                    d3_sno_5 = '$f_d3_sno_5',
                                
                                                                    d3_material_code_1 = '$f_d3_material_code_1',
                                                                    d3_material_code_2 = '$f_d3_material_code_2',
                                                                    d3_material_code_3 = '$f_d3_material_code_3',
                                                                    d3_material_code_4 = '$f_d3_material_code_4',
                                                                    d3_material_code_5 = '$f_d3_material_code_5',
                                
                                                                    d3_material_name_1 = '$f_d3_material_name_1',
                                                                    d3_material_name_2 = '$f_d3_material_name_2',
                                                                    d3_material_name_3 = '$f_d3_material_name_3',
                                                                    d3_material_name_4 = '$f_d3_material_name_4',
                                                                    d3_material_name_5 = '$f_d3_material_name_5',
                                
                                                                    d3_quantity_1 = '$f_d3_quantity_1',
                                                                    d3_quantity_2 = '$f_d3_quantity_2',
                                                                    d3_quantity_3 = '$f_d3_quantity_3',
                                                                    d3_quantity_4 = '$f_d3_quantity_4',
                                                                    d3_quantity_5 = '$f_d3_quantity_5',
                                
                                                                    d3_artwork_code_1 = '$f_d3_artwork_code_1',
                                                                    d3_artwork_code_2 = '$f_d3_artwork_code_2',
                                                                    d3_artwork_code_3 = '$f_d3_artwork_code_3',
                                                                    d3_artwork_code_4 = '$f_d3_artwork_code_4',
                                                                    d3_artwork_code_5 = '$f_d3_artwork_code_5',
                                
                                                                    d3_batchno_1 = '$f_d3_batchno_1',
                                                                    d3_batchno_2 = '$f_d3_batchno_2',
                                                                    d3_batchno_3 = '$f_d3_batchno_3',
                                                                    d3_batchno_4 = '$f_d3_batchno_4',
                                                                    d3_batchno_5 = '$f_d3_batchno_5',
                                
                                                                    d3_signature_planning_1 = '$f_d3_signature_planning_1',
                                                                    d3_signature_planning_2 = '$f_d3_signature_planning_2',
                                                                    d3_signature_planning_3 = '$f_d3_signature_planning_3',
                                                                    d3_signature_planning_4 = '$f_d3_signature_planning_4',
                                                                    d3_signature_planning_5 = '$f_d3_signature_planning_5',
                                
                                
                                                                            -- form 6
                                                                     e_admin_1 = '$f_administration_input1',
                                                        e_admin_2 = '$f_administration_input2',
                                                        e_admin_3 = '$f_administration_input3',
                                
                                                        e_production_1 = '$f_production_input1',
                                                        e_production_2 = '$f_production_input2',
                                                        e_production_3 = '$f_production_input3',
                                
                                                        e_qa_1 = '$f_qa_input1',
                                                        e_qa_2 = '$f_qa_input2',
                                                        e_qa_3 = '$f_qa_input3',
                                
                                                        e_qc_1 = '$f_qc_input1',
                                                        e_qc_2 = '$f_qc_input2',
                                                        e_qc_3 = '$f_qc_input3',
                                
                                                        e_herb_1 = '$f_herb_warehouse_input1',
                                                        e_herb_2 = '$f_herb_warehouse_input2',
                                                        e_herb_3 = '$f_herb_warehouse_input3',
                                
                                                        e_chemical_1 = '$f_chemical_warehouse_input1',
                                                        e_chemical_2 = '$f_chemical_warehouse_input2',
                                                        e_chemical_3 = '$f_chemical_warehouse_input3',
                                
                                                        e_packing_1 = '$f_packing_warehouse_input1',
                                                        e_packing_2 = '$f_packing_warehouse_input2',
                                                        e_packing_3 = '$f_packing_warehouse_input3',
                                
                                                        e_finished_goods_1 = '$f_finished_goods_warehouse_input1',
                                                        e_finished_goods_2 = '$f_finished_goods_warehouse_input2',
                                                        e_finished_goods_3 = '$f_finished_goods_warehouse_input3',
                                
                                                        e_procurement_1 = '$f_procurement_input1',
                                                        e_procurement_2 = '$f_procurement_input2',
                                                        e_procurement_3 = '$f_procurement_input3',
                                
                                                        e_scm_1 = '$f_supply_chain_management_input1',
                                                        e_scm_2 = '$f_supply_chain_management_input2',
                                                        e_scm_3 = '$f_supply_chain_management_input3',
                                
                                                        e_finance_1 = '$f_finance_n_accounts_input1',
                                                        e_finance_2 = '$f_finance_n_accounts_input2',
                                                        e_finance_3 = '$f_finance_n_accounts_input3',
                                
                                                        e_bdd_1 = '$f_business_development_department_input1',
                                                        e_bdd_2 = '$f_business_development_department_input2',
                                                        e_bdd_3 = '$f_business_development_department_input3',
                                
                                                        e_marketing_1 = '$f_marketing_department_input1',
                                                        e_marketing_2 = '$f_marketing_department_input2',
                                                        e_marketing_3 = '$f_marketing_department_input3',
                                
                                                        e_rnd_1 = '$f_research_and_development_input1',
                                                        e_rnd_2 = '$f_research_and_development_input2',
                                                        e_rnd_3 = '$f_research_and_development_input3',
                                
                                                        e_regulatory_1 = '$f_regulatory_input1',
                                                        e_regulatory_2 = '$f_regulatory_input2',
                                                        e_regulatory_3 = '$f_regulatory_input3',
                                
                                                        e_engineering_1 = '$f_engineering_input1',
                                                        e_engineering_2 = '$f_engineering_input2',
                                                        e_engineering_3 = '$f_engineering_input3',
                                
                                                        e_microbiology_1 = '$f_microbiology_input1',
                                                        e_microbiology_2 = '$f_microbiology_input2',
                                                        e_microbiology_3 = '$f_microbiology_input3',
                                
                                                        e_hr_1 = '$f_human_resource_input1',
                                                        e_hr_2 = '$f_human_resource_input2',
                                                        e_hr_3 = '$f_human_resource_input3',
                                
                                                        e_it_1 = '$f_it_department_input1',
                                                        e_it_2 = '$f_it_department_input2',
                                                        e_it_3 = '$f_it_department_input3',
                                                        part_1 = 'Approved'
                                
                                                        WHERE id = '$id'";
                                
                                    // Execute update query
                                    $result = mysqli_query($conn, $update_query);
                                
                                    if ($result) {
                                        // Update successful
                                        echo "<script>alert('Record updated successfully!');
                                        window.location.href = 'cc_add_stock.php?id=" . $id . "';
                                        
                                        </script>";
                                        // Redirect or perform additional actions as needed
                                    } else {
                                        // Update failed
                                        echo "<script>alert('Update failed!');
                                        window.location.href = window.location.href;</script>";
                                        // Redirect or handle error as needed
                                    }
                                }
                                ?>
                            </div>
                            <!-- col -->
                            </div>
                            <!-- row -->
                        </div>
                        <!-- container-fluid -->
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
            } else {
            echo "No record found!";
            }
            ?>
        </div>
        </div>
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
                const checkboxes = document.querySelectorAll('.category-checkbox');
            
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkboxes = document.querySelectorAll('.type-checkbox');
            
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkboxes = document.querySelectorAll('.depart_type-checkbox');
            
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