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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MedicsFlow</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
    <?php
    include 'cdncss.php'
        ?>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
    <style>
        .table2-2 td {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            font-size: 11px !important;
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

        .btn {
            font-size: 11px !important;
            border-radius: 0px !important
        }

        .bg-grey {
            background-color: #E3F4F4 !important;
        }

        a {
            text-decoration: none !important;
        }

        .table-container {
            overflow-y: auto;
            height: 90vh;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            font-size: 12px !important;
            border: none !important;
            background-color: #1B7BBC !important;
            color: white !important;
        }

        table td {
            font-size: 12px;
            color: black;
            padding: 0px !important;
        }

        .table_add_service th {
            background-color: white !important;
            color: black !important;
            font-size: 14px;
        }

        input {
            width: 100% !important;
            font-size: 13px;
            border-radius: 0px;
            border: 1px solid grey;
            transition: border-color 0.3s ease;
            padding: 2.5px 5px;
            letter-spacing: 0.4px;
            height: 25px !important;
        }

        input:focus {
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
        }

        p {
            font-size: 13px !important;
        }

        li {
            font-size: 13px !important;
        }

        .table1-1 th,
        .table1-2 th {
            border: 1px solid #1B7BBC !important;
        }

        .table1-1 td,
        .table1-2 td {
            font-size: 12.5px !important;
            padding: 5px !important;
            border: 1px solid black !important;
        }

        .table2-1 td,
        .table2-2 td,
        .table2-3 td {
            font-size: 12.3px !important;
            padding: 5px !important;
        }

        .table2-1 td,
        .table2-2 td,
        .table2-3 td {
            font-size: 12.5px !important;
            padding: 5px !important;
        }

        .table3-1 th {
            border: 1px solid #1B7BBC !important;
        }
    </style>


    <style>
        .pagination-scroll {
            overflow-x: auto;
            /* Enable horizontal scrolling */
            white-space: nowrap;
            /* Prevent wrapping of pagination buttons */
            width: 100%;
            /* Full width of the parent container */
        }

        #pagination-controls {
            display: inline-block;
            /* Ensure the pagination controls are displayed inline to enable scrolling */
        }
    </style>
    <style>
        .nav-tabs .nav-link {
            background-color: white;
            border: 1px solid black;
            color: black;
            border-radius: 0;
            margin-right: 2px;
            padding: 8px 15px;
            transition: background-color 0.3s ease;
        }

        /* Hover effect for inactive tabs */
        .nav-tabs .nav-link:hover {
            background-color: #f0f0f0;
            /* light grey */
            border: 1px solid black;
            /* keep border on hover */
            color: black;
        }

        /* Active tab */
        .nav-tabs .nav-link.active {
            background-color: #8ABB6C;
            color: white;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            border: 1px solid #8ABB6C;
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
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-success btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </nav>
            <div class="container-fluid">

                <nav class="mt-2">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">



                        <button class="nav-link active mt-md-0 mt-1" id="nav-home-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                            aria-selected="true">BDO</button>
                        <button class="nav-link  mt-md-0 mt-1" id="nav-profile-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                            aria-selected="false">FM & ASM</button>
                        <button class="nav-link  mt-md-0 mt-1" id="nav-group-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-group" type="button" role="tab" aria-controls="nav-group"
                            aria-selected="false">TMDM & KAM</button>
                        <button class="nav-link  mt-md-0 mt-1" id="nav-contact-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact"
                            aria-selected="false">ZSM</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">

                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                        tabindex="0">



                        <div class="d-flex align-items-center justify-content-between bg-white py-3">
                            <!-- Left: Home Button -->
                            <a class="btn btn-dark btn-sm" href="appraisal_forms.php">
                                <i class="fa-solid fa-home"></i> Home
                            </a>

                            <!-- Center: Heading -->
                            <div class="flex-grow-1 text-center">
                                <h5 class="m-0" style="font-weight: 600;">
                                    KPI Setting<br>
                                    <span style="font-weight: 400; font-size: 14px;">(For BDO)</span>
                                </h5>
                            </div>

                            <!-- Right: Empty placeholder to balance layout -->
                            <div style="width:70px;"></div>
                        </div>


                        <div class="table-responsive">
                            <table class="table table2-2">
                                <thead>
                                    <tr>
                                        <th>KPI Description</th>
                                        <th>Benchmark</th>
                                        <th>Weightage</th>
                                        <th>Measuring Tool</th>
                                        <th>Achievement</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td class="bg-grey">A quantifiable measure of performance</br> over time.</td>
                                        <td class="bg-grey">Desired target</td>
                                        <td class="bg-grey">Weightage</td>
                                        <td class="bg-grey">Quantifiable Framework</td>
                                        <td class="bg-grey">Achieved value</td>
                                        <td class="bg-grey">Any additional notes pertaining</br> to each KPI</td>
                                    </tr>







                                    <tr>
                                        <td><b>Call Ratio:</b></br>The average number of monthly</br> customers calls
                                            completed in a month.</td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Productivity Ratio:</b></br>The average numbers of
                                            customers</br>generating sales out of total customer</br>calls in a month.
                                        </td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>New Leads ratio:</b> The average</br> number of new business added</br>
                                            to pipeline during a single quarter.</td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Customer Retention Ratio:</b> The</br> percentage of customers who</br>
                                            continue to buy and use products.</td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Product Knowledge & Selling Skills: </b></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Sales Achievement of Quarter 1:</b></br> Targets achieved in a quarter
                                        </td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Sales Achievement of Quarter 2:</b></br> Targets achieved in a quarter
                                        </td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Sales Achievement of Quarter 3:</b></br> Targets achieved in a quarter
                                        </td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Sales Achievement of Quarter 4:</b></br> Targets achieved in a quarter
                                        </td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <div class="text-center mt-3 mb-5">
                                                <button class="slide" name="submit"
                                                    style="font-size: 17px; height: 36px; width: 150px;">
                                                    <span class="text">Submit</span>
                                                </button>
                                            </div>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- tab 1 end -->






                    <!-- tab 2 start  -->
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"
                        tabindex="0">
                        <!-- <h5 class="text-center py-3 bg-white" style="font-weight: 600;">KPI Setting</br>
                            <span style="font-weight: 400;font-size:14px">(For FM & ASM)</span>
                        </h5> -->



                        <div class="d-flex align-items-center justify-content-between bg-white py-3">
                            <!-- Left: Home Button -->
                            <a class="btn btn-dark btn-sm" href="appraisal_forms.php">
                                <i class="fa-solid fa-home"></i> Home
                            </a>

                            <!-- Center: Heading -->
                            <div class="flex-grow-1 text-center">
                                <h5 class="m-0" style="font-weight: 600;">
                                    KPI Setting<br>
                                    <span style="font-weight: 400; font-size: 14px;">(For FM & ASM)</span>
                                </h5>
                            </div>

                            <!-- Right: Empty placeholder to balance layout -->
                            <div style="width:70px;"></div>
                        </div>



                        <div class="table-responsive">
                            <table class="table table2-2">
                                <thead>
                                    <tr>
                                        <th>KPI Description</th>
                                        <th>Benchmark</th>
                                        <th>Weightage</th>
                                        <th>Measuring Tool</th>
                                        <th>Achievement</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td class="bg-grey">A quantifiable measure of performance</br>over time.</td>
                                        <td class="bg-grey">Desired target</td>
                                        <td class="bg-grey">Weightage</td>
                                        <td class="bg-grey">Quantifiable Framework</td>
                                        <td class="bg-grey">Achieved value</td>
                                        <td class="bg-grey">Any additional notes pertaining</br>to each KPI</td>
                                    </tr>







                                    <tr>
                                        <td><b>Call Ratio:</b></br>The average number of monthly</br>customers calls
                                            completed in a month.</td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Productivity Ratio:</b></br>The average numbers of
                                            customers</br>generating sales out of total customer</br>calls in a month.
                                        </td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>New Leads ratio:</b></br>The average number of new business</br>added to
                                            pipeline during a single quarter.</td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Customer Retention Ratio:</b></br>The percentage of customers
                                            who</br>continue to buy and use products.</td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Product Knowledge & Selling Skills: </b></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Sales Achievement of Quarter 1:</b></br> Targets achieved in a quarter
                                        </td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Sales Achievement of Quarter 2:</b></br> Targets achieved in a quarter
                                        </td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Sales Achievement of Quarter 3:</b></br> Targets achieved in a quarter
                                        </td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Sales Achievement of Quarter 4:</b></br> Targets achieved in a quarter
                                        </td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <div class="text-center mt-3 mb-5">
                                                <button class="slide" name="submit"
                                                    style="font-size: 17px; height: 36px; width: 150px;">
                                                    <span class="text">Submit</span>
                                                </button>
                                            </div>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!--tab 2 end -->






                    <!-- tab 3 start  -->
                    <div class="tab-pane fade" id="nav-group" role="tabpanel" aria-labelledby="nav-group-tab"
                        tabindex="0">
                        <!-- <h5 class="text-center py-3 bg-white" style="font-weight: 600;">KPI Setting</br>
                            <span style="font-weight: 400;font-size:14px">(For TMDM & KAM)</span>
                        </h5> -->



                        <div class="d-flex align-items-center justify-content-between bg-white py-3">
                            <!-- Left: Home Button -->
                            <a class="btn btn-dark btn-sm" href="appraisal_forms.php">
                                <i class="fa-solid fa-home"></i> Home
                            </a>

                            <!-- Center: Heading -->
                            <div class="flex-grow-1 text-center">
                                <h5 class="m-0" style="font-weight: 600;">
                                    KPI Setting<br>
                                    <span style="font-weight: 400; font-size: 14px;">(For TMDM & KAM)</span>
                                </h5>
                            </div>

                            <!-- Right: Empty placeholder to balance layout -->
                            <div style="width:70px;"></div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table2-2">
                                <thead>
                                    <tr>
                                        <th>KPI Description</th>
                                        <th>Benchmark</th>
                                        <th>Weightage</th>
                                        <th>Measuring Tool</th>
                                        <th>Achievement</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td class="bg-grey">A quantifiable measure of performance</br>over time.</td>
                                        <td class="bg-grey">Desired target</td>
                                        <td class="bg-grey">Weightage</td>
                                        <td class="bg-grey">Quantifiable Framework</td>
                                        <td class="bg-grey">Achieved value</td>
                                        <td class="bg-grey">Any additional notes pertaining</br> to each KPI</td>
                                    </tr>







                                    <tr>
                                        <td><b>Average Sales per product:</b></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Trade Partnership Program Pharmacy</br> Growth:</b></br>Sales and Growth
                                            of Chain Pharmacy</br> business (%)</td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Unique Key Accounts Activation:</b></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Compliance Rate:</b></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Product Knowledge & Selling Skills:</b></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Customer Relationship:</b></br> Counseling, FF improvement,
                                            Customers</br> relationship , Product knowledge, Personal</br> & Sellings
                                            skills. </td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>KOL Development:</b></br>Execution of PCP/HCP programs & BTL</br>
                                            activities</td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Customer Acquisition Cost:- </b></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>New Leads ratio:</b></br>The average number of new business</br> added to
                                            pipeline during a single quarter.</td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>


                                    <tr>
                                        <td><b>Customer Retention Ratio:</b></br>The percentage of customers who</br>
                                            continue to buy and use products.</td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Retention Ratio:</b></br>Percentage of team members</br> who remain in an
                                            organization in</br> an evaluation year.</td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Sales Achievement of Quarter 1:</b></br> Targets achieved in a quarter
                                        </td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Sales Achievement of Quarter 2:</b></br> Targets achieved in a quarter
                                        </td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Sales Achievement of Quarter 3:</b></br> Targets achieved in a quarter
                                        </td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Sales Achievement of Quarter 4:</b></br> Targets achieved in a quarter
                                        </td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <div class="text-center mt-3 mb-5">
                                                <button class="slide" name="submit"
                                                    style="font-size: 17px; height: 36px; width: 150px;">
                                                    <span class="text">Submit</span>
                                                </button>
                                            </div>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- tab 3 end  -->


                    <!-- tab 4 start  -->
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab"
                        tabindex="0">
                        <!-- <h5 class="text-center py-3 bg-white" style="font-weight: 600;">KPI Setting</br>
                            <span style="font-weight: 400;font-size:14px">(For ZSM)</span>
                        </h5> -->


                        <div class="d-flex align-items-center justify-content-between bg-white py-3">
                            <!-- Left: Home Button -->
                            <a class="btn btn-dark btn-sm" href="appraisal_forms.php">
                                <i class="fa-solid fa-home"></i> Home
                            </a>

                            <!-- Center: Heading -->
                            <div class="flex-grow-1 text-center">
                                <h5 class="m-0" style="font-weight: 600;">
                                    KPI Setting<br>
                                    <span style="font-weight: 400; font-size: 14px;">(For ZSM)</span>
                                </h5>
                            </div>

                            <!-- Right: Empty placeholder to balance layout -->
                            <div style="width:70px;"></div>
                        </div>




                        <div class="table-responsive">
                            <table class="table table2-2">
                                <thead>
                                    <tr>
                                        <th>KPI Description</th>
                                        <th>Benchmark</th>
                                        <th>Weightage</th>
                                        <th>Measuring Tool</th>
                                        <th>Achievement</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td class="bg-grey">A quantifiable measure of</br> performance over time.</td>
                                        <td class="bg-grey">Desired target</td>
                                        <td class="bg-grey">Weightage</td>
                                        <td class="bg-grey">Quantifiable Framework</td>
                                        <td class="bg-grey">Achieved value</td>
                                        <td class="bg-grey">Any additional notes pertaining to</br> each KPI</td>
                                    </tr>







                                    <tr>
                                        <td><b>Average Sales per product:</b></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Team Development:</b></br> Counseling, FF improvement,</br> Customers
                                            relationship , Product</br> knowledge, Personal & Sellings skills. </td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>KOL Development:</b></br>Execution of PCP/HCP programs</br> & BTL
                                            activities</b></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Customer Acquisition Cost:</b></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>New Leads ratio:</b></br>The average number of new</br> business added to
                                            pipeline</br> during a single quarter.</td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Customer Retention Ratio:</b></br>The percentage of customers</br> who
                                            continue to buy and use</br> products.</td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Retention Ratio:</b></br>Percentage of team members</br> who remain in an
                                            organization</br> in an evaluation year.</td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Revenue per BDO:</b></br>Average sales BDO brings in a</br> month</td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Sales Achievement of Quarter 1:</b></br>Targets achieved in a quarter
                                        </td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>


                                    <tr>
                                        <td><b>Sales Achievement of Quarter 2:</b></br>Targets achieved in a quarter
                                        </td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Sales Achievement of Quarter 3:</b></br> Targets achieved in a quarter
                                        </td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Sales Achievement of Quarter 4:</b></br>Targets achieved in a quarter
                                        </td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>

                                    <tr>
                                        <td colspan="6">
                                            <div class="text-center mt-3 mb-5">
                                                <button class="slide" name="submit"
                                                    style="font-size: 17px; height: 36px; width: 150px;">
                                                    <span class="text">Submit</span>
                                                </button>
                                            </div>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- tab 4 end -->
                    </div>
                </div>
            </div>
            <?php
            include 'footer.php'
                ?>