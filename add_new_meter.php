<?php
session_start();


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
   <title>MedicsFlow</title>
   <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
   <?php
   include 'cdncss.php'
   ?>
   <style>
      .bg-menu {
         background-color: #393E46 !important;
      }

      .btn-menu {
         font-size: 12.5px;
         background-color: #FFB22C !important;
         padding: 5px 10px;
         font-weight: 600;
         border: none !important;
      }

      body {
         font-family: 'Poppins', sans-serif;
      }

      .btn {
         border-radius: 0px;
         font-size: 11px !important;
      }

      .btn-home {
         background-color: #62CDFF;
         border: 1px solid #62CDFF;
         color: black;
         padding: 5px 10px;
         font-weight: 600;
         border: none !important;
         font-size: 12px;
      }

      .btn-back {
         background-color: #56DFCF;
         color: black;
         padding: 5px 10px;
         font-weight: 600;
         border: 1px solid #56DFCF;
         font-size: 12px;
      }

      .slide {
         position: relative;
         overflow: hidden;
         background-color: #7868E6;
         border: 2px solid #4B2C91;
         color: white;
         font-weight: 600;
         border-radius: 4px;
         cursor: pointer;
         padding: 0 35px;
         display: inline-flex;
         align-items: center;
         justify-content: center;
      }

      .text {
         position: relative;
         z-index: 2;
         transition: color 0.4s ease;
      }

      .slide::before {
         content: "";
         position: absolute;
         top: 0;
         left: 0;
         width: 130%;
         height: 100%;
         background-color: white;
         /* white overlay */
         transform: translateX(-110%) skew(-30deg);
         transition: transform 0.5s ease;
         z-index: 1;
      }

      .slide:hover::before {
         transform: translateX(-5%) skew(-15deg);
      }

      .slide:hover .text {
         color: #4B2C91;
      }
   </style>
   <style>
      .sub {
         font-size: 11px !important;
      }

      th,
      td {
         padding: 5px !important;
         margin: 0px !important;
      }

      th {
         background-color: #FFB0B0;
         font-size: 13px;
         text-align-last: center;
      }

      input {
         font-size: 13px;
         background-color: #f2f2f2;
         padding-top: 2px;
         padding-bottom: 2px;
         border: 1px solid black;
         padding-left: 5px;
      }


   </style>


   <?php
   include 'sidebarcss.php';
   ?>
</head>

<body background-color="white">
   <div class="wrapper">
      <?php
      include 'sidebar1.php';
      ?>
      <!-- Page Content  -->
      <div id="content">
         <!-- navbar -->
         <nav class="navbar navbar-expand-lg navbar-light bg-menu">
            <div class="container-fluid">
               <button type="button" id="sidebarCollapse" class="btn-menu">
                  <i class="fas fa-align-left"></i>
                  <span>Menu</span>
               </button>
            </div>
         </nav>
         <section>
            <div class="container-fluid">
               <div class="row justify-content-center">
                  <div class="col">
                     <form class="form pb-2" method="POST">
                        <div class="container">
                           <div class="row justify-content-center">
                              <div class="col-9 p-5" Style="border:1px solid black; background-color:white">
                                 <h5 class="text-center pb-3 font-weight-bold">
                                    <a href="ecs.php" class="btn-back" style="float:right!important">Back</a> Add New Meter
                                 </h5>
                                 <div class="row pb-2">
                                    <div class="col-md-4">
                                       <p>Meter Name</p>
                                       <input type="text" autocomplete="off" name="name" class="w-100">
                                    </div>

                                    <div class="col-md-4">
                                       <p>Area</p>
                                       <input type="text" autocomplete="off" name="area" class="w-100">
                                    </div>

                                    <div class="col-md-4">
                                       <p>Tag #</p>
                                       <input type="text" autocomplete="off" name="tagno" class="w-100">
                                    </div>
                                 </div>

                                 <div class="row pb-2">
                                    <div class="col-md-4">
                                       <p>Meter Type</p>
                                       <label style="font-size:12px!important;font-weight:500!important"><input type="checkbox" class="type-checkbox cbox" name="meter_type" value="K-Electric"> K-Electric&nbsp;</label>
                                       <label style="font-size:12px!important;font-weight:500!important"><input type="checkbox" class="type-checkbox cbox" name="meter_type" value="SUI Gas"> SUI Gas</label>
                                    </div>

                                 </div>



                                 <div class="text-center mt-3">
                                    <button class="slide" name="submit"
                                       style="font-size: 17px; height: 36px; width: 150px;">
                                       <span class="text">Submit</span>
                                    </button>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </form>
                     <?php
                     include 'dbconfig.php';

                     if (isset($_POST['submit'])) {
                        date_default_timezone_set("Asia/Karachi");

                        // Collect form and session data
                        $id = $_SESSION['id'];
                        $name = $_SESSION['fullname'];
                        $email = $_SESSION['email'];
                        $username = $_SESSION['username'];
                        $department = $_SESSION['department'];
                        $date = date('Y-m-d');
                        $head_email = $_SESSION['head_email'];

                        $be_depart = $_SESSION['be_depart'];
                        $be_role = $_SESSION['be_role'];

                        $name = $_POST['name'];

                        $area = $_POST['area'];
                        $tagno = $_POST['tagno'];

                        $meter_type = $_POST['meter_type'];



                        $insert = "INSERT INTO meters
                                (name, area, tagno, meter_type)
                                VALUES 
                                ('$name', '$area', '$tagno', '$meter_type')";

                        // SQL query for inserting data into the database
                        // $insert = "INSERT INTO assets
                        //     (purchase_date, supplier_name, invoice_number, location, asset_tag_number, quantity, s_no, name_description, cost, `usage`, model, owner_code, comments, user_name, user_date, user_department, user_role, finance_status, po_approve_status, status, grn_status, po_no_status, po_date_status, update_date)
                        //     VALUES 
                        //     ('$ar_date', '$supplier_name', '$ar_invoice_number', '$ar_location', '$asset_tag_number', '$qty', '$s_no', '$desc', '$cost', '$usage', '$model', '$owner_code', '$comment', '$username', '$date', '$department', '$role', 'Pending', '$po_approve_status', 'Pending', 'Pending', 'Pending', 'Pending', 'Pending')";

                        // Execute the query
                        $insert_q = mysqli_query($conn, $insert);

                        if ($insert_q) {
                     ?>
                           <script type="text/javascript">
                              alert("Data has been submitted");
                              window.location.href = "add_new_meter.php";
                           </script>
                        <?php
                        } else {
                        ?>
                           <script type="text/javascript">
                              alert("Data submission failed!");
                              window.location.href = "add_new_meter.php";
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
      document.addEventListener('DOMContentLoaded', function() {
         const checkboxes = document.querySelectorAll('.add-remove-checkbox');

         checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
               const groupName = this.name.split('_')[0]; // Extract the group name

               // Uncheck other checkboxes in the same group
               checkboxes.forEach(function(cb) {
                  if (cb !== checkbox && cb.name.startsWith(groupName)) {
                     cb.checked = false;
                  }
               });
            });
         });
      });
   </script>


   <script>
      document.addEventListener('DOMContentLoaded', function() {
         const checkboxes = document.querySelectorAll('.type-checkbox');

         checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
               const groupName = this.name.split('_')[0]; // Extract the group name

               // Uncheck other checkboxes in the same group
               checkboxes.forEach(function(cb) {
                  if (cb !== checkbox && cb.name.startsWith(groupName)) {
                     cb.checked = false;
                  }
               });
            });
         });
      });
   </script>

   <script>
      document.addEventListener('DOMContentLoaded', function() {
         const checkboxes = document.querySelectorAll('.type-checkbox');

         checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
               const groupName = this.name.split('_')[0]; // Extract the group name

               // Uncheck other checkboxes in the same group
               checkboxes.forEach(function(cb) {
                  if (cb !== checkbox && cb.name.startsWith(groupName)) {
                     cb.checked = false;
                  }
               });
            });
         });
      });
   </script>




    <?php
    include 'footer.php'
    ?>