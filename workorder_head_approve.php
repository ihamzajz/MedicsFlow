<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id        = $_GET['id'];
$email     = $_GET['email'];
$user_name = $_GET['name'];
$type      = $_GET['type'];
$category  = $_GET['category'];

$approver_name = $_SESSION['fullname'];
$depart_type   = $_SESSION['depart_type'];
$date          = date('Y-m-d H:i:s');

/* =========================
   Update DB
========================= */
$update = "
UPDATE workorder_form 
SET 
    head_status = 'Approved',
    head_msg    = 'Approved By $approver_name',
    head_date   = '$date',
    task_status = 'Task is going through approval',
    final_status = 'Approval Pending'
WHERE id = $id
";
mysqli_query($conn, $update);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

/* =========================================================
   ENGINEERING FLOW
========================================================= */
if ($depart_type === 'Engineering') {

    try {
        // SMTP
        $mail->SMTPDebug  = 0;
        $mail->Debugoutput = 'error_log';
        $mail->isSMTP();
        $mail->Host       = 'smtp.office365.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@medicslab.com';
        $mail->Password   = 'kcmzrskfgmwzzshz';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        /* ===== Email to User ===== */
        $mail->setFrom('info@medicslab.com', 'Medics Digital Form');
        $mail->addAddress($email);
        // $mail->addAddress('muhammad.hamza@medicslab.com');

        $mail->isHTML(true);
        $mail->Subject = "Workorder Notification";
        $mail->Body = "
        <p>Dear {$user_name},</p>

        <p>
        Your work order request <strong>#{$id}</strong> has been
        <strong>approved</strong> by <strong>{$approver_name}</strong>.
        </p>

        <p>
        Your request is now moving forward for further processing.
        </p>

        <p>Thank you.</p>

        <p>
        Best regards,<br>
        <strong>MedicsFlow</strong>
        </p>
        ";

        $mail->send();

        /* ===== Email to Engineering Head ===== */
        $mail->clearAddresses();
        $mail->addAddress('taha.khan@medicslab.com', 'Engineering Department');

        $mail->Subject = "Workorder Notification";
        $mail->Body = "
        <p>Dear Engineering Department,</p>

        <p>
        A new work order request <strong>#{$id}</strong> has been submitted by
        <strong>{$user_name}</strong> and approved at the initial level.
        </p>

        <p>
        Kindly review and proceed with the necessary action in <strong>MedicsFlow</strong>.
        </p>

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
}

/* =========================================================
   ADMIN FLOW
========================================================= */
else {

    try {
        // SMTP
       $mail->SMTPDebug  = 0;
        $mail->Debugoutput = 'error_log';
        $mail->isSMTP();
        $mail->Host       = 'smtp.office365.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@medicslab.com';
        $mail->Password   = 'kcmzrskfgmwzzshz';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        /* ===== Email to User ===== */
        $mail->setFrom('info@medicslab.com', 'Medics Digital Form');
        $mail->addAddress($email);
        //$mail->addAddress('muhammad.hamza@medicslab.com');

        $mail->isHTML(true);
        $mail->Subject = "Workorder Notification";
        $mail->Body = "
        <p>Dear {$user_name},</p>

        <p>
        Your work order request <strong>#{$id}</strong> has been
        <strong>approved</strong> by <strong>{$approver_name}</strong>.
        </p>

        <p>
        Your request is now moving forward for further processing.
        </p>

        <p>Thank you.</p>

        <p>
        Best regards,<br>
        <strong>MedicsFlow</strong>
        </p>
        ";

        $mail->send();

        /* ===== Email to Admin Head ===== */
        $mail->clearAddresses();
         $mail->addAddress('jawwad.ali@medicslab.com', 'Admin Department');
        // $mail->addAddress('muhammad.hamza@medicslab.com');

        $mail->Subject = "Workorder Notification";
        $mail->Body = "
        <p>Dear Admin Department,</p>

        <p>
        A new work order request <strong>#{$id}</strong> has been submitted by
        <strong>{$user_name}</strong> and approved at the initial level.
        </p>

        <p>
        Kindly review and proceed with the necessary action in <strong>MedicsFlow</strong>.
        </p>

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
}
?>
