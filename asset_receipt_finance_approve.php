<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id=$_GET['id'];
// $email = $_GET['email'];
// $user_name = $_GET['name'];

$approver_name = $_SESSION['fullname'];
$date =  date('Y-m-d H:i:s');


$update="UPDATE assets SET finance_status = 'Approved' ,finance_msg = 'Approved By $approver_name',finance_date = '$date' , req_status = 'Approved' WHERE id = $id";
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
        $mail->Subject = "WorkOrder Request Update";
        $mail->Body    = "Hi $user_name Your WorkOrder request has been approved by $approver_name";
        $mail->AltBody = "Hi $user_name WorkOrder request has been approved by $approver_name";
        $mail->send();
        header("Location:workorder_head_list.php");
    
        $mail->clearAddresses(); 

        $mail->addAddress('', 'Engineering Head'); 
        $mail->Subject = "";
        $mail->Body = '';
    
        $mail->send();
        header("Location:asset_receipt_finance_list.php");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header("Location:asset_receipt_finance_list.php");
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
        $mail->addAddress('ihamzajz@gmailc.com','XD');    
    
    
       
        $mail->isHTML(true);                                 
        $mail->Subject = "rEQ";
        $mail->Body    = "REQ";
        $mail->AltBody = "REQ";
        $mail->send();
        header("Location:asset_receipt_finance_list.php");

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header("Location:asset_receipt_finance_list.php");
    }
}
?>
