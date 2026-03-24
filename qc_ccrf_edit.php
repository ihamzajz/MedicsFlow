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
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <!-- Our Custom CSS -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="assets/css/style.css">
        <style>
            .table-1 td , .table-2 td , .table-3 td {
            padding: 7px 10px!important;
            }
            .ul-msg li{
            font-size: 12px;
            font-weight: 500;
            padding-top:10px
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
            th{
            font-size: 10.5px!important;
            border:none!important;
            border:1px solid #0D9276!important;
            color:white!important;
            background-color: #0D9276!important;
            }
            td{
            font-size: 10.5px!important;
            background-color:White!important;
            color:black!important;
            border:1px solid grey!important;
            padding:0px!important;
            margin:0px!important;
            }
            thead{
            border:1px solid #0D9276!important;
            }
            input[type=checkbox],label{
            padding:0px!important;
            margin:0px!important;
            }
            .btn-submit {
            font-size: 12px !important; 
            color: white;
            background-color: #0D9276;
            padding: 5px 35px;
            border-radius: 2px;
            border: 2px solid #0D9276;
            letter-spacing: 1.35px; 
            font-weight: 500;
            }
            .btn-menu{
            font-size: 11px;
            border-radius:0px;
            }
            .cbox{
            height: 13px!important;
            width: 13px!important;
            }
            p{
            font-size: 11.7px!important;
            padding: 0px!important;
            margin: 0px!important;
            font-weight: 500!important;
            display: inline!important; 
            margin-right: 10px!important;
            }
            input , textarea {
            width: 100% !important;
            font-size: 11.7px!important; 
            border-radius: 0px!important;
            border: none!important;
            transition: border-color 0.3s ease!important;
            padding: 5px 5px!important;
            letter-spacing: 0.4px!important; 
            height:25px!important;
            }
            textarea {
            width: 200px !important;
            /* font-size: 11.7px!important; 
            border-radius: 0px!important;
            border: 1px solid grey!important;
            transition: border-color 0.3s ease!important;
            padding: 5px 5px!important;
            letter-spacing: 0.4px!important;  */
            /* height:25px!important; */
            }
            input:focus , textarea:focus{
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
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
    </head>
    <body>
        <div class="wrapper">
            <?php
                include 'sidebar.php';
                ?>
            <!-- Page Content  -->
            <div id="content">
                <!-- navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-dark btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                        </button>
                    </div>
                </nav>
                <!-- work start  -->
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col text-center">
                            <a href="profile.php" class="btn btn-dark btn-sm" style="border-radius:0px!important">Home</a>
                            <a href="salesmain_productlist.php" class="btn btn-dark btn-sm" style="border-radius:0px!important">Product List</a>
                        </div>
                    </div>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Initiate Form</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Part 2</button>
                            <button class="nav-link" id="nav-group-tab" data-bs-toggle="tab" data-bs-target="#nav-group" type="button" role="tab" aria-controls="nav-group" aria-selected="false">Part 3</button>
                            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Assign Department</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <!-- <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="0">...</div> -->
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                            <!-- a start  -->
                            <p>1</p>
                            <!-- a end -->
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                            <!-- b start  -->
                            <?php
                                include 'dbconfig.php';
                                
                                
                                $id=$_GET['id'];
                                $select = "SELECT * FROM qc_ccrf WHERE
                                id = '$id' ";
                                
                                $select_q = mysqli_query($conn,$select);
                                $data = mysqli_num_rows($select_q);
                                ?>
                            <?php 
                                if($data){
                                	while ($row=mysqli_fetch_array($select_q)) {
                                		?>
                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <form class="form pb-3" method="POST" style="border: 1px solid black; padding: 25px; padding-bottom: 0px; border-radius: 2px;background-color:white!important" >
                                            <h6 class="text-center pb-3" style="font-weight: bolder; font-size: 18px !important;">
                                                Change Control Request Form 
                                            </h6>
                                            <h6 class="" style="font-weight: bolder;font-size:13.5px">RISK ASSESSMENT</h6>
                                            <table class="table table-responsive ">
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
                                                        <td><textarea name="b_risk_item_no" value="<?php echo $row['b_risk_item_no']; ?>"></textarea></td>
                                                        <td><textarea name="b_potential_failure_mode" value="<?php echo $row['b_potential_failure_mode']; ?>"></textarea></td>
                                                        <td><textarea name="b_potential_effect" value="<?php echo $row['b_potential_effect']; ?>"></textarea></td>
                                                        <td><textarea name="b_severity1" value="<?php echo $row['b_severity1']; ?>"></textarea></td>
                                                        <td><textarea name="b_potential_cause" value="<?php echo $row['b_potential_cause']; ?>"></textarea></td>
                                                        <td><textarea name="b_occurence_probablility" value="<?php echo $row['b_occurence_probablility']; ?>"></textarea></td>
                                                        <td><textarea name="b_current_control" value="<?php echo $row['b_current_control']; ?>"></textarea></td>
                                                        <td><textarea name="b_dectection1" value="<?php echo $row['b_dectection1']; ?>"></textarea></td>
                                                        <td><textarea name="b_rpn1" value="<?php echo $row['b_rpn1']; ?>"></textarea></td>
                                                        <td><textarea name="b_recommended_action" value="<?php echo $row['b_recommended_action']; ?>"></textarea></td>
                                                        <td><textarea name="b_severity2" value="<?php echo $row['b_severity2']; ?>"></textarea></td>
                                                        <td><textarea name="b_occurence" value="<?php echo $row['b_occurence']; ?>"></textarea></td>
                                                        <td><textarea name="b_detection2" value="<?php echo $row['b_detection2']; ?>"></textarea></td>
                                                        <td><textarea name="b_rpn2" value="<?php echo $row['b_rpn2']; ?>"></textarea></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div style="border: 1px solid black; padding: 25px; padding-bottom: 0px; border-radius: 2px;background-color:white!important;margin-top:15px" >
                                                            <h6 class="" style="font-weight: bolder;font-size:13.5px">To CALCULATE "RISK PRIORITIZATION NUMBER (or) RPN":</h6>
                                                            <p style="font-size:12.5px!important" class="">RPN is calculated by multiplying Probablility (P) , Delectablity (D) 
                                                                and severity (S), which are individually categorized and scored as described below in Table
                                                            </p>
                                                            <!-- table 1 -->
                                                            <table class="table mt-3 table-1">
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
                                                            <table class="table table-3">
                                                                <thead >
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
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- form 4 -->
                                            <table class="table">
                                                <thead>
                                                    <tr >
                                                        <td colspan="8" class="py-1 pl-1">
                                                            <p>In-Hand Stock Status</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th rowspan="2">S. No.</th>
                                                        <th rowspan="2">Material Code</th>
                                                        <th  rowspan="2">Material Name</th>
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
                                                        <td><input type="text" name="c_sno_1" value="<?php echo $row['c_sno_1']; ?>"></td>
                                                        <td><input type="text" name="c_material_code_1"  value="<?php echo $row['c_material_code_1']; ?>"></td>
                                                        <td><input type="text" name="c_material_name_1"  value="<?php echo $row['c_material_name_1']; ?>"></td>
                                                        <td><input type="text" name="c_released_qty_1"  value="<?php echo $row['c_released_qty_1']; ?>"></td>
                                                        <td><input type="text" name="c_artwork_code_1"  value="<?php echo $row['c_artwork_code_1']; ?>"></td>
                                                        <td><input type="text" name="c_quarantine_qty_1"  value="<?php echo $row['c_quarantine_qty_1']; ?>"></td>
                                                        <td><input type="text" name="c_artwork_code2_1"  value="<?php echo $row['c_artwork_code2_1']; ?>"></td>
                                                        <td><input type="text" name="c_signature_warehouse_1"  value="<?php echo $row['c_signature_warehouse_1']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="c_sno_2" value="<?php echo $row['c_sno_2']; ?>"></td>
                                                        <td><input type="text" name="c_material_code_2"  value="<?php echo $row['c_material_code_2']; ?>"></td>
                                                        <td><input type="text" name="c_material_name_2"  value="<?php echo $row['c_material_name_2']; ?>"></td>
                                                        <td><input type="text" name="c_released_qty_2"  value="<?php echo $row['c_released_qty_2']; ?>"></td>
                                                        <td><input type="text" name="c_artwork_code_2"  value="<?php echo $row['c_artwork_code_2']; ?>"></td>
                                                        <td><input type="text" name="c_quarantine_qty_2"  value="<?php echo $row['c_quarantine_qty_2']; ?>"></td>
                                                        <td><input type="text" name="c_artwork_code2_2"  value="<?php echo $row['c_artwork_code2_2']; ?>"></td>
                                                        <td><input type="text" name="c_signature_warehouse_2"  value="<?php echo $row['c_signature_warehouse_2']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="c_sno_3" value="<?php echo $row['c_sno_3']; ?>"></td>
                                                        <td><input type="text" name="c_material_code_3"  value="<?php echo $row['c_material_code_3']; ?>"></td>
                                                        <td><input type="text" name="c_material_name_3"  value="<?php echo $row['c_material_name_3']; ?>"></td>
                                                        <td><input type="text" name="c_released_qty_3"  value="<?php echo $row['c_released_qty_3']; ?>"></td>
                                                        <td><input type="text" name="c_artwork_code_3"  value="<?php echo $row['c_artwork_code_3']; ?>"></td>
                                                        <td><input type="text" name="c_quarantine_qty_3"  value="<?php echo $row['c_quarantine_qty_3']; ?>"></td>
                                                        <td><input type="text" name="c_artwork_code2_3"  value="<?php echo $row['c_artwork_code2_3']; ?>"></td>
                                                        <td><input type="text" name="c_signature_warehouse_3"  value="<?php echo $row['c_signature_warehouse_3']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="c_sno_4" value="<?php echo $row['c_sno_4']; ?>"></td>
                                                        <td><input type="text" name="c_material_code_4"  value="<?php echo $row['c_material_code_4']; ?>"></td>
                                                        <td><input type="text" name="c_material_name_4"  value="<?php echo $row['c_material_name_4']; ?>"></td>
                                                        <td><input type="text" name="c_released_qty_4"  value="<?php echo $row['c_released_qty_4']; ?>"></td>
                                                        <td><input type="text" name="c_artwork_code_4"  value="<?php echo $row['c_artwork_code_4']; ?>"></td>
                                                        <td><input type="text" name="c_quarantine_qty_4"  value="<?php echo $row['c_quarantine_qty_4']; ?>"></td>
                                                        <td><input type="text" name="c_artwork_code2_4"  value="<?php echo $row['c_artwork_code2_4']; ?>"></td>
                                                        <td><input type="text" name="c_signature_warehouse_4"  value="<?php echo $row['c_signature_warehouse_4']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="c_sno_5" value="<?php echo $row['c_sno_5']; ?>"></td>
                                                        <td><input type="text" name="c_material_code_5"  value="<?php echo $row['c_material_code_5']; ?>"></td>
                                                        <td><input type="text" name="c_material_name_5"  value="<?php echo $row['c_material_name_5']; ?>"></td>
                                                        <td><input type="text" name="c_released_qty_5"  value="<?php echo $row['c_released_qty_5']; ?>"></td>
                                                        <td><input type="text" name="c_artwork_code_5"  value="<?php echo $row['c_artwork_code_5']; ?>"></td>
                                                        <td><input type="text" name="c_quarantine_qty_5"  value="<?php echo $row['c_quarantine_qty_5']; ?>"></td>
                                                        <td><input type="text" name="c_artwork_code2_5"  value="<?php echo $row['c_artwork_code2_5']; ?>"></td>
                                                        <td><input type="text" name="c_signature_warehouse_5"  value="<?php echo $row['c_signature_warehouse_5']; ?>"></td>
                                                    </tr>
                                                    </tr>
                                                    <tr >
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
                                                        <td><input type="text" name="c2_sno_1"   value="<?php echo $row['c2_sno_1']; ?>"></td>
                                                        <td><input type="text" name="c2_material_code_1"  value="<?php echo $row['c2_material_code_1']; ?>"></td>
                                                        <td><input type="text" name="c2_material_name_1"  value="<?php echo $row['c2_material_name_1']; ?>"></td>
                                                        <td><input type="text" name="c2_quantity_1"  value="<?php echo $row['c2_quantity_1']; ?>"></td>
                                                        <td><input type="text" name="c2_artwork_code_1"  value="<?php echo $row['c2_artwork_code_1']; ?>"></td>
                                                        <td><input type="text" name="c2_expected_ddate_1"  value="<?php echo $row['c2_expected_ddate_1']; ?>"></td>
                                                        <td colspan="2"><input type="text" name="c2_signature_pd_1"  value="<?php echo $row['c2_signature_pd_1']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="c2_sno_2"   value="<?php echo $row['c2_sno_2']; ?>"></td>
                                                        <td><input type="text" name="c2_material_code_2"  value="<?php echo $row['c2_material_code_2']; ?>"></td>
                                                        <td><input type="text" name="c2_material_name_2"  value="<?php echo $row['c2_material_name_2']; ?>"></td>
                                                        <td><input type="text" name="c2_quantity_2"  value="<?php echo $row['c2_quantity_2']; ?>"></td>
                                                        <td><input type="text" name="c2_artwork_code_2"  value="<?php echo $row['c2_artwork_code_2']; ?>"></td>
                                                        <td><input type="text" name="c2_expected_ddate_2"  value="<?php echo $row['c2_expected_ddate_2']; ?>"></td>
                                                        <td colspan="2"><input type="text" name="c2_signature_pd_2"  value="<?php echo $row['c2_signature_pd_2']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="c2_sno_3"   value="<?php echo $row['c2_sno_3']; ?>"></td>
                                                        <td><input type="text" name="c2_material_code_3"  value="<?php echo $row['c2_material_code_3']; ?>"></td>
                                                        <td><input type="text" name="c2_material_name_3"  value="<?php echo $row['c2_material_name_3']; ?>"></td>
                                                        <td><input type="text" name="c2_quantity_3"  value="<?php echo $row['c2_quantity_3']; ?>"></td>
                                                        <td><input type="text" name="c2_artwork_code_3"  value="<?php echo $row['c2_artwork_code_3']; ?>"></td>
                                                        <td><input type="text" name="c2_expected_ddate_3"  value="<?php echo $row['c2_expected_ddate_3']; ?>"></td>
                                                        <td colspan="2"><input type="text" name="c2_signature_pd_3"  value="<?php echo $row['c2_signature_pd_3']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="c2_sno_4"   value="<?php echo $row['c2_sno_4']; ?>"></td>
                                                        <td><input type="text" name="c2_material_code_4"  value="<?php echo $row['c2_material_code_4']; ?>"></td>
                                                        <td><input type="text" name="c2_material_name_4"  value="<?php echo $row['c2_material_name_4']; ?>"></td>
                                                        <td><input type="text" name="c2_quantity_4"  value="<?php echo $row['c2_quantity_4']; ?>"></td>
                                                        <td><input type="text" name="c2_artwork_code_4"  value="<?php echo $row['c2_artwork_code_4']; ?>"></td>
                                                        <td><input type="text" name="c2_expected_ddate_4"  value="<?php echo $row['c2_expected_ddate_4']; ?>"></td>
                                                        <td colspan="2"><input type="text" name="c2_signature_pd_4"  value="<?php echo $row['c2_signature_pd_4']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="c2_sno_5"   value="<?php echo $row['c2_sno_5']; ?>"></td>
                                                        <td><input type="text" name="c2_material_code_5"  value="<?php echo $row['c2_material_code_5']; ?>"></td>
                                                        <td><input type="text" name="c2_material_name_5"  value="<?php echo $row['c2_material_name_5']; ?>"></td>
                                                        <td><input type="text" name="c2_quantity_5"  value="<?php echo $row['c2_quantity_5']; ?>"></td>
                                                        <td><input type="text" name="c2_artwork_code_5"  value="<?php echo $row['c2_artwork_code_5']; ?>"></td>
                                                        <td><input type="text" name="c2_expected_ddate_5"  value="<?php echo $row['c2_expected_ddate_5']; ?>"></td>
                                                        <td colspan="2"><input type="text" name="c2_signature_pd_5"  value="<?php echo $row['c2_signature_pd_5']; ?>"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <!-- form 5 -->      
                                            <table class="table">
                                                <thead>
                                                    <tr >
                                                        <td colspan="8" class="py-1 pl-1">
                                                            <p>Detail regarding additional order (along with code no.) to be placed (if any)</p>
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
                                                        <td><input type="text" name="d_sno_1"   value="<?php echo $row['d_sno_1']; ?>"></td>
                                                        <td><input type="text" name="d_material_code_1"  value="<?php echo $row['d_material_code_1']; ?>"></td>
                                                        <td><input type="text" name="d_material_name_1"   value="<?php echo $row['d_material_name_1']; ?>"></td>
                                                        <td><input type="text" name="d_quantity_1"   value="<?php echo $row['d_quantity_1']; ?>"></td>
                                                        <td><input type="text" name="d_artwork_code_1"   value="<?php echo $row['d_artwork_code_1']; ?>"></td>
                                                        <td><input type="text" name="d_expected_ddate_1"   value="<?php echo $row['d_expected_ddate_1']; ?>"></td>
                                                        <td><input type="text" name="d_signature_purchase_1"   value="<?php echo $row['d_signature_purchase_1']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="d_sno_2"   value="<?php echo $row['d_sno_2']; ?>"></td>
                                                        <td><input type="text" name="d_material_code_2"  value="<?php echo $row['d_material_code_2']; ?>"></td>
                                                        <td><input type="text" name="d_material_name_2"   value="<?php echo $row['d_material_name_2']; ?>"></td>
                                                        <td><input type="text" name="d_quantity_2"   value="<?php echo $row['d_quantity_2']; ?>"></td>
                                                        <td><input type="text" name="d_artwork_code_2"   value="<?php echo $row['d_artwork_code_2']; ?>"></td>
                                                        <td><input type="text" name="d_expected_ddate_2"   value="<?php echo $row['d_expected_ddate_2']; ?>"></td>
                                                        <td><input type="text" name="d_signature_purchase_2"   value="<?php echo $row['d_signature_purchase_2']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="d_sno_3"   value="<?php echo $row['d_sno_3']; ?>"></td>
                                                        <td><input type="text" name="d_material_code_3"  value="<?php echo $row['d_material_code_3']; ?>"></td>
                                                        <td><input type="text" name="d_material_name_3"   value="<?php echo $row['d_material_name_3']; ?>"></td>
                                                        <td><input type="text" name="d_quantity_3"   value="<?php echo $row['d_quantity_3']; ?>"></td>
                                                        <td><input type="text" name="d_artwork_code_3"   value="<?php echo $row['d_artwork_code_3']; ?>"></td>
                                                        <td><input type="text" name="d_expected_ddate_3"   value="<?php echo $row['d_expected_ddate_3']; ?>"></td>
                                                        <td><input type="text" name="d_signature_purchase_3"   value="<?php echo $row['d_signature_purchase_3']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="d_sno_4"   value="<?php echo $row['d_sno_4']; ?>"></td>
                                                        <td><input type="text" name="d_material_code_4"  value="<?php echo $row['d_material_code_4']; ?>"></td>
                                                        <td><input type="text" name="d_material_name_4"   value="<?php echo $row['d_material_name_4']; ?>"></td>
                                                        <td><input type="text" name="d_quantity_4"   value="<?php echo $row['d_quantity_4']; ?>"></td>
                                                        <td><input type="text" name="d_artwork_code_4"   value="<?php echo $row['d_artwork_code_4']; ?>"></td>
                                                        <td><input type="text" name="d_expected_ddate_4"   value="<?php echo $row['d_expected_ddate_4']; ?>"></td>
                                                        <td><input type="text" name="d_signature_purchase_4"   value="<?php echo $row['d_signature_purchase_4']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="d_sno_5"   value="<?php echo $row['d_sno_5']; ?>"></td>
                                                        <td><input type="text" name="d_material_code_5"  value="<?php echo $row['d_material_code_5']; ?>"></td>
                                                        <td><input type="text" name="d_material_name_5"   value="<?php echo $row['d_material_name_5']; ?>"></td>
                                                        <td><input type="text" name="d_quantity_5"   value="<?php echo $row['d_quantity_5']; ?>"></td>
                                                        <td><input type="text" name="d_artwork_code_5"   value="<?php echo $row['d_artwork_code_5']; ?>"></td>
                                                        <td><input type="text" name="d_expected_ddate_5"   value="<?php echo $row['d_expected_ddate_5']; ?>"></td>
                                                        <td><input type="text" name="d_signature_purchase_5"   value="<?php echo $row['d_signature_purchase_5']; ?>"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table">
                                                <thead>
                                                    <tr >
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
                                                        <td><input type="text" name="d2_sno_1"   value="<?php echo $row['d2_sno_1']; ?>"></td>
                                                        <td><input type="text" name="d2_material_code_1"   value="<?php echo $row['d2_material_code_1']; ?>"></td>
                                                        <td><input type="text" name="d2_material_name_1"   value="<?php echo $row['d2_material_name_1']; ?>"></td>
                                                        <td><input type="text" name="d2_quantity_1"   value="<?php echo $row['d2_quantity_1']; ?>"></td>
                                                        <td><input type="text" name="d2_artwork_code_1"   value="<?php echo $row['d2_artwork_code_1']; ?>"></td>
                                                        <td><input type="text" name="d2_signature_planning_1"   value="<?php echo $row['d2_signature_planning_1']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="d2_sno_2"   value="<?php echo $row['d2_sno_2']; ?>"></td>
                                                        <td><input type="text" name="d2_material_code_2"   value="<?php echo $row['d2_material_code_2']; ?>"></td>
                                                        <td><input type="text" name="d2_material_name_2"   value="<?php echo $row['d2_material_name_2']; ?>"></td>
                                                        <td><input type="text" name="d2_quantity_2"   value="<?php echo $row['d2_quantity_2']; ?>"></td>
                                                        <td><input type="text" name="d2_artwork_code_2"   value="<?php echo $row['d2_artwork_code_2']; ?>"></td>
                                                        <td><input type="text" name="d2_signature_planning_2"   value="<?php echo $row['d2_signature_planning_2']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="d2_sno_3"   value="<?php echo $row['d2_sno_3']; ?>"></td>
                                                        <td><input type="text" name="d2_material_code_3"   value="<?php echo $row['d2_material_code_3']; ?>"></td>
                                                        <td><input type="text" name="d2_material_name_3"   value="<?php echo $row['d2_material_name_3']; ?>"></td>
                                                        <td><input type="text" name="d2_quantity_3"   value="<?php echo $row['d2_quantity_3']; ?>"></td>
                                                        <td><input type="text" name="d2_artwork_code_3"   value="<?php echo $row['d2_artwork_code_3']; ?>"></td>
                                                        <td><input type="text" name="d2_signature_planning_3"   value="<?php echo $row['d2_signature_planning_3']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="d2_sno_4"   value="<?php echo $row['d2_sno_4']; ?>"></td>
                                                        <td><input type="text" name="d2_material_code_4"   value="<?php echo $row['d2_material_code_4']; ?>"></td>
                                                        <td><input type="text" name="d2_material_name_4"   value="<?php echo $row['d2_material_name_4']; ?>"></td>
                                                        <td><input type="text" name="d2_quantity_4"   value="<?php echo $row['d2_quantity_4']; ?>"></td>
                                                        <td><input type="text" name="d2_artwork_code_4"   value="<?php echo $row['d2_artwork_code_4']; ?>"></td>
                                                        <td><input type="text" name="d2_signature_planning_4"   value="<?php echo $row['d2_signature_planning_4']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="d2_sno_5"   value="<?php echo $row['d2_sno_5']; ?>"></td>
                                                        <td><input type="text" name="d2_material_code_5"   value="<?php echo $row['d2_material_code_5']; ?>"></td>
                                                        <td><input type="text" name="d2_material_name_5"   value="<?php echo $row['d2_material_name_5']; ?>"></td>
                                                        <td><input type="text" name="d2_quantity_5"   value="<?php echo $row['d2_quantity_5']; ?>"></td>
                                                        <td><input type="text" name="d2_artwork_code_5"   value="<?php echo $row['d2_artwork_code_5']; ?>"></td>
                                                        <td><input type="text" name="d2_signature_planning_5"   value="<?php echo $row['d2_signature_planning_5']; ?>"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table">
                                                <thead>
                                                    <tr >
                                                        <td colspan="8" class="py-1 pl-1">
                                                            <p>No. if batches to be produced with old inventory as per following details</p>
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
                                                        <td><input type="text" name="d3_sno_1"  value="<?php echo $row['d3_sno_1']; ?>"></td>
                                                        <td><input type="text" name="d3_material_code_1"  value="<?php echo $row['d3_material_code_1']; ?>"></td>
                                                        <td><input type="text" name="d3_material_name_1"  value="<?php echo $row['d3_material_name_1']; ?>"></td>
                                                        <td><input type="text" name="d3_quantity_1"  value="<?php echo $row['d3_quantity_1']; ?>"></td>
                                                        <td><input type="text" name="d3_artwork_code_1"  value="<?php echo $row['d3_artwork_code_1']; ?>"></td>
                                                        <td><input type="text" name="d3_batchno_1"  value="<?php echo $row['d3_batchno_1']; ?>"></td>
                                                        <td><input type="text" name="d3_signature_planning_1"  value="<?php echo $row['d3_signature_planning_1']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="d3_sno_2"  value="<?php echo $row['d3_sno_2']; ?>"></td>
                                                        <td><input type="text" name="d3_material_code_2"  value="<?php echo $row['d3_material_code_2']; ?>"></td>
                                                        <td><input type="text" name="d3_material_name_2"  value="<?php echo $row['d3_material_name_2']; ?>"></td>
                                                        <td><input type="text" name="d3_quantity_2"  value="<?php echo $row['d3_quantity_2']; ?>"></td>
                                                        <td><input type="text" name="d3_artwork_code_2"  value="<?php echo $row['d3_artwork_code_2']; ?>"></td>
                                                        <td><input type="text" name="d3_batchno_2"  value="<?php echo $row['d3_batchno_2']; ?>"></td>
                                                        <td><input type="text" name="d3_signature_planning_2"  value="<?php echo $row['d3_signature_planning_2']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="d3_sno_3"  value="<?php echo $row['d3_sno_3']; ?>"></td>
                                                        <td><input type="text" name="d3_material_code_3"  value="<?php echo $row['d3_material_code_3']; ?>"></td>
                                                        <td><input type="text" name="d3_material_name_3"  value="<?php echo $row['d3_material_name_3']; ?>"></td>
                                                        <td><input type="text" name="d3_quantity_3"  value="<?php echo $row['d3_quantity_3']; ?>"></td>
                                                        <td><input type="text" name="d3_artwork_code_3"  value="<?php echo $row['d3_artwork_code_3']; ?>"></td>
                                                        <td><input type="text" name="d3_batchno_3"  value="<?php echo $row['d3_batchno_3']; ?>"></td>
                                                        <td><input type="text" name="d3_signature_planning_3"  value="<?php echo $row['d3_signature_planning_3']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="d3_sno_4"  value="<?php echo $row['d3_sno_4']; ?>"></td>
                                                        <td><input type="text" name="d3_material_code_4"  value="<?php echo $row['d3_material_code_4']; ?>"></td>
                                                        <td><input type="text" name="d3_material_name_4"  value="<?php echo $row['d3_material_name_4']; ?>"></td>
                                                        <td><input type="text" name="d3_quantity_4"  value="<?php echo $row['d3_quantity_4']; ?>"></td>
                                                        <td><input type="text" name="d3_artwork_code_4"  value="<?php echo $row['d3_artwork_code_4']; ?>"></td>
                                                        <td><input type="text" name="d3_batchno_4"  value="<?php echo $row['d3_batchno_4']; ?>"></td>
                                                        <td><input type="text" name="d3_signature_planning_4"  value="<?php echo $row['d3_signature_planning_4']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="d3_sno_5"  value="<?php echo $row['d3_sno_5']; ?>"></td>
                                                        <td><input type="text" name="d3_material_code_5"  value="<?php echo $row['d3_material_code_5']; ?>"></td>
                                                        <td><input type="text" name="d3_material_name_5"  value="<?php echo $row['d3_material_name_5']; ?>"></td>
                                                        <td><input type="text" name="d3_quantity_5"  value="<?php echo $row['d3_quantity_5']; ?>"></td>
                                                        <td><input type="text" name="d3_artwork_code_5"  value="<?php echo $row['d3_artwork_code_5']; ?>"></td>
                                                        <td><input type="text" name="d3_batchno_4"  value="<?php echo $row['d3_batchno_5']; ?>"></td>
                                                        <td><input type="text" name="d3_signature_planning_5"  value="<?php echo $row['d3_signature_planning_5']; ?>"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <tr>
                                                <button type="submit" class="btn btn-submit" name="submit" style="font-size: 20px">Submit</button>
                                            </tr>
                                        </form>
                                        <?php
                                            include 'dbconfig.php';
                                            
                                            // Check if form is submitted
                                            if (isset($_POST['submit'])) {
                                                // Retrieve form data
                                                $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                                                $name =  $_SESSION['fullname'];
                                            
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
                                                                  b_rpn2 = '$f_b_rpn2',
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
                                                    window.location.href = window.location.href;
                                                    
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
                }
                else{
                echo "No record found!";
                }
                ?>
        </div>
        </div>
        <!-- b end -->
        </div>





        <div class="tab-pane fade" id="nav-group" role="tabpanel" aria-labelledby="nav-group-tab" tabindex="0">
            <!-- c start  -->





            










                



            
            <!-- c end -->
        </div>









        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
            <!-- d start  -->


             <div class="wrapper">
            <?php
                include 'sidebar.php';
                ?>
            <!-- Page Content  -->
            <div id="content">
                <!-- navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-dark btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                        </button>
                    </div>
                </nav>
                <?php
                    include 'dbconfig.php';
                    
                    
                    $id=$_GET['id'];
                    $select = "SELECT * FROM qc_ccrf2 WHERE
                    fk_id = '$id' ";
                    
                    $select_q = mysqli_query($conn,$select);
                    $data = mysqli_num_rows($select_q);
                    ?>
                <?php 
                    if($data){
                    	while ($row=mysqli_fetch_array($select_q)) {
                    		?>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col ">
                            <form class="form pb-3" method="POST" style="border: 1px solid black; padding: 25px; padding-bottom: 0px; border-radius: 2px;background-color:white!important" >
                                <h6 class="text-center pb-3">
                                    Change Control Request Form 
                                    <a href="qc_ccrf_main_form-11_userlist.php" class="btn btn-dark" style="font-size: 11px !important;float:right!important">Next</a>
                                </h6>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Event / Action Plan</th>
                                            <th>Responsiblity</th>
                                            <th>Timeline</th>
                                            <th>Signature</th>
                                            <th>Verified By Quality Department</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" name="f_ac_1" value="<?php echo $row['f_ac_1']; ?>"></td>
                                            <td><input type="text" name="f_responsibility_1"  value="<?php echo $row['f_responsibility_1']; ?>"></td>
                                            <td><input type="text" name="f_timeline_1"  value="<?php echo $row['f_timeline_1']; ?>"></td>
                                            <td><input type="text" name="f_signature_1"  value="<?php echo $row['f_signature_1']; ?>"></td>
                                            <td><input type="text" name="f_verify_by_1"  value="<?php echo $row['f_verify_by_1']; ?>"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" name="f_ac_2" value="<?php echo $row['f_ac_2']; ?>"></td>
                                            <td><input type="text" name="f_responsibility_2"  value="<?php echo $row['f_responsibility_2']; ?>"></td>
                                            <td><input type="text" name="f_timeline_2"  value="<?php echo $row['f_timeline_2']; ?>"></td>
                                            <td><input type="text" name="f_signature_2"  value="<?php echo $row['f_signature_2']; ?>"></td>
                                            <td><input type="text" name="f_verify_by_2"  value="<?php echo $row['f_verify_by_2']; ?>"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" name="f_ac_3" value="<?php echo $row['f_ac_3']; ?>"></td>
                                            <td><input type="text" name="f_responsibility_3"  value="<?php echo $row['f_responsibility_3']; ?>"></td>
                                            <td><input type="text" name="f_timeline_3"  value="<?php echo $row['f_timeline_3']; ?>"></td>
                                            <td><input type="text" name="f_signature_3"  value="<?php echo $row['f_signature_3']; ?>"></td>
                                            <td><input type="text" name="f_verify_by_3"  value="<?php echo $row['f_verify_by_3']; ?>"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" name="f_ac_4" value="<?php echo $row['f_ac_4']; ?>"></td>
                                            <td><input type="text" name="f_responsibility_4"  value="<?php echo $row['f_responsibility_4']; ?>"></td>
                                            <td><input type="text" name="f_timeline_4"  value="<?php echo $row['f_timeline_4']; ?>"></td>
                                            <td><input type="text" name="f_signature_4"  value="<?php echo $row['f_signature_4']; ?>"></td>
                                            <td><input type="text" name="f_verify_by_4"  value="<?php echo $row['f_verify_by_4']; ?>"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" name="f_ac_5" value="<?php echo $row['f_ac_5']; ?>"></td>
                                            <td><input type="text" name="f_responsibility_5"  value="<?php echo $row['f_responsibility_5']; ?>"></td>
                                            <td><input type="text" name="f_timeline_5"  value="<?php echo $row['f_timeline_5']; ?>"></td>
                                            <td><input type="text" name="f_signature_5"  value="<?php echo $row['f_signature_5']; ?>"></td>
                                            <td><input type="text" name="f_verify_by_5"  value="<?php echo $row['f_verify_by_5']; ?>"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" name="f_ac_6" value="<?php echo $row['f_ac_6']; ?>"></td>
                                            <td><input type="text" name="f_responsibility_6"  value="<?php echo $row['f_responsibility_6']; ?>"></td>
                                            <td><input type="text" name="f_timeline_6"  value="<?php echo $row['f_timeline_6']; ?>"></td>
                                            <td><input type="text" name="f_signature_6"  value="<?php echo $row['f_signature_6']; ?>"></td>
                                            <td><input type="text" name="f_verify_by_6"  value="<?php echo $row['f_verify_by_6']; ?>"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" name="f_ac_7" value="<?php echo $row['f_ac_7']; ?>"></td>
                                            <td><input type="text" name="f_responsibility_7"  value="<?php echo $row['f_responsibility_7']; ?>"></td>
                                            <td><input type="text" name="f_timeline_7"  value="<?php echo $row['f_timeline_7']; ?>"></td>
                                            <td><input type="text" name="f_signature_7"  value="<?php echo $row['f_signature_7']; ?>"></td>
                                            <td><input type="text" name="f_verify_by_7"  value="<?php echo $row['f_verify_by_7']; ?>"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" name="f_ac_8" value="<?php echo $row['f_ac_8']; ?>"></td>
                                            <td><input type="text" name="f_responsibility_8"  value="<?php echo $row['f_responsibility_8']; ?>"></td>
                                            <td><input type="text" name="f_timeline_8"  value="<?php echo $row['f_timeline_8']; ?>"></td>
                                            <td><input type="text" name="f_signature_8"  value="<?php echo $row['f_signature_8']; ?>"></td>
                                            <td><input type="text" name="f_verify_by_8"  value="<?php echo $row['f_verify_by_8']; ?>"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" name="f_ac_9" value="<?php echo $row['f_ac_9']; ?>"></td>
                                            <td><input type="text" name="f_responsibility_9"  value="<?php echo $row['f_responsibility_9']; ?>"></td>
                                            <td><input type="text" name="f_timeline_9"  value="<?php echo $row['f_timeline_9']; ?>"></td>
                                            <td><input type="text" name="f_signature_9"  value="<?php echo $row['f_signature_9']; ?>"></td>
                                            <td><input type="text" name="f_verify_by_9"  value="<?php echo $row['f_verify_by_9']; ?>"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" name="f_ac_10" value="<?php echo $row['f_ac_10']; ?>"></td>
                                            <td><input type="text" name="f_responsibility_10"  value="<?php echo $row['f_responsibility_10']; ?>"></td>
                                            <td><input type="text" name="f_timeline_10"  value="<?php echo $row['f_timeline_10']; ?>"></td>
                                            <td><input type="text" name="f_signature_10"  value="<?php echo $row['f_signature_10']; ?>"></td>
                                            <td><input type="text" name="f_verify_by_10"  value="<?php echo $row['f_verify_by_10']; ?>"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table mt-3">
                                    <thead>
                                        <th>Department</th>
                                        <th>Remarks</t>
                                        <th>Signature Date
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="p-2">Head of Quality</td>
                                            <td class="p-2">
                                                <input type="checkbox" class="type-checkbox cbox" 
                                                    name="head_of_quality" 
                                                    value="Approve the change" 
                                                    <?php echo ($row['head_of_quality'] === 'Approve the change') ? 'checked' : ''; ?>>
                                                Approve the change
                                                <input type="checkbox" class="type-checkbox cbox" 
                                                    name="head_of_quality" 
                                                    value="Donot approve the change" 
                                                    <?php echo ($row['head_of_quality'] === 'Donot approve the change') ? 'checked' : ''; ?>>
                                                Donot approve the change
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="p-2">Chief Executive Officer</td>
                                            <td class="p-2">
                                                <input type="checkbox" class="type-checkbox cbox" 
                                                    name="ceo" 
                                                    value="Authorized" 
                                                    <?php echo ($row['ceo'] === 'Authorized') ? 'checked' : ''; ?>>
                                                Authorized
                                                <input type="checkbox" class="type-checkbox cbox" 
                                                    name="ceo" 
                                                    value="Not Authorized" 
                                                    <?php echo ($row['ceo'] === 'Not Authorized') ? 'checked' : ''; ?>>
                                                Not Authorized
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p>*CEO Authorized required for Criical or Major Changes Only.</p>
                                <!-- page 8 -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Possible Consequences of the change on:</th>
                                            <th>Please Tick</th>
                                            <th>Why/Measures/Dates/Responsibilities</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="pl-2">Cost</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="cost_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['g_cost_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="cost_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['g_cost_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="cost_input" 
                                                    value="<?php echo htmlspecialchars($row['g_cost_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                             
                                        <tr>
                                            <td class="pl-2">Manufacturing</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="manufacturing_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['g_manufacturing_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="manufacturing_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['g_manufacturing_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="manufacturing_input" 
                                                    value="<?php echo htmlspecialchars($row['g_manufacturing_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                             
                                        <tr>
                                            <td class="pl-2">Master Formula Record/BOM</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="master_formula_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['g_master_formula_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="master_formula_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['g_master_formula_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="master_formula_input" 
                                                    value="<?php echo htmlspecialchars($row['g_master_formula_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                                  
                                        <tr>
                                            <td class="pl-2">Packaging/Labeling</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="packaging_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['g_packaging_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="packaging_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['g_packaging_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="packaging_input" 
                                                    value="<?php echo htmlspecialchars($row['g_packaging_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                                    
                                        <tr>
                                            <td class="pl-2">Testing</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="testing_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['g_testing_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="testing_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['g_testing_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="testing_input" 
                                                    value="<?php echo htmlspecialchars($row['g_testing_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                                    
                                        <tr>
                                            <td class="pl-2">Product stability</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="pstability_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['g_product_stability_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="pstability_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['g_product_stability_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="product_stability_input" 
                                                    value="<?php echo htmlspecialchars($row['g_product_stability_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                                   
                                        <tr>
                                            <td class="pl-2">Product quality/specification</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="pquality_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['g_product_quality_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="pquality_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['g_product_quality_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="product_quality_input" 
                                                    value="<?php echo htmlspecialchars($row['g_product_quality_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                             
                                        <tr>
                                            <td class="pl-2">Product supply</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="psupply_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['g_product_supply_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="psupply_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['g_product_supply_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="product_supply_input" 
                                                    value="<?php echo htmlspecialchars($row['g_product_supply_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                            
                                        <tr>
                                            <td class="pl-2">Efficacy</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="efficacy_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['g_efficacy_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="efficacy_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['g_efficacy_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="efficacy_input" 
                                                    value="<?php echo htmlspecialchars($row['g_efficacy_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                                  
                                        <tr>
                                            <td class="pl-2">Equipment impact</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="equipment_impact_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['g_equipment_impact_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="equipment_impact_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['g_equipment_impact_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="equipment_impact_input" 
                                                    value="<?php echo htmlspecialchars($row['g_equipment_impact_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                            
                                        <tr>
                                            <td class="pl-2">Name of product impact</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="name_of_product_impact_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['g_name_of_product_impact_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="name_of_product_impact_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['g_name_of_product_impact_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="name_of_product_impact_input" 
                                                    value="<?php echo htmlspecialchars($row['g_name_of_product_impact_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                    
                                        <tr>
                                            <td class="pl-2">Change in SOP</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="change_in_sop_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['g_change_in_sop_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="change_in_sop_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['g_change_in_sop_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="change_in_sop_input" 
                                                    value="<?php echo htmlspecialchars($row['g_change_in_sop_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                                 
                                        <tr>
                                            <td class="pl-2">Validation</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="validation_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['g_validation_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="validation_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['g_validation_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="validation_input" 
                                                    value="<?php echo htmlspecialchars($row['g_validation_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                                 
                                        <tr>
                                            <td class="pl-2">Qualification</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="qualification_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['g_qualification_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="qualification_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['g_qualification_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="qualification_input" 
                                                    value="<?php echo htmlspecialchars($row['g_qualification_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                                
                                        <tr>
                                            <td class="pl-2">Calibration</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="calibration_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['g_calibration_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="calibration_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['g_calibration_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="calibration_input" 
                                                    value="<?php echo htmlspecialchars($row['g_calibration_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                                   
                                        <tr>
                                            <td class="pl-2">Marketing Impact (local/export)</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="marketing_impact_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['g_marketing_impact_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="marketing_impact_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['g_marketing_impact_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="marketing_impact_input" 
                                                    value="<?php echo htmlspecialchars($row['g_marketing_impact_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                                
                                        <tr>
                                            <td class="pl-2">Registration</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="registration_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['g_registration_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="registration_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['g_registration_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="registration_input" 
                                                    value="<?php echo htmlspecialchars($row['g_registration_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                                 
                                        <tr>
                                            <td class="pl-2">Training Required</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="trequired_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['g_training_required_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="trequired_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['g_training_required_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="training_required_input" 
                                                    value="<?php echo htmlspecialchars($row['g_training_required_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                             
                                        <tr>
                                            <td class="pl-2">Regulatory requirement</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="regulatory_requirement_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['g_regulatory_requirement_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="regulatory_requirement_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['g_regulatory_requirement_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="regulatory_requirement_input" 
                                                    value="<?php echo htmlspecialchars($row['g_regulatory_requirement_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                              
                                        <tr>
                                            <td class="pl-2">Any Other</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="any_other_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['g_any_other_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="any_other_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['g_any_other_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="any_other_input" 
                                                    value="<?php echo htmlspecialchars($row['g_any_other_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- form 9 -->
                                <h6 class="text-center pb-3" style="font-weight: bolder;">Change Control Request Form</h6>
                                <p>Documents Needing Revision as a result of the Change:</p>
                                <table class="table">
                                    <thead style="background-color: grey; color: white;">
                                        <tr style="border:1px solid white!important">
                                            <th rowspan="2" style="border:1px solid white!important;vertical-align: middle;">Documents Name/Type</th>
                                            <th  rowspan="2" style="border:1px solid white!important;vertical-align: middle;">Please Tick</th>
                                            <th colspan="2" style="border:1px solid white!important">Document Identification /Date <br> </th>
                                        </tr>
                                        <tr style="border:1px solid white!important">
                                            <th>Current Change</th>
                                            <th>Changed</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     
                                        <tr>
                                            <td class="pl-2">Bill(s) of Materials</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="bills_of_material_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['h_bills_of_materials_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="bills_of_material_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['h_bills_of_materials_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="bills_of_material_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_bills_of_materials_input_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                            <td>
                                                <input type="text" name="bills_of_material_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_bills_of_materials_input_3'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                             
                                        <tr>
                                            <td class="pl-2">Calibration document(s)</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="cdocument_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['h_calibration_documents_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="cdocument_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['h_calibration_documents_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="calibration_document_input1" 
                                                    value="<?php echo htmlspecialchars($row['h_calibration_documents_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                            <td>
                                                <input type="text" name="calibration_document_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_calibration_documents_3'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                                
                                        <tr>
                                            <td class="pl-2">Contract(s) Supplier & Quality Agreements</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="contracts_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['h_contracts_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="contracts_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['h_contracts_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="contracts_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_contracts_input_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                            <td>
                                                <input type="text" name="contracts_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_contracts_input_3'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                                      
                                        <tr>
                                            <td class="pl-2">Master batch records(s)</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="mbatch_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['h_master_batch_records_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="mbatch_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['h_master_batch_records_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="master_batch_input1" 
                                                    value="<?php echo htmlspecialchars($row['h_master_batch_records_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                            <td>
                                                <input type="text" name="master_batch_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_master_batch_records_3'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                                     
                                        <tr>
                                            <td class="pl-2">Material Characterization/Specification(s)</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="material_characterization_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['h_material_characterization_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="material_characterization_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['h_material_characterization_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="material_characterization_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_material_characterization_input_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                            <td>
                                                <input type="text" name="material_characterization_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_material_characterization_input_3'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                           
                                        <tr>
                                            <td class="pl-2">Master imprinted packaging material</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="mimprinted_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['h_master_imprinted_packaging_material_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="mimprinted_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['h_master_imprinted_packaging_material_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="master_imprinted_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_master_imprinted_packaging_material_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                            <td>
                                                <input type="text" name="master_imprinted_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_master_imprinted_packaging_material_3'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                               
                                        <tr>
                                            <td class="pl-2">Master packaging record(s)</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="mpackaging_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['h_master_packaging_records_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="mpackaging_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['h_master_packaging_records_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="master_packaging_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_master_packaging_records_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                            <td>
                                                <input type="text" name="master_packaging_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_master_packaging_records_3'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                            
                                        <tr>
                                            <td class="pl-2">Stability report(s)</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="stability_report_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['h_stability_report_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="stability_report_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['h_stability_report_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="stability_report_input1" 
                                                    value="<?php echo htmlspecialchars($row['h_stability_report_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                            <td>
                                                <input type="text" name="stability_report_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_stability_report_3'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                             
                                        <tr>
                                            <td class="pl-2">Standard Operating Procedure(s)</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="standard_operating_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['h_standard_operating_procedure_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="standard_operating_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['h_standard_operating_procedure_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="standard_operating_input1" 
                                                    value="<?php echo htmlspecialchars($row['h_standard_operating_procedure_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                            <td>
                                                <input type="text" name="standard_operating_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_standard_operating_procedure_3'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                              
                                        <tr>
                                            <td class="pl-2">Testing Monograph(s)</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="tmonograph_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['h_testing_monograph_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="tmonograph_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['h_testing_monograph_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="testing_monograph_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_testing_monograph_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                            <td>
                                                <input type="text" name="testing_monograph_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_testing_monograph_3'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                                  
                                        <tr>
                                            <td class="pl-2">Training document(s)</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="tdocument_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['h_training_document_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="tdocument_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['h_training_document_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="tdocument_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_training_document_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                            <td>
                                                <input type="text" name="training_document_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_training_document_3'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                               
                                        <tr>
                                            <td class="pl-2">Plant drawing(s)</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="plant_drawing_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['h_plant_drawings_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="plant_drawing_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['h_plant_drawings_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="plant_drawing_input1" 
                                                    value="<?php echo htmlspecialchars($row['h_plant_drawings_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                            <td>
                                                <input type="text" name="plant_drawing_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_plant_drawings_3'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                  
                                        <tr>
                                            <td class="pl-2">Qualification Protocol(s)</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="qprotocol_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['h_qualification_protocols_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="qprotocol_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['h_qualification_protocols_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="qualification_protocol_input1" 
                                                    value="<?php echo htmlspecialchars($row['h_qualification_protocols_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                            <td>
                                                <input type="text" name="qualification_protocol_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_qualification_protocols_3'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                  
                                        <tr>
                                            <td class="pl-2">Qualification report(s)</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="qreport_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['h_qualification_reports_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="qreport_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['h_qualification_reports_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="qualification_report_input1" 
                                                    value="<?php echo htmlspecialchars($row['h_qualification_reports_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                            <td>
                                                <input type="text" name="qualification_report_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_qualification_reports_3'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                           
                                        <tr>
                                            <td class="pl-2">Registration dossier(s)</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="rdossier_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['h_registration_dossiers_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="rdossier_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['h_registration_dossiers_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="registration_dossier_input1" 
                                                    value="<?php echo htmlspecialchars($row['h_registration_dossiers_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                            <td>
                                                <input type="text" name="registration_dossier_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_registration_dossiers_3'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                    
                                        <tr>
                                            <td class="pl-2">Validation Protocol(s)</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="vprotocol_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['h_validation_protocols_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="vprotocol_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['h_validation_protocols_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="validation_protocol_input1" 
                                                    value="<?php echo htmlspecialchars($row['h_validation_protocols_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                            <td>
                                                <input type="text" name="validation_protocol_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_validation_protocols_3'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                               
                                        <tr>
                                            <td class="pl-2">Validation report(s)</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="vreport_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['h_validation_reports_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="vreport_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['h_validation_reports_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="validation_report_input1" 
                                                    value="<?php echo htmlspecialchars($row['h_validation_reports_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                            <td>
                                                <input type="text" name="validation_report_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_validation_reports_3'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                           
                                        <tr>
                                            <td class="pl-2">other</td>
                                            <td class="pt-3 pl-2">
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="other_yes_no" 
                                                    value="Yes" 
                                                    <?php echo ($row['h_others_1'] === 'Yes') ? 'checked' : ''; ?>>
                                                Yes
                                                </label>
                                                <label>
                                                <input type="checkbox" class="category-checkbox cbox" 
                                                    name="other_yes_no" 
                                                    value="No" 
                                                    <?php echo ($row['h_others_1'] === 'No') ? 'checked' : ''; ?>>
                                                No
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="other_input1" 
                                                    value="<?php echo htmlspecialchars($row['h_other_2'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                            <td>
                                                <input type="text" name="other_input2" 
                                                    value="<?php echo htmlspecialchars($row['h_other_3'] ?? '', ENT_QUOTES); ?>">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- form 10 -->
                                <table class="table">
                                    <tr>
                                        <th colspan="2" style="background-color:gray;color:white">Change Control Closing</th>
                                    </tr>
                                    <tr>
                                        <td rowspan="8" style="vertical-align:middle!important" class="pl-2">Effectiveness Checks
                                            Completion:
                                        </td>
                                        <td><input type="text" name="i_1"   value="<?php echo $row['i_1']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="i_2"   value="<?php echo $row['i_2']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="i_3"   value="<?php echo $row['i_3']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="i_4"   value="<?php echo $row['i_4']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="i_5"   value="<?php echo $row['i_5']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="i_6"   value="<?php echo $row['i_6']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="i_7"   value="<?php echo $row['i_7']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="i_8"   value="<?php echo $row['i_8']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td  class="pl-2">Change completion date:</td>
                                        <td><input type="text" name="i_9"></td>
                                    </tr>
                                    <tr>
                                        <td  class="pl-2">
                                            <div style="display: flex; align-items: center; gap: 5px;">
                                                <label for="name">Name:</label>
                                                <input type="text"  name="i_10" style="flex: 1;"  value="<?php echo $row['i_10']; ?>">>
                                            </div>
                                        </td>
                                        <td  class="pl-2">
                                            <div style="display: flex; align-items: center; gap: 5px;">
                                                <label for="sign">Sign / Date:</label>
                                                <input type="date"  name="i_11">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-submit" name="submit" style="font-size: 20px">Submit</button>
                                </div>
                            </form>
                            <?php
                                include 'dbconfig.php';
                                
                                // Check if form is submitted
                                if (isset($_POST['submit'])) {
                                    // Retrieve form data
                                    $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                                    $name =  $_SESSION['fullname'];
                                
                                                   $f_f_ac_1 = isset($_POST['f_ac_1']) && $_POST['f_ac_1'] !== $row['f_ac_1'] ? $_POST['f_ac_1'] : $row['f_ac_1'];
                                                   $f_f_ac_2 = isset($_POST['f_ac_2']) && $_POST['f_ac_2'] !== $row['f_ac_2'] ? $_POST['f_ac_2'] : $row['f_ac_2'];
                                                   $f_f_ac_3 = isset($_POST['f_ac_3']) && $_POST['f_ac_3'] !== $row['f_ac_3'] ? $_POST['f_ac_3'] : $row['f_ac_3'];
                                                   $f_f_ac_4= isset($_POST['f_ac_4']) && $_POST['f_ac_4'] !== $row['f_ac_4'] ? $_POST['f_ac_4'] : $row['f_ac_4'];
                                                   $f_f_ac_5= isset($_POST['f_ac_5']) && $_POST['f_ac_5'] !== $row['f_ac_5'] ? $_POST['f_ac_5'] : $row['f_ac_5'];
                                                   $f_f_ac_6 = isset($_POST['f_ac_6']) && $_POST['f_ac_6'] !== $row['f_ac_6'] ? $_POST['f_ac_6'] : $row['f_ac_6'];
                                                   $f_f_ac_7 = isset($_POST['f_ac_7']) && $_POST['f_ac_7'] !== $row['f_ac_7'] ? $_POST['f_ac_7'] : $row['f_ac_7'];
                                                   $f_f_ac_8 = isset($_POST['f_ac_8']) && $_POST['f_ac_8'] !== $row['f_ac_8'] ? $_POST['f_ac_8'] : $row['f_ac_8'];
                                                   $f_f_ac_9 = isset($_POST['f_ac_9']) && $_POST['f_ac_9'] !== $row['f_ac_9'] ? $_POST['f_ac_9'] : $row['f_ac_9'];
                                                   $f_f_ac_10 = isset($_POST['f_ac_10']) && $_POST['f_ac_10'] !== $row['f_ac_10'] ? $_POST['f_ac_10'] : $row['f_ac_10'];
                                
                                
                                                   $f_f_responsibility_1 = isset($_POST['f_responsibility_1']) && $_POST['f_responsibility_1'] !== $row['f_responsibility_1'] ? $_POST['f_responsibility_1'] : $row['f_responsibility_1'];
                                                   $f_f_responsibility_2 = isset($_POST['f_responsibility_2']) && $_POST['f_responsibility_2'] !== $row['f_responsibility_2'] ? $_POST['f_responsibility_2'] : $row['f_responsibility_2'];
                                                   $f_f_responsibility_3 = isset($_POST['f_responsibility_3']) && $_POST['f_responsibility_3'] !== $row['f_responsibility_3'] ? $_POST['f_responsibility_3'] : $row['f_responsibility_3'];
                                                   $f_f_responsibility_4 = isset($_POST['f_responsibility_4']) && $_POST['f_responsibility_4'] !== $row['f_responsibility_4'] ? $_POST['f_responsibility_4'] : $row['f_responsibility_4'];
                                                   $f_f_responsibility_5 = isset($_POST['f_responsibility_5']) && $_POST['f_responsibility_5'] !== $row['f_responsibility_5'] ? $_POST['f_responsibility_5'] : $row['f_responsibility_5'];
                                                   $f_f_responsibility_6 = isset($_POST['f_responsibility_6']) && $_POST['f_responsibility_6'] !== $row['f_responsibility_6'] ? $_POST['f_responsibility_6'] : $row['f_responsibility_6'];
                                                   $f_f_responsibility_7 = isset($_POST['f_responsibility_7']) && $_POST['f_responsibility_7'] !== $row['f_responsibility_7'] ? $_POST['f_responsibility_7'] : $row['f_responsibility_7'];
                                                   $f_f_responsibility_8 = isset($_POST['f_responsibility_8']) && $_POST['f_responsibility_8'] !== $row['f_responsibility_8'] ? $_POST['f_responsibility_8'] : $row['f_responsibility_8'];
                                                   $f_f_responsibility_9 = isset($_POST['f_responsibility_9']) && $_POST['f_responsibility_9'] !== $row['f_responsibility_9'] ? $_POST['f_responsibility_9'] : $row['f_responsibility_9'];
                                                   $f_f_responsibility_10 = isset($_POST['f_responsibility_10']) && $_POST['f_responsibility_10'] !== $row['f_responsibility_10'] ? $_POST['f_responsibility_10'] : $row['f_responsibility_10'];
                                
                                                   $f_f_timeline_1 = isset($_POST['f_timeline_1']) && $_POST['f_timeline_1'] !== $row['f_timeline_1'] ? $_POST['f_timeline_1'] : $row['f_timeline_1'];
                                                   $f_f_timeline_2 = isset($_POST['f_timeline_2']) && $_POST['f_timeline_2'] !== $row['f_timeline_2'] ? $_POST['f_timeline_2'] : $row['f_timeline_2'];
                                                   $f_f_timeline_3 = isset($_POST['f_timeline_3']) && $_POST['f_timeline_3'] !== $row['f_timeline_3'] ? $_POST['f_timeline_3'] : $row['f_timeline_3'];
                                                   $f_f_timeline_4 = isset($_POST['f_timeline_4']) && $_POST['f_timeline_4'] !== $row['f_timeline_4'] ? $_POST['f_timeline_4'] : $row['f_timeline_4'];
                                                   $f_f_timeline_5 = isset($_POST['f_timeline_5']) && $_POST['f_timeline_5'] !== $row['f_timeline_5'] ? $_POST['f_timeline_5'] : $row['f_timeline_5'];
                                                   $f_f_timeline_6 = isset($_POST['f_timeline_6']) && $_POST['f_timeline_6'] !== $row['f_timeline_6'] ? $_POST['f_timeline_6'] : $row['f_timeline_6'];
                                                   $f_f_timeline_7 = isset($_POST['f_timeline_7']) && $_POST['f_timeline_7'] !== $row['f_timeline_7'] ? $_POST['f_timeline_7'] : $row['f_timeline_7'];
                                                   $f_f_timeline_8 = isset($_POST['f_timeline_8']) && $_POST['f_timeline_8'] !== $row['f_timeline_8'] ? $_POST['f_timeline_8'] : $row['f_timeline_8'];
                                                   $f_f_timeline_9 = isset($_POST['f_timeline_9']) && $_POST['f_timeline_9'] !== $row['f_timeline_9'] ? $_POST['f_timeline_9'] : $row['f_timeline_9'];
                                                   $f_f_timeline_10 = isset($_POST['f_timeline_10']) && $_POST['f_timeline_10'] !== $row['f_timeline_10'] ? $_POST['f_timeline_10'] : $row['f_timeline_10'];
                                
                                
                                
                                                   $f_f_signature_1 = isset($_POST['f_signature_1']) && $_POST['f_signature_1'] !== $row['f_signature_1'] ? $_POST['f_signature_1'] : $row['f_signature_1'];
                                                   $f_f_signature_2 = isset($_POST['f_signature_2']) && $_POST['f_signature_2'] !== $row['f_signature_2'] ? $_POST['f_signature_2'] : $row['f_signature_2'];
                                                   $f_f_signature_3 = isset($_POST['f_signature_3']) && $_POST['f_signature_3'] !== $row['f_signature_3'] ? $_POST['f_signature_3'] : $row['f_signature_3'];
                                                   $f_f_signature_4 = isset($_POST['f_signature_4']) && $_POST['f_signature_4'] !== $row['f_signature_4'] ? $_POST['f_signature_4'] : $row['f_signature_4'];
                                                   $f_f_signature_5 = isset($_POST['f_signature_5']) && $_POST['f_signature_5'] !== $row['f_signature_5'] ? $_POST['f_signature_5'] : $row['f_signature_5'];
                                                   $f_f_signature_6 = isset($_POST['f_signature_6']) && $_POST['f_signature_6'] !== $row['f_signature_6'] ? $_POST['f_signature_6'] : $row['f_signature_6'];
                                                   $f_f_signature_7 = isset($_POST['f_signature_7']) && $_POST['f_signature_7'] !== $row['f_signature_7'] ? $_POST['f_signature_7'] : $row['f_signature_7'];
                                                   $f_f_signature_8 = isset($_POST['f_signature_8']) && $_POST['f_signature_8'] !== $row['f_signature_8'] ? $_POST['f_signature_8'] : $row['f_signature_8'];
                                                   $f_f_signature_9 = isset($_POST['f_signature_9']) && $_POST['f_signature_9'] !== $row['f_signature_9'] ? $_POST['f_signature_9'] : $row['f_signature_9'];
                                                   $f_f_signature_10 = isset($_POST['f_signature_10']) && $_POST['f_signature_10'] !== $row['f_signature_10'] ? $_POST['f_signature_10'] : $row['f_signature_10'];
                                
                                
                                                   $f_f_verify_by_1 = isset($_POST['f_verify_by_1']) && $_POST['f_verify_by_1'] !== $row['f_verify_by_1'] ? $_POST['f_verify_by_1'] : $row['f_verify_by_1'];
                                                   $f_f_verify_by_2 = isset($_POST['f_verify_by_2']) && $_POST['f_verify_by_2'] !== $row['f_verify_by_2'] ? $_POST['f_verify_by_2'] : $row['f_verify_by_2'];
                                                   $f_f_verify_by_3 = isset($_POST['f_verify_by_3']) && $_POST['f_verify_by_3'] !== $row['f_verify_by_3'] ? $_POST['f_verify_by_3'] : $row['f_verify_by_3'];
                                                   $f_f_verify_by_4 = isset($_POST['f_verify_by_4']) && $_POST['f_verify_by_4'] !== $row['f_verify_by_4'] ? $_POST['f_verify_by_4'] : $row['f_verify_by_4'];
                                                   $f_f_verify_by_5 = isset($_POST['f_verify_by_5']) && $_POST['f_verify_by_5'] !== $row['f_verify_by_5'] ? $_POST['f_verify_by_5'] : $row['f_verify_by_5'];
                                                   $f_f_verify_by_6 = isset($_POST['f_verify_by_6']) && $_POST['f_verify_by_6'] !== $row['f_verify_by_6'] ? $_POST['f_verify_by_6'] : $row['f_verify_by_6'];
                                                   $f_f_verify_by_7 = isset($_POST['f_verify_by_7']) && $_POST['f_verify_by_7'] !== $row['f_verify_by_7'] ? $_POST['f_verify_by_7'] : $row['f_verify_by_7'];
                                                   $f_f_verify_by_8 = isset($_POST['f_verify_by_8']) && $_POST['f_verify_by_8'] !== $row['f_verify_by_8'] ? $_POST['f_verify_by_8'] : $row['f_verify_by_8'];
                                                   $f_f_verify_by_9 = isset($_POST['f_verify_by_9']) && $_POST['f_verify_by_9'] !== $row['f_verify_by_9'] ? $_POST['f_verify_by_9'] : $row['f_verify_by_9'];
                                                   $f_f_verify_by_10 = isset($_POST['f_verify_by_10']) && $_POST['f_verify_by_10'] !== $row['f_verify_by_10'] ? $_POST['f_verify_by_10'] : $row['f_verify_by_10'];
                                
                                
                                                   $f_head_of_quality = isset($_POST['head_of_quality']) && $_POST['head_of_quality'] !== $row['head_of_quality'] ? $_POST['head_of_quality'] : $row['head_of_quality'];
                                                   $f_ceo = isset($_POST['ceo']) && $_POST['ceo'] !== $row['ceo'] ? $_POST['ceo'] : $row['ceo'];
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                                //    page 8 
                                                // table 1
                                
                                                $f_cost_yes_no = isset($_POST['cost_yes_no']) && $_POST['cost_yes_no'] !== $row['cost_yes_no'] ? $_POST['cost_yes_no'] : $row['cost_yes_no'];
                                                $f_cost_input = isset($_POST['cost_input']) && $_POST['cost_input'] !== $row['cost_input'] ? $_POST['cost_input'] : $row['cost_input'];
                                
                                
                                                $f_manufacturing_yes_no = isset($_POST['manufacturing_yes_no']) && $_POST['manufacturing_yes_no'] !== $row['manufacturing_yes_no'] ? $_POST['manufacturing_yes_no'] : $row['manufacturing_yes_no'];
                                                $f_manufacturing_input = isset($_POST['manufacturing_input']) && $_POST['manufacturing_input'] !== $row['manufacturing_input'] ? $_POST['manufacturing_input'] : $row['manufacturing_input'];
                                               
                                
                                                $f_master_formula_yes_no = isset($_POST['master_formula_yes_no']) && $_POST['master_formula_yes_no'] !== $row['master_formula_yes_no'] ? $_POST['master_formula_yes_no'] : $row['master_formula_yes_no'];
                                                $f_master_formula_input = isset($_POST['master_formula_input']) && $_POST['master_formula_input'] !== $row['master_formula_input'] ? $_POST['master_formula_input'] : $row['master_formula_input'];
                                
                                
                                                $f_packaging_yes_no = isset($_POST['packaging_yes_no']) && $_POST['packaging_yes_no'] !== $row['packaging_yes_no'] ? $_POST['packaging_yes_no'] : $row['packaging_yes_no'];
                                                $f_packaging_input = isset($_POST['packaging_input']) && $_POST['packaging_input'] !== $row['packaging_input'] ? $_POST['packaging_input'] : $row['packaging_input'];
                                
                                
                                                $f_testing_yes_no = isset($_POST['testing_yes_no']) && $_POST['testing_yes_no'] !== $row['testing_yes_no'] ? $_POST['testing_yes_no'] : $row['testing_yes_no'];
                                                $f_testing_input = isset($_POST['testing_input']) && $_POST['testing_input'] !== $row['testing_input'] ? $_POST['testing_input'] : $row['testing_input'];
                                
                                
                                                $f_product_stability_yes_no = isset($_POST['pstability_yes_no']) && $_POST['pstability_yes_no'] !== $row['pstability_yes_no'] ? $_POST['pstability_yes_no'] : $row['pstability_yes_no'];
                                                $f_product_stability_input = isset($_POST['product_stability_input']) && $_POST['product_stability_input'] !== $row['product_stability_input'] ? $_POST['product_stability_input'] : $row['product_stability_input'];
                                
                                
                                                $f_product_quality_yes_no = isset($_POST['pquality_yes_no']) && $_POST['pquality_yes_no'] !== $row['pquality_yes_no'] ? $_POST['pquality_yes_no'] : $row['pquality_yes_no'];
                                                $f_product_quality_input = isset($_POST['product_quality_input']) && $_POST['product_quality_input'] !== $row['product_quality_input'] ? $_POST['product_quality_input'] : $row['product_quality_input'];
                                
                                
                                                $f_product_supply_yes_no = isset($_POST['psupply_yes_no']) && $_POST['psupply_yes_no'] !== $row['psupply_yes_no'] ? $_POST['psupply_yes_no'] : $row['psupply_yes_no'];
                                                $f_product_supply_input = isset($_POST['product_supply_input']) && $_POST['product_supply_input'] !== $row['product_supply_input'] ? $_POST['product_supply_input'] : $row['product_supply_input'];
                                
                                
                                                $f_efficacy_yes_no = isset($_POST['efficacy_yes_no']) && $_POST['efficacy_yes_no'] !== $row['efficacy_yes_no'] ? $_POST['efficacy_yes_no'] : $row['efficacy_yes_no'];
                                                $f_efficacy_input = isset($_POST['efficacy_input']) && $_POST['efficacy_input'] !== $row['efficacy_input'] ? $_POST['efficacy_input'] : $row['efficacy_input'];
                                
                                
                                                $f_equipment_impact_yes_no = isset($_POST['equipment_impact_yes_no']) && $_POST['equipment_impact_yes_no'] !== $row['equipment_impact_yes_no'] ? $_POST['equipment_impact_yes_no'] : $row['equipment_impact_yes_no'];
                                                $f_equipment_impact_input = isset($_POST['equipment_impact_input']) && $_POST['equipment_impact_input'] !== $row['equipment_impact_input'] ? $_POST['equipment_impact_input'] : $row['equipment_impact_input'];
                                
                                
                                                $f_name_of_product_impact_yes_no = isset($_POST['name_of_product_impact_yes_no']) && $_POST['name_of_product_impact_yes_no'] !== $row['name_of_product_impact_yes_no'] ? $_POST['name_of_product_impact_yes_no'] : $row['name_of_product_impact_yes_no'];
                                                $f_name_of_product_impact_input = isset($_POST['name_of_product_impact_input']) && $_POST['name_of_product_impact_input'] !== $row['name_of_product_impact_input'] ? $_POST['name_of_product_impact_input'] : $row['name_of_product_impact_input'];
                                
                                
                                                $f_change_in_sop_yes_no = isset($_POST['change_in_sop_yes_no']) && $_POST['change_in_sop_yes_no'] !== $row['change_in_sop_yes_no'] ? $_POST['change_in_sop_yes_no'] : $row['change_in_sop_yes_no'];
                                                $f_change_in_sop_input = isset($_POST['change_in_sop_input']) && $_POST['change_in_sop_input'] !== $row['change_in_sop_input'] ? $_POST['change_in_sop_input'] : $row['change_in_sop_input'];
                                
                                
                                                $f_validation_yes_no = isset($_POST['validation_yes_no']) && $_POST['validation_yes_no'] !== $row['validation_yes_no'] ? $_POST['validation_yes_no'] : $row['validation_yes_no'];
                                                $f_validation_input = isset($_POST['validation_input']) && $_POST['validation_input'] !== $row['validation_input'] ? $_POST['validation_input'] : $row['validation_input'];
                                
                                
                                                $f_qualification_yes_no = isset($_POST['qualification_yes_no']) && $_POST['qualification_yes_no'] !== $row['qualification_yes_no'] ? $_POST['qualification_yes_no'] : $row['qualification_yes_no'];
                                                $f_qualification_input = isset($_POST['qualification_input']) && $_POST['qualification_input'] !== $row['qualification_input'] ? $_POST['qualification_input'] : $row['qualification_input'];
                                
                                
                                                $f_calibration_yes_no = isset($_POST['calibration_yes_no']) && $_POST['calibration_yes_no'] !== $row['calibration_yes_no'] ? $_POST['calibration_yes_no'] : $row['calibration_yes_no'];
                                                $f_calibration_input = isset($_POST['calibration_input']) && $_POST['calibration_input'] !== $row['calibration_input'] ? $_POST['calibration_input'] : $row['calibration_input'];
                                
                                
                                                $f_marketing_impact_yes_no = isset($_POST['marketing_impact_yes_no']) && $_POST['marketing_impact_yes_no'] !== $row['marketing_impact_yes_no'] ? $_POST['marketing_impact_yes_no'] : $row['marketing_impact_yes_no'];
                                                $f_marketing_impact_input = isset($_POST['marketing_impact_input']) && $_POST['marketing_impact_input'] !== $row['marketing_impact_input'] ? $_POST['marketing_impact_input'] : $row['marketing_impact_input'];
                                
                                
                                                $f_registration_yes_no = isset($_POST['registration_yes_no']) && $_POST['registration_yes_no'] !== $row['registration_yes_no'] ? $_POST['registration_yes_no'] : $row['registration_yes_no'];
                                                $f_registration_input = isset($_POST['registration_input']) && $_POST['registration_input'] !== $row['registration_input'] ? $_POST['registration_input'] : $row['registration_input'];
                                
                                
                                                $f_training_required_yes_no = isset($_POST['trequired_yes_no']) && $_POST['trequired_yes_no'] !== $row['trequired_yes_no'] ? $_POST['trequired_yes_no'] : $row['trequired_yes_no'];
                                                $f_training_required_input = isset($_POST['training_required_input']) && $_POST['training_required_input'] !== $row['training_required_input'] ? $_POST['training_required_input'] : $row['training_required_input'];
                                
                                
                                                $f_regulatory_requirement_yes_no = isset($_POST['regulatory_requirement_yes_no']) && $_POST['regulatory_requirement_yes_no'] !== $row['regulatory_requirement_yes_no'] ? $_POST['regulatory_requirement_yes_no'] : $row['regulatory_requirement_yes_no'];
                                                $f_regulatory_requirement_input = isset($_POST['regulatory_requirement_input']) && $_POST['regulatory_requirement_input'] !== $row['regulatory_requirement_input'] ? $_POST['regulatory_requirement_input'] : $row['regulatory_requirement_input'];
                                
                                
                                                $f_any_other_yes_no = isset($_POST['any_other_yes_no']) && $_POST['any_other_yes_no'] !== $row['any_other_yes_no'] ? $_POST['any_other_yes_no'] : $row['any_other_yes_no'];
                                                $f_any_other_input = isset($_POST['any_other_input']) && $_POST['any_other_input'] !== $row['any_other_input'] ? $_POST['any_other_input'] : $row['any_other_input'];
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                                // form 9
                                
                                                $f_bills_of_material_yes_no = isset($_POST['bills_of_material_yes_no']) && $_POST['bills_of_material_yes_no'] !== $row['bills_of_material_yes_no'] ? $_POST['bills_of_material_yes_no'] : $row['bills_of_material_yes_no'];
                                                $f_bills_of_material_input1 = isset($_POST['bills_of_material_input1']) && $_POST['bills_of_material_input1'] !== $row['bills_of_material_input1'] ? $_POST['bills_of_material_input1'] : $row['bills_of_material_input1'];
                                                $f_bills_of_material_input2 = isset($_POST['bills_of_material_input2']) && $_POST['bills_of_material_input2'] !== $row['bills_of_material_input2'] ? $_POST['bills_of_material_input2'] : $row['bills_of_material_input2'];
                                
                                                $f_calibration_document_yes_no = isset($_POST['cdocument_yes_no']) && $_POST['cdocument_yes_no'] !== $row['cdocument_yes_no'] ? $_POST['cdocument_yes_no'] : $row['cdocument_yes_no'];
                                                $f_calibration_document_input1 = isset($_POST['calibration_document_input1']) && $_POST['calibration_document_input1'] !== $row['calibration_document_input1'] ? $_POST['calibration_document_input1'] : $row['calibration_document_input1'];
                                                $f_calibration_document_input2 = isset($_POST['calibration_document_input2']) && $_POST['calibration_document_input2'] !== $row['calibration_document_input2'] ? $_POST['calibration_document_input2'] : $row['calibration_document_input2'];
                                
                                                $f_contracts_yes_no = isset($_POST['contracts_yes_no']) && $_POST['contracts_yes_no'] !== $row['contracts_yes_no'] ? $_POST['contracts_yes_no'] : $row['contracts_yes_no'];
                                                $f_contracts_input1 = isset($_POST['contracts_input1']) && $_POST['contracts_input1'] !== $row['contracts_input1'] ? $_POST['contracts_input1'] : $row['contracts_input1'];
                                                $f_contracts_input2 = isset($_POST['contracts_input2']) && $_POST['contracts_input2'] !== $row['contracts_input2'] ? $_POST['contracts_input2'] : $row['contracts_input2'];
                                
                                                $f_master_batch_yes_no = isset($_POST['mbatch_yes_no']) && $_POST['mbatch_yes_no'] !== $row['mbatch_yes_no'] ? $_POST['mbatch_yes_no'] : $row['mbatch_yes_no'];
                                                $f_master_batch_input1 = isset($_POST['master_batch_input1']) && $_POST['master_batch_input1'] !== $row['master_batch_input1'] ? $_POST['master_batch_input1'] : $row['master_batch_input1'];
                                                $f_master_batch_input2 = isset($_POST['master_batch_input2']) && $_POST['master_batch_input2'] !== $row['master_batch_input2'] ? $_POST['master_batch_input2'] : $row['master_batch_input2'];
                                
                                                $f_material_characterization_yes_no = isset($_POST['material_characterization_yes_no']) && $_POST['material_characterization_yes_no'] !== $row['material_characterization_yes_no'] ? $_POST['material_characterization_yes_no'] : $row['material_characterization_yes_no'];
                                                $f_material_characterization_input1= isset($_POST['material_characterization_input1']) && $_POST['material_characterization_input1'] !== $row['material_characterization_input1'] ? $_POST['material_characterization_input1'] : $row['material_characterization_input1'];
                                                $f_material_characterization_input2 = isset($_POST['material_characterization_input2']) && $_POST['material_characterization_input2'] !== $row['material_characterization_input2'] ? $_POST['material_characterization_input2'] : $row['material_characterization_input2'];
                                
                                
                                                 //    second part
                                                $f_master_imprinted_yes_no = isset($_POST['mimprinted_yes_no']) && $_POST['mimprinted_yes_no'] !== $row['mimprinted_yes_no'] ? $_POST['mimprinted_yes_no'] : $row['mimprinted_yes_no'];
                                                $f_master_imprinted_input1 = isset($_POST['master_imprinted_input1']) && $_POST['master_imprinted_input1'] !== $row['master_imprinted_input1'] ? $_POST['master_imprinted_input1'] : $row['master_imprinted_input1'];
                                                $f_master_imprinted_input2 = isset($_POST['master_imprinted_input2']) && $_POST['master_imprinted_input2'] !== $row['master_imprinted_input2'] ? $_POST['master_imprinted_input2'] : $row['master_imprinted_input2'];
                                
                                                $f_master_packaging_yes_no = isset($_POST['mpackaging_yes_no']) && $_POST['mpackaging_yes_no'] !== $row['mpackaging_yes_no'] ? $_POST['mpackaging_yes_no'] : $row['mpackaging_yes_no'];
                                                $f_master_packaging_input1 = isset($_POST['master_packaging_input1']) && $_POST['master_packaging_input1'] !== $row['master_packaging_input1'] ? $_POST['master_packaging_input1'] : $row['master_packaging_input1'];
                                                $f_master_packaging_input2 = isset($_POST['master_packaging_input2']) && $_POST['master_packaging_input2'] !== $row['master_packaging_input2'] ? $_POST['master_packaging_input2'] : $row['master_packaging_input2'];
                                
                                                $f_stability_report_yes_no = isset($_POST['stability_report_yes_no']) && $_POST['stability_report_yes_no'] !== $row['stability_report_yes_no'] ? $_POST['stability_report_yes_no'] : $row['stability_report_yes_no'];
                                                $f_stability_report_input1= isset($_POST['stability_report_input1']) && $_POST['stability_report_input1'] !== $row['stability_report_input1'] ? $_POST['stability_report_input1'] : $row['stability_report_input1'];
                                                $f_stability_report_input2 = isset($_POST['stability_report_input2']) && $_POST['stability_report_input2'] !== $row['stability_report_input2'] ? $_POST['stability_report_input2'] : $row['stability_report_input2'];
                                
                                                $f_standard_operating_yes_no = isset($_POST['standard_operating_yes_no']) && $_POST['standard_operating_yes_no'] !== $row['standard_operating_yes_no'] ? $_POST['standard_operating_yes_no'] : $row['standard_operating_yes_no'];
                                                $f_standard_operating_input1 = isset($_POST['standard_operating_input1']) && $_POST['standard_operating_input1'] !== $row['standard_operating_input1'] ? $_POST['standard_operating_input1'] : $row['standard_operating_input1'];
                                                $f_standard_operating_input2 = isset($_POST['standard_operating_input2']) && $_POST['standard_operating_input2'] !== $row['standard_operating_input2'] ? $_POST['standard_operating_input2'] : $row['standard_operating_input2'];
                                
                                                $f_testing_monograph_yes_no = isset($_POST['tmonograph_yes_no']) && $_POST['tmonograph_yes_no'] !== $row['tmonograph_yes_no'] ? $_POST['tmonograph_yes_no'] : $row['tmonograph_yes_no'];
                                                $f_testing_monograph_input1 = isset($_POST['testing_monograph_input1']) && $_POST['testing_monograph_input1'] !== $row['testing_monograph_input1'] ? $_POST['testing_monograph_input1'] : $row['testing_monograph_input1'];
                                                $f_testing_monograph_input2 = isset($_POST['testing_monograph_input2']) && $_POST['testing_monograph_input2'] !== $row['testing_monograph_input2'] ? $_POST['testing_monograph_input2'] : $row['testing_monograph_input2'];
                                
                                                 // third part
                                                $f_training_document_yes_no = isset($_POST['tdocument_yes_no']) && $_POST['tdocument_yes_no'] !== $row['tdocument_yes_no'] ? $_POST['tdocument_yes_no'] : $row['tdocument_yes_no'];
                                                $f_training_document_input1 = isset($_POST['training_document_input1']) && $_POST['training_document_input1'] !== $row['training_document_input1'] ? $_POST['training_document_input1'] : $row['training_document_input1'];
                                                $f_training_document_input2 = isset($_POST['training_document_input2']) && $_POST['training_document_input2'] !== $row['training_document_input2'] ? $_POST['training_document_input2'] : $row['training_document_input2'];
                                
                                                $f_plant_drawing_yes_no = isset($_POST['plant_drawing_yes_no']) && $_POST['plant_drawing_yes_no'] !== $row['plant_drawing_yes_no'] ? $_POST['plant_drawing_yes_no'] : $row['plant_drawing_yes_no'];
                                                $f_plant_drawing_input1 = isset($_POST['plant_drawing_input1']) && $_POST['plant_drawing_input1'] !== $row['plant_drawing_input1'] ? $_POST['plant_drawing_input1'] : $row['plant_drawing_input1'];
                                                $f_plant_drawing_input2 = isset($_POST['plant_drawing_input2']) && $_POST['plant_drawing_input2'] !== $row['plant_drawing_input2'] ? $_POST['plant_drawing_input2'] : $row['plant_drawing_input2'];
                                
                                                $f_qualification_protocol_yes_no = isset($_POST['qprotocol_yes_no']) && $_POST['qprotocol_yes_no'] !== $row['qprotocol_yes_no'] ? $_POST['qprotocol_yes_no'] : $row['qprotocol_yes_no'];
                                                $f_qualification_protocol_input1 = isset($_POST['qualification_protocol_input1']) && $_POST['qualification_protocol_input1'] !== $row['qualification_protocol_input1'] ? $_POST['qualification_protocol_input1'] : $row['qualification_protocol_input1'];
                                                $f_qualification_protocol_input2 = isset($_POST['qualification_protocol_input2']) && $_POST['qualification_protocol_input2'] !== $row['qualification_protocol_input2'] ? $_POST['qualification_protocol_input2'] : $row['qualification_protocol_input2'];
                                
                                                $f_qualification_report_yes_no = isset($_POST['qreport_yes_no']) && $_POST['qreport_yes_no'] !== $row['qreport_yes_no'] ? $_POST['qreport_yes_no'] : $row['qreport_yes_no'];
                                                $f_qualification_report_input1 = isset($_POST['qualification_report_input1']) && $_POST['qualification_report_input1'] !== $row['qualification_report_input1'] ? $_POST['qualification_report_input1'] : $row['qualification_report_input1'];
                                                $f_qualification_report_input2 = isset($_POST['qualification_report_input2']) && $_POST['qualification_report_input2'] !== $row['qualification_report_input2'] ? $_POST['qualification_report_input2'] : $row['qualification_report_input2'];
                                
                                                $f_registration_dossier_yes_no = isset($_POST['rdossier_yes_no']) && $_POST['rdossier_yes_no'] !== $row['rdossier_yes_no'] ? $_POST['rdossier_yes_no'] : $row['rdossier_yes_no'];
                                                $f_registration_dossier_input1 = isset($_POST['registration_dossier_input1']) && $_POST['registration_dossier_input1'] !== $row['registration_dossier_input1'] ? $_POST['registration_dossier_input1'] : $row['registration_dossier_input1'];
                                                $f_registration_dossier_input2 = isset($_POST['registration_dossier_input2']) && $_POST['registration_dossier_input2'] !== $row['registration_dossier_input2'] ? $_POST['registration_dossier_input2'] : $row['registration_dossier_input2'];
                                
                                
                                                // forth part
                                                $f_validation_protocol_yes_no = isset($_POST['vprotocol_yes_no']) && $_POST['vprotocol_yes_no'] !== $row['vprotocol_yes_no'] ? $_POST['vprotocol_yes_no'] : $row['vprotocol_yes_no'];
                                                $f_validation_protocol_input1 = isset($_POST['validation_protocol_input1']) && $_POST['validation_protocol_input1'] !== $row['validation_protocol_input1'] ? $_POST['validation_protocol_input1'] : $row['validation_protocol_input1'];
                                                $f_validation_protocol_input2 = isset($_POST['validation_protocol_input2']) && $_POST['validation_protocol_input2'] !== $row['validation_protocol_input2'] ? $_POST['validation_protocol_input2'] : $row['validation_protocol_input2'];
                                
                                                $f_validation_report_yes_no = isset($_POST['vreport_yes_no']) && $_POST['vreport_yes_no'] !== $row['vreport_yes_no'] ? $_POST['vreport_yes_no'] : $row['vreport_yes_no'];
                                                $f_validation_report_input1 = isset($_POST['validation_report_input1']) && $_POST['validation_report_input1'] !== $row['validation_report_input1'] ? $_POST['validation_report_input1'] : $row['validation_report_input1'];
                                                $f_validation_report_input2 = isset($_POST['validation_report_input2']) && $_POST['validation_report_input2'] !== $row['validation_report_input2'] ? $_POST['validation_report_input2'] : $row['validation_report_input2'];
                                
                                                $f_other_yes_no = isset($_POST['other_yes_no']) && $_POST['other_yes_no'] !== $row['other_yes_no'] ? $_POST['other_yes_no'] : $row['other_yes_no'];
                                                $f_other_input1 = isset($_POST['other_input1']) && $_POST['other_input1'] !== $row['other_input1'] ? $_POST['other_input1'] : $row['other_input1'];
                                                $f_other_input2 = isset($_POST['other_input2']) && $_POST['other_input2'] !== $row['other_input2'] ? $_POST['other_input2'] : $row['other_input2'];
                                
                                
                                
                                
                                                // form 10
                                
                                                $f_i_1 = isset($_POST['i_1']) && $_POST['i_1'] !== $row['i_1'] ? $_POST['i_1'] : $row['i_1'];
                                                $f_i_2 = isset($_POST['i_2']) && $_POST['i_2'] !== $row['i_2'] ? $_POST['i_2'] : $row['i_2'];
                                                $f_i_3 = isset($_POST['i_3']) && $_POST['i_3'] !== $row['i_3'] ? $_POST['i_3'] : $row['i_3'];
                                                $f_i_4 = isset($_POST['i_4']) && $_POST['i_4'] !== $row['i_4'] ? $_POST['i_4'] : $row['i_4'];
                                                $f_i_5 = isset($_POST['i_5']) && $_POST['i_5'] !== $row['i_5'] ? $_POST['i_5'] : $row['i_5'];
                                                $f_i_6 = isset($_POST['i_6']) && $_POST['i_6'] !== $row['i_6'] ? $_POST['i_6'] : $row['i_6'];
                                                $f_i_7 = isset($_POST['i_7']) && $_POST['i_7'] !== $row['i_7'] ? $_POST['i_7'] : $row['i_7'];
                                                $f_i_8 = isset($_POST['i_8']) && $_POST['i_8'] !== $row['i_8'] ? $_POST['i_8'] : $row['i_8'];
                                                $f_i_9 = isset($_POST['i_9']) && $_POST['i_9'] !== $row['i_9'] ? $_POST['i_9'] : $row['i_9'];
                                                $f_i_10 = isset($_POST['i_10']) && $_POST['i_10'] !== $row['i_10'] ? $_POST['i_10'] : $row['i_10'];
                                
                                
                                
                                
                                                   $f_date = date('Y-m-d');
                                
                                                   $update_query = "UPDATE qc_ccrf2 SET 
                                               
                                                        f_ac_1 = '$f_f_ac_1',
                                                        f_ac_2 = '$f_f_ac_2',
                                                        f_ac_3 = '$f_f_ac_3',
                                                        f_ac_4 = '$f_f_ac_4',
                                                        f_ac_5 = '$f_f_ac_5',
                                                        f_ac_6 = '$f_f_ac_6',
                                                        f_ac_7 = '$f_f_ac_7',
                                                        f_ac_8 = '$f_f_ac_8',
                                                        f_ac_9 = '$f_f_ac_9',
                                                        f_ac_10 = '$f_f_ac_10',
                                
                                                        f_responsibility_1 = '$f_f_responsibility_1',
                                                        f_responsibility_2 = '$f_f_responsibility_2',
                                                        f_responsibility_3 = '$f_f_responsibility_3',
                                                        f_responsibility_4 = '$f_f_responsibility_4',
                                                        f_responsibility_5 = '$f_f_responsibility_5',
                                                        f_responsibility_6 = '$f_f_responsibility_6',
                                                        f_responsibility_7 = '$f_f_responsibility_7',
                                                        f_responsibility_8 = '$f_f_responsibility_8',
                                                        f_responsibility_9 = '$f_f_responsibility_9',
                                                        f_responsibility_10 = '$f_f_responsibility_10',
                                
                                                        f_timeline_1 = '$f_f_timeline_1',
                                                        f_timeline_2 = '$f_f_timeline_2',
                                                        f_timeline_3 = '$f_f_timeline_3',
                                                        f_timeline_4 = '$f_f_timeline_4',
                                                        f_timeline_5 = '$f_f_timeline_5',
                                                        f_timeline_6 = '$f_f_timeline_6',
                                                        f_timeline_7 = '$f_f_timeline_7',
                                                        f_timeline_8 = '$f_f_timeline_8',
                                                        f_timeline_9 = '$f_f_timeline_9',
                                                        f_timeline_10 = '$f_f_timeline_10',
                                
                                                        f_signature_1 = '$f_f_signature_1',
                                                        f_signature_2 = '$f_f_signature_2',
                                                        f_signature_3 = '$f_f_signature_3',
                                                        f_signature_4 = '$f_f_signature_4',
                                                        f_signature_5 = '$f_f_signature_5',
                                                        f_signature_6 = '$f_f_signature_6',
                                                        f_signature_7 = '$f_f_signature_7',
                                                        f_signature_8 = '$f_f_signature_8',
                                                        f_signature_9 = '$f_f_signature_9',
                                                        f_signature_10 = '$f_f_signature_10',
                                
                                                        f_verify_by_1 = '$f_f_verify_by_1',
                                                        f_verify_by_2 = '$f_f_verify_by_2',
                                                        f_verify_by_3 = '$f_f_verify_by_3',
                                                        f_verify_by_4 = '$f_f_verify_by_4',
                                                        f_verify_by_5 = '$f_f_verify_by_5',
                                                        f_verify_by_6 = '$f_f_verify_by_6',
                                                        f_verify_by_7 = '$f_f_verify_by_7',
                                                        f_verify_by_8 = '$f_f_verify_by_8',
                                                        f_verify_by_9 = '$f_f_verify_by_9',
                                                        f_verify_by_10 = '$f_f_verify_by_10',
                                
                                                        head_of_quality = '$f_head_of_quality',
                                                        ceo = '$f_ceo',
                                
                                
                                
                                
                                                        -- page 8
                                
                                                         g_cost_1 = '$f_cost_yes_no',
                                                        g_cost_2 = '$f_cost_input',
                                
                                                        g_manufacturing_1 = '$f_manufacturing_yes_no',
                                                        g_manufacturing_2 = '$f_manufacturing_input',
                                
                                                        g_master_formula_1 = '$f_master_formula_yes_no',
                                                        g_master_formula_2 = '$f_master_formula_input',
                                
                                                        g_packaging_1 = '$f_packaging_yes_no',
                                                        g_packaging_2 = '$f_packaging_input',
                                
                                                        g_testing_1 = '$f_testing_yes_no',
                                                        g_testing_2 = '$f_testing_input',
                                
                                                        g_product_stability_1 = '$f_product_stability_yes_no',
                                                        g_product_stability_2 = '$f_product_stability_input',
                                
                                                        g_product_quality_1 = '$f_product_quality_yes_no',
                                                        g_product_quality_2 = '$f_product_quality_input',
                                
                                                        g_product_supply_1 = '$f_product_supply_yes_no',
                                                        g_product_supply_2 = '$f_product_supply_input',
                                
                                                        g_efficacy_1 = '$f_efficacy_yes_no',
                                                        g_efficacy_2 = '$f_efficacy_yes_input',
                                
                                                        g_equipment_impact_1 = '$f_equipment_impact_yes_no',
                                                        g_equipment_impact_2 = '$f_equipment_impact_input',
                                
                                                        g_name_of_product_impact_1 = '$f_name_of_product_impact_yes_no',
                                                        g_name_of_product_impact_2 = '$f_name_of_product_impact_input',
                                
                                                        g_change_in_sop_1 = '$f_change_in_sop_yes_no',
                                                        g_change_in_sop_2 = '$f_change_in_sop_input',
                                
                                                        g_validation_1 = '$f_validation_yes_no',
                                                       	g_validation_2 = '$f_validation_input',
                                
                                                        g_qualification_1 = '$f_qualification_yes_no',
                                                        g_qualification_2 = '$f_qualification_input',
                                
                                                        g_calibration_1 = '$f_calibration_yes_no',
                                                        g_calibration_2 = '$f_calibration_input',
                                
                                                        g_marketing_impact_1 = '$f_marketing_impact_yes_no',
                                                        g_marketing_impact_2 = '$f_marketing_impact_input',
                                
                                                        g_registration_1 = '$f_registration_yes_no',
                                                        g_registration_2 = '$f_registration_input',
                                
                                                        g_training_required_1 = '$f_training_required_yes_no',
                                                        g_training_required_2 = '$f_training_required_input',
                                
                                                        g_regulatory_requirement_1 = '$f_regulatory_requirement_yes_no',
                                                        g_regulatory_requirement_2 = '$f_regulatory_requirement_input',
                                
                                                        g_any_other_1 = '$f_any_other_yes_no',
                                                        g_any_other_2 = '$f_any_other_input',
                                
                                
                                
                                
                                
                                                        -- form 9
                                
                                
                                
                                                          h_bills_of_materials_1 = '$f_bills_of_material_yes_no',
                                                        h_bills_of_materials_2 = '$f_bills_of_material_input1',
                                                        h_bills_of_materials_3 = '$f_bills_of_material_input2',
                                
                                                        h_calibration_documents_1 = '$f_calibration_document_yes_no',
                                                        h_calibration_documents_2 = '$f_calibration_document_input1',
                                                        h_calibration_documents_3 = '$f_calibration_document_input2',
                                
                                                        h_contracts_1 = '$f_contracts_yes_no',
                                                        h_contracts_2 = '$f_contracts_input1',
                                                        h_contracts_3 = '$f_contracts_input2',
                                
                                                        h_master_batch_records_1 = '$f_master_batch_yes_no',
                                                        h_master_batch_records_2 = '$f_master_batch_input1',
                                                        h_master_batch_records_3 = '$f_master_batch_input2',
                                
                                                        h_material_characterization_1 = '$f_material_characterization_yes_no',
                                                        h_material_characterization_2 = '$f_material_characterization_input1',
                                                        h_material_characterization_3 = '$f_material_characterization_input2',
                                
                                
                                
                                
                                                        h_master_imprinted_packaging_material_1 = '$f_master_imprinted_yes_no',
                                                        h_master_imprinted_packaging_material_2 = '$f_master_imprinted_input1',
                                                        h_master_imprinted_packaging_material_3 = '$f_master_imprinted_input2',
                                
                                                        h_master_packaging_records_1 = '$f_master_packaging_yes_no',
                                                        h_master_packaging_records_2 = '$f_master_packaging_input1',
                                                        h_master_packaging_records_3 = '$f_master_packaging_input2',
                                
                                                        h_stability_report_1 = '$f_stability_report_yes_no',
                                                        h_stability_report_2 = '$f_stability_report_input1',
                                                        h_stability_report_3 = '$f_stability_report_input2',
                                
                                                        h_standard_operating_procedure_1 = '$f_standard_operating_yes_no',
                                                        h_standard_operating_procedure_2 = '$f_standard_operating_input1',
                                                        h_standard_operating_procedure_3 = '$f_standard_operating_input2',
                                
                                                        h_testing_monograph_1 = '$f_testing_monograph_yes_no',
                                                        h_testing_monograph_2 = '$f_testing_monograph_input1',
                                                        h_testing_monograph_3 = '$f_testing_monograph_input2',
                                
                                
                                
                                                        h_training_document_1 = '$f_training_document_yes_no',
                                                        h_training_document_2 = '$f_training_document_input1',
                                                        h_training_document_3 = '$f_training_document_input2',
                                
                                                        h_plant_drawings_1 = '$f_plant_drawing_yes_no',
                                                        h_plant_drawings_2 = '$f_plant_drawing_input1',
                                                        h_plant_drawings_3 = '$f_plant_drawing_input2',
                                
                                                        h_qualification_protocols_1 = '$f_qualification_protocol_yes_no',
                                                        h_qualification_protocols_2 = '$f_qualification_protocol_input1',
                                                        h_qualification_protocols_3 = '$f_qualification_protocol_input2',
                                
                                                        h_qualification_reports_1 = '$f_qualification_report_yes_no',
                                                        h_qualification_reports_2 = '$f_qualification_report_input1',
                                                        h_qualification_reports_3 = '$f_qualification_report_input2',
                                
                                                        h_registration_dossiers_1 = '$f_registration_dossier_yes_no',
                                                        h_registration_dossiers_2 = '$f_registration_dossier_input1',
                                                        h_registration_dossiers_3 = '$f_registration_dossier_input2',
                                
                                
                                
                                
                                                        h_validation_protocols_1 = '$f_validation_protocol_yes_no',
                                                        h_validation_protocols_2 = '$f_validation_protocol_input1',
                                                        h_validation_protocols_3 = '$f_validation_protocol_input2',
                                
                                                        h_validation_reports_1 = '$f_validation_report_yes_no',
                                                        h_validation_reports_2 = '$f_validation_report_input1',
                                                        h_validation_reports_3 = '$f_validation_report_input2',
                                
                                                        h_others_1 = '$f_other_yes_no',
                                                        h_others_2 = '$f_other_yes_input1',
                                                        h_others_3 = '$f_other_yes_input2',
                                
                                                        -- form 10
                                                        i_1 = '$f_i_1',
                                                        i_2 = '$f_i_2',
                                                        i_3 = '$f_i_3',
                                                        i_4 = '$f_i_4',
                                                        i_5 = '$f_i_5',
                                                        i_6 = '$f_i_6',
                                                        i_7 = '$f_i_7',
                                                        i_8 = '$f_i_8',
                                                        i_9 = '$f_i_9',
                                                        i_10 = '$f_i_10'
                                
                                                       
                                
                                                      
                                
                                
                                                        WHERE fk_id = '$id'";
                                
                                   // Execute update query for qc_ccrf2
                                $result = mysqli_query($conn, $update_query);
                                
                                if ($result) {
                                // Now update the qc_ccrf table
                                $update_ccrf_query = "UPDATE qc_ccrf SET part_2 = 'Approved' WHERE id = '$id'";
                                
                                // Execute the update query for qc_ccrf
                                $result_ccrf = mysqli_query($conn, $update_ccrf_query);
                                
                                if ($result_ccrf) {
                                // Both updates successful
                                echo "<script>alert('Record updated successfully!');
                                window.location.href = window.location.href;</script>";
                                } else {
                                // qc_ccrf update failed
                                echo "<script>alert('Error updating qc_ccrf table!');
                                window.location.href = window.location.href;</script>";
                                }
                                } else {
                                // qc_ccrf2 update failed
                                echo "<script>alert('Update failed for qc_ccrf2!');
                                window.location.href = window.location.href;</script>";
                                }
                                }
                                ?>
                        </div>
                    </div>
                </div>
                <?php
                    }
                    }
                    else{
                    echo "No record found!";
                    }
                    ?>
            </div>
        </div>



            <!-- d end -->
        </div>
        </div>
        </div>
        <!-- work end -->
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