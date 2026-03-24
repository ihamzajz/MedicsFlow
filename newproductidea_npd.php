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
        <title>New Product Idea Detail</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <!-- Bootstrap CSS CDN -->
        <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous"> -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!--Font -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="assets/css/style.css">
        <style>
           .btn{
                border-radius:0px;
            }
            .btn-submit {
            font-size: 14.4px !important; 
            color: white;
            background-color: #0D9276;
            padding: 5px 35px;
            border-radius: 2px;
            border: 2px solid #0D9276;
            letter-spacing: 1.35px; 
            font-weight: 500;
            }
            .btn-submit:hover {
            font-size: 14.4px !important; 
            color: white;
            background-color: #0D9276;
            padding: 5px 35px;
            border-radius: 2px;
            border: 2px solid #0D9276;
            letter-spacing: 1.35px; 
            font-weight: 500;
            }
            tr{
            border:none!important;
            padding:0px!important;
            margin:0px!important;
            }
            th{
            font-size: 10.5px!important;
            background-color: #D9EAFD!important;
            color:black!important;
            border:none!important
            }
            td{
                border:1px solid black!important;
            padding:5px!important;
            margin:0px!important;
            font-size: 11px!important;
            }
            p{
            padding:0px!important;
            margin:0px!important; 
            }
            .th_secondary{
            font-size: 11px!important; 
            color:white!important; 
            background-color: #3D3D3D!important; 
            text-transform:capitalize!important; 
            }
            .textp {
            font-size: 12px !important;
            }
            body {
            font-family: 'Poppins', sans-serif;
            }
            .btn{
            font-size: 11px;
            border-radius:0px;
            }
            p{
            font-size: 12.5px!important;
            padding: 0px!important;
            margin: 0px!important;
            font-weight: 500;
            }
            input,textarea {
            width: 100% !important;
            font-size: 11px!important; 
            border-radius: 0px;
           
            transition: border-color 0.3s ease;
            padding: 2.5px 5px;
            letter-spacing: 0.4px; 
            height:25px!important;
            border:none!important;
            }
            input:focus {
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
            }
            ::placeholder {
            color: black; 
            }
            textarea {
            font-size: 14px; 
            }
            .form-table{
                input{
                    border:0.5px solid black!important;
                }
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
            margin-left: -250px;
            }
            #sidebar.active {
            margin-left: 0;
            }
            #sidebar .sidebar-header {
            padding: 20px;
            background: #0d9276!important;
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
            padding-bottom:4px!important;
            font-size: 10.6px !important;
            display: block;
            color: white!important;
            position: relative;
            }
            #sidebar ul li a:hover {
            text-decoration: none;
            }
            #sidebar ul li.active>a,
            a[aria-expanded="true"] {
            color: cyan!important;
            background: #1c9be7!important;
            }
            #sidebar a {
            position: relative;
            padding-right: 40px; 
            }
            .toggle-icon {
            font-size: 12px;
            color: #fff;
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            transition: transform 0.3s;
            }
            .collapse.show + a .toggle-icon {
            transform: translateY(-50%) rotate(45deg); 
            }
            .collapse:not(.show) + a .toggle-icon {
            transform: translateY(-50%) rotate(0deg); 
            }
            ul ul a {
            font-size: 11px!important;
            padding-left: 15px !important;
            background: #263144!important;
            color: #fff!important;
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
            color: #0d9276!important;
            }
            a.article,
            a.article:hover {
            background: #0d9276!important;
            color: #fff!important;
            }
            #content {
            width: 100%;
            padding: 0px;
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
            .form-table {
            display: flex;
            flex-direction: column;
            gap: 20px;
            }
            .form-row {
            display: flex;
            align-items: center;
            gap: 10px;
            }
            .form-row label {
            min-width: 200px;
            text-align: right;
            font-weight: 400;
            }
            .form-row input {
            flex: 1;
            padding: 5px 10px;
            }
            .p-tag{
            font-size: 15.5px!important;
            padding: 0px!important;
            margin: 0px!important;
            font-weight: 500;
            }
            .cbox{
                height: 13px!important;
                width: 13px!important;
            }
            .table-swat td input {
  border-bottom: 0.3px solid black !important;
}

        </style>
    </head>
    <body>
        <?php
            include 'dbconfig.php';
            ?>
        <div class="wrapper d-flex align-items-stretch">
            <?php
                include 'sidebar1.php';
                ?>
            <!-- Page Content  -->
            <div id="content">
                <!-- navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-success">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                        </button>
                    </div>
                </nav>
                <?php
                    include 'dbconfig.php';
                    
                    
                    $id=$_GET['id'];
                    $select = "SELECT * FROM newproductidea_npd WHERE
                    fk_id = '$id' ";
                    
                    $select_q = mysqli_query($conn,$select);
                    $data = mysqli_num_rows($select_q);
                    ?>
                <?php 
                    if($data){
                    	while ($row=mysqli_fetch_array($select_q)) {
                    		?>
                <div class="container">
                    <form class="form pb-3" method="POST" style="border: 1px solid black; padding: 25px; padding-bottom: 0px; border-radius: 2px;background-color:white!important" >
                        <div class="d-flex align-items-center justify-content-between pb-3" style="position: relative;">
                            <div>
                                <a class="btn btn-dark btn-sm me-2" href="newproductidea_home.php" style="font-size:11px!important;">
                                <i class="fa-solid fa-arrow-left"></i> Home
                                </a>
                                <a class="btn btn-dark btn-sm" href="newproductidea_rnd_list.php" style="font-size:11px!important;">
                                <i class="fa-solid fa-arrow-left"></i> Back
                                </a>
                            </div>
                            <h5 class="position-absolute top-50 start-50 translate-middle" style="font-weight: bolder;padding-bottom:20px!important">
                                New Product Idea Form - NPD SHEET
                            </h5>
                        </div>
                        <div class="form-table mb-5">
                            <div class="form-row">
                                <label>Proposed Product:</label>
                                <input type="text" readonly value="<?php echo $row['proposed_product']; ?>">
                            </div>
                            <div class="form-row">
                                <label>Reference Product:</label>
                                <input type="text" readonly value="<?php echo $row['reference_product']; ?>">
                            </div>
                            <div class="form-row">
                                <label>Active Ingredients:</label>
                                <input type="text" readonly value="<?php echo $row['active_ingredients']; ?>">
                            </div>
                            <div class="form-row">
                                <label>Product Form:</label>
                                <input type="text" readonly value="<?php echo $row['product_form']; ?>">
                            </div>
                            <div class="form-row">
                                <label>Product Packaging:</label>
                                <input type="text" readonly value="<?php echo $row['product_packaging']; ?>">
                            </div>
                            <div class="form-row">
                                <label>Required From RND:</label>
                                <input type="text" readonly value="<?php echo $row['required_from_rnd']; ?>">
                            </div>
                        </div>


                        <p class="p-tag">Composition</p>
                        <table class="table table-bordered">
                            <thead>
                                <th style="width:12%!important">Sr. #</th>
                                <th>API</th>
                                <th style="width:25%!important">Quantity per 5ML</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" value="1" readonly></td>
                                    <td><input type="text" name="api_name_1" id="api_name_1"></td>
                                    <td><input type="text" name="api_qty_1" id="api_qty_1"></td>
                                </tr>
                                <tr>
                                <td><input type="text" value="2" readonly></td>
                                    <td><input type="text" name="api_name_2" id="api_name_2"></td>
                                    <td><input type="text" name="api_qty_2" id="api_qty_2"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="3" readonly></td>
                                    <td><input type="text" name="api_name_3" id="api_name_3"></td>
                                    <td><input type="text" name="api_qty_3" id="api_qty_3"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="4" readonly></td>
                                    <td><input type="text" name="api_name_4" id="api_name_4"></td>
                                    <td><input type="text" name="api_qty_4" id="api_qty_4"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="5" readonly></td>
                                    <td><input type="text" name="api_name_5" id="api_name_5"></td>
                                    <td><input type="text" name="api_qty_5" id="api_qty_5"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="6" readonly></td>
                                    <td><input type="text" name="api_name_6" id="api_name_6"></td>
                                    <td><input type="text" name="api_qty_6" id="api_qty_6"></td>
                                </tr>
                            </tbody>
                        </table>


                        <p class="p-tag">Market Data (IMS Q4/24)</p>
                        <thead></thead>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td style="width:30%!important">Market size (Stimulant Laxatives)</td>
                                    <td><input type="text" name="market_size_no" id="market_size_no"></td>
                                </tr>
                                <tr>
                                    <td style="width:30%!important">Market Growth</td>
                                    <td><input type="text" name="market_growth_no" id="market_growth_no"></td>
                                </tr>
                                <tr>
                                    <td style="width:30%!important">Units</td>
                                    <td><input type="text" name="market_units_no" id="market_units_no"></td>
                                </tr>
                            </tbody>
                        </table>



                        <p >Target Customer</p>
                        <input type="text" name="target_customers" id="target_customers" style="border:1px solid black!important">


                        <p class="p-tag">Demographic Data</p>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td style="width:30%!important">Total Population</td>
                                    <td> <input type="text" name="demographic_data_qty_1" id="demographic_data_qty_1" ></td>
                                </tr>
                                <tr>
                                    <td style="width:30%!important">Urban population @ 35%</td>
                                    <td> <input type="text" name="demographic_data_qty_2" id="demographic_data_qty_2"></td>
                                </tr>
                                <tr>
                                    <td style="width:30%!important">Rural population @ 65%</td>
                                    <td> <input type="text" name="demographic_data_qty_3" id="demographic_data_qty_3"></td>
                                </tr>
                            </tbody>
                        </table>


                        <p class="p-tag">Competitor's Data</p>
                        <table class="table table-bordered">
                            <thead>
                                <th style="width:12%!important">Sr. #</th>
                                <th>Top Brand</th>
                                <th>Pack Size</th>
                                <th>Units</th>
                                <th>MRP</th>
                                <th>Daily Dose</th>
                                <th>Cost / Dose</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="width:12%!important"><input type="text" value="1" readonly ></td>
                                    <td><input type="text" name="top_brand_1" id="top_brand_1"></td>
                                    <td><input type="text" name="pack_size_1" id="pack_size_1"></td>
                                    <td><input type="text" name="units_1" id="units_1"></td>
                                    <td><input type="text" name="mrp_1" id="mrp_1"></td>
                                    <td><input type="text" name="daily_dose_1" id="daily_dose_1"></td>
                                    <td><input type="text" name="cost_dose_1" id="cost_dose_1"></td>
                                </tr>
                                <tr>
                                <td><input type="text" value="2" readonly ></td>
                                    <td><input type="text" name="top_brand_2" id="top_brand_2"></td>
                                    <td><input type="text" name="pack_size_2" id="pack_size_2"></td>
                                    <td><input type="text" name="units_2" id="units_2"></td>
                                    <td><input type="text" name="mrp_2" id="mrp_2"></td>
                                    <td><input type="text" name="daily_dose_2" id="daily_dose_2"></td>
                                    <td><input type="text" name="cost_dose_2" id="cost_dose_2"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="3" readonly ></td>
                                    <td><input type="text" name="top_brand_3" id="top_brand_3"></td>
                                    <td><input type="text" name="pack_size_3" id="pack_size_3"></td>
                                    <td><input type="text" name="units_3" id="units_3"></td>
                                    <td><input type="text" name="mrp_3" id="mrp_3"></td>
                                    <td><input type="text" name="daily_dose_3" id="daily_dose_3"></td>
                                    <td><input type="text" name="cost_dose_3" id="cost_dose_3"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="4" readonly ></td>
                                    <td><input type="text" name="top_brand_4" id="top_brand_4"></td>
                                    <td><input type="text" name="pack_size_4" id="pack_size_4"></td>
                                    <td><input type="text" name="units_4" id="units_4"></td>
                                    <td><input type="text" name="mrp_4" id="mrp_4"></td>
                                    <td><input type="text" name="daily_dose_4" id="daily_dose_4"></td>
                                    <td><input type="text" name="cost_dose_4" id="cost_dose_4"></td>
                                </tr>
                                <tr>
                                <td><input type="text" value="5" readonly ></td>
                                    <td><input type="text" name="top_brand_5" id="top_brand_5"></td>
                                    <td><input type="text" name="pack_size_5" id="pack_size_5"></td>
                                    <td><input type="text" name="units_5" id="units_5"></td>
                                    <td><input type="text" name="mrp_5" id="mrp_5"></td>
                                    <td><input type="text" name="daily_dose_5" id="daily_dose_5"></td>
                                    <td><input type="text" name="cost_dose_5" id="cost_dose_5"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="6" readonly ></td>
                                    <td><input type="text" name="top_brand_6" id="top_brand_6"></td>
                                    <td><input type="text" name="pack_size_6" id="pack_size_6"></td>
                                    <td><input type="text" name="units_6" id="units_6"></td>
                                    <td><input type="text" name="mrp_6" id="mrp_6"></td>
                                    <td><input type="text" name="daily_dose_6" id="daily_dose_6"></td>
                                    <td><input type="text" name="cost_dose_6" id="cost_dose_6"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="7" readonly ></td>
                                    <td><input type="text" name="top_brand_7" id="top_brand_7"></td>
                                    <td><input type="text" name="pack_size_7" id="pack_size_7"></td>
                                    <td><input type="text" name="units_7" id="units_7"></td>
                                    <td><input type="text" name="mrp_7" id="mrp_7"></td>
                                    <td><input type="text" name="daily_dose_7" id="daily_dose_7"></td>
                                    <td><input type="text" name="cost_dose_7" id="cost_dose_7"></td>
                                </tr>
                            </tbody>
                        </table>



                        <p class="p-tag">Rationale</p>
                        <p>Synergies with Medics current business model & portfolio / Target group</p>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Business Model</td>
                                    <td>
                                        <label><input type="checkbox" class="type-checkbox cbox" name="rationale_1" id="rationale_1" value="Trade Promotion"> Trade Promotion &nbsp;</label>
                                        <label><input type="checkbox" class="type-checkbox cbox" name="rationale_1" id="rationale_1" value="Digital Marketing"> Digital Marketing  </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Target Group</td>
                                    <td>
                                        <label><input type="checkbox" class="type-checkbox cbox" name="rationale_2" id="rationale_2" value="Child"> Child</label>
                                        <label><input type="checkbox" class="type-checkbox cbox" name="rationale_2" id="rationale_2" value="Female"> Female</label>
                                        <label><input type="checkbox" class="type-checkbox cbox" name="rationale_2" id="rationale_2" value="General"> General</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Current Portfolio</td>
                                    <td>
                                        <label><input type="checkbox" class="type-checkbox cbox" name="rationale_3" id="rationale_3" value="Digestive care "> Digestive care </label>
                                        <label><input type="checkbox" class="type-checkbox cbox" name="rationale_3" id="rationale_3" value="Female"> Female care </label>
                                        <label><input type="checkbox" class="type-checkbox cbox" name="rationale_3" id="rationale_3" value="Analgesic"> Analgesic</label>
                                        <label><input type="checkbox" class="type-checkbox cbox" name="rationale_3" id="rationale_3" value="Cough & Cold"> Cough & Cold</label>
                                        <label><input type="checkbox" class="type-checkbox cbox" name="rationale_3" id="rationale_3" value="Hepatic care"> Hepatic care</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Current No. of Customers</td>
                                    <td><input type="text" name="rationale_4" id="rationale_4"></td>
                                </tr>
                            </tbody>
                        </table>


                        <p class="p-tag">SWAT Analysis</p>
                        <table class="table table-bordered table-swat">
                            <tbody>
                                <tr>
                                    <td>
                                        <p>Strength</p><br>
                                        <input type="text" name="strength_1" id="strength_1"><br>
                                        <input type="text" name="strength_2" id="strength_2"><br>
                                        <input type="text" name="strength_3" id="strength_3"><br>
                                        <input type="text" name="strength_4" id="strength_4"><br>
                                    </td>
                                    <td>
                                        <p>Weakness</p><br>
                                        <input type="text" name="weakness_1" id="weakness_1"><br>
                                        <input type="text" name="weakness_2" id="weakness_2"><br>
                                        <input type="text" name="weakness_3" id="weakness_3"><br>
                                        <input type="text" name="weakness_4" id="weakness_4"><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Opportunity</p><br>
                                        <input type="text" name="opportunity_1" id="opportunity_1"><br>
                                        <input type="text" name="opportunity_2" id="opportunity_2"><br>
                                        <input type="text" name="opportunity_3" id="opportunity_3"><br>
                                        <input type="text" name="opportunity_4" id="opportunity_4"><br>
                                    </td>
                                    <td>
                                        <p>Threats</p><br>
                                        <input type="text" name="threats_1" id="threats_1"><br>
                                        <input type="text" name="threats_2" id="threats_2"><br>
                                        <input type="text" name="threats_3" id="threats_3"><br>
                                        <input type="text" name="threats_4" id="threats_4"><br>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                        <p class="p-tag">Capex</p>
                        <table class="table table-bordered">
                            <thead>
                                <th>Department</th>
                                <th>Task</th>
                                <th>Amount Required</th>
                                <th>Timeline</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" name="capex_department_1" id="capex_department_1"></td>
                                    <td><input type="text" name="capex_task_1" id="capex_task_1"></td>
                                    <td><input type="text" name="capex_amt_req_1" id="capex_amt_req_1"></td>
                                    <td><input type="text" name="capex_timelime_1" id="capex_timelime_1"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="capex_department_2" id="capex_department_2"></td>
                                    <td><input type="text" name="capex_task_2" id="capex_task_2"></td>
                                    <td><input type="text" name="capex_amt_req_2" id="capex_amt_req_2"></td>
                                    <td><input type="text" name="capex_timelime_2" id="capex_timelime_2"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="capex_department_3" id="capex_department_3"></td>
                                    <td><input type="text" name="capex_task_3" id="capex_task_3"></td>
                                    <td><input type="text" name="capex_amt_req_3" id="capex_amt_req_3"></td>
                                    <td><input type="text" name="capex_timelime_3" id="capex_timelime_3"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="capex_department_4" id="capex_department_4"></td>
                                    <td><input type="text" name="capex_task_4" id="capex_task_4"></td>
                                    <td><input type="text" name="capex_amt_req_4" id="capex_amt_req_4"></td>
                                    <td><input type="text" name="capex_timelime_4" id="capex_timelime_4"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="capex_department_5" id="capex_department_5"></td>
                                    <td><input type="text" name="capex_task_5" id="capex_task_5"></td>
                                    <td><input type="text" name="capex_amt_req_5" id="capex_amt_req_5"></td>
                                    <td><input type="text" name="capex_timelime_5" id="capex_timelime_5"></td>
                                </tr>
                            </tbody>
                        </table>

                        <p class="p-tag">Rolling Forecast Tab: (Suppose TP Rs.340)</p>
                        <table class="table table-bordered">
                            <thead>
                                <th>Year</th>
                                <th>Target Customers</th>
                                <th>Launch Quantity</th>
                                <th>Quarterly forecast</th>
                                <th>Annual Forecast</th>
                                <th>TP Value</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1st</td>
                                    <td><input type="text" name="rft_target_customers_1" id="rft_target_customers_1"></td>
                                    <td><input type="text" name="lft_launch_qty_1" id="lft_launch_qty_1"></td>
                                    <td><input type="text" name="lft_quarterly_forecast_1" id="lft_quarterly_forecast_1"></td>
                                    <td><input type="text" name="lft_annual_forecast_1" id="lft_annual_forecast_1"></td>
                                    <td><input type="text" name="rft_tb_value_1" id="rft_tb_value_1"></td>
                                </tr>
                                <tr>
                                    <td>2nd</td>
                                    <td><input type="text" name="rft_target_customers_2" id="rft_target_customers_2"></td>
                                    <td><input type="text" name="lft_launch_qty_2" id="lft_launch_qty_2"></td>
                                    <td><input type="text" name="lft_quarterly_forecast_2" id="lft_quarterly_forecast_2"></td>
                                    <td><input type="text" name="lft_annual_forecast_2" id="lft_annual_forecast_2"></td>
                                    <td><input type="text" name="rft_tb_value_2" id="rft_tb_value_2"></td>
                                </tr>
                                <tr>
                                    <td>3rd</td>
                                    <td><input type="text" name="rft_target_customers_3" id="rft_target_customers_3"></td>
                                    <td><input type="text" name="lft_launch_qty_3" id="lft_launch_qty_3"></td>
                                    <td><input type="text" name="lft_quarterly_forecast_3" id="lft_quarterly_forecast_3"></td>
                                    <td><input type="text" name="lft_annual_forecast_3" id="lft_annual_forecast_3"></td>
                                    <td><input type="text" name="rft_tb_value_3" id="rft_tb_value_3"></td>
                                </tr>
                                <tr>
                                    <td>4th</td>
                                    <td><input type="text" name="rft_target_customers_4" id="rft_target_customers_4"></td>
                                    <td><input type="text" name="lft_launch_qty_4" id="lft_launch_qty_4"></td>
                                    <td><input type="text" name="lft_quarterly_forecast_4" id="lft_quarterly_forecast_4"></td>
                                    <td><input type="text" name="lft_annual_forecast_4" id="lft_annual_forecast_4"></td>
                                    <td><input type="text" name="rft_tb_value_4" id="rft_tb_value_4"></td>
                                </tr>
                                <tr>
                                    <td>5th</td>
                                    <td><input type="text" name="rft_target_customers_5" id="rft_target_customers_5"></td>
                                    <td><input type="text" name="lft_launch_qty_5" id="lft_launch_qty_5"></td>
                                    <td><input type="text" name="lft_quarterly_forecast_5" id="lft_quarterly_forecast_5"></td>
                                    <td><input type="text" name="lft_annual_forecast_5" id="lft_annual_forecast_5"></td>
                                    <td><input type="text" name="rft_tb_value_5" id="rft_tb_value_5"></td>
                                </tr>
                            </tbody>
                        </table>
                        

                        <p class="p-tag">Rolling Forecast Syrup: (Suppose TP)</p>
                        <table class="table table-bordered">
                            <thead>
                                <th>Year</th>
                                <th>Target Customers</th>
                                <th>Launch Quantity</th>
                                <th>Quarterly forecast</th>
                                <th>Annual Forecast</th>
                                <th>TP Value</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1st</td>
                                    <td><input type="text" name="rfs_target_customers_1" id="rfs_target_customers_1"></td>
                                    <td><input type="text" name="rfs_lauch_qty_1" id="rfs_lauch_qty_1"></td>
                                    <td><input type="text" name="rfs_quarterly_forecast_1" id="rfs_quarterly_forecast_1"></td>
                                    <td><input type="text" name="rfs_target_customers_1" id="rfs_annual_forecast_1"></td>
                                    <td><input type="text" name="rfs_tp_value_1" id="rfs_tp_value_1"></td>
                                </tr>
                                <tr>
                                    <td>2nd</td>
                                    <td><input type="text" name="rfs_target_customers_2" id="rfs_target_customers_2"></td>
                                    <td><input type="text" name="rfs_lauch_qty_2" id="rfs_lauch_qty_2"></td>
                                    <td><input type="text" name="rfs_quarterly_forecast_2" id="rfs_quarterly_forecast_2"></td>
                                    <td><input type="text" name="rfs_target_customers_2" id="rfs_annual_forecast_2"></td>
                                    <td><input type="text" name="rfs_tp_value_2" id="rfs_tp_value_2"></td>
                                </tr>
                                <tr>
                                    <td>3rd</td>
                                    <td><input type="text" name="rfs_target_customers_3" id="rfs_target_customers_3"></td>
                                    <td><input type="text" name="rfs_lauch_qty_3" id="rfs_lauch_qty_3"></td>
                                    <td><input type="text" name="rfs_quarterly_forecast_3" id="rfs_quarterly_forecast_3"></td>
                                    <td><input type="text" name="rfs_target_customers_3" id="rfs_annual_forecast_3"></td>
                                    <td><input type="text" name="rfs_tp_value_3" id="rfs_tp_value_3"></td>
                                </tr>
                                <tr>
                                    <td>4th</td>
                                    <td><input type="text" name="rfs_target_customers_4" id="rfs_target_customers_4"></td>
                                    <td><input type="text" name="rfs_lauch_qty_4" id="rfs_lauch_qty_4"></td>
                                    <td><input type="text" name="rfs_quarterly_forecast_4" id="rfs_quarterly_forecast_4"></td>
                                    <td><input type="text" name="rfs_target_customers_4" id="rfs_annual_forecast_4"></td>
                                    <td><input type="text" name="rfs_tp_value_4" id="rfs_tp_value_4"></td>
                                </tr>
                                <tr>
                                    <td>5th</td>
                                    <td><input type="text" name="rfs_target_customers_5" id="rfs_target_customers_5"></td>
                                    <td><input type="text" name="rfs_lauch_qty_5" id="rfs_lauch_qty_5"></td>
                                    <td><input type="text" name="rfs_quarterly_forecast_5" id="rfs_quarterly_forecast_5"></td>
                                    <td><input type="text" name="rfs_target_customers_5" id="rfs_annual_forecast_5"></td>
                                    <td><input type="text" name="rfs_tp_value_5" id="rfs_tp_value_5"></td>
                                </tr>
                            </tbody>
                        </table>


                        <p class="p-tag">Financial Data:</p>
                        <table class="table table-bordered">
                            <thead>
                                <th>-</th>
                                <th colspan="2">-</th>
                                <th colspan="2">-</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Proposed MRP incl GST</td>
                                    <td><input type="text" name="proposed_mrp_incl_gst" id="proposed_mrp_incl_gst"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Proposed MRP excl GST</td>
                                    <td><input type="text" name="proposed_mrp_excl_gst" id="proposed_mrp_excl_gst"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Trade Price</td>
                                    <td><input type="text" name="trade_price" id="trade_price"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Net Selling Price</td>
                                    <td><input type="text" name="net_selling_price" id="net_selling_price"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Less: Product Cost</td>
                                    <td><input type="text" name="less_product_cost" id="less_product_cost"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>GP Value</td>
                                    <td><input type="text" name="gp_value" id="gp_value"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>GP %</td>
                                    <td><input type="text" name="gp_percentage" id="gp_percentage"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>-</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Cost / Dose</td>
                                    <td><input type="text" name="cost_dose" id="cost_dose"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
       
                            </tbody>
                        </table>
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-submit" name="submit" style="font-size: 20px">Submit</button>
                        </div>
                    </form>
                </div>
                <?php
                    include 'dbconfig.php';
                    
                    // Check if form is submitted
                    if (isset($_POST['submit'])) {
                        // Retrieve form data
                        $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                        $name =  $_SESSION['fullname'];
                    
                        $proposed_product = isset($_POST['proposed_product']) && $_POST['proposed_product'] !== $row['proposed_product'] ? $_POST['proposed_product'] : $row['proposed_product'];
                        $reference_product = isset($_POST['reference_product']) && $_POST['reference_product'] !== $row['reference_product'] ? $_POST['reference_product'] : $row['reference_product'];
                        $active_ingredients = isset($_POST['active_ingredients']) && $_POST['active_ingredients'] !== $row['active_ingredients'] ? $_POST['active_ingredients'] : $row['active_ingredients'];
                        $product_form = isset($_POST['product_form']) && $_POST['product_form'] !== $row['product_form'] ? $_POST['product_form'] : $row['product_form'];
                        $product_packaging = isset($_POST['product_packaging']) && $_POST['product_packaging'] !== $row['product_packaging'] ? $_POST['product_packaging'] : $row['product_packaging'];
                        $required_from_rnd = isset($_POST['required_from_rnd']) && $_POST['required_from_rnd'] !== $row['required_from_rnd'] ? $_POST['required_from_rnd'] : $row['required_from_rnd'];

                        $api_name_1 = isset($_POST['api_name_1']) && $_POST['api_name_1'] !== $row['api_name_1'] ? $_POST['api_name_1'] : $row['api_name_1'];
                        $api_name_2 = isset($_POST['api_name_2']) && $_POST['api_name_2'] !== $row['api_name_2'] ? $_POST['api_name_2'] : $row['api_name_2'];
                        $api_name_3 = isset($_POST['api_name_3']) && $_POST['api_name_3'] !== $row['api_name_3'] ? $_POST['api_name_3'] : $row['api_name_3'];
                        $api_name_4 = isset($_POST['api_name_4']) && $_POST['api_name_4'] !== $row['api_name_4'] ? $_POST['api_name_4'] : $row['api_name_4'];
                        $api_name_5 = isset($_POST['api_name_5']) && $_POST['api_name_5'] !== $row['api_name_5'] ? $_POST['api_name_5'] : $row['api_name_5'];
                        $api_name_6 = isset($_POST['api_name_6']) && $_POST['api_name_6'] !== $row['api_name_6'] ? $_POST['api_name_6'] : $row['api_name_6'];

                        $api_qty_1 = isset($_POST['api_qty_1']) && $_POST['api_qty_1'] !== $row['api_qty_1'] ? $_POST['api_qty_1'] : $row['api_qty_1'];
                        $api_qty_2 = isset($_POST['api_qty_2']) && $_POST['api_qty_2'] !== $row['api_qty_2'] ? $_POST['api_qty_2'] : $row['api_qty_2'];
                        $api_qty_3 = isset($_POST['api_qty_3']) && $_POST['api_qty_3'] !== $row['api_qty_3'] ? $_POST['api_qty_3'] : $row['api_qty_3'];
                        $api_qty_4 = isset($_POST['api_qty_4']) && $_POST['api_qty_4'] !== $row['api_qty_4'] ? $_POST['api_qty_4'] : $row['api_qty_4'];
                        $api_qty_5 = isset($_POST['api_qty_5']) && $_POST['api_qty_5'] !== $row['api_qty_5'] ? $_POST['api_qty_5'] : $row['api_qty_5'];
                        $api_qty_6 = isset($_POST['api_qty_6']) && $_POST['api_qty_6'] !== $row['api_qty_6'] ? $_POST['api_qty_6'] : $row['api_qty_6'];

                        $market_size_no = isset($_POST['market_size_no']) && $_POST['market_size_no'] !== $row['market_size_no'] ? $_POST['market_size_no'] : $row['market_size_no'];
                        $market_growth_no = isset($_POST['market_growth_no']) && $_POST['market_growth_no'] !== $row['market_growth_no'] ? $_POST['market_growth_no'] : $row['market_growth_no'];
                        $market_units_no = isset($_POST['market_units_no']) && $_POST['market_units_no'] !== $row['market_units_no'] ? $_POST['market_units_no'] : $row['market_units_no'];

                        $target_customers = isset($_POST['target_customers']) && $_POST['target_customers'] !== $row['target_customers'] ? $_POST['target_customers'] : $row['target_customers'];

                        $demographic_data_qty_1 = isset($_POST['demographic_data_qty_1']) && $_POST['demographic_data_qty_1'] !== $row['demographic_data_qty_1'] ? $_POST['demographic_data_qty_1'] : $row['demographic_data_qty_1'];
                        $demographic_data_qty_2 = isset($_POST['demographic_data_qty_2']) && $_POST['demographic_data_qty_2'] !== $row['demographic_data_qty_2'] ? $_POST['demographic_data_qty_2'] : $row['demographic_data_qty_2'];
                        $demographic_data_qty_3 = isset($_POST['demographic_data_qty_3']) && $_POST['demographic_data_qty_3'] !== $row['demographic_data_qty_3'] ? $_POST['demographic_data_qty_3'] : $row['demographic_data_qty_3'];

                        $top_brand_1 = isset($_POST['top_brand_1']) && $_POST['top_brand_1'] !== $row['top_brand_1'] ? $_POST['top_brand_1'] : $row['top_brand_1'];
                        $top_brand_2 = isset($_POST['top_brand_2']) && $_POST['top_brand_2'] !== $row['top_brand_2'] ? $_POST['top_brand_2'] : $row['top_brand_2'];
                        $top_brand_3 = isset($_POST['top_brand_3']) && $_POST['top_brand_3'] !== $row['top_brand_3'] ? $_POST['top_brand_3'] : $row['top_brand_3'];
                        $top_brand_4 = isset($_POST['top_brand_4']) && $_POST['top_brand_4'] !== $row['top_brand_4'] ? $_POST['top_brand_4'] : $row['top_brand_4'];
                        $top_brand_5 = isset($_POST['top_brand_5']) && $_POST['top_brand_5'] !== $row['top_brand_5'] ? $_POST['top_brand_5'] : $row['top_brand_5'];

                        $pack_size_1 = isset($_POST['pack_size_1']) && $_POST['pack_size_1'] !== $row['pack_size_1'] ? $_POST['pack_size_1'] : $row['pack_size_1'];
                        $pack_size_2 = isset($_POST['pack_size_2']) && $_POST['pack_size_2'] !== $row['pack_size_2'] ? $_POST['pack_size_2'] : $row['pack_size_2'];
                        $pack_size_3 = isset($_POST['pack_size_3']) && $_POST['pack_size_3'] !== $row['pack_size_3'] ? $_POST['pack_size_3'] : $row['pack_size_3'];
                        $pack_size_4 = isset($_POST['pack_size_4']) && $_POST['pack_size_4'] !== $row['pack_size_4'] ? $_POST['pack_size_4'] : $row['pack_size_4'];
                        $pack_size_5 = isset($_POST['pack_size_5']) && $_POST['pack_size_5'] !== $row['pack_size_5'] ? $_POST['pack_size_5'] : $row['pack_size_5'];

                        $units_1 = isset($_POST['units_1']) && $_POST['units_1'] !== $row['units_1'] ? $_POST['units_1'] : $row['units_1'];
                        $units_2 = isset($_POST['units_2']) && $_POST['units_2'] !== $row['units_2'] ? $_POST['units_2'] : $row['units_2'];
                        $units_3 = isset($_POST['units_3']) && $_POST['units_3'] !== $row['units_3'] ? $_POST['units_3'] : $row['units_3'];
                        $units_4 = isset($_POST['units_4']) && $_POST['units_4'] !== $row['units_4'] ? $_POST['units_4'] : $row['units_4'];
                        $units_5 = isset($_POST['units_5']) && $_POST['units_5'] !== $row['units_5'] ? $_POST['units_5'] : $row['units_5'];

                        $mrp_1 = isset($_POST['mrp_1']) && $_POST['mrp_1'] !== $row['mrp_1'] ? $_POST['mrp_1'] : $row['mrp_1'];
                        $mrp_2 = isset($_POST['mrp_2']) && $_POST['mrp_2'] !== $row['mrp_2'] ? $_POST['mrp_2'] : $row['mrp_2'];
                        $mrp_3 = isset($_POST['mrp_3']) && $_POST['mrp_3'] !== $row['mrp_3'] ? $_POST['mrp_3'] : $row['mrp_3'];
                        $mrp_4 = isset($_POST['mrp_4']) && $_POST['mrp_4'] !== $row['mrp_4'] ? $_POST['mrp_4'] : $row['mrp_4'];
                        $mrp_5 = isset($_POST['mrp_5']) && $_POST['mrp_5'] !== $row['mrp_5'] ? $_POST['mrp_5'] : $row['mrp_5'];

                        $daily_dose_1 = isset($_POST['daily_dose_1']) && $_POST['daily_dose_1'] !== $row['daily_dose_1'] ? $_POST['daily_dose_1'] : $row['daily_dose_1'];
                        $daily_dose_2 = isset($_POST['daily_dose_2']) && $_POST['daily_dose_2'] !== $row['daily_dose_2'] ? $_POST['daily_dose_2'] : $row['daily_dose_2'];
                        $daily_dose_3 = isset($_POST['daily_dose_3']) && $_POST['daily_dose_3'] !== $row['daily_dose_3'] ? $_POST['daily_dose_3'] : $row['daily_dose_3'];
                        $daily_dose_4 = isset($_POST['daily_dose_4']) && $_POST['daily_dose_4'] !== $row['daily_dose_4'] ? $_POST['daily_dose_4'] : $row['daily_dose_4'];
                        $daily_dose_5 = isset($_POST['daily_dose_5']) && $_POST['daily_dose_5'] !== $row['daily_dose_5'] ? $_POST['daily_dose_5'] : $row['daily_dose_5'];

                        $cost_dose_1 = isset($_POST['cost_dose_1']) && $_POST['cost_dose_1'] !== $row['cost_dose_1'] ? $_POST['cost_dose_1'] : $row['cost_dose_1'];
                        $cost_dose_2 = isset($_POST['cost_dose_2']) && $_POST['cost_dose_2'] !== $row['cost_dose_2'] ? $_POST['cost_dose_2'] : $row['cost_dose_2'];
                        $cost_dose_3 = isset($_POST['cost_dose_3']) && $_POST['cost_dose_3'] !== $row['cost_dose_3'] ? $_POST['cost_dose_3'] : $row['cost_dose_3'];
                        $cost_dose_4 = isset($_POST['cost_dose_4']) && $_POST['cost_dose_4'] !== $row['cost_dose_4'] ? $_POST['cost_dose_4'] : $row['cost_dose_4'];
                        $cost_dose_5 = isset($_POST['cost_dose_5']) && $_POST['cost_dose_5'] !== $row['cost_dose_5'] ? $_POST['cost_dose_5'] : $row['cost_dose_5'];

                      
                        $update_query = "UPDATE new_product_idea SET 
                    
                                    proposed_product = '$proposed_product',
                                    reference_product = '$reference_product',
                                    active_ingredients = '$active_ingredients',
                                    product_form = '$product_form',
                                    product_packaging = '$product_packaging',
                                    required_from_rnd = '$required_from_rnd',

                                    api_name_1 = '$api_name_1',
                                    api_name_2 = '$api_name_2',
                                    api_name_3 = '$api_name_3',
                                    api_name_4 = '$api_name_4',
                                    api_name_5 = '$api_name_5',
                                    api_name_6 = '$api_name_6',

                                    api_qty_1 = '$api_qty_1',
                                    api_qty_2 = '$api_qty_2',
                                    api_qty_3 = '$api_qty_3',
                                    api_qty_4 = '$api_qty_4',
                                    api_qty_5 = '$api_qty_5',
                                    api_qty_6 = '$api_qty_6',

                                    market_size_no = '$market_size_no',
                                    market_growth_no = '$market_growth_no',
                                    market_units_no = '$market_units_no',

                                    target_customers = '$target_customers',
                                    demographic_data_qty_1 = '$demographic_data_qty_1',
                                    demographic_data_qty_2 = '$demographic_data_qty_2',
                                    demographic_data_qty_3 = '$demographic_data_qty_3',

                                    top_brand_1 = '$top_brand_1',
                                    pack_size_1 = '$pack_size_1',
                                    units_1 = '$units_1',
                                    mrp_1 = '$mrp_1',
                                    daily_dose_1 = '$daily_dose_1',
                                    cost_dose_1 = '$pcost_dose_1',

                                    top_brand_2 = '$top_brand_2',
                                    pack_size_2 = '$pack_size_2',
                                    units_2 = '$units_2',
                                    mrp_2 = '$mrp_2',
                                    daily_dose_2 = '$daily_dose_2',
                                    cost_dose_2 = '$pcost_dose_2',

                                    top_brand_3 = '$top_brand_3',
                                    pack_size_3 = '$pack_size_3',
                                    units_3 = '$units_3',
                                    mrp_3 = '$mrp_3',
                                    daily_dose_3 = '$daily_dose_3',
                                    cost_dose_3 = '$pcost_dose_3',

                                    top_brand_4 = '$top_brand_4',
                                    pack_size_4 = '$pack_size_4',
                                    units_4 = '$units_4',
                                    mrp_4 = '$mrp_4',
                                    daily_dose_4 = '$daily_dose_4',
                                    cost_dose_4 = '$pcost_dose_4',

                                    top_brand_5 = '$top_brand_5',
                                    pack_size_5 = '$pack_size_5',
                                    units_5 = '$units_5',
                                    mrp_5 = '$mrp_5',
                                    daily_dose_5 = '$daily_dose_5',
                                    cost_dose_5 = '$pcost_dose_5',

                                    top_brand_6 = '$top_brand_6',
                                    pack_size_6 = '$pack_size_6',
                                    units_6 = '$units_6',
                                    mrp_6 = '$mrp_6',
                                    daily_dose_6 = '$daily_dose_6',
                                    cost_dose_6 = '$pcost_dose_6',

                                    top_brand_7 = '$top_brand_7',
                                    pack_size_7 = '$pack_size_7',
                                    units_7 = '$units_7',
                                    mrp_7 = '$mrp_7',
                                    daily_dose_7 = '$daily_dose_7',
                                    cost_dose_7 = '$pcost_dose_7',

                                    rationale_1 = '$rationale_1',
                                    rationale_2 = '$rationale_2',
                                    rationale_3 = '$rationale_3',
                                    rationale_4 = '$rationale_4',
                                  
                                    strength_1 = '$strength_1',
                                    strength_2 = '$strength_2',
                                    strength_3 = '$strength_3',
                                    strength_4 = '$strength_4',

                                    weakness_1 = '$weakness_1',
                                    weakness_2 = '$weakness_2',
                                    weakness_3 = '$weakness_3',
                                    weakness_4 = '$weakness_4',

                                    opportunity_1 = '$opportunity_1',
                                    opportunity_2 = '$opportunity_2',
                                    opportunity_3 = '$opportunity_3',
                                    opportunity_4 = '$opportunity_4',

                                    threats_1 = '$threats_1',
                                    threats_2 = '$threats_2',
                                    threats_3 = '$threats_3',
                                    threats_4 = '$threats_4',

                                    capex_department_1 = '$capex_department_1',
                                    capex_task_1 = '$capex_task_1',
                                    capex_amt_req_1 = '$capex_amt_req_1',
                                    capex_timelime_1 = '$capex_timelime_1',

                                    capex_department_2 = '$capex_department_2',
                                    capex_task_2 = '$capex_task_2',
                                    capex_amt_req_2 = '$capex_amt_req_2',
                                    capex_timelime_2 = '$capex_timelime_2',

                                    capex_department_3 = '$capex_department_3',
                                    capex_task_3 = '$capex_task_3',
                                    capex_amt_req_3 = '$capex_amt_req_3',
                                    capex_timelime_3 = '$capex_timelime_3',

                                    capex_department_4 = '$capex_department_4',
                                    capex_task_4 = '$capex_task_4',
                                    capex_amt_req_4 = '$capex_amt_req_4',
                                    capex_timelime_4 = '$capex_timelime_4',

                                    capex_department_5 = '$capex_department_5',
                                    capex_task_5 = '$capex_task_5',
                                    capex_amt_req_5 = '$capex_amt_req_5',
                                    capex_timelime_5 = '$capex_timelime_5',

                                    rft_target_customers_1 = '$rft_target_customers_1',
                                    lft_launch_qty_1 = '$lft_launch_qty_1',
                                    lft_quarterly_forecast_1 = '$lft_quarterly_forecast_1',
                                    lft_annual_forecast_1 = '$lft_annual_forecast_1',
                                    rft_tb_value_1 = '$rft_tb_value_1',

                                    rft_target_customers_2 = '$rft_target_customers_2',
                                    lft_launch_qty_2 = '$lft_launch_qty_2',
                                    lft_quarterly_forecast_2 = '$lft_quarterly_forecast_2',
                                    lft_annual_forecast_2 = '$lft_annual_forecast_2',
                                    rft_tb_value_2 = '$rft_tb_value_2',

                                    rft_target_customers_3 = '$rft_target_customers_3',
                                    lft_launch_qty_3 = '$lft_launch_qty_3',
                                    lft_quarterly_forecast_3 = '$lft_quarterly_forecast_3',
                                    lft_annual_forecast_3 = '$lft_annual_forecast_3',
                                    rft_tb_value_3 = '$rft_tb_value_3',

                                    rft_target_customers_4 = '$rft_target_customers_4',
                                    lft_launch_qty_4 = '$lft_launch_qty_4',
                                    lft_quarterly_forecast_4 = '$lft_quarterly_forecast_4',
                                    lft_annual_forecast_4 = '$lft_annual_forecast_4',
                                    rft_tb_value_4 = '$rft_tb_value_4',

                                    rft_target_customers_5 = '$rft_target_customers_5',
                                    lft_launch_qty_5 = '$lft_launch_qty_5',
                                    lft_quarterly_forecast_5 = '$lft_quarterly_forecast_5',
                                    lft_annual_forecast_5 = '$lft_annual_forecast_5',
                                    rft_tb_value_5 = '$rft_tb_value_5',

                                    rfs_target_customers_1 = '$rfs_target_customers_1',
                                    rfs_lauch_qty_1 = '$rfs_lauch_qty_1',
                                    rfs_quarterly_forecast_1 = '$rfs_quarterly_forecast_1',
                                    rfs_annual_forecast_1 = '$rfs_annual_forecast_1',
                                    rfs_tp_value_1 = '$rfs_tp_value_1',

                                    rfs_target_customers_2 = '$rfs_target_customers_2',
                                    rfs_lauch_qty_2 = '$rfs_lauch_qty_2',
                                    rfs_quarterly_forecast_2 = '$rfs_quarterly_forecast_2',
                                    rfs_annual_forecast_2 = '$rfs_annual_forecast_2',
                                    rfs_tp_value_2 = '$rfs_tp_value_2',

                                    rfs_target_customers_3 = '$rfs_target_customers_3',
                                    rfs_lauch_qty_3 = '$rfs_lauch_qty_3',
                                    rfs_quarterly_forecast_3 = '$rfs_quarterly_forecast_3',
                                    rfs_annual_forecast_3 = '$rfs_annual_forecast_3',
                                    rfs_tp_value_3 = '$rfs_tp_value_3',

                                    rfs_target_customers_4 = '$rfs_target_customers_4',
                                    rfs_lauch_qty_4 = '$rfs_lauch_qty_4',
                                    rfs_quarterly_forecast_4 = '$rfs_quarterly_forecast_4',
                                    rfs_annual_forecast_4 = '$rfs_annual_forecast_4',
                                    rfs_tp_value_4 = '$rfs_tp_value_4',

                                    rfs_target_customers_5 = '$rfs_target_customers_5',
                                    rfs_lauch_qty_5 = '$rfs_lauch_qty_5',
                                    rfs_quarterly_forecast_5 = '$rfs_quarterly_forecast_5',
                                    rfs_annual_forecast_5 = '$rfs_annual_forecast_5',
                                    rfs_tp_value_5 = '$rfs_tp_value_5',

                                    proposed_mrp_incl_gst = '$proposed_mrp_incl_gst',
                                    proposed_mrp_excl_gst = '$proposed_mrp_excl_gst',
                                    trade_price = '$trade_price',
                                    net_selling_price = '$net_selling_price',
                                    less_product_cost = '$less_product_cost',
                                    gp_value = '$gp_value',
                                    gp_percentage = '$gp_percentage',
                                    cost_dose = '$cost_dose'
                
                                    WHERE fk_id = '$id'";
                    
                        // Execute update query
                        $result = mysqli_query($conn, $update_query);
                    
                        if ($result) {
                            // Update successful
                            echo "<script>
                            alert('Data updated successfully.');
                            window.location.href = window.location.href; // Reload the page
                          </script>";
                            // Redirect or perform additional actions as needed
                        } else {
                            // Update failed
                            echo "<script>
                            alert('Update Failed.');
                            window.location.href = window.location.href; // Reload the page
                          </script>";
                            // Redirect or handle error as needed
                        }
                    }
                    ?>
                <!-- col-1-ends -->
            </div>
            <?php
                }
                }
                else{
                echo "No record found!";
                }
                ?>
        </div>
        <!--content-->
        </div>
        <!--wrapper-->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function () {
            // Ensure the sidebar is active (visible) by default
            $('#sidebar').addClass('active'); // Change to addClass to show sidebar initially
            
            // Handle sidebar collapse toggle
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
            
            // Update the icon when collapsing/expanding
            $('[data-bs-toggle="collapse"]').on('click', function () {
                var target = $(this).find('.toggle-icon');
                if ($(this).attr('aria-expanded') === 'true') {
                    target.removeClass('fa-plus').addClass('fa-minus');
                } else {
                    target.removeClass('fa-minus').addClass('fa-plus');
                }
            });
            });
        </script>
        <script type="text/javascript" src="libs/js-xlsx/xlsx.core.min.js"></script>
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
        <script src="assets/js/main.js"></script>
        <script>
            function promptReason(itemId) {
                var reason = prompt("Rejection Remarks:");
                if (reason != null && reason.trim() !== "") {
                    window.location.href = "newproductidea_rnd_reject.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
                }
            }
        </script>
        <script>
            function submitRejectionReason(itemId, reason) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload(); 
                    }
                };
                xhr.open("POST", "update_rejection_reason.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + itemId + "&reason=" + encodeURIComponent(reason));
            }
        </script>
        <script>
            function promptReason2(itemId) {
                var reason = prompt("Approval Remarks:");
                if (reason != null && reason.trim() !== "") {
                    window.location.href = "newproductidea_rnd_approve.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
                }
            }
        </script>
        <script>
            function submitRejectionReason(itemId, reason) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload(); 
                    }
                };
                xhr.open("POST", "update_rejection_reason.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + itemId + "&reason=" + encodeURIComponent(reason));
            }
        </script>
    </body>
</html>