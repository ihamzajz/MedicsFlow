<?php

session_start();
include 'dbconfig.php';

date_default_timezone_set("Asia/Karachi");

$id = $_GET['id'];
$fname = $_SESSION['fullname']; // from session
$date = date('d-m-Y');

$update = "UPDATE qc_ccrf2 SET workdone9 = 'Completed', workdone9_date = '$date' WHERE id = $id";
$update_q = mysqli_query($conn, $update);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com'; // Use your desired SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'info@medicslab.com'; // Your email username
    $mail->Password = 'kcmzrskfgmwzzshz'; // Your email password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('info@medicslab.com', 'Medics Digital form');
     $mail->addAddress('sadia.iqbal@medicslab.com'); // The recipient's email address

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = "Change Control Update";
    $mail->Body = "Dear Quality Department,<br><br>
An Action Plan has been completed by $fname for Change Control Form #$id.<br><br>
Kindly visit MedicsFlow at <a href='http://43.245.128.46:9090/medicsflow/login'>MedicsFlow Login</a> to take the necessary action.<br><br>
Best regards,<br>
MedicsFlow";
    // Send the email
    $mail->send();
    
    // After sending the email, redirect to the workorder_head_list.php page
    header("Location: cc_add_action_plan.php?id=$id");

} catch (Exception $e) {
    // Handle errors and show the error message if the email fails to send
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    header("Location: cc_add_action_plan.php?id=$id");
}
?>
