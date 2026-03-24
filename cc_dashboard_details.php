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
        textarea {
            background-color: #F8F5E9;
            font-size: 11.5px !important;
        }

        .input_style {
            height: 25px !important;
        }

        body {
            font-family: 'Poppins', sans-serif !important;
        }

        .table-1 td {
            padding: 2px !important;
        }

        .table-2 td {
            padding: 2px !important;
        }

        .table-3 td {
            padding: 2px !important;
        }

        .table-4 td {
            padding: 2px !important;
        }

        .table-5 td {
            padding: 2px !important;
        }

        .table-6 td {
            padding: 2px !important;
        }

        .table-7 td {
            padding: 2px !important;
        }

        .table-8 td {
            padding: 2px !important;
        }

        .table-9 td {
            padding: 2px !important;
        }

        .table-10 td {
            padding: 2px !important;
        }

        .table-11 td {
            padding: 2px !important;
        }

        .table-12 td {
            padding: 2px !important;
        }

        .btn {
            font-size: 11px !important;
            color: white !important;
            border-radius: 0px !important;
        }

        tr {
            border: none !important;
            margin: 0px !important;
        }

        /* th {
            font-size: 11px !important;
            border: none !important;
            background-color: #6c757d!important;
            color: #edf2f4 !important;
            font-weight: 600 !important;
        } */
        th {
            font-size: 11px !important;
            border: none !important;
            background-color: #ced4da !important;
            color: black !important;
            font-weight: 600 !important;
        }

        td {
            font-size: 11.5px !important;
            border: none !important;
            margin: 0px !important;
            margin: 0px !important;
        }

        p {
            margin: 0;
            margin-bottom: 2px;
            font-size: 11px !important;
            color: black;
            font-weight: 600;
        }

        input[type="text"] {
            font-size: 11.5px;
            width: 100% !important;
            height: 22px !important;
            border: 0.5px solid grey;
            padding: 2px 5px !important;
            background-color: white;
            margin: 0px !important;
        }

        ::placeholder {
            color: black;
        }

        textarea {
            font-size: 11.5px !important;
            background-color: white;
        }
    </style>

    <?php
    include 'sidebarcss.php'
    ?>

    <style>
        .readonly-box {
            width: 100%;
            min-height: 27px;
            padding: 6px 8px;
            /* add proper padding inside */
            font-size: 11px;
            white-space: pre-wrap;
            /* preserves line breaks */
            word-wrap: break-word;
            border: 1px solid #adb5bd;
            border-radius: 4px;
            background-color: #f8f9fa;
            text-align: left;
            line-height: 1.4;
            /* improves vertical spacing */
            overflow-wrap: break-word;
        }
    </style>


    <style>
        .pdf-wrapper {
            transform-origin: top left;
        }

        .pdf-wrapper table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        .pdf-wrapper th,
        .pdf-wrapper td {
            word-break: break-word;
            padding: 4px;
        }

        /* No need for input/textarea CSS anymore */
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


            $id = $_GET['id'];

            $select = "SELECT * FROM qc_ccrf WHERE id = '$id' ";
            $select_q = mysqli_query($conn, $select);
            $data = mysqli_num_rows($select_q);


            // Query for the `vt_site` table
            $select2 = "SELECT * FROM qc_ccrf2 WHERE fk_id = '$id'";
            $select_q2 = mysqli_query($conn, $select2);
            $row2 = mysqli_fetch_assoc($select_q2);



            ?>
            <?php
            if ($data) {
                while ($row = mysqli_fetch_array($select_q)) {
            ?>

                    <div class="container-fluid">

                        <div style="background-color:white!important;padding:15px!important;border:1px solid black;margin-bottom:15px!important">
                            <div class="d-flex justify-content-between align-items-center pb-5 pt-2">
                                <!-- Left: Home Button -->
                                <div>
                                    <a href="cc_home.php" class="btn btn-dark btn-sm">
                                        <i class="fa-solid fa-home"></i> Home
                                    </a>
                                </div>

                                <!-- Right: Print Button -->
                                <div>
                                    <button id="printBtn" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-print"></i> Print PDF
                                    </button>
                                </div>
                            </div>


                            <div class="pdf">
                                <p style="font-size:16px!important;font-weight:700" class="text-center pb-5 fw-bold">
                                    Change Control:
                                    <?php echo $row['code']; ?>
                                </p>
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <p style="font-size:12px!important;font-weight:500">Date Initiated</p>
                                        <div class="readonly-box"><?php echo nl2br(htmlspecialchars(trim($row['i_date_initiated']))); ?></div>
                                    </div>

                                    <div class="col-md-4">
                                        <p style="font-size:12px!important;font-weight:500">Area of Change</p>
                                        <div class="readonly-box"><?php echo nl2br(htmlspecialchars(trim($row['i_area_of_change']))); ?></div>
                                    </div>

                                    <div class="col-md-4">
                                        <p style="font-size:12px!important;font-weight:500">Type of Change</p>
                                        <div class="readonly-box"><?php echo nl2br(htmlspecialchars(trim($row['i_time_of_change']))); ?></div>
                                    </div>
                                </div>

                                <?php if (strtolower($row['i_time_of_change']) === 'temporary') : ?>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <p style="font-size:12px!important;font-weight:500">Start Date</p>
                                            <div class="readonly-box"><?php echo !empty($row['startdate']) ? htmlspecialchars($row['startdate']) : '-'; ?></div>
                                        </div>
                                        <div class="col-md-4">
                                            <p style="font-size:12px!important;font-weight:500">End Date</p>
                                            <div class="readonly-box"><?php echo !empty($row['enddate']) ? htmlspecialchars($row['enddate']) : '-'; ?></div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <h6 class="pt-4" style="font-size:13px!important;font-weight:700"> Description of Change</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p style="font-size:12px!important;font-weight:500">Current Status</p>
                                        <div class="readonly-box"><?php echo nl2br(htmlspecialchars(trim($row['i_current_status']))); ?></div>
                                    </div>
                                    <div class="col-md-4">
                                        <p style="font-size:12px!important;font-weight:500">Proposed Change</p>
                                        <div class="readonly-box"><?php echo nl2br(htmlspecialchars(trim($row['i_proposed_status']))); ?></div>
                                    </div>
                                    <div class="col-md-4">
                                        <p style="font-size:12px!important;font-weight:500">Title of Change</p>
                                        <div class="readonly-box"><?php echo nl2br(htmlspecialchars(trim($row['i_title_of_change']))); ?></div>
                                    </div>
                                </div>

                                <h6 class="pt-4" style="font-size:13px!important;font-weight:700"> Requestor Information</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p style="font-size:12px!important;font-weight:500">Requestor Name</p>
                                        <div class="readonly-box"><?php echo nl2br(htmlspecialchars(trim($row['username']))); ?></div>
                                    </div>
                                    <div class="col-md-4">
                                        <p style="font-size:12px!important;font-weight:500">Department</p>
                                        <div class="readonly-box"><?php echo nl2br(htmlspecialchars(trim($row['user_department']))); ?></div>
                                    </div>
                                    <div class="col-md-4">
                                        <p style="font-size:12px!important;font-weight:500">Designation</p>
                                        <div class="readonly-box"><?php echo nl2br(htmlspecialchars(trim($row['user_role']))); ?></div>
                                    </div>
                                </div>

                                <h6 class="pt-4" style="font-size:13px!important;font-weight:600">Change Control Classification (Designee)</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p style="font-size:12px!important;font-weight:500">Nature of Change</p>
                                        <div class="readonly-box"><?php echo nl2br(htmlspecialchars(trim($row['i_classification_status']))); ?></div>
                                    </div>

                                    <div class="col-md-4">
                                        <p style="font-size:12px!important;font-weight:500">Justification of Change</p>
                                        <div class="readonly-box"><?php echo nl2br(htmlspecialchars(trim($row['i_justification_of_change']))); ?></div>
                                    </div>
                                    <div class="col-md-4">
                                        <p style="font-size:12px!important;font-weight:500">Completion Date</p>
                                        <div class="readonly-box"><?php echo nl2br(htmlspecialchars(trim($row['i_completion_date']))); ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="pdf">
                                <div class="row pt-3">
                                    <div class="col-6">
                                        <h5 style="font-size:13px!important;font-weight:600">Department Head</h5>
                                        <?php
                                        // Set color for status
                                        $deptStatus = $row['dept_head_status'];
                                        $deptColor = 'text-secondary'; // default
                                        if ($deptStatus === 'Pending') $deptColor = 'text-dark';
                                        elseif ($deptStatus === 'Approved') $deptColor = 'text-success';
                                        elseif ($deptStatus === 'Rejected') $deptColor = 'text-danger';
                                        ?>
                                        <p style="font-size:12px!important;font-weight:500">Status: <span class="<?php echo $deptColor; ?>"><?php echo $deptStatus; ?></span></p>

                                        <?php if (!empty($row['dept_head_date'])): ?>
                                            <p style="font-size:12px!important;font-weight:500">Date: <?php echo $row['dept_head_date']; ?></p>
                                        <?php endif; ?>

                                        <?php
                                        $deptRemarks = trim($row['reject_reason2'] . ' ' . $row['dept_head_comment']);
                                        if (!empty($deptRemarks)): ?>
                                            <p style="font-size:12px!important;font-weight:500">Remarks: <?php echo $deptRemarks; ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-6">
                                        <h5 style="font-size:13px!important;font-weight:600">Quality Head</h5>
                                        <?php
                                        // Set color for status
                                        $qcStatus = $row['qchead_status'];
                                        $qcColor = 'text-secondary'; // default
                                        if ($qcStatus === 'Pending') $qcColor = 'text-dark';
                                        elseif ($qcStatus === 'Approved') $qcColor = 'text-success';
                                        elseif ($qcStatus === 'Rejected') $qcColor = 'text-danger';
                                        ?>
                                        <p style="font-size:12px!important;font-weight:500">Status: <span class="<?php echo $qcColor; ?>"><?php echo $qcStatus; ?></span></p>

                                        <?php if (!empty($row['qchead_date'])): ?>
                                            <p style="font-size:12px!important;font-weight:500">Date: <?php echo $row['qchead_date']; ?></p>
                                        <?php endif; ?>

                                        <?php
                                        $qcRemarks = trim($row['reject_reason'] . ' ' . $row['qchead_comment']);
                                        if (!empty($qcRemarks)): ?>
                                            <p style="font-size:12px!important;font-weight:500">Remarks: <?php echo $qcRemarks; ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>



                            <div class="pdf">
                                <table class="table my-5">
                                    <thead>
                                        <tr>
                                            <th>File No</th>
                                            <th>Doc Number</th>
                                            <th>Revision No</th>
                                            <th>Effective Date</th>
                                            <th>Review Date</th>
                                            <th>Page No</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1098</td>
                                            <td>ML.QAS.FRM.041.R1.E</td>
                                            <td>01</td>
                                            <td>01 JAN 25</td>
                                            <td>On Change</td>
                                            <td>Page 1 of 10</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="pdf">
                                <div class="table-responsive">
                                    <table class="table table-1">
                                        <thead style="background-color:grey;color:white">
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
                                                <td>
                                                    <textarea style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"><?php echo htmlspecialchars($row['b_risk_item_no']); ?></textarea>
                                                </td>
                                                <td>
                                                    <textarea style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"><?php echo htmlspecialchars($row['b_potential_failure_mode']); ?></textarea>
                                                </td>
                                                <td>
                                                    <textarea style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"><?php echo htmlspecialchars($row['b_potential_effect']); ?></textarea>
                                                </td>
                                                <td><textarea style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"><?php echo htmlspecialchars($row['b_severity1']); ?></textarea>
                                                </td>
                                                <td>
                                                    <textarea style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"><?php echo htmlspecialchars($row['b_potential_cause']); ?></textarea>
                                                </td>
                                                <td>
                                                    <textarea style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"><?php echo htmlspecialchars($row['b_occurence_probablility']); ?></textarea>
                                                </td>
                                                <td>
                                                    <textarea style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"><?php echo htmlspecialchars($row['b_current_control']); ?></textarea>
                                                </td>
                                                <td>
                                                    <textarea style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"><?php echo htmlspecialchars($row['b_dectection1']); ?></textarea>
                                                </td>
                                                <td>
                                                    <textarea style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"><?php echo htmlspecialchars($row['b_rpn1']); ?></textarea>
                                                </td>
                                                <td>
                                                    <textarea style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"><?php echo htmlspecialchars($row['b_recommended_action']); ?></textarea>
                                                </td>
                                                <td>
                                                    <textarea style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"><?php echo htmlspecialchars($row['b_severity2']); ?></textarea>
                                                </td>
                                                <td>
                                                    <textarea style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"><?php echo htmlspecialchars($row['b_occurence']); ?></textarea>
                                                </td>
                                                <td>
                                                    <textarea style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"><?php echo htmlspecialchars($row['b_detection2']); ?></textarea>
                                                </td>
                                                <td>
                                                    <textarea style="height:300px!important; width:150px!important; text-align: left; padding: 2px;font-size:11px!important"><?php echo htmlspecialchars($row['b_rpn2']); ?></textarea>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="pdf">
                                <div class="table-responsive">
                                    <table class="table table-2" style="background-color:white;">
                                        <thead>
                                            <tr>
                                                <td colspan="8" class="py-1 pl-1">
                                                    <p class="fw-bold">In-Hand Stock Status</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th rowspan="2">S. No.</th>
                                                <th rowspan="2">Material Code</th>
                                                <th rowspan="2">Material Name</th>
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
                                                <td><input type="text" placeholder="<?php echo $row['c_sno_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_material_code_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_material_name_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_released_qty_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_artwork_code_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_quarantine_qty_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_artwork_code2_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_signature_warehouse_1']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row['c_sno_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_material_code_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_material_name_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_released_qty_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_artwork_code_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_quarantine_qty_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_artwork_code2_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_signature_warehouse_2']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row['c_sno_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_material_code_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_material_name_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_released_qty_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_artwork_code_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_quarantine_qty_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_artwork_code2_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_signature_warehouse_3']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row['c_sno_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_material_code_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_material_name_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_released_qty_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_artwork_code_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_quarantine_qty_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_artwork_code2_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_signature_warehouse_4']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row['c_sno_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_material_code_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_material_name_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_released_qty_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_artwork_code_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_quarantine_qty_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_artwork_code2_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c_signature_warehouse_5']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="7" class="py-1 pl-1">
                                                    <p class="fw-bold"> On-Order Quality</p>
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
                                                <td><input type="text" placeholder="<?php echo $row['c2_sno_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_material_code_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_material_name_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_quantity_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_artwork_code_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_expected_ddate_1']; ?>"></td>
                                                <td colspan="2"><input type="text" placeholder="<?php echo $row['c2_signature_pd_1']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row['c2_sno_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_material_code_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_material_name_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_quantity_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_artwork_code_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_expected_ddate_2']; ?>"></td>
                                                <td colspan="2"><input type="text" placeholder="<?php echo $row['c2_signature_pd_2']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row['c2_sno_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_material_code_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_material_name_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_quantity_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_artwork_code_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_expected_ddate_3']; ?>"></td>
                                                <td colspan="2"><input type="text" placeholder="<?php echo $row['c2_signature_pd_3']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row['c2_sno_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_material_code_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_material_name_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_quantity_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_artwork_code_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_expected_ddate_4']; ?>"></td>
                                                <td colspan="2"><input type="text" placeholder="<?php echo $row['c2_signature_pd_4']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row['c2_sno_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_material_code_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_material_name_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_quantity_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_artwork_code_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['c2_expected_ddate_5']; ?>"></td>
                                                <td colspan="2"><input type="text" placeholder="<?php echo $row['c2_signature_pd_5']; ?>"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="pdf">
                                <div class="table-responsive">
                                    <table class="table table-3" style="background-color:white;">
                                        <thead>
                                            <tr>
                                                <td colspan="8" class="py-1 pl-1">
                                                    <p class="fw-bold">Detail regarding additional order (along with code no.) to be placed (if any)</p>
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
                                                <td><input type="text" placeholder="<?php echo $row['d_sno_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_material_code_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_material_name_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_quantity_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_artwork_code_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_expected_ddate_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_signature_purchase_1']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row['d_sno_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_material_code_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_material_name_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_quantity_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_artwork_code_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_expected_ddate_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_signature_purchase_2']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row['d_sno_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_material_code_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_material_name_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_quantity_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_artwork_code_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_expected_ddate_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_signature_purchase_3']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row['d_sno_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_material_code_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_material_name_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_quantity_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_artwork_code_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_expected_ddate_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_signature_purchase_4']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row['d_sno_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_material_code_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_material_name_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_quantity_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_artwork_code_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_expected_ddate_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d_signature_purchase_5']; ?>"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="pdf">
                                <div class="table-responsive">
                                    <table class="table table-4" style="background-color:white;">
                                        <thead>
                                            <tr>
                                                <td colspan="6" class="py-1 pl-1">
                                                    <p class="fw-bold">Material to be destroyed (if any)</p>
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
                                                <td><input type="text" placeholder="<?php echo $row['d2_sno_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_material_code_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_material_name_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_quantity_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_artwork_code_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_signature_planning_1']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row['d2_sno_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_material_code_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_material_name_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_quantity_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_artwork_code_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_signature_planning_2']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row['d2_sno_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_material_code_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_material_name_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_quantity_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_artwork_code_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_signature_planning_3']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row['d2_sno_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_material_code_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_material_name_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_quantity_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_artwork_code_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_signature_planning_4']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row['d2_sno_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_material_code_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_material_name_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_quantity_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_artwork_code_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d2_signature_planning_5']; ?>"></td>
                                            </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="pdf">
                                <div class="table-responsive">
                                    <table class="table table-5" style="background-color:white;">
                                        <thead>
                                            <tr>
                                                <td colspan="8" class="py-1 pl-1">
                                                    <p class="fw-bold">No. if batches to be produced with old inventory as per following details</p>
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
                                                <td><input type="text" placeholder="<?php echo $row['d3_sno_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_material_code_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_material_name_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_quantity_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_artwork_code_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_batchno_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_signature_planning_1']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row['d3_sno_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_material_code_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_material_name_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_quantity_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_artwork_code_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_batchno_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_signature_planning_2']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row['d3_sno_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_material_code_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_material_name_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_quantity_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_artwork_code_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_batchno_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_signature_planning_3']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row['d3_sno_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_material_code_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_material_name_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_quantity_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_artwork_code_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_batchno_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_signature_planning_5']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row['d3_sno_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_material_code_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_material_name_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_quantity_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_artwork_code_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_batchno_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row['d3_signature_planning_5']; ?>"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- page 8 -->
                            <div class="pdf">
                                <div class="table-responsive">
                                    <table class="table table-8" style="background-color:white;">
                                        <thead>
                                            <tr>
                                                <th>Possible Consequences of the change on:</th>
                                                <th>YES/NO</th>
                                                <th>Why/Measures/Dates/Responsibilities</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="pl-2">Cost</td>
                                                <td><input type="text" placeholder="<?php echo htmlspecialchars($row2['g_cost_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_cost_2']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Manufacturing</td>
                                                <td><input type="text" placeholder="<?php echo htmlspecialchars($row2['g_manufacturing_1']); ?>"></td>
                                                <td><input type="text" placeholder="<?php echo htmlspecialchars($row2['g_manufacturing_2']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Master Formula Record/BOM</td>
                                                <td><input type="text" placeholder="<?php echo htmlspecialchars($row2['g_master_formula_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_master_formula_2']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Packaging/Labeling</td>
                                                <td><input type="text" placeholder="<?php echo htmlspecialchars($row2['g_packaging_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_packaging_2']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Testing</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_testing_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_testing_2']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Product stability</td>
                                                <td><input type="text" placeholder="<?php echo htmlspecialchars($row2['g_product_stability_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_product_stability_2']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Product quality/specification</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_product_quality_1']); ?>"></td>
                                                <td><input type="text" placeholder="<?php echo htmlspecialchars($row2['g_product_quality_2']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Product supply</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_product_supply_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_product_supply_2']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Efficacy</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_efficacy_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_efficacy_2']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Equipment impact</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_equipment_impact_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_equipment_impact_2']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Name of product impact</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_name_of_product_impact_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_name_of_product_impact_2']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Change in SOP</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_change_in_sop_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_change_in_sop_2']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Validation</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_validation_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_validation_2']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Qualification</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_qualification_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_qualification_2']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Calibration</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_calibration_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_calibration_2']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Marketing Impact (local/export)</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_marketing_impact_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_marketing_impact_2']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Registration</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_registration_1']); ?>"></td>
                                                <td><input type="text" placeholder="<?php echo htmlspecialchars($row2['g_registration_2']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Training Required</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_training_required_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_training_required_2']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Regulatory requirement</td>
                                                <td><input type="text" placeholder="<?php echo htmlspecialchars($row2['g_regulatory_requirement_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_regulatory_requirement_2']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Any Other</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_any_other_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['g_any_other_2']); ?>"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="pdf">
                                <p class="fw-bold">Documents Needing Revision as a result of the Change:</p>
                                <div class="table-responsive">
                                    <table class="table table-9" style="background-color:white;">
                                        <thead style="background-color: grey; color: white;">
                                            <tr style="border:1px solid white!important">
                                                <th rowspan="2" style="border:1px solid white!important;vertical-align: middle;">Documents Name/Type</th>
                                                <th rowspan="2" style="border:1px solid white!important;vertical-align: middle;">Please Tick</th>
                                                <th colspan="2" style="border:1px solid white!important">Document Identification /Date <br> </th>
                                            </tr>
                                            <tr style="border:1px solid white!important">
                                                <th>Current Change</th>
                                                <th>Changed</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="pl-2">Bill(s)of Materials </td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_bills_of_materials_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_bills_of_materials_2']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_bills_of_materials_3']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Calibration document(s)</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_calibration_documents_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_calibration_documents_2']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_calibration_documents_3']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Contract(s) Supplier & Quality Agreements</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_contracts_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_contracts_2']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_contracts_3']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Master batch records(s)</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_master_batch_records_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_master_batch_records_2']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_master_batch_records_3']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Material Characterization/Specification(s)</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_material_characterization_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_material_characterization_2']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_material_characterization_3']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Master imprinted packaging material</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_master_imprinted_packaging_material_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_master_imprinted_packaging_material_2']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_master_imprinted_packaging_material_3']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Master packaging record(s)</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_master_packaging_records_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_master_packaging_records_2']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_master_packaging_records_3']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Stability report(s)</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_stability_report_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_stability_report_2']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_stability_report_3']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Standard Operating Procedure(s)</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_standard_operating_procedure_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_standard_operating_procedure_2']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_standard_operating_procedure_3']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Testing Monograph(s)</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_testing_monograph_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_testing_monograph_2']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_testing_monograph_3']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Training document(s)</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_training_document_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_training_document_2']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_training_document_3']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Plant drawing(s)</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_plant_drawings_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_plant_drawings_2']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_plant_drawings_3']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Qualification Protocol(s) </td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_qualification_protocols_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_qualification_protocols_2']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_qualification_protocols_3']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Qualification report(s)</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_qualification_reports_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_qualification_reports_2']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_qualification_reports_3']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Registration dossier(s)</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_registration_dossiers_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_registration_dossiers_2']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_registration_dossiers_3']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Validation Protocol(s) </td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_validation_protocols_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_validation_protocols_2']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_validation_protocols_3']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Validation report(s)</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_validation_reports_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_validation_reports_2']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_validation_reports_3']); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">other</td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_others_1']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_others_2']); ?>"></td>
                                                <td> <input type="text" placeholder="<?php echo htmlspecialchars($row2['h_others_3']); ?>"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="pdf">
                                <h6><b>Assigned Department</b></h6>
                                <div class="table-responsive">
                                    <table class="table table-11" style="background-color:white;">
                                        <thead>
                                            <tr>
                                                <th>Department</th>
                                                <th>Tick (√) the box where evaluation required</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="pl-2">Administration</td>
                                                <td><input type="text" name="administration_input1" placeholder="<?php echo $row['administration_val']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Production</td>
                                                <td><input type="text" name="administration_input1" placeholder="<?php echo $row['production_val']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Quality Assurance</td>
                                                <td><input type="text" name="administration_input1" placeholder="<?php echo $row['qa_val']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Quality Control</td>
                                                <td><input type="text" name="administration_input1" placeholder="<?php echo $row['qc_val']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Herb Warehouse</td>
                                                <td><input type="text" name="administration_input1" placeholder="<?php echo $row['herb_warehouse_val']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Chemical Warehouse</td>
                                                <td><input type="text" name="administration_input1" placeholder="<?php echo $row['chemical_warehouse_val']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Packing Warehouse</td>
                                                <td><input type="text" name="administration_input1" placeholder="<?php echo $row['packing_warehouse_val']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Finished Goods Warehouse</td>
                                                <td><input type="text" name="administration_input1" placeholder="<?php echo $row['finished_goods_warehouse_val']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Procurement</td>
                                                <td><input type="text" name="administration_input1" placeholder="<?php echo $row['procurement_val']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Supply Chain Management</td>
                                                <td><input type="text" name="administration_input1" placeholder="<?php echo $row['scm_val']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Finance & Accounts</td>
                                                <td><input type="text" name="administration_input1" placeholder="<?php echo $row['finance_val']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Business Development Department</td>
                                                <td><input type="text" name="administration_input1" placeholder="<?php echo $row['bdd_val']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Marketing Department</td>
                                                <td><input type="text" name="administration_input1" placeholder="<?php echo $row['marketing_val']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Research and Development</td>
                                                <td><input type="text" name="administration_input1" placeholder="<?php echo $row['rnd_val']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Regulatory</td>
                                                <td><input type="text" name="administration_input1" placeholder="<?php echo $row['regu_val']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Engineering</td>
                                                <td><input type="text" name="administration_input1" placeholder="<?php echo $row['eng_val']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Microbiology</td>
                                                <td><input type="text" name="administration_input1" placeholder="<?php echo $row['micro_val']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Human Resource</td>
                                                <td><input type="text" name="administration_input1" placeholder="<?php echo $row['hr_val']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-2">IT Department</td>
                                                <td><input type="text" name="administration_input1" placeholder="<?php echo $row['it_val']; ?>"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="pdf">
                                <h6><b>Department Input</b></h6>
                                <div class="table-responsive">
                                    <table class="table table-12" style="background-color:white;">
                                        <thead>
                                            <tr>
                                                <th>Department</th>

                                                <th>Comments</th>
                                                <th>Signature</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="pl-2">Administration</td>

                                                <td><input type="text" placeholder="<?php echo $row['e_admin_2']; ?>"></td>
                                                <!-- <td><input type="text" placeholder="<?php echo $row['e_admin_3']; ?>"></td> -->
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Production</td>

                                                <td><input type="text" placeholder="<?php echo $row['e_production_2']; ?>"></td>
                                                <!-- <td><input type="text" placeholder="<?php echo $row['e_production_3']; ?>"></td> -->
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Quality Assurance</td>

                                                <td><input type="text" placeholder="<?php echo $row['e_qa_2']; ?>"></td>
                                                <!-- <td><input type="text" placeholder="<?php echo $row['e_qa_3']; ?>"></td> -->
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Quality Control</td>
                                                <td><input type="text" placeholder="<?php echo $row['e_qc_2']; ?>"></td>
                                                <!-- <td><input type="text" placeholder="<?php echo $row['e_qc_3']; ?>"></td> -->
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Herb Warehouse</td>
                                                <td><input type="text" placeholder="<?php echo $row['e_herb_2']; ?>"></td>
                                                <!-- <td><input type="text" placeholder="<?php echo $row['e_herb_3']; ?>"></td> -->
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Chemical Warehouse</td>
                                                <td><input type="text" placeholder="<?php echo $row['e_chemical_2']; ?>"></td>
                                                <!-- <td><input type="text" placeholder="<?php echo $row['e_chemical_3']; ?>"></td> -->
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Packing Warehouse</td>
                                                <td><input type="text" placeholder="<?php echo $row['e_chemical_2']; ?>"></td>
                                                <!-- <td><input type="text" placeholder="<?php echo $row['e_chemical_3']; ?>"></td> -->
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Finished Goods Warehouse</td>
                                                <td><input type="text" placeholder="<?php echo $row['e_finished_goods_2']; ?>"></td>
                                                <!-- <td><input type="text" placeholder="<?php echo $row['e_finished_goods_3']; ?>"></td> -->
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Procurement</td>
                                                <td><input type="text" placeholder="<?php echo $row['e_procurement_2']; ?>"></td>
                                                <!-- <td><input type="text" placeholder="<?php echo $row['e_procurement_3']; ?>"></td> -->
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Supply Chain Management</td>
                                                <td><input type="text" placeholder="<?php echo $row['e_scm_2']; ?>"></td>
                                                <!-- <td><input type="text" placeholder="<?php echo $row['e_scm_3']; ?>"></td> -->
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Finance & Accounts</td>
                                                <td><input type="text" placeholder="<?php echo $row['e_finance_2']; ?>"></td>
                                                <!-- <td><input type="text" placeholder="<?php echo $row['e_finance_3']; ?>"></td> -->
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Business Development Department</td>
                                                <td><input type="text" placeholder="<?php echo $row['e_bdd_2']; ?>"></td>
                                                <!-- <td><input type="text" placeholder="<?php echo $row['e_bdd_3']; ?>"></td> -->
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Marketing Department</td>
                                                <td><input type="text" placeholder="<?php echo $row['e_marketing_2']; ?>"></td>
                                                <!-- <td><input type="text" placeholder="<?php echo $row['e_marketing_3']; ?>"></td> -->
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Research and Development</td>
                                                <td><input type="text" placeholder="<?php echo $row['e_rnd_2']; ?>"></td>
                                                <!-- <td><input type="text" placeholder="<?php echo $row['e_rnd_3']; ?>"></td> -->
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Regulatory</td>
                                                <td><input type="text" placeholder="<?php echo $row['e_regulatory_2']; ?>"></td>
                                                <!-- <td><input type="text" placeholder="<?php echo $row['e_regulatory_3']; ?>"></td> -->
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Engineering</td>
                                                <td><input type="text" placeholder="<?php echo $row['e_engineering_2']; ?>"></td>
                                                <!-- <td><input type="text" placeholder="<?php echo $row['e_engineering_3']; ?>"></td> -->
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Microbiology</td>
                                                <td><input type="text" placeholder="<?php echo $row['e_microbiology_2']; ?>"></td>
                                                <!-- <td><input type="text" placeholder="<?php echo $row['e_microbiology_3']; ?>"></td> -->
                                            </tr>
                                            <tr>
                                                <td class="pl-2">Human Resource</td>
                                                <td><input type="text" placeholder="<?php echo $row['e_hr_2']; ?>"></td>
                                                <!-- <td><input type="text" placeholder="<?php echo $row['e_hr_3']; ?>"></td> -->
                                            </tr>
                                            <tr>
                                                <td class="pl-2">IT Department</td>
                                                <td><input type="text" placeholder="<?php echo $row['e_it_1']; ?>"></td>
                                                <!-- <td><input type="text" placeholder="<?php echo $row['e_it_1']; ?>"></td> -->
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- <div class="pdf">
                                <h6><b>Final Approval</b></h6>
                                <div class="table-responsive">
                                    <table class="table  table-bordered table-7" style="background-color:white;">
                                        <thead>
                                            <th>Department</th>
                                            <th>Remarks</t>
                                                </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="p-2">Head of quality</td>
                                                <td class="p-2">
                                                    <input type="text" placeholder="<?php echo htmlspecialchars($row['qchead_status2']); ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-2">Chief executive officer
                                                </td>
                                                <td class="p-2">
                                                    <input type="text" placeholder="<?php echo htmlspecialchars($row['ceo_status']); ?>">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p>*CEO Authorized required for Criical or Major Changes Only.</p>
                            </div> -->
                            <div class="pdf">
                                <h6 class="pt-2 fw-bold">Action Plan</h6>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Event / Action Plan</th>
                                                <th>Responsiblity</th>
                                                <th>Timeline</th>
                                                <th>Email</th>
                                                <th>Completion Status</th>
                                                <th>Verified By Quality Department</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row2['f_ac_1']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_responsibility_1']; ?>"></td>
                                                <td>
                                                    <input type="text"
                                                        placeholder="<?php
                                                                        echo !empty($row2['f_timeline_1'])
                                                                            ? date('d-m-Y', strtotime($row2['f_timeline_1']))
                                                                            : '';
                                                                        ?>">
                                                </td>

                                                <td><input type="text" placeholder="<?php echo $row2['f_signature_1']; ?>"></td>

                                                <td><input type="text" placeholder="<?php echo $row2['workdone1']; ?> <?php echo $row2['workdone1_date']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_verify_by_1']; ?>"></td>

                                            </tr>

                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row2['f_ac_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_responsibility_2']; ?>"></td>
                                                <td>
                                                    <input type="text"
                                                        placeholder="<?php
                                                                        echo !empty($row2['f_timeline_2'])
                                                                            ? date('d-m-Y', strtotime($row2['f_timeline_2']))
                                                                            : '';
                                                                        ?>">
                                                </td>

                                                <td><input type="text" placeholder="<?php echo $row2['f_signature_2']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['workdone2']; ?> <?php echo $row2['workdone2_date']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_verify_by_2']; ?>"></td>
                                            </tr>

                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row2['f_ac_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_responsibility_3']; ?>"></td>
                                                <td>
                                                    <input type="text"
                                                        placeholder="<?php
                                                                        echo !empty($row2['f_timeline_3'])
                                                                            ? date('d-m-Y', strtotime($row2['f_timeline_3']))
                                                                            : '';
                                                                        ?>">
                                                </td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_signature_3']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['workdone3']; ?> <?php echo $row2['workdone3_date']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_verify_by_3']; ?>"></td>
                                            </tr>

                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row2['f_ac_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_responsibility_4']; ?>"></td>
                                                <td>
                                                    <input type="text"
                                                        placeholder="<?php
                                                                        echo !empty($row2['f_timeline_4'])
                                                                            ? date('d-m-Y', strtotime($row2['f_timeline_4']))
                                                                            : '';
                                                                        ?>">
                                                </td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_signature_4']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['workdone4']; ?> <?php echo $row2['workdone4_date']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_verify_by_4']; ?>"></td>
                                            </tr>

                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row2['f_ac_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_responsibility_5']; ?>"></td>
                                                <td>
                                                    <input type="text"
                                                        placeholder="<?php
                                                                        echo !empty($row2['f_timeline_5'])
                                                                            ? date('d-m-Y', strtotime($row2['f_timeline_5']))
                                                                            : '';
                                                                        ?>">
                                                </td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_signature_5']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['workdone5']; ?> <?php echo $row2['workdone5_date']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_verify_by_5']; ?>"></td>
                                            </tr>


                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row2['f_ac_6']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_responsibility_6']; ?>"></td>
                                                <td>
                                                    <input type="text"
                                                        placeholder="<?php
                                                                        echo !empty($row2['f_timeline_6'])
                                                                            ? date('d-m-Y', strtotime($row2['f_timeline_6']))
                                                                            : '';
                                                                        ?>">
                                                </td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_signature_6']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['workdone6']; ?> <?php echo $row2['workdone6_date']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_verify_by_6']; ?>"></td>
                                            </tr>


                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row2['f_ac_7']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_responsibility_7']; ?>"></td>
                                                <td>
                                                    <input type="text"
                                                        placeholder="<?php
                                                                        echo !empty($row2['f_timeline_7'])
                                                                            ? date('d-m-Y', strtotime($row2['f_timeline_7']))
                                                                            : '';
                                                                        ?>">
                                                </td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_signature_7']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['workdone7']; ?> <?php echo $row2['workdone7_date']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_verify_by_7']; ?>"></td>
                                            </tr>


                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row2['f_ac_8']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_responsibility_8']; ?>"></td>
                                                <td>
                                                    <input type="text"
                                                        placeholder="<?php
                                                                        echo !empty($row2['f_timeline_8'])
                                                                            ? date('d-m-Y', strtotime($row2['f_timeline_8']))
                                                                            : '';
                                                                        ?>">
                                                </td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_signature_8']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['workdone8']; ?> <?php echo $row2['workdone8_date']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_verify_by_8']; ?>"></td>
                                            </tr>

                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row2['f_ac_9']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_responsibility_9']; ?>"></td>
                                                <td>
                                                    <input type="text"
                                                        placeholder="<?php
                                                                        echo !empty($row2['f_timeline_9'])
                                                                            ? date('d-m-Y', strtotime($row2['f_timeline_9']))
                                                                            : '';
                                                                        ?>">
                                                </td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_signature_9']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['workdone9']; ?> <?php echo $row2['workdone9_date']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_verify_by_9']; ?>"></td>
                                            </tr>

                                            <tr>
                                                <td><input type="text" placeholder="<?php echo $row2['f_ac_10']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_responsibility_10']; ?>"></td>
                                                <td>
                                                    <input type="text"
                                                        placeholder="<?php
                                                                        echo !empty($row2['f_timeline_10'])
                                                                            ? date('d-m-Y', strtotime($row2['f_timeline_10']))
                                                                            : '';
                                                                        ?>">
                                                </td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_signature_10']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['workdone10']; ?> <?php echo $row2['workdone10_date']; ?>"></td>
                                                <td><input type="text" placeholder="<?php echo $row2['f_verify_by_10']; ?>"></td>
                                            </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="pdf">
                                <h6><b>Closing</b></h6>
                                <div class="table-responsive">
                                    <table class="table table-10" style="background-color:white;">
                                        <tr>
                                            <td rowspan="8" style="vertical-align:middle!important" class="pl-2" style="font-size:13px!important">Effectiveness Checks
                                                Completion:
                                            </td>
                                            <td><input type="text" placeholder="<?php echo htmlspecialchars($row2['i_1']); ?>"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" placeholder="<?php echo htmlspecialchars($row2['i_2']); ?>"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" placeholder="<?php echo htmlspecialchars($row2['i_3']); ?>"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" placeholder="<?php echo htmlspecialchars($row2['i_4']); ?>"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" placeholder="<?php echo htmlspecialchars($row2['i_5']); ?>"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" placeholder="<?php echo htmlspecialchars($row2['i_6']); ?>"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" placeholder="<?php echo htmlspecialchars($row2['i_7']); ?>"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" placeholder="<?php echo htmlspecialchars($row2['i_8']); ?>"></td>
                                        </tr>
                                        <tr>
                                            <td class="pl-2">Change completion date:</td>
                                            <td><input type="text" placeholder="<?php echo htmlspecialchars($row2['i_9']); ?>"></td>
                                        </tr>
                                        <tr>
                                            <td class="pl-2">
                                                <div style="display: flex; align-items: center; gap: 5px;">
                                                    <label for="name" style="font-size:13px!important">Name:</label>
                                                    <input type="text" placeholder="<?php echo htmlspecialchars($row2['i_10']); ?>">
                                                </div>
                                            </td>
                                            <td class="pl-2">
                                                <div style="display: flex; align-items: center; gap: 5px;">
                                                    <label for="sign" style="font-size:13px!important">Date:</label>
                                                    <input type="text" placeholder="<?php echo htmlspecialchars($row2['i_11']); ?>">
                                                </div>
                                            </td>
                                        </tr>
                                    </table>


                                </div>

                            </div>

                            <?php
                            // ---------- Fetch files from ccrf table ----------
                            $ccFiles = [];
                            if (!empty($row['file'])) {
                                $ccFiles = json_decode($row['file'], true);
                                if (!is_array($ccFiles)) {
                                    $ccFiles = [];
                                }
                            }
                            ?>


                            <button class="btn btn-sm btn-warning" style="color:black!important"
                                data-bs-toggle="modal"
                                data-bs-target="#ccFilesModal">
                                Change Control submission document
                            </button>


                            <?php
                            $closingFiles = [];
                            if (!empty($row2['evidence_files'])) {
                                $closingFiles = json_decode($row2['evidence_files'], true);
                            }
                            ?>

                            <?php if (!empty($closingFiles)) : ?>
                                <div class="mt-3">
                                    <button class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#closingDocsModal">
                                        Closing Documents
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- container end-->
            <?php
                }
            } else {
                echo "No record found!";
            }
            ?>
        </div>
    </div>
    <!--content-->
    </div> <!--wrapper-->
    <!-- <button onclick="downloadPDF()" class="btn btn-danger ">Download as PDF</button> -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            // Ensure the sidebar is active (visible) by default
            $('#sidebar').addClass('active'); // Change to addClass to show sidebar initially

            // Handle sidebar collapse toggle
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });

            // Update the icon when collapsing/expanding
            $('[data-bs-toggle="collapse"]').on('click', function() {
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
    <script src="assets/js/main.js"></script>

    <div class="modal fade" id="closingDocsModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">

                <!-- Modal Header -->
                <div class="modal-header text-white" style="background: linear-gradient(90deg, #212529, #343a40);">
                    <h6 class="modal-title fw-semibold">Closing Documents</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body" style="background-color:#f1f3f5;">

                    <?php
                    $docCount = 1;
                    foreach ($closingFiles as $file):
                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                        $typeLabel = strtoupper($ext);
                    ?>

                        <div class="mb-4 rounded shadow-sm overflow-hidden">

                            <!-- Document Header -->
                            <div class="px-4 py-3 d-flex align-items-center justify-content-between"
                                style="background-color:#212529;">
                                <span class="text-white fw-semibold">
                                    Closing Document <?= $docCount; ?> (<?= $typeLabel; ?>)
                                </span>

                                <span class="badge bg-secondary">
                                    <?= $typeLabel; ?>
                                </span>
                            </div>

                            <!-- Preview Area -->
                            <div class="p-4 text-center" style="background-color:#ffffff;">

                                <?php if (in_array($ext, ['jpg', 'jpeg', 'png'])): ?>
                                    <img src="<?= $file ?>" class="img-fluid rounded border">

                                <?php elseif ($ext === 'pdf'): ?>
                                    <iframe src="<?= $file ?>"
                                        width="100%"
                                        height="500"
                                        class="border rounded"></iframe>

                                <?php elseif (in_array($ext, ['xls', 'xlsx'])): ?>
                                    <a href="<?= $file ?>" target="_blank"
                                        class="btn btn-success btn-sm px-4">
                                        Download Excel File
                                    </a>

                                <?php elseif (in_array($ext, ['doc', 'docx'])): ?>
                                    <a href="<?= $file ?>" target="_blank"
                                        class="btn btn-primary btn-sm px-4">
                                        Download Word File
                                    </a>

                                <?php else: ?>
                                    <a href="<?= $file ?>" target="_blank"
                                        class="btn btn-outline-secondary btn-sm px-4">
                                        Open Document
                                    </a>
                                <?php endif; ?>

                            </div>
                        </div>

                    <?php
                        $docCount++;
                    endforeach;
                    ?>

                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        const {
            jsPDF
        } = window.jspdf;

        document.getElementById("printBtn").addEventListener("click", async () => {
            const blocks = document.querySelectorAll(".pdf");
            if (!blocks.length) return alert("No .pdf blocks found");

            const pdf = new jsPDF({
                orientation: "portrait",
                unit: "px",
                format: "a4"
            });
            const pageWidth = pdf.internal.pageSize.getWidth();
            const pageHeight = pdf.internal.pageSize.getHeight();
            const TOP_MARGIN = 20;
            const LEFT_MARGIN = 20;
            const MAX_SCALE = 0.95;

            for (let i = 0; i < blocks.length; i++) {
                const block = blocks[i].cloneNode(true);

                // Replace inputs/textareas with spans that copy styles and borders
                block.querySelectorAll("input, textarea").forEach(el => {
                    const span = document.createElement("span");
                    span.textContent = el.value || el.placeholder || "";

                    const style = window.getComputedStyle(el);
                    span.style.fontSize = style.fontSize;
                    span.style.fontFamily = style.fontFamily;
                    span.style.fontWeight = style.fontWeight;
                    span.style.color = style.color;
                    span.style.backgroundColor = style.backgroundColor;
                    span.style.display = "inline-block";
                    span.style.width = style.width;
                    span.style.height = style.height;
                    span.style.padding = style.padding;
                    span.style.margin = style.margin;

                    // Copy border properly
                    span.style.borderWidth = style.borderWidth;
                    span.style.borderStyle = style.borderStyle;
                    span.style.borderColor = style.borderColor;
                    span.style.borderRadius = style.borderRadius;

                    span.style.boxSizing = "border-box";

                    el.parentNode.replaceChild(span, el);
                });

                // Force table elements to render and copy their borders
                block.querySelectorAll("table, th, td, tr").forEach(el => {
                    const style = window.getComputedStyle(el);
                    el.style.display = style.display; // preserve display
                    el.style.borderStyle = style.borderStyle;
                    el.style.borderWidth = style.borderWidth;
                    el.style.borderColor = style.borderColor;
                    el.style.borderCollapse = style.borderCollapse || "collapse";
                });

                document.body.appendChild(block);

                const canvas = await html2canvas(block, {
                    scale: 2,
                    useCORS: true,
                    backgroundColor: "#ffffff",
                });

                const imgWidth = canvas.width;
                const imgHeight = canvas.height;
                const scale = Math.min((pageWidth - LEFT_MARGIN * 2) / imgWidth, MAX_SCALE, 1);
                const renderWidth = imgWidth * scale;
                const renderHeight = imgHeight * scale;

                if (i > 0) pdf.addPage();
                pdf.addImage(canvas.toDataURL("image/jpeg", 1.0), "JPEG", LEFT_MARGIN, TOP_MARGIN, renderWidth, renderHeight);

                document.body.removeChild(block);
            }

            pdf.save("corporate_output.pdf");
        });
    </script>







    <!-- ---------- Modal ---------- -->
    <div class="modal fade" id="ccFilesModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Change Control Submission Documents</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" style="background-color:#f1f3f5;">
                    <?php
                    $docCount = 1;
                    foreach ($ccFiles as $file):
                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                        $typeLabel = strtoupper($ext);
                    ?>
                        <div class="mb-4 rounded shadow-sm overflow-hidden">

                            <!-- Document Header -->
                            <div class="px-4 py-3 d-flex align-items-center justify-content-between"
                                style="background-color:#212529;">
                                <span class="text-white fw-semibold">
                                    Submission Document <?= $docCount; ?> (<?= $typeLabel; ?>)
                                </span>
                                <span class="badge bg-secondary">
                                    <?= $typeLabel; ?>
                                </span>
                            </div>

                            <!-- Preview Area -->
                            <div class="p-4 text-center" style="background-color:#ffffff;">

                                <?php if (in_array($ext, ['jpg', 'jpeg', 'png'])): ?>
                                    <img src="<?= $file ?>" class="img-fluid rounded border">

                                <?php elseif ($ext === 'pdf'): ?>
                                    <iframe src="<?= $file ?>" width="100%" height="500" class="border rounded"></iframe>

                                <?php elseif (in_array($ext, ['xls', 'xlsx'])): ?>
                                    <a href="<?= $file ?>" target="_blank" class="btn btn-success btn-sm px-4">
                                        Download Excel File
                                    </a>

                                <?php elseif (in_array($ext, ['doc', 'docx'])): ?>
                                    <a href="<?= $file ?>" target="_blank" class="btn btn-primary btn-sm px-4">
                                        Download Word File
                                    </a>

                                <?php else: ?>
                                    <a href="<?= $file ?>" target="_blank" class="btn btn-outline-secondary btn-sm px-4">
                                        Open Document
                                    </a>
                                <?php endif; ?>

                            </div>
                        </div>
                    <?php
                        $docCount++;
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>-