<?php

session_start();
include 'dbconfig.php';

$id=$_GET['id'];
$email = $_GET['email'];
$name = $_SESSION['fullname'];

// echo "$email";

$update="UPDATE workorder_form SET ceo_status = 'Approved',ceo_msg='Approved By $name',task_status='WIP' WHERE id = $id";
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
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('hamza.mediclabs@gmail.com', 'Medics Digital Form');
    $mail->addAddress($email);     //Add a recipient;


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "WorkOrder Request Update";
    $mail->Body    = "Your WorkOrder request has been Approved by $name";
    $mail->AltBody = "Your WorkOrder request has been Approved by '$name";

    $mail->send();
    //echo 'Message has been sent';
    header("Location:workorder_ceo_list.php");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>