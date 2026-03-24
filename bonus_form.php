<?php 
    session_start (); 
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php'); // Redirect to the login page
        exit;
    }
    $head_email = $_SESSION['head_email'];
    
    ?>
<?php
    include 'dbconfig.php';
    
    $zone = $_SESSION['zone'];
    
    // AJAX 1: Get Towns based on Depot
    if (isset($_POST['action']) && $_POST['action'] === 'get_towns') {
        $depot = $_POST['depot'];
        $query = "SELECT DISTINCT town_name FROM customer_details WHERE depot_name = '$depot' AND zone = '$zone'";
        $result = mysqli_query($conn, $query);
        
        echo '<option value="">Select Town</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['town_name'] . '">' . $row['town_name'] . '</option>';
        }
        exit;
    }
    
    // AJAX 2: Get Customers based on Depot + Town
    if (isset($_POST['action']) && $_POST['action'] === 'get_customers') {
        $depot = $_POST['depot'];
        $town = $_POST['town'];
        $query = "SELECT DISTINCT cust_name FROM customer_details WHERE depot_name = '$depot' AND town_name = '$town' AND zone = '$zone'";
        $result = mysqli_query($conn, $query);
    
        echo '<option value="">Select Customer</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['cust_name'] . '">' . $row['cust_name'] . '</option>';
        }
        exit;
    }
    
    // AJAX 3: Get Customer Code by Name
    if (isset($_POST['action']) && $_POST['action'] === 'get_cust_id') {
        $cust_name = $_POST['cust_name'];
        $query = "SELECT cust_id FROM customer_details WHERE cust_name = '$cust_name' LIMIT 1";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        echo $row['cust_id'];
        exit;
    }
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Bonus Form</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="assets/css/style.css">
        <style>
            .btn-primary,.btn-success{
            font-size: 13px!important;
            padding:5px 15px!important;
            border-radius:5px!important;
            }
            .btn-color{
            background-color: #A66E38;
            }
            .btn-color:hover{
            background-color: #A66E38;
            }
            .modal-proname{
            font-weight: 700!important;
            }
            .table-modal td{
            font-size: 11px!important;
            }
            body {
            font-family: 'Poppins', sans-serif;
            }
            td{
            background-color: white!important;
            }
            .btn{
            border-radius:0px;
            color:white!important;
            }
            select{
            height:23px!important;
            }
            input{
            border-radius:0x!important;
            height:23px!important;
            }
            .input-pro{
            width:185px!important;
            }
            .input-batch{
            width:100px!important;
            }
            .input-num{
            width: 100%!important;
            }
            select,option {
            font-size: 10.5px; /* Change the font size as desired */
            width:100%!important;
            }
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
            .width{
            width: 100%;
            }
            .pro-width{
            width: 85%;
            }
            .numbering{
            font-size: 15px;
            }
            th{
            font-size: 10.5px!important;
            border:none!important;
            }
            .pro_th{
            font-size: 10px!important;
            color: white!important;
            background-color: #2F89FC!important;
            }
            .btn{
            font-size: 11px;
            }
            input{
            font-size: 11px;
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <?php
                include 'sidebar1.php';
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
                <section class="">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-color" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Trade Policy May-25
                                </button>
                                <!-- <button type="button" class="btn btn-color" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                                Rooh Afza Trade Scheme
                                </button> -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content" style="min-height: 500px;">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Trade Policy May-25</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table-responsive">
                                                    <table class="table table-modal">
                                                        <tbody>
                                                            <tr>
                                                                <td class="modal-proname">Coldeez (Pelargonium) Syrup</td>
                                                                <td>4+1</td>
                                                                <td>10+3</td>
                                                                <td>20+7</td>
                                                                <td>50+18</td>
                                                                <td>Multiple</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="modal-proname">Digas Antacid Suspension</td>
                                                                <td>6+1</td>
                                                                <td>12+3</td>
                                                                <td>20+6</td>
                                                                <td>50+16</td>
                                                                <td>100+36</td>
                                                                <td>Multiple</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="modal-proname">Digas Antacid Susp. Sachet</td>
                                                                <td>1+1 Digas Colic Drop</td>
                                                                <td>5+6 Digas Colic Drop</td>
                                                                <td>Multiple</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="modal-proname">Digas Classic Tab</td>
                                                                <td>7+1</td>
                                                                <td>Multiple</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="modal-proname">Digas Tab. Khatti Meethi</td>
                                                                <td>7+1</td>
                                                                <td>Multiple</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="modal-proname">Digas Colic Drops</td>
                                                                <td>10+2</td>
                                                                <td>Multiple</td>
                                                                <td>No any Disc. Only FOC</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="modal-proname">Digas Syrup</td>
                                                                <td>10+1</td>
                                                                <td>50+6</td>
                                                                <td>100+15</td>
                                                                <td>Multiple</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="modal-proname">F. C. Forte Syrup</td>
                                                                <td>3+1</td>
                                                                <td>Multiple</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="modal-proname">Herbituss Syrup</td>
                                                                <td>6+1</td>
                                                                <td>12+3</td>
                                                                <td>20+7</td>
                                                                <td>50+18</td>
                                                                <td>100+40</td>
                                                                <td>Multiple</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="modal-proname">Livgen Drops</td>
                                                                <td>5+1</td>
                                                                <td>10+3</td>
                                                                <td>Multiple</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="modal-proname">Livgen Syrup</td>
                                                                <td>5+1</td>
                                                                <td>10+3</td>
                                                                <td>Multiple</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="modal-proname">Medics Chest Rub</td>
                                                                <td>6+8% off</td>
                                                                <td>10+10% off</td>
                                                                <td>20 and above 15% off</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="modal-proname">Medics Children Cough Syrup</td>
                                                                <td>2+1</td>
                                                                <td>Multiple</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="modal-proname">Medics Toot Siah Plus</td>
                                                                <td>5+10% off</td>
                                                                <td>10+12% off</td>
                                                                <td>20+15% off</td>
                                                                <td>30+20% off</td>
                                                                <td>50+25% off</td>
                                                                <td>100 and above 30% off</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="modal-proname">Medics Inhaler</td>
                                                                <td>9+3</td>
                                                                <td>17+7</td>
                                                                <td>33+15</td>
                                                                <td>65+31</td>
                                                                <td>96+48</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="modal-proname">Rumol Cream 50gm</td>
                                                                <td>5+1</td>
                                                                <td>10+3</td>
                                                                <td>20+7</td>
                                                                <td>50+18</td>
                                                                <td>100+40</td>
                                                               
                                                            </tr>
                                                            <tr>
                                                                <td class="modal-proname">Rumol Cream 25gm</td>
                                                                <td>6+1</td>
                                                                <td>Multiple</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="modal-proname">Digas Antacid Susp. Sachet Jar</td>
                                                                <td>1 + 2 / Digas Colic Drops + 5% Disc</td>
                                                               
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content" style="min-height: 500px;">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Rooh Afza Trade Scheme April-25</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table-responsive">
                                                    <table class="table table-modal table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <th style="font-weight:900!important">Product Code</th>
                                                                <th style="font-weight:900!important">Product Code</th>
                                                                <th style="font-weight:900!important">Bonus Slab</th>
                                                                <th style="font-weight:900!important">Rooh Afza Trade Scheme</th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5" class="text-center" style="font-weight:700!important">For (Retailer + Wholesalers + HOD )</td>
                                                            </tr>
                                                            <tr>
                                                                <td>91008</td>
                                                                <td>Digas Colic Drops</td>
                                                                <td>20 + 4</td>
                                                                <td rowspan="5">1 Rooh Afza Free oninvoice Value of Rs. 5,114/- Upto Rs. 12,044/-2 time Multiple</td>
                                                            </tr>
                                                            <tr>
                                                                <td>91001</td>
                                                                <td>Digas Syrup</td>
                                                                <td>10 + 1</td>
                                                                <!-- <td>1 Rooh Afza Free oninvoice Value of Rs. 5,114/- Upto Rs. 12,044/-2 time Multiple</td> -->
                                                            </tr>
                                                            <tr>
                                                                <td>91011</td>
                                                                <td>Digas Antacid Suspension</td>
                                                                <td>13 + 3</td>
                                                                <!-- <td>1 Rooh Afza Free oninvoice Value of Rs. 5,114/- Upto Rs. 12,044/-2 time Multiple</td> -->
                                                            </tr>
                                                            <tr>
                                                                <td>91006</td>
                                                                <td>Digas Classic Tablet</td>
                                                                <td>14 + 2</td>
                                                                <!-- <td>1 Rooh Afza Free oninvoice Value of Rs. 5,114/- Upto Rs. 12,044/-2 time Multiple</td> -->
                                                            </tr>
                                                            <tr>
                                                                <td>91009</td>
                                                                <td>Digas Tab. Khatti Meeti</td>
                                                                <td>20 + 4</td>
                                                                <!-- <td>1 Rooh Afza Free oninvoice Value of Rs. 5,114/- Upto Rs. 12,044/-2 time Multiple</td> -->
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5" class="text-center" style="font-weight:700!important">For (Retailer + Wholesalers + HOD + Stockiest ) </td>
                                                            </tr>
                                                            <tr>
                                                                <td>91008</td>
                                                                <td>Dias Colic Drops</td>
                                                                <td>30 + 6</td>
                                                                <td>1 Bott.Rooh Afza & Multiple</td>
                                                            </tr>
                                                            <tr>
                                                                <td>91001</td>
                                                                <td>Digas Syrup</td>
                                                                <td>50 + 6</td>
                                                                <td>1 Bott.Rooh Afza & Multiple</td>
                                                            </tr>
                                                            <tr>
                                                                <td>91011</td>
                                                                <td>Digas Antacid Suspension</td>
                                                                <td>50 + 6</td>
                                                                <td>1 Bott.Rooh Afza & Multiple</td>
                                                            </tr>
                                                            <tr>
                                                                <td>91008</td>
                                                                <td>Dias Colic Drops</td>
                                                                <td>100 + 20</td>
                                                                <td>4 Bott.Rooh Afza & Multiple</td>
                                                            </tr>
                                                            <tr>
                                                                <td>91008</td>
                                                                <td>Dias Colic Drops</td>
                                                                <td>30 + 6</td>
                                                                <td>1 Bott.Rooh Afza & Multiple</td>
                                                            </tr>
                                                            <tr>
                                                                <td>91001</td>
                                                                <td>Digas Syrup</td>
                                                                <td>100 + 6</td>
                                                                <td>3 Bott.Rooh Afza & Multiple</td>
                                                            </tr>
                                                            <tr>
                                                                <td>91001</td>
                                                                <td>Digas Antacid Suspension</td>
                                                                <td>100 + 36</td>
                                                                <td>3 Bott.Rooh Afza & Multiple</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ml-auto pt-md-2">
                                <form class="form pb-3" method="POST" id="bonusForm" style="border: 0.5px solid black; padding: 25px; padding-bottom: 0px; border-radius: 5px; background-color: white;">
                                    <h5 class="text-center pb-3"><span style="float:left!important"><a class="btn btn-dark btn-sm" href="bonus_approval_home.php" style="font-size:11px!important"><i class="fa-solid fa-arrow-left"></i> Home</a></span> Bonus Approval Form</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered ">
                                            <thead>
                                            </thead>
                                            <tbody id="table-body">
                                                <tr>
                                                    <th>Depot</th>
                                                    <td colspan="6">
                                                        <select name="depot" id="depot" class="width">
                                                            <option value="">Select Depot</option>
                                                            <?php
                                                                $select = "SELECT DISTINCT depot_name FROM customer_details WHERE zone = '$zone'";
                                                                $select_q = mysqli_query($conn, $select);
                                                                while ($row = mysqli_fetch_assoc($select_q)) {
                                                                    echo '<option value="' . $row['depot_name'] . '">' . $row['depot_name'] . '</option>';
                                                                }
                                                                ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Town</th>
                                                    <td colspan="6">
                                                        <select name="town" id="town" class="width">
                                                            <option value="">Select Town</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Customer Name</th>
                                                    <td colspan="6">
                                                        <select name="customer_name" id="cust_name" class="width">
                                                            <option value="">Select Customer</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Customer Code</th>
                                                    <td colspan="6">
                                                        <input type="text" name="customer_code" id="customer_code" class="width" readonly>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="pro_th" style="width: 180px;">Products</th>
                                                    <th class="pro_th" style="width: 100px;">Quantity</th>
                                                    <th class="pro_th" style="width: 120px;">Actual Bonus</th>
                                                    <th class="pro_th" style="width: 140px;">Additional Bonus</th>
                                                    <th class="pro_th" style="width: 120px;">Total Bonus</th>
                                                    <th class="pro_th" style="width: 100px;">Gift</th>
                                                    <th class="pro_th" style="width: 110px;">Withdrawal</th>
                                                    <th class="pro_th" style="width: 180px;">Remarks</th>
                                                    <th class="pro_th" style="width: 90px;">Remove</th>
                                                </tr>
                                                <tr id="row_1">
                                                    <td>
                                                        <select name="products[]" class="pro-width input-pro"  style="min-width: 250px!important;">
                                                        <?php
                                                            $select = "SELECT name FROM products";
                                                            $select_q = mysqli_query($conn, $select);
                                                            if (mysqli_num_rows($select_q) > 0) {
                                                                while ($row = mysqli_fetch_assoc($select_q)) {
                                                                    echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                                                                }
                                                            } else {
                                                                echo '<option value="">No products found</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td style="min-width: 170px;"><input type="number" name="product_qty[]" class="input-num" autocomplete="off" style="width: 100%;"></td>
                                                    <td style="min-width: 170px;"><input type="text" name="actual_bonus[]" class="input-num" autocomplete="off" oninput="calculateTotalBonus(this)" style="width: 100%;"></td>
                                                    <td style="min-width: 170px;"><input type="text" name="additional_bonus[]" class="input-num" autocomplete="off" oninput="calculateTotalBonus(this)" style="width: 100%;"></td>
                                                    <td style="min-width: 170px;"><input type="text" name="total_bonus[]" class="input-num" autocomplete="off" readonly style="width: 100%;"></td>
                                                    <td style="min-width: 170px;"><input type="text" name="gift[]" class="input-num" autocomplete="off" style="width: 100%;"></td>
                                                    <td style="min-width: 170px;"><input type="number" name="withdrawal[]" class="input-num" autocomplete="off" style="width: 100%;"></td>
                                                    <td style="min-width: 170px;"><input type="text" name="remarks[]" class="input-num" autocomplete="off" style="width: 100%;"></td>
                                                    <td style="min-width: 170px;"><button type="button" class="btn btn-danger btn-sm removeRow" style="font-size:11px!important; width: 100%;">Remove</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-center mt-3">
                                        <button type="button" id="addRow" class="btn btn-primary btn-sm">Add Product</button>
                                        <button type="submit" class="btn btn-success btn-sm" name="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <?php
                                include 'dbconfig.php';
                                
                                if (isset($_POST['submit'])) {
                                    $depot = $_POST['depot'];
                                    $town = $_POST['town'];
                                    $customer_name = $_POST['customer_name'];
                                    $customer_code = $_POST['customer_code'];
                                    $products = $_POST['products'];
                                    $product_qty = $_POST['product_qty'];
                                    $actual_bonus = $_POST['actual_bonus'];
                                    $additional_bonus = $_POST['additional_bonus'];
                                    $total_bonus = $_POST['total_bonus'];
                                    $gift = $_POST['gift'];
                                    $withdrawal = $_POST['withdrawal']; 
                                    $remarks = $_POST['remarks']; 
                                    $name = $_SESSION['fullname'];
                                    $username = $_SESSION['username'];
                                    $email = $_SESSION['email'];
                                    $department = $_SESSION['department'];
                                    $role = $_SESSION['role'];
                                    $zone = $_SESSION['zone'];
                                    $be_depart = $_SESSION['be_depart'];
                                    $be_role = $_SESSION['be_role'];
                                    $date = date('Y-m-d H:i:s');
                                
                                    $insert_query = "INSERT INTO bonus_form (name, username, email, date, department, role, zone, customer_name, customer_code, depot,town, be_depart, be_role, zsm_status, ho_status, task_status, final_status, delivery_status";
                                
                                    for ($i = 1; $i <= 6; $i++) {
                                        $insert_query .= ", products_$i, order_qty_$i, actual_bonus_$i, additional_bonus_$i, total_bonus_$i, gift_$i, withdrawal_$i, remarks_$i"; // Added withdrawal and remarks
                                    }
                                
                                    $insert_query .= ") VALUES ('$name', '$username', '$email', '$date', '$department', '$role', '$zone', '$customer_name', '$customer_code', '$depot','$depot', '$be_depart', '$be_role', 'Pending', 'Pending', 'Approval Pending', 'Approval Pending', 'Undelivered'";
                                
                                    // Loop through each product field
                                    for ($i = 0; $i < 6; $i++) {
                                        $product = isset($products[$i]) ? mysqli_real_escape_string($conn, $products[$i]) : '';
                                        $qty = isset($product_qty[$i]) ? mysqli_real_escape_string($conn, $product_qty[$i]) : '';
                                        $actual = isset($actual_bonus[$i]) ? mysqli_real_escape_string($conn, $actual_bonus[$i]) : '';
                                        $additional = isset($additional_bonus[$i]) ? mysqli_real_escape_string($conn, $additional_bonus[$i]) : '';
                                        $total = isset($total_bonus[$i]) ? mysqli_real_escape_string($conn, $total_bonus[$i]) : '';
                                        $gift_val = isset($gift[$i]) ? mysqli_real_escape_string($conn, $gift[$i]) : '';
                                        $withdrawal_val = isset($withdrawal[$i]) ? mysqli_real_escape_string($conn, $withdrawal[$i]) : '';
                                        $remarks_val = isset($remarks[$i]) ? mysqli_real_escape_string($conn, $remarks[$i]) : '';
                                
                                        if ($qty === '') $qty = NULL;
                                        if ($actual === '') $actual = NULL;
                                        if ($additional === '') $additional = NULL;
                                        if ($total === '') $total = NULL;
                                
                                        $insert_query .= ", '$product', '$qty', '$actual', '$additional', '$total', '$gift_val', '$withdrawal_val', '$remarks_val'";
                                    }
                                
                                    $insert_query .= ")";
                                
                                    if (mysqli_query($conn, $insert_query)) {
                                        echo "<script>alert('Request has been submitted'); window.location.href = 'bonus_form.php';</script>";
                                    } else {
                                        echo "<script>alert('Error submitting request'); window.location.href = 'bonus_form.php';</script>";
                                    }
                                }
                                
                                ?>
                        </div>
                    </div>
            </div>
            </section>
        </div>
        </div> 
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function () {
            $('#sidebar').addClass('active');
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
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
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const checkboxes = document.querySelectorAll('.category-checkbox');
                checkboxes.forEach(function (checkbox) {
                    checkbox.addEventListener('change', function () {
                        const groupName = this.name.split('_')[0]; 
                        checkboxes.forEach(function (cb) {
                            if (cb !== checkbox && cb.name.startsWith(groupName)) {
                                cb.checked = false;
                            }
                        });
                    });
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const checkboxes = document.querySelectorAll('.type-checkbox');
                checkboxes.forEach(function (checkbox) {
                    checkbox.addEventListener('change', function () {
                        const groupName = this.name.split('_')[0]; 
                        checkboxes.forEach(function (cb) {
                            if (cb !== checkbox && cb.name.startsWith(groupName)) {
                                cb.checked = false;
                            }
                        });
                    });
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const checkboxes = document.querySelectorAll('.depart_type-checkbox');
            
                checkboxes.forEach(function (checkbox) {
                    checkbox.addEventListener('change', function () {
                        const groupName = this.name.split('_')[0]; 
                        checkboxes.forEach(function (cb) {
                            if (cb !== checkbox && cb.name.startsWith(groupName)) {
                                cb.checked = false;
                            }
                        });
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                var rowNumber = 2; 
                var maxRows = 8;  
                $('#addRow').click(function() {
                    if ($('#table-body tr').length - 2 < maxRows) {
                        var newRow = $('#row_1').clone().attr('id', 'row_' + rowNumber);
                        
                        newRow.find('input').each(function() {
                            var name = $(this).attr('name').replace('1_', rowNumber + '_');
                            $(this).attr('name', name);
                            $(this).val('');
                        });
                        newRow.find('td:first').html('<select name="products[]" class="input-pro">' + $('#row_1 select').html() + '</select>');
                        newRow.find('td:last').html('<button type="button" class="btn btn-danger removeRow" style="font-size:11px!important">Remove</button>');
                        
                        $('#table-body').append(newRow);
                        rowNumber++;
                    } else {
                        alert('6 Products limit');
                    }
                });
                $(document).on('click', '.removeRow', function() {
                    $(this).closest('tr').remove();
                    rowNumber--; 
                });
            });
        </script>
        <script src="assets/js/main.js"></script>
        <script>
            $(document).ready(function(){
            
                $('#depot').on('change', function(){
                    let depot = $(this).val();
                    $.post('', {action: 'get_towns', depot: depot}, function(data){
                        $('#town').html(data);
                        $('#cust_name').html('<option value="">Select Customer</option>');
                        $('#customer_code').val('');
                    });
                });
            
                $('#town').on('change', function(){
                    let depot = $('#depot').val();
                    let town = $(this).val();
                    $.post('', {action: 'get_customers', depot: depot, town: town}, function(data){
                        $('#cust_name').html(data);
                        $('#customer_code').val('');
                    });
                });
            
                $('#cust_name').on('change', function(){
                    let cust_name = $(this).val();
                    $.post('', {action: 'get_cust_id', cust_name: cust_name}, function(data){
                        $('#customer_code').val(data);
                    });
                });
            
            });
        </script>
        <!-- <script>
 // Slab data
const slabs = {
  "Coldeez (Pelargonium) Syrup 120ml": [
    { min: 50, bonus: 18 },
    { min: 20, bonus: 7 },
    { min: 10, bonus: 3 },
    { min: 4, bonus: 1 }
  ],
  "Digas Antacid Suspension 120ml": [
    { min: 100, bonus: 36 },
    { min: 50, bonus: 16 },
    { min: 20, bonus: 6 },
    { min: 12, bonus: 3 },
    { min: 6, bonus: 1 }
  ],
  "Digas Antacid Susp. Sachet 25x10ml": [
    { min: 5, bonus: 6, gift: "Digas Colic Drop" },
    { min: 1, bonus: 1, gift: "Digas Colic Drop" }
  ],
  "Digas Antacid Susp. Sachet Jar": [
    { min: 5, bonus: 2, gift: "Digas Colic Drop + 5% off" },
    { min: 1, bonus: 2, gift: "Digas Colic Drop + 5% off" }
  ],
  "Digas Classic Tab 120's": [
    { min: 7, bonus: 1 }
  ],
  "Digas Tab. Khatti Meethi 120's": [
    { min: 7, bonus: 1 }
  ],
  "Digas Colic Drops 20ml": [
    { min: 10, bonus: 2 }
  ],
  "Digas Syrup 120ml": [
    { min: 100, bonus: 15 },
    { min: 50, bonus: 6 },
    { min: 10, bonus: 1 }
  ],
  "F. C. Forte Syrup 120ml": [
    { min: 3, bonus: 1 }
  ],
  "Herbituss Syrup 120ml": [
    { min: 100, bonus: 40 },
    { min: 50, bonus: 18 },
    { min: 20, bonus: 7 },
    { min: 12, bonus: 3 },
    { min: 6, bonus: 1 }
  ],
  "Livgen Drops 20ml": [
    { min: 10, bonus: 3 },
    { min: 5, bonus: 1 }
  ],
  "Livgen Syrup 120ml": [
    { min: 10, bonus: 3 },
    { min: 5, bonus: 1 }
  ],
  "Medics Chest Rub": [
    { min: 20, discount: 15 },
    { min: 10, discount: 10 },
    { min: 6, discount: 8 }
  ],
  "Medics Children Cough Syrup 120ml": [
    { min: 2, bonus: 1 }
  ],
  "Medics Toot Siah Plus 120ml": [
    { min: 100, discount: 30 },
    { min: 50, discount: 25 },
    { min: 30, discount: 20 },
    { min: 20, discount: 15 },
    { min: 10, discount: 12 },
    { min: 5, discount: 10 }
  ],
  "Medics Inhaler 1ml": [
    { min: 96, bonus: 48 },
    { min: 65, bonus: 31 },
    { min: 35, bonus: 15 },
    { min: 17, bonus: 7 },
    { min: 9, bonus: 3 }
  ],
  "Rumol Cream 50gm": [
    { min: 100, bonus: 40 },
    { min: 50, bonus: 18 },
    { min: 20, bonus: 7 },
    { min: 10, bonus: 3 },
    { min: 5, bonus: 1 }
  ],
  "Rumol Cream 25gm": [
    { min: 6, bonus: 1 }
  ]
};

// Main bonus calculation function
function autoCalculateBonus(row) {
  const productSelect = row.querySelector('select[name="products[]"]');
  const qtyInput = row.querySelector('input[name="product_qty[]"]');
  const actualBonusInput = row.querySelector('input[name="actual_bonus[]"]');
  const totalBonusInput = row.querySelector('input[name="total_bonus[]"]');
  const giftInput = row.querySelector('input[name="gift[]"]');

  const product = productSelect.value;
  let qty = parseInt(qtyInput.value, 10);

  actualBonusInput.value = '';
  totalBonusInput.value = '';
  giftInput.value = '';

  if (!product || isNaN(qty) || !slabs[product]) return;

  let bonusText = '';
  let giftText = '';

  const sorted = slabs[product].slice().sort((a, b) => b.min - a.min);

  // Loop through slabs and calculate bonus or discount
  for (const slab of sorted) {
    if (slab.discount != null) {
      // For products with discount (fixed last slab)
      if (qty >= slab.min) {
        giftText = `${slab.discount}% off`;
        break;
      }
    } else {
      // For products with multiple slabs (variable)
      if (qty >= slab.min) {
        if (slab.gift) {
          let totalGifts = slab.bonus * qty;
          bonusText = `${totalGifts} ${slab.gift}`;
        } else {
          let totalBonus = slab.bonus * Math.floor(qty / slab.min);
          bonusText = totalBonus.toString();
        }
        break;
      }
    }
  }

  actualBonusInput.value = bonusText || giftText;
  calculateTotalBonus(actualBonusInput);
}

// Total bonus calculation
function calculateTotalBonus(input) {
  var row = $(input).closest('tr');
  var actualBonus = row.find('input[name="actual_bonus[]"]').val().trim();
  var additionalBonus = row.find('input[name="additional_bonus[]"]').val().trim();

  if (!actualBonus) {
    row.find('input[name="total_bonus[]"]').val(additionalBonus);
    return;
  }

  const isActualBonusText = actualBonus.includes('%') || /[a-zA-Z]/.test(actualBonus);

  if (isActualBonusText) {
    if (additionalBonus === '' || additionalBonus === '0') {
      row.find('input[name="total_bonus[]"]').val(actualBonus);
    } else {
      row.find('input[name="total_bonus[]"]').val(additionalBonus + ' + ' + actualBonus);
    }
  } else {
    const actualSum = actualBonus.split('+').reduce((sum, val) => sum + (parseFloat(val.trim()) || 0), 0);
    const additionalSum = parseFloat(additionalBonus) || 0;
    row.find('input[name="total_bonus[]"]').val(actualSum + additionalSum);
  }
}

// Attach events to every row
function attachEventListenersToRow(row) {
  const sel = row.querySelector('select[name="products[]"]');
  const qty = row.querySelector('input[name="product_qty[]"]');
  const additional = row.querySelector('input[name="additional_bonus[]"]');

  if (sel) sel.addEventListener('change', () => autoCalculateBonus(row));
  if (qty) qty.addEventListener('input', () => autoCalculateBonus(row));
  if (additional) additional.addEventListener('input', function () {
    calculateTotalBonus(this);
  });
}

// Initialize events for existing rows
document.querySelectorAll('#table-body tr').forEach(attachEventListenersToRow);

// Handle dynamic added row
document.getElementById('addRow').addEventListener('click', () => {
  setTimeout(() => {
    const rows = document.querySelectorAll('#table-body tr');
    const newRow = rows[rows.length - 1];
    attachEventListenersToRow(newRow);
  }, 50);
});


</script> -->
<script>
// Slab data
const slabs = {
  "Coldeez (Pelargonium) Syrup 120ml": [
    { min: 50, bonus: 18 },
    { min: 20, bonus: 7 },
    { min: 10, bonus: 3 },
    { min: 4, bonus: 1 }
  ],
  "Digas Antacid Suspension 120ml": [
    { min: 100, bonus: 36 },
    { min: 50, bonus: 16 },
    { min: 20, bonus: 6 },
    { min: 12, bonus: 3 },
    { min: 6, bonus: 1 }
  ],
  "Digas Antacid Susp. Sachet 25x10ml": [
    { min: 5, bonus: 6, gift: "Digas Colic Drop" },
    { min: 1, bonus: 1, gift: "Digas Colic Drop" }
  ],
  "Digas Antacid Susp. Sachet Jar": [
    { min: 5, bonus: 2, gift: "Digas Colic Drop + 5% off" },
    { min: 1, bonus: 2, gift: "Digas Colic Drop + 5% off" }
  ],
  "Digas Classic Tab 120's": [
    { min: 7, bonus: 1 }
  ],
  "Digas Tab. Khatti Meethi 120's": [
    { min: 7, bonus: 1 }
  ],
  "Digas Colic Drops 20ml": [
    { min: 10, bonus: 2 }
  ],
  "Digas Syrup 120ml": [
    { min: 100, bonus: 15 },
    { min: 50, bonus: 6 },
    { min: 10, bonus: 1 }
  ],
  "F. C. Forte Syrup 120ml": [
    { min: 3, bonus: 1 }
  ],
  "Herbituss Syrup 120ml": [
    { min: 100, bonus: 40 },
    { min: 50, bonus: 18 },
    { min: 20, bonus: 7 },
    { min: 12, bonus: 3 },
    { min: 6, bonus: 1 }
  ],
  "Livgen Drops 20ml": [
    { min: 10, bonus: 3 },
    { min: 5, bonus: 1 }
  ],
  "Livgen Syrup 120ml": [
    { min: 10, bonus: 3 },
    { min: 5, bonus: 1 }
  ],
  "Medics Chest Rub": [
    { min: 20, discount: 15 },
    { min: 10, discount: 10 },
    { min: 6, discount: 8 }
  ],
  "Medics Children Cough Syrup 120ml": [
    { min: 2, bonus: 1 }
  ],
  "Medics Toot Siah Plus 120ml": [
    { min: 100, discount: 30 },
    { min: 50, discount: 25 },
    { min: 30, discount: 20 },
    { min: 20, discount: 15 },
    { min: 10, discount: 12 },
    { min: 5, discount: 10 }
  ],
  "Medics Inhaler 1ml": [
    { min: 96, bonus: 48 },
    { min: 65, bonus: 31 },
    { min: 33, bonus: 15 },
    { min: 17, bonus: 7 },
    { min: 9, bonus: 3 }
  ],
  "Rumol Cream 50gm": [
    { min: 100, bonus: 40 },
    { min: 50, bonus: 18 },
    { min: 20, bonus: 7 },
    { min: 10, bonus: 3 },
    { min: 5, bonus: 1 }
  ],
  "Rumol Cream 25gm": [
    { min: 6, bonus: 1 }
  ]
};

// Main bonus calculation function
function autoCalculateBonus(row) {
  const productSelect = row.querySelector('select[name="products[]"]');
  const qtyInput = row.querySelector('input[name="product_qty[]"]');
  const actualBonusInput = row.querySelector('input[name="actual_bonus[]"]');
  const totalBonusInput = row.querySelector('input[name="total_bonus[]"]');
  const giftInput = row.querySelector('input[name="gift[]"]');

  const product = productSelect.value;
  let qty = parseInt(qtyInput.value, 10);

  actualBonusInput.value = '';
  totalBonusInput.value = '';
  giftInput.value = '';

  if (!product || isNaN(qty) || !slabs[product]) return;

  let bonusText = '';
  let giftText = '';

  const sorted = slabs[product].slice().sort((a, b) => b.min - a.min);

  for (const slab of sorted) {
    if (slab.discount != null) {
      if (qty >= slab.min) {
        giftText = `${slab.discount}% off`;
        break;
      }
    } else {
      if (qty >= slab.min) {
        if (slab.gift) {
          let times = Math.floor(qty / slab.min);
          let totalBonus = times * slab.bonus;
          bonusText = `${totalBonus} ${slab.gift}`;
        } else {
          let times = Math.floor(qty / slab.min);
          let totalBonus = times * slab.bonus;
          bonusText = totalBonus.toString();
        }
        break;
      }
    }
  }

  actualBonusInput.value = bonusText || giftText;
  calculateTotalBonus(actualBonusInput);
}

// Total bonus calculation
function calculateTotalBonus(input) {
  var row = $(input).closest('tr');
  var actualBonus = row.find('input[name="actual_bonus[]"]').val().trim();
  var additionalBonus = row.find('input[name="additional_bonus[]"]').val().trim();

  if (!actualBonus) {
    row.find('input[name="total_bonus[]"]').val(additionalBonus);
    return;
  }

  const isActualBonusText = actualBonus.includes('%') || /[a-zA-Z]/.test(actualBonus);

  if (isActualBonusText) {
    if (additionalBonus === '' || additionalBonus === '0') {
      row.find('input[name="total_bonus[]"]').val(actualBonus);
    } else {
      row.find('input[name="total_bonus[]"]').val(additionalBonus + ' + ' + actualBonus);
    }
  } else {
    const actualSum = actualBonus.split('+').reduce((sum, val) => sum + (parseFloat(val.trim()) || 0), 0);
    const additionalSum = parseFloat(additionalBonus) || 0;
    row.find('input[name="total_bonus[]"]').val(actualSum + additionalSum);
  }
}

// Attach events to every row
function attachEventListenersToRow(row) {
  const sel = row.querySelector('select[name="products[]"]');
  const qty = row.querySelector('input[name="product_qty[]"]');
  const additional = row.querySelector('input[name="additional_bonus[]"]');

  if (sel) sel.addEventListener('change', () => autoCalculateBonus(row));
  if (qty) qty.addEventListener('input', () => autoCalculateBonus(row));
  if (additional) additional.addEventListener('input', function () {
    calculateTotalBonus(this);
  });
}

// Initialize events for existing rows
document.querySelectorAll('#table-body tr').forEach(attachEventListenersToRow);

// Handle dynamic added row
document.getElementById('addRow').addEventListener('click', () => {
  setTimeout(() => {
    const rows = document.querySelectorAll('#table-body tr');
    const newRow = rows[rows.length - 1];
    attachEventListenersToRow(newRow);
  }, 50);
});
</script>


    </body>
</html>