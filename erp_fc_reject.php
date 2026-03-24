<?php

session_start();
include 'dbconfig.php';

$id=$_GET['id'];
$email = $_GET['email'];
$name = $_SESSION['fullname'];

// echo "$email";


$update="UPDATE erpaccess_form SET fc_status = 'Rejected',fc_msg = 'Rejected By $name', task_status='Rejected By $name' WHERE id = $id";
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
    $mail->Username   = 'hamza.mediclabs@gmail.com';                     //SMTP username
    $mail->Password   = 'hwxxkrrezfslrjil';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('hamza.mediclabs@gmail.com', 'Medics Digital Form');
    $mail->addAddress($email);     //Add a recipient;


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "ERP Access Request Update";
    $mail->Body    = "Your Erp Access request has been Rejected by $name";
    $mail->AltBody = "Your Erp Access request has been Rejected by '$name";

    $mail->send();
    //echo 'Message has been sent';
    header("Location:erp_fc_list.php");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>