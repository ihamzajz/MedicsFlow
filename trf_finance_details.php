<?php
    session_start();
    
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php');
        exit;
    }
    
    include 'dbconfig.php';
    
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    // --- Handle deletion of invoice images ---
    if(isset($_POST['delete_col'], $_POST['delete_index'], $_POST['id'])) {
        $col = $_POST['delete_col'];
        $index = intval($_POST['delete_index']);
        $id = intval($_POST['id']);
    
        $res = mysqli_query($conn, "SELECT `$col` FROM trf WHERE id='$id'");
        if($res && mysqli_num_rows($res) > 0){
            $row = mysqli_fetch_assoc($res);
            $invoices = json_decode($row[$col], true);
            if(!is_array($invoices)) $invoices = [];
    
            if(isset($invoices[$index])){
                $file = $invoices[$index];
                $fileDeleted = true;
                if(file_exists($file)){
                    $fileDeleted = unlink($file);
                }
    
                array_splice($invoices, $index, 1);
                $invoices_json = json_encode($invoices);
    
                $upd = mysqli_query($conn, "UPDATE trf SET `$col`='$invoices_json' WHERE id='$id'");
                echo ($upd && $fileDeleted) ? 'success' : 'fail: '.mysqli_error($conn);
            } else {
                echo 'fail: index not found';
            }
        } else {
            echo 'fail: no record found';
        }
        exit; // important
    }
    
    // --- Fetch the row ---
    $select_q = mysqli_query($conn, "SELECT * FROM trf WHERE id='$id'");
    if(!$select_q || mysqli_num_rows($select_q) == 0){
        echo "No record found!";
        exit;
    }
    $row = mysqli_fetch_assoc($select_q);
    
    // --- Handle form submit ---
    if(isset($_POST['submit'])) {
        $name = $_SESSION['fullname'];
        $date = date('Y-m-d H:i:s');
    
        function handleUploads($field, $oldData){
            $uploadsDir = "uploads/trf/";
            if(!file_exists($uploadsDir)) mkdir($uploadsDir, 0777, true);
    
            $existing = !empty($oldData) ? json_decode($oldData, true) : [];
            if(!is_array($existing)) $existing = [];
    
            if(!empty($_FILES[$field]['name'][0])){
                foreach($_FILES[$field]['tmp_name'] as $k=>$tmp){
                    if($_FILES[$field]['error'][$k] === UPLOAD_ERR_OK){
                        $filename = uniqid()."_".basename($_FILES[$field]['name'][$k]);
                        $target = $uploadsDir.$filename;
                        move_uploaded_file($tmp, $target);
                        $existing[] = $target;
                    }
                }
            }
            return json_encode($existing);
        }
    
        $fi_airline_invoice   = handleUploads("fi_airline_invoice", $row['fi_airline_invoice']);
        $fi_hotel_invoice     = handleUploads("fi_hotel_invoice", $row['fi_hotel_invoice']);
        $fi_transport_invoice = handleUploads("fi_transport_invoice", $row['fi_transport_invoice']);
        $fi_visa_invoice      = handleUploads("fi_visa_invoice", $row['fi_visa_invoice']);
        $fi_other_invoice     = handleUploads("fi_other_invoice", $row['fi_other_invoice']);
    
        $update_query = "UPDATE trf SET 
            fi_airline_ac_amount   = '{$_POST['fi_airline_ac_amount']}',
            fi_airline_est_amount  = '{$_POST['fi_airline_est_amount']}',
            fi_airline_invoice     = '$fi_airline_invoice',
            fi_airline_supplier    = '{$_POST['fi_airline_supplier']}',
            fi_airline_date        = '{$_POST['fi_airline_date']}',
            fi_hotel_ac_amount     = '{$_POST['fi_hotel_ac_amount']}',
            fi_hotel_est_amount    = '{$_POST['fi_hotel_est_amount']}',
            fi_hotel_invoice       = '$fi_hotel_invoice',
            fi_hotel_supplier      = '{$_POST['fi_hotel_supplier']}',
            fi_hotel_date          = '{$_POST['fi_hotel_date']}',
            fi_transport_ac_amount = '{$_POST['fi_transport_ac_amount']}',
            fi_transport_est_amount= '{$_POST['fi_transport_est_amount']}',
            fi_transport_invoice   = '$fi_transport_invoice',
            fi_transport_supplier  = '{$_POST['fi_transport_supplier']}',
            fi_transport_date      = '{$_POST['fi_transport_date']}',
            fi_visa_ac_amount      = '{$_POST['fi_visa_ac_amount']}',
            fi_visa_est_amount     = '{$_POST['fi_visa_est_amount']}',
            fi_visa_invoice        = '$fi_visa_invoice',
            fi_visa_supplier       = '{$_POST['fi_visa_supplier']}',
            fi_visa_date           = '{$_POST['fi_visa_date']}',
            fi_other_ac_amount     = '{$_POST['fi_other_ac_amount']}',
            fi_other_est_amount    = '{$_POST['fi_other_est_amount']}',
            fi_other_invoice       = '$fi_other_invoice',
            fi_other_supplier      = '{$_POST['fi_other_supplier']}',
            fi_other_date          = '{$_POST['fi_other_date']}',
            fi_total_amount1       = '{$_POST['fi_total_amount1']}',
            fi_total_amount2       = '{$_POST['fi_total_amount2']}',
            finance_date           = '$date',
            finance_name           = '$name',
            finance_status         = 'Approved'
            WHERE id='$id'";
    
        $result = mysqli_query($conn, $update_query);
        if($result){
            echo "<script>alert('Record updated successfully!'); window.location.href=window.location.href;</script>";
        } else {
            echo "<script>alert('Update failed!');</script>";
        }
    }
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MedicsFlow</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon1.png" />
        <!-- Bootstrap CSS CDN -->
        <?php
            include 'cdncss.php'
                ?>
        <style>
            body {
            font-family: 'Poppins', sans-serif;
            }
            .btn {
            font-size: 11px !important;
            border-radius: 0px !important;
            }
            p {
            font-size: 13px !important;
            padding: 0px !important;
            margin: 0px !important;
            font-weight: 600;
            }
            input {
            font-size: 13px !important;
            width: 100% !important;
            height: 25px !important;
            padding: 5px 5px !important;
            }
            textarea,
            select,
            option {
            font-size: 13px !important;
            width: 100% !important;
            height: 25px !important;
            padding: 5px 5px !important;
            }
            ::placeholder {
            color: black;
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
            /* Approve Button  */
            .btn-approve {
            white-space: nowrap !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            background-color: #D1E7DD;
            color: white !important;
            border-radius: 15px !important;
            transition: all 0.3s ease !important;
            padding: 4px 15px !important;
            color: black !important;
            border: 1px solid #198754 !important;
            }
            .btn-approve:hover {
            filter: brightness(85%);
            }
            /* Reject Button */
            .btn-reject {
            white-space: nowrap !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            background-color: #F8D7DA;
            color: white !important;
            border-radius: 15px !important;
            transition: all 0.3s ease !important;
            padding: 4px 15px !important;
            color: black !important;
            border: 1px solid #DC3545 !important;
            }
            .btn-reject:hover {
            filter: brightness(85%);
            }
        </style>
        <style>
            .table {
            border: 0.5px solid grey !important;
            }
            .table th {
            font-size: 12px !important;
            border: none !important;
            background-color: #1B7BBC !important;
            color: white !important;
            padding: 6px 5px !important;
            font-weight: 500;
            }
            .table td {
            font-size: 11px;
            color: black;
            padding: 7px 5px !important;
            font-weight: 500;
            border: none !important
            }
            .travel-desk1{
            font-size: 14px !important;
            }
        </style>
        <style>
            .btn-uploadevidence {
            font-size: 12px !important;
            font-weight: 500 !important;
            background-color: white;
            color: black !important;
            border-radius: 15px !important;
            transition: all 0.3s ease !important;
            padding: 4px 15px !important;
            border: 1px solid black !important;
            }
            .btn-uploadevidence:hover {
            filter: brightness(85%) !important;
            }
            .btn-viewevidence {
            font-size: 12px !important;
            font-weight: 500 !important;
            background-color: #7F7C82;
            color: white !important;
            border-radius: 15px !important;
            transition: all 0.3s ease !important;
            padding: 4px 15px !important;
            border: 1px solid black !important;
            }
            .btn-viewevidence:hover {
            filter: brightness(85%) !important;
            }
        </style>
        <?php
            include 'sidebarcss.php'
                ?>
    </head>
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
                    $select = "SELECT * FROM trf WHERE
                    id = '$id' ";
                    
                    $select_q = mysqli_query($conn,$select);
                    $data = mysqli_num_rows($select_q);
                    ?>
                <?php 
                    if($data){
                    	while ($row=mysqli_fetch_array($select_q)) {
                    		?>
                <div style="background-color: white!important;border:1px solid black!important; padding:20px!important"
                    class="m-5">
                    <div class="d-flex align-items-center justify-content-between">
                        <!-- Left Side Buttons -->
                        <div>
                            <a class="btn btn-dark btn-sm mt-1" href="trf_home.php" style="font-size:11px!important">
                            <i class="fa-solid fa-home"></i> Home
                            </a>
                            <a class="btn btn-dark btn-sm mt-1" href="trf_finance_list.php" style="font-size:11px!important">
                            <i class="fa-solid fa-arrow-left"></i> Back
                            </a>
                        </div>
                        <!-- Center Heading -->
                        <h5 class="m-0 text-center" style="flex:1; font-weight:600">
                            Trf # <?php echo $row['id'] ?>
                        </h5>
                        <!-- Right Side (optional, placeholder for now) -->
                        <div style="width:100px"></div>
                    </div>
                    <div class="row pb-2 pt-5">
                        <h6 class="fw-bold pb-2 text-primary">User Request</h6>
                        <div class="col-md-3 pb-2">
                            <p>Name:</p>
                            <input type="text" placeholder="<?php echo $row['name']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>Department:</p>
                            <input type="text" placeholder="<?php echo $row['department']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>Role:</p>
                            <input type="text" placeholder="<?php echo $row['role']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>Submission Date:</p>
                            <input type="text" placeholder="<?php echo $row['date']?>" readonly class="ready">
                        </div>
                    </div>
                    <!-- row 1 end-->
                    <div class="row pb-2">
                        <div class="col-md-6">
                            <p>Purpose of Travel</p>
                            <input type="text" placeholder="<?php echo $row['purpose']?>" readonly class="ready">
                        </div>
                        <div class="col-md-6">
                            <p>Reason</p>
                            <input type="text" placeholder="<?php echo $row['reason']?>" readonly class="ready">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 pb-2">
                            <p>Departure From</p>
                            <input type="text" placeholder="<?php echo $row['to_1']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>To</p>
                            <input type="text" placeholder="<?php echo $row['to_2']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>To</p>
                            <input type="text" placeholder="<?php echo $row['to_3']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>To</p>
                            <input type="text" placeholder="<?php echo $row['to_4']?>" readonly class="ready">
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-3">
                            <p>Preferable Date From</p>
                            <input type="text" placeholder="<?php echo $row['date_1']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>To</p>
                            <input type="text" placeholder="<?php echo $row['date_2']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>To</p>
                            <input type="text" placeholder="<?php echo $row['date_3']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>To</p>
                            <input type="text" placeholder="<?php echo $row['date_4']?>" readonly class="ready">
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-3">
                            <p>Preferable Time From</p>
                            <input type="text" placeholder="<?php echo $row['time_1']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>To</p>
                            <input type="text" placeholder="<?php echo $row['time_2']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>To</p>
                            <input type="text" placeholder="<?php echo $row['time_3']?>" readonly class="ready">
                        </div>
                        <div class="col-md-3">
                            <p>To</p>
                            <input type="text" placeholder="<?php echo $row['time_4']?>" readonly class="ready">
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-4">
                            <p>Preferable Flight</p>
                            <input type="text" placeholder="<?php echo $row['preferable_flight']?>" readonly class="ready">
                        </div>
                        <div class="col-md-4">
                            <p>Duration of Visit (In Days)</p>
                            <input type="text" placeholder="<?php echo $row['duration']?>" readonly class="ready">
                        </div>
                        <div class="col-md-4">
                            <p>Expected day of return</p>
                            <input type="text" placeholder="<?php echo $row['expected_days']?>" readonly class="ready">
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-4">
                            <p>Mode Of Travel</p>
                            <input type="text" placeholder="<?php echo $row['mode_of_travel']?>" readonly class="ready">
                        </div>
                        <div class="col-md-4">
                            <p>Hotel Booking Required</p>
                            <input type="text" placeholder="<?php echo $row['hotel_booking']?>" readonly class="ready">
                        </div>
                        <div class="col-md-4">
                            <p>Visa Required</p>
                            <input type="text" placeholder="<?php echo $row['visa_required']?>" readonly class="ready">
                        </div>
                    </div>
                    <p class=" py-2 fw-bold">Traveling Advance (For Finance Department)</p>
                    <div class="row pb-2">
                        <div class="col-md-6">
                            <p for="advance_required">Advance Required</p>
                            <input type="text" placeholder="<?php echo $row['advance_required']?>" readonly class="ready">
                        </div>
                        <div class="col-md-6">
                            <p for="advance_amount">Advance Amount (PKR)</p>
                            <input type="text" placeholder="<?php echo $row['advance_amount']?>" readonly class="ready">
                        </div>
                    </div>
                    <!-- fetch ends -->
                    <!-- final starts  -->
                    <h6 class="fw-bold pb-2 text-primary pt-4">Final Details By Admin</h6>
                    <div class="row pb-2">
                        <div class="col-md-3">
                            <p for="up_to_1">Departure from</p>
                            <input type="text" placeholder="<?php echo $row['admin_to_1']?>" readonly class="ready travel-desk">
                            </select>
                        </div>
                        <div class="col-md-3">
                            <p for="up_to_1">To</p>
                            <input type="text" placeholder="<?php echo $row['admin_to_2']?>" readonly class="ready travel-desk">
                        </div>
                        <div class="col-md-3">
                            <p for="up_to_2">To</p>
                            <input type="text" placeholder="<?php echo $row['admin_to_3']?>" readonly class="ready travel-desk">
                        </div>
                        <div class="col-md-3">
                            <p for="up_to_2">To</p>
                            <input type="text" placeholder="<?php echo $row['admin_to_4']?>" readonly class="ready travel-desk">
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-3">
                            <p for="up_date_1">Date From</p>
                            <input type="text" placeholder="<?php echo $row['admin_date_1']?>" readonly class="ready travel-desk">
                        </div>
                        <div class="col-md-3">
                            <p for="to_1">To</p>
                            <input type="text" placeholder="<?php echo $row['admin_date_2']?>" readonly class="ready travel-desk">
                        </div>
                        <div class="col-md-3">
                            <p for="up_to_2">To</p>
                            <input type="text" placeholder="<?php echo $row['admin_date_3']?>" readonly class="ready travel-desk">
                        </div>
                        <div class="col-md-3">
                            <p for="up_to_3">To</p>
                            <input type="text" placeholder="<?php echo $row['admin_date_4']?>" readonly class="ready travel-desk">
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-3">
                            <p for="up_date_1">Preferable Time From</p>
                            <input type="text" placeholder="<?php echo $row['admin_time_1']?>" readonly class="ready travel-desk">
                        </div>
                        <div class="col-md-3">
                            <p for="up_time_2">To</p>
                            <input type="text" placeholder="<?php echo $row['admin_time_2']?>" readonly class="ready travel-desk">
                        </div>
                        <div class="col-md-3">
                            <p for="up_time_3">To</p>
                            <input type="text" placeholder="<?php echo $row['admin_time_3']?>" readonly class="ready travel-desk">
                        </div>
                        <div class="col-md-3">
                            <p for="up_time_4">To</p>
                            <input type="text" placeholder="<?php echo $row['admin_time_4']?>" readonly class="ready travel-desk">
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-4">
                            <p for="up_preferable_flight">Preferable Flight</p>
                            <input type="text" placeholder="<?php echo $row['admin_flight_details']?>" readonly class="ready travel-desk">
                        </div>
                        <div class="col-md-4">
                            <p for="up_flight_nos">Flight Nos</p>
                            <input type="text" placeholder="<?php echo $row['admin_flight_nos']?>" readonly class="ready travel-desk">
                        </div>
                        <div class="col-md-4">
                            <p for="up_airline_cost">Airline Cost</p>
                            <input type="text" placeholder="<?php echo $row['admin_flight_cost']?>" readonly class="ready travel-desk">
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-4">
                            <p for="up_mode_of_travel">Hotel Cost</p>
                            <input type="text" placeholder="<?php echo $row['admin_hotel_cost']?>" readonly class="ready travel-desk">
                        </div>
                        <div class="col-md-4">
                            <p for="up_transport_cost">Transport Cost</p>
                            <input type="text" placeholder="<?php echo $row['admin_transport_cost']?>" readonly class="ready travel-desk">
                        </div>
                        <div class="col-md-4">
                            <p for="up_visa_cost">Visa Cost</p>
                            <input type="text" placeholder="<?php echo $row['admin_visa_cost']?>" readonly class="ready travel-desk">
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-4">
                            <p for="up_other">Other Cost</p>
                            <input type="text" placeholder="<?php echo $row['admin_other_cost']?>" readonly class="ready travel-desk">
                        </div>
                        <div class="col-md-4">
                            <p for="up_estimate_cost">Travel Estimate Cost</p>
                            <input type="text" placeholder="<?php echo $row['admin_total_cost']?>" readonly class="ready travel-desk">
                        </div>
                        <div class="col-md-4">
                            <p for="up_agent_name">Name of Travel Agent</p>
                            <input type="text" placeholder="<?php echo $row['admin_agent_name']?>" readonly class="ready travel-desk">
                        </div>
                    </div>
                    <p style="font-weight:600" class="py-2"> Representation of Travel Agent who has booked Flight</p>
                    <div class="row">
                        <div class="col-md-6">
                            <p for="up_repname">Name</p>
                            <input type="text" placeholder="<?php echo $row['admin_repname']?>" readonly class="ready travel-desk">
                        </div>
                        <div class="col-md-6">
                            <p for="up_repcontact">Contact No</p>
                            <input type="text" placeholder="<?php echo $row['admin_repcontact']?>" readonly class="ready travel-desk">
                        </div>
                    </div>
                    <!-- final ends -->
                    <?php if ($row['finance_status'] === 'Approved'): ?>
                    <form class="form" method="POST" enctype="multipart/form-data" style="border:2px solid whites;">
                        <h6 class="fw-bold pb-2 text-primary pt-5">Travel Desk</h6>
                        <div class="row">
                            <div class="col">
                                <table class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Ac. Amount</th>
                                            <th>Est. Amount</th>
                                            <th>Invoices</th>
                                            <th>Supplier</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            function renderInvoiceCell($category, $row) {
                                                $col = "fi_{$category}_invoice";
                                                $invoices = !empty($row[$col]) ? json_decode($row[$col], true) : [];
                                                if(!is_array($invoices)) $invoices = [];
                                            
                                                echo '<div class="d-flex align-items-center gap-2">';
                                                echo '<label class="btn-uploadevidence mb-0" style="cursor:pointer;">
                                                        Upload<input type="file" name="'.$col.'[]" multiple style="display:none;"></label>';
                                            
                                                if(count($invoices) > 0){
                                                    echo '<button type="button" class="btn-viewevidence" data-bs-toggle="modal" data-bs-target="#modal_'.$col.'">View</button>';
                                                    echo '<div class="modal fade" id="modal_'.$col.'" tabindex="-1">
                                                            <div class="modal-dialog modal-lg">
                                                              <div class="modal-content">
                                                                <div class="modal-header">
                                                                  <h5 class="modal-title">Invoices - '.ucfirst($category).'</h5>
                                                                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body text-center">';
                                                    
                                                    // Track highlighted index
                                                    echo '<div class="d-flex justify-content-center align-items-start mb-3 gap-2">
                                                            <img id="mainPreview_'.$col.'" src="'.$invoices[0].'" class="img-fluid border rounded" style="max-height:400px; object-fit:contain; cursor:pointer;" onclick="window.open(this.src)">
                                                            <button type="button" class="btn btn-danger btn-sm" id="deleteBtn_'.$col.'" onclick="deleteMainInvoice(\''.$col.'\',0)">Delete</button>
                                                          </div>';
                                            
                                                    echo '<div class="d-flex flex-wrap justify-content-center gap-2">';
                                                    foreach($invoices as $index=>$img){
                                                        echo '<img src="'.$img.'" data-index="'.$index.'" class="invoice-thumb_'.$col.' border rounded" style="height:80px;width:80px;object-fit:cover;cursor:pointer;" onclick="setMainPreview(\''.$col.'\', \''.$img.'\', '.$index.')">';
                                                    }
                                                    echo '</div></div></div></div></div>';
                                                }
                                                echo '</div>';
                                            }
                                            
                                            $categories = ["airline","hotel","transport","visa","other"];
                                            foreach($categories as $cat): ?>
                                        <tr>
                                            <td class="travel-desk1"><?php echo ucfirst($cat); ?></td>
                                            <td><input type="text" name="fi_<?php echo $cat; ?>_ac_amount" value="<?php echo $row['fi_'.$cat.'_ac_amount']; ?>"></td>
                                            <td><input type="text" name="fi_<?php echo $cat; ?>_est_amount" value="<?php echo $row['fi_'.$cat.'_est_amount']; ?>"></td>
                                            <td><?php renderInvoiceCell($cat,$row); ?></td>
                                            <td><input type="text" name="fi_<?php echo $cat; ?>_supplier" value="<?php echo $row['fi_'.$cat.'_supplier']; ?>"></td>
                                            <td><input type="date" name="fi_<?php echo $cat; ?>_date" value="<?php echo $row['fi_'.$cat.'_date']; ?>"></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td class="travel-desk1">Total</td>
                                            <td><input type="text" name="fi_total_amount1" value="<?php echo $row['fi_total_amount1'];?>"></td>
                                            <td><input type="text" name="fi_total_amount2" value="<?php echo $row['fi_total_amount2'];?>"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- <div class="text-center mt-3">
                                    <button class="btn btn-success custom-submit-btn" name="submit" style="font-size:17px;height:36px;width:150px;"><span class="text">Submit</span></button>
                                    </div> -->
                                <div class="text-center mt-3">
                                    <button class="slide" name="submit"
                                        style="font-size: 17px; height: 36px; width: 150px;">
                                    <span class="text">Submit</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php endif; ?>
                    <script>
                        let highlightedIndex = {}; // Store current highlighted index per column
                        
                        function setMainPreview(col, src, index){
                            document.querySelector('#mainPreview_'+col).src = src;
                            highlightedIndex[col] = index;
                            document.querySelector('#deleteBtn_'+col).setAttribute('onclick','deleteMainInvoice("'+col+'",'+index+')');
                        }
                        
                        function deleteMainInvoice(col,index){
                            if(!confirm('Are you sure you want to delete this image?')) return;
                            const id = <?php echo intval($_GET["id"]); ?>;
                            fetch('', {
                                method:'POST',
                                headers:{'Content-Type':'application/x-www-form-urlencoded'},
                                body:'delete_col='+encodeURIComponent(col)+'&delete_index='+encodeURIComponent(index)+'&id='+id
                            }).then(res=>res.text()).then(res=>{
                                res = res.trim(); // <-- trim extra whitespace
                                if(res==='success'){ 
                                    alert('Image deleted'); 
                                    location.reload(); 
                                }
                                else{
                                    alert('Delete failed: ' + res); // <-- show actual reason
                                }
                            });
                        }
                        
                    </script>
                    <!-- <div class="row align-items-center mb-2">
                        <div class="col-12 mb-2">
                            <p class="fw-bold mb-1">Approval</p>
                        </div>
                        <div class="col-auto">
                            <a href="trf_finance_approve.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email']; ?>&name=<?php echo $row['name']; ?>" 
                                class="btn-approve">
                            <i class="fa-solid fa-check"></i> Approve
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="trf_finance_reject.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email']; ?>&name=<?php echo $row['name']; ?>" 
                                class="btn-reject">
                            <i class="fa-solid fa-xmark"></i> Reject
                            </a>
                        </div>
                        </div> -->
                    <div class="row align-items-center mb-2 pt-3">
                        <div class="col-12 mb-2">
                            <p class="fw-bold mb-1 text-primary">Approval</p>
                        </div>
                        <?php if ($row['finance_status'] === 'Pending'): ?>
                        <div class="col-auto">
                            <a href="trf_finance_approve.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email']; ?>&name=<?php echo $row['name']; ?>" 
                                class="btn-approve">
                            <i class="fa-solid fa-check"></i> Approve
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="trf_finance_reject.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email']; ?>&name=<?php echo $row['name']; ?>" 
                                class="btn-reject">
                            <i class="fa-solid fa-xmark"></i> Reject
                            </a>
                        </div>
                        <?php else: ?>
                        <div class="col-auto">
                            <span class="fw-bold">
                            <?php echo ucfirst($row['finance_status']); ?>
                            </span>
                        </div>
                        <?php endif; ?>
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
        </div>
        <?php
            include "footer.php"
                ?>