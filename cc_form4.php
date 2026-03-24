<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$head_email = $_SESSION['head_email'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Define the sendPHPMailer function
function sendPHPMailer($to, $subject, $body)
{
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host       = 'smtp.office365.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@medicslab.com';
        $mail->Password   = 'kcmzrskfgmwzzshz';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('info@medicslab.com', 'Medics Digital form');
        $mail->addAddress($to); // ✅ Use the $to argument passed in
        $mail->addCC('sadia.iqbal@medicslab.com');

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Assign to department</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* =====================
   Base Styles
===================== */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f6fa;
        }

        p {
            font-size: 11.7px !important;
            font-weight: 500 !important;
            padding: 0 !important;
            margin: 0 10px 0 0 !important;
            display: inline !important;
        }

        /* =====================
   Cards & Layout
===================== */
        .card {
            border-radius: 10px;
        }

        .main-heading {
            font-size: 15px !important;
            font-weight: 600 !important;
        }

        .bg-menu {
            background-color: #393E46 !important;
        }

        /* =====================
   Buttons
===================== */
        .btn-menu {
            font-size: 12.5px;
            font-weight: 600;
            background-color: #FFB22C !important;
            padding: 5px 10px;
            border: none !important;
            border-radius: 2px !important;
            color: black !important;
        }

        .btn-light {
            font-size: 13px;
            font-weight: 400;
        }

        .btn-submit {
            font-size: 17px !important;
            font-weight: 500;
            color: white;
            background-color: #0d6efd;
            padding: 5px 35px;
            border-radius: 2px;
            border: 2px solid #0D9276;
            letter-spacing: 1.35px;
        }

        .btn-submit:hover {
            background-color: #0d6efd;
            color: white;
        }

        /* =====================
   Tables
===================== */
        th {
            font-size: 11px !important;
            font-weight: 600 !important;
            background-color: #ced4da !important;
            color: black !important;
            border: none !important;
        }

        td {
            border: none !important;
            padding: 2px 2px !important;
            margin: 0px !important;
        }

        tr {
            border-bottom: 0.5px solid grey !important;

        }

        thead {
            border: 1px solid grey !important;
        }

        .table-1 td,
        .table-2 td,
        .table-3 td {
            padding: 7px 10px !important;
        }

        /* =====================
   Lists
===================== */
        .ul-msg li {
            font-size: 12px;
            font-weight: 500;
            padding-top: 10px;
        }

        /* =====================
   Inputs & Forms
===================== */
        input {
            width: 100% !important;
            height: 25px !important;
            font-size: 11.7px !important;
            padding: 5px !important;
            border: none !important;
            border-radius: 0 !important;
            letter-spacing: 0.4px !important;
            transition: border-color 0.3s ease !important;
        }

        input:focus {
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
        }

        input[type="checkbox"],
        label {
            padding: 0 !important;
            margin: 0 !important;
            font-size: 12px !important;
        }

        .cbox {
            width: 13px !important;
            height: 13px !important;
        }
    </style>
    <?php include 'sidebarcss.php' ?>
</head>

<body>
    <div class="wrapper">
        <?php
        include 'sidebar1.php';
        ?>
        <!-- Page Content  -->
        <div id="content">
            <!-- navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-menu">
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
            $select = "SELECT * FROM qc_ccrf WHERE
                    id = '$id'";

            $select_q = mysqli_query($conn, $select);
            $data = mysqli_num_rows($select_q);
            ?>
            <?php
            if ($data) {
                while ($row = mysqli_fetch_array($select_q)) {
            ?>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-7 pt-md-2">
                                <form class="form pb-3" method="POST">







                                    <div class="card shadow mt-3">
                                        <div class="card-header bg-dark text-white d-flex align-items-center">
                                            <h6 class="mb-0 main-heading"> Assign To Departments</h6>

                                            <div class="ms-auto">
                                                <a href="cc_home.php" class="btn btn-light btn-sm me-2">Home</a>
                                                <a href="cc_user_forms.php" class="btn btn-light btn-sm me-2">Back</a>
                                            </div>
                                        </div>
                                        <div class="card-body">





                                            <table class="table">

                                                <tr>
                                                    <td style="font-weight:600;font-size:12px!important">Administration</td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="category-checkbox cbox"
                                                                name="administration_val"
                                                                value="Yes"
                                                                <?php echo ($row['administration_val'] === 'Yes') ? 'checked' : ''; ?>>
                                                            Yes
                                                        </label>
                                                    </td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="category-checkbox cbox"
                                                                name="administration_val"
                                                                value="No"
                                                                <?php echo ($row['administration_val'] === 'No') ? 'checked' : ''; ?>>
                                                            No
                                                        </label>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="font-weight:600;font-size:12px!important">Production</td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="production_val"
                                                                value="Yes"
                                                                <?php echo ($row['production_val'] === 'Yes') ? 'checked' : ''; ?>>
                                                            Yes
                                                        </label>
                                                    </td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="production_val"
                                                                value="No"
                                                                <?php echo ($row['production_val'] === 'No') ? 'checked' : ''; ?>>
                                                            No
                                                        </label>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td style="font-weight:600;font-size:12px!important">Quality Assurance</td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="qa_val"
                                                                value="Yes"
                                                                <?php echo ($row['qa_val'] === 'Yes') ? 'checked' : ''; ?>>
                                                            Yes
                                                        </label>
                                                    </td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="qa_val"
                                                                value="No"
                                                                <?php echo ($row['qa_val'] === 'No') ? 'checked' : ''; ?>>
                                                            No
                                                        </label>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td style="font-weight:600;font-size:12px!important">Quality Control</td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="qc_val"
                                                                value="Yes"
                                                                <?php echo ($row['qc_val'] === 'Yes') ? 'checked' : ''; ?>>
                                                            Yes
                                                        </label>
                                                    </td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="qc_val"
                                                                value="No"
                                                                <?php echo ($row['qc_val'] === 'No') ? 'checked' : ''; ?>>
                                                            No
                                                        </label>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td style="font-weight:600;font-size:12px!important">Chemical Warehouse</td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="chemical_warehouse_val"
                                                                value="Yes"
                                                                <?php echo ($row['chemical_warehouse_val'] === 'Yes') ? 'checked' : ''; ?>>
                                                            Yes
                                                        </label>
                                                    </td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="chemical_warehouse_val"
                                                                value="No"
                                                                <?php echo ($row['chemical_warehouse_val'] === 'No') ? 'checked' : ''; ?>>
                                                            No
                                                        </label>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td style="font-weight:600;font-size:12px!important">Packing Warehouse</td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="pwarehouse_val"
                                                                value="Yes"
                                                                <?php echo ($row['packing_warehouse_val'] === 'Yes') ? 'checked' : ''; ?>>
                                                            Yes
                                                        </label>
                                                    </td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="pwarehouse_val"
                                                                value="No"
                                                                <?php echo ($row['packing_warehouse_val'] === 'No') ? 'checked' : ''; ?>>
                                                            No
                                                        </label>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td style="font-weight:600;font-size:12px!important">Finished Goods Warehouse</td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="finished_goods_warehouse_val"
                                                                value="Yes"
                                                                <?php echo ($row['finished_goods_warehouse_val'] === 'Yes') ? 'checked' : ''; ?>>
                                                            Yes
                                                        </label>
                                                    </td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="finished_goods_warehouse_val"
                                                                value="No"
                                                                <?php echo ($row['finished_goods_warehouse_val'] === 'No') ? 'checked' : ''; ?>>
                                                            No
                                                        </label>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td style="font-weight:600;font-size:12px!important">Procurement</td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="procurement_val"
                                                                value="Yes"
                                                                <?php echo ($row['procurement_val'] === 'Yes') ? 'checked' : ''; ?>>
                                                            Yes
                                                        </label>
                                                    </td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="procurement_val"
                                                                value="No"
                                                                <?php echo ($row['procurement_val'] === 'No') ? 'checked' : ''; ?>>
                                                            No
                                                        </label>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td style="font-weight:600;font-size:12px!important">Supply Chain Management</td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="scm_val"
                                                                value="Yes"
                                                                <?php echo ($row['scm_val'] === 'Yes') ? 'checked' : ''; ?>>
                                                            Yes
                                                        </label>
                                                    </td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="scm_val"
                                                                value="No"
                                                                <?php echo ($row['scm_val'] === 'No') ? 'checked' : ''; ?>>
                                                            No
                                                        </label>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td style="font-weight:600;font-size:12px!important">Finance & Accounts</td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="finance_val"
                                                                value="Yes"
                                                                <?php echo ($row['finance_val'] === 'Yes') ? 'checked' : ''; ?>>
                                                            Yes
                                                        </label>
                                                    </td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="finance_val"
                                                                value="No"
                                                                <?php echo ($row['finance_val'] === 'No') ? 'checked' : ''; ?>>
                                                            No
                                                        </label>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td style="font-weight:600;font-size:12px!important">Business Development Department</td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="bdd_val"
                                                                value="Yes"
                                                                <?php echo ($row['bdd_val'] === 'Yes') ? 'checked' : ''; ?>>
                                                            Yes
                                                        </label>
                                                    </td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="bdd_val"
                                                                value="No"
                                                                <?php echo ($row['bdd_val'] === 'No') ? 'checked' : ''; ?>>
                                                            No
                                                        </label>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td style="font-weight:600;font-size:12px!important">Marketing Department</td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="marketing_val"
                                                                value="Yes"
                                                                <?php echo ($row['marketing_val'] === 'Yes') ? 'checked' : ''; ?>>
                                                            Yes
                                                        </label>
                                                    </td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="marketing_val"
                                                                value="No"
                                                                <?php echo ($row['marketing_val'] === 'No') ? 'checked' : ''; ?>>
                                                            No
                                                        </label>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td style="font-weight:600;font-size:12px!important">Research and Development</td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="rnd_val"
                                                                value="Yes"
                                                                <?php echo ($row['rnd_val'] === 'Yes') ? 'checked' : ''; ?>>
                                                            Yes
                                                        </label>
                                                    </td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="rnd_val"
                                                                value="No"
                                                                <?php echo ($row['rnd_val'] === 'No') ? 'checked' : ''; ?>>
                                                            No
                                                        </label>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td style="font-weight:600;font-size:12px!important">Regulatory</td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="regu_val"
                                                                value="Yes"
                                                                <?php echo ($row['regu_val'] === 'Yes') ? 'checked' : ''; ?>>
                                                            Yes
                                                        </label>
                                                    </td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="regu_val"
                                                                value="No"
                                                                <?php echo ($row['regu_val'] === 'No') ? 'checked' : ''; ?>>
                                                            No
                                                        </label>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td style="font-weight:600;font-size:12px!important">Engineering</td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="eng_val"
                                                                value="Yes"
                                                                <?php echo ($row['eng_val'] === 'Yes') ? 'checked' : ''; ?>>
                                                            Yes
                                                        </label>
                                                    </td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="eng_val"
                                                                value="No"
                                                                <?php echo ($row['eng_val'] === 'No') ? 'checked' : ''; ?>>
                                                            No
                                                        </label>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td style="font-weight:600;font-size:12px!important">Microbiology</td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="micro_val"
                                                                value="Yes"
                                                                <?php echo ($row['micro_val'] === 'Yes') ? 'checked' : ''; ?>>
                                                            Yes
                                                        </label>
                                                    </td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="micro_val"
                                                                value="No"
                                                                <?php echo ($row['micro_val'] === 'No') ? 'checked' : ''; ?>>
                                                            No
                                                        </label>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="font-weight:600;font-size:12px!important">Human Resource</td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="hr_val"
                                                                value="Yes"
                                                                <?php echo ($row['hr_val'] === 'Yes') ? 'checked' : ''; ?>>
                                                            Yes
                                                        </label>
                                                    </td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="hr_val"
                                                                value="No"
                                                                <?php echo ($row['hr_val'] === 'No') ? 'checked' : ''; ?>>
                                                            No
                                                        </label>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td style="font-weight:600;font-size:12px!important">IT Department</td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="it_val"
                                                                value="Yes"
                                                                <?php echo ($row['it_val'] === 'Yes') ? 'checked' : ''; ?>>
                                                            Yes
                                                        </label>
                                                    </td>
                                                    <td class="">
                                                        <label>
                                                            <input type="checkbox" class="type-checkbox cbox"
                                                                name="it_val"
                                                                value="No"
                                                                <?php echo ($row['it_val'] === 'No') ? 'checked' : ''; ?>>
                                                            No
                                                        </label>
                                                    </td>
                                                </tr>
                                            </table>
                                            <div class="text-center mt-3">
                                                <div class="text-center mt-4">
                                                    <button type="submit" name="submit" class="btn btn-dark px-4" style="font-size: 14px!important">
                                                        Update
                                                    </button>
                                                </div>
                                            </div>
                                            <?php
                                            include 'dbconfig.php';

                                            // Check if form is submitted
                                            if (isset($_POST['submit'])) {
                                                // Retrieve form data
                                                $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                                                $name =  $_SESSION['fullname'];

                                                $f_administration_val = isset($_POST['administration_val']) && $_POST['administration_val'] !== $row['administration_val'] ? $_POST['administration_val'] : $row['administration_val'];
                                                $f_production_val = isset($_POST['production_val']) && $_POST['production_val'] !== $row['production_val'] ? $_POST['production_val'] : $row['production_val'];
                                                $f_qa_val = isset($_POST['qa_val']) && $_POST['qa_val'] !== $row['qa_val'] ? $_POST['qa_val'] : $row['qa_val'];
                                                $f_qc_val = isset($_POST['qc_val']) && $_POST['qc_val'] !== $row['qc_val'] ? $_POST['qc_val'] : $row['qc_val'];
                                                $f_herb_warehouse_val = isset($_POST['herb_warehouse_val']) && $_POST['herb_warehouse_val'] !== $row['herb_warehouse_val'] ? $_POST['herb_warehouse_val'] : $row['herb_warehouse_val'];
                                                $f_chemical_warehouse_val = isset($_POST['chemical_warehouse_val']) && $_POST['chemical_warehouse_val'] !== $row['chemical_warehouse_val'] ? $_POST['chemical_warehouse_val'] : $row['chemical_warehouse_val'];
                                                $f_packing_warehouse_val = isset($_POST['pwarehouse_val']) && $_POST['pwarehouse_val'] !== $row['pwarehouse_val'] ? $_POST['pwarehouse_val'] : $row['pwarehouse_val'];
                                                $f_finished_goods_warehouse_val = isset($_POST['finished_goods_warehouse_val']) && $_POST['finished_goods_warehouse_val'] !== $row['finished_goods_warehouse_val'] ? $_POST['finished_goods_warehouse_val'] : $row['finished_goods_warehouse_val'];
                                                $f_procurement_val = isset($_POST['procurement_val']) && $_POST['procurement_val'] !== $row['procurement_val'] ? $_POST['procurement_val'] : $row['procurement_val'];
                                                $f_scm_val = isset($_POST['scm_val']) && $_POST['scm_val'] !== $row['scm_val'] ? $_POST['scm_val'] : $row['scm_val'];
                                                $f_finance_val = isset($_POST['finance_val']) && $_POST['finance_val'] !== $row['finance_val'] ? $_POST['finance_val'] : $row['finance_val'];
                                                $f_bdd_val = isset($_POST['bdd_val']) && $_POST['bdd_val'] !== $row['bdd_val'] ? $_POST['bdd_val'] : $row['bdd_val'];
                                                $f_marketing_val = isset($_POST['marketing_val']) && $_POST['marketing_val'] !== $row['marketing_val'] ? $_POST['marketing_val'] : $row['marketing_val'];
                                                $f_rnd_val = isset($_POST['rnd_val']) && $_POST['rnd_val'] !== $row['rnd_val'] ? $_POST['rnd_val'] : $row['rnd_val'];
                                                $f_regu_val = isset($_POST['regu_val']) && $_POST['regu_val'] !== $row['regu_val'] ? $_POST['regu_val'] : $row['regu_val'];
                                                $f_eng_val = isset($_POST['eng_val']) && $_POST['eng_val'] !== $row['eng_val'] ? $_POST['eng_val'] : $row['eng_val'];
                                                $f_micro_val = isset($_POST['micro_val']) && $_POST['micro_val'] !== $row['micro_val'] ? $_POST['micro_val'] : $row['micro_val'];
                                                $f_hr_val = isset($_POST['hr_val']) && $_POST['hr_val'] !== $row['hr_val'] ? $_POST['hr_val'] : $row['hr_val'];
                                                $f_it_val = isset($_POST['it_val']) && $_POST['it_val'] !== $row['it_val'] ? $_POST['it_val'] : $row['it_val'];


                                                $f_date = date('Y-m-d');

                                                $update_query = "UPDATE qc_ccrf SET 
                                
                                    administration_val = '$f_administration_val',
                                    production_val = '$f_production_val',
                                    qa_val = '$f_qa_val',
                                    qc_val = '$f_qc_val',
                                    herb_warehouse_val = '$f_herb_warehouse_val',
                                    chemical_warehouse_val = '$f_chemical_warehouse_val',
                
                                 
                
                                    finished_goods_warehouse_val = '$f_finished_goods_warehouse_val',
                                    procurement_val = '$f_procurement_val',
                                    scm_val = '$f_scm_val',
                                    finance_val = '$f_finance_val',
                                    bdd_val = '$f_bdd_val',
                                    marketing_val = '$f_marketing_val',
                                    rnd_val = '$f_rnd_val',
                                    regu_val = '$f_regu_val',
                                    eng_val = '$f_eng_val',
                                    micro_val = '$f_micro_val',
                                    hr_val = '$f_hr_val',
                                    it_val = '$f_it_val',
                
                                    part_3 = 'Approved'
                                
                                     WHERE id = '$id'";

                                                // Execute update query for qc_ccrf
                                                $result = mysqli_query($conn, $update_query);

                                                if ($result) {
                                                    // Now update the qc_ccrf table for part_2
                                                    $update_ccrf_query = "UPDATE qc_ccrf SET part_2 = 'Approved' WHERE id = '$id'";
                                                    $result_ccrf = mysqli_query($conn, $update_ccrf_query);

                                                    if ($result_ccrf) {
                                                        $subject = "Approval Notification: CCRF ID $id";
                                                        // $baseMessage = "Dear Team,<br><br>CCRF (ID: $id) has been approved on " . date('Y-m-d') . ".<br><br>Approved by: $name.<br><br>Regards,<br>Change Control System";

                                               $baseMessage = "
Dear Concerned Department,<br><br>
A new Change Control Form has been assigned to your department. Please log in to the MedicsFlow application to review and take the necessary action.<br><br>
<a href='http://43.245.128.46:9090/medicsflow/login' target='_blank'>Access MedicsFlow Application</a><br><br>
Thank you,<br>
MedicsFlow Team
";


                                                        // Send emails based on conditions
                                                        if ($f_administration_val === 'Yes') {
                                                            sendPHPMailer('jawwad.ali@medicslab.com', $subject, $baseMessage);
                                                        }

                                                        if ($f_production_val === 'Yes') {
                                                            sendPHPMailer('ehtesham.haq@medicslab.com', $subject, $baseMessage);
                                                        }
                                                        if ($f_qa_val === 'Yes') {
                                                            sendPHPMailer('arif.kafray@medicslab.com', $subject, $baseMessage);
                                                        }

                                                        if ($f_qc_val === 'Yes') {
                                                            sendPHPMailer('kishwer.ejaz@medicslab.com', $subject, $baseMessage);
                                                        }
                                                        if ($f_herb_warehouse_val === 'Yes') {
                                                            sendPHPMailer('izhar.ahmed@medicslab.com', $subject, $baseMessage);
                                                        }

                                                        if ($f_chemical_warehouse_val === 'Yes') {
                                                            sendPHPMailer('mazher.ali@medicslab.com', $subject, $baseMessage);
                                                        }
                                                        if ($f_finished_goods_warehouse_val === 'Yes') {
                                                            sendPHPMailer('shayan.musarrat@medicslab.com', $subject, $baseMessage);
                                                        }

                                                        if ($f_procurement_val === 'Yes') {
                                                            sendPHPMailer('mazher.ali@medicslab.com', $subject, $baseMessage);
                                                        }
                                                        if ($f_scm_val === 'Yes') {
                                                            sendPHPMailer('ehtesham.haq@medicslab.com', $subject, $baseMessage);
                                                        }

                                                        if ($f_finance_val === 'Yes') {
                                                            sendPHPMailer('mustafa.ahmed@medicslab.com', $subject, $baseMessage);
                                                        }
                                                        if ($f_bdd_val === 'Yes') {
                                                            sendPHPMailer('asif.jabbar@medicslab.com', $subject, $baseMessage);
                                                        }
                                                        if ($f_marketing_val === 'Yes') {
                                                            sendPHPMailer('ashhad.hussain@medicslab.com', $subject, $baseMessage);
                                                        }
                                                        if ($f_rnd_val === 'Yes') {
                                                            sendPHPMailer('zeeshan.ahmed@medicslab.com', $subject, $baseMessage);
                                                        }
                                                        if ($f_regu_val === 'Yes') {
                                                            sendPHPMailer('hina.arsalan@medicslab.com', $subject, $baseMessage);
                                                        }
                                                        if ($f_eng_val === 'Yes') {
                                                            sendPHPMailer('taha.khan@medicslab.com', $subject, $baseMessage);
                                                        }
                                                        if ($f_micro_val === 'Yes') {
                                                            sendPHPMailer('abeer.ahmed@medicslab.com', $subject, $baseMessage);
                                                        }
                                                        if ($f_hr_val === 'Yes') {
                                                            sendPHPMailer('taha.ahmed@medicslab.com', $subject, $baseMessage);
                                                        }
                                                        if ($f_it_val === 'Yes') {
                                                            sendPHPMailer('farhan.arif@medicslab.com', $subject, $baseMessage);
                                                        }

                                                        // Additional department checks here...

                                                        echo "<script>alert('Record updated successfully!'); window.location.href = window.location.href;</script>";
                                                    } else {
                                                        echo "<script>alert('Error updating qc_ccrf table!'); window.location.href = window.location.href;</script>";
                                                    }
                                                } else {
                                                    echo "No record found!";
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                            </div>
                    <?php
                }
            } else {
                echo "No record found!";
            }
                    ?>
                        </div>
                    </div>
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
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const checkboxes = document.querySelectorAll('.category-checkbox');

                            checkboxes.forEach(function(checkbox) {
                                checkbox.addEventListener('change', function() {
                                    const groupName = this.name.split('_')[0]; // Extract the group name

                                    // Uncheck other checkboxes in the same group
                                    checkboxes.forEach(function(cb) {
                                        if (cb !== checkbox && cb.name.startsWith(groupName)) {
                                            cb.checked = false;
                                        }
                                    });
                                });
                            });
                        });
                    </script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const checkboxes = document.querySelectorAll('.type-checkbox');

                            checkboxes.forEach(function(checkbox) {
                                checkbox.addEventListener('change', function() {
                                    const groupName = this.name.split('_')[0]; // Extract the group name

                                    // Uncheck other checkboxes in the same group
                                    checkboxes.forEach(function(cb) {
                                        if (cb !== checkbox && cb.name.startsWith(groupName)) {
                                            cb.checked = false;
                                        }
                                    });
                                });
                            });
                        });
                    </script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const checkboxes = document.querySelectorAll('.depart_type-checkbox');

                            checkboxes.forEach(function(checkbox) {
                                checkbox.addEventListener('change', function() {
                                    const groupName = this.name.split('_')[0]; // Extract the group name

                                    // Uncheck other checkboxes in the same group
                                    checkboxes.forEach(function(cb) {
                                        if (cb !== checkbox && cb.name.startsWith(groupName)) {
                                            cb.checked = false;
                                        }
                                    });
                                });
                            });
                        });
                    </script>

                    <script src="assets/js/main.js"></script>
</body>

</html>