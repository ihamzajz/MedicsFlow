<?php

session_start();
include 'dbconfig.php';

$id=$_GET['id'];
$email = $_GET['email'];
$name = $_SESSION['fullname'];

// echo "$email";

$update="UPDATE erpaccess_form SET it_head_status = 'Approved',it_head_msg = 'Approved By $name', task_status='Work in progress' WHERE id = $id";
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
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'medicsdigitalform@gmail.com';                     //SMTP username
    $mail->Password   = 'loirscdzztpgbmpa';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                      //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('medicsdigitalform@gmail.com', 'Medics ERP Digital Form');
    $mail->addAddress($email);     //Add a recipient;

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "ERP Access Request Update";
    $mail->Body    = "Your Erp Access request has been Approved by $name";
    $mail->AltBody = "Your Erp Access request has been Approved by '$name";

    $mail->send();
    header("Location:erp_ithead_list.php");
    
    //echo 'Message has been sent';

    $mail->clearAddresses(); // Clearing previous recipient
    $mail->addAddress('muhammad.hamza@medicslab.com'); // Add a new recipient
    $mail->Subject = "ERP Access Request for FC";
    $mail->Body = '
                <p>Hello,</p>
                <p>New ERP Access Request for FC.</p>
                <p>
                    <a href="erp_fc_approve.php" style="padding: 10px 20px; background-color: #2f89fc; color: white; text-decoration: none; border-radius: 5px;">Approve</a>
                    <a href="erp_fc_reject.php" style="padding: 10px 20px; background-color: #ff0000; color: white; text-decoration: none; border-radius: 5px; margin-left: 10px;">Reject</a>
                </p>
                <p>Thank you.</p>
            ';
    $mail->send();
    header("Location:erp_ithead_list.php");
    //header("Location:erp_ithead_list.php");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    header("Location:erp_ithead_list.php");
}

?>