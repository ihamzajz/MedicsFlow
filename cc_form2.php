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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Digital Form</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* =====================
   Base Styles
===================== */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f6fa;
        }

        p {
            font-size: 11.7px !important;
            font-weight: 500 !important;
            padding: 0 !important;
            margin: 0 10px 0 0 !important;
            display: inline !important;
        }

        /* =====================
   Cards & Layout
===================== */
        .card {
            border-radius: 10px;
        }

        .main-heading {
            font-size: 15px !important;
            font-weight: 600 !important;
        }

        .bg-menu {
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

        .btn-light {
            font-size: 13px;
            font-weight: 400;
        }

   

        /* =====================
   Tables
===================== */
        th {
            font-size: 11px !important;
            font-weight: 600 !important;
            background-color: #ced4da !important;
            color: black !important;
            border: none !important;
        }

        td {
            font-size: 11px !important;
            background-color: white !important;
            color: black !important;
            border: 1px solid grey !important;
            padding: 0 !important;
        }

        thead {
            border: 1px solid grey !important;
        }

        .table-1 td,
        .table-2 td,
        .table-3 td {
            padding: 7px 10px !important;
        }

        /* =====================
   Lists
===================== */
        .ul-msg li {
            font-size: 12px;
            font-weight: 500;
            padding-top: 10px;
        }

        /* =====================
   Inputs & Forms
===================== */
        input {
            width: 100% !important;
            height: 25px !important;
            font-size: 11.7px !important;
            padding: 5px !important;
            border: none !important;
            border-radius: 0 !important;
            letter-spacing: 0.4px !important;
            transition: border-color 0.3s ease !important;
        }

        input:focus {
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
        }

        input[type="checkbox"],
        label {
            padding: 0 !important;
            margin: 0 !important;
        }

        .cbox {
            width: 13px !important;
            height: 13px !important;
        }
    </style>

    <?php
    include 'sidebarcss.php'
    ?>

    <style>
        .readonly-box {
            width: 100%;
            min-height: 27px;
            padding: 6px 8px;
            /* add proper padding inside */
            font-size: 11px;
            white-space: pre-wrap;
            /* preserves line breaks */
            word-wrap: break-word;
            border: 1px solid #adb5bd;
            border-radius: 4px;
            background-color: #f8f9fa;
            text-align: left;
            line-height: 1.4;
            /* improves vertical spacing */
            overflow-wrap: break-word;
        }
    </style>
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
                            <div class="col-11">
                                <form class="form pb-3" method="POST">

                                    <div class="card shadow mt-3">
                                        <div class="card-header bg-dark text-white d-flex align-items-center">
                                            <h6 class="mb-0 main-heading"> Risk & Stock</h6>

                                            <div class="ms-auto">
                                                <a href="cc_home.php" class="btn btn-light btn-sm me-2">Home</a>
                                                <a href="cc_user_forms.php" class="btn btn-light btn-sm me-2">Back</a>

                                                <a href="cc_form3.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">
                                                    Consequences + Revision
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body">



                                            <?php if ($be_depart == 'it' or $be_depart == 'qaqc' or $be_depart == 'super') { ?>
                                                <h6 class="" style="font-weight: bolder;font-size:13.5px">RISK ASSESSMENT</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-responsive table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Risk Item No</th>
                                                                <th>Potential Failure Mode (Hazard or Hazard Situation)</th>
                                                                <th>Potential Effect of failure (Harm)</th>
                                                                <th>Severity (S)</th>
                                                                <th>Potential Cause / Mechanism of Failure</th>
                                                                <th>Occurence/Probablility (O)</th>
                                                                <th>Current Control</th>
                                                                <th>Dectection (D)</th>
                                                                <th>RPN (SXOXD)</th>
                                                                <th>Recommended Action (s)</th>
                                                                <th>Severity (s)</th>
                                                                <th>Occurence /</th>
                                                                <th>Detection (D)</th>
                                                                <th>RPN (SXOXD)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <textarea
                                                                        style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"
                                                                        name="b_risk_item_no"><?php echo htmlspecialchars($row['b_risk_item_no']); ?></textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea
                                                                        style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"
                                                                        name="b_potential_failure_mode"><?php echo htmlspecialchars($row['b_potential_failure_mode']); ?></textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea
                                                                        style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"
                                                                        name="b_potential_effect"><?php echo htmlspecialchars($row['b_potential_effect']); ?></textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea
                                                                        style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"
                                                                        name="b_severity1"><?php echo htmlspecialchars($row['b_severity1']); ?></textarea>
                                                                </td>

                                                                <td>
                                                                    <textarea
                                                                        style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"
                                                                        name="b_potential_cause"><?php echo htmlspecialchars($row['b_potential_cause']); ?></textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea
                                                                        style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"
                                                                        name="b_occurence_probablility"><?php echo htmlspecialchars($row['b_occurence_probablility']); ?></textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea
                                                                        style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"
                                                                        name="b_current_control"><?php echo htmlspecialchars($row['b_current_control']); ?></textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea
                                                                        style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"
                                                                        name="b_dectection1"><?php echo htmlspecialchars($row['b_dectection1']); ?></textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea
                                                                        style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"
                                                                        name="b_rpn1"><?php echo htmlspecialchars($row['b_rpn1']); ?></textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea
                                                                        style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"
                                                                        name="b_recommended_action"><?php echo htmlspecialchars($row['b_recommended_action']); ?></textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea
                                                                        style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"
                                                                        name="b_severity2"><?php echo htmlspecialchars($row['b_severity2']); ?></textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea
                                                                        style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"
                                                                        name="b_occurence"><?php echo htmlspecialchars($row['b_occurence']); ?></textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea
                                                                        style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"
                                                                        name="b_detection2"><?php echo htmlspecialchars($row['b_detection2']); ?></textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea
                                                                        style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"
                                                                        name="b_rpn2"><?php echo htmlspecialchars($row['b_rpn2']); ?></textarea>
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>






                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div
                                                                style="border: 1px solid black; padding: 25px; padding-bottom: 0px; border-radius: 2px;background-color:white!important;margin-top:15px">
                                                                <h6 class="" style="font-weight: bolder;font-size:13.5px">To CALCULATE "RISK
                                                                    PRIORITIZATION NUMBER (or) RPN":</h6>
                                                                <p style="font-size:12.5px!important" class="">RPN is calculated by
                                                                    multiplying Probablility (P) , Delectablity (D)
                                                                    and severity (S), which are individually categorized and scored as
                                                                    described below in Table
                                                                </p>

                                                                <!-- table 1 -->
                                                                <table class="table table-responsive mt-3 table-1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Probablility / Occurrenece</th>
                                                                            <th>P / O (*)</th>
                                                                            <th>Description</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Extremely low</td>
                                                                            <td>2</td>
                                                                            <td>Highly improbable to occue</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>Low</td>
                                                                            <td>4</td>
                                                                            <td>Improbable to occur</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>Moderate</td>
                                                                            <td>6</td>
                                                                            <td>Probable to occur</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>High</td>
                                                                            <td>8</td>
                                                                            <td>High probable to occur</td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table>

                                                                <!-- table 2 -->
                                                                <table class="table table-2">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Detectability</th>
                                                                            <th>D (*)</th>
                                                                            <th>Description</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Hight</td>
                                                                            <td>2</td>
                                                                            <td>Control system in place has a high probability of detecting
                                                                                the defect or
                                                                                its effects.</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>Moderate</td>
                                                                            <td>4</td>
                                                                            <td>Control system in place could detect the defect or its
                                                                                effects.
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>Low</td>
                                                                            <td>6</td>
                                                                            <td>Control system in place has a low probability of detecting
                                                                                the defect or
                                                                                its effects</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Non existent</td>
                                                                            <td>8</td>
                                                                            <td>There is no control system to detect the defect</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                                <!-- table 3 -->
                                                                <table class="table table-3">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Severity </th>
                                                                            <th>S (*)</th>
                                                                            <th>Description</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Low</td>
                                                                            <td>2</td>
                                                                            <td>Minor GMP non-compliance; no possible impact on Patient,
                                                                                yield or on
                                                                                production capability</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Moderate</td>
                                                                            <td>4</td>
                                                                            <td>Significant GMP non-compliance; possible impact on patient;
                                                                                moderate
                                                                                impact on yield or production capability</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>High</td>
                                                                            <td>6</td>
                                                                            <td>Major GMP non-compliance; probable impact on patient; high
                                                                                impact on
                                                                                yield or production Capability.</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>Critical</td>
                                                                            <td>54</td>
                                                                            <td>Serious GMP non-compliance; Probable serious harm or death;
                                                                                critical
                                                                                impact on yield or production capability</td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table>

                                                                <div class="pr-5 pt-3">
                                                                    <p style="font-size:12.5px!important">The scoring should be assigned in
                                                                        an objective well justified manner as applicable by the FMEA
                                                                        team, which should be carefully selected based on scientific
                                                                        background, product knowledge and
                                                                        experience. Possible interpretation of the RPN used to categorize:
                                                                    </p>
                                                                    <ul class="ul-msg">
                                                                        <li>Critical if RPN value > 216</li>
                                                                        <li>Major if RPN value > 40 and < 216</li>
                                                                        <li>Minor if RPN value < 40 </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php } ?>
                                            <?php if ($be_depart == 'it' or $be_depart == 'qaqc' or $be_depart == 'sc' or $be_depart == 'super') { ?>


                                                <!-- form 4 -->
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <td colspan="8" class="py-1 pl-1">
                                                                    <p>In-Hand Stock Status</p>
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
                                                            <tr>
                                                                <td><input type="text" name="c_sno_1"
                                                                        value="<?php echo $row['c_sno_1']; ?>"></td>
                                                                <td><input type="text" name="c_material_code_1"
                                                                        value="<?php echo $row['c_material_code_1']; ?>"></td>
                                                                <td><input type="text" name="c_material_name_1"
                                                                        value="<?php echo $row['c_material_name_1']; ?>"></td>
                                                                <td><input type="text" name="c_released_qty_1"
                                                                        value="<?php echo $row['c_released_qty_1']; ?>"></td>
                                                                <td><input type="text" name="c_artwork_code_1"
                                                                        value="<?php echo $row['c_artwork_code_1']; ?>"></td>
                                                                <td><input type="text" name="c_quarantine_qty_1"
                                                                        value="<?php echo $row['c_quarantine_qty_1']; ?>"></td>
                                                                <td><input type="text" name="c_artwork_code2_1"
                                                                        value="<?php echo $row['c_artwork_code2_1']; ?>"></td>
                                                                <td><input type="text" name="c_signature_warehouse_1"
                                                                        value="<?php echo $row['c_signature_warehouse_1']; ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="text" name="c_sno_2"
                                                                        value="<?php echo $row['c_sno_2']; ?>"></td>
                                                                <td><input type="text" name="c_material_code_2"
                                                                        value="<?php echo $row['c_material_code_2']; ?>"></td>
                                                                <td><input type="text" name="c_material_name_2"
                                                                        value="<?php echo $row['c_material_name_2']; ?>"></td>
                                                                <td><input type="text" name="c_released_qty_2"
                                                                        value="<?php echo $row['c_released_qty_2']; ?>"></td>
                                                                <td><input type="text" name="c_artwork_code_2"
                                                                        value="<?php echo $row['c_artwork_code_2']; ?>"></td>
                                                                <td><input type="text" name="c_quarantine_qty_2"
                                                                        value="<?php echo $row['c_quarantine_qty_2']; ?>"></td>
                                                                <td><input type="text" name="c_artwork_code2_2"
                                                                        value="<?php echo $row['c_artwork_code2_2']; ?>"></td>
                                                                <td><input type="text" name="c_signature_warehouse_2"
                                                                        value="<?php echo $row['c_signature_warehouse_2']; ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="text" name="c_sno_3"
                                                                        value="<?php echo $row['c_sno_3']; ?>"></td>
                                                                <td><input type="text" name="c_material_code_3"
                                                                        value="<?php echo $row['c_material_code_3']; ?>"></td>
                                                                <td><input type="text" name="c_material_name_3"
                                                                        value="<?php echo $row['c_material_name_3']; ?>"></td>
                                                                <td><input type="text" name="c_released_qty_3"
                                                                        value="<?php echo $row['c_released_qty_3']; ?>"></td>
                                                                <td><input type="text" name="c_artwork_code_3"
                                                                        value="<?php echo $row['c_artwork_code_3']; ?>"></td>
                                                                <td><input type="text" name="c_quarantine_qty_3"
                                                                        value="<?php echo $row['c_quarantine_qty_3']; ?>"></td>
                                                                <td><input type="text" name="c_artwork_code2_3"
                                                                        value="<?php echo $row['c_artwork_code2_3']; ?>"></td>
                                                                <td><input type="text" name="c_signature_warehouse_3"
                                                                        value="<?php echo $row['c_signature_warehouse_3']; ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="text" name="c_sno_4"
                                                                        value="<?php echo $row['c_sno_4']; ?>"></td>
                                                                <td><input type="text" name="c_material_code_4"
                                                                        value="<?php echo $row['c_material_code_4']; ?>"></td>
                                                                <td><input type="text" name="c_material_name_4"
                                                                        value="<?php echo $row['c_material_name_4']; ?>"></td>
                                                                <td><input type="text" name="c_released_qty_4"
                                                                        value="<?php echo $row['c_released_qty_4']; ?>"></td>
                                                                <td><input type="text" name="c_artwork_code_4"
                                                                        value="<?php echo $row['c_artwork_code_4']; ?>"></td>
                                                                <td><input type="text" name="c_quarantine_qty_4"
                                                                        value="<?php echo $row['c_quarantine_qty_4']; ?>"></td>
                                                                <td><input type="text" name="c_artwork_code2_4"
                                                                        value="<?php echo $row['c_artwork_code2_4']; ?>"></td>
                                                                <td><input type="text" name="c_signature_warehouse_4"
                                                                        value="<?php echo $row['c_signature_warehouse_4']; ?>"></td>
                                                            </tr>

                                                            <tr>
                                                                <td><input type="text" name="c_sno_5"
                                                                        value="<?php echo $row['c_sno_5']; ?>"></td>
                                                                <td><input type="text" name="c_material_code_5"
                                                                        value="<?php echo $row['c_material_code_5']; ?>"></td>
                                                                <td><input type="text" name="c_material_name_5"
                                                                        value="<?php echo $row['c_material_name_5']; ?>"></td>
                                                                <td><input type="text" name="c_released_qty_5"
                                                                        value="<?php echo $row['c_released_qty_5']; ?>"></td>
                                                                <td><input type="text" name="c_artwork_code_5"
                                                                        value="<?php echo $row['c_artwork_code_5']; ?>"></td>
                                                                <td><input type="text" name="c_quarantine_qty_5"
                                                                        value="<?php echo $row['c_quarantine_qty_5']; ?>"></td>
                                                                <td><input type="text" name="c_artwork_code2_5"
                                                                        value="<?php echo $row['c_artwork_code2_5']; ?>"></td>
                                                                <td><input type="text" name="c_signature_warehouse_5"
                                                                        value="<?php echo $row['c_signature_warehouse_5']; ?>"></td>
                                                            </tr>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="7" class="py-1 pl-1">
                                                                    <p> On-Order Quality</p>
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
                                                            <tr>
                                                                <td><input type="text" name="c2_sno_1"
                                                                        value="<?php echo $row['c2_sno_1']; ?>"></td>
                                                                <td><input type="text" name="c2_material_code_1"
                                                                        value="<?php echo $row['c2_material_code_1']; ?>"></td>
                                                                <td><input type="text" name="c2_material_name_1"
                                                                        value="<?php echo $row['c2_material_name_1']; ?>"></td>
                                                                <td><input type="text" name="c2_quantity_1"
                                                                        value="<?php echo $row['c2_quantity_1']; ?>"></td>
                                                                <td><input type="text" name="c2_artwork_code_1"
                                                                        value="<?php echo $row['c2_artwork_code_1']; ?>"></td>
                                                                <td><input type="text" name="c2_expected_ddate_1"
                                                                        value="<?php echo $row['c2_expected_ddate_1']; ?>"></td>
                                                                <td colspan="2"><input type="text" name="c2_signature_pd_1"
                                                                        value="<?php echo $row['c2_signature_pd_1']; ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="text" name="c2_sno_2"
                                                                        value="<?php echo $row['c2_sno_2']; ?>"></td>
                                                                <td><input type="text" name="c2_material_code_2"
                                                                        value="<?php echo $row['c2_material_code_2']; ?>"></td>
                                                                <td><input type="text" name="c2_material_name_2"
                                                                        value="<?php echo $row['c2_material_name_2']; ?>"></td>
                                                                <td><input type="text" name="c2_quantity_2"
                                                                        value="<?php echo $row['c2_quantity_2']; ?>"></td>
                                                                <td><input type="text" name="c2_artwork_code_2"
                                                                        value="<?php echo $row['c2_artwork_code_2']; ?>"></td>
                                                                <td><input type="text" name="c2_expected_ddate_2"
                                                                        value="<?php echo $row['c2_expected_ddate_2']; ?>"></td>
                                                                <td colspan="2"><input type="text" name="c2_signature_pd_2"
                                                                        value="<?php echo $row['c2_signature_pd_2']; ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="text" name="c2_sno_3"
                                                                        value="<?php echo $row['c2_sno_3']; ?>"></td>
                                                                <td><input type="text" name="c2_material_code_3"
                                                                        value="<?php echo $row['c2_material_code_3']; ?>"></td>
                                                                <td><input type="text" name="c2_material_name_3"
                                                                        value="<?php echo $row['c2_material_name_3']; ?>"></td>
                                                                <td><input type="text" name="c2_quantity_3"
                                                                        value="<?php echo $row['c2_quantity_3']; ?>"></td>
                                                                <td><input type="text" name="c2_artwork_code_3"
                                                                        value="<?php echo $row['c2_artwork_code_3']; ?>"></td>
                                                                <td><input type="text" name="c2_expected_ddate_3"
                                                                        value="<?php echo $row['c2_expected_ddate_3']; ?>"></td>
                                                                <td colspan="2"><input type="text" name="c2_signature_pd_3"
                                                                        value="<?php echo $row['c2_signature_pd_3']; ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="text" name="c2_sno_4"
                                                                        value="<?php echo $row['c2_sno_4']; ?>"></td>
                                                                <td><input type="text" name="c2_material_code_4"
                                                                        value="<?php echo $row['c2_material_code_4']; ?>"></td>
                                                                <td><input type="text" name="c2_material_name_4"
                                                                        value="<?php echo $row['c2_material_name_4']; ?>"></td>
                                                                <td><input type="text" name="c2_quantity_4"
                                                                        value="<?php echo $row['c2_quantity_4']; ?>"></td>
                                                                <td><input type="text" name="c2_artwork_code_4"
                                                                        value="<?php echo $row['c2_artwork_code_4']; ?>"></td>
                                                                <td><input type="text" name="c2_expected_ddate_4"
                                                                        value="<?php echo $row['c2_expected_ddate_4']; ?>"></td>
                                                                <td colspan="2"><input type="text" name="c2_signature_pd_4"
                                                                        value="<?php echo $row['c2_signature_pd_4']; ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="text" name="c2_sno_5"
                                                                        value="<?php echo $row['c2_sno_5']; ?>"></td>
                                                                <td><input type="text" name="c2_material_code_5"
                                                                        value="<?php echo $row['c2_material_code_5']; ?>"></td>
                                                                <td><input type="text" name="c2_material_name_5"
                                                                        value="<?php echo $row['c2_material_name_5']; ?>"></td>
                                                                <td><input type="text" name="c2_quantity_5"
                                                                        value="<?php echo $row['c2_quantity_5']; ?>"></td>
                                                                <td><input type="text" name="c2_artwork_code_5"
                                                                        value="<?php echo $row['c2_artwork_code_5']; ?>"></td>
                                                                <td><input type="text" name="c2_expected_ddate_5"
                                                                        value="<?php echo $row['c2_expected_ddate_5']; ?>"></td>
                                                                <td colspan="2"><input type="text" name="c2_signature_pd_5"
                                                                        value="<?php echo $row['c2_signature_pd_5']; ?>"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>


                                                <!-- form 5 -->
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="8" class="py-1 pl-1">
                                                                <p>Detail regarding additional order (along with code no.) to be placed (if
                                                                    any)</p>
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
                                                            <td><input type="text" name="d_sno_1" value="<?php echo $row['d_sno_1']; ?>">
                                                            </td>
                                                            <td><input type="text" name="d_material_code_1"
                                                                    value="<?php echo $row['d_material_code_1']; ?>"></td>
                                                            <td><input type="text" name="d_material_name_1"
                                                                    value="<?php echo $row['d_material_name_1']; ?>"></td>
                                                            <td><input type="text" name="d_quantity_1"
                                                                    value="<?php echo $row['d_quantity_1']; ?>"></td>
                                                            <td><input type="text" name="d_artwork_code_1"
                                                                    value="<?php echo $row['d_artwork_code_1']; ?>"></td>
                                                            <td><input type="text" name="d_expected_ddate_1"
                                                                    value="<?php echo $row['d_expected_ddate_1']; ?>"></td>
                                                            <td><input type="text" name="d_signature_purchase_1"
                                                                    value="<?php echo $row['d_signature_purchase_1']; ?>"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text" name="d_sno_2" value="<?php echo $row['d_sno_2']; ?>">
                                                            </td>
                                                            <td><input type="text" name="d_material_code_2"
                                                                    value="<?php echo $row['d_material_code_2']; ?>"></td>
                                                            <td><input type="text" name="d_material_name_2"
                                                                    value="<?php echo $row['d_material_name_2']; ?>"></td>
                                                            <td><input type="text" name="d_quantity_2"
                                                                    value="<?php echo $row['d_quantity_2']; ?>"></td>
                                                            <td><input type="text" name="d_artwork_code_2"
                                                                    value="<?php echo $row['d_artwork_code_2']; ?>"></td>
                                                            <td><input type="text" name="d_expected_ddate_2"
                                                                    value="<?php echo $row['d_expected_ddate_2']; ?>"></td>
                                                            <td><input type="text" name="d_signature_purchase_2"
                                                                    value="<?php echo $row['d_signature_purchase_2']; ?>"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text" name="d_sno_3" value="<?php echo $row['d_sno_3']; ?>">
                                                            </td>
                                                            <td><input type="text" name="d_material_code_3"
                                                                    value="<?php echo $row['d_material_code_3']; ?>"></td>
                                                            <td><input type="text" name="d_material_name_3"
                                                                    value="<?php echo $row['d_material_name_3']; ?>"></td>
                                                            <td><input type="text" name="d_quantity_3"
                                                                    value="<?php echo $row['d_quantity_3']; ?>"></td>
                                                            <td><input type="text" name="d_artwork_code_3"
                                                                    value="<?php echo $row['d_artwork_code_3']; ?>"></td>
                                                            <td><input type="text" name="d_expected_ddate_3"
                                                                    value="<?php echo $row['d_expected_ddate_3']; ?>"></td>
                                                            <td><input type="text" name="d_signature_purchase_3"
                                                                    value="<?php echo $row['d_signature_purchase_3']; ?>"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text" name="d_sno_4" value="<?php echo $row['d_sno_4']; ?>">
                                                            </td>
                                                            <td><input type="text" name="d_material_code_4"
                                                                    value="<?php echo $row['d_material_code_4']; ?>"></td>
                                                            <td><input type="text" name="d_material_name_4"
                                                                    value="<?php echo $row['d_material_name_4']; ?>"></td>
                                                            <td><input type="text" name="d_quantity_4"
                                                                    value="<?php echo $row['d_quantity_4']; ?>"></td>
                                                            <td><input type="text" name="d_artwork_code_4"
                                                                    value="<?php echo $row['d_artwork_code_4']; ?>"></td>
                                                            <td><input type="text" name="d_expected_ddate_4"
                                                                    value="<?php echo $row['d_expected_ddate_4']; ?>"></td>
                                                            <td><input type="text" name="d_signature_purchase_4"
                                                                    value="<?php echo $row['d_signature_purchase_4']; ?>"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text" name="d_sno_5" value="<?php echo $row['d_sno_5']; ?>">
                                                            </td>
                                                            <td><input type="text" name="d_material_code_5"
                                                                    value="<?php echo $row['d_material_code_5']; ?>"></td>
                                                            <td><input type="text" name="d_material_name_5"
                                                                    value="<?php echo $row['d_material_name_5']; ?>"></td>
                                                            <td><input type="text" name="d_quantity_5"
                                                                    value="<?php echo $row['d_quantity_5']; ?>"></td>
                                                            <td><input type="text" name="d_artwork_code_5"
                                                                    value="<?php echo $row['d_artwork_code_5']; ?>"></td>
                                                            <td><input type="text" name="d_expected_ddate_5"
                                                                    value="<?php echo $row['d_expected_ddate_5']; ?>"></td>
                                                            <td><input type="text" name="d_signature_purchase_5"
                                                                    value="<?php echo $row['d_signature_purchase_5']; ?>"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>







                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="6" class="py-1 pl-1">
                                                                <p>Material to be destroyed (if any)</p>
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
                                                            <td><input type="text" name="d2_sno_1" value="<?php echo $row['d2_sno_1']; ?>">
                                                            </td>
                                                            <td><input type="text" name="d2_material_code_1"
                                                                    value="<?php echo $row['d2_material_code_1']; ?>"></td>
                                                            <td><input type="text" name="d2_material_name_1"
                                                                    value="<?php echo $row['d2_material_name_1']; ?>"></td>
                                                            <td><input type="text" name="d2_quantity_1"
                                                                    value="<?php echo $row['d2_quantity_1']; ?>"></td>
                                                            <td><input type="text" name="d2_artwork_code_1"
                                                                    value="<?php echo $row['d2_artwork_code_1']; ?>"></td>
                                                            <td><input type="text" name="d2_signature_planning_1"
                                                                    value="<?php echo $row['d2_signature_planning_1']; ?>"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text" name="d2_sno_2" value="<?php echo $row['d2_sno_2']; ?>">
                                                            </td>
                                                            <td><input type="text" name="d2_material_code_2"
                                                                    value="<?php echo $row['d2_material_code_2']; ?>"></td>
                                                            <td><input type="text" name="d2_material_name_2"
                                                                    value="<?php echo $row['d2_material_name_2']; ?>"></td>
                                                            <td><input type="text" name="d2_quantity_2"
                                                                    value="<?php echo $row['d2_quantity_2']; ?>"></td>
                                                            <td><input type="text" name="d2_artwork_code_2"
                                                                    value="<?php echo $row['d2_artwork_code_2']; ?>"></td>
                                                            <td><input type="text" name="d2_signature_planning_2"
                                                                    value="<?php echo $row['d2_signature_planning_2']; ?>"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text" name="d2_sno_3" value="<?php echo $row['d2_sno_3']; ?>">
                                                            </td>
                                                            <td><input type="text" name="d2_material_code_3"
                                                                    value="<?php echo $row['d2_material_code_3']; ?>"></td>
                                                            <td><input type="text" name="d2_material_name_3"
                                                                    value="<?php echo $row['d2_material_name_3']; ?>"></td>
                                                            <td><input type="text" name="d2_quantity_3"
                                                                    value="<?php echo $row['d2_quantity_3']; ?>"></td>
                                                            <td><input type="text" name="d2_artwork_code_3"
                                                                    value="<?php echo $row['d2_artwork_code_3']; ?>"></td>
                                                            <td><input type="text" name="d2_signature_planning_3"
                                                                    value="<?php echo $row['d2_signature_planning_3']; ?>"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text" name="d2_sno_4" value="<?php echo $row['d2_sno_4']; ?>">
                                                            </td>
                                                            <td><input type="text" name="d2_material_code_4"
                                                                    value="<?php echo $row['d2_material_code_4']; ?>"></td>
                                                            <td><input type="text" name="d2_material_name_4"
                                                                    value="<?php echo $row['d2_material_name_4']; ?>"></td>
                                                            <td><input type="text" name="d2_quantity_4"
                                                                    value="<?php echo $row['d2_quantity_4']; ?>"></td>
                                                            <td><input type="text" name="d2_artwork_code_4"
                                                                    value="<?php echo $row['d2_artwork_code_4']; ?>"></td>
                                                            <td><input type="text" name="d2_signature_planning_4"
                                                                    value="<?php echo $row['d2_signature_planning_4']; ?>"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text" name="d2_sno_5" value="<?php echo $row['d2_sno_5']; ?>">
                                                            </td>
                                                            <td><input type="text" name="d2_material_code_5"
                                                                    value="<?php echo $row['d2_material_code_5']; ?>"></td>
                                                            <td><input type="text" name="d2_material_name_5"
                                                                    value="<?php echo $row['d2_material_name_5']; ?>"></td>
                                                            <td><input type="text" name="d2_quantity_5"
                                                                    value="<?php echo $row['d2_quantity_5']; ?>"></td>
                                                            <td><input type="text" name="d2_artwork_code_5"
                                                                    value="<?php echo $row['d2_artwork_code_5']; ?>"></td>
                                                            <td><input type="text" name="d2_signature_planning_5"
                                                                    value="<?php echo $row['d2_signature_planning_5']; ?>"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>



                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="8" class="py-1 pl-1">
                                                                <p>No. if batches to be produced with old inventory as per following details
                                                                </p>
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
                                                            <td><input type="text" name="d3_sno_1" value="<?php echo $row['d3_sno_1']; ?>">
                                                            </td>
                                                            <td><input type="text" name="d3_material_code_1"
                                                                    value="<?php echo $row['d3_material_code_1']; ?>"></td>
                                                            <td><input type="text" name="d3_material_name_1"
                                                                    value="<?php echo $row['d3_material_name_1']; ?>"></td>
                                                            <td><input type="text" name="d3_quantity_1"
                                                                    value="<?php echo $row['d3_quantity_1']; ?>"></td>
                                                            <td><input type="text" name="d3_artwork_code_1"
                                                                    value="<?php echo $row['d3_artwork_code_1']; ?>"></td>
                                                            <td><input type="text" name="d3_batchno_1"
                                                                    value="<?php echo $row['d3_batchno_1']; ?>"></td>
                                                            <td><input type="text" name="d3_signature_planning_1"
                                                                    value="<?php echo $row['d3_signature_planning_1']; ?>"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text" name="d3_sno_2" value="<?php echo $row['d3_sno_2']; ?>">
                                                            </td>
                                                            <td><input type="text" name="d3_material_code_2"
                                                                    value="<?php echo $row['d3_material_code_2']; ?>"></td>
                                                            <td><input type="text" name="d3_material_name_2"
                                                                    value="<?php echo $row['d3_material_name_2']; ?>"></td>
                                                            <td><input type="text" name="d3_quantity_2"
                                                                    value="<?php echo $row['d3_quantity_2']; ?>"></td>
                                                            <td><input type="text" name="d3_artwork_code_2"
                                                                    value="<?php echo $row['d3_artwork_code_2']; ?>"></td>
                                                            <td><input type="text" name="d3_batchno_2"
                                                                    value="<?php echo $row['d3_batchno_2']; ?>"></td>
                                                            <td><input type="text" name="d3_signature_planning_2"
                                                                    value="<?php echo $row['d3_signature_planning_2']; ?>"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text" name="d3_sno_3" value="<?php echo $row['d3_sno_3']; ?>">
                                                            </td>
                                                            <td><input type="text" name="d3_material_code_3"
                                                                    value="<?php echo $row['d3_material_code_3']; ?>"></td>
                                                            <td><input type="text" name="d3_material_name_3"
                                                                    value="<?php echo $row['d3_material_name_3']; ?>"></td>
                                                            <td><input type="text" name="d3_quantity_3"
                                                                    value="<?php echo $row['d3_quantity_3']; ?>"></td>
                                                            <td><input type="text" name="d3_artwork_code_3"
                                                                    value="<?php echo $row['d3_artwork_code_3']; ?>"></td>
                                                            <td><input type="text" name="d3_batchno_3"
                                                                    value="<?php echo $row['d3_batchno_3']; ?>"></td>
                                                            <td><input type="text" name="d3_signature_planning_3"
                                                                    value="<?php echo $row['d3_signature_planning_3']; ?>"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text" name="d3_sno_4" value="<?php echo $row['d3_sno_4']; ?>">
                                                            </td>
                                                            <td><input type="text" name="d3_material_code_4"
                                                                    value="<?php echo $row['d3_material_code_4']; ?>"></td>
                                                            <td><input type="text" name="d3_material_name_4"
                                                                    value="<?php echo $row['d3_material_name_4']; ?>"></td>
                                                            <td><input type="text" name="d3_quantity_4"
                                                                    value="<?php echo $row['d3_quantity_4']; ?>"></td>
                                                            <td><input type="text" name="d3_artwork_code_4"
                                                                    value="<?php echo $row['d3_artwork_code_4']; ?>"></td>
                                                            <td><input type="text" name="d3_batchno_4"
                                                                    value="<?php echo $row['d3_batchno_4']; ?>"></td>
                                                            <td><input type="text" name="d3_signature_planning_4"
                                                                    value="<?php echo $row['d3_signature_planning_4']; ?>"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text" name="d3_sno_5" value="<?php echo $row['d3_sno_5']; ?>">
                                                            </td>
                                                            <td><input type="text" name="d3_material_code_5"
                                                                    value="<?php echo $row['d3_material_code_5']; ?>"></td>
                                                            <td><input type="text" name="d3_material_name_5"
                                                                    value="<?php echo $row['d3_material_name_5']; ?>"></td>
                                                            <td><input type="text" name="d3_quantity_5"
                                                                    value="<?php echo $row['d3_quantity_5']; ?>"></td>
                                                            <td><input type="text" name="d3_artwork_code_5"
                                                                    value="<?php echo $row['d3_artwork_code_5']; ?>"></td>
                                                            <td><input type="text" name="d3_batchno_4"
                                                                    value="<?php echo $row['d3_batchno_5']; ?>"></td>
                                                            <td><input type="text" name="d3_signature_planning_5"
                                                                    value="<?php echo $row['d3_signature_planning_5']; ?>"></td>
                                                        </tr>

                                                    <?php } ?>
                                                    </tbody>
                                                </table>

                                                <tr>
                                                    <!-- <button type="submit" class="btn btn-submit" name="submit"
                                            style="font-size: 20px">Submit</button> -->

                                                    <div class="text-center mt-4">
                                                        <button type="submit" name="submit" class="btn btn-dark px-4" style="font-size: 14px!important">
                                                            Update
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
                                    $name = $_SESSION['fullname'];

                                    $f_b_risk_item_no = isset($_POST['b_risk_item_no']) && $_POST['b_risk_item_no'] !== $row['b_risk_item_no'] ? $_POST['b_risk_item_no'] : $row['b_risk_item_no'];
                                    $f_b_potential_failure_mode = isset($_POST['b_potential_failure_mode']) && $_POST['b_potential_failure_mode'] !== $row['b_potential_failure_mode'] ? $_POST['b_potential_failure_mode'] : $row['b_potential_failure_mode'];
                                    $f_b_potential_effect = isset($_POST['b_potential_effect']) && $_POST['b_potential_effect'] !== $row['b_potential_effect'] ? $_POST['b_potential_effect'] : $row['b_potential_effect'];
                                    $f_b_severity1 = isset($_POST['b_severity1']) && $_POST['b_severity1'] !== $row['b_severity1'] ? $_POST['b_severity1'] : $row['b_severity1'];
                                    $f_b_potential_cause = isset($_POST['b_potential_cause']) && $_POST['b_potential_cause'] !== $row['b_potential_cause'] ? $_POST['b_potential_cause'] : $row['b_potential_cause'];

                                    $f_b_occurence_probablility = isset($_POST['b_occurence_probablility']) && $_POST['b_occurence_probablility'] !== $row['b_occurence_probablility'] ? $_POST['b_occurence_probablility'] : $row['b_occurence_probablility'];
                                    $f_b_current_control = isset($_POST['b_current_control']) && $_POST['b_current_control'] !== $row['b_current_control'] ? $_POST['b_current_control'] : $row['b_current_control'];
                                    $f_b_dectection1 = isset($_POST['b_dectection1']) && $_POST['b_dectection1'] !== $row['b_dectection1'] ? $_POST['b_dectection1'] : $row['b_dectection1'];
                                    $f_b_rpn1 = isset($_POST['b_rpn1']) && $_POST['b_rpn1'] !== $row['b_rpn1'] ? $_POST['b_rpn1'] : $row['b_rpn1'];
                                    $f_b_recommended_action = isset($_POST['b_recommended_action']) && $_POST['b_recommended_action'] !== $row['b_recommended_action'] ? $_POST['b_recommended_action'] : $row['b_recommended_action'];

                                    $f_b_severity2 = isset($_POST['b_severity2']) && $_POST['b_severity2'] !== $row['b_severity2'] ? $_POST['b_severity2'] : $row['b_severity2'];
                                    $f_b_occurence = isset($_POST['b_occurence']) && $_POST['b_occurence'] !== $row['b_occurence'] ? $_POST['b_occurence'] : $row['b_occurence'];
                                    $f_b_detection2 = isset($_POST['b_detection2']) && $_POST['b_detection2'] !== $row['b_detection2'] ? $_POST['b_detection2'] : $row['b_detection2'];
                                    $f_b_rpn2 = isset($_POST['b_rpn2']) && $_POST['b_rpn2'] !== $row['b_rpn2'] ? $_POST['b_rpn2'] : $row['b_rpn2'];







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

                                    $f_c_signature_warehouse_1 = isset($_POST['c_signature_warehouse_1']) && $_POST['c_signature_warehouse_1'] !== $row['c_signature_warehouse_1'] ? $_POST['c_signature_warehouse_1'] : $row['c_signature_warehouse_1'];
                                    $f_c_signature_warehouse_2 = isset($_POST['c_signature_warehouse_2']) && $_POST['c_signature_warehouse_2'] !== $row['c_signature_warehouse_2'] ? $_POST['c_signature_warehouse_2'] : $row['c_signature_warehouse_2'];
                                    $f_c_signature_warehouse_3 = isset($_POST['c_signature_warehouse_3']) && $_POST['c_signature_warehouse_3'] !== $row['c_signature_warehouse_3'] ? $_POST['c_signature_warehouse_3'] : $row['c_signature_warehouse_3'];
                                    $f_c_signature_warehouse_4 = isset($_POST['c_signature_warehouse_4']) && $_POST['c_signature_warehouse_4'] !== $row['c_signature_warehouse_4'] ? $_POST['c_signature_warehouse_4'] : $row['c_signature_warehouse_4'];
                                    $f_c_signature_warehouse_5 = isset($_POST['c_signature_warehouse_5']) && $_POST['c_signature_warehouse_5'] !== $row['c_signature_warehouse_5'] ? $_POST['c_signature_warehouse_5'] : $row['c_signature_warehouse_5'];













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

                                    $f_c2_signature_pd_1 = isset($_POST['c2_signature_pd_1']) && $_POST['c2_signature_pd_1'] !== $row['c2_signature_pd_1'] ? $_POST['c2_signature_pd_1'] : $row['c2_signature_pd_1'];
                                    $f_c2_signature_pd_2 = isset($_POST['c2_signature_pd_2']) && $_POST['c2_signature_pd_2'] !== $row['c2_signature_pd_2'] ? $_POST['c2_signature_pd_2'] : $row['c2_signature_pd_2'];
                                    $f_c2_signature_pd_3 = isset($_POST['c2_signature_pd_3']) && $_POST['c2_signature_pd_3'] !== $row['c2_signature_pd_3'] ? $_POST['c2_signature_pd_3'] : $row['c2_signature_pd_3'];
                                    $f_c2_signature_pd_4 = isset($_POST['c2_signature_pd_4']) && $_POST['c2_signature_pd_4'] !== $row['c2_signature_pd_4'] ? $_POST['c2_signature_pd_4'] : $row['c2_signature_pd_4'];
                                    $f_c2_signature_pd_5 = isset($_POST['c2_signature_pd_5']) && $_POST['c2_signature_pd_5'] !== $row['c2_signature_pd_5'] ? $_POST['c2_signature_pd_5'] : $row['c2_signature_pd_5'];









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

                                    $f_d_signature_purchase_1 = isset($_POST['d_signature_purchase_1']) && $_POST['d_signature_purchase_1'] !== $row['d_signature_purchase_1'] ? $_POST['d_signature_purchase_1'] : $row['d_signature_purchase_1'];
                                    $f_d_signature_purchase_2 = isset($_POST['d_signature_purchase_2']) && $_POST['d_signature_purchase_2'] !== $row['d_signature_purchase_2'] ? $_POST['d_signature_purchase_2'] : $row['d_signature_purchase_2'];
                                    $f_d_signature_purchase_3 = isset($_POST['d_signature_purchase_3']) && $_POST['d_signature_purchase_3'] !== $row['d_signature_purchase_3'] ? $_POST['d_signature_purchase_3'] : $row['d_signature_purchase_3'];
                                    $f_d_signature_purchase_4 = isset($_POST['d_signature_purchase_4']) && $_POST['d_signature_purchase_4'] !== $row['d_signature_purchase_4'] ? $_POST['d_signature_purchase_4'] : $row['d_signature_purchase_4'];
                                    $f_d_signature_purchase_5 = isset($_POST['d_signature_purchase_5']) && $_POST['d_signature_purchase_5'] !== $row['d_signature_purchase_5'] ? $_POST['d_signature_purchase_5'] : $row['d_signature_purchase_5'];











                                    $f_d2_sno_1 = isset($_POST['d2_sno_1']) && $_POST['d2_sno_1'] !== $row['d2_sno_1'] ? $_POST['d2_sno_1'] : $row['d2_sno_1'];
                                    $f_d2_sno_2 = isset($_POST['d2_sno_2']) && $_POST['d2_sno_2'] !== $row['d2_sno_2'] ? $_POST['d2_sno_1'] : $row['d2_sno_2'];
                                    $f_d2_sno_3 = isset($_POST['d2_sno_3']) && $_POST['d2_sno_3'] !== $row['d2_sno_3'] ? $_POST['d2_sno_1'] : $row['d2_sno_3'];
                                    $f_d2_sno_4 = isset($_POST['d2_sno_4']) && $_POST['d2_sno_4'] !== $row['d2_sno_4'] ? $_POST['d2_sno_1'] : $row['d2_sno_4'];
                                    $f_d2_sno_5 = isset($_POST['d2_sno_5']) && $_POST['d2_sno_5'] !== $row['d2_sno_5'] ? $_POST['d2_sno_1'] : $row['d2_sno_5'];

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

                                    $f_d2_signature_planning_1 = isset($_POST['d2_signature_planning_1']) && $_POST['d2_signature_planning_1'] !== $row['d2_signature_planning_1'] ? $_POST['d2_signature_planning_1'] : $row['d2_signature_planning_1'];
                                    $f_d2_signature_planning_2 = isset($_POST['d2_signature_planning_2']) && $_POST['d2_signature_planning_2'] !== $row['d2_signature_planning_2'] ? $_POST['d2_signature_planning_2'] : $row['d2_signature_planning_2'];
                                    $f_d2_signature_planning_3 = isset($_POST['d2_signature_planning_3']) && $_POST['d2_signature_planning_3'] !== $row['d2_signature_planning_3'] ? $_POST['d2_signature_planning_3'] : $row['d2_signature_planning_3'];
                                    $f_d2_signature_planning_4 = isset($_POST['d2_signature_planning_4']) && $_POST['d2_signature_planning_4'] !== $row['d2_signature_planning_4'] ? $_POST['d2_signature_planning_4'] : $row['d2_signature_planning_4'];
                                    $f_d2_signature_planning_5 = isset($_POST['d2_signature_planning_5']) && $_POST['d2_signature_planning_5'] !== $row['d2_signature_planning_5'] ? $_POST['d2_signature_planning_5'] : $row['d2_signature_planning_5'];




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

                                    $f_d3_signature_planning_1 = isset($_POST['d3_signature_planning_1']) && $_POST['d3_signature_planning_1'] !== $row['d3_signature_planning_1'] ? $_POST['d3_signature_planning_1'] : $row['d3_signature_planning_1'];
                                    $f_d3_signature_planning_2 = isset($_POST['d3_signature_planning_2']) && $_POST['d3_signature_planning_2'] !== $row['d3_signature_planning_2'] ? $_POST['d3_signature_planning_2'] : $row['d3_signature_planning_2'];
                                    $f_d3_signature_planning_3 = isset($_POST['d3_signature_planning_3']) && $_POST['d3_signature_planning_3'] !== $row['d3_signature_planning_3'] ? $_POST['d3_signature_planning_3'] : $row['d3_signature_planning_3'];
                                    $f_d3_signature_planning_4 = isset($_POST['d3_signature_planning_4']) && $_POST['d3_signature_planning_4'] !== $row['d3_signature_planning_4'] ? $_POST['d3_signature_planning_4'] : $row['d3_signature_planning_4'];
                                    $f_d3_signature_planning_5 = isset($_POST['d3_signature_planning_5']) && $_POST['d3_signature_planning_5'] !== $row['d3_signature_planning_5'] ? $_POST['d3_signature_planning_5'] : $row['d3_signature_planning_5'];






                                    $f_date = date('Y-m-d');


                                    $update_query = "UPDATE qc_ccrf SET 
                                
                                                      b_risk_item_no = '$f_b_risk_item_no',
                                                      b_potential_failure_mode = '$f_b_potential_failure_mode',
                                                      b_potential_effect = '$f_b_potential_effect',
                                                      b_severity1 = '$f_b_severity1',
                                                      b_potential_cause = '$f_b_potential_cause',
                                
                                                      b_occurence_probablility = '$f_b_occurence_probablility',
                                                      b_current_control = '$f_b_current_control',
                                                      b_dectection1 = '$f_b_dectection1',
                                                      b_rpn1 = '$f_b_rpn1',
                                                      b_recommended_action = '$f_b_recommended_action',
                                
                                                      b_severity2 = '$f_b_severity2',
                                                      b_occurence = '$f_b_occurence',
                                                      b_detection2 = '$f_b_detection2',
                                                      b_rpn2 = '$f_b_rpn2',
                                
                                
                                
                                
                                                      -- form 4
                                
                                
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
                                
                                                    c_signature_warehouse_1 = '$f_c_signature_warehouse_1',
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
                                        window.location.href = 'cc_form2?id=" . $id . "';
                                        
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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
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