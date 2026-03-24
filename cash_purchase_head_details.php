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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Cash Purchase</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <!-- Bootstrap CSS CDN -->
        <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous"> -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Poppins Font -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="assets/css/style.css">
        <style>
            .btn{
            font-size: 11px!important;
            }
            body {
            font-family: 'Poppins', sans-serif;
            }
            .btn{
            border-radius:0px;
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
            .btn-menu{
            font-size: 11px;
            }
            .cbox{
            height: 13px!important;
            width: 13px!important;
            }
            table th {
            font-size: 12.5px!important;
            border:none!important;
            background-color: #1B7BBC!important;
            color:white!important;
            padding:6px 5px!important;
            }
            table td {
            font-size: 12.5px;
            color: black;
            padding: 0px!important; /* Adjust padding as needed */
            /* border: 1px solid #ddd; */
            }
            input {
            width: 100% !important;
            font-size: 12.5px; 
            border-radius: 0px;
            border: 1px solid grey;
            transition: border-color 0.3s ease;
            padding: 2.5px 5px;
            letter-spacing: 0.4px; 
            height:25px!important;
            /* color:#2c2c2c!important; */
            }
            input:focus {
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
            }
            .labelp{
            padding:0px!important;
            margin:0px!important;
            font-size: 12.5px!important;
            font-weight: 600!important;
            padding-bottom: 5px!important;;
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
                    $select = "SELECT * FROM cash_purchase WHERE
                    id = '$id' ";
                    
                    $select_q = mysqli_query($conn,$select);
                    $data = mysqli_num_rows($select_q);
                    ?>
                <?php 
                    if($data){
                    	while ($row=mysqli_fetch_array($select_q)) {
                    		?>
                <div class="container-fluid">
                    <form class="form pb-3" method="POST">
                                <div class="d-flex align-items-center position-relative mb-3" style="min-height: 40px;">
    <!-- Left-aligned buttons -->
    <div class="z-1">
        <a class="btn btn-dark btn-sm me-2" href="expense_home.php" style="font-size:11px!important">
            <i class="fa fa-home"></i> Home
        </a>
        <a class="btn btn-dark btn-sm me-2" href="cash_purchase_head_list.php" style="font-size:11px!important">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    <!-- Centered heading -->
    <h5 class="position-absolute top-50 start-50 translate-middle text-center mb-0 fw-bold">
        Cash / Purchase Requisition Form
    </h5>
</div>
                        <div class="row mb-3 mt-5">
                            <div class="col-md-4">
                                <div>
                                    <p class="labelp">Requestor Name</p>
                                    <input type="text" name="name" value="<?php echo $row['name']; ?>" class="w-100" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div>
                                    <p class="labelp">Department</p>
                                    <input type="text" name="department" value="<?php echo $row['department']; ?>" class="w-100" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div>
                                    <p class="labelp">Role</p>
                                    <input type="text" name="role" value="<?php echo $row['role']; ?>" class="w-100" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width:20px!important">S.R</th>
                                        <th>Description</th>
                                        <th>Purpose</th>
                                        <th style="width:70px!important">Qty</th>
                                        <th style="width:120px!important">Price</th>
                                        <th style="width:120px!important">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($row['description_1'])): ?>
                                    <tr>
                                        <td><input type="text" name="sr_1" value="<?php echo $row['sr_1']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="description_1" value="<?php echo $row['description_1']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="purpose_1" value="<?php echo $row['purpose_1']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="qty_1" value="<?php echo $row['qty_1']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="price_1" value="<?php echo $row['price_1']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="amount_1" value="<?php echo $row['amount_1']; ?>" class="w-100" readonly></td>
                                    </tr>
                                    <?php endif; ?>

                                    <?php if (!empty($row['description_2'])): ?>
                                    <tr>
                                        <td><input type="text" name="sr_2" value="<?php echo $row['sr_2']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="description_2" value="<?php echo $row['description_2']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="purpose_2" value="<?php echo $row['purpose_2']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="qty_2" value="<?php echo $row['qty_2']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="price_2" value="<?php echo $row['price_2']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="amount_2" value="<?php echo $row['amount_2']; ?>" class="w-100" readonly></td>
                                    </tr>
                                    <?php endif; ?>

                                    <?php if (!empty($row['description_3'])): ?>
                                    <tr>
                                        <td><input type="text" name="sr_3" value="<?php echo $row['sr_3']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="description_3" value="<?php echo $row['description_3']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="purpose_3" value="<?php echo $row['purpose_3']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="qty_3" value="<?php echo $row['qty_3']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="price_3" value="<?php echo $row['price_3']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="amount_3" value="<?php echo $row['amount_3']; ?>" class="w-100" readonly></td>
                                    </tr>
                                    <?php endif; ?>

                                    <?php if (!empty($row['description_4'])): ?>
                                    <tr>
                                        <td><input type="text" name="sr_4" value="<?php echo $row['sr_4']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="description_4" value="<?php echo $row['description_4']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="purpose_4" value="<?php echo $row['purpose_4']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="qty_4" value="<?php echo $row['qty_4']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="price_4" value="<?php echo $row['price_4']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="amount_4" value="<?php echo $row['amount_4']; ?>" class="w-100" readonly></td>
                                    </tr>
                                    <?php endif; ?>

                                    <?php if (!empty($row['description_5'])): ?>
                                    <tr>
                                        <td><input type="text" name="sr_5" value="<?php echo $row['sr_5']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="description_5" value="<?php echo $row['description_5']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="purpose_5" value="<?php echo $row['purpose_5']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="qty_5" value="<?php echo $row['qty_5']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="price_5" value="<?php echo $row['price_5']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="amount_5" value="<?php echo $row['amount_5']; ?>" class="w-100" readonly></td>
                                    </tr>
                                    <?php endif; ?>

                                    <?php if (!empty($row['description_6'])): ?>
                                    <tr>
                                        <td><input type="text" name="sr_6" value="<?php echo $row['sr_6']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="description_6" value="<?php echo $row['description_6']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="purpose_6" value="<?php echo $row['purpose_6']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="qty_6" value="<?php echo $row['qty_6']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="price_6" value="<?php echo $row['price_6']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="amount_6" value="<?php echo $row['amount_6']; ?>" class="w-100" readonly></td>
                                    </tr>
                                    <?php endif; ?>

                                    <?php if (!empty($row['description_7'])): ?>
                                    <tr>
                                        <td><input type="text" name="sr_7" value="<?php echo $row['sr_7']; ?>" class="w-100"readonly></td>
                                        <td><input type="text" name="description_7" value="<?php echo $row['description_7']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="purpose_7" value="<?php echo $row['purpose_7']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="qty_7" value="<?php echo $row['qty_7']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="price_7" value="<?php echo $row['price_7']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="amount_7" value="<?php echo $row['amount_7']; ?>" class="w-100" readonly></td>
                                    </tr>
                                    <?php endif; ?>

                                    <?php if (!empty($row['description_8'])): ?>
                                    <tr>
                                        <td><input type="text" name="sr_8" value="<?php echo $row['sr_8']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="description_8" value="<?php echo $row['description_8']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="purpose_8" value="<?php echo $row['purpose_8']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="qty_8" value="<?php echo $row['qty_8']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="price_8" value="<?php echo $row['price_8']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="amount_8" value="<?php echo $row['amount_8']; ?>" class="w-100" readonly></td>
                                    </tr>
                                    <?php endif; ?>

                                    <?php if (!empty($row['description_9'])): ?>
                                    <tr>
                                        <td><input type="text" name="sr_9" value="<?php echo $row['sr_9']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="description_9" value="<?php echo $row['description_9']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="purpose_9" value="<?php echo $row['purpose_9']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="qty_9" value="<?php echo $row['qty_9']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="price_9" value="<?php echo $row['price_9']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="amount_9" value="<?php echo $row['amount_9']; ?>" class="w-100"readonly></td>
                                    </tr>
                                    <?php endif; ?>

                                    <?php if (!empty($row['description_10'])): ?>
                                    <tr>
                                        <td><input type="text" name="sr_10" value="<?php echo $row['sr_10']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="description_10" value="<?php echo $row['description_10']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="purpose_10" value="<?php echo $row['purpose_10']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="qty_10" value="<?php echo $row['qty_10']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="price_10" value="<?php echo $row['price_10']; ?>" class="w-100" readonly></td>
                                        <td><input type="text" name="amount_10" value="<?php echo $row['amount_10']; ?>" class="w-100" readonly></td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td colspan="5" class="px-2" style="text-align: right !important;font-weight:600;font-size:18px">Total Amount</td>
                                        <td><input type="text" name="total_amount" value="<?php echo $row['total_amount']; ?>" class="w-100" readonly style="color:red;font-weight:600;font-size:18px"></td>
                                    </tr>

                        </tbody>
                            </table>
                            <div class="text-center">
                              
                            <a href="cash_purchase_head_approve.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email']; ?>&name=<?php echo $row['name']; ?>"  class="btn btn-success btn-md" style="border-radius:15px!important;font-size:15px!important"><i class="fa-solid fa-check"></i> Approve</a>
                            <a href="cash_purchase_head_reject.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email']; ?>&name=<?php echo $row['name']; ?>"  class="btn btn-danger btn-md" style="border-radius:15px!important;font-size:15px!important"><i class="fa-solid fa-xmark"></i> Reject</a>
                            </div>
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
                    
                        $sr_1 = isset($_POST['sr_1']) && $_POST['sr_1'] !== $row['sr_1'] ? $_POST['sr_1'] : $row['sr_1'];
                        $sr_2 = isset($_POST['sr_2']) && $_POST['sr_2'] !== $row['sr_2'] ? $_POST['sr_2'] : $row['sr_2'];
                        $sr_3 = isset($_POST['sr_3']) && $_POST['sr_3'] !== $row['sr_3'] ? $_POST['sr_3'] : $row['sr_3'];
                        $sr_4 = isset($_POST['sr_4']) && $_POST['sr_4'] !== $row['sr_4'] ? $_POST['sr_4'] : $row['sr_4'];
                        $sr_5 = isset($_POST['sr_5']) && $_POST['sr_5'] !== $row['sr_5'] ? $_POST['sr_5'] : $row['sr_5'];
                        $sr_6 = isset($_POST['sr_6']) && $_POST['sr_6'] !== $row['sr_6'] ? $_POST['sr_6'] : $row['sr_6'];
                        $sr_7 = isset($_POST['sr_7']) && $_POST['sr_7'] !== $row['sr_7'] ? $_POST['sr_7'] : $row['sr_7'];
                        $sr_8 = isset($_POST['sr_8']) && $_POST['sr_8'] !== $row['sr_8'] ? $_POST['sr_8'] : $row['sr_8'];
                        $sr_9 = isset($_POST['sr_9']) && $_POST['sr_9'] !== $row['sr_9'] ? $_POST['sr_9'] : $row['sr_9'];
                        $sr_10 = isset($_POST['sr_10']) && $_POST['sr_10'] !== $row['sr_10'] ? $_POST['sr_10'] : $row['sr_10'];
                    
                        $description_1 = isset($_POST['description_1']) && $_POST['description_1'] !== $row['description_1'] ? $_POST['description_1'] : $row['description_1'];
                        $description_2 = isset($_POST['description_2']) && $_POST['description_2'] !== $row['description_2'] ? $_POST['description_2'] : $row['description_2'];
                        $description_3 = isset($_POST['description_3']) && $_POST['description_3'] !== $row['description_3'] ? $_POST['description_3'] : $row['description_3'];
                        $description_4 = isset($_POST['description_4']) && $_POST['description_4'] !== $row['description_4'] ? $_POST['description_4'] : $row['description_4'];
                        $description_5 = isset($_POST['description_5']) && $_POST['description_5'] !== $row['description_5'] ? $_POST['description_5'] : $row['description_5'];
                        $description_6 = isset($_POST['description_6']) && $_POST['description_6'] !== $row['description_6'] ? $_POST['description_6'] : $row['description_6'];
                        $description_7 = isset($_POST['description_7']) && $_POST['description_7'] !== $row['description_7'] ? $_POST['description_7'] : $row['description_7'];
                        $description_8 = isset($_POST['description_8']) && $_POST['description_8'] !== $row['description_8'] ? $_POST['description_8'] : $row['description_8'];
                        $description_9 = isset($_POST['description_9']) && $_POST['description_9'] !== $row['description_9'] ? $_POST['description_9'] : $row['description_9'];
                        $description_10 = isset($_POST['description_10']) && $_POST['description_10'] !== $row['description_10'] ? $_POST['description_10'] : $row['description_10'];
                    
                        $purpose_1 = isset($_POST['purpose_1']) && $_POST['purpose_1'] !== $row['purpose_1'] ? $_POST['purpose_1'] : $row['purpose_1'];
                        $purpose_2 = isset($_POST['purpose_2']) && $_POST['purpose_2'] !== $row['purpose_2'] ? $_POST['purpose_2'] : $row['purpose_2'];
                        $purpose_3 = isset($_POST['purpose_3']) && $_POST['purpose_3'] !== $row['purpose_3'] ? $_POST['purpose_3'] : $row['purpose_3'];
                        $purpose_4 = isset($_POST['purpose_4']) && $_POST['purpose_4'] !== $row['purpose_4'] ? $_POST['purpose_4'] : $row['purpose_4'];
                        $purpose_5 = isset($_POST['purpose_5']) && $_POST['purpose_5'] !== $row['purpose_5'] ? $_POST['purpose_5'] : $row['purpose_5'];
                        $purpose_6 = isset($_POST['purpose_6']) && $_POST['purpose_6'] !== $row['purpose_6'] ? $_POST['purpose_6'] : $row['purpose_6'];
                        $purpose_7 = isset($_POST['purpose_7']) && $_POST['purpose_7'] !== $row['purpose_7'] ? $_POST['purpose_7'] : $row['purpose_7'];
                        $purpose_8 = isset($_POST['purpose_8']) && $_POST['purpose_8'] !== $row['purpose_8'] ? $_POST['purpose_8'] : $row['purpose_8'];
                        $purpose_9 = isset($_POST['purpose_9']) && $_POST['purpose_9'] !== $row['purpose_9'] ? $_POST['purpose_9'] : $row['purpose_9'];
                        $purpose_10 = isset($_POST['purpose_10']) && $_POST['purpose_10'] !== $row['purpose_10'] ? $_POST['purpose_10'] : $row['purpose_10'];
                    
                    
                        $qty_1 = isset($_POST['qty_1']) && $_POST['qty_1'] !== $row['qty_1'] ? $_POST['qty_1'] : $row['qty_1'];
                        $qty_2 = isset($_POST['qty_2']) && $_POST['qty_2'] !== $row['qty_2'] ? $_POST['qty_2'] : $row['qty_2'];
                        $qty_3 = isset($_POST['qty_3']) && $_POST['qty_3'] !== $row['qty_3'] ? $_POST['qty_3'] : $row['qty_3'];
                        $qty_4 = isset($_POST['qty_4']) && $_POST['qty_4'] !== $row['qty_4'] ? $_POST['qty_4'] : $row['qty_4'];
                        $qty_5 = isset($_POST['qty_5']) && $_POST['qty_5'] !== $row['qty_5'] ? $_POST['qty_5'] : $row['qty_5'];
                        $qty_6 = isset($_POST['qty_6']) && $_POST['qty_6'] !== $row['qty_6'] ? $_POST['qty_6'] : $row['qty_6'];
                        $qty_7 = isset($_POST['qty_7']) && $_POST['qty_7'] !== $row['qty_7'] ? $_POST['qty_7'] : $row['qty_7'];
                        $qty_8 = isset($_POST['qty_8']) && $_POST['qty_8'] !== $row['qty_8'] ? $_POST['qty_8'] : $row['qty_8'];
                        $qty_9 = isset($_POST['qty_9']) && $_POST['qty_9'] !== $row['qty_9'] ? $_POST['qty_9'] : $row['qty_9'];
                        $qty_10 = isset($_POST['qty_10']) && $_POST['qty_10'] !== $row['qty_10'] ? $_POST['qty_10'] : $row['qty_10'];
                    
                        $price_1 = isset($_POST['price_1']) && $_POST['price_1'] !== $row['price_1'] ? $_POST['price_1'] : $row['price_1'];
                        $price_2 = isset($_POST['price_2']) && $_POST['price_2'] !== $row['price_2'] ? $_POST['price_2'] : $row['price_2'];
                        $price_3 = isset($_POST['price_3']) && $_POST['price_3'] !== $row['price_3'] ? $_POST['price_3'] : $row['price_3'];
                        $price_4 = isset($_POST['price_4']) && $_POST['price_4'] !== $row['price_4'] ? $_POST['price_4'] : $row['price_4'];
                        $price_5 = isset($_POST['price_5']) && $_POST['price_5'] !== $row['price_5'] ? $_POST['price_5'] : $row['price_5'];
                        $price_6 = isset($_POST['price_6']) && $_POST['price_6'] !== $row['price_6'] ? $_POST['price_6'] : $row['price_6'];
                        $price_7 = isset($_POST['price_7']) && $_POST['price_7'] !== $row['price_7'] ? $_POST['price_7'] : $row['price_7'];
                        $price_8 = isset($_POST['price_8']) && $_POST['price_8'] !== $row['price_8'] ? $_POST['price_8'] : $row['price_8'];
                        $price_9 = isset($_POST['price_9']) && $_POST['price_9'] !== $row['price_9'] ? $_POST['price_9'] : $row['price_9'];
                        $price_10 = isset($_POST['price_10']) && $_POST['price_10'] !== $row['price_10'] ? $_POST['price_10'] : $row['price_10'];
                    
                        $amount_1 = isset($_POST['amount_1']) && $_POST['amount_1'] !== $row['amount_1'] ? $_POST['amount_1'] : $row['amount_1'];
                        $amount_2 = isset($_POST['amount_2']) && $_POST['amount_2'] !== $row['amount_2'] ? $_POST['amount_2'] : $row['amount_2'];
                        $amount_3 = isset($_POST['amount_3']) && $_POST['amount_3'] !== $row['amount_3'] ? $_POST['amount_3'] : $row['amount_3'];
                        $amount_4 = isset($_POST['amount_4']) && $_POST['amount_4'] !== $row['amount_4'] ? $_POST['amount_4'] : $row['amount_4'];
                        $amount_5 = isset($_POST['amount_5']) && $_POST['amount_5'] !== $row['amount_5'] ? $_POST['amount_5'] : $row['amount_5'];
                        $amount_6 = isset($_POST['amount_6']) && $_POST['amount_6'] !== $row['amount_6'] ? $_POST['amount_6'] : $row['amount_6'];
                        $amount_7 = isset($_POST['amount_7']) && $_POST['amount_7'] !== $row['amount_7'] ? $_POST['amount_7'] : $row['amount_7'];
                        $amount_8 = isset($_POST['amount_8']) && $_POST['amount_8'] !== $row['amount_8'] ? $_POST['amount_8'] : $row['amount_8'];
                        $amount_9 = isset($_POST['amount_9']) && $_POST['amount_9'] !== $row['amount_9'] ? $_POST['amount_9'] : $row['amount_9'];
                        $amount_10 = isset($_POST['amount_10']) && $_POST['amount_10'] !== $row['amount_10'] ? $_POST['amount_10'] : $row['amount_10'];
                    
                    
                    
                        // dispose new end
                      
                        $update_query = "UPDATE cash_purchase SET 
                    
                                          purchase_date = '$f_purchase_date',
                             
                                          dc_disposition_date = '$dc_disposition_date'
                            
                    
                    
                                            WHERE id = '$id'";
                    
                    
                    $result = mysqli_query($conn, $update_query);
                    
                    if ($result) {
                    // Insert a row in asset_transfer_log
                    $insert_log_query = "INSERT INTO asset_transfer_log 
                    (asset_tag_number,at_rc_name,at_rc_no,at_department,at_room,at_transfer_prepared_by,at_reason,at_owner_code,at_comments)
                     VALUES
                      ('$f_asset_tag_number','$at_rc_name','$at_rc_no','$at_department_code','$at_room','$at_transfer_prepared_by','$at_reason','$at_owner_code','$at_comments')";
                    
                    $log_result = mysqli_query($conn, $insert_log_query);
                    
                    if ($log_result) {
                    echo "<script>
                    alert('Asset updated and transfer log inserted.');
                    window.location.href = window.location.href;
                    </script>";
                    } else {
                    echo "<script>
                    alert('Asset updated, but failed to insert transfer log.');
                    window.location.href = window.location.href;
                    </script>";
                    }
                    }
                    
                        else {
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
            $('#myTable').tableExport({ type: 'excel',ignoreColumn: [] });
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
        <!-- 2-->
        <script>
            function promptReason2(itemId) {
                var reason = prompt("Enter reason for rejection:");
                if (reason != null && reason.trim() !== "") {
                    window.location.href = "ot_fpna_reject_2.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
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