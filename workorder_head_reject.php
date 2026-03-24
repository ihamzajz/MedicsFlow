<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id            = $_GET['id'];
$email         = $_GET['email'];
$user_name     = $_GET['name'];
$approver_name = $_SESSION['fullname'];
$date          = date('Y-m-d H:i:s');

/* =========================
   Update DB
========================= */
$update = "
UPDATE workorder_form 
SET 
    head_status = 'Rejected',
    head_msg    = 'Rejected By $approver_name',
    head_date   = '$date',
    task_status = 'Rejected By $approver_name',
    final_status = 'Rejected'
WHERE id = $id
";
mysqli_query($conn, $update);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    /* =========================
       SMTP Settings
    ========================= */
    $mail->SMTPDebug   = 0;
    $mail->Debugoutput = 'error_log';
    $mail->isSMTP();
    $mail->Host       = 'smtp.office365.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@medicslab.com';
    $mail->Password   = 'kcmzrskfgmwzzshz';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    /* =========================
       Recipient
    ========================= */
    $mail->setFrom('info@medicslab.com', 'Medics Digital Form');
    $mail->addAddress($email);

    /* =========================
       Email Content
    ========================= */
    $mail->isHTML(true);
    $mail->Subject = "Workorder Notification";
    $mail->Body = "
    <p>Dear {$user_name},</p>

    <p>
    We regret to inform you that your work order request
    <strong>#{$id}</strong> has been <strong>rejected</strong> by
    <strong>{$approver_name}</strong>.
    </p>

    <p>
    If you require further clarification or wish to discuss this decision,
    please feel free to reach out.
    </p>

    <p>Thank you for your understanding.</p>

    <p>
    Best regards,<br>
    <strong>MedicsFlow</strong>
    </p>
    ";

    $mail->send();
    header("Location:workorder_head_list.php");
    exit;

} catch (Exception $e) {
    error_log($mail->ErrorInfo);
    header("Location:workorder_head_list.php");
    exit;
}
?>
