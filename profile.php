<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
   header('Location: login.php'); // Redirect to the login page
   exit;
}

// Include database configuration
include 'dbconfig.php';
?>


<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8">

   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Profile</title>

   <?php
   include 'cdncss.php'
      ?>

   <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />

   <style>
      a {
         text-decoration: none !important
      }

      body {
         font-family: 'Poppins', sans-serif;
      }

      th {
         font-weight: 500;
      }

      th,
      td {
         font-size: 13px;
      }

      .btn {
         font-size: 11px !important;
         border-radius: 0px !important;
      }

      .slide {
         position: relative;
         overflow: hidden;
         background-color: #ced4da;
         /* initial purple */
         border: 1px solid black;
         /* dark purple border */
         color: black;
         font-weight: 600;
         border-radius: 4px;
         cursor: pointer;
         padding: 0 35px;
         display: inline-flex;
         align-items: center;
         justify-content: center;
         border-radius: 0px !important
      }

      .text {
         position: relative;
         z-index: 2;
         transition: color 0.4s ease;
      }

      /* White overlay sliding animation */
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

      /* Hover effects */
      .slide:hover::before {
         transform: translateX(-5%) skew(-15deg);
         /* slide overlay */
      }

      .slide:hover .text {
         color: black;
         /* text color matches border on hover */
      }

      .profile-heading {
         font-weight: 500 !important;
      }
   </style>
   <?php
   include 'sidebarcss.php'
      ?>
</head>

<body>
   <div class="wrapper" style="background-color: #FAFAFA!important;">
      <?php
      include 'sidebar1.php';
      ?>
      <!-- Page Content  -->
      <div id="content" style="background-color: #FAFAFA!important;">
         <!-- navbar -->
         <nav class="navbar navbar-expand-lg" style="background-color: #FAFAFA!important;">
            <div class="container-fluid">
               <button type="button" id="sidebarCollapse" class="btn btn-success">
                  <i class="fas fa-align-left"></i>
                  <span>Menu</span>
               </button>
            </div>
         </nav>
         <?php
         $id = $_SESSION['id'] ?? '';
         $fullname = $_SESSION['fullname'] ?? '';
         $username = $_SESSION['username'] ?? '';
         $password = $_SESSION['password'] ?? '';
         $email = $_SESSION['email'] ?? '';
         $gender = $_SESSION['gender'] ?? '';
         $department = $_SESSION['department'] ?? '';
         $role = $_SESSION['role'] ?? '';
         $added_date = $_SESSION['added_date'] ?? '';
         ?>
         <!-- Profile Section -->
         <div class="profile-section p-5">
            <h5 class="profile-heading" style="font-weight:600!important">Profile</h5>
            <div class="table-responsive">
               <table class="table table-bordered" style="background-color:White">
                  <tbody>

                     <tr>
                        <th>Full Name</th>
                        <td><?php echo htmlspecialchars($fullname); ?></td>
                     </tr>

                     <tr>
                        <th>Department</th>
                        <td><?php echo htmlspecialchars($department); ?></td>
                     </tr>
                     <tr>
                        <th>Role</th>
                        <td><?php echo htmlspecialchars($role); ?></td>
                     </tr>
                     <tr>
                        <th>Change Password</th>
                        <td>
                           <form method="post">
                              <input type="password" placeholder="Enter new password" name="new_password" required>


                              <button class="slide" name="change_password_btn"
                                 style="font-size: 11.5px;padding:4px 10px">
                                 <span class="text">Change Password</span>
                              </button>
                           </form>
                           <?php

                           if (isset($_POST['change_password_btn'])) {
                              $id = $_SESSION['id'];
                              $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
                              $sql = "UPDATE users SET password = '$new_password' WHERE id = $id";
                              if (mysqli_query($conn, $sql)) {
                                 echo "Password updated successfully.";
                              } else {
                                 echo "Error updating password: " . mysqli_error($conn);
                              }
                           }
                           ?>
                        </td>
                     </tr>
               </table>

               <h6 style="font-size:13.5px;font-weight:600" class="pt-4">For any query contact IT Department</h6>
               <p style="font-size:12px">muhammad.hamza@medicslab.com </br><span>farhan.arif@medicslab.com</span> </p>

            </div>
         </div>
      </div>

   </div>
   <!--wrapper-->
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"></script>
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






</body>

</html>
