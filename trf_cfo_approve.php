<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id=$_GET['id'];
$email = $_GET['email'];
$user_name = $_GET['name'];

$approver_name = $_SESSION['fullname'];
$date =  date('Y-m-d H:i:s');

$update="UPDATE trf SET cfo_status = 'Approved' ,cfo_msg = 'Approved By $approver_name',cfo_date = '$date' WHERE id = $id";
$update_q=mysqli_query($conn,$update);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->SMTPAuth   = true;                                 
    $mail->Username   = 'medicsdigitalform@gmail.com';                    
    $mail->Password   = 'loirscdzztpgbmpa';                              
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
    $mail->Port       = 465;  
  
    $mail->setFrom('medicsdigitalform@gmail.com', 'Medics Digital Form');
    $mail->addAddress($email);    

    $mail->isHTML(true);                                 
    $mail->Subject = "Travel Request Form Update";
    $mail->Body    = "Hi $user_name Your Travel request form has been approved by $approver_name";
    $mail->AltBody = "Hi $user_name Travel request form has been approved by $approver_name";
    $mail->send();
    header("Location:trf_cfo.php");
    $mail->clearAddresses(); 

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    header("Location:trf_cfo.php");
}


?>