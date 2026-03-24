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
    <!-- fevicon -->
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

        a {
            text-decoration: none !important;
        }

        .table-container {
            overflow-y: auto;
            height: 90vh;
            /* Full viewport height */
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
            /* Adjust padding as needed */
            /* border: 1px solid #ddd; */
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
  <?php
include 'cdncjs.php'
?>
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
                <div>
                    <a class="btn btn-dark btn-sm" href="appraisal_forms.php"><i class="fa-solid fa-home"></i> Home</a>

                </div>
                <nav class="mt-2">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active mt-md-0 mt-1" id="nav-home-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                            aria-selected="true">Guide</button>
                        <button class="nav-link  mt-md-0 mt-1" id="nav-profile-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                            aria-selected="false">Departmental Objective</button>
                        <button class="nav-link  mt-md-0 mt-1" id="nav-group-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-group" type="button" role="tab" aria-controls="nav-group"
                            aria-selected="false">Monitoring Program</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <!-- tab 1 start  -->
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                        tabindex="0">
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div style="border: 1px solid #ccc; padding: 15px; height: 100%;background-color:white">
                                    <h5><strong>Setting the Right Goals & Objectives</strong></h5>
                                    <p>
                                        Following features must be kept in mind while devising the KPIs:
                                    <ol>
                                        <li>Identify a problem, any situation, problem or objective you are trying to
                                            address in the department or any process you want to improve.</li>
                                        <li> Develop a view on how you would like the results to look. For example from
                                            what percentage to what.</li>
                                        <li>Ensure KPIs are aligned with your strategic objectives.</li>
                                        <li>Ensure the selected KPIs are attainable and can be measured through
                                            evidence.</li>
                                        <li>Develop a process for how you want things to be achieved. For example, this
                                            could involve reengineering the process or introducing more strategies.</li>
                                    </ol>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="border: 1px solid #ccc; padding: 15px; height: 100%;background-color:white">
                                    <h5><strong>What are Key Performance Indicators</strong></h5>
                                    <p>
                                        A Key Performance Indicator (KPI) is a measurable value that demonstrates how
                                        effectively an individual, team, and organization is achieving key business
                                        objectives. Organizations use KPIs to evaluate their success at reaching
                                        targets.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- b start  -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div style="border: 1px solid #ccc; padding: 15px; height: 100%;background-color:white">
                                    <h6 style="color:#D94948"><u>Operational Effeciency</u></h6>
                                    <p>
                                        Goals & Objectives demonstrating effectiveness of various departmental functions
                                        and processes (operations) in
                                        relevance to achieving organizational goals, efficient work flow, improved
                                        performance.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="border: 1px solid #ccc; padding: 15px; height: 100%;background-color:white">
                                    <h6 style="color:#D94948"><u>Business Enhancement / Strategic Growth</u></h6>
                                    <p>
                                        Strategies or measures to develop and implement growth opportunities aiming to
                                        increase business/ revenue generation with reference to the departmental scope
                                        of work.[where applicable]
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- b end  -->
                        <!-- c start  -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div style="border: 1px solid #ccc; padding: 15px; height: 100%;background-color:white">
                                    <h6 style="color:#1D4886"><u>System Automation</u></h6>
                                    <p>
                                        Form area indicators which can help to identify the areas and current manual
                                        practices for process improvement through system automations and reduction in
                                        manual workload thereby developing
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="border: 1px solid #ccc; padding: 15px; height: 100%;background-color:white">
                                    <h6 style="color:#1D4886"><u>People / Learning and growth Perspectives</u></h6>
                                    <p>
                                        Learning and growth are analyzed through the investigation of training and
                                        knowledge resources. This handles how well information is captured and how
                                        effectively employees use the information to convert it to a competitive
                                        advantage over the industry.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- c end -->
                    </div>
                    <!-- tab 1 end -->
                    <!-- tab 2 start  -->
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"
                        tabindex="0">
                        <div class="table-responsive mt-4">
                            <table class="table table2-1">
                                <thead>
                                    <thead>
                                        <tr>
                                            <th>GOALS & OBJECTIVES</th>
                                            <th>Weightage</th>
                                            <th>ACTUAL</th>
                                            <th>TARGET</th>
                                            <th>TIME FRAME</th>
                                            <th>%age of Achievement</th>
                                            <th>Progress</th>
                                            <th>NOTES</th>
                                        </tr>
                                        <tr>
                                            <td
                                                style="font-size:10.5px!important;font-weight:500!important;background-color:#E3F4F4!important">
                                                What we want to accomplish & how we are going to accomplish the goal
                                            </td>
                                            <td
                                                style="font-size:10.5px!important;font-weight:500!important;background-color:#E3F4F4!important">
                                                Total weightage of each dimension should be equal to 100</td>
                                            <td
                                                style="font-size:10.5px!important;font-weight:500!important;background-color:#E3F4F4!important">
                                                Current Baseline</td>
                                            <td
                                                style="font-size:10.5px!important;font-weight:500!important;background-color:#E3F4F4!important">
                                                Desired target</td>
                                            <td
                                                style="font-size:10.5px!important;font-weight:500!important;background-color:#E3F4F4!important">
                                                Time it takes to complete </td>
                                            <td
                                                style="font-size:10.5px!important;font-weight:500!important;background-color:#E3F4F4!important">
                                                %age of Achievement</td>
                                            <td
                                                style="font-size:10.5px!important;font-weight:500!important;background-color:#E3F4F4!important">
                                                Overall progress status</td>
                                            <td
                                                style="font-size:10.5px!important;font-weight:500!important;background-color:#E3F4F4!important">
                                                Any additional notes pertaining to each KPI</td>
                                        </tr>
                                    </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="8"
                                            style="font-size:15px!important;background-color:#C9D6DF!important;padding-top:10px!important;padding-bottom:10px!important;">
                                            Operational Efficiency / Process Improvement<span
                                                style="float:right!important">30%</span></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>


                                    <!-- 2 start  -->

                                    <tr>
                                        <td colspan="8"
                                            style="font-size:15px!important;background-color:#C9D6DF!important;padding-top:10px!important;padding-bottom:10px!important;">
                                            Business Enhancement / Strategic Growth<span
                                                style="float:right!important">30%</span></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <!-- 2 end -->

                                    <!-- 3start  -->
                                    <tr>
                                        <td colspan="8"
                                            style="font-size:15px!important;background-color:#C9D6DF!important;padding-top:10px!important;padding-bottom:10px!important;">
                                            System Automation<span style="float:right!important">20%</span></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <!-- 3 end -->


                                    <!-- 4 start  -->
                                    <tr>
                                        <td colspan="8"
                                            style="font-size:15px!important;background-color:#C9D6DF!important;padding-top:10px!important;padding-bottom:10px!important;">
                                            PEOPLE LEARNING & GROWTH<span style="float:right!important">20%</span></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <!-- 4 end  -->

                                </tbody>
                                </thead>
                            </table>
                        </div>
                        <div class="text-center mt-3">
                            <button class="slide" name="submit" style="font-size: 17px; height: 36px; width: 150px;">
                                <span class="text">Submit</span>
                            </button>
                        </div>
                    </div>
                    <!--tab 2 end -->



                    <!-- tab 3 start  -->
                    <div class="tab-pane fade" id="nav-group" role="tabpanel" aria-labelledby="nav-group-tab"
                        tabindex="0">
                        <div class="table-responsive mt-4">
                            <table class="table table3-1">
                                <thead>
                                    <tr>
                                        <th>Milestones</th>
                                        <th>Measuring Tools</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive">
                            <table class="table table3-2">
                                <thead>
                                    <tr>
                                        <th>Action Plan</th>
                                        <th>Start Date</th>
                                        <th>Completed By</th>
                                        <th>Portion</th>
                                        <th>Status</th>
                                        <th>Responsible Person</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                        <td><input type="text" name="" id=""></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- comment start  -->
                        <div class="row mt-3">
                            <div class="col">
                                <div style="background-color:white!important;padding:10px 20px;border:1px solid black">
                                    <div>
                                        <p>HOD Comments <input type="text" placeholder="abc"></p>
                                    </div>
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
            </div>
        </div>
      <?php
    include 'footer.php'
        ?>