<?php
    session_start();
    
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php'); // Redirect to the login page
        exit;
    }
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Digital Form</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/style.css">


        <style>
            .div-1{
                background-color: #FFFAB7;
                padding: 20px;
                box-shadow: 1px 1px 1px #888888;
                border-radius: 5px;
            }
            .div-1 p{
                font-size: 12px!important;
                font-weight:500;
            }
            .span-val{
                color: #615EFC;
            }





            table, th, td {
            padding: 0;
            margin: 0;
            width: 100%;
            border: none!important;
            }
            th, td {
            padding: 2px!important;
            }
            .score_val{
            color: black;
            }
            .table{
            background-color: #F4F9F9;
            border-radius: 5px;
            padding: 20px;
            padding-left: 25px;
            box-shadow: 1px 1px 1px #888888;
            }
            .step{
            color: #003285;
            font-size: 13px;
            font-weight: 500;
            }
            h6{
            color: #615EFC;
            }
            th{
            font-size: 12px;
            }
            td{
            padding-left: 10px!important;
            margin-left: 10px;
            }
            p{
            margin: 0;
            margin-bottom: 2px;
            font-size: 13px!important;
            color: black;
            }
            input[type="text"] {
            font-size: 14px;
            }
            ::placeholder {
            color: black; 
            }
            textarea {
            font-size: 14px; 
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
            background: #263144!important;
            }
            #sidebar ul.components {
            padding: 10px 0;
            /* border-bottom: 1px solid #263144!important; */
            }
            #sidebar ul p {
            color: #fff;
            padding: 8px!important;
            }
            #sidebar ul li a {
            padding: 8px!important;
            font-size: 13px !important;
            display: block;
            color: white!important;
            }
            #sidebar ul li a:hover {
            /* color: black!important;
            background: #E5BA73!important; */
            text-decoration: none;
            }
            #sidebar ul li.active>a,
            a[aria-expanded="true"] {
            color: black!important;
            background: #E5BA73!important;
            }
            a[data-toggle="collapse"] {
            position: relative;
            }
            .dropdown-toggle::after {
            display: block;
            position: absolute;
            color: black!important;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            background: transparent!important;
            }
            ul ul a {
            font-size: 13px !important;
            padding-left: 15px !important;
            background: #263144!important;
            color: black!important;
            }
            ul.CTAs {
            font-size: 13px !important;
            }
            ul.CTAs a {
            text-align: center;
            font-size: 13px;
            display: block;
            border-radius: 5px;
            margin-bottom: 5px;
            }
            a.download {
            background: #fff;
            color: #263144;
            }
            a.article,
            a.article:hover {
            background: white;
            color: black!important ;
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
    </head>
    <body>
        <?php
            include 'dbconfig.php';
            ?>
        <div class="wrapper d-flex align-items-stretch">
            <?php
                include 'sidebar.php';
                ?>
            <!-- Page Content  -->
            <div id="content" style="background-color: white;">
                <!-- navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                        </button>
                    </div>
                </nav>
                <?php
                    include 'dbconfig.php';
                    
                    $id=$_GET['id'];
                    $select = "SELECT * FROM joint_visit WHERE id = '$id'";
                    $select_q = mysqli_query($conn, $select);
                    $data = mysqli_num_rows($select_q);
                    ?>
                <?php if ($data) { while ($row = mysqli_fetch_array($select_q)) { ?>
                <div class="container">
                    <h6 class="text-center pb-md-4">Joint Visit <?php echo $row['id']?> Details</h6>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="div-1">
                                <p>Development Plan <span class="span-val"><?php echo $row['development_plan']?></span></p>
                                <p>Date of Coaching Session <span class="span-val"><?php echo $row['date_of_coaching_session']?></span></p>
                                <p>Overall Score New <span class="span-val"><?php echo $row['overall_score_new']?></span></p>
                                <p>Coaching Session with <span class="span-val"><?php echo $row['coaching_session_with']?></span></p>
                                <p>Score Total New <span class="span-val"><?php echo $row['score_total_new']?></span></p>
                                <p>Is First this Month <span class="span-val"><?php echo $row['is_first_this_month']?></span></p>
                            </div> 
                        </div> 



                        <div class="col-md-6">
                            <div class="div-1">
                                <p>Total Score <span class="span-val"><?php echo $row['total_score']?></span></p>
                                <p>Reviewed <span class="span-val"><?php echo $row['reviewed']?></span></p>
                                <p>Professional Call Model <span class="span-val"><?php echo $row['professional_call_model']?></span></p>
                                <p>MR Level <span class="span-val"><?php echo $row['mr_level']?></span></p>
                                <p>Smooth Delivery and Use of Bridging Statement <span class="span-val"><?php echo $row['smooth_delivery']?></span></p>
                                <p>Years In Positions <span class="span-val"><?php echo $row['years_in_positions']?></span></p>
                            </div> 
                        </div>                      

                        </div>
                    </div>
                    <div class="row d-flex align-items-stretch justify-content-center">
                        <div class="col-md-5 d-flex flex-column" data-aos="fade-up" data-aos-duration="4000">
                            <table class="table table-bordered table-responsive flex-grow-1">
                                <thead>
                                    <tr>
                                        <th colspan="2">
                                            <h6>Preparation</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    <tr>
                                        <th>Brick Sales Review</th>
                                        <td class="tds"><?php echo $row['brick_sales']?></td>
                                    </tr>
                                    <tr>
                                        <th>Territory Target Known & Owned</th>
                                        <td class="tds"><?php echo $row['territory_target']?></td>
                                    </tr>
                                    <tr>
                                        <th>Route Plane for Total Cycle Completed</th>
                                        <td class="tds"><?php echo $row['route_plane']?></td>
                                    </tr>
                                    <tr>
                                        <th>Review Call Note</th>
                                        <td class="tds"><?php echo $row['review_call']?></td>
                                    </tr>
                                    <tr>
                                        <th>Smart Call Objective</th>
                                        <td class="tds"><?php echo $row['smart_call']?></td>
                                    </tr>
                                    <tr>
                                        <th>Review Key Contact Data</th>
                                        <td class="tds"><?php echo $row['review_key']?></td>
                                    </tr>
                                    <tr>
                                        <th>Overall evaluation Of Sales Representative </th>
                                        <td class="tds"><?php echo $row['overall_evaluation']?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="step pt-md-3 text-right">Step 1 Score <span class="score_val"><?php echo $row['score_1']?></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-5 d-flex flex-column" data-aos="fade-up" data-aos-duration="4000">
                            <table class="table table-bordered table-responsive flex-grow-1">
                                <thead>
                                    <tr>
                                        <th colspan="2">
                                            <h6>Pharmacy Visit</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    <tr>
                                        <th>Check Sales Tools,Equipment/Material</th>
                                        <td class="tds"><?php echo $row['check_sales']?></td>
                                    </tr>
                                    <tr>
                                        <th>External & Internal Visual Evaluation</th>
                                        <td class="tds"><?php echo $row['external_internal']?></td>
                                    </tr>
                                    <tr>
                                        <th>Introduction to Staff</th>
                                        <td class="tds"><?php echo $row['introduction_to']?></td>
                                    </tr>
                                    <tr>
                                        <th>Check Price and Promotional Activities</th>
                                        <td class="tds"><?php echo $row['check_price']?></td>
                                    </tr>
                                    <tr>
                                        <th>Listen Recommendation/ Habits of Staff</th>
                                        <td class="tds"><?php echo $row['listen_recommendation']?></td>
                                    </tr>
                                    <tr>
                                        <th>Identify 1 or 2 opportunities</th>
                                        <td class="tds"><?php echo $row['identify_1_2']?></td>
                                    </tr>
                                    <tr>
                                        <th>Review/Adjust Call Objectives</th>
                                        <td class="tds"><?php echo $row['review_adjust_call']?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="step pt-md-3 text-right">Step 2 Score <span class="score_val"><?php echo $row['score_2']?></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- 3starts -->
                    <div class="row justify-content-center">
                        <div class="col-md-5 d-flex flex-column" data-aos="fade-up" data-aos-duration="4000">
                            <table class="table table-bordered table-responsive flex-grow-1">
                                <thead>
                                    <tr>
                                        <th colspan="2">
                                            <h6>Customer Development</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    <tr>
                                        <th>Summarize the Situation</th>
                                        <td class="tds"><?php echo $row['summarize_the_Situation']?></td>
                                    </tr>
                                    <tr>
                                        <th>Explore Needs</th>
                                        <td class="tds"><?php echo $row['explore_need']?></td>
                                    </tr>
                                    <tr>
                                        <th>State the Idea</th>
                                        <td class="tds"><?php echo $row['state_the_idea']?></td>
                                    </tr>
                                    <tr>
                                        <th>Emphasize & Use of Features and Benefits</th>
                                        <td class="tds"><?php echo $row['emphasize_use']?></td>
                                    </tr>
                                    <tr>
                                        <th>Close Effectively</th>
                                        <td class="tds"><?php echo $row['close_effectively']?></td>
                                    </tr>
                                    <tr>
                                        <th>Handle Objections</th>
                                        <td class="tds"><?php echo $row['handle_objections']?></td>
                                    </tr>
                                    <tr>
                                        <th>Take the Order</th>
                                        <td class="tds"><?php echo $row['take_the_order']?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="step pt-md-3 text-right">Step 3 Score <span class="score_val"><?php echo $row['score_3']?></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-5 d-flex flex-column" data-aos="fade-up" data-aos-duration="4000">
                            <table class="table table-bordered table-responsive flex-grow-1">
                                <thead>
                                    <tr>
                                        <th colspan="2">
                                            <h6>VISIBILITY</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    <tr>
                                        <th>Implement Actions of Call Objectives</th>
                                        <td class="tds"><?php echo $row['implement_action']?></td>
                                    </tr>
                                    <tr>
                                        <th>Display</th>
                                        <td class="tds"><?php echo $row['display']?></td>
                                    </tr>
                                    <tr>
                                        <th>Shelving</th>
                                        <td class="tds"><?php echo $row['shelving']?></td>
                                    </tr>
                                    <tr>
                                        <th>Price & Promotions</th>
                                        <td class="tds"><?php echo $row['price_promotions']?></td>
                                    </tr>
                                    <tr>
                                        <th>Range availability</th>
                                        <td class="tds"><?php echo $row['range_availability']?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="step pt-md-3 text-right">Step 4 Score <span class="score_val"><?php echo $row['score_4']?></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-5 d-flex flex-column" data-aos="fade-up" data-aos-duration="4000">
                            <table class="table table-bordered table-responsive flex-grow-1">
                                <thead>
                                    <tr>
                                        <th colspan="2">
                                            <h6>Advocacy</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    <tr>
                                        <th>Understand who does what</th>
                                        <td class="tds"><?php echo $row['understand_who_does_what']?></td>
                                    </tr>
                                    <tr>
                                        <th>Complete Pharmacy Staff Training</th>
                                        <td class="tds"><?php echo $row['complete_pharmacy']?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="step pt-md-3 text-right">Step 5 Score <span class="score_val"><?php echo $row['score_5']?></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-5 d-flex flex-column" data-aos="fade-up" data-aos="fade-up" data-aos-duration="4000">
                            <table class="table table-bordered table-responsive flex-grow-1">
                                <thead>
                                    <tr>
                                        <th colspan="2">
                                            <h6>CLOSING</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    <tr>
                                        <th>Confirm All Agreement with Customers</th>
                                        <td class="tds"><?php echo $row['confirm_all_agreement']?></td>
                                    </tr>
                                    <tr>
                                        <th>Order confirmation to list</th>
                                        <td class="tds"><?php echo $row['order_confirmation']?></td>
                                    </tr>
                                    <tr>
                                        <th>Update log file</th>
                                        <td class="tds"><?php echo $row['update_log_file']?></td>
                                    </tr>
                                    <tr>
                                        <th>Post Call Analysis</th>
                                        <td class="tds"><?php echo $row['post_call_analysis']?></td>
                                    </tr>
                                    <tr>
                                        <th>Feedback</th>
                                        <td class="tds"><?php echo $row['feedback']?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="step pt-md-3 text-right">Step 6 Score <span class="score_val"><?php echo $row['score_6']?></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-5 d-flex flex-column" data-aos="fade-up" data-aos-duration="4000">
                            <table class="table table-bordered table-responsive flex-grow-1">
                                <thead>
                                    <tr>
                                        <th colspan="2">
                                            <h6>Next Joint Visit Objectives (max.2) and Agreed Actions</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    <tr>
                                        <th>Objective 1</th>
                                        <td class="tds"><?php echo $row['objective_1']?></td>
                                    </tr>
                                    <tr>
                                        <th>Action </th>
                                        <td class="tds"><?php echo $row['action_1']?></td>
                                    </tr>
                                    <tr>
                                        <th>Objective 2</th>
                                        <td class="tds"><?php echo $row['objective_2']?></td>
                                    </tr>
                                    <tr>
                                        <th>Action </th>
                                        <td class="tds"><?php echo $row['action_2']?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-5 d-flex flex-column" data-aos="fade-up" data-aos-duration="4000">
                            <div class="d-flex flex-column flex-grow-1">
                                <h6 class="pr-4">Comments</h6>
                                <textarea placeholder="<?php echo $row['comments']?>" id="" rows="3" cols="50" readonly></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- container end-->
                    <?php } } else { echo "No record found!"; } ?>
                </div>
            </div>
            <!--content-->
        </div>
        <!--wrapper--> 
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" src="libs/js-xlsx/xlsx.core.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar').toggleClass('active');
                });
            });
        </script>
        <!-- table export -->
        <script src="
            https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/tableExport.min.js
            "></script>
        <script type="text/javascript" src="libs/FileSaver/FileSaver.min.js"></script>
        <script type="text/javascript" src="../libs/jsPDF/polyfills.umd.js"></script>
        <script type="text/javascript" src="tableExport.min.js"></script>
        <!-- TABLE EXPORT -->
        <!-- ALL -->
        <script type="text/javascript">
            $(document).ready(function() {
            $('#excel').click(function() {
            $('#myTable').tableExport({ type: 'excel',ignoreColumn: [16] });
            });
            });
        </script>
        <!-- ALL -->
        <script>
            $(document).ready(function () {
            (function ($) {
                $('#filter').keyup(function () {
                    var rex = new RegExp($(this).val(), 'i');
                    $('.searchable tr').hide();
                    $('.searchable tr').filter(function () {
                        return rex.test($(this).text());
                    }).show();
                })
            
            }(jQuery));
            });
        </script>


<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({

    once: true,
  });
  
</script>
        <script src="assets/js/main.js"></script>
    </body>
</html>