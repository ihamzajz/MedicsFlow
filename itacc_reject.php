<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id = $_GET['id'];
$email = $_GET['email'];
$user_name = $_GET['name'];

$approver_name = $_SESSION['fullname'];
$date =  date('Y-m-d H:i:s');
$reason = $_GET['reason'];

$update = "UPDATE it_accessories SET it_status = 'Rejected' ,it_msg = 'Rejected By $approver_name',it_date = '$date' , reason = '$reason' , final_status = 'Rejected' WHERE id = $id";
$update_q = mysqli_query($conn, $update);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
if ($be_role == 'xxx') {
    try {
        //Server settings
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'error_log';
        $mail->isSMTP();
        $mail->Host = 'smtp.office365.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'info@medicslab.com';
        $mail->Password = 'kcmzrskfgmwzzshz';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('info@medicslab.com', 'Medics Digital form');
        $mail->addAddress($email);


        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "WorkOrder Request Update";
        $mail->Body    = "Hi $user_name Your WorkOrder request has been approved by $approver_name";
        $mail->AltBody = "Hi $user_name WorkOrder request has been approved by $approver_name";
        $mail->send();
        header("Location:workorder_head_list.php");
        //echo 'Message has been sent';
        $mail->clearAddresses(); // Clearing previous recipient

        $mail->addAddress('taha.khan@medicslab.com', 'Engineering Head');
        $mail->Subject = "New WorkOrder Request For Engineering Head";
        $mail->Body = 'New Workorder By ' . $user_name . ' </br> Type: ' . $type . ' </br> Category: ' . $category;

        //$mail->AltBody = "ERP Access request with ID $id has been rejected by $name";

        $mail->send();
        header("Location:workorder_head_list.php");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header("Location:workorder_head_list.php");
    }
} else {
    try {
        //Server settings
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'error_log';
        $mail->isSMTP();
        $mail->Host = 'smtp.office365.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'info@medicslab.com';
        $mail->Password = 'kcmzrskfgmwzzshz';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('info@medicslab.com', 'Medics Digital form');
        $mail->addAddress($email);
        // $mail->addAddress('muhammad.hamza@medicslab.com');


       
        $safeApprover = htmlspecialchars((string)$approver_name, ENT_QUOTES, 'UTF-8');
        $safeReason = nl2br(htmlspecialchars(trim((string)$reason), ENT_QUOTES, 'UTF-8'));

        $mail->isHTML(true);
        $mail->Subject = "IT Accessories Form Notification";
        $mail->Body = "
  <p>Dear Concern,</p>

  <p>
    Your IT Accessories request <strong>#{$id}</strong> has been rejected by
    <strong>{$safeApprover}</strong>.
  </p>

  <p><strong>Reason:</strong><br>{$safeReason}</p>

  <p>Thank you.</p>

  <p>Regards,<br><strong>MedicsFlow</strong></p>
";

        $mail->send();
        header("Location:itacc_it.php");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header("Location:itacc_it.php");
    }
}
