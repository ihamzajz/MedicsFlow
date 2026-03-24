<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id=$_GET['id'];
// $email = $_GET['email'];
// $user_name = $_GET['name'];

$approver_name = $_SESSION['fullname'];
$date =  date('Y-m-d H:i:s');


$update="UPDATE fixed_assets_disposal_form SET finance_status = 'Approved' ,finance_msg = 'Approved By $approver_name',finance_date = '$date',status = 'Approved'  WHERE id = $id";
$update_q=mysqli_query($conn,$update);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
    $mail->isSMTP();                                           
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'medicsdigitalform@gmail.com';                    
    $mail->Password   = 'loirscdzztpgbmpa';                               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
    $mail->Port       = 465;                                      //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $mail->setFrom('medicsdigitalform@gmail.com', 'Medics Digital Form');
    $mail->addAddress($email);     

    $mail->isHTML(true);                                 
    $mail->Subject = "req";
    $mail->Body    = "req";
    $mail->AltBody = "req";

    $mail->send();
    header("Location:fixedAssetsDisposal_finance_list.phpp");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    header("Location:fixedAssetsDisposal_finance_list.php");
}

?>