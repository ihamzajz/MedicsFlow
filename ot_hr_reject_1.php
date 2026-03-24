<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id=$_GET['id'];
$email = $_GET['email'];
$name = $_SESSION['fullname'];
$date =  date('Y-m-d H:i:s');
// echo "$email";
$date =  date('Y-m-d H:i:s');
$reason = $_GET['reason'];

$update="UPDATE ot SET status1_1 = 'Rejected', status1_2 = 'Rejected By $name', status1_3 =  '$date', status1_4 = '$reason', hr_submission = 'Approved' WHERE id = $id";
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
    $mail->Password   = 'loirscdzztpgbmpa';                               //SMTP password                              //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                      //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('medicsdigitalform@gmail.com', 'Medics Digital Form');
    $mail->addAddress($email);     //Add a recipient;


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "WorkOrder Request Update";
    $mail->Body    = "Your Over Time request has been Rejected by $name";
    $mail->AltBody = "Your Over Time request has been Rejected by '$name";

    $mail->send();
    //echo 'Message has been sent';
    header("Location:ot_hr_details?id=$id");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    header("Location:ot_hr_details?id=$id");
}

?>