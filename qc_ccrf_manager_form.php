<?php 
    session_start (); 
    
    
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php'); // Redirect to the login page
        exit;
    }
    
    $head_email = $_SESSION['head_email'];


    $fullname = $_SESSION['fullname'];
    $department = $_SESSION['department'];
    $role = $_SESSION['role'];
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
        <title>Change Control Request Form</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <!-- Our Custom CSS -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="assets/css/style.css">
        <style>
            .btn-submit {
            font-size: 14.4px !important; 
            color: white;
            background-color: #0D9276;
            padding: 5px 35px;
            border-radius: 2px;
            border: 2px solid #0D9276;
            letter-spacing: 1.35px; 
            font-weight: 500;
            }
            .btn-menu{
                font-size: 11px;
                border-radius:0px;
    
            }
             .cbox{
                height: 13px!important;
                width: 13px!important;
            }
            p{
                font-size: 11.7px!important;
            padding: 0px!important;
            margin: 0px!important;
            font-weight: 500!important;
            display: inline!important; 
            margin-right: 10px!important;
            }
           
            input {
            width: 200px !important;
            font-size: 11.7px!important; 
            border-radius: 0px!important;
            border: 1px solid grey!important;
            transition: border-color 0.3s ease!important;
            padding: 5px 5px!important;
            letter-spacing: 0.4px!important; 
            height:25px!important;
            }
            input:focus {
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
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
    <body>
        <div class="wrapper">
            <?php
                include 'sidebar.php';
                ?>
            <!-- Page Content  -->
            <div id="content">
                <!-- navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-dark btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                        </button>
                    </div>
                </nav>
           
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col ">

                                <form class="form pb-3" method="POST" style="border: 1px solid black; padding: 25px; padding-bottom: 0px; border-radius: 2px;background-color:white!important" >
                                    <h6 class="text-center pb-3" style="font-weight: bolder;">Change Control Request Form</h6>
                                    <table>


                                        <div style="border: 1px solid grey; padding: 10px;">
                                            <div style="display: flex; gap: 20px; align-items: center;">
                                                <div>
                                                    <p>Date Initiated</p>
                                                    <input type="date" style="display: inline;" name="i_date_initiated">
                                                </div>

                                                <div>
                                                    <p>Area of Change</p>
                                                    <input type="text" style="display: inline;" name="i_area_of_change">
                                                </div>
                                            </div>

                                            <div style="margin-top: 10px;">
                                                <p>Time of Change</p>
                                                <input type="time" style="display: inline;" name="i_time_of_change">
                                            </div>
                                        </div>





                                        <div style="border: 1px solid grey; padding: 10px; margin-top: 15px;">
                                        <div style="margin-bottom: 10px;">
                                        <p style="font-weight: 600 !important; font-size: 13px !important;">Description of Change</p>
                                        </div>
                                            <div style="margin-bottom: 10px;">
                                                <p>Current Status</p>
                                                <input type="text" style="display: block; width:100%!important" name="i_current_status">
                                            </div>

                                            <div style="margin-top: 10px;">
                                                <p>Proposed Change</p>
                                                <input type="text" style="display: block; width:100%!important" name="i_proposed_status">
                                            </div>
                                        </div>









                                        <div style="border: 1px solid grey; padding: 10px; margin-top: 15px;">

                                            <div style="margin-bottom: 10px;">
                                                 <p style="font-weight: 600 !important; font-size: 12px !important;">Justification of Change (Supporting Data if applicable)</p>
                                                <input type="text" style="display: block; width:100%!important" name="i_justification_of_change">
                                            </div>

                                            <div style="display: flex; gap: 20px; align-items: center;">
                                                <div>
                                                    <p>Requestor Name</p>
                                                    <input type="text" style="display: inline;background-color:#F5F5F5!important" value="<?php echo htmlspecialchars($fullname); ?>" readonly>
                                                </div>

                                                <div>
                                                    <p>Department</p>
                                                    <input type="text" style="display: inline;background-color:#F5F5F5!important" value="<?php echo htmlspecialchars($department); ?>" readonly>
                                                </div>
                                            </div>

                                            <div style="display: flex; gap: 20px; align-items: center;margin-top: 10px;">
                                                <div>
                                                    <p>Designation</p>
                                                    <input type="test" style="display: inline;background-color:#F5F5F5!important" value="<?php echo htmlspecialchars($role); ?>" readonly>
                                                </div>

                                                <!-- <div>
                                                    <p>Sign/Date</p>
                                                    <input type="text" style="display: inline;">
                                                </div> -->
                                            </div>
                                        </div>
                                        
                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-submit" name="submit" style="font-size: 20px">Submit</button>
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
                                       $role =  $_SESSION['role'];
                                       $date =  date('Y-m-d H:i:s');

                                       $desc =  mysqli_real_escape_string($conn, $_POST['desc']); 
                                       $head_email =  $_SESSION['head_email'];
                                    
                                       $be_depart =  $_SESSION['be_depart'];
                                       $be_role =  $_SESSION['be_role'];
                                       
                                       $type =  $_POST['type'];
                                       $category = $_POST['category'];
                                       $depart_type = $_POST['depart_type'];
                                    
                                    
                                       $insert = "INSERT INTO workorder_form (name,username,email,date,department,role,be_depart,be_role,type,category,description,head_status,engineering_status,finance_status,ceo_status,amount,task_status,admin_status,depart_type) VALUES 
                                       ('$name','$username','$email','$date','$department','$role','$be_depart','$be_role','$type','$category','$desc','Pending','Pending','Pending','Pending','TBD','Task is going through approval','Pending','$depart_type')";
                                    
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
                                            $mail->addAddress($head_email,'HOD');    
                                    
                                            //Content
                                            $mail->isHTML(true);                                  //Set email format to HTML
                                            $mail->Subject = "Workorder Form Submission";
                                            $mail->Body = "
                                            <p>Dear HOD,</p>
                                            <p>A new workorder form has been submitted by {$name}.</p>
                                            ";
                                    
                                            $mail->send();
                                        } catch (Exception $e) {
                                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                                        }
                    
                                        ?>
                                                            <script type="text/javascript">
                                                                alert("Form has been submitted!");
                                                                window.location.href = "workorder_form.php";
                                                            </script>
                                                            <?php
                                    } else {
                                        ?>
                                                                <script type="text/javascript">
                                                                    alert("Form submission failed!");
                                                                    window.location.href = "workorder_form.php";
                                                                </script>
                                                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
          
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const checkboxes = document.querySelectorAll('.category-checkbox');
            
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
                const checkboxes = document.querySelectorAll('.type-checkbox');
            
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
                const checkboxes = document.querySelectorAll('.depart_type-checkbox');
            
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
