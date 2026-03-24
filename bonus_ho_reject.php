<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id=$_GET['id'];
$approver_name = $_SESSION['fullname'];
$date =  date('Y-m-d H:i:s');
$reason = $_GET['reason'];
$update="UPDATE bonus_form SET ho_status = 'Rejected' ,ho_msg = 'Rejected By $approver_name',ho_date = '$date' , task_status='Rejected By $approver_name', final_status = 'Rejected', reason = '$reason'  WHERE id = $id";
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
    $mail->isHTML(true);                                 
    $mail->Subject = "Bonus Approval Request Update";
    $mail->Body    = "Hi $user_name Your Bonus Approval request has been rejected by $approver_name";
    $mail->AltBody = "Hi $user_name Your Bonus Approval request has been rejected by $approver_name";
    $mail->send();
    header("Location:bonus_ho_list.php");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    header("Location:bonus_ho_list.php");
}
?>