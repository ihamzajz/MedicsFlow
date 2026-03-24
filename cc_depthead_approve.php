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
$date = date('Y-m-d H:i:s');
$reason = $_GET['reason'];

$update = "UPDATE qc_ccrf SET dept_head_status = 'Approved', dept_head_date = '$date', dept_head_comment = '$reason' WHERE id = $id";
$update_q = mysqli_query($conn, $update);

// Proceed only if update was successful
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
        // $mail->addAddress('ihamzajz@gmail.com', 'QC Head');

       
         $mail->addAddress('sadia.iqbal@medicslab.com'); // The recipient's email address

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Change Control Form Update";
        $mail->Body = "
<p>Dear QC Head,</p>

<p>A Change Control Form (ID: <strong>$id</strong>) has been approved by the Departmental Head.</p>

<p><strong>Reason for Approval:</strong> $reason<br>
<strong>Date:</strong> $date</p>

<p>Please visit <a href='http://43.245.128.46:9090/medicsflow'>MedicsFlow</a> at your earliest convenience to review the form and take any necessary actions.</p>

<p>Thank you for your prompt attention.</p>

<p>Best regards,<br>
MedicsFlow</p>
";


        $mail->send();
        // Redirect after success
        header("Location:cc_depthead_list.php");
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        // Still redirect (optional)
        header("Location:cc_depthead_list.php");
        exit();
    }
} else {
    echo "Database update failed.";
    header("Location:cc_depthead_list.php");
    exit();
}
