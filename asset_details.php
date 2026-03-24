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
    <title>MedicsFlow</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
    <?php
    include 'cdncss.php'
        ?>
    <style>
        .btn {
            font-size: 11px !important;
            color: white !important;
            border-radius: 0px !important;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        .btn-menu {
            background-color: #06923E !important;
            color: white !important;
            border-radius: 0px !important;
            font-size: 11px !important;
        }

        .btn-menu:hover {
            background-color: #06923E !important;
            color: white !important;
            border-radius: 0px !important;
            font-size: 11px !important;
        }

        .sub-by {
            font-weight: bold !important;
        }

        a {
            text-decoration: none;
            color: white
        }

        a:hover {
            text-decoration: none;
            color: white
        }

        p {
            font-size: 11.5px !important;
            padding: 0px !important;
            margin: 0px !important;
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
            height: 25px !important;
        }

        input:focus {
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
        }

        select {
            width: 100% !important;
            font-size: 11px;
            border-radius: 0px;
            border: 1px solid grey;
            transition: border-color 0.3s ease;
            padding: 2.5px 5px;
            letter-spacing: 0.4px;
            height: 25px !important;
        }

        option {
            width: 100% !important;
            font-size: 11px;
            border-radius: 0px;
            border: 1px solid grey;
            transition: border-color 0.3s ease;
            padding: 2.5px 5px;
            letter-spacing: 0.4px;
            height: 25px !important;
        }

        .slide {
            position: relative;
            overflow: hidden;
            background-color: #7868E6;
            /* initial purple */
            border: 2px solid #4B2C91;
            /* dark purple border */
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

        /* White overlay sliding animation */
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

        /* Hover effects */
        .slide:hover::before {
            transform: translateX(-5%) skew(-15deg);
            /* slide overlay */
        }

        .slide:hover .text {
            color: #4B2C91;
            /* text color matches border on hover */
        }
    </style>
    <?php
    include 'sidebarcss.php'
        ?>
    <style>
        /* Remove default arrow */
        .accordion-button::after {
            display: none !important;
        }

        /* Optional: add spacing between icon and text */
        .accordion-button .custom-arrow {
            color: white;
            margin-left: 10px;
            font-size: 14px;
        }
    </style>
    <style>
        .table-log th {
            background-color: #AEDEFC !important;
            position: sticky;
            top: 0;
            z-index: 1000;
            font-size: 10px;
            text-align: left;
            letter-spacing: 0.4px;
            font-weight: 600;
        }

        .table-log td {
            font-size: 10px;
            color: black !important;
            padding: 5px 10px !important;
            border: 1px solid #ddd;
            letter-spacing: 0.2px;
        }
    </style>
    <!-- toggle button start  -->
    <style>
        .btn-toggle {
            padding: 10px 20px;
            margin-right: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .toggle-box {
            display: none;
            margin-top: 10px;
            padding: 10px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
        }
    </style>
    <!-- toggle button end -->
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
                    <button type="button" id="sidebarCollapse" class="btn btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </nav>
            <?php
            include 'dbconfig.php';


            $id = $_GET['id'];
            $select = "SELECT * FROM assets WHERE
                    id = '$id' ";

            $select_q = mysqli_query($conn, $select);
            $data = mysqli_num_rows($select_q);
            ?>
            <?php
            if ($data) {
                while ($row = mysqli_fetch_array($select_q)) {
                    ?>
                    <div class="container">
                        <form class="form pb-3" method="POST">
                            <div class="row">
                                <div class="col-12 p-5" Style="border:1px solid black; background-color:white;padding:20px">
                                    <div class="position-relative mb-4" style="min-height: 40px;">
                                        <!-- Flex container to position buttons and center heading -->
                                        <div class="d-flex align-items-center position-relative" style="min-height: 40px;">
                                            <!-- Left-aligned buttons -->
                                            <div class="z-1">
                                                <a class="btn btn-dark btn-sm me-2" href="assets_management_home.php"
                                                    style="font-size:11px!important">
                                                    <i class="fa-solid fa-home"></i> Home
                                                </a>
                                                <a class="btn btn-dark btn-sm me-2" href="assets_list.php"
                                                    style="font-size:11px!important">
                                                    <i class="fa-solid fa-list"></i> Back
                                                </a>
                                            </div>
                                            <!-- Centered heading -->
                                            <h6
                                                class="position-absolute top-50 start-50 translate-middle text-center mb-0 fw-bold">
                                                <span class="text-primary"><?php echo $row['name_description'] ?></span>
                                                <span>(<?php echo $row['asset_tag_number'] ?>)</span>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="pb-4">
                                        <p>
                                            <?php echo $row['user_name'] ?> - <span class="pl-3">
                                                <?php echo $row['user_date'] ?></span>
                                        </p>
                                        <p>
                                            <?php echo $row['user_department'] ?> - <span
                                                class="pl-3"><?php echo $row['user_role'] ?> </span>
                                        </p>
                                    </div>
                                    <div class="row pb-2">
                                        <div class="col-md-4">
                                            <p>Purchase Date</p>
                                            <input type="text" name="purchase_date" value="<?php echo $row['purchase_date']; ?>"
                                                class="w-100">
                                        </div>
                                        <div class="col-md-4">
                                            <p>Invoice Number</p>
                                            <input type="text" name="invoice_number"
                                                value="<?php echo $row['invoice_number']; ?>" class="w-100">
                                        </div>
                                    </div>
                                    <div class="row pb-2 ">
                                        <div class="col-md-4">
                                            <p>Asset Location</p>
                                            <input type="text" name="asset_location"
                                                value="<?php echo $row['asset_location']; ?>" class="w-100">
                                        </div>
                                        <div class="col-md-4">
                                            <p>Supplier Name</p>
                                            <input type="text" name="supplier_name" value="<?php echo $row['supplier_name']; ?>"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <p class="py-3" style="font-size:13.5px!important"><b>Following Assets Received</b></p>
                                    <div class="row pb-2">
                                        <div class="col-md-4">
                                            <p>Asset Tag Number</p>
                                            <input type="text" name="asset_tag_number"
                                                value="<?php echo $row['asset_tag_number']; ?>" class="w-100">
                                        </div>
                                        <div class="col-md-4">
                                            <p>Quantity</p>
                                            <input type="text" name="quantity" value="<?php echo $row['quantity']; ?>"
                                                class="w-100">
                                        </div>
                                        <div class="col-md-4">
                                            <p>Serial Number</p>
                                            <input type="text" name="s_no" value="<?php echo $row['s_no']; ?>" class="w-100">
                                        </div>
                                    </div>
                                    <div class="row pb-2">
                                        <div class="col-md-8">
                                            <p>Asset Name</p>
                                            <input type="text" name="name_description"
                                                value="<?php echo $row['name_description']; ?>" class="w-100">
                                        </div>
                                        <div class="col-md-4">
                                            <p>Model</p>
                                            <input type="text" name="Model" value="<?php echo $row['model']; ?>" class="w-100">
                                        </div>
                                    </div>
                                    <div class="row pb-2">
                                        <div class="col-md-4">
                                            <p>Capacity/Usage</p>
                                            <input type="text" name="usage" value="<?php echo $row['usage']; ?>" class="w-100">
                                        </div>
                                        <div class="col-md-4">
                                            <p>Cost</p>
                                            <input type="number" name="cost" value="<?php echo $row['cost']; ?>" class="w-100">
                                        </div>
                                         <div class="col-md-4">
                                            <p>Fair Market Value</p>
                                            <input type="number" name="fair_market_value" value="<?php echo $row['fair_market_value']; ?>" class="w-100">
                                        </div>
                                        <div class="col-md-4">
                                            <p>Owner Code</p>
                                            <input type="text" name="owner_code" value="<?php echo $row['owner_code']; ?>"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="row pb-2">
                                        <div class="col-md-4">
                                            <p>Department Location</p>
                                            <input type="text" name="department_location"
                                                value="<?php echo $row['department_location']; ?>" class="w-100">
                                        </div>
                                        <div class="col-md-8">
                                            <p>Comments</p>
                                            <input type="text" name="comments" value="<?php echo $row['comments']; ?>"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="row pb-2">
                                    </div>
                                    <div class="row pb-2">
                                        <div class="col-md-4">
                                            <p>PO Finance Approval</p>
                                            <input type="text" name="po_approve_status"
                                                value="<?php echo $row['po_approve_status']; ?>" class="w-100">
                                        </div>
                                        <div class="col-md-4">
                                            <p>Status</p>
                                            <?php
                                            $final_status = $row['final_status'];
                                            $valid_statuses = [
                                                "Active",
                                                "Available",
                                                "Disposed",
                                                "Damaged",
                                                "Under Maintenance",
                                                "Pending Approval"
                                            ];
                                            $is_valid = in_array($final_status, $valid_statuses);
                                            ?>
                                            <select name="final_status" class="w-100" id="final_status">
                                                <option value="" disabled <?= $is_valid ? '' : 'selected' ?>>Select Status
                                                </option>
                                                <?php foreach ($valid_statuses as $status): ?>
                                                    <option value="<?= $status ?>" <?= ($final_status === $status) ? 'selected' : '' ?>>
                                                        <?= $status ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <?php if ($final_status !== "Disposed"): ?>
                                                <p>&nbsp;</p>
                                                <!-- Add top label space to match Status -->
                                                <a href="asset_dispose_form.php?id=<?= $row['id']; ?>"
                                                    class="btn btn-danger w-100 text-start">
                                                    <i class="fa-solid fa-dumpster"></i> Dispose This Asset
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="mt-3 justify-content-center text-center">
                                        <?php if (in_array(strtolower(trim($final_status)), ['disposed', 'disposal'])): ?>
                                            <button type="button" class="btn-toggle"
                                                style="font-size: 13px; padding: 11px; background-color:#DC2525"
                                                onclick="toggleBox('box1', this)">
                                                <i class="fas fa-trash-alt me-2"></i> Disposal Details
                                                <i class="fas fa-chevron-down ms-2 arrow-icon"></i>
                                            </button>
                                        <?php endif; ?>
                                        <button type="button" class="btn-toggle"
                                            style="font-size: 13px; padding: 11px; background-color:#437057"
                                            onclick="toggleBox('box2', this)">
                                            <i class="fas fa-info-circle me-2"></i> Other Details
                                            <i class="fas fa-chevron-down ms-2 arrow-icon"></i>
                                        </button>
                                        <button type="button" class="btn-toggle"
                                            style="font-size: 13px; padding: 11px; background-color:#456882"
                                            onclick="toggleBox('box3', this)">
                                            <i class="fas fa-exchange-alt me-2"></i> Transfer Details
                                            <i class="fas fa-chevron-down ms-2 arrow-icon"></i>
                                        </button>
                                    </div>
                                    <!-- Boxes -->
                                    <div id="box1" class="toggle-box"
                                        style="background-color: white!important; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);">
                                        <!-- content 1 start  -->
                                        <!-- START: Disposal Details Content -->
                                        <h6 class="text-center pt-2 pb-1"><b>Disposal Details</b></h6>

                                        <!-- dc new 1 -->
                                        <div class="row pb-2 pt-3">
                                            <div class="col-md-4">
                                                <p>Disposal Department</p>
                                                <input type="text" name="dc_disposal_department"
                                                    value="<?php echo $row['dc_disposal_department']; ?>" class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Applicant</p>
                                                <input type="text" name="dc_applicant"
                                                    value="<?php echo $row['dc_applicant']; ?>" class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Date of disposal</p>
                                                <input type="date" name="dc_date_of_application"
                                                    value="<?php echo $row['dc_date_of_application']; ?>" class="w-100">
                                            </div>
                                        </div>

                                        <!-- dc new 2 -->
                                        <div class="row pb-2 pt-3">
                                            <div class="col-md-4">
                                                <p>Asset Name</p>
                                                <input type="text" name="dc_name" value="<?php echo $row['dc_name']; ?>"
                                                    class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Asset Tag Number</p>
                                                <input type="text" name="dc_asset_number"
                                                    value="<?php echo $row['dc_asset_number']; ?>" class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Date of Purchase</p>
                                                <input type="text" name="dc_date_of_purchase"
                                                    value="<?php echo $row['dc_date_of_purchase']; ?>" class="w-100">
                                            </div>
                                        </div>

                                        <!-- dc new 3 -->
                                        <div class="row pb-2 pt-3">
                                            <div class="col-md-4">
                                                <p>Quantity</p>
                                                <input type="text" name="dc_quantity" value="<?php echo $row['dc_quantity']; ?>"
                                                    class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Brand Specification</p>
                                                <input type="text" name="dc_brand_specification"
                                                    value="<?php echo $row['dc_brand_specification']; ?>" class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Disposal Date</p>
                                                <input type="text" name="dc_disposition_date"
                                                    value="<?php echo $row['dc_disposition_date']; ?>" class="w-100">
                                            </div>
                                        </div>





                                        <div class="row pb-2 pt-3">
                                            <div class="col-md-4">
                                                <p>Original Value</p>
                                                <input type="text" name="dc_original_value"
                                                    value="<?php echo $row['dc_original_value']; ?>" class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Depreciation Value</p>
                                                <input type="text" name="dc_depreciation_value"
                                                    value="<?php echo $row['dc_depreciation_value']; ?>" class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Net Worth</p>
                                                <input type="text" name="dc_networth" value="<?php echo $row['dc_networth']; ?>"
                                                    class="w-100">
                                            </div>
                                        </div>
                                        <div class="row pb-2">
                                            <div class="col-md-4">
                                                <p>Disposal Reason</p>
                                                <input type="text" name="dc_disposal_reason"
                                                    value="<?php echo $row['dc_disposal_reason']; ?>" class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Department Head Opinion</p>
                                                <input type="text" name="dc_department_head_opinion"
                                                    value="<?php echo $row['dc_department_head_opinion']; ?>" class="w-100">
                                            </div>
                                        </div>
                                        <?php $dc_disposal_method = $row['dc_disposal_method']; ?>
                                        <div class="row">
                                            <div class="col">
                                                <h6 style="font-size:13.5px" class="pb-1">Disposal Method</h6>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th style="background-color:#AEDEFC;color:black;font-size:13px">Sold
                                                            </th>
                                                            <th style="background-color:#AEDEFC;color:black;font-size:13px">
                                                                Scrapped</th>
                                                            <th style="background-color:#AEDEFC;color:black;font-size:13px">
                                                                Destroyed</th>
                                                            <th style="background-color:#AEDEFC;color:black;font-size:13px">Lost
                                                            </th>
                                                            <th style="background-color:#AEDEFC;color:black;font-size:13px">Idle
                                                            </th>
                                                            <th style="background-color:#AEDEFC;color:black;font-size:13px">
                                                                Other</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input type="radio" name="dc_disposal_method" value="Sold" <?php if ($dc_disposal_method == 'Sold')
                                                                echo 'checked'; ?>></td>
                                                            <td><input type="radio" name="dc_disposal_method" value="Scrapped"
                                                                    <?php if ($dc_disposal_method == 'Scrapped')
                                                                        echo 'checked'; ?>></td>
                                                            <td><input type="radio" name="dc_disposal_method" value="Destroyed"
                                                                    <?php if ($dc_disposal_method == 'Destroyed')
                                                                        echo 'checked'; ?>></td>
                                                            <td><input type="radio" name="dc_disposal_method" value="Lost" <?php if ($dc_disposal_method == 'Lost')
                                                                echo 'checked'; ?>></td>
                                                            <td><input type="radio" name="dc_disposal_method" value="Idle" <?php if ($dc_disposal_method == 'Idle')
                                                                echo 'checked'; ?>></td>
                                                            <td><input type="radio" name="dc_disposal_method" value="Other"
                                                                    <?php if ($dc_disposal_method == 'Other')
                                                                        echo 'checked'; ?>>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
   
                                    </div>
                                    <div id="box2" class="toggle-box"
                                        style="background-color: white!important; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);">
                                        <h6 class="text-center pt-2 pb-1"><b>Other Details</b></h6>
                                        <div class="row pb-2 justify-content-center">
                                            <div class="col-md-4">
                                                <p>Grn</p>
                                                <input type="text" name="grn" value="<?php echo $row['grn']; ?>" class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>PO Number</p>
                                                <input type="text" name="po_no" value="<?php echo $row['po_no']; ?>"
                                                    class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>PO Date</p>
                                                <input type="date" name="po_date" value="<?php echo $row['po_date']; ?>"
                                                    class="w-100">
                                            </div>
                                        </div>
                                        <!-- Continue with the rest of your input fields -->
                                        <!-- Repeat your remaining rows below -->
                                        <div class="row pb-2 justify-content-center">
                                            <div class="col-md-4">
                                                <p>Remarks1</p>
                                                <input type="text" name="remarks" value="<?php echo $row['remarks']; ?>"
                                                    class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Type</p>
                                                <input type="text" name="type" value="<?php echo $row['type']; ?>"
                                                    class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Comments</p>
                                                <input type="text" name="f_comments" value="<?php echo $row['f_comments']; ?>"
                                                    class="w-100">
                                            </div>
                                        </div>
                                        <!-- Add your other rows here as needed -->
                                        <!-- Example -->
                                        <div class="row pb-2 justify-content-center">
                                            <div class="col-md-4">
                                                <p>Part of machine</p>
                                                <input type="text" name="part_of_machine"
                                                    value="<?php echo $row['part_of_machine']; ?>" class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Old Code</p>
                                                <input type="text" name="old_code" value="<?php echo $row['old_code']; ?>"
                                                    class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>New Code</p>
                                                <input type="text" name="new_code" value="<?php echo $row['new_code']; ?>"
                                                    class="w-100">
                                            </div>
                                        </div>
                                        <!-- Remaining fields -->
                                        <div class="row pb-2">
                                            <div class="col-md-4">
                                                <p>Asset Class</p>
                                                <input type="text" name="asset_class" value="<?php echo $row['asset_class']; ?>"
                                                    class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Origin</p>
                                                <input type="text" name="origin" value="<?php echo $row['origin']; ?>"
                                                    class="w-100">
                                            </div>
                                        </div>
                                        <div class="row pb-2">
                                            <div class="col-md-4">
                                                <p>Remarks2</p>
                                                <input type="text" name="remarks2" value="<?php echo $row['remarks2']; ?>"
                                                    class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Part of far</p>
                                                <input type="text" name="part_of_far" value="<?php echo $row['part_of_far']; ?>"
                                                    class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Department</p>
                                                <input type="text" name="department2" value="<?php echo $row['department2']; ?>"
                                                    class="w-100">
                                            </div>
                                        </div>
                                        <div class="row pb-2">
                                            <div class="col-md-4 pb-2">
                                                <p>Unique Nuim</p>
                                                <input type="text" name="unique_nuim" value="<?php echo $row['unique_nuim']; ?>"
                                                    class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Item Desc</p>
                                                <input type="text" name="item_description"
                                                    value="<?php echo $row['item_description']; ?>" class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Balance</p>
                                                <input type="text" name="balances" value="<?php echo $row['balances']; ?>"
                                                    class="w-100">
                                            </div>
                                        </div>
                                        <div class="row pb-2">
                                            <div class="col-md-4">
                                                <p>Available Amount</p>
                                                <input type="text" name="available_amount"
                                                    value="<?php echo $row['available_amount']; ?>" class="w-100">
                                            </div>
                                            <div class="col-md-4 pb-2">
                                                <p>Department name</p>
                                                <input type="text" name="department_name"
                                                    value="<?php echo $row['department_name']; ?>" class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Category</p>
                                                <input type="text" name="category" value="<?php echo $row['category']; ?>"
                                                    class="w-100">
                                            </div>
                                        </div>

                                    </div>
                                    <div id="box3" class="toggle-box"
                                        style="background-color: white!important; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);">
                 
                                        <h6 class="text-center pt-2 pb-1"><b>Transfer Details</b></h6>

                                        <div class="row pb-2 justify-content-center">
                                            <div class="col-md-4">
                                                <p>Receiving Custodian Name</p>
                                                <input type="text" name="at_rc_name" value="<?php echo $row['at_rc_name']; ?>"
                                                    class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Receiving Custodian No.</p>
                                                <input type="text" name="at_rc_no" value="<?php echo $row['at_rc_no']; ?>"
                                                    class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Department</p>
                                                <select name="at_department_code" id="at_department_code" class="w-100">
                                                    <?php
                                                    $selected_department = $row['at_department'] ?? ''; // The already saved value from DB
                                            
                                                    // Show "Please select" only if nothing is selected
                                                    if (empty($selected_department)) {
                                                        echo '<option value="" selected disabled>Please select</option>';
                                                    }

                                                    include 'dbconfig.php';
                                                    $select = "SELECT * FROM department";
                                                    $select_q = mysqli_query($conn, $select);
                                                    if (mysqli_num_rows($select_q) > 0) {
                                                        while ($row1 = mysqli_fetch_assoc($select_q)) {
                                                            $dept_name = $row1['department_name'];
                                                            $selected = ($dept_name === $selected_department) ? 'selected' : '';
                                                            echo '<option value="' . $dept_name . '" ' . $selected . '>' . $dept_name . '</option>';
                                                        }
                                                    } else {
                                                        echo '<option value="">No department found</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row pb-2 justify-content-center">
                                            <div class="col-md-4">
                                                <p>Reason</p>
                                                <input type="text" name="at_reason" value="<?php echo $row['at_reason']; ?>"
                                                    class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Transfer Prepared By</p>
                                                <input type="text" name="at_transfer_prepared_by"
                                                    value="<?php echo $row['at_transfer_prepared_by']; ?>" class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Room</p>
                                                <input type="text" name="at_room" value="<?php echo $row['at_room']; ?>"
                                                    class="w-100">
                                            </div>
                                        </div>
                                        <!-- END: Transfer Details Content -->
                                        <div class="row pb-2">
                                            <div class="col-md-4">
                                                <p>Owner Code</p>
                                                <input type="text" name="at_owner_code"
                                                    value="<?php echo $row['at_owner_code']; ?>" class="w-100">
                                            </div>
                                            <div class="col-md-4">
                                                <p>Comments</p>
                                                <input type="text" name="at_comments" value="<?php echo $row['at_comments']; ?>"
                                                    class="w-100">
                                            </div>
                                        </div>
                                        <?php
                                        $tag_number = $row['asset_tag_number'];
                                        $log_query = "SELECT * FROM asset_transfer_log WHERE asset_tag_number = '$tag_number' ORDER BY id DESC";
                                        $log_result = mysqli_query($conn, $log_query);
                                        ?>
                                        <p class="text-center mt-3"><b>Transfer Log</b></p>
                                        <table class="table table-bordered mt-1 table-hover table-log">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <th>Asset Tag No</th>
                                                    <th>Receiving Custodian Name</th>
                                                    <th>Receiving Custodian No</th>
                                                    <th>Department</th>
                                                    <th>Reason</th>
                                                    <th>Transfer By</th>
                                                    <th>Room</th>
                                                    <th>Owner Code</th>
                                                    <th>Comments</th>
                                                    <th>Ref id</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (mysqli_num_rows($log_result) > 0): ?>
                                                    <?php while ($log = mysqli_fetch_assoc($log_result)): ?>
                                                        <tr>
                                                            <td><?= $log['asset_tag_number'] ?></td>
                                                            <td><?= $log['at_rc_name'] ?></td>
                                                            <td><?= $log['at_rc_no'] ?></td>
                                                            <td><?= $log['at_department'] ?></td>
                                                            <td><?= $log['at_reason'] ?></td>
                                                            <td><?= $log['at_transfer_prepared_by'] ?></td>
                                                            <td><?= $log['at_room'] ?></td>
                                                            <td><?= $log['at_owner_code'] ?></td>
                                                            <td><?= $log['at_comments'] ?></td>
                                                            <td><?= $log['id'] ?></td>
                                                        </tr>
                                                    <?php endwhile; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="10" class="text-center">No transfer logs found for this asset.
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <script>
                                    function toggleBox(id) {
                                        const box = document.getElementById(id);
                                        box.style.display = box.style.display === 'block' ? 'none' : 'block';
                                    }
                                </script>
                     
                                <div class="text-center mt-3">
                                    <button class="slide" name="submit" style="font-size: 17px; height: 36px; width: 150px;">
                                        <span class="text">Update</span>
                                    </button>
                                </div>
                            </div>
                     
                    </div>
                </div>
            </div>
            </div>
            </div>
            </div>
            </form>
            </div>
            <?php
            include 'dbconfig.php';

            if (isset($_POST['submit'])) {
                $id = $_GET['id'];  
                $name = $_SESSION['fullname'];

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
                $f_department_location = isset($_POST['department_location']) && $_POST['department_location'] !== $row['department_location'] ? $_POST['department_location'] : $row['department_location'];
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

                $grn = isset($_POST['grn']) && $_POST['grn'] !== $row['grn'] ? $_POST['grn'] : $row['grn'];
                $po_no = isset($_POST['po_no']) && $_POST['po_no'] !== $row['po_no'] ? $_POST['po_no'] : $row['po_no'];
                $po_date = isset($_POST['po_date']) && $_POST['po_date'] !== $row['po_date'] ? $_POST['po_date'] : $row['po_date'];

                // transfer starts 
                $at_rc_name = isset($_POST['at_rc_name']) && $_POST['at_rc_name'] !== $row['at_rc_name'] ? $_POST['at_rc_name'] : $row['at_rc_name'];
                $at_rc_no = isset($_POST['at_rc_no']) && $_POST['at_rc_no'] !== $row['at_rc_no'] ? $_POST['at_rc_no'] : $row['at_rc_no'];
                $at_department_code = isset($_POST['at_department_code']) && $_POST['at_department_code'] !== $row['at_department_code'] ? $_POST['at_department_code'] : $row['at_department_code'];

                $at_room = isset($_POST['at_room']) && $_POST['at_room'] !== $row['at_room'] ? $_POST['at_room'] : $row['at_room'];
                $at_transfer_prepared_by = isset($_POST['at_transfer_prepared_by']) && $_POST['at_transfer_prepared_by'] !== $row['at_transfer_prepared_by'] ? $_POST['at_transfer_prepared_by'] : $row['at_rc_nat_transfer_prepared_byo'];
                $at_reason = isset($_POST['at_reason']) && $_POST['at_reason'] !== $row['at_reason'] ? $_POST['at_reason'] : $row['at_reason'];

                $at_owner_code = isset($_POST['at_owner_code']) && $_POST['at_owner_code'] !== $row['at_owner_code'] ? $_POST['at_owner_code'] : $row['at_owner_code'];
                $at_comments = isset($_POST['at_comments']) && $_POST['at_comments'] !== $row['at_comments'] ? $_POST['at_comments'] : $row['at_comments'];


                $final_status = isset($_POST['final_status']) && $_POST['final_status'] !== $row['final_status'] ? $_POST['final_status'] : $row['final_status'];

                // transfer ends
                $fair_market_value = isset($_POST['fair_market_value']) && $_POST['fair_market_value'] !== $row['fair_market_value'] ? $_POST['fair_market_value'] : $row['fair_market_value'];




                // dispose new start 
                $dc_disposal_department = isset($_POST['dc_disposal_department']) && $_POST['dc_disposal_department'] !== $row['dc_disposal_department'] ? $_POST['dc_disposal_department'] : $row['dc_disposal_department'];
                $dc_applicant = isset($_POST['dc_applicant']) && $_POST['dc_applicant'] !== $row['dc_applicant'] ? $_POST['dc_applicant'] : $row['dc_applicant'];
                $dc_date_of_application = isset($_POST['dc_date_of_application']) && $_POST['dc_date_of_application'] !== $row['dc_date_of_application'] ? $_POST['dc_date_of_application'] : $row['dc_date_of_application'];

                // transfer starts 
                $dc_name = isset($_POST['dc_name']) && $_POST['dc_name'] !== $row['dc_name'] ? $_POST['dc_name'] : $row['dc_name'];
                $at_rc_no = isset($_POST['dc_asset_number']) && $_POST['dc_asset_number'] !== $row['dc_asset_number'] ? $_POST['dc_asset_number'] : $row['dc_asset_number'];
                $dc_date_of_purchase = isset($_POST['dc_date_of_purchase']) && $_POST['dc_date_of_purchase'] !== $row['dc_date_of_purchase'] ? $_POST['dc_date_of_purchase'] : $row['dc_date_of_purchase'];

                $dc_quantity = isset($_POST['dc_quantity']) && $_POST['dc_quantity'] !== $row['dc_quantity'] ? $_POST['dc_quantity'] : $row['dc_quantity'];
                $dc_brand_specification = isset($_POST['dc_brand_specification']) && $_POST['dc_brand_specification'] !== $row['dc_brand_specification'] ? $_POST['dc_brand_specification'] : $row['dc_brand_specification'];
                $dc_disposition_date = isset($_POST['dc_disposition_date']) && $_POST['dc_disposition_date'] !== $row['dc_disposition_date'] ? $_POST['dc_disposition_date'] : $row['dc_disposition_date'];

                // dispose new end
    
                $update_query = "UPDATE assets SET 
            
                                  purchase_date = '$f_purchase_date',
                                  invoice_number = '$f_invoice_number',
                                  asset_location = '$f_asset_location',
                                  supplier_name = '$f_supplier_name',
                                  asset_tag_number = '$f_asset_tag_number',
            
                                  quantity = '$f_quantity',
                                  s_no = '$f_s_no',
                                  name_description = '$f_name_description',
                                  model = '$f_model',
                                  `usage` = '$f_usage',
            
                                  cost = '$f_cost',
                                  fair_market_value = '$fair_market_value',
                                  owner_code = '$f_owner_code',
                                  department_location = '$f_department_location',
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
                                  update_date = '$f_date',
            
                                grn = '$grn',
                                  po_no = '$po_no',
                                  po_date = '$po_date',
            
                                --   transfer starts
                                  at_rc_name = '$at_rc_name',
                                  at_rc_no = '$at_rc_no',
                                  at_department = '$at_department_code',
            
                                    at_room = '$at_room',
                                  at_transfer_prepared_by = '$at_transfer_prepared_by',
                                  at_reason = '$at_reason',
            
                                  at_owner_code = '$at_owner_code',
                                  at_comments = '$at_comments',
            
                                    final_status = '$final_status',

                                    dc_disposal_department = '$dc_disposal_department',
                                  dc_applicant = '$dc_applicant',
                                  dc_date_of_application = '$dc_date_of_application',
            
                                    dc_name = '$dc_name',
                                  dc_asset_number = '$dc_asset_number',
                                  dc_date_of_purchase = '$dc_date_of_purchase',

                                         dc_quantity = '$dc_quantity',
                                  dc_brand_specification = '$dc_brand_specification',
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
                } else {
                    echo "<script>
                    alert('Update Failed.');
                    window.location.href = window.location.href; // Reload the page
                  </script>";
                }
            }
            ?>
            </div>
            <?php
                }
            } else {
                echo "No record found!";
            }
            ?>
    </div>
    </div>
    <?php
    include 'footer.php'
        ?>