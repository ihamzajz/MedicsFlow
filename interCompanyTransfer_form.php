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
        <title>Inter Company Transfer Form</title>
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
         select{
            font-size: 12px!important;
            border-radius:0px!important;
            height:22.5px!important;
         }
         option{
            font-size: 12px!important;
         }
      </style>
      <style>
           .btn{
                font-size: 11px!important;
                color:white!important;
                border-radius:0px!important
            }
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
                        <button type="button" id="sidebarCollapse" class="btn btn-info btn-menu">
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
                                    <div class="container-fluid">
                                        <div class="row justify-content-center">
                                            <div class="col-xl-10 p-4" style="border:1px solid black;background-color:white">
                                                <h6 class="text-center pb-md-4 pb-2 font-weight-bold"><span style="float:left"> <a class="btn btn-dark btn-sm" href="assets_management_home.php" style="font-size:11px!important"><i class="fa-solid fa-arrow-left"></i> Home</a></span>Asset Transfer Form</h6>
                                                <!-- row 0 starts -->


                                                <div class="row pb-3 justify-content-center" >

                                                    <div class="col-md-4 pb-md-0 pb-2">
                                                        <p>Receiving Custodian Name</p>
                                                        <input type="text" name="rc_name" class="w-100">
                                                    </div>
                                                    <div class="col-md-4 pb-md-0 pb-2">
                                                        <p>Receiving Custodian No.</p>
                                                        <input type="text" name="rc_no" class="w-100">
                                                    </div>
                                                    <div class="col-md-4 pb-md-0 pb-2">
                                                        <p>Department</p>
                                                        <!-- <input type="text" name="department_code" class="w-100"> -->
                                                        <select name="department_code" id="department_codet" class="w-100">
                                                            <!-- Populate options from database -->
                                                            <?php
                                                                $department =  $_SESSION['department'];
                                                                // $zone =  $_SESSION['zone'];
                                                                include 'dbconfig.php';
                                                                $select = "SELECT * FROM department";
                                                                $select_q = mysqli_query($conn, $select);
                                                                if (mysqli_num_rows($select_q) > 0) {
                                                                    while ($row = mysqli_fetch_assoc($select_q)) {
                                                                        echo '<option value="' . $row['department_name'] . '">' . $row['department_name'] . '</option>';
                                                                    }
                                                                } else {
                                                                    echo '<option value="">No department found</option>';
                                                                }
                                                                ?>
                                                        </select>
                                                    </div>

                                                </div>









                                               
                                                <div class="row pb-4 justify-content-center">
                                                    <div class="col-md-4 pb-md-0 pb-2">
                                                        <p>Date</p>
                                                        <input type="date" required name="date1" class="w-100">
                                                    </div>
                                                    <div class="col-md-4 pb-md-0 pb-2">
                                                        <p>Transfer Prepared By</p>
                                                        <input type="text" name="transfer_prepared_by"  class="w-100">
                                                    </div>
                                                    <div class="col-md-4 pb-md-0 pb-2">
                                                        <p>Date Prepared </p>
                                                        <input type="date" name="date_prepared"  class="w-100">
                                                    </div>
                                                </div>


                                                <div class="row pb-3 justify-content-center" >
                                                    <div class="col-12 pb-md-0 pb-2">
                                                        <p>Complete Address, (Area Code) Phone Number</p>
                                                        <input type="text" name="address" class="w-100">
                                                    </div>
                                                </div>

                                                <!-- row 0 ends -->
                                                <h6 class="text-center py-3 font-weight:700">Interdepartmental Asset Transfer</h6>
                                                <!-- row 1 starts -->
                                                <div class="row pb-3">
                                                    <div class="col-md-4 pb-md-0 pb-2">
                                                        <p>Asset Tag Number</p>
                                                        <input type="text" name="asset_tag_number"  class="w-100">
                                                    </div>
                                                    <div class="col-md-4 pb-md-0 pb-2">
                                                        <p>Quantity</p>
                                                        <input type="text" name="qty"  class="w-100">
                                                    </div>
                                                    <div class="col-md-4 pb-md-0 pb-2">
                                                        <p>Serial Number</p>
                                                        <input type="text" name="s_no"  class="w-100">
                                                    </div>
                                                </div>
                                                <!-- row 1 ends -->
                                                <!-- row 2 starts -->
                                                <div class="row pb-3">
                                                    <div class="col-md-4 pb-md-0 pb-2">
                                                        <p>Description, Mfg, Model, Serial No., Color</p>
                                                        <td><input type="text" autocomplete="off" name="desc" class="w-100"></td>
                                                    </div>
                                                    <div class="col-md-4 pb-md-0 pb-2">
                                                        <p>Cost</p>
                                                        <td><input type="text" autocomplete="off" name="cost" class="w-100"></td>
                                                    </div>
                                                    <div class="col-md-4 pb-md-0 pb-2">
                                                        <p>Bldg</p>
                                                        <td><input type="text" autocomplete="off" name="bldg" class="w-100"></td>
                                                    </div>
                                                </div>
                                                <!-- row 2 ends -->
                                                <!-- row 3 starts -->
                                                <div class="row pb-3">
                                                   
                                                    <div class="col-md-4 pb-md-0 pb-2">
                                                        <p>Room</p>
                                                        <td><input type="text" autocomplete="off" name="room" class="w-100"></td>
                                                    </div>
                                                    <div class="col-md-4 pb-md-0 pb-2">
                                                        <p>Owner Code</p>
                                                        <td><input type="text" autocomplete="off" name="owner_code" class="w-100"></td>
                                                    </div>
                                                    <div class="col-md-4 pb-md-0 pb-2">
                                                        <p>Comments</p>
                                                        <td><input type="text" autocomplete="off" name="comments" class="w-100"></td>
                                                    </div>
                                                </div>
                    
                                                <!-- row 4 ends -->
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
                                       $role = $_SESSION['role'];
                                     
                                       $date =  date('Y-m-d H:i:s');
                                       $head_email =  $_SESSION['head_email'];
                                    
                                       $be_depart =  $_SESSION['be_depart'];
                                       $be_role =  $_SESSION['be_role'];
                                    
                                       $rc_name = $_POST['rc_name'];
                                       $rc_no = $_POST['rc_no'];
                                       $department_code =  $_POST['department_code'];
                                    
                                       $date_1 =  $_POST['date_1'];
                                    
                                    
                                       $transfer_prepared_by =  $_POST['transfer_prepared_by'];
                                       $date_prepared =  $_POST['date_prepared'];
                                       $address =  $_POST['address'];
                                       
                                    
                                       $asset_tag_number = $_POST['asset_tag_number'];
                                       $qty = $_POST['qty'];
                                       $s_no =  $_POST['s_no'];
                                    
                                       $desc = $_POST['desc'];
                                       $cost = $_POST['cost'];
                                       $bldg =  $_POST['bldg'];
                                    
                                       $room = $_POST['room']; 
                                     
                                       $owner_code = $_POST['owner_code'];
                                       $comments = $_POST['comments'];
                                    
                                       $insert = "INSERT INTO intercompanytransfer_form 
                                       (rc_name,rc_no,department,date_1,transfer_prepared_by,date_prepared,address,asset_tag_number, qty,s_no, description,cost,bldg,room,owner_code,comments,user_name,user_date,user_department,user_role,finance_status,receiver_status)
                                       VALUES 
                                       ('$rc_name','$rc_no','$department_code','$date_1','$transfer_prepared_by','$date_prepared','$address','$asset_tag_number','$qty','$s_no','$desc','$cost','$bldg','$room','$owner_code','$comments','$username','$date','$department','$role','Pending','Pending')";
                                    
                                    
                                    
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
                                            $mail->isHTML(true);                                  //Set email format to HTML
                                            $mail->Subject = "New Asset Transfer Form Submission";
                                            $mail->Body = "
                                            <p>Dear Finance Department,</p>
                                            <p>A new Asset Transfer Form has been submitted by {$name}</p>
                                            ";
                                    
                                            $mail->send();
                                        } catch (Exception $e) {
                                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                                        }
    
                                        ?>
                                        <script type="text/javascript">
                                            alert("Your Request has been submitted!");
                                            window.location.href = "interCompanyTransfer_form.php";
                                        </script>
                                        <?php
                                    } else {
                                        ?>
                                        <script type="text/javascript">
                                            alert("Request submission failed!");
                                            window.location.href = "interCompanyTransfer_form.php";
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

        <script src="assets/js/main.js"></script>
    </body>
</html>