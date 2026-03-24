<?php
session_start();


if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php'); // Redirect to the login page
    exit;
}

$head_email = $_SESSION['head_email'];
$fullname = $_SESSION['fullname'];
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
        .table_header th,
        td {
            font-size: 12px !important;
        }

        .table-yes-no {
            font-size: 13px;
            border-collapse: collapse;
            width: 100%;
        }

        .table-yes-no th,
        .table-yes-no td {
            padding: 6px 12px;
            font-size: 11px !important;
        }

        .custom-radio {
            position: relative;
            display: inline-block;
            width: 16px;
            height: 16px;
        }

        .custom-radio input[type="radio"] {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .custom-radio span {
            position: absolute;
            top: 0;
            left: 0;
            width: 16px;
            height: 16px;
            border: 2px solid #333;
            background-color: #fff;
            border-radius: 2px;
        }

        .custom-radio input[type="radio"]:checked+span::after {
            content: "";
            position: absolute;
            top: 3px;
            left: 3px;
            width: 8px;
            height: 8px;
            background-color: #333;
        }
    </style>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        th,
        td {
            padding: 2px 10px !important;
            font-size: 11px !important;
        }

        li {
            font-size: 11px !important;
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

        input {
            width: 200px !important;
            font-size: 11.7px !important;
            border-radius: 0px !important;
            border: 1px solid grey !important;
            transition: border-color 0.3s ease !important;
            padding: 5px 5px !important;
            letter-spacing: 0.4px !important;
            height: 25px !important;
        }

        input:focus {
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
        }
    </style>
    <?php
    include 'sidebarcss.php'
    ?>
    <style>
        .table-risk th {
            font-size: 11px !important;
            border: none !important;
            background-color: #ced4da !important;
            color: black !important;
            border: none !important
        }

        .table-risk td {
            border: none !important;
        }

        .table-risk tr {
            border: none !important;
        }

        .table-risk1 th {
            background-color: #ced4da !important;
            color: black !important;
            font-size: 11px !important;
        }

        .table-risk2 th {
            background-color: #ced4da !important;
            color: black !important;
            font-size: 11px !important;
        }

        .table-risk3 th {
            background-color: #ced4da !important;
            color: black !important;
            font-size: 11px !important;
        }

        .btn {
            border-radius: 2px
        }

        .bg-menu {
            background-color: #393E46 !important;
            border-radius: 0px !important;
        }

        .btn-menu {
            font-size: 12.5px;
            background-color: #FFB22C !important;
            padding: 5px 10px;
            font-weight: 600;
            border: none !important;
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
                    <button type="button" id="sidebarCollapse" class="btn btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </nav>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <form class="form pb-2" method="POST" style="border: 1px solid black; padding: 25px; padding-bottom: 0px; border-radius: 2px;background-color:white!important" enctype="multipart/form-data">
                            <h6 class="text-center pb-3" style="font-weight: bold;"><span style="float:left!important"> <a class="btn btn-dark btn-sm" href="cc_home.php" style="font-size:11px!important"><i class="fa-solid fa-home"></i> Home</a></span>Change Control Request Form</h6>
                            <!-- 
                <p>File No, Doc Number, Revision No, Effective Date, Review Date, Page No</p>
                <p>1098, ML.QAS.FRM.041.R1.E ,01 , 01 JAN 25 , On Change ,  Page 1 out of 10</p> -->
                            <table class="mb-3 table_header" border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: center; font-family: Arial, sans-serif;">
                                <tr style="background-color: #ced4da; font-weight: bold;">
                                    <td>File No</td>
                                    <td>Doc Number</td>
                                    <td>Revision No</td>
                                    <td>Effective Date</td>
                                    <td>Review Date</td>
                                    <td>Page No</td>
                                </tr>
                                <tr>
                                    <td>1098</td>
                                    <td>ML.QAS.FRM.041.R1.E</td>
                                    <td>01</td>
                                    <td>01 JAN 25</td>
                                    <td>On Change</td>
                                    <td>Page 1 of 10</td>
                                </tr>
                            </table>
                            <div>
                                <p>Date Initiated</p>
                                <input type="date"
                                    style="display: block; width:100%!important"
                                    name="i_date_initiated"
                                    value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div>
                                <p>Area of Change</p>
                                <input type="text" style="display: block; width:100%!important" name="i_area_of_change">
                            </div>
                            <table class="table table-yes-no mt-3">
                                <tr>
                                    <td>Type of Change</td>
                                    <td>
                                        <label class="custom-radio">Temporary</label>
                                        <input type="radio" name="i_time_of_change" value="Temporary">
                                    </td>
                                    <td>
                                        <label class="custom-radio">Permanent</label>
                                        <input type="radio" name="i_time_of_change" value="Permanent">
                                    </td>
                                </tr>
                                <tr class="datetr" style="display: none;">
                                    <td class="py-2">Start Date</td>
                                    <td class="py-2">
                                        <input type="date" name="startdate" id="startdate">
                                    </td>
                                    <td class="py-2">End Date</td>
                                    <td class="py-2">
                                        <input type="date" name="enddate" id="enddate">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Stock Status Requirement</td>
                                    <td>
                                        <label class="custom-radio">Yes</label>
                                        <input type="radio" name="stock_status_req" value="Yes">
                                    </td>
                                    <td>
                                        <label class="custom-radio">No</label>
                                        <input type="radio" name="stock_status_req" value="No">
                                    </td>
                                </tr>
                            </table>
                            <!-- stock status req end  -->
                            <div>
                                <div style="margin-bottom: 10px;">
                                    <p style="font-weight: 600 !important; font-size: 13px !important;">Description of Change</p>
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <p>Title of Change</p>
                                    <input type="text" style="display: block; width:100%!important" name="i_title_of_change">
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <p>Current Status</p>
                                    <input type="text" style="display: block; width:100%!important" name="i_current_status">
                                </div>
                                <div style="margin-top: 10px;margin-bottom: 10px;">
                                    <p>Proposed Change</p>
                                    <input type="text" style="display: block; width:100%!important" name="i_proposed_status">
                                </div>
                                <div style="margin-top: 10px;margin-bottom: 10px;">
                                    <p>Change Control Completion</p>
                                    <input type="date" style="display: block; width:100%!important" name="i_completion_date">
                                </div>
                                <div style="margin-top: 10px;margin-bottom: 10px;">
                                    <p>Attach File</p>
                                    <input type="file" style="display: block; width:100%!important" name="file">
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <p style="font-weight: 600 !important; font-size: 12px !important;">Justification of Change (Supporting Data if applicable)</p>
                                    <input type="text" style="display: block; width:100%!important" name="i_justification_of_change">
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <table class="table" style="padding:0px!important;margin:0px!important">
                                        <p style="font-weight: 600 !important; font-size: 12px !important;">
                                            Change Control Classification (Designee)
                                        </p>
                                        <tbody>
                                            <tr>
                                                <th colspan="2" class="py-2" style="font-size:12px!important">Nature Of Change</th>
                                            </tr>
                                            <tr>
                                                <th style="font-size:11px!important; text-align: left;font-weight: normal;">Critical</th>
                                                <td><input type="checkbox" class="add-remove-checkbox cbox" name="i_classification_status" value="Critical" style="height:20px!important;width:20px!important"></td>
                                            </tr>
                                            <tr>
                                                <th style="font-size:11px!important; text-align: left;font-weight: normal;">Major</th>
                                                <td><input type="checkbox" class="add-remove-checkbox cbox" name="i_classification_status" value="Major" style="height:20px!important;width:20px!important"></td>
                                            </tr>
                                            <tr>
                                                <th style="font-size:11px!important; text-align: left;font-weight: normal;">Minor</th>
                                                <td><input type="checkbox" class="add-remove-checkbox cbox" name="i_classification_status" value="Minor" style="height:20px!important;width:20px!important"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- risk start  -->
                            <h6 class="mt-3" style="font-weight: bolder;font-size:13.5px">RISK ASSESSMENT</h6>
                            <div class="table-responsive">
                                <table class="table table-risk table-bordered">
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
                                                <textarea style="height:300px;width:150px;text-align:left;padding:2px;font-size:11px" name="b_risk_item_no"></textarea>
                                            </td>
                                            <td>
                                                <textarea style="height:300px;width:150px;text-align:left;padding:2px;font-size:11px" name="b_potential_failure_mode"></textarea>
                                            </td>
                                            <td>
                                                <textarea style="height:300px;width:150px;text-align:left;padding:2px;font-size:11px" name="b_potential_effect"></textarea>
                                            </td>
                                            <td>
                                                <textarea style="height:300px;width:150px;text-align:left;padding:2px;font-size:11px" name="b_severity1" oninput="calculateRPN1(this)"></textarea>
                                            </td>
                                            <td>
                                                <textarea style="height:300px;width:150px;text-align:left;padding:2px;font-size:11px" name="b_potential_cause"></textarea>
                                            </td>
                                            <td>
                                                <textarea style="height:300px;width:150px;text-align:left;padding:2px;font-size:11px" name="b_occurence_probablility" oninput="calculateRPN1(this)"></textarea>
                                            </td>
                                            <td>
                                                <textarea style="height:300px;width:150px;text-align:left;padding:2px;font-size:11px" name="b_current_control"></textarea>
                                            </td>
                                            <td>
                                                <textarea style="height:300px;width:150px;text-align:left;padding:2px;font-size:11px" name="b_dectection1" oninput="calculateRPN1(this)"></textarea>
                                            </td>
                                            <td>
                                                <textarea style="height:300px;width:150px;text-align:left;padding:2px;font-size:11px;background-color:#f5f5f5;" name="b_rpn1" readonly></textarea>
                                            </td>
                                            <td>
                                                <textarea style="height:300px;width:150px;text-align:left;padding:2px;font-size:11px" name="b_recommended_action"></textarea>
                                            </td>
                                            <td>
                                                <textarea style="height:300px;width:150px;text-align:left;padding:2px;font-size:11px" name="b_severity2" oninput="calculateRPN2(this)"></textarea>
                                            </td>
                                            <td>
                                                <textarea style="height:300px;width:150px;text-align:left;padding:2px;font-size:11px" name="b_occurence" oninput="calculateRPN2(this)"></textarea>
                                            </td>
                                            <td>
                                                <textarea style="height:300px;width:150px;text-align:left;padding:2px;font-size:11px" name="b_detection2" oninput="calculateRPN2(this)"></textarea>
                                            </td>
                                            <td>
                                                <textarea style="height:300px;width:150px;text-align:left;padding:2px;font-size:11px;background-color:#f5f5f5;" name="b_rpn2" readonly></textarea>
                                            </td>
                                        </tr>
                                        <script>
                                            function calculateRPN1(element) {
                                                var row = element.closest('tr');

                                                var severity = parseFloat(row.querySelector('[name="b_severity1"]').value) || 0;
                                                var occurrence = parseFloat(row.querySelector('[name="b_occurence_probablility"]').value) || 0;
                                                var detection = parseFloat(row.querySelector('[name="b_dectection1"]').value) || 0;

                                                var rpn = severity * occurrence * detection;
                                                row.querySelector('[name="b_rpn1"]').value = rpn;
                                            }

                                            function calculateRPN2(element) {
                                                var row = element.closest('tr');

                                                var severity2 = parseFloat(row.querySelector('[name="b_severity2"]').value) || 0;
                                                var occurrence2 = parseFloat(row.querySelector('[name="b_occurence"]').value) || 0;
                                                var detection2 = parseFloat(row.querySelector('[name="b_detection2"]').value) || 0;

                                                var rpn2 = severity2 * occurrence2 * detection2;
                                                row.querySelector('[name="b_rpn2"]').value = rpn2;
                                            }
                                        </script>
                                    </tbody>
                                </table>
                            </div>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <div style="border: 1px solid black; padding: 25px; padding-bottom: 0px; border-radius: 2px;background-color:white!important;margin-top:15px">
                                            <h6 class="" style="font-weight: bolder;font-size:13.5px">To CALCULATE "RISK PRIORITIZATION NUMBER (or) RPN":</h6>
                                            <p style="font-size:12.5px!important" class="">RPN is calculated by multiplying Probablility (P) , Delectablity (D)
                                                and severity (S), which are individually categorized and scored as described below in Table
                                            </p>
                                            <!-- table 1 -->
                                            <table class="table table-responsive mt-3 table-risk1">
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
                                            <table class="table table-risk3">
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
                                                        <td>Control system in place has a high probability of detecting the defect or
                                                            its effects.
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Moderate</td>
                                                        <td>4</td>
                                                        <td>Control system in place could detect the defect or its effects.
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Low</td>
                                                        <td>6</td>
                                                        <td>Control system in place has a low probability of detecting the defect or
                                                            its effects
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Non existent</td>
                                                        <td>8</td>
                                                        <td>There is no control system to detect the defect</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <!-- table 3 -->
                                            <table class="table table-risk3">
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
                                                        <td>Minor GMP non-compliance; no possible impact on Patient, yield or on
                                                            production capability
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Moderate</td>
                                                        <td>4</td>
                                                        <td>Significant GMP non-compliance; possible impact on patient; moderate
                                                            impact on yield or production capability
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>High</td>
                                                        <td>6</td>
                                                        <td>Major GMP non-compliance; probable impact on patient; high impact on
                                                            yield or production Capability.
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Critical</td>
                                                        <td>54</td>
                                                        <td>Serious GMP non-compliance; Probable serious harm or death; critical
                                                            impact on yield or production capability
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="pr-5 pt-3">
                                                <p style="font-size:12.5px!important">The scoring should be assigned in an objective well justified manner as applicable by the FMEA
                                                    team, which should be carefully selected based on scientific background, product knowledge and
                                                    experience. Possible interpretation of the RPN used to categorize:
                                                </p>
                                                <ul class="ul-msg">
                                                    <li>Critical if RPN value > 216</li>
                                                    <li>Major if RPN value > 40 and < 216</li>
                                                    <li>Minor if RPN value < 40 </li>
                                                </ul>
                                            </div>
                                            <hr>
                                            <div>
                                                <div style="display: flex; gap: 20px; align-items: center;">
                                                    <div>
                                                        <p>Requestor Name</p>
                                                        <input type="text" style="display: inline;background-color:#F5F5F5!important" value="<?php echo htmlspecialchars($fullname); ?>" readonly>
                                                    </div>
                                                    <div>
                                                        <p>Department</p>
                                                        <input type="text" style="display: inline;background-color:#F5F5F5!important" value="<?php echo htmlspecialchars($department); ?>" readonly>
                                                    </div>
                                                </div>
                                                <div style="display: flex; gap: 20px; align-items: center;margin-top: 10px;" class="mb-3">
                                                    <div>
                                                        <p>Designation</p>
                                                        <input type="test" style="display: inline;background-color:#F5F5F5!important" value="<?php echo htmlspecialchars($role); ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" name="submit" class="btn btn-dark px-4">
                                    Submit
                                </button>
                            </div>
                        </form>
                        <?php
                        include 'dbconfig.php';
                        if (isset($_POST['submit'])) {
                            date_default_timezone_set("Asia/Karachi");

                            $id = $_SESSION['id'];
                            $fullname = $_SESSION['fullname'];
                            $email = $_SESSION['email'];
                            $username = $_SESSION['username'];
                            $department = $_SESSION['department'];
                            $role = $_SESSION['role'];
                            $date = date('Y-m-d');
                            $be_depart = $_SESSION['be_depart'];
                            $be_role = $_SESSION['be_role'];
                            $email = $_SESSION['email'];
                            $head_email =  $_SESSION['head_email'];

                            $i_title_of_change = mysqli_real_escape_string($conn, $_POST['i_title_of_change']);
                            $i_date_initiated = mysqli_real_escape_string($conn, $_POST['i_date_initiated']);
                            $i_area_of_change = mysqli_real_escape_string($conn, $_POST['i_area_of_change']);
                            $i_time_of_change = mysqli_real_escape_string($conn, $_POST['i_time_of_change']);
                            $i_current_status = mysqli_real_escape_string($conn, $_POST['i_current_status']);
                            $i_completion_date = mysqli_real_escape_string($conn, $_POST['i_completion_date']);
                            $i_proposed_status = mysqli_real_escape_string($conn, $_POST['i_proposed_status']);
                            $i_justification_of_change = mysqli_real_escape_string($conn, $_POST['i_justification_of_change']);
                            $i_classification_status = isset($_POST['i_classification_status'])
                                ? mysqli_real_escape_string($conn, $_POST['i_classification_status'])
                                : '';
                            $stock_status_req = mysqli_real_escape_string($conn, $_POST['stock_status_req']);
                            $startdate = mysqli_real_escape_string($conn, $_POST['startdate']);
                            $enddate = mysqli_real_escape_string($conn, $_POST['enddate']);
                            $file_path = mysqli_real_escape_string($conn, $destination);
                            $f_b_risk_item_no = mysqli_real_escape_string($conn, $_POST['b_risk_item_no']);
                            $f_b_potential_failure_mode = mysqli_real_escape_string($conn, $_POST['b_potential_failure_mode']);
                            $f_b_potential_effect = mysqli_real_escape_string($conn, $_POST['b_potential_effect']);
                            $f_b_severity1 = mysqli_real_escape_string($conn, $_POST['b_severity1']);
                            $f_b_potential_cause = mysqli_real_escape_string($conn, $_POST['b_potential_cause']);
                            $f_b_occurence_probablility = mysqli_real_escape_string($conn, $_POST['b_occurence_probablility']);
                            $f_b_current_control = mysqli_real_escape_string($conn, $_POST['b_current_control']);
                            $f_b_dectection1 = mysqli_real_escape_string($conn, $_POST['b_dectection1']);
                            $f_b_rpn1 = mysqli_real_escape_string($conn, $_POST['b_rpn1']);
                            $f_b_recommended_action = mysqli_real_escape_string($conn, $_POST['b_recommended_action']);
                            $f_b_severity2 = mysqli_real_escape_string($conn, $_POST['b_severity2']);
                            $f_b_occurence = mysqli_real_escape_string($conn, $_POST['b_occurence']);
                            $f_b_detection2 = mysqli_real_escape_string($conn, $_POST['b_detection2']);
                            $f_b_rpn2 = mysqli_real_escape_string($conn, $_POST['b_rpn2']);


                            $f_date = date('Y-m-d');
                            //  risk end


                            // ================= FILE UPLOAD FIX =================
                            $uploadDir = __DIR__ . '/assets/uploads/cc/';
                            $file_path = '';

                            if (!is_dir($uploadDir)) {
                                mkdir($uploadDir, 0755, true);
                            }

                            if (!empty($_FILES['file']['name']) && $_FILES['file']['error'] === 0) {

                                $fileTmpPath = $_FILES['file']['tmp_name'];
                                $fileName = $_FILES['file']['name'];
                                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                                $allowedExtensions = [
                                    'png',
                                    'jpg',
                                    'jpeg',
                                    'pdf',
                                    'doc',
                                    'docx',
                                    'xls',
                                    'xlsx',
                                    'csv'
                                ];

                                if (in_array($fileExt, $allowedExtensions)) {

                                    $newFileName = uniqid('ccrf_', true) . '.' . $fileExt;
                                    $destination = $uploadDir . $newFileName;

                                    if (move_uploaded_file($fileTmpPath, $destination)) {
                                        // Path saved in DB (relative path)
                                        $file_path = 'assets/uploads/cc/' . $newFileName;
                                    } else {
                                        die('❌ File upload failed (permission/path issue)');
                                    }
                                } else {
                                    die('❌ Invalid file type');
                                }
                            }
                            // ================= END FILE UPLOAD =================


                            // ---------- CODE GENERATION LOGIC ----------
                            $currentYear = date('y'); // 25, 26, etc
                            $prefix = 'CR';

                            $query = "
    SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(code, '-', 2), '-', -1) AS UNSIGNED) AS seq
    FROM qc_ccrf
    WHERE code LIKE '$prefix-%-$currentYear'
    ORDER BY seq DESC
    LIMIT 1
";

                            $result = mysqli_query($conn, $query);

                            if ($row = mysqli_fetch_assoc($result)) {
                                $newNumber = (int)$row['seq'] + 1;
                            } else {
                                $newNumber = 1;
                            }

                            $sequence = str_pad($newNumber, 3, '0', STR_PAD_LEFT);
                            $code = $prefix . '-' . $sequence . '-' . $currentYear;
                            // ---------- END CODE GENERATION ----------



                            $insert = "INSERT INTO qc_ccrf (
            code,
            i_date_initiated, i_title_of_change, i_area_of_change, i_time_of_change,
            i_current_status, i_proposed_status, i_justification_of_change, i_classification_status,
            username, user_department, user_role, user_date, user_be_depart, user_be_role, user_email, user_name,
            qchead_status, dept_head_status, part_1, part_2, part_3, qchead_status2, stock_status_req, startdate, enddate, file,
            
            b_risk_item_no, b_potential_failure_mode, b_potential_effect, b_severity1, b_potential_cause, b_occurence_probablility, b_current_control,
            b_dectection1, b_rpn1, b_recommended_action, b_severity2, b_occurence, b_detection2, b_rpn2, status, i_completion_date
            ) VALUES (
            '$code',
            '$i_date_initiated', '$i_title_of_change', '$i_area_of_change', '$i_time_of_change',
            '$i_current_status', '$i_proposed_status', '$i_justification_of_change', '$i_classification_status',
            '$username', '$department', '$role', '$date', '$be_depart', '$be_role','$email','$fullname',
            'Pending', 'Pending', 'Pending', 'Pending', 'Pending', 'Pending', '$stock_status_req','$startdate','$enddate','$file_path',
            
            '$f_b_risk_item_no', '$f_b_potential_failure_mode','$f_b_potential_effect','$f_b_severity1','$f_b_potential_cause','$f_b_occurence_probablility','$f_b_current_control',
            '$f_b_dectection1','$f_b_rpn1','$f_b_recommended_action','$f_b_severity2','$f_b_occurence','$f_b_detection2','$f_b_rpn2' ,
            'Open' , '$i_completion_date'
            )";

                            $insert_q = mysqli_query($conn, $insert);



                            if ($insert_q) {
                                // ✅ Output a loading message *before* sending emails
                                echo '
            <div id="loadingMsg" style="
            position:fixed;
            top:0;left:0;width:100%;height:100%;
            display:flex;align-items:center;justify-content:center;
            background:rgba(0,0,0,0.6);
            color:white;font-size:22px;z-index:9999;
            flex-direction:column;">
            <div style="padding:20px;background:#222;border-radius:10px;">
            <p>📨 Please wait, your request is being processed...</p>
            <p>Email is sending, this may take a few seconds.</p>
            </div>
            </div>
            ';

                                // ✅ Flush this message immediately so user sees it
                                ob_flush();
                                flush();




                                $last_id = mysqli_insert_id($conn);

                                $insert_ccrf2 = "INSERT INTO qc_ccrf2 (fk_id) VALUES ('$last_id')";
                                $insert_ccrf2_q = mysqli_query($conn, $insert_ccrf2);

                                if ($insert_ccrf2_q) {
                                    // ---- EMAIL LOGIC START ----
                                    try {
                                        $mail->clearAddresses();
                                        $mail->clearAttachments();

                                        $mail->isSMTP();
                                        $mail->Host       = 'smtp.office365.com';
                                        $mail->SMTPAuth   = true;
                                        $mail->Username   = 'info@medicslab.com';
                                        $mail->Password   = 'kcmzrskfgmwzzshz';
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                        $mail->Port       = 587;

                                        // IMPORTANT: Disable debug in production
                                        $mail->SMTPDebug = 0;

                                        $mail->setFrom('info@medicslab.com', 'Medics Digital Form');
                                        $mail->addAddress($head_email, 'Department Head');
                                        $mail->addCC('sadia.iqbal@medicslab.com');

                                        $mail->isHTML(true);
                                        $mail->Subject = "CCRF Form Submission – $code";
                                        $mail->Body = "
        <p>Dear Concern,</p>

        <p>A new <strong>Change Control Request Form (CCRF)</strong> has been submitted.</p>

        <p><strong>Request No:</strong> $code</p>
        <p><strong>Submitted by:</strong> {$fullname}</p>

        <p>
        Please log in to <a href='http://43.245.128.46:9090/medicsflow'>MedicsFlow</a>
        to review and take action.
        </p>

        <p>Regards,<br>MedicsFlow System</p>
    ";

                                        $mail->send();
                                    } catch (Exception $e) {
                                        error_log("Mail Error: " . $mail->ErrorInfo);
                                    }
                                    // ---- EMAIL LOGIC END ----
                        ?>
                                    <script type="text/javascript">
                                        alert("Form has been submitted!");
                                        window.location.href = "cc_form.php";
                                    </script>
                                <?php
                                } else {
                                ?>
                                    <script type="text/javascript">
                                        alert("Form submitted but ccrf2 record creation failed!");
                                        window.location.href = "cc_form.php";
                                    </script>
                                <?php
                                }
                            } else {
                                ?>
                                <script type="text/javascript">
                                    alert("Form submission failed!");
                                    window.location.href = "cc_form.php.php";
                                </script>
                        <?php
                            }
                        }
                        ?>
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
                        <script>
                            $(document).ready(function() {
                                // Initially hide the row
                                $(".datetr").hide();

                                // Watch for radio change
                                $("input[name='i_time_of_change']").change(function() {
                                    if ($(this).val() === "Temporary") {
                                        $(".datetr").show();
                                    } else {
                                        $(".datetr").hide();
                                    }
                                });
                            });
                        </script>
</body>

</html>