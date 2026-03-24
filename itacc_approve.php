<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id = $_GET['id'];
$email = $_GET['email'];
$user_name = $_GET['name'];


$approver_name = $_SESSION['fullname'];
$date =  date('Y-m-d H:i:s');


$update = "UPDATE it_accessories SET it_status = 'Approved' ,it_msg = 'Approved By $approver_name',it_date = '$date' ,final_status = 'Approved' WHERE id = $id";
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
        $mail->Subject = "IT Accessories - Notification";
        $mail->Body    = "Hi $user_name Your IT Accessories request has been approved by $approver_name";
        $mail->send();
        header("Location:itacc_it.php");
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



        $mail->isHTML(true);
        $mail->Subject = "IT Accessories Form Notification";
        $mail->Body = "
  <p>Dear Concern,</p>

  <p>
    Your IT Accessories request <strong>#{$id}</strong> has been approved by
    <strong>{$approver_name}</strong>.
  </p>

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
