<?php
// Import PHPMailer classes BEFORE any other PHP code
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id = (int) $_GET['id'];
$reason = mysqli_real_escape_string($conn, $_GET['reason']);
$user_email = mysqli_real_escape_string($conn, $_GET['user_email']);
$user_name = mysqli_real_escape_string($conn, $_GET['user_name']);
$date = date('Y-m-d H:i:s');

// Update database
$update = "UPDATE qc_ccrf SET qchead_status = 'Approved', qchead_date = '$date', qchead_comment = '$reason' WHERE id = $id";
$update_q = mysqli_query($conn, $update);

if ($update_q) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host       = 'smtp.office365.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@medicslab.com';
        $mail->Password   = 'kcmzrskfgmwzzshz'; // Use env vars in production
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('info@medicslab.com', 'Medics Digital Form');
        $mail->addAddress($user_email, $user_name);
        // $mail->addCC('ihamzajz@gmail.com', 'QC HEAD');

        $mail->addCC('sadia.saeed@medicslab.com', 'QC HEAD');

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Change Control Form Approved";
        $mail->Body = "
<p>Dear <strong>$user_name</strong>,</p>

<p>Your Change Control Request (CCRF) has been <strong style='color:green;'>approved</strong> by the Quality Head.</p>

<p><strong>Remarks:</strong> $reason<br>
<strong>Date:</strong> $date</p>

<p>Please visit <a href='http://43.245.128.46:9090/medicsflow'>MedicsFlow</a> to review the approval and proceed with any next steps.</p>



<p>Best regards,<br>
MedicsFlow</p>
";

        $mail->send();
        header("Location:cc_qchead_list.php");
        exit();
    } catch (Exception $e) {
        echo "Approval Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header("Location:cc_qchead_list.php");
        exit();
    }
} else {
    echo "Database update failed.";
    header("Location:cc_qchead_list.php");
    exit();
}
