<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id=$_GET['id'];

// $approver_name = $_SESSION['fullname'];
// $date =  date('Y-m-d H:i:s');

$update="UPDATE batch SET status = 'inactive' WHERE id = $id";
$update_q=mysqli_query($conn,$update);















use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);
if($be_role == 'xxx'){
    try {
      
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                     
        $mail->isSMTP();                                          
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'medicsdigitalform@gmail.com';                     
        $mail->Password   = 'loirscdzztpgbmpa';                              
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
        $mail->Port       = 465;  
        //Recipients
        $mail->setFrom('medicsdigitalform@gmail.com', 'Medics Digital Form');
        $mail->addAddress($email);    
    
    
        //Content
        $mail->isHTML(true);                                  
        $mail->Subject = "";
        $mail->Body    = "";
        $mail->AltBody = "";
        $mail->send();
        header("Location:active_batch.php");
    

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header("Location:active_batch.php");
    }
}
else{
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
        $mail->addAddress('','');    
    
    
       
        $mail->isHTML(true);                                 
        $mail->Subject = "";
        $mail->Body    = "";
        $mail->AltBody = "";
        $mail->send();
        header("Location:active_batch.php");

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header("Location:active_batch.php");
    }
}
?>