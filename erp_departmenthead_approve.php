<?php

session_start();
include 'dbconfig.php';

$id=$_GET['id'];
$email = $_GET['email'];
$name = $_SESSION['fullname'];

// echo "$email";


$update="UPDATE erpaccess_form SET department_head_status = 'Approved',department_head_msg = 'Approved By $name' , task_status='Approved by $name' WHERE id = $id";
$update_q=mysqli_query($conn,$update);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;  
    $mail->isSMTP();  
    $mail->Host       = 'smtp.office365.com';  
    $mail->SMTPAuth   = true;  
    $mail->Username   = 'info@medicslab.com';  
    $mail->Password   = 'kcmzrskfgmwzzshz';  
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;                                   

    //Recipients
    $mail->setFrom('info@medicslab.com', 'Medics Digital form');
    // $mail->addAddress($email);    


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "ERP Access Request Update";
    $mail->Body    = "Your Erp Access request has been approved by $name";
    $mail->AltBody = "Your Erp Access request has been approved by '$name";

    $mail->send();
    header("Location:erp_departmenthead_list.php");
    //echo 'Message has been sent';

    $mail->clearAddresses(); // Clearing previous recipient
    $mail->addAddress('farhan.arif@medicslab.com'); 
    $mail->Subject = "ERP Access Request for IT Head";
    $mail->Body = '
                <p>Dear IT Head,,</p>
                <p>A new ERP request has been submitted and is currently awaiting your approval.
Kindly review and proceed with the necessary action at your earliest convenience.</p>

            ';
    //$mail->AltBody = "ERP Access request with ID $id has been rejected by $name";

    $mail->send();
    header("Location:erp_departmenthead_list.php");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    header("Location:erp_departmenthead_list.php");
}

?>