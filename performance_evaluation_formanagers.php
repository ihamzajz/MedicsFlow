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
                <!-- <div>
                    <a class="btn btn-dark btn-sm" href="appraisal_forms.php"><i class="fa-solid fa-home"></i> Home</a>

                </div> -->
                <nav class="mt-2">
                    <div class="nav nav-tabs " id="nav-tab" role="tablist">
                        <button class="nav-link active mt-md-0 mt-1" id="nav-home-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                            aria-selected="true">Guildlines</button>
                        <button class="nav-link  mt-md-0 mt-1" id="nav-profile-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                            aria-selected="false">Rating</button>
                        <button class="nav-link  mt-md-0 mt-1" id="nav-group-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-group" type="button" role="tab" aria-controls="nav-group"
                            aria-selected="false">Development</button>
                        <button class="nav-link  mt-md-0 mt-1" id="nav-contact-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact"
                            aria-selected="false">Rating Summary</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <!-- <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="0">...</div> -->
                    <!-- tab 1 start  -->
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                        tabindex="0">
                        <!-- row 1 starts -->
                        <div class="row mt-3">
                            <div class="col">
                                <div style="background-color:white!important;padding:10px 20px;border:1px solid black">
                                    <!-- <h5 class="text-center py-3" style="font-weight: 400;">Performance Evaluation Plan
                                        <br>
                                        <span style="font-weight: 400;font-size:14px">For Year 2026</span>
                                    </h5> -->
                                    <div class="d-flex align-items-center justify-content-between bg-white py-3">
                                        <!-- Left: Home Button -->
                                        <a class="btn btn-dark btn-sm" href="appraisal_forms.php">
                                            <i class="fa-solid fa-home"></i> Home
                                        </a>

                                        <!-- Center: Heading -->
                                        <div class="flex-grow-1 text-center">
                                            <h5 class="m-0" style="font-weight: 600;">
                                                Performance Evaluation Plan<br>
                                                <span style="font-weight: 400; font-size: 14px;">For Year 2026</span>
                                            </h5>
                                        </div>

                                        <!-- Right: Empty placeholder to balance layout -->
                                        <div style="width:70px;"></div>
                                    </div>
                                    <h6>Purpose</h6>
                                    <div>
                                        <p> To Conduct performance Management for giving feed back to the appraisee and
                                            reinforce performance accordingly</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- row 1 ends -->
                        <!-- row 2 starts -->
                        <div class="row mt-3">
                            <div class="col">
                                <div style="background-color:white!important;padding:10px 20px;border:1px solid black">
                                    <h6>Guidelines for filling this form</h6>
                                    <div>
                                        <ol>
                                            <li>Please assess the apraisee in relation to the requirements of his/her
                                                present position only.</li>
                                            <li>Your Rating should be as objective as possible, Please do not let
                                                personal prejudices influence your appraisal.</li>
                                            <li>Consider each performance dimension independently, uninfluence by the
                                                rating you give to other factors.</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- row 2 ends -->
                        <!-- row 3 starts -->
                        <div class="row mt-3">
                            <div class="col">
                                <div style="background-color:white!important;padding:10px 20px;border:1px solid black">
                                    <h6>Rating Defination</h6>
                                    <div class="table-responsive">
                                        <table class="table table1-1">
                                            <thead>
                                                <tr>
                                                    <th
                                                        style="background-color:#EEEEEE!important;color:black!important">
                                                        D</th>
                                                    <th
                                                        style="background-color:#EEEEEE!important;color:black!important">
                                                        C</th>
                                                    <th
                                                        style="background-color:#EEEEEE!important;color:black!important">
                                                        B</th>
                                                    <th
                                                        style="background-color:#EEEEEE!important;color:black!important">
                                                        A</th>
                                                    <th
                                                        style="background-color:#EEEEEE!important;color:black!important">
                                                        A+</th>
                                                </tr>
                                                <tr>
                                                    <th>1) Unsatisfactory</th>
                                                    <th>2) Need Development</th>
                                                    <th>3) Meet Requirements</th>
                                                    <th>4) Exceed Expectations</th>
                                                    <th>5) Exceptional</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Individual does not have capabilities or abilities needed to
                                                        accomplish basic job requirements</td>
                                                    <td>Show inconsistant achievement of job; performance improvement
                                                        needed</td>
                                                    <td>Fulfills performance standard of job. job requirements are met
                                                    </td>
                                                    <td>High quality performance is achieved consistently</td>
                                                    <td>Exceptional performance and always exceeds expectation</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- row 3 ends -->
                        <!-- row 4 starts -->
                        <div class="row mt-3 mb-5">
                            <div class="col">
                                <div style="background-color:white!important;padding:10px 20px;border:1px solid black">
                                    <h6>Rating Criteria</h6>
                                    <div class="table-responsive">
                                        <table class="table table1-2">
                                            <thead>
                                                <tr>
                                                    <th>Performance Rating</th>
                                                    <th>Performance Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>A+</td>
                                                    <td>100% to 91%</td>
                                                </tr>
                                                <tr>
                                                    <td>A+</td>
                                                    <td>90% to 80%</td>
                                                </tr>
                                                <tr>
                                                    <td>B</td>
                                                    <td>79% to 61%</td>
                                                </tr>
                                                <tr>
                                                    <td>C</td>
                                                    <td>60% to 50%</td>
                                                </tr>
                                                <tr>
                                                    <td>D</td>
                                                    <td>below 50%</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- row 4 ends -->
                    </div>
                    <!-- tab 1 end -->
                    <!-- tab 2 start  -->
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"
                        tabindex="0">
                        <div class="row mt-3">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table table2-1">
                                        <thead>
                                            <tr>
                                                <td colspan="5"
                                                    style="font-size:13.5px!important;padding:15px 10px!important;font-weight:500">
                                                    <a style="float:left!important" class="btn btn-dark btn-sm"
                                                        href="appraisal_forms.php"><i class="fa-solid fa-home"></i>
                                                        Home</a>
                                                    <h5 style="font-weight:500!important">&nbsp;&nbsp;&nbsp;Yearly
                                                        Objective (50% Weightage)</h5></br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width:30px!important">Sn#</th>
                                                <th>Description</th>
                                                <th>Weightage</th>
                                                <th>Achievement</th>
                                                <th>Final Score</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td><b>Operational efficiency:</b></br>Goals and objectives
                                                    demonstrating</br>effectiveness of various
                                                    departmental</br>functions and processes (operations)</td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2</td>
                                                <td><b>Business enhancement / strategic growth:</b></br>Strategies and
                                                    measures to develop and</br>implement growth opportunities
                                                    aiming</br>to increase business (where applicable).</td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">3</td>
                                                <td><b>System automation:</b></br>Help to identify current manual
                                                    practices</br>for process improvement through system</br>automation
                                                    and reduction in manual processes</td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">5</td>
                                                <td><b>People learning and growth:</b></br>This handles how well
                                                    information is</br>transferred and captured.</td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">6</td>
                                                <td><b>Any other focus area:</b></br>Any other focus area you want
                                                    to</br>mention related to your department.</td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table2-2">
                                        <thead>
                                            <tr>
                                                <td colspan="5"
                                                    style="font-size:13.5px!important;padding:15px 10px!important;font-weight:500">
                                                    Behavioral Commpetencies (25% Weightage)</br>
                                                    <span
                                                        style="font-size:12.7px!important;!important;font-weight:400">The
                                                        rating should be 1 to 5 where 1 is unsatisfactory and 5 is
                                                        exceptional</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width:5px!important">Sn#</th>
                                                <th>Description</th>
                                                <th>Rating</th>
                                                <th>%age</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="">
                                                <td class="text-center">1</td>
                                                <td><b>Adaptability:</b></br>Adjusting own behaviors to work
                                                    efficiency</br> and effectivly</td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2</td>
                                                <td><b>Analytical thinking:</b> Interpreting, linking,</br>and analyzing
                                                    information in order to</br>understand issues.</td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">3</td>
                                                <td><b>Communication:</b></br>Listening to others and communication
                                                    in</br>an affective manner that fosters open</br>communication</td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">4</td>
                                                <td><b>Creative thinking and innovation:</b></br>Listening to others and
                                                    communicating</br>effectively to foster open and
                                                    collaborative</br>communication</td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">5</td>
                                                <td><b>Decision making:</b></br>Making decisions and solving
                                                    problems</br>involving varying levels of complexity,</br>ambiguity,
                                                    and risk</td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">6</td>
                                                <td><b>Developing others:</b></br>Fostering the development of others
                                                    by</br>providing a supportive environment for</br>enhanced
                                                    performance and growth</td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">7</td>
                                                <td><b>Continuous learning:</b></br>Identifying and addressing
                                                    individual</br>strengths, weaknesses, development</br>needs, and
                                                    adapting to changing circumstances</td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">8</td>
                                                <td><b>Result orientation:</b></br>Focusing personal effort on
                                                    achieving</br>results</td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">9</td>
                                                <td><b>Team leadership:</b></br>Leading and supporting a team to achieve
                                                    results</td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">10</td>
                                                <td><b>Integrity:</b></br>Acting in a way that is consistent with
                                                    what</br>one says; that is. one's behavior is consistent</br>with
                                                    one's value</td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- table 2.3 -->
                                <div class="table-responsive">
                                    <table class="table table2-3">
                                        <thead>
                                            <tr>
                                                <td colspan="5"
                                                    style="font-size:13.5px!important;padding:15px 10px!important;font-weight:500">
                                                    Performance Commpetencies (25% Weightage)</br>
                                                    <span
                                                        style="font-size:12.7px!important;!important;font-weight:400">The
                                                        rating should be 1 to 5 where 1 is unsatisfactory and 5 is
                                                        exceptional</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width:30px!important">Sn#</th>
                                                <th>Description</th>
                                                <th>Rating</th>
                                                <th>%age</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td><b>Knowdledge Excellence:</b></br>Adhere to organizational policies
                                                    and</br>procedure. Evaluate and address
                                                    issue</br>surrounding</br>equipment and/or operation</td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2</td>
                                                <td><b>Strategic management:</b></br>Demonstrating an intimate
                                                    understanding</br>of the capabilities, nature, and potential
                                                    of</br>the business</td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">3</td>
                                                <td><b>People management:</b></br>Ability to train others and a
                                                    willingness to</br>do so gladly</td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">5</td>
                                                <td><b>Quality of work:</b></br>Complete assignment in time
                                                    with</br>effectiveness & efficiency</td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">6</td>
                                                <td><b>Quantity of work:</b></br>Works collaboratively with others to
                                                    achieve</br>common goals and positive results</td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- comment start  -->
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <div
                                            style="background-color:white!important;padding:10px 20px;border:1px solid black">
                                            <div>
                                                <p>Employee Comments: <input type="text" placeholder="abc"></br><input
                                                        type="text" placeholder="abc"></p>
                                                <p>Reviser Comments: <input type="text" placeholder="abc"></br><input
                                                        type="text" placeholder="abc"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center mt-3 mb-5">
                                        <button class="slide" name="submit"
                                            style="font-size: 17px; height: 36px; width: 150px;">
                                            <span class="text">Submit</span>
                                        </button>
                                    </div>
                                </div>
                                <!-- comment end -->


                            </div> <!-- End of .col -->
                        </div> <!-- End of .row mt-3 -->
                    </div> <!-- End of .tab-pane -->
                    <!--tab 2 end -->
                    <!-- tab 3 start  -->
                    <div class="tab-pane fade" id="nav-group" role="tabpanel" aria-labelledby="nav-group-tab"
                        tabindex="0">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div style="background-color:white!important;padding:10px 20px;border:1px solid black">
                                    <!-- <h5 class="text-center py-3" style="font-weight: 400;">Annual Development Plan</br>
                                        <span style="font-weight: 400;font-size:14px">For The Year</span>
                                    </h5> -->


                                    <div class="d-flex align-items-center justify-content-between bg-white py-3">
                                        <!-- Left: Home Button -->
                                        <a class="btn btn-dark btn-sm" href="appraisal_forms.php">
                                            <i class="fa-solid fa-home"></i> Home
                                        </a>

                                        <!-- Center: Heading -->
                                        <div class="flex-grow-1 text-center">
                                            <h5 class="m-0" style="font-weight: 600;">
                                                Annual Development Plan<br>
                                                <span style="font-weight: 400; font-size: 14px;">For The Year</span>
                                            </h5>
                                        </div>

                                        <!-- Right: Empty placeholder to balance layout -->
                                        <div style="width:70px;"></div>
                                    </div>
                                    <div>
                                        <p
                                            style="margin: 0px !important;padding:0px!important;font-size:13px!important">
                                            Manager will sign when individual development plan achieved</p>
                                        <p
                                            style="margin: 0px !important;padding:0px!important;font-size:13px!important">
                                            Please do not indicate more than 5 areas.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table table3-3">
                                        <thead>
                                            <tr>
                                                <th style="width:30px!important">Sno#</th>
                                                <th>Development Plan</th>
                                                <th>Resources Required</th>
                                                <th>Expected time to complete</th>
                                                <th>Actual time to complete</th>
                                                <th>Manager Sign</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <div
                                            style="background-color:white!important;padding:10px 20px;border:1px solid black">
                                            <h6>Listed below are some of the suggested area of trainning for the
                                                employee. Please
                                                select those area of training. which you consider most important for the
                                                appraisee
                                                in performaing her/his present assignments
                                            </h6>
                                            <div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p style="font-weight:600" class="pt-3">Personal Development</p>
                                                        <ol>
                                                            <li>Communication Skill</li>
                                                            <li>Analytics Skills (Tools Learning)</li>
                                                            <li>Time and Stress Management</li>
                                                            <li>Conflict Management</li>
                                                            <li>Any Job related certification / job</li>
                                                        </ol>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p style="font-weight:600" class="pt-3">Supervisory / Managerial
                                                            Skills</p>
                                                        <ol>
                                                            <li>Interviewing Skill</li>
                                                            <li>Counseling and coaching employee</li>
                                                            <li>Leading and motivating employee</li>
                                                            <li>Emotional Intelligence</li>
                                                            <li>Learn Processing Tool</li>
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mt-3 mb-5">
                                    <button class="slide" name="submit"
                                        style="font-size: 17px; height: 36px; width: 150px;">
                                        <span class="text">Submit</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab"
                        tabindex="0">
                        <div class="row">
                            <div class="col">
                                <div class="mt-1">
                                    <a class="btn btn-dark btn-sm" href="appraisal_forms.php"><i
                                            class="fa-solid fa-home "></i> Home</a>

                                </div>
                                <div class="table-responsive">
                                    <table class="table table4-2 mt-1">
                                        <thead>
                                            <tr>
                                                <th style="width:30px!important">Sno#</th>
                                                <th>Performance Attribute</th>
                                                <th>Total Point</th>
                                                <th>Annual Review Rating</th>
                                                <th>Annual Review Point</th>
                                                <th>Final Points</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p><b>Percentage Achieve - #DIV0</b></p>
                                <p><b>Grade - #DIV0</b></p>
                            </div>
                        </div>
                        <!-- comment start  -->
                        <div class="row mt-3">
                            <div class="col">
                                <div style="background-color:white!important;padding:10px 20px;border:1px solid black">
                                    <div>
                                        <p>Managers Recommendation <input type="text" placeholder="abc"></p>

                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-3 mb-5">
                                <button class="slide" name="submit"
                                    style="font-size: 17px; height: 36px; width: 150px;">
                                    <span class="text">Submit</span>
                                </button>
                            </div>
                        </div>
                        <!-- comment end -->
                        </form>
                    </div>
                </div>
            </div>
            <!-- tab 4 end -->
        </div>
    </div>
    </div>
    <?php
    include 'footer.php'
        ?>