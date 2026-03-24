<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id=$_GET['id'];
$email = $_GET['email'];
$user_name = $_GET['name'];

$approver_name = $_SESSION['fullname'];
$date =  date('Y-m-d H:i:s');


$update="UPDATE bonus_form SET zsm_status = 'Approved' ,zsm_msg = 'Approved By $approver_name',zsm_date = '$date' , task_status='Task is going through approval', final_status = 'Approval Pending' WHERE id = $id";
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
    $mail->Port       = 465;  
    //Recipients
    $mail->setFrom('medicsdigitalform@gmail.com', 'Medics Digital Form');
    //  $mail->addAddress($email);    
    $mail->addAddress('ihamzajz@gmail.com');  


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "bonus Request Update";
    $mail->Body    = "Hi $user_name Your bonus request has been approved by $approver_name";
    $mail->AltBody = "Hi $user_name bonus request has been approved by $approver_name";
    $mail->send();
    header("Location:bonus_zsm_list.php");
    $mail->clearAddresses(); 

    $mail->addAddress('ihamzajz@gmail.com', 'HO Approver'); 
    $mail->Subject = "New bonus Request For HO Approver";
    $mail->Body = 'New bonus Request By ' . $user_name;

    //$mail->AltBody = "ERP Access request with ID $id has been rejected by $name";

    $mail->send();
    header("Location:bonus_zsm_list.php");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    header("Location:bonus_zsm_list.php");
}

?>