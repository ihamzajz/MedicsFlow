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
        <title>Joint Visit Form</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/style.css">
        <style>
            body{
                background-color: white!important;
            }
            .table{
                background-color: #F4F9F9;
                padding: 20px;
                box-shadow: 1px 1px 1px #888888;
            }
            .step{
            color: green;
            text-align: right;
            }
            h6{
            color: #2f89fc;
            }
            .tds{
            width: 200px;
            }
            table td,th{
            border: none!important;
            }
            td,th{
            padding: 2px!important;
            font-size: 12px!important;
            }
            th{
            width: 300px!important;
            }
        </style>
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
                                <form class="form pb-3" method="POST" id="bonusForm" style="border: 2px solid white; padding: 25px; padding-bottom: 0px; border-radius: 5px;background-color:white">
                                    <h2 class="text-center pb-3" style="font-size: 25px; color: #2f89fc; font-weight: bolder;">Joint Visit Form</h2>
                                    <div class="row">
                                        <div class="col-md-12 d-flex flex-column">
                                            <table class="table table-responsive" style="background-color: #FFFAB7;padding:20px">
                                                <tbody id="table-body flex-grow-1">
                                                    <tr>
                                                        <th>Development Plan</th>
                                                        <td class="tds"><input type="text" name="development_plan" class="width"></td>
                                                        <th>Date of Coaching Session</th>
                                                        <td class="tds"><input type="date" name="date_of_coaching_session" class="width"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Overall Score New</th>
                                                        <td class="tds"><input type="text" name="overall_score_new" class="width"></td>
                                                        <th>Coaching Session with</th>
                                                        <td class="tds"><input type="text" name="coaching_session_with" class="width"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Score Total New</th>
                                                        <td class="tds"><input type="text" name="score_total_new" class="width"></td>
                                                        <th>Is First this Month</th>
                                                        <td class="tds"><input type="text" name="is_first_this_month" class="width"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Score</th>
                                                        <td class="tds"><input type="text" name="total_score" class="width"></td>
                                                        <th>Reviewed</th>
                                                        <td class="tds"><input type="text" name="reviewed" class="width"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Professional Call Model</th>
                                                        <td class="tds"><input type="text" name="professional_call_model" class="width"></td>
                                                        <th>MR Level</th>
                                                        <td class="tds"><input type="text" name="mr_level" class="width"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Smooth Delivery and Use of Bridging Statement</th>
                                                        <td class="tds"><input type="text" name="smooth_delivery" class="width"></td>
                                                        <th>Years In Positions</th>
                                                        <td class="tds"><input type="text" name="years_in_positions" class="width"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 d-flex flex-column" data-aos="fade-up" data-aos-duration="4000">
                                                <table class="table table-responsive flex-grow-1">
                                                <thead>
                                                        <tr>
                                                            <th colspan="2">
                                                            <h6>Preparation</h6>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="table-body-1">
                                                        
                                                        <tr>
                                                            <th>Brick Sales Review</th>
                                                            <td class="tds"><input type="number" name="brick_sales" min="1" max="5" class="width" oninput="score1()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Territory Target Known & Owned</th>
                                                            <td class="tds"><input type="number" name="territory_target" min="1" max="5" class="width" oninput="score1()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Route Plane for Total Cycle Completed</th>
                                                            <td class="tds"><input type="number" name="route_plane" min="1" max="5" class="width" oninput="score1()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Review Call Note</th>
                                                            <td class="tds"><input type="number" name="review_call" min="1" max="5" class="width" oninput="score1()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Smart Call Objective</th>
                                                            <td class="tds"><input type="number" name="smart_call" min="1" max="5" class="width" oninput="score1()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Review Key Contact Data</th>
                                                            <td class="tds"><input type="number" name="review_key" min="1" max="5" class="width" oninput="score1()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Overall evaluation Of Sales Representative </th>
                                                            <td class="tds"><input type="number" name="overall_evaluation" min="1" max="5" class="width" oninput="score1()"></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="step">Step 1 Score <input type="number" id="score_1" name="score_1" readonly></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-6 d-flex flex-column" data-aos="fade-up" data-aos-duration="4000">
                                                <table class="table table-responsive flex-grow-1">
                                                <thead>
                                                        <tr>
                                                            <th colspan="2">
                                                            <h6>Pharmacy Visit</h6>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="table-body-2">
                                                        
                                                        <tr>
                                                            <th>Check Sales Tools, Equipment/Material</th>
                                                            <td class="tds"><input type="number" name="check_sales" min="1" max="5" class="width" oninput="score2()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>External & Internal Visual Evaluation</th>
                                                            <td class="tds"><input type="number" name="external_internal" min="1" max="5" class="width" oninput="score2()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Introduction to Staff</th>
                                                            <td class="tds"><input type="number" name="introduction_to" min="1" max="5" class="width" oninput="score2()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Check Price and Promotional Activities</th>
                                                            <td class="tds"><input type="number" name="check_price" min="1" max="5" class="width" oninput="score2()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Listen Recommendation/ Habits of Staff</th>
                                                            <td class="tds"><input type="number" name="listen_recommendation" min="1" max="5" class="width" oninput="score2()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Identify 1 or 2 opportunities</th>
                                                            <td class="tds"><input type="number" name="identify_1_2" min="1" max="5" class="width" oninput="score2()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Review/Adjust Call Objectives</th>
                                                            <td class="tds"><input type="number" name="review_adjust_call" min="1" max="5" class="width" oninput="score2()"></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="step">Step 2 Score <input type="number" id="score_2" name="score_2" readonly></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 d-flex flex-column" data-aos="fade-up" data-aos-duration="4000">
                                                <table class="table table-responsive flex-grow-1">
                                                <thead>
                                                        <tr>
                                                            <th colspan="2">
                                                            <h6>Customer Development</h6>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="table-body-3">
                                                        <tr>
                                                            <th>Summarize the Situation</th>
                                                            <td class="tds"><input type="number" name="summarize_the_Situation" min="1" max="5" class="width"  oninput="score3()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Explore Needs</th>
                                                            <td class="tds"><input type="number" name="explore_need" min="1" max="5" class="width" oninput="score3()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>State the Idea</th>
                                                            <td class="tds"><input type="number" name="state_the_idea" min="1" max="5" class="width" oninput="score3()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Emphasize & Use of Features and Benefits</th>
                                                            <td class="tds"><input type="number" name="emphasize_use" min="1" max="5" class="width" oninput="score3()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Close Effectively</th>
                                                            <td class="tds"><input type="number" name="close_effectively" min="1" max="5" class="width" oninput="score3()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Handle Objections</th>
                                                            <td class="tds"><input type="number" name="handle_objections" min="1" max="5" class="width" oninput="score3()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Take the Order</th>
                                                            <td class="tds"><input type="number" name="take_the_order" min="1" max="5" class="width" oninput="score3()"></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="step">Step 3 Score <input type="number" id="score_3" name="score_3" readonly></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-6 d-flex flex-column" data-aos="fade-up" data-aos-duration="4000">
                                                <table id="table-body-4" class="table table-responsive flex-grow-1">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2">
                                                            <h6>Visibility</h6>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="table-body-3">
                                                        <tr>
                                                            <th>Implement Actions of Call Objectives</th>
                                                            <td class="tds"><input type="number" name="implement_action" min="1" max="5" class="width" oninput="score4()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Display</th>
                                                            <td class="tds"><input type="number" name="display" min="1" max="5" class="width" oninput="score4()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Shelving</th>
                                                            <td class="tds"><input type="number" name="shelving" min="1" max="5" class="width" oninput="score4()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Price & Promotions</th>
                                                            <td class="tds"><input type="number" name="price_promotions" min="1" max="5" class="width" oninput="score4()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Range availability</th>
                                                            <td class="tds"><input type="number" name="range_availability" min="1" max="5" class="width" oninput="score4()"></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="step">Step 4 Score <input type="number" id="score_4" name="score_4" readonly></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 d-flex flex-column" data-aos="fade-up" data-aos-duration="4000">
                                                <table class="table table-responsive flex-grow-1">
                                                <thead>
                                                        <tr>
                                                            <th colspan="2">
                                                            <h6>Advocacy</h6>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="table-body-5">
                                                        <tr>
                                                            <th>Understand who does what</th>
                                                            <td class="tds"><input type="number" name="understand_who_does_what" min="1" max="5" class="width" oninput="score5()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Complete Pharmacy Staff Training</th>
                                                            <td class="tds"><input type="number" name="complete_pharmacy" min="1" max="5" class="width" oninput="score5()"></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="step">Step 5 Score <input type="number" id="score_5" name="score_5" readonly></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-6 d-flex flex-column" data-aos="fade-up" data-aos-duration="4000">
                                                <table class="table table-responsive flex-grow-1">
                                                <thead>
                                                        <tr>
                                                            <th colspan="2">
                                                            <h6>Closing</h6>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="table-body-6">     
                                                        <tr>
                                                            <th>Confirm All Agreement with Customers</th>
                                                            <td class="tds"><input type="number" name="confirm_all_agreement" min="1" max="5" class="width" oninput="score6()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Order confirmation to list</th>
                                                            <td class="tds"><input type="number" name="order_confirmation" min="1" max="5" class="width" oninput="score6()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Update log file</th>
                                                            <td class="tds"><input type="number" name="update_log_file" min="1" max="5" class="width" oninput="score6()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Post Call Analysis</th>
                                                            <td class="tds"><input type="number" name="post_call_analysis" min="1" max="5" class="width" oninput="score6()"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Feedback</th>
                                                            <td class="tds"><input type="number" name="feedback" min="1" max="5" class="width" oninput="score6()"></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="step">Step 6 Score <input type="number" id="score_6" name="score_6" readonly></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 d-flex flex-column" data-aos="fade-up" data-aos-duration="4000">
                                                <table class="table table-responsive flex-grow-1">
                                                <thead>
                                                        <tr>
                                                            <th colspan="2">
                                                            <h6>Next joint visit objectives (max.2) and agreed actions</h6>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="table-body">
                                                        <tr>
                                                            <th>Objective 1</th>
                                                            <td class="tds"><input type="text" name="objective_1" min="1" max="5" class="width"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Action </th>
                                                            <td class="tds"><input type="text" name="action_1" min="1" max="5" class="width"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Objective 2</th>
                                                            <td class="tds"><input type="text" name="objective_2" min="1" max="5" class="width"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Action </th>
                                                            <td class="tds"><input type="text" name="action_2" min="1" max="5" class="width"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-6" data-aos="fade-up" data-aos-duration="4000">
                                                <div>
                                                    <h6 class="pr-4">Comments</h6>
                                                    <textarea name="comments" id="" rows="3" cols="50"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-2">
                                                <button type="submit" class="btn text-uppercase" style="background-color: #2f89fc;color: white;font-size: 17px;" name="submit" style="font-size: 20px">Submit</button>
                                            </div>
                                        </div>
                                </form>
                                </div>
                                <?php
                                    include 'dbconfig.php';
                                    if (isset($_POST['submit'])) {
                                    
                                    date_default_timezone_set("Asia/Karachi");
                                    
                                       $id =  $_SESSION['id'];
                                       $name =  $_SESSION['fullname'];
                                       $email =  $_SESSION['email'];
                                       $username =  $_SESSION['username'];
                                       $department = $_SESSION['department'];
                                       $role =  $_SESSION['role'];
                                       $date =  date('Y-m-d H:i:s');
                                    
                                       $head_email =  $_SESSION['head_email'];
                                    
                                       $be_depart =  $_SESSION['be_depart'];
                                       $be_role =  $_SESSION['be_role'];
                                    
                                       $development_plan =  $_POST['development_plan'];
                                       $date_of_coaching_session = $_POST['date_of_coaching_session'];
                                       $overall_score_new = $_POST['overall_score_new'];
                                       $coaching_session_with = $_POST['coaching_session_with'];
                                       $score_total_new = $_POST['score_total_new'];
                                       $is_first_this_month = $_POST['is_first_this_month'];
                                    
                                       $total_score = $_POST['total_score'];
                                       $reviewed = $_POST['reviewed'];
                                       $professional_call_model = $_POST['professional_call_model'];
                                       $mr_level = $_POST['mr_level'];
                                       $smooth_delivery = $_POST['smooth_delivery'];
                                       $years_in_positions = $_POST['years_in_positions'];

                                       $brick_sales = $_POST['brick_sales'];
                                       $territory_target = $_POST['territory_target'];
                                       $route_plane = $_POST['route_plane'];
                                       $review_call = $_POST['review_call'];
                                       $smart_call = $_POST['smart_call'];
                                       $review_key = $_POST['review_key'];
                                       $overall_evaluation = $_POST['overall_evaluation'];
                                       $check_sales = $_POST['check_sales'];
                                       $external_internal = $_POST['external_internal'];
                                       $introduction_to = $_POST['introduction_to'];
                                       $check_price = $_POST['check_price'];
                                       $listen_recommendation = $_POST['listen_recommendation'];
                                       $identify_1_2 = $_POST['identify_1_2'];
                                       $review_adjust_call = $_POST['review_adjust_call'];     
                                       $summarize_the_Situation = $_POST['summarize_the_Situation'];
                                       $explore_need = $_POST['explore_need'];
                                       $state_the_idea = $_POST['state_the_idea'];
                                       $emphasize_use = $_POST['emphasize_use'];
                                       $close_effectively = $_POST['close_effectively'];
                                       $handle_objections = $_POST['handle_objections'];
                                       $take_the_order = $_POST['take_the_order'];
                                       $implement_action = $_POST['implement_action'];
                                       $display = $_POST['display'];
                                       $shelving = $_POST['shelving'];
                                       $price_promotions = $_POST['price_promotions'];
                                       $range_availability = $_POST['range_availability'];
                                       $understand_who_does_what = $_POST['understand_who_does_what'];
                                       $complete_pharmacy = $_POST['complete_pharmacy'];
                                       $confirm_all_agreement = $_POST['confirm_all_agreement'];
                                       $order_confirmation = $_POST['order_confirmation'];
                                       $update_log_file = $_POST['update_log_file'];
                                       $post_call_analysis = $_POST['post_call_analysis'];
                                       $feedback = $_POST['feedback'];
                                       $objective_1 = $_POST['objective_1'];
                                       $action_1 = $_POST['action_1'];
                                       $objective_2 = $_POST['objective_2'];
                                       $action_2 = $_POST['action_2'];
                                       $comments =  mysqli_real_escape_string($conn, $_POST['comments']);
                                       $score_1 = $_POST['score_1'];
                                       $score_2 = $_POST['score_2'];
                                       $score_3 = $_POST['score_3'];
                                       $score_4 = $_POST['score_4'];
                                       $score_5 = $_POST['score_5'];
                                       $score_6 = $_POST['score_6']; 
                                       $insert = "INSERT INTO joint_visit (name,date,development_plan,date_of_coaching_session,overall_score_new,coaching_session_with,score_total_new,is_first_this_month,
                                       reviewed,smart_call,total_score,review_key,overall_evaluation,check_sales,external_internal,introduction_to,check_price,listen_recommendation,identify_1_2,review_adjust_call,
                                       summarize_the_Situation,explore_need,state_the_idea,emphasize_use,close_effectively,handle_objections,take_the_order,implement_action,display,shelving,price_promotions,
                                       range_availability,understand_who_does_what,complete_pharmacy,confirm_all_agreement,order_confirmation,update_log_file,post_call_analysis,feedback,objective_1,action_1,
                                       objective_2,action_2,comments,score_1,score_2,score_3,score_4,score_5,score_6) 
                                       VALUES 
                                       ('$name','$date','$development_plan','$date_of_coaching_session','$overall_score_new','$coaching_session_with','$score_total_new','$is_first_this_month',
                                       '$reviewed','$smart_call','$total_score','$review_key','$overall_evaluation','$check_sales','$external_internal','$introduction_to','$check_price','$listen_recommendation','$identify_1_2',
                                       '$review_adjust_call','$summarize_the_Situation','$explore_need','$state_the_idea','$emphasize_use','$close_effectively','$handle_objections','$take_the_order'
                                       ,'$implement_action','$display','$shelving','$price_promotions','$range_availability','$understand_who_does_what','$complete_pharmacy','$confirm_all_agreement',
                                       '$order_confirmation','$update_log_file','$post_call_analysis','$feedback','$objective_1','$action_1','$objective_2','$action_2','$comments','$score_1','$score_2','$score_3','$score_4','$score_5','$score_6')";
                                    
                                       $insert_q=mysqli_query($conn,$insert);
                                       if ($insert_q) {
                                           ?>
                                <script type="text/javascript">
                                    alert("Form has been submitted")
                                     window.location.href = "joint_visit_form.php";
                                </script>
                                <?php
                                    }
                                    else
                                    {
                                        ?>
                                <script type="text/javascript">
                                    alert("Request submition failed!")
                                    window.location.href = "joint_visit_form.php";
                                </script>
                                <?php
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
        <script src="assets/js/main.js"></script>
        <script>
            function score1() {
                const inputs = document.querySelectorAll('#table-body-1 input[type="number"]:not([readonly])');
                let sum = 0;
                let count = 0;
                inputs.forEach(input => {
                    const value = parseFloat(input.value);
                    if (!isNaN(value)) {
                        sum += value;
                        count++;
                    }
                });
                const average = count > 0 ? (sum / count).toFixed(2) : 0;
                document.getElementById('score_1').value = average;
            }
        </script>
        <script>
            function score2() {
                const inputs = document.querySelectorAll('#table-body-2 input[type="number"]:not([readonly])');
                let sum = 0;
                let count = 0;
            
                inputs.forEach(input => {
                    const value = parseFloat(input.value);
                    if (!isNaN(value)) {
                        sum += value;
                        count++;
                    }
                });
            
                const average = count > 0 ? (sum / count).toFixed(2) : 0;
                document.getElementById('score_2').value = average;
            }
        </script>
        <script>
            function score3() {
                const inputs = document.querySelectorAll('#table-body-3 input[type="number"]:not([readonly])');
                let sum = 0;
                let count = 0;
            
                inputs.forEach(input => {
                    const value = parseFloat(input.value);
                    if (!isNaN(value)) {
                        sum += value;
                        count++;
                    }
                });
            
                const average = count > 0 ? (sum / count).toFixed(2) : 0;
                document.getElementById('score_3').value = average;
            }
        </script>
        <script>
            function score4() {
                const inputs = document.querySelectorAll('#table-body-4 input[type="number"]:not([readonly])');
                let sum = 0;
                let count = 0;
            
                inputs.forEach(input => {
                    const value = parseFloat(input.value);
                    if (!isNaN(value)) {
                        sum += value;
                        count++;
                    }
                });
            
                const average = count > 0 ? (sum / count).toFixed(2) : 0;
                document.getElementById('score_4').value = average;
            }
        </script>
        <script>
            function score5() {
                const inputs = document.querySelectorAll('#table-body-5 input[type="number"]:not([readonly])');
                let sum = 0;
                let count = 0;
            
                inputs.forEach(input => {
                    const value = parseFloat(input.value);
                    if (!isNaN(value)) {
                        sum += value;
                        count++;
                    }
                });
            
                const average = count > 0 ? (sum / count).toFixed(2) : 0;
                document.getElementById('score_5').value = average;
            }
        </script>
        <script>
            function score6() {
                const inputs = document.querySelectorAll('#table-body-6 input[type="number"]:not([readonly])');
                let sum = 0;
                let count = 0;
            
                inputs.forEach(input => {
                    const value = parseFloat(input.value);
                    if (!isNaN(value)) {
                        sum += value;
                        count++;
                    }
                });
            
                const average = count > 0 ? (sum / count).toFixed(2) : 0;
                document.getElementById('score_6').value = average;
            }
        </script>
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
    once: true,
  });
</script>
    </body>
</html>