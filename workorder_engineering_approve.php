<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id = $_GET['id'];
$email = $_GET['email'];
$name = $_SESSION['fullname'];
$date =  date('Y-m-d H:i:s');
// echo "$email";

$update = "UPDATE workorder_form SET engineering_status = 'Approved',engineering_msg = 'Approved By $name', eng_date =  '$date', task_status='Work in progress' 
, final_status = 'Work In Progress' WHERE id = $id";
$update_q = mysqli_query($conn, $update);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

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

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "Workorder Notification";
    $mail->Body = "
<p>Dear Concern,</p>
<p>Your work order request <strong>#{$id}</strong> has been <strong>approved</strong> by <strong>{$name}</strong>.</p>
<p>If you have any questions or require further assistance, please feel free to contact us.</p>
<p>Thank you.</p>
<p>
Best regards,<br>
<strong>MedicsFlow</strong>
</p>
";


    $mail->send();
    //echo 'Message has been sent';
    header("Location:workorder_engineering_list.php");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    header("Location:workorder_engineering_list.php");
}
