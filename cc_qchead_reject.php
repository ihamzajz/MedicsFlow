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

$id = $_GET['id'];
$reason = $_GET['reason'];
$user_email = $_GET['user_email'];
$user_name = $_GET['user_name'];
$date = date('Y-m-d H:i:s');

$update = "UPDATE qc_ccrf SET qchead_status = 'Rejected', qchead_date = '$date', reject_reason = '$reason' WHERE id = $id";
$update_q = mysqli_query($conn, $update);

/// Proceed only if update was successful
if ($update_q) {
    // Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Turn this off in production
        $mail->isSMTP();
        $mail->Host       = 'smtp.office365.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@medicslab.com';
        $mail->Password   = 'kcmzrskfgmwzzshz'; // Consider using environment variables instead
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('info@medicslab.com', 'Medics Digital Form');
        $mail->addAddress($user_email, $user_name);
        // $mail->addCC('ihamzajz@gmail.com', 'QC HEAD');

        $mail->addCC('sadia.saeed@medicslab.com', 'QC HEAD');

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Change Control Form Update";
        $mail->Body = "
<p>Dear <strong>$user_name</strong>,</p>

<p>Your Change Control Request (CCRF) has been <strong style='color:red;'>rejected</strong> by the Quality Head.</p>

<p><strong>Remarks:</strong> $reason</p>

<p>Please visit <a href='http://43.245.128.46:9090/medicsflow'>MedicsFlow</a> to review the rejection details and take any necessary follow-up actions.</p>


<p>Best regards,<br>
MedicsFlow</p>
";


        $mail->send();
        // Redirect after success
        header("Location:cc_qchead_list.php");
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        // Still redirect (optional)
        header("Location:cc_qchead_list.php");
        exit();
    }
} else {
    echo "Database update failed.";
    header("Location:cc_qchead_list.php");
    exit();
}
