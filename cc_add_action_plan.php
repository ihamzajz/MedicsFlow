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
<?php
$id = $_SESSION['id'];
$fname = $_SESSION['fullname'];
$username = $_SESSION['username'];
$role = $_SESSION['role'];
$password = $_SESSION['password'];
$gender = $_SESSION['gender'];
$department = $_SESSION['department'];

$email = $_SESSION['email'];

$be_depart = $_SESSION['be_depart'];
$be_role = $_SESSION['be_role'];

$sa_user = $_SESSION['sa_user'];
$sa_depart = $_SESSION['sa_depart'];
$sa_depart2 = $_SESSION['sa_depart2'];
$sa_depart3 = $_SESSION['sa_depart3'];
$sa_role = $_SESSION['sa_role'];
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
            font-family: 'Poppins', sans-serif !important;
        }

        .btn {
            font-size: 11px;
            color: white;
        }

        .center-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            background-color: rgba(255, 255, 255, 0.8);
            /* optional light background */
        }

        .message-box {
            padding: 20px 30px;
            background-color: #d4edda;
            color: #155724;
            font-weight: bold;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            text-align: center;
        }
    </style>
    <style>
        .btn-brown {
            background-color: #129990;
            padding: 1px 10px !important;
            font-weight: 500;
        }

        .btn-brown:hover {
            background-color: #6A9C89;
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
            font-size: 11.5px !important;
            border: none !important;
            margin: 0px !important;
            margin: 0px !important;
        }

        tr {
            border: 0.5px solid black !important;
        }

        thead {
            border: 1px solid grey !important;
        }

        input[type=checkbox],
        label {
            padding: 0px !important;
            margin: 0px !important;
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
            font-size: 11px !important;
            border-radius: 0px !important;
            border: 0.5px solid #adb5bd !important;
            transition: border-color 0.3s ease !important;
            padding: 10px 5px !important;
            height: 23px !important;
        }

        .bg-menu {
            background-color: #393E46 !important;
        }

        .btn-menu {
            font-size: 12.5px;
            background-color: #FFB22C !important;
            padding: 5px 10px;
            font-weight: 600;
            border: none !important;
        }
    </style>
    <?php
    include 'sidebarcss.php';
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
                    <button type="button" id="sidebarCollapse" class="btn-menu">
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
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col">
                                <form class="form pb-3" method="POST" style="border: 1px solid black; padding: 25px; padding-bottom: 0px; border-radius: 2px;background-color:white!important">
                                    <div style="position: relative; text-align: center;">
                                        <h6 class="pb-1"><b>Add Action Plan</b></h6>
                                        <div style="position: absolute; left: 0; top: 0;">
                                            <a class="btn btn-dark btn-sm" href="cc_home.php">
                                                <i class="fa-solid fa-home"></i> Home
                                            </a>
                                            <!-- <a class="btn btn-dark btn-sm" href="cc_add_action_plan_list.php">
                                                <i class="fa-solid fa-arrow-left"></i> Back
                                            </a> -->
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Event / Action Plan</th>
                                                    <th>Responsiblity</th>
                                                    <th>Timeline</th>
                                                    <th>Email</th>
                                                    <th>Mark Complete/Completion Date</th>
                                                    <th>Verified By Quality Department</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="f_ac_<?php echo $i; ?>" value="<?php echo $row["f_ac_$i"]; ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="f_responsibility_<?php echo $i; ?>" value="<?php echo $row["f_responsibility_$i"]; ?>">
                                                        </td>
                                                        <td>
                                                            <input type="date" name="f_timeline_<?php echo $i; ?>"
                                                                value="<?php echo !empty($row["f_timeline_$i"]) ? htmlspecialchars($row["f_timeline_$i"]) : ''; ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="f_signature_<?php echo $i; ?>" value="<?php echo $row["f_signature_$i"]; ?>">
                                                        </td>
                                                        <!-- WORKDONE BUTTON -->
                                                        <td>
                                                            <?php
                                                            $signatureEmail = $row["f_signature_$i"];
                                                            $workdoneValue  = $row["workdone{$i}"];        // workdone1..workdone10
                                                            $workdoneDate   = $row["workdone{$i}_date"];   // workdone1_date..workdone10_date

                                                            // 1. If workdone exists → show value + date
                                                            if (!empty($workdoneValue)):
                                                            ?>
                                                                <span class="p-3">
                                                                    <?php
                                                                    echo htmlspecialchars($workdoneValue);

                                                                    if (!empty($workdoneDate)) {
                                                                        echo ' (' . date('d-m-Y', strtotime($workdoneDate)) . ')';
                                                                    }
                                                                    ?>
                                                                </span>

                                                            <?php
                                                            // 2. Otherwise show Workdone button (permission based)
                                                            elseif (
                                                                !empty($signatureEmail) &&
                                                                (
                                                                    $signatureEmail === $email ||
                                                                    $be_depart === 'it' ||
                                                                    $be_depart === 'super'
                                                                )
                                                            ):
                                                                $workdonePage = "cc_workdone{$i}.php";
                                                            ?>
                                                                <a href="<?php echo $workdonePage; ?>?id=<?php echo $row['id']; ?>"
                                                                    class="btn btn-primary btn-sm">
                                                                    Workdone
                                                                </a>
                                                            <?php endif; ?>
                                                        </td>



                                                        <td>
                                                            <?php
                                                            $workdoneValue = $row["workdone{$i}"];      // workdone1..10
                                                            $verifyValue   = $row["f_verify_by_$i"];    // f_verify_by_1..10

                                                            // check if user is allowed to verify
                                                            $canVerify =
                                                                $be_depart === 'it' ||
                                                                $be_depart === 'super' ||
                                                                ($be_role === 'approver' && $be_depart === 'qaqc');

                                                            // show verify button only if workdone is Completed
                                                            if ($workdoneValue === 'Completed' && $canVerify):

                                                                // if not yet verified → show button
                                                                if (empty($verifyValue)):
                                                            ?>
                                                                    <a href="cc_qc_verify<?php echo $i; ?>.php?id=<?php echo $row['id']; ?>"
                                                                        class="btn btn-success btn-sm mx-2">
                                                                        <i class="fa-solid fa-check"></i> Verify
                                                                    </a>
                                                                <?php
                                                                // already verified → show text
                                                                else:
                                                                ?>
                                                                    <span class="p-3">
                                                                        <b><?php echo htmlspecialchars($verifyValue); ?></b>
                                                                    </span>
                                                            <?php
                                                                endif;
                                                            endif;
                                                            ?>
                                                        </td>

                                                    </tr>
                                                <?php endfor; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-center mt-4">
                                        <button type="submit" name="submit" class="btn btn-dark px-4" style="font-size: 14px;">
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

                                    $f_f_ac_1 = isset($_POST['f_ac_1']) && $_POST['f_ac_1'] !== $row['f_ac_1'] ? $_POST['f_ac_1'] : $row['f_ac_1'];
                                    $f_f_ac_2 = isset($_POST['f_ac_2']) && $_POST['f_ac_2'] !== $row['f_ac_2'] ? $_POST['f_ac_2'] : $row['f_ac_2'];
                                    $f_f_ac_3 = isset($_POST['f_ac_3']) && $_POST['f_ac_3'] !== $row['f_ac_3'] ? $_POST['f_ac_3'] : $row['f_ac_3'];
                                    $f_f_ac_4 = isset($_POST['f_ac_4']) && $_POST['f_ac_4'] !== $row['f_ac_4'] ? $_POST['f_ac_4'] : $row['f_ac_4'];
                                    $f_f_ac_5 = isset($_POST['f_ac_5']) && $_POST['f_ac_5'] !== $row['f_ac_5'] ? $_POST['f_ac_5'] : $row['f_ac_5'];
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
                                                        f_verify_by_10 = '$f_f_verify_by_10'
                                
                                                        WHERE fk_id = '$id'";

                                    // Execute update query for qc_ccrf2
                                    $result = mysqli_query($conn, $update_query);

                                    if ($result) {
                                        // Now update the qc_ccrf table
                                        $update_ccrf_query = "UPDATE qc_ccrf SET part_2 = 'Approved' WHERE id = '$id'";

                                        // Execute the update query for qc_ccrf
                                        $result_ccrf = mysqli_query($conn, $update_ccrf_query);

                                        if ($result_ccrf) {
                                            // Include PHPMailer
                                            require 'vendor/autoload.php';


                                            // Email subject
                                            $subject = "Action Plan Assigned – CCRF ID $id";

                                            // Sender name
                                            $sender = $_SESSION['fullname'];

                                            // Form link
                                            $formLink = "http://43.245.128.46:9090/medicsflow/cc_add_action_plan?id=$id";

                                            // Email body
                                            $baseMessage = "
Dear Concern Department,<br><br>

A new action plan has been assigned to you by <strong>$sender</strong>.<br><br>

<strong>Form ID:</strong> CCRF-$id<br><br>

Please click the link below to view and complete your assigned task:<br>
<a href='$formLink' target='_blank'>$formLink</a><br><br>

Thanks & Regards,<br>
Medics Digital Form System
";

                                            // Track already emailed addresses (avoid duplicates)
                                            $sentEmails = [];

                                            // Loop through all signature fields
                                            for ($i = 1; $i <= 10; $i++) {

                                                $field = 'f_signature_' . $i;

                                                // Old email from database
                                                $oldEmail = $row[$field] ?? '';

                                                // New email from submitted form
                                                $newEmail = $_POST[$field] ?? '';

                                                // Send email ONLY if new/changed
                                                if (
                                                    !empty($newEmail) &&
                                                    filter_var($newEmail, FILTER_VALIDATE_EMAIL) &&
                                                    $newEmail !== $oldEmail &&
                                                    !in_array($newEmail, $sentEmails)
                                                ) {
                                                    sendPHPMailer($newEmail, $subject, $baseMessage);
                                                    $sentEmails[] = $newEmail;
                                                }
                                            }
                                            // Both updates successful
                                            echo "<script>alert('Record updated successfully!');
                                
                                window.location.href = 'cc_add_action_plan?id=" . $id . "';
                                </script>";
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

    <script src="assets/js/main.js"></script>
</body>

</html>
<?php
if (isset($_SESSION['success'])) {
    echo "<div style='color: green; font-weight: bold; margin-bottom: 10px;'>" . $_SESSION['success'] . "</div>";
    unset($_SESSION['success']); // remove it after showing
}
?>