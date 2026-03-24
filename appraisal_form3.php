<?php 
    session_start (); 
    include 'dbconfig.php';
    
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php'); // Redirect to the login page
        exit;
    }
    
    // $head_email = $_SESSION['head_email'];
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    //Load Composer's autoloader
    require 'vendor/autoload.php';
    
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Coldeez Syrup</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <!-- Bootstrap CSS CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Our Custom CSS -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <!-- DataTables CSS -->
        <!-- Font Awesome JS -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="assets/css/style.css">
        <!-- fevicon -->
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <style>
            .table2-2 td{
            padding-top: 10px!important;
            padding-bottom: 10px!important;
            font-size: 11px!important;
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
            transition: all 0.3s ease; /* Smooth transition effect */
            }
            .btn-submit:hover {
            color: #0D9276;
            background-color: white;
            border: 2px solid #0D9276;
            }
            .btn{
            font-size: 11px!important;
            }
            a{
            text-decoration:none!important;
            }
            .table-container {
            overflow-y: auto;
            height: 90vh; /* Full viewport height */
            margin: 0;
            padding: 0;
            }
            table {
            width: 100%;
            border-collapse: collapse;
            }
            table th {
            font-size: 12px!important;
            border:none!important;
            background-color: #1B7BBC!important;
            color:white!important;
            }
            table td {
            font-size: 12px;
            color: black;
            padding: 0px!important; /* Adjust padding as needed */
            /* border: 1px solid #ddd; */
            }
            .table_add_service th{
            background-color:white!important;
            color:black!important;
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
            height:25px!important;
            }
            input:focus {
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
            }
            p{
            font-size: 13px!important;
            }
            li{
            font-size: 13px!important;
            }
            .table1-1 th,
            .table1-2 th{
            border:1px solid #1B7BBC!important;
            }
            .table1-1 td,
            .table1-2 td{
            font-size: 12.5px!important;
            padding:5px!important;
            border:1px solid black!important;
            }
            .table2-1 td,
            .table2-2 td,
            .table2-3 td{
            font-size: 12.3px!important;
            padding:5px!important;
            }
            .table2-1 td,
            .table2-2 td,
            .table2-3 td{
            font-size: 12.5px!important;
            padding:5px!important;
            }
            .table3-1 th{
            border:1px solid #1B7BBC!important;
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
            .pagination-scroll {
            overflow-x: auto; /* Enable horizontal scrolling */
            white-space: nowrap; /* Prevent wrapping of pagination buttons */
            width: 100%; /* Full width of the parent container */
            }
            #pagination-controls {
            display: inline-block; /* Ensure the pagination controls are displayed inline to enable scrolling */
            }
        </style>
    </head>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col text-center">
                <a href="profile.php" class="btn btn-dark btn-sm" style="border-radius:0px!important">Home</a>
                <a href="salesmain_productlist.php" class="btn btn-dark btn-sm" style="border-radius:0px!important">Product List</a>
            </div>
        </div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Guildlines</button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Rating</button>
                <button class="nav-link" id="nav-group-tab" data-bs-toggle="tab" data-bs-target="#nav-group" type="button" role="tab" aria-controls="nav-group" aria-selected="false">Development</button>
                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Rating Summary</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <!-- <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="0">...</div> -->
            <!-- tab 1 start  -->
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                <!-- row 1 starts -->
                <div class="row mt-3">
                    <div class="col-md-10">
                        <div style="background-color:white!important;padding:10px 20px;border:1px solid black">
                            <h5 class="text-center py-3" style="font-weight: 400;">Performance Evaluation Plan <br>
                                <span style="font-weight: 400;font-size:14px">For Year 2026</span>
                            </h5>
                            <h6>Purpose</h6>
                            <div>
                                <p> To Conduct performance Management for giving feed back to the appraisee and reinforce performance accordingly</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- row 1 ends -->
                <!-- row 2 starts -->
                <div class="row mt-3">
                    <div class="col-md-10">
                        <div style="background-color:white!important;padding:10px 20px;border:1px solid black">
                            <h6>Guidelines for filling this form</h6>
                            <div>
                                <ol>
                                    <li>Please assess the apraisee in relation to the requirements of his/her present position only.</li>
                                    <li>Your Rating should be as objective as possible</li>
                                    <li>Consider each performance dimension independently, uninfluence by the rating you give to other factors</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- row 2 ends -->
                <!-- row 3 starts -->
                <div class="row mt-3">
                    <div class="col-md-10">
                        <div style="background-color:white!important;padding:10px 20px;border:1px solid black">
                            <h6>Rating Defination</h6>
                            <table class="table table1-1">
                                <thead>
                                    <tr>
                                        <th  style="background-color:#EEEEEE!important;color:black!important">D</th>
                                        <th  style="background-color:#EEEEEE!important;color:black!important">C</th>
                                        <th  style="background-color:#EEEEEE!important;color:black!important">B</th>
                                        <th  style="background-color:#EEEEEE!important;color:black!important">A</th>
                                        <th  style="background-color:#EEEEEE!important;color:black!important">A+</th>
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
                                        <td>Individual does not have capabilities or abilities needed to accomplish basic job requirements</td>
                                        <td>Show inconsistant achievement of job; performance improvement needed</td>
                                        <td>Fulfills performance standard of job. job requirements are met</td>
                                        <td>High quality performance is achieved consistently</td>
                                        <td>Exceptional performance and always exceeds expectation</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- row 3 ends -->
                <!-- row 4 starts -->
                <div class="row mt-3 mb-5">
                    <div class="col-md-10">
                        <div style="background-color:white!important;padding:10px 20px;border:1px solid black">
                            <h6>Rating Criteria</h6>
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
                <!-- row 4 ends -->
            </div>
            <!-- tab 1 end -->
            <!-- tab 2 start  -->
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                <div class="row mt-3">
                    <div class="col">
                        <table class="table table2-1">
                            <thead>
                                <tr>
                                    <td colspan="5">
                                        <h5 class="text-center py-3" style="font-weight: 400;">Performance Evaluation Form </br>
                                            <span style="font-weight: 400;font-size:14px">(for Below Mid-Level Managers)</span>
                                        </h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="font-size:13.5px!important;padding:15px 10px!important;font-weight:500">Key Performance Indicator (40% weightage).</br> 
                                        <span  style="font-size:12.7px!important;!important;font-weight:400">The Rating should be 1 to 5 where 1 unsatisfactory and 5 is exceptional</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Sn#</th>
                                    <th>KPI  Description</th>
                                    <th>Benchmark</th>
                                    <th>Achievement</th>
                                    <th>Final score</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
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
                                </tr>
                                <tr>
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
                                </tr>
                                <tr>
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
                                </tr>
                                <tr>
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
                                </tr>
                                <tr>
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
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table2-2">
                            <thead>
                                <tr>
                                    <td colspan="5" style="font-size:13.5px!important;padding:15px 10px!important;font-weight:500">Behavioral Commpetencies (30% Weightage)</br> 
                                        <span  style="font-size:12.7px!important;!important;font-weight:400">The rating should be 1 to 5 where 1 is unsatisfactory and 5 is exceptional</span>
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
                                    <td><b>Adaptability:</b> Adjusting own behaviors to work efficiency and effectivly</td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td><b>Contious Learning:</b> Identifying and addressing individuals strength and weakness <br> to enchance personal and organizational performance</td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td><b>Communication:</b> Listening to others and communication in an  <br> affective manner that fosters open communication</td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                </tr>
                                <tr>
                                    <td class="text-center">4</td>
                                    <td><b>Conflict Management:</b> Preventing, managing and/or resolving conflicts</td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                </tr>
                                <tr>
                                    <td class="text-center">5</td>
                                    <td><b>Planning and organizing:</b> Defining tasks and milestones to achieve objectives, while <br> ensuring the optional use of resources</td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                </tr>
                                <tr>
                                    <td class="text-center">6</td>
                                    <td><b>Flexibility:</b> Ability to adapt to and work with a variety of situation, individual and groups</td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                </tr>
                                <tr>
                                    <td class="text-center">7</td>
                                    <td><b>Initiative:</b> Identifying and dealing with issues proactively and persistently; seizing <br> oppurtunities that aries</td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                </tr>
                                <tr>
                                    <td class="text-center">8</td>
                                    <td><b>Results Orientation:</b> Focusing personal effects on achieving results, consistent with <br> the organization objective.</td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                </tr>
                                <tr>
                                    <td class="text-center">9</td>
                                    <td><b>Team work:</b> Working collaboratively with others to achieve common goals and <br> positive results</td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                </tr>
                                <tr>
                                    <td class="text-center">10</td>
                                    <td style="font-size:10.5px!important"><b>Integrity:</b> Acting in a way that is consistent with what one says; that is. one's <br> behavior is consistent with one's value</td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- table 2.3 -->
                        <table class="table table2-3">
                            <thead>
                                <tr>
                                    <td colspan="5" style="font-size:13.5px!important;padding:15px 10px!important;font-weight:500">Performance Commpetencies (30% Weightage)</br> 
                                        <span  style="font-size:12.7px!important;!important;font-weight:400">The rating should be 1 to 5 where 1 is unsatisfactory and 5 is exceptional</span>
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
                                    <td><b>Knowdledge Excellence:</b> Adhere to organizational policies and procedure. Evaluate and <br> address issue surrounding equipment and/or operation</td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td><b>Professional Confidence:</b> Ability to do the job. providing an opinion or advice when <br>  neccessary</td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td><b>Planning and Organizing:</b> Define task and milestones tp achieve objectives while <br> ensuring the optional use of resources</td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                </tr>
                                <tr>
                                    <td class="text-center">4</td>
                                    <td><b>Conflict Management:</b> Preventing, managing and/or resolving conflicts</td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                </tr>
                                <tr>
                                    <td class="text-center">5</td>
                                    <td><b>Quality of work:</b> Complete assignment in time with effectiveness & efficiency</td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                </tr>
                                <tr>
                                    <td class="text-center">6</td>
                                    <td><b>Quantity of work:</b> Works collaboratively with others to achieve common goals and positive results</td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row mt-3">
                            <div class="col-md-10">
                                <div style="background-color:white!important;padding:10px 20px;border:1px solid black">
                                    <div>
                                        <p>Employee Comment: <input type="text" placeholder="abc"></p>
                                        <p>Reviewer Comment: <input type="text" placeholder="abc"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3 mb-3">
                            <button type="submit" class="btn-submit" name="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--tab 2 end -->
            <!-- tab 3 start  -->
            <div class="tab-pane fade" id="nav-group" role="tabpanel" aria-labelledby="nav-group-tab" tabindex="0">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div style="background-color:white!important;padding:10px 20px;border:1px solid black">
                            <h5 class="text-center py-3" style="font-weight: 400;">Annual Development Plan</br>
                                <span style="font-weight: 400;font-size:14px">For The Year</span>
                            </h5>
                            <div>
                                <p  style="margin: 0px !important;padding:0px!important;font-size:13px!important">Manager will sign when individual development plan achieved</p>
                                <p style="margin: 0px !important;padding:0px!important;font-size:13px!important">Please do not indicate more than 5 areas.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h6></h6>
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
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div style="background-color:white!important;padding:10px 20px;border:1px solid black">
                                    <h6>Listed below are some of the suggested area of trainning for the employee. Please
                                        select those area of training. which you consider most important for the appraisee
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
                                                <p style="font-weight:600" class="pt-3">Supervisory / Managerial Skills</p>
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
                        <div class="text-center mt-3 mb-3">
                            <button type="submit" class="btn btn-submit" name="submit" style="font-size: 20px">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- tab 3 end -->
            <!-- tab 4 start  -->
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col pt-md-2">
                            <form class="form pb-3" method="POST" style="border: 1px solid black; padding: 20px; padding-bottom: 0px; border-radius: 2px;background-color:white!important" >
                                <!-- <table class="table table4-1">
                                    <tr>
                                        <th style="width:30%!important">Employee Name</th>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <th>Employee ID</th>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <th>Designation</th>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <th>Department</th>
                                        <td><input type="text"></td>
                                    </tr>
                                    </table> -->
                                <table class="table table4-2">
                                    <thead >
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
                                <h6>Percentage Achieve - #DIV0</h6>
                                <h6>Grage - #DIV0</h6>
                                <div class="text-center mt-3">
                                    <button type="submit" class="btn-submit" name="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- tab 4 end -->
            </div>
        </div>
    </div>
    <!-- conatiner -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
    <script type="text/javascript">
        document.getElementById('excel1').addEventListener('click', function() {
            var table = document.getElementById('myTable1');
            var workbook = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
            XLSX.writeFile(workbook, 'export.xlsx');
        });
    </script>
    <script type="text/javascript">
        document.getElementById('excel2').addEventListener('click', function() {
            var table = document.getElementById('myTable2');
            var workbook = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
            XLSX.writeFile(workbook, 'export.xlsx');
        });
    </script>
    <script type="text/javascript">
        document.getElementById('excel3').addEventListener('click', function() {
            var table = document.getElementById('myTable3');
            var workbook = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
            XLSX.writeFile(workbook, 'export.xlsx');
        });
    </script>
    <script type="text/javascript">
        document.getElementById('excel4').addEventListener('click', function() {
            var table = document.getElementById('myTable4');
            var workbook = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
            XLSX.writeFile(workbook, 'export.xlsx');
        });
    </script>
    <script>
        $(document).ready(function () {
        (function ($) {
            $('#filter1').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.searchable1 tr').hide();
                $('.searchable1 tr').filter(function () {
                    return rex.test($(this).text());
                }).show();
            })
        }(jQuery));
        });
    </script>
    <script>
        $(document).ready(function () {
        (function ($) {
            $('#filter2').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.searchable2 tr').hide();
                $('.searchable2 tr').filter(function () {
                    return rex.test($(this).text());
                }).show();
            })
        }(jQuery));
        });
    </script>
    <script>
        $(document).ready(function () {
        (function ($) {
            $('#filter3').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.searchable3 tr').hide();
                $('.searchable3 tr').filter(function () {
                    return rex.test($(this).text());
                }).show();
            })
        }(jQuery));
        });
    </script>
    <script>
        $(document).ready(function () {
        (function ($) {
            $('#filter4').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.searchable4 tr').hide();
                $('.searchable4 tr').filter(function () {
                    return rex.test($(this).text());
                }).show();
            })
        }(jQuery));
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
    <script src="assets/js/main.js"></script>
    <script>
        $(document).ready(function() {
            let offset = 0; // Initial offset
            const limit = 100; // Number of rows per page
            const $dataBody = $('#data-body');
            const $paginationControls = $('#pagination-controls');
            const $filterInput = $('#filter2');
        
            function loadData() {
                $.ajax({
                    url: 'fetchData_coldeez.php', // Adjust this URL to your backend script
                    type: 'GET',
                    data: {
                        limit: limit,
                        offset: offset,
                        search: $filterInput.val() // Include the search term
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.data) {
                            // Update table with new data
                            $dataBody.html(response.data.rows);
                            
                            // Update pagination controls
                            $paginationControls.html(response.data.pagination);
                            
                            // Update offset
                            offset = response.nextOffset;
                        }
                    }
                });
            }
        
            // Load initial data
            loadData();
        
            // Handle pagination controls click
            $paginationControls.on('click', 'button', function() {
                let newOffset = $(this).data('offset');
                if (newOffset !== undefined) {
                    offset = newOffset;
                    loadData();
                }
            });
        
            // Handle search input change
            $filterInput.on('input', function() {
                offset = 0; // Reset offset when searching
                loadData();
            });
        });
    </script>
    </body>
</html>