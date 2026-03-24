<?php 
session_start (); 


if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php'); // Redirect to the login page
    exit;
}

$head_email = $_SESSION['head_email'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>New Batch</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>


    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="assets/css/style.css">


    <style>
        .heading-main{
            padding-top: 10px;
            padding-bottom: 10px;
            font-size: 22px;
            font-weight:700;
            color: white;
            background-color: #8576FF;
            }
    </style>
    <style>
           h6{
        font-size: 16px!important;
    }
        th.hidden, td.hidden {
        display: none;
    }
    .btn-dark,.btn-success,.btn-danger, .btn-info{
        font-size: 11px;
    }
    .labelm {
        font-size: 11px;
        font-weight: bold;
    }
    select,  select option , input[type=date]{
        font-size: 13px!important;
        height:10px:!important;
    }
    </style>



    <style>
        p{
            font-size: 13px;
            padding:0px;
            margin:0px;
        }
    </style>
  




    <style>
        
        .sub{
            font-size: 11px!important;
        }

        th, td {
 
        }
        th {
            background-color:#FFB0B0;
            font-size: 13px;
            text-align-last: center;
        }
        input{
            font-size: 13px;
            background-color:#f2f2f2;
            padding-top: 2px;
            padding-bottom: 2px;
            border: 1px solid black;
            padding-left: 5px;
            
        }
    </style>
    <style>
        .section-4{
        background-image: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.7)),url('assets/images/banner.png');
        height: 100vh;
        background-size: cover;
        }
    </style>

<style>
         .wrapper {
         display: flex;
         width: 100%;
         align-items: stretch;
         }
         #sidebar {
         min-width: 250px;
         max-width: 250px;
         background: #263144!important;
         color: #fff;
         transition: all 0.3s;
         }
         #sidebar.active {
         margin-left: -250px;
         }
         #sidebar .sidebar-header {
         padding: 20px;
         background: yellow!important;
         }
         #sidebar ul.components {
         padding: 10px 0;
         }
         #sidebar ul p {
         color: #fff;
         padding: 8px!important;
         }
         #sidebar ul li a {
         padding: 8px!important;
         font-size: 11px !important;
         display: block;
         color: white!important;
         }
         #sidebar ul li a:hover {
         text-decoration: none;
         }
         #sidebar ul li.active>a,
         a[aria-expanded="true"] {
         color: cyan!important;
         background: #1c9be7!important;
         }
         a[data-toggle="collapse"] {
         position: relative;
         }
         .dropdown-toggle::after {
         display: block;
         position: absolute;
         color: #1c9be7!important;
         top: 50%;
         right: 20px;
         transform: translateY(-50%);
         background: transparent!important;
         }
         ul ul a {
         font-size: 11px!important;
         padding-left: 15px !important;
         background: yellow!important;
         color: yellow!important;
         }
         ul.CTAs {
         font-size: 11px !important;
         }
         ul.CTAs a {
         text-align: center;
         font-size: 11px!important;
         display: block;
         margin-bottom: 5px;
         }
         a.download {
         background: #fff;
         color: yellow;
         }
         a.article,
         a.article:hover {
         background: yellow;
         color: yellow!important ;
         }
         #content {
         width: 100%;
         padding: 20px;
         min-height: 100vh;
         transition: all 0.3s;
         }
         @media (max-width: 768px) {
         #sidebar {
            margin-left: -250px;
         }
         #sidebar.active {
            margin-left: 0;
         }
         #sidebarCollapse span {
            display: none;
         }
         }
      </style>

</head>

<body background-color="white">
    <div class="wrapper">

    <?php
            include 'sidebar.php';
        ?>

        <!-- Page Content  -->
        <div id="content">
            <!-- navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </nav>
            
            <h6 class="text-center heading-main px-2 py-3">
                        <span style="float:left;">
                        <a href="profile.php"><button class="btn btn-sm btn-dark" >Back</button></a>
                        </span>
                        Add New Batch
                       <span style="float:right;">
                       <a href="new_batch.php"><button class="btn btn-sm btn-dark">New Batch</button></a>
                        <a href="active_batch.php"><button class="btn btn-sm btn-dark">Active batch</button></a>
                        <a href="inactive_batch.php"><button class="btn btn-sm btn-dark">Inactive batch</button></a>
                        </span>
            </h6>

                <section>
        <div class="container-fluid">
            <div class="row justify-content-center">
            <div class="col">

                <form class="form pb-2 mt-4" method="POST">
                <div class="container">
                <div class="row justify-content-center">
                    <div class="col-7 p-5"  Style="border:1px solid black; background-color:white">
                            <h5 class="text-center pb-3 font-weight-bold">Enter New Batch</h5>


                            <div class="row pb-2 justify-content-center">
                            <div class="col-md-4">
                                    <p>Batch name</p>
                                    <input type="name" required name="batch_name" class="w-100">
                               </div>
                                <div class="col-md-4">
                                    <p>start date</p>
                                    <input type="date" required name="start_date" class="w-100">
                                </div>
                                <div class="col-md-4">
                                    <p>End date</p>
                                    <input type="date" required name="end_date" class="w-100">
                               </div>
                           </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-sm btn-dark" name="submit">Submit</button>
                            </div>


                    </div>
                </div>
            </div>

                    </form>

                    <?php
                        

 include 'dbconfig.php';
if (isset($_POST['submit'])) {

date_default_timezone_set("Asia/Karachi");

    $id =  $_SESSION['id'];
    $name =  $_SESSION['fullname'];
    $email =  $_SESSION['email'];
    $username =  $_SESSION['username'];
    $department = $_SESSION['department'];
  
    $date =  date('Y-m-d');
    $head_email =  $_SESSION['head_email'];

    $be_depart =  $_SESSION['be_depart'];
    $be_role =  $_SESSION['be_role'];
    
    $batch_name = $_POST['batch_name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
 
    $insert = "INSERT INTO batch
    (name,start_date,end_date,user_name,user_date,status)
    VALUES 
    ('$batch_name','$start_date','$end_date','$name','$date','active')";

    $insert_q=mysqli_query($conn,$insert);
    if ($insert_q) {

        //ceo ke pass jaegi hod ki
            if($role=='xxx'){

            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'medicsdigitalform@gmail.com';                     //SMTP username
                $mail->Password   = 'loirscdzztpgbmpa';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom('medicsdigitalform@gmail.com', 'Medics Digital form');
                $mail->addAddress('','CEO');     //Add a recipient;
            
            
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = "New WorkOrder Request";
                $mail->Body = '
                    <p>Hello,</p>
                    <p>New WorkOrder request for CEO.</p>
                    <p>
                        <a href="workorder_ceo_approve.php" style="padding: 10px 20px; background-color: #2f89fc; color: white; text-decoration: none; border-radius: 5px;">Approve</a>
                        <a href="workorder_ceo_reject.php" style="padding: 10px 20px; background-color: #ff0000; color: white; text-decoration: none; border-radius: 5px; margin-left: 10px;">Reject</a>
                    </p>
                    <p>Thank you.</p>
                ';
                // $mail->AltBody = "Approve";
            
                $mail->send();
                //echo 'Message has been sent';
                //header("Location:erp_ceo_list.php");
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            ?>
            <script type="text/javascript">
                alert("Request has been submitted")
                // window.location.href = "workorder_userlist.php";
                //header("location:profile.php");
            </script>
            <?php

            

        //normal bande ki hod ke pass
        }else{

            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
                $mail->isSMTP();                                            
                $mail->Host       = 'smtp.gmail.com';                    
                $mail->SMTPAuth   = true;                                   
                $mail->Username   = 'medicsdigitalform@gmail.com';                   
                $mail->Password   = 'loirscdzztpgbmpa';                               
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
                $mail->Port       = 465;                                    
            
                //Recipients
                $mail->setFrom('medicsdigitalform@gmail.com', 'Medics Digital form');
                 $mail->addAddress('','Department Head');    
            
            
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = "New Asset Receipt Form Submission";
                $mail->Body = '
                <p>Hi.</p>
                <p>New Asset Receipt Form has been Submitted</p>

            ';
                //$mail->AltBody = "Approve";
            
                $mail->send();
                //echo 'Message has been sent';
                //header("Location:erp_ceo_list.php");
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        }

        ?>
        <script type="text/javascript">
            alert("Your Request has been submitted!")
             window.location.href = "new_batch.php";
        </script>
        <?php
    }
    else
    {
        ?>
        <script type="text/javascript">
            alert("Request submition failed!")
             window.location.href = "new_batch.php";
        </script>
        <?php
    }
    }

?>




 
                        

            </div>



            </div> 
        </div> 
    </section>
        </div> 
    </div> 

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

   


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.add-remove-checkbox');

        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                const groupName = this.name.split('_')[0]; // Extract the group name

                // Uncheck other checkboxes in the same group
                checkboxes.forEach(function (cb) {
                    if (cb !== checkbox && cb.name.startsWith(groupName)) {
                        cb.checked = false;
                    }
                });
            });
        });
    });
</script>


    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
   

  
    <script src="assets/js/main.js"></script>
</body>

</html>