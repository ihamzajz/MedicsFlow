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
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


        <link rel="stylesheet" href="assets/css/style.css">
        <style>
        .btn{
            font-size: 11px!important;
            color:white!important;
            border-radius:0px!important;
            }
            body {
font-family: 'Poppins', sans-serif;
}
            .btn-menu{
            font-size: 11px;
            border-radius:0px;
            }
            .sub-by{
            font-weight:bold!important;
            }
            a
            {
            text-decoration:none;
            color:white
            }
            a:hover
            {
            text-decoration:none;
            color:white
            }
            p{
            font-size: 11.5px!important;
            padding: 0px!important;
            margin: 0px!important;
            font-weight: 500;
            }
            input {
            width: 100% !important;
            font-size: 12px; 
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
            select{
            width: 100% !important;
            font-size: 11px; 
            border-radius: 0px;
            border: 1px solid grey;
            transition: border-color 0.3s ease;
            padding: 2.5px 5px;
            letter-spacing: 0.4px; 
            height:25px!important;
            }
            option {
            width: 100% !important;
            font-size: 11px; 
            border-radius: 0px;
            border: 1px solid grey;
            transition: border-color 0.3s ease;
            padding: 2.5px 5px;
            letter-spacing: 0.4px; 
            height:25px!important; 
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
                        <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                        </button>
                    </div>
                </nav>
                <?php
                include 'dbconfig.php';
                
                
                $id=$_GET['id'];
                $select = "SELECT * FROM assets WHERE
                id = '$id' ";
                
                $select_q = mysqli_query($conn,$select);
                $data = mysqli_num_rows($select_q);
                ?>
                            <?php 
                if($data){
                	while ($row=mysqli_fetch_array($select_q)) {
                		?>
                <div class="container">
                    <form class="form pb-3" method="POST">
                        <div class="row">
                            <!-- col-1-starts -->
                            <div class="col-12 p-5" Style="border:1px solid black; background-color:white;padding:20px">
                                <h5 class="text-center pb-3 font-weight-bold"> <span style="float:left"><a class="btn btn-dark btn-sm" href="assets_management_home.php" style="font-size:11px!important"><i class="fa-solid fa-arrow-left"></i> Home</a></span>Asset Receipt Form # <?php echo $row['id']?></h5>
                                <div class="pb-4">
                                    <p class="sub-by">Submit by:</p>
                                    <p>
                                        <?php echo $row['user_name']?><span class="pl-3"> <?php echo $row['user_date']?></span>
                                    </p>
                                    <p>
                                        <?php echo $row['user_department']?><span class="pl-3"><?php echo $row['user_role']?> </span>
                                    </p>
                                </div>
                                <div class="row pb-2">
                                    <div class="col-md-4">
                                        <p>Purchase Date</p>
                                        <input type="text" name="purchase_date" value="<?php echo $row['purchase_date']; ?>" class="w-100">
                                    </div>
                                    <div class="col-md-4">
                                        <p>Invoice Number</p>
                                        <input type="text" name="invoice_number" value="<?php echo $row['invoice_number']; ?>" class="w-100">
                                    </div>
                                </div>
                                <div class="row pb-2 ">
                                    <div class="col-md-4">
                                        <p>Asset Location</p>
                                        <input type="text" name="asset_location" value="<?php echo $row['asset_location']; ?>" class="w-100">
                                    </div>
                                    <div class="col-md-4">
                                        <p>Supplier Name</p>
                                        <input type="text" name="supplier_name" value="<?php echo $row['supplier_name']; ?>" class="w-100">
                                    </div>
                                </div>
                                <h6 class="text-center py-3">Following Assets Received</h6>
                                <div class="row pb-2">
                                    <div class="col-md-4">
                                        <p>Asset Tag Number</p>
                                        <input type="text" name="asset_tag_number" value="<?php echo $row['asset_tag_number']; ?>" class="w-100">
                                    </div>
                                    <div class="col-md-4">
                                        <p>Quantity</p>
                                        <input type="text" name="quantity" value="<?php echo $row['quantity']; ?>" class="w-100">
                                    </div>
                                    <div class="col-md-4">
                                        <p>Serial Number</p>
                                        <input type="text" name="s_no" value="<?php echo $row['s_no']; ?>" class="w-100">
                                    </div>
                                </div>
                                <div class="row pb-2">
                                    <div class="col">
                                        <p>Name/Description</p>
                                        <input type="text" name="name_description" value="<?php echo $row['name_description']; ?>" class="w-100">
                                    </div>
                                </div>
                                <div class="row pb-2">
                                    <div class="col-md-4">
                                        <p>Model</p>
                                        <input type="text" name="Model" value="<?php echo $row['model']; ?>" class="w-100">
                                    </div>
                                    <div class="col-md-4">
                                        <p>Name/Description</p>
                                        <input type="text" name="usage" value="<?php echo $row['usage']; ?>" class="w-100">
                                    </div>
                                    <div class="col-md-4">
                                        <p>Cost</p>
                                        <input type="text" name="cost" value="<?php echo $row['cost']; ?>" class="w-100">
                                    </div>
                                </div>
                                <div class="row pb-2">
                                    <div class="col-md-4">
                                        <p>Owner Code</p>
                                        <input type="text" name="owner_code" value="<?php echo $row['owner_code']; ?>" class="w-100">
                                    </div>
                                    <div class="col-md-4">
                                        <p>Location</p>
                                        <input type="text" name="location" value="<?php echo $row['location']; ?>" class="w-100">
                                    </div>
                                </div>
                                <div class="row pb-2">
                                    <div class="col-12">
                                        <p>Comments</p>
                                        <input type="text" name="comments" value="<?php echo $row['comments']; ?>" class="w-100">
                                    </div>
                                </div>
                                <div class="row pb-2">
                                    <div class="col-12">
                                        <p>PO Finance Approval</p>
                                        <input type="text" name="po_approve_status" value="<?php echo $row['po_approve_status']; ?>" class="w-100"> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col p-5" Style="border:1px solid black; background-color:white">
                                <h5 class="text-center pb-3 font-weight-bold">Edit Data</h5>
                                <div class="row pb-2 justify-content-center">
                                    <div class="col-md-4">
                                        <p>Remarks1</p>
                                        <input type="text" name="remarks" value="<?php echo $row['remarks']; ?>" class="w-100"> 
                                    </div>
                                    <div class="col-md-4">
                                        <p>Type</p>
                                        <input type="text" name="type" value="<?php echo $row['type']; ?>" class="w-100">
                                    </div>
                                    <div class="col-md-4">
                                        <p>Comments</p>
                                        <input type="text" name="f_comments" value="<?php echo $row['f_comments']; ?>" class="w-100">
                                    </div>
                                </div>
                                <div class="row pb-2 justify-content-center">
                                    <div class="col-md-4">
                                        <p>Part of machine</p>
                                        <input type="text" name="part_of_machine" value="<?php echo $row['part_of_machine']; ?>" class="w-100">
                                    </div>
                                    <div class="col-md-4">
                                        <p>Old Code</p>
                                        <input type="text" name="old_code" value="<?php echo $row['old_code']; ?>" class="w-100"> 
                                    </div>
                                    <div class="col-md-4">
                                        <p>New Code</p>
                                        <input type="text" name="new_code" value="<?php echo $row['new_code']; ?>" class="w-100"> 
                                    </div>
                                </div>
                                <div class="row pb-2 justify-content-center">
                                    <div class="col-md-4">
                                        <p>Part of machine</p>
                                        <input type="text" name="part_of_machine" value="<?php echo $row['part_of_machine']; ?>" class="w-100">
                                    </div>
                                    <div class="col-md-4">
                                        <p>Old Code</p>
                                        <input type="text" name="old_code" value="<?php echo $row['old_code']; ?>" class="w-100"> 
                                    </div>
                                    <div class="col-md-4">
                                        <p>New Code</p>
                                        <input type="text" name="new_code" value="<?php echo $row['new_code']; ?>" class="w-100"> 
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col-md-4">
                                        <p>Asset Class</p>
                                        <input type="text" name="asset_class" value="<?php echo $row['asset_class']; ?>" class="w-100">
                                    </div>
                                    <div class="col-md-4">
                                        <p>Origin</p>
                                        <input type="text" name="origin" value="<?php echo $row['origin']; ?>" class="w-100"> 
                                    </div>
                                    <div class="col-md-4">
                                        <p>Status</p>
                                        <input type="text" name="status" value="<?php echo $row['status']; ?>" class="w-100">
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col-md-4">
                                        <p>Asset Class</p>
                                        <input type="text" name="asset_class" value="<?php echo $row['asset_class']; ?>" class="w-100"> 
                                    </div>
                                    <div class="col-md-4">
                                        <p>Origin</p>
                                        <input type="text" name="origin" value="<?php echo $row['origin']; ?>" class="w-100"> 
                                    </div>
                                    <div class="col-md-4">
                                        <p>Status</p>
                                        <input type="text" name="status" value="<?php echo $row['status']; ?>" class="w-100"> 
                                    </div>
                                </div>
                                <div class="row pb-2">
                                    <div class="col-md-4">
                                        <p>Remarks2</p>
                                        <input type="text" name="remarks2" value="<?php echo $row['remarks2']; ?>" class="w-100"> 
                                    </div>
                                    <div class="col-md-4">
                                        <p>Part of far</p>
                                        <input type="text" name="part_of_far" value="<?php echo $row['part_of_far']; ?>" class="w-100"> 
                                    </div>
                                    <div class="col-md-4">
                                        <p>Department</p>
                                        <input type="text" name="department2" value="<?php echo $row['department2']; ?>" class="w-100"> 
                                    </div>
                                </div>
                                <div class="row pb-2">
                                    <div class="col-md-4 pb-2">
                                        <p>Unique Nuim</p>
                                        <input type="text" name="unique_nuim" value="<?php echo $row['unique_nuim']; ?>" class="w-100"> 
                                    </div>
                                    <div class="col-md-4">
                                        <p>Item Desc</p>
                                        <input type="text" name="item_description" value="<?php echo $row['item_description']; ?>" class="w-100"> 
                                    </div>
                                    <div class="col-md-4">
                                        <p>Balance</p>
                                        <input type="text" name="balances" value="<?php echo $row['balances']; ?>" class="w-100"> 
                                    </div>
                                </div>
                                <div class="row pb-2">
                                    <div class="col-md-4">
                                        <p>Available Amount</p>
                                        <input type="text" name="available_amount" value="<?php echo $row['available_amount']; ?>" class="w-100">
                                    </div>
                                    <div class="col-md-4 pb-2">
                                        <p>Department name</p>
                                        <input type="text" name="department_name" value="<?php echo $row['department_name']; ?>" class="w-100"> 
                                    </div>
                                    <div class="col-md-4">
                                        <p>Category</p>
                                        <input type="text" name="category" value="<?php echo $row['category']; ?>" class="w-100"> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-sm btn-dark" name="submit">Submit</button>
                                </div>
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
                    
                        $f_purchase_date = isset($_POST['purchase_date']) && $_POST['purchase_date'] !== $row['purchase_date'] ? $_POST['purchase_date'] : $row['purchase_date'];
                        $f_invoice_number = isset($_POST['invoice_number']) && $_POST['invoice_number'] !== $row['invoice_number'] ? $_POST['invoice_number'] : $row['invoice_number'];
                        $f_asset_location = isset($_POST['asset_location']) && $_POST['asset_location'] !== $row['asset_location'] ? $_POST['asset_location'] : $row['asset_location'];
                        $f_supplier_name = isset($_POST['supplier_name']) && $_POST['supplier_name'] !== $row['supplier_name'] ? $_POST['supplier_name'] : $row['supplier_name'];
                        $f_asset_tag_number = isset($_POST['asset_tag_number']) && $_POST['asset_tag_number'] !== $row['asset_tag_number'] ? $_POST['asset_tag_number'] : $row['asset_tag_number'];
                         
                        $f_quantity = isset($_POST['quantity']) && $_POST['quantity'] !== $row['quantity'] ? $_POST['quantity'] : $row['quantity'];
                        $f_s_no = isset($_POST['s_no']) && $_POST['s_no'] !== $row['s_no'] ? $_POST['s_no'] : $row['s_no'];
                        $f_name_description = isset($_POST['name_description']) && $_POST['name_description'] !== $row['name_description'] ? $_POST['name_description'] : $row['name_description'];
                        $f_model = isset($_POST['model']) && $_POST['model'] !== $row['model'] ? $_POST['model'] : $row['model'];
                        $f_usage = isset($_POST['usage']) && $_POST['usage'] !== $row['usage'] ? $_POST['usage'] : $row['usage'];

                        $f_cost = isset($_POST['cost']) && $_POST['cost'] !== $row['cost'] ? $_POST['cost'] : $row['cost'];
                        $f_owner_code = isset($_POST['owner_code']) && $_POST['owner_code'] !== $row['owner_code'] ? $_POST['owner_code'] : $row['owner_code'];
                        $f_location = isset($_POST['location']) && $_POST['location'] !== $row['location'] ? $_POST['location'] : $row['name_description'];
                        $f_po_approve_status = isset($_POST['po_approve_status']) && $_POST['po_approve_status'] !== $row['po_approve_status'] ? $_POST['po_approve_status'] : $row['po_approve_status'];
                        $f_remarks = isset($_POST['remarks']) && $_POST['remarks'] !== $row['remarks'] ? $_POST['remarks'] : $row['remarks'];

                        $f_type = isset($_POST['type']) && $_POST['type'] !== $row['type'] ? $_POST['type'] : $row['type'];
                        $f_comments = isset($_POST['comments']) && $_POST['comments'] !== $row['comments'] ? $_POST['comments'] : $row['comments'];
                        $f_part_of_machine = isset($_POST['part_of_machine']) && $_POST['part_of_machine'] !== $row['part_of_machine'] ? $_POST['part_of_machine'] : $row['part_of_machine'];
                        $f_old_code = isset($_POST['old_code']) && $_POST['old_code'] !== $row['old_code'] ? $_POST['old_code'] : $row['old_code'];
                        $f_new_code = isset($_POST['new_code']) && $_POST['new_code'] !== $row['new_code'] ? $_POST['remarks'] : $row['new_code'];

                        $f_asset_class = isset($_POST['asset_class']) && $_POST['asset_class'] !== $row['asset_class'] ? $_POST['asset_class'] : $row['asset_class'];
                        $f_origin = isset($_POST['origin']) && $_POST['origin'] !== $row['origin'] ? $_POST['origin'] : $row['origin'];
                        $f_status = isset($_POST['status']) && $_POST['status'] !== $row['status'] ? $_POST['status'] : $row['status'];
                        $f_remarks2 = isset($_POST['remarks2']) && $_POST['remarks2'] !== $row['remarks2'] ? $_POST['remarks2'] : $row['remarks2'];
                        $f_part_of_far = isset($_POST['part_of_far']) && $_POST['part_of_far'] !== $row['part_of_far'] ? $_POST['part_of_far'] : $row['part_of_far'];

                        $f_department2 = isset($_POST['department2']) && $_POST['department2'] !== $row['department2'] ? $_POST['department2'] : $row['department2'];
                        $f_unique_nuim = isset($_POST['unique_nuim']) && $_POST['unique_nuim'] !== $row['unique_nuim'] ? $_POST['unique_nuim'] : $row['unique_nuim'];
                        $f_item_description = isset($_POST['item_description']) && $_POST['item_description'] !== $row['item_description'] ? $_POST['item_description'] : $row['item_description'];
                        $f_balances = isset($_POST['balances']) && $_POST['balances'] !== $row['balances'] ? $_POST['balances'] : $row['balances'];
                        $f_department_name = isset($_POST['department_name']) && $_POST['department_name'] !== $row['department_name'] ? $_POST['department_name'] : $row['department_name'];

                        $f_category = isset($_POST['category']) && $_POST['category'] !== $row['category'] ? $_POST['category'] : $row['category'];
                        $f_available_amount = isset($_POST['available_amount']) && $_POST['available_amount'] !== $row['available_amount'] ? $_POST['available_amount'] : $row['available_amount'];
                        $f_date = date('Y-m-d');

                      
                        $update_query = "UPDATE assets SET 
                    
                                          purchase_date = '$f_purchase_date',
                                          invoice_number = '$f_invoice_number',
                                          asset_location = '$f_asset_location',
                                          supplier_name = '$f_supplier_name',
                                          asset_tag_number = ' $f_asset_tag_number',
                    
                                          quantity = '$f_quantity',
                                          s_no = '$f_s_no',
                                          name_description = '$f_name_description',
                                          model = '$f_model',
                                          `usage` = '$f_usage',
                    
                                          cost = '$f_cost',
                                          owner_code = '$f_owner_code',
                                          location = '$f_location',
                                          po_approve_status = '$f_po_approve_status',
                                          remarks = '$f_remarks',
                    
                                          type = '$f_type',
                                          comments= '$f_comments',
                                          part_of_machine = '$f_part_of_machine',
                                          old_code = '$f_old_code',
                                          new_code = '$f_new_code',
                    
                                          asset_class = '$f_asset_class',
                                          origin = '$f_origin',
                                          status = '$f_status',
                                          remarks2 = '$f_remarks2',
                                          part_of_far = '$f_part_of_far',
                    
                                          unique_nuim = '$f_unique_nuim',
                                          item_description = '$f_item_description',
                                          balances = '$f_balances',
                                          department_name = '$f_department_name',
                                          category = '$f_category',
                    
                                          available_amount = '$f_available_amount',
                                          update_date = '$f_date'
                    
                                            WHERE id = '$id'";
                    
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
    </body>
</html>