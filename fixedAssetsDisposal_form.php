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

    <title>Asset Disposal Form</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body {
font-family: 'Poppins', sans-serif;
}
         .add-remove-checkbox{
         height:18px!important;
         width:18px!important;
         }
         .btn-submit {
            font-size: 14.4px !important; 
            color: white;
            background-color: #0d6efd;
            padding: 5px 35px;
            border-radius: 2px;
            border: 2px solid #0D9276;
            letter-spacing: 1.35px; 
            font-weight: 500;
            }
         .btn-menu{
         font-size: 11px;
         }
         /* body{
         background-color: white;
         } */
         .btn{
         font-size: 11px;
         border-radius:0px;
         }
      </style>
      <style>
         .btn-orange{
         font-size: 14px!important;
         color:white;
         background-color: #FF6600;
         padding: 5px 25px;
         border-radius:2px;
         border:2px solid  #FF6600
         }
         .btn-orange:hover{
         background-color: white;
         border:2px solid  #FF6600;
         color:#FF6600;
         font-weight: normal;
         }
      </style>
      <style>
         p{
         font-size: 12px!important;
         padding: 0px!important;
         margin: 0px!important;
         font-weight: 500;
         }
      </style>
      <style>
         .sub{
         font-size: 11px!important;
         }
         th, td {
         padding:5px!important;
         margin: 0px!important;
         }
         th {
         background-color:#FFB0B0;
         font-size: 13px;
         text-align-last: center;
         }
         input {
         width: 100% !important;
         font-size: 12px!important; 
         border-radius: 0px;
         border: 1px solid grey;
         transition: border-color 0.3s ease;
         padding: 2.5px 5px;
         letter-spacing: 0.4px; 
         height:25px!important;
         }
         input:focus {
         outline: none;
         border: 1px solid black;
         background-color: #FFF4B5;
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
    margin-left: -250px;
    }
    #sidebar.active {
    margin-left: 0;
    }
    #sidebar .sidebar-header {
    padding: 20px;
    background: #0d9276!important;
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
    padding-bottom:4px!important;
    font-size: 10.6px !important;
    display: block;
    color: white!important;
    position: relative;
    }
    #sidebar ul li a:hover {
    text-decoration: none;
    }
    #sidebar ul li.active>a,
    a[aria-expanded="true"] {
    color: cyan!important;
    background: #1c9be7!important;
    }
    #sidebar a {
    position: relative;
    padding-right: 40px; 
    }
    .toggle-icon {
    font-size: 12px;
    color: #fff;
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    transition: transform 0.3s;
    }
    .collapse.show + a .toggle-icon {
    transform: translateY(-50%) rotate(45deg); 
    }
    .collapse:not(.show) + a .toggle-icon {
    transform: translateY(-50%) rotate(0deg); 
    }
    ul ul a {
    font-size: 11px!important;
    padding-left: 15px !important;
    background: #263144!important;
    color: #fff!important;
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
    color: #0d9276!important;
    }
    a.article,
    a.article:hover {
    background: #0d9276!important;
    color: #fff!important;
    }
    #content {
    width: 100%;
    padding: 0px;
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
            include 'sidebar1.php';
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



           



                <section>
        <div class="container-fluid">
            <div class="row justify-content-center">
            <div class="col">

                <form class="form pb-3" method="POST">
                <div class="container">
                <div class="row justify-content-center">
                <div class="col-xl-10 p-5" style="border:1px solid black;background-color:White">
                            <!-- <h5 class="text-center pb-3 font-weight-bold">Fixed Assets Disposal Form</h5> -->

                            <h6 class="text-center pb-md-2 font-weight-bold"><span style="float:right"> <a class="btn btn-dark btn-sm" href="assets_management_home.php" style="font-size:11px!important"><i class="fa-solid fa-arrow-left"></i> Home</a></span>Asset Disposal Form</h6>


                            <!-- row 0 starts -->





                            <h6 style="font-size:13.5px" class="pb-1">Disposal Content</h6>
                            <div class="row pb-3 justify-content-center" >
                               
                                <div class="col-md-4">
                                    <p>Name</p>
                                    <input type="text" name="dc_name" class="w-100">
                                </div>
                                <div class="col-md-4">
                                    <p>Asset Number</p>
                                    <input type="text" name="dc_asset_number" class="w-100">
                                </div>

                                <div class="col-md-4">
                                    <p>Date of Purchase</p>
                                    <input type="date"  name="dc_date_of_purchase" class="w-100">
                                </div>
                            </div>

                            <div class="row pb-3 justify-content-center">
                               
                                <div class="col-md-4">
                                    <p>Quantity</p>
                                    <input type="text" name="dc_quantity" class="W-100">
                                </div>
                                <div class="col-md-4">
                                    <p>Brand/Specification</p>
                                    <input type="text" name="dc_brand_specification" class="W-100">
                                </div>
                                <div class="col-md-4">
                                    <p>Disposition Date</p>
                                    <input type="date" name="dc_disposition_date" class="W-100">
                                </div>
                            
                            </div>     
                            
                            


                            <div class="row pb-3 justify-content-center">
                               
                               <div class="col-md-4">
                                   <p>Orignal Value</p>
                                   <input type="text" name="dc_original_value" class="W-100">
                               </div>
                               <div class="col-md-4">
                                   <p>Depreciation Value</p>
                                   <input type="text" name="dc_depreciation_value" class="W-100">
                               </div>
                               <div class="col-md-4">
                                   <p>Net Worth</p>
                                   <input type="text" required name="dc_net_worth" class="W-100">
                               </div>
                           
                           </div>    
                            <!-- row 0 ends -->

                          
                            <!-- row 1 starts -->
                            <div class="row pb-3">
                                <div class="col-md-4">
                                    <p>Disposal Reason</p>
                                    <input type="text" name="disposal_reason" class="W-100">
                                </div>
                                <div class="col-md-8">
                                    <p>Department Head Opinion</p>
                                    <input type="text" required name="department_head_opinion" class="W-100">
                                </div>
                            </div>
                            <!-- row 1 ends -->

                            <!-- row 2 starts -->
                            <div class="row pb-3">
                                <div class="col">
                                    <h6 style="font-size:13.5px" class="pb-1">Disposal Method</h6>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="background-color:#697565;color:white">Sold</th>
                                                <th style="background-color:#697565;color:white">Scrapped</th>
                                                <th style="background-color:#697565;color:white">Destroyed</th>
                                                <th style="background-color:#697565;color:white">Lost</th>
                                                <th style="background-color:#697565;color:white">Idle</th>
                                                <th style="background-color:#697565;color:white">Other</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="checkbox" class="add-remove-checkbox0" name="disposal_method" id="" value="Sold"> </td>
                                                <td><input type="checkbox" class="add-remove-checkbox0" name="disposal_method" id="" value="Scrapped">  </td>
                                                <td><input type="checkbox" class="add-remove-checkbox0" name="disposal_method" id="" value="Destroyed"> </td>
                                                <td><input type="checkbox" class="add-remove-checkbox0" name="disposal_method" id="" value="Lost"> </td>
                                                <td><input type="checkbox" class="add-remove-checkbox0" name="disposal_method" id="" value="Idle"> </td>
                                                <td><input type="checkbox" class="add-remove-checkbox0" name="disposal_method" id="" value="Other"> </td>
                                            </tr>
                                        </tbody>
                                    </table>

                    
                                    
                                </div>
                            </div>
                            <!-- row 2 ends -->

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-submit" name="submit">Submit</button>
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
  
    $date =  date('Y-m-d H:i:s');
    $head_email =  $_SESSION['head_email'];

    $be_depart =  $_SESSION['be_depart'];
    $be_role =  $_SESSION['be_role'];
    

    $dc_name =  mysqli_real_escape_string($conn, $_POST['dc_name']);
    $dc_asset_number =  mysqli_real_escape_string($conn, $_POST['dc_asset_number']);
    $dc_date_of_purchase =  mysqli_real_escape_string($conn, $_POST['dc_date_of_purchase']);

    $dc_quantity =  mysqli_real_escape_string($conn, $_POST['dc_quantity']);
    $dc_brand_specification =  mysqli_real_escape_string($conn, $_POST['dc_brand_specification']);
    $dc_disposition_date =  mysqli_real_escape_string($conn, $_POST['dc_disposition_date']);

    $dc_original_value =  mysqli_real_escape_string($conn, $_POST['dc_original_value']);
    $dc_depreciation_value =  mysqli_real_escape_string($conn, $_POST['dc_depreciation_value']);
    $dc_net_worth =  mysqli_real_escape_string($conn, $_POST['dc_net_worth']);

    $disposal_reason =  mysqli_real_escape_string($conn, $_POST['disposal_reason']);
    $department_head_opinion =  mysqli_real_escape_string($conn, $_POST['department_head_opinion']);
    $disposal_method=  mysqli_real_escape_string($conn, $_POST['disposal_method']);
 
    $insert = "INSERT INTO fixed_assets_disposal_form 
    (disposal_department, applicant, date_of_application, dc_name, dc_asset_number, dc_date_of_purchase, dc_quantity, dc_brand_specification, dc_disposition_date, dc_original_value, dc_depreciation_value, dc_networth, disposal_reason, disposal_method, department_head_opinion, finance_status,status,jv_status) 
    VALUES 
    ('$department', '$name', '$date', '$dc_name', '$dc_asset_number', '$dc_date_of_purchase', '$dc_quantity', '$dc_brand_specification', '$dc_disposition_date', '$dc_original_value', '$dc_depreciation_value', '$dc_net_worth', '$disposal_reason', '$disposal_method', '$department_head_opinion','Pending','Pending','Pending')";
    
    $insert_q=mysqli_query($conn,$insert);
    if ($insert_q) {
        // Sending email
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
            $mail->addAddress('muhammad.taha@medicslab.com','Finance Department');    
    
            //Content
            $mail->isHTML(true);                                  
            $mail->Subject = "New Asset Disposal Form Submission";
            $mail->Body = "
            <p>Dear Finance Department,</p>
            <p>A new Asset Disposal Form has been submitted by {$name}</p>
            ";
    
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        ?>
        <script type="text/javascript">
            alert("Your Request has been submitted!");
            window.location.href = "fixedAssetsDisposal_form.php";
        </script>
        <?php
    } else {
        ?>
        <script type="text/javascript">
            alert("Request submission failed!");
            window.location.href = "fixedAssetsDisposal_form.php";
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
    // Ensure the sidebar is active (visible) by default
    $('#sidebar').addClass('active'); // Change to addClass to show sidebar initially
    
    // Handle sidebar collapse toggle
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });
    
    // Update the icon when collapsing/expanding
    $('[data-bs-toggle="collapse"]').on('click', function () {
        var target = $(this).find('.toggle-icon');
        if ($(this).attr('aria-expanded') === 'true') {
            target.removeClass('fa-plus').addClass('fa-minus');
        } else {
            target.removeClass('fa-minus').addClass('fa-plus');
        }
    });
    });
</script>
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


   

   <script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.add-remove-checkbox0');

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
    <script src="assets/js/main.js"></script>
</body>

</html>