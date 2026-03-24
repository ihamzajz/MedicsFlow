<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendPHPMailer($to, $subject, $body)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.office365.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@medicslab.com';
        $mail->Password   = 'kcmzrskfgmwzzshz';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('info@medicslab.com', 'Medics Digital Form');
        $mail->addAddress($to);

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
    <title>Change Control Request Form</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
   body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f6fa;
        }
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

        .btn-menu {
            font-size: 12.5px;
            font-weight: 600;
            background-color: #FFB22C !important;
            padding: 5px 10px;
            border: none !important;
            border-radius: 2px !important;
            color: black!important;
        }

        .btn-light {
            font-size: 13px;
            font-weight: 400;
        }


        .table-1 td,
        .table-2 td,
        .table-3 td {
            padding: 7px 10px !important;
        }

        .ul-msg li {
            font-size: 12px;
            font-weight: 500;
            padding-top: 10px
        }

        th {
            font-size: 11px !important;
            border: none !important;
            background-color: #ced4da !important;
            color: black !important;
            font-weight: 600 !important;
        }

        td {
            font-size: 11px !important;
            background-color: White !important;
            color: black !important;
            border: 1px solid grey !important;
            padding: 0px !important;
        }

        thead {
            border: 1px solid grey !important;
        }

        input[type=checkbox],
        label {
            padding: 0px !important;
            margin: 0px !important;
        }

        .btn-submit {
            font-size: 17px !important;
            color: white;
            background-color: #0d6efd;
            padding: 5px 35px;
            border-radius: 2px;
            border: 2px solid #0D9276;
            letter-spacing: 1.35px;
            font-weight: 500;
        }

        .btn-submit:hover {
            font-size: 17px !important;
            color: white;
            background-color: #0d6efd;
            padding: 5px 35px;
            border-radius: 2px;
            border: 2px solid #0D9276;
            letter-spacing: 1.35px;
            font-weight: 500;
        }

        .cbox {
            height: 13px !important;
            width: 13px !important;
        }
        p {
            font-size: 11.7px !important;
            padding: 0px !important;
            margin: 0px !important;
            font-weight: 500 !important;
            display: inline !important;
            margin-right: 10px !important;
        }
        input {
            width: 100% !important;
            font-size: 11.7px !important;
            border-radius: 0px !important;
            border: none !important;
            transition: border-color 0.3s ease !important;
            padding: 5px 5px !important;
            letter-spacing: 0.4px !important;
            height: 25px !important;
        }

        input:focus {
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
        }

    
    </style>
    <?php
    include 'sidebarcss.php'
    ?>
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
            $select = "SELECT * FROM qc_ccrf2 WHERE
                    fk_id = '$id'";

            $select_q = mysqli_query($conn, $select);
            $data = mysqli_num_rows($select_q);
            ?>
            <?php
            if ($data) {
                while ($row = mysqli_fetch_array($select_q)) {
            ?>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col ">
                                <form class="form pb-3" method="POST">




                                    <div class="card shadow mt-3">
                                        <div class="card-header bg-dark text-white d-flex align-items-center">
                                            <h6 class="mb-0 main-heading">Consequences + Revision</h6>

                                            <div class="ms-auto">
                                                <a href="cc_home.php" class="btn btn-light btn-sm me-2">Home</a>
                                                <a href="cc_user_forms.php" class="btn btn-light btn-sm me-2">Back</a>
                                                <a href="cc_form4.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">
                                                 Assign To Department
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body">






                                            <div class="table-responsive">
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
                                                            <td class="p-1">Cost</td>
                                                            <td class="p-1">
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
                                                            <td class="p-1">
                                                                <input type="text" name="cost_input"
                                                                    value="<?php echo htmlspecialchars($row['g_cost_2'] ?? '', ENT_QUOTES); ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-1">Manufacturing</td>
                                                            <td class="p-1">
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
                                                            <td class="p-1">
                                                                <input type="text" name="manufacturing_input"
                                                                    value="<?php echo htmlspecialchars($row['g_manufacturing_2'] ?? '', ENT_QUOTES); ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-1">Master Formula Record/BOM</td>
                                                            <td class="p-1">
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
                                                            <td class="p-1">
                                                                <input type="text" name="master_formula_input"
                                                                    value="<?php echo htmlspecialchars($row['g_master_formula_2'] ?? '', ENT_QUOTES); ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-1">Packaging/Labeling</td>
                                                            <td class="p-1">
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
                                                            <td class="p-1">
                                                                <input type="text" name="packaging_input"
                                                                    value="<?php echo htmlspecialchars($row['g_packaging_2'] ?? '', ENT_QUOTES); ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-1">Testing</td>
                                                            <td class="p-1">
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
                                                            <td class="p-1">
                                                                <input type="text" name="testing_input"
                                                                    value="<?php echo htmlspecialchars($row['g_testing_2'] ?? '', ENT_QUOTES); ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-1">Product stability</td>
                                                            <td class="p-1">
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
                                                            <td class="p-1">
                                                                <input type="text" name="product_stability_input"
                                                                    value="<?php echo htmlspecialchars($row['g_product_stability_2'] ?? '', ENT_QUOTES); ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-1">Product quality/specification</td>
                                                            <td class="p-1">
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
                                                            <td class="p-1">
                                                                <input type="text" name="product_quality_input"
                                                                    value="<?php echo htmlspecialchars($row['g_product_quality_2'] ?? '', ENT_QUOTES); ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-1">Product supply</td>
                                                            <td class="p-1">
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
                                                            <td class="p-1">
                                                                <input type="text" name="product_supply_input"
                                                                    value="<?php echo htmlspecialchars($row['g_product_supply_2'] ?? '', ENT_QUOTES); ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-1">Efficacy</td>
                                                            <td class="p-1">
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
                                                            <td class="p-1">
                                                                <input type="text" name="efficacy_input"
                                                                    value="<?php echo htmlspecialchars($row['g_efficacy_2'] ?? '', ENT_QUOTES); ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-1">Equipment impact</td>
                                                            <td class="p-1">
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
                                                            <td class="p-1">
                                                                <input type="text" name="equipment_impact_input"
                                                                    value="<?php echo htmlspecialchars($row['g_equipment_impact_2'] ?? '', ENT_QUOTES); ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-1">Name of product impact</td>
                                                            <td class="p-1">
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
                                                            <td class="p-1">
                                                                <input type="text" name="name_of_product_impact_input"
                                                                    value="<?php echo htmlspecialchars($row['g_name_of_product_impact_2'] ?? '', ENT_QUOTES); ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-1">Change in SOP</td>
                                                            <td class="p-1">
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
                                                            <td class="p-1">
                                                                <input type="text" name="change_in_sop_input"
                                                                    value="<?php echo htmlspecialchars($row['g_change_in_sop_2'] ?? '', ENT_QUOTES); ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-1">Validation</td>
                                                            <td class="p-1">
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
                                                            <td class="p-1">
                                                                <input type="text" name="validation_input"
                                                                    value="<?php echo htmlspecialchars($row['g_validation_2'] ?? '', ENT_QUOTES); ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-1">Qualification</td>
                                                            <td class="p-1">
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
                                                            <td class="p-1">
                                                                <input type="text" name="qualification_input"
                                                                    value="<?php echo htmlspecialchars($row['g_qualification_2'] ?? '', ENT_QUOTES); ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-1">Calibration</td>
                                                            <td class="p-1">
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
                                                            <td class="p-1">
                                                                <input type="text" name="calibration_input"
                                                                    value="<?php echo htmlspecialchars($row['g_calibration_2'] ?? '', ENT_QUOTES); ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-1">Marketing Impact (local/export)</td>
                                                            <td class="p-1">
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
                                                            <td class="p-1">
                                                                <input type="text" name="marketing_impact_input"
                                                                    value="<?php echo htmlspecialchars($row['g_marketing_impact_2'] ?? '', ENT_QUOTES); ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-1">Registration</td>
                                                            <td class="p-1">
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
                                                            <td class="p-1">
                                                                <input type="text" name="registration_input"
                                                                    value="<?php echo htmlspecialchars($row['g_registration_2'] ?? '', ENT_QUOTES); ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-1">Training Required</td>
                                                            <td class="p-1">
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
                                                            <td class="p-1">
                                                                <input type="text" name="training_required_input"
                                                                    value="<?php echo htmlspecialchars($row['g_training_required_2'] ?? '', ENT_QUOTES); ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-1">Regulatory requirement</td>
                                                            <td class="p-1">
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
                                                            <td class="p-1">
                                                                <input type="text" name="regulatory_requirement_input"
                                                                    value="<?php echo htmlspecialchars($row['g_regulatory_requirement_2'] ?? '', ENT_QUOTES); ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-1">Any Other</td>
                                                            <td class="p-1">
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
                                                            <td class="p-1">
                                                                <input type="text" name="any_other_input"
                                                                    value="<?php echo htmlspecialchars($row['g_any_other_2'] ?? '', ENT_QUOTES); ?>">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>

                                            <!-- form 9 -->
                                            
                                            <p><b>Documents Needing Revision as a result of the Change:</b></p>
                                            <table class="table">
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
                                                        <td class="p-1">Bill(s) of Materials</td>
                                                        <td class="p-1">
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
                                                        <td class="p-1">
                                                            <input type="text" name="bills_of_materials_2"
                                                                value="<?php echo htmlspecialchars($row['h_bills_of_materials_2'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                        <td class="p-1">
                                                            <input type="text" name="bills_of_materials_3"
                                                                value="<?php echo htmlspecialchars($row['h_bills_of_materials_3'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1">Calibration document(s)</td>
                                                        <td class="p-1">
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
                                                        <td class="p-1">
                                                            <input type="text" name="calibration_document_input1"
                                                                value="<?php echo htmlspecialchars($row['h_calibration_documents_2'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                        <td class="p-1">
                                                            <input type="text" name="calibration_document_input2"
                                                                value="<?php echo htmlspecialchars($row['h_calibration_documents_3'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1">Contract(s) Supplier & Quality Agreements</td>
                                                        <td class="p-1">
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
                                                        <td class="p-1">
                                                            <input type="text" name="contracts_input2"
                                                                value="<?php echo htmlspecialchars($row['h_contracts_2'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                        <td class="p-1">
                                                            <input type="text" name="contracts_input3"
                                                                value="<?php echo htmlspecialchars($row['h_contracts_3'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1">Master batch records(s)</td>
                                                        <td class="p-1">
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
                                                        <td class="p-1">
                                                            <input type="text" name="master_batch_input1"
                                                                value="<?php echo htmlspecialchars($row['h_master_batch_records_2'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                        <td class="p-1">
                                                            <input type="text" name="master_batch_input2"
                                                                value="<?php echo htmlspecialchars($row['h_master_batch_records_3'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1">Material Characterization/Specification(s)</td>
                                                        <td class="p-1">
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
                                                        <td class="p-1">
                                                            <input type="text" name="material_characterization_input2"
                                                                value="<?php echo htmlspecialchars($row['h_material_characterization_2'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                        <td class="p-1">
                                                            <input type="text" name="material_characterization_input3"
                                                                value="<?php echo htmlspecialchars($row['h_material_characterization_3'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1">Master imprinted packaging material</td>
                                                        <td class="p-1">
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
                                                        <td class="p-1">
                                                            <input type="text" name="master_imprinted_input2"
                                                                value="<?php echo htmlspecialchars($row['h_master_imprinted_packaging_material_2'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                        <td class="p-1">
                                                            <input type="text" name="master_imprinted_input3"
                                                                value="<?php echo htmlspecialchars($row['h_master_imprinted_packaging_material_3'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1">Master packaging record(s)</td>
                                                        <td class="p-1">
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
                                                        <td class="p-1">
                                                            <input type="text" name="master_packaging_input2"
                                                                value="<?php echo htmlspecialchars($row['h_master_packaging_records_2'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                        <td class="p-1">
                                                            <input type="text" name="master_packaging_input3"
                                                                value="<?php echo htmlspecialchars($row['h_master_packaging_records_3'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1">Stability report(s)</td>
                                                        <td class="p-1">
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
                                                        <td class="p-1">
                                                            <input type="text" name="stability_report_input1"
                                                                value="<?php echo htmlspecialchars($row['h_stability_report_2'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                        <td class="p-1">
                                                            <input type="text" name="stability_report_input2"
                                                                value="<?php echo htmlspecialchars($row['h_stability_report_3'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1">Standard Operating Procedure(s)</td>
                                                        <td class="p-1">
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
                                                        <td class="p-1">
                                                            <input type="text" name="standard_operating_input1"
                                                                value="<?php echo htmlspecialchars($row['h_standard_operating_procedure_2'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                        <td class="p-1">
                                                            <input type="text" name="standard_operating_input2"
                                                                value="<?php echo htmlspecialchars($row['h_standard_operating_procedure_3'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1">Testing Monograph(s)</td>
                                                        <td class="p-1">
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
                                                        <td class="p-1">
                                                            <input type="text" name="testing_monograph_input2"
                                                                value="<?php echo htmlspecialchars($row['h_testing_monograph_2'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                        <td class="p-1">
                                                            <input type="text" name="testing_monograph_input3"
                                                                value="<?php echo htmlspecialchars($row['h_testing_monograph_3'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1">Training document(s)</td>
                                                        <td class="p-1">
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
                                                        <td class="p-1">
                                                            <input type="text" name="tdocument_input2"
                                                                value="<?php echo htmlspecialchars($row['h_training_document_2'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                        <td class="p-1">
                                                            <input type="text" name="tdocument_input3"
                                                                value="<?php echo htmlspecialchars($row['h_training_document_3'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1">Plant drawing(s)</td>
                                                        <td class="p-1">
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
                                                        <td class="p-1">
                                                            <input type="text" name="plant_drawing_input1"
                                                                value="<?php echo htmlspecialchars($row['h_plant_drawings_2'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                        <td class="p-1">
                                                            <input type="text" name="plant_drawing_input2"
                                                                value="<?php echo htmlspecialchars($row['h_plant_drawings_3'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1">Qualification Protocol(s)</td>
                                                        <td class="p-1">
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
                                                        <td class="p-1">
                                                            <input type="text" name="qualification_protocol_input1"
                                                                value="<?php echo htmlspecialchars($row['h_qualification_protocols_2'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                        <td class="p-1">
                                                            <input type="text" name="qualification_protocol_input2"
                                                                value="<?php echo htmlspecialchars($row['h_qualification_protocols_3'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1">Qualification report(s)</td>
                                                        <td class="p-1">
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
                                                        <td class="p-1">
                                                            <input type="text" name="qualification_report_input1"
                                                                value="<?php echo htmlspecialchars($row['h_qualification_reports_2'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                        <td class="p-1">
                                                            <input type="text" name="qualification_report_input2"
                                                                value="<?php echo htmlspecialchars($row['h_qualification_reports_3'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1">Registration dossier(s)</td>
                                                        <td class="p-1">
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
                                                        <td class="p-1">
                                                            <input type="text" name="registration_dossier_input1"
                                                                value="<?php echo htmlspecialchars($row['h_registration_dossiers_2'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                        <td class="p-1">
                                                            <input type="text" name="registration_dossier_input2"
                                                                value="<?php echo htmlspecialchars($row['h_registration_dossiers_3'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1">Validation Protocol(s)</td>
                                                        <td class="p-1">
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
                                                        <td class="p-1">
                                                            <input type="text" name="validation_protocol_input1"
                                                                value="<?php echo htmlspecialchars($row['h_validation_protocols_2'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                        <td class="p-1">
                                                            <input type="text" name="validation_protocol_input2"
                                                                value="<?php echo htmlspecialchars($row['h_validation_protocols_3'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1">Validation report(s)</td>
                                                        <td class="p-1">
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
                                                        <td class="p-1">
                                                            <input type="text" name="validation_report_input1"
                                                                value="<?php echo htmlspecialchars($row['h_validation_reports_2'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                        <td class="p-1">
                                                            <input type="text" name="validation_report_input2"
                                                                value="<?php echo htmlspecialchars($row['h_validation_reports_3'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="p-1">other</td>
                                                        <td class="p-1">
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
                                                        <td class="p-1">
                                                            <input type="text" name="others_input1"
                                                                value="<?php echo htmlspecialchars($row['h_others_2'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                        <td class="p-1">
                                                            <input type="text" name="others_input2"
                                                                value="<?php echo htmlspecialchars($row['h_others_3'] ?? '', ENT_QUOTES); ?>">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <!-- <div class="text-center mt-3">
                                    <button type="submit" class="btn-submit" name="submit">Submit</button>
                                </div> -->
                                            <div class="text-center mt-4">
                                                <button type="submit" name="submit" class="btn btn-dark px-4" style="font-size:15px!important;font-weight:600!important">
                                                    Submit
                                                </button>
                                            </div>
                                </form>
                                <?php
                                include 'dbconfig.php';

                                // Check if form is submitted
                                if (isset($_POST['submit'])) {
                                    // Retrieve form data
                                    $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                                    $name =  $_SESSION['fullname'];

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
                                    $f_bills_of_material_input1 = isset($_POST['bills_of_materials_2']) && $_POST['bills_of_materials_2'] !== $row['bills_of_materials_2'] ? $_POST['bills_of_materials_2'] : $row['bills_of_materials_2'];
                                    $f_bills_of_material_input2 = isset($_POST['bills_of_materials_3']) && $_POST['bills_of_materials_3'] !== $row['bills_of_materials_3'] ? $_POST['bills_of_materials_3'] : $row['bills_of_materials_3'];

                                    $f_calibration_document_yes_no = isset($_POST['cdocument_yes_no']) && $_POST['cdocument_yes_no'] !== $row['cdocument_yes_no'] ? $_POST['cdocument_yes_no'] : $row['cdocument_yes_no'];
                                    $f_calibration_document_input1 = isset($_POST['calibration_document_input1']) && $_POST['calibration_document_input1'] !== $row['calibration_document_input1'] ? $_POST['calibration_document_input1'] : $row['calibration_document_input1'];
                                    $f_calibration_document_input2 = isset($_POST['calibration_document_input2']) && $_POST['calibration_document_input2'] !== $row['calibration_document_input2'] ? $_POST['calibration_document_input2'] : $row['calibration_document_input2'];

                                    $f_contracts_yes_no = isset($_POST['contracts_yes_no']) && $_POST['contracts_yes_no'] !== $row['contracts_yes_no'] ? $_POST['contracts_yes_no'] : $row['contracts_yes_no'];
                                    $f_contracts_input1 = isset($_POST['contracts_input2']) && $_POST['contracts_input2'] !== $row['contracts_input2'] ? $_POST['contracts_input2'] : $row['contracts_input2'];
                                    $f_contracts_input2 = isset($_POST['contracts_input3']) && $_POST['contracts_input3'] !== $row['contracts_input3'] ? $_POST['contracts_input3'] : $row['contracts_input3'];

                                    $f_master_batch_yes_no = isset($_POST['mbatch_yes_no']) && $_POST['mbatch_yes_no'] !== $row['mbatch_yes_no'] ? $_POST['mbatch_yes_no'] : $row['mbatch_yes_no'];
                                    $f_master_batch_input1 = isset($_POST['master_batch_input1']) && $_POST['master_batch_input1'] !== $row['master_batch_input1'] ? $_POST['master_batch_input1'] : $row['master_batch_input1'];
                                    $f_master_batch_input2 = isset($_POST['master_batch_input2']) && $_POST['master_batch_input2'] !== $row['master_batch_input2'] ? $_POST['master_batch_input2'] : $row['master_batch_input2'];

                                    $f_material_characterization_yes_no = isset($_POST['material_characterization_yes_no']) && $_POST['material_characterization_yes_no'] !== $row['material_characterization_yes_no'] ? $_POST['material_characterization_yes_no'] : $row['material_characterization_yes_no'];
                                    $f_material_characterization_input1 = isset($_POST['material_characterization_input2']) && $_POST['material_characterization_input2'] !== $row['material_characterization_input2'] ? $_POST['material_characterization_input2'] : $row['material_characterization_input2'];
                                    $f_material_characterization_input2 = isset($_POST['material_characterization_input3']) && $_POST['material_characterization_input3'] !== $row['material_characterization_input3'] ? $_POST['material_characterization_input3'] : $row['material_characterization_input3'];


                                    //    second part
                                    $f_master_imprinted_yes_no = isset($_POST['mimprinted_yes_no']) && $_POST['mimprinted_yes_no'] !== $row['mimprinted_yes_no'] ? $_POST['mimprinted_yes_no'] : $row['mimprinted_yes_no'];
                                    $f_master_imprinted_input1 = isset($_POST['master_imprinted_input2']) && $_POST['master_imprinted_input2'] !== $row['master_imprinted_input2'] ? $_POST['master_imprinted_input2'] : $row['master_imprinted_input2'];
                                    $f_master_imprinted_input2 = isset($_POST['master_imprinted_input3']) && $_POST['master_imprinted_input3'] !== $row['master_imprinted_input3'] ? $_POST['master_imprinted_input3'] : $row['master_imprinted_input3'];

                                    $f_master_packaging_yes_no = isset($_POST['mpackaging_yes_no']) && $_POST['mpackaging_yes_no'] !== $row['mpackaging_yes_no'] ? $_POST['mpackaging_yes_no'] : $row['mpackaging_yes_no'];
                                    $f_master_packaging_input1 = isset($_POST['master_packaging_input2']) && $_POST['master_packaging_input2'] !== $row['master_packaging_input2'] ? $_POST['master_packaging_input2'] : $row['master_packaging_input2'];
                                    $f_master_packaging_input2 = isset($_POST['master_packaging_input3']) && $_POST['master_packaging_input3'] !== $row['master_packaging_input3'] ? $_POST['master_packaging_input3'] : $row['master_packaging_input3'];

                                    $f_stability_report_yes_no = isset($_POST['stability_report_yes_no']) && $_POST['stability_report_yes_no'] !== $row['stability_report_yes_no'] ? $_POST['stability_report_yes_no'] : $row['stability_report_yes_no'];
                                    $f_stability_report_input1 = isset($_POST['stability_report_input1']) && $_POST['stability_report_input1'] !== $row['stability_report_input1'] ? $_POST['stability_report_input1'] : $row['stability_report_input1'];
                                    $f_stability_report_input2 = isset($_POST['stability_report_input2']) && $_POST['stability_report_input2'] !== $row['stability_report_input2'] ? $_POST['stability_report_input2'] : $row['stability_report_input2'];

                                    $f_standard_operating_yes_no = isset($_POST['standard_operating_yes_no']) && $_POST['standard_operating_yes_no'] !== $row['standard_operating_yes_no'] ? $_POST['standard_operating_yes_no'] : $row['standard_operating_yes_no'];
                                    $f_standard_operating_input1 = isset($_POST['standard_operating_input1']) && $_POST['standard_operating_input1'] !== $row['standard_operating_input1'] ? $_POST['standard_operating_input1'] : $row['standard_operating_input1'];
                                    $f_standard_operating_input2 = isset($_POST['standard_operating_input2']) && $_POST['standard_operating_input2'] !== $row['standard_operating_input2'] ? $_POST['standard_operating_input2'] : $row['standard_operating_input2'];

                                    $f_testing_monograph_yes_no = isset($_POST['tmonograph_yes_no']) && $_POST['tmonograph_yes_no'] !== $row['tmonograph_yes_no'] ? $_POST['tmonograph_yes_no'] : $row['tmonograph_yes_no'];
                                    $f_testing_monograph_input1 = isset($_POST['testing_monograph_input2']) && $_POST['testing_monograph_input2'] !== $row['testing_monograph_input2'] ? $_POST['testing_monograph_input2'] : $row['testing_monograph_input2'];
                                    $f_testing_monograph_input2 = isset($_POST['testing_monograph_input3']) && $_POST['testing_monograph_input3'] !== $row['testing_monograph_input3'] ? $_POST['testing_monograph_input3'] : $row['testing_monograph_input3'];

                                    // third part
                                    $f_training_document_yes_no = isset($_POST['tdocument_yes_no']) && $_POST['tdocument_yes_no'] !== $row['tdocument_yes_no'] ? $_POST['tdocument_yes_no'] : $row['tdocument_yes_no'];
                                    $f_training_document_input1 = isset($_POST['tdocument_input2']) && $_POST['tdocument_input2'] !== $row['tdocument_input2'] ? $_POST['tdocument_input2'] : $row['tdocument_input2'];
                                    $f_training_document_input2 = isset($_POST['tdocument_input3']) && $_POST['tdocument_input3'] !== $row['tdocument_input3'] ? $_POST['tdocument_input3'] : $row['tdocument_input3'];

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
                                    $f_others_input1 = isset($_POST['others_input1']) && $_POST['others_input1'] !== $row['others_input1'] ? $_POST['others_input1'] : $row['others_input1'];
                                    $f_others_input2 = isset($_POST['others_input2']) && $_POST['others_input2'] !== $row['others_input2'] ? $_POST['others_input2'] : $row['others_input2'];






                                    $f_date = date('Y-m-d');

                                    $update_query = "UPDATE qc_ccrf2 SET 
                                               
                                                       
                                
                                
                                
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
                                                        g_efficacy_2 = '$f_efficacy_input',
                                
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
                                                        h_others_2 = '$f_others_input1',
                                                        h_others_3 = '$f_others_input2',
                                
       
                                
                                                        part_3 = 'Approved'
                                
                                                       
                                
                                                      
                                
                                
                                                        WHERE fk_id = '$id'";

                                    // Execute update query for qc_ccrf2
                                    $result = mysqli_query($conn, $update_query);

                                    if ($result) {
                                        // Now update the qc_ccrf table
                                        $update_ccrf_query = "UPDATE qc_ccrf SET part_2 = 'Approved' WHERE id = '$id'";

                                        // Execute the update query for qc_ccrf
                                        $result_ccrf = mysqli_query($conn, $update_ccrf_query);

                                         // Update successful
                                        echo "<script>alert('Record updated successfully!');
                                        window.location.href = 'cc_form3?id=" . $id . "';
                                        
                                        </script>";
                                        // Redirect or perform additional actions as needed
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