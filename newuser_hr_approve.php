<?php
session_start();
include 'dbconfig.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

date_default_timezone_set("Asia/Karachi");

$id = $_GET['id'];
$approver_name = $_SESSION['fullname'];
$date = date('Y-m-d H:i:s');

// Update the database
$update = "UPDATE newuserform SET hr_status = 'Approved', hr_msg = 'Approved By $approver_name', hr_date = '$date' WHERE id = $id";
$update_q = mysqli_query($conn, $update);

if ($update_q) {
    // Send email
    try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;  
        $mail->isSMTP();  
        $mail->Host       = 'smtp.office365.com';  
        $mail->SMTPAuth   = true;  
        $mail->Username   = 'info@medicslab.com';  
        $mail->Password   = 'kcmzrskfgmwzzshz';  
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;                    

        //Recipients
        $mail->setFrom('info@medicslab.com', 'Medics Digital form');
        $mail->addAddress('bilal.ahmed@medicslab.com','IT Department');    

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "New User Form Submission";
        $mail->Body = "
        <p>Dear IT Department,</p>
        <p>A new user form has been submitted and approved by HR Head.</p>
        ";

        $mail->send();
        $mail->clearAddresses();

        $mail->addAddress('hamza.abbasi@medicslab.com', 'Hamza IT');
             $mail->Subject = "New User Form Submission";
             $mail->Body = "
             <p>Dear IT Department,</p>
             <p>A new user form has been submitted. and approved by HR Head.</p>
             ";
             $mail->send();

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    // Success alert
    ?>
    <script type="text/javascript">
        alert("Form has been submitted!");
        window.location.href = "newuserhr.php";
    </script>
    <?php
} else {
    // Failure alert
    ?>
    <script type="text/javascript">
        alert("Form submission failed!");
        window.location.href = "newuserhr.php";
    </script>
    <?php
}
?>
