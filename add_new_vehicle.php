<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
   header('Location: login.php');
   exit;
}
include 'dbconfig.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Add Vehicle</title>

   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
   <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

   <style>
      body {
         font-family: 'Poppins', sans-serif;
         background-color: #f5f6fa;
      }

      .card {
         border-radius: 10px;
      }

      label {
         font-weight: 500;
         font-size: 12px;
      }

      input {
         font-size: 12px !important;
      }

      .form-group {
         margin-bottom: 2px !important;
      }

      .bg-menu {
         background-color: #393E46 !important;
         border-radius: 0px !important;
      }

      .btn-menu {
         font-size: 12.5px;
         background-color: #FFB22C !important;
         padding: 5px 10px;
         font-weight: 600;
         border: none !important;
      }

      .btn {
         border-radius: 5px !important;
         ;
      }
   </style>
   <?php include 'sidebarcss.php'; ?>
</head>

<body>

   <div class="wrapper">
      <?php include 'sidebar1.php'; ?>

      <div id="content">
         <nav class="navbar navbar-expand-lg navbar-light bg-menu">
            <button type="button" id="sidebarCollapse" class="btn-menu">
               ☰ Menu
            </button>
         </nav>

         <div class="container mt-4">
            <div class="row justify-content-center">
               <div class="col-lg-10">

                  <div class="card shadow">
                     <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Add New Vehicle</h6>
                        <a href="vehicle_listall.php" class="btn btn-light btn-sm">Back</a>
                     </div>

                     <div class="card-body">
                        <form method="POST">

                           <div class="form-row">
                              <div class="form-group col-md-4">
                                 <label>Reg No</label>
                                 <input type="text" name="reg_no" class="form-control" required>
                              </div>
                              <div class="form-group col-md-4">
                                 <label>Reg Date</label>
                                 <input type="date" name="reg_date" class="form-control">
                              </div>
                              <div class="form-group col-md-4">
                                 <label>Type</label>
                                 <input type="text" name="type" class="form-control">
                              </div>
                           </div>

                           <div class="form-row">
                              <div class="form-group col-md-4">
                                 <label>Make</label>
                                 <input type="text" name="make" class="form-control">
                              </div>
                              <div class="form-group col-md-4">
                                 <label>Model</label>
                                 <input type="text" name="model" class="form-control">
                              </div>
                              <div class="form-group col-md-4">
                                 <label>Color</label>
                                 <input type="text" name="color" class="form-control">
                              </div>
                           </div>

                           <div class="form-row">
                              <div class="form-group col-md-4">
                                 <label>Engine No</label>
                                 <input type="text" name="engine_no" class="form-control">
                              </div>
                              <div class="form-group col-md-4">
                                 <label>Chassis No</label>
                                 <input type="text" name="chassis_no" class="form-control">
                              </div>
                              <div class="form-group col-md-4">
                                 <label>Engine Power</label>
                                 <input type="text" name="engine_power" class="form-control">
                              </div>
                           </div>

                           <div class="form-row">
                              <div class="form-group col-md-4">
                                 <label>User Name</label>
                                 <input type="text" name="user_name" class="form-control">
                              </div>
                              <div class="form-group col-md-4">
                                 <label>Designation</label>
                                 <input type="text" name="designation" class="form-control">
                              </div>
                              <div class="form-group col-md-4">
                                 <label>User Location</label>
                                 <input type="text" name="user_location" class="form-control">
                              </div>
                           </div>

                           <div class="form-group col-md-4 p-0">
                              <label>Fuel Tank Capacity</label>
                              <input type="text" name="fuel_tank_capacity" class="form-control">
                           </div>

                           <div class="text-center mt-4">
                              <button type="submit" name="submit" class="btn btn-dark px-4">
                                 Submit
                              </button>
                           </div>

                        </form>
                     </div>
                  </div>

               </div>
            </div>
         </div>

         <?php
         if (isset($_POST['submit'])) {

            $reg_no = $_POST['reg_no'];
            $reg_date = $_POST['reg_date'];
            $type = $_POST['type'];
            $make = $_POST['make'];
            $model = $_POST['model'];
            $color = $_POST['color'];
            $engine_no = $_POST['engine_no'];
            $chassis_no = $_POST['chassis_no'];
            $engine_power = $_POST['engine_power'];
            $user_name = $_POST['user_name'];
            $designation = $_POST['designation'];
            $user_location = $_POST['user_location'];
            $fuel_tank_capacity = $_POST['fuel_tank_capacity'];

            // CHECK DUPLICATE REG NO
            $check = mysqli_query($conn, "SELECT vehicle_id FROM vehicle WHERE reg_no='$reg_no'");

            if (mysqli_num_rows($check) > 0) {
               echo "<script>alert('This Reg No already exists!');</script>";
            } else {

               $insert = "INSERT INTO vehicle
        (reg_no, reg_date, type, make, model, color, engine_no, chassis_no, engine_power, user_name, designation, user_location, fuel_tank_capacity)
        VALUES
        ('$reg_no','$reg_date','$type','$make','$model','$color','$engine_no','$chassis_no','$engine_power','$user_name','$designation','$user_location','$fuel_tank_capacity')";

               if (mysqli_query($conn, $insert)) {
                  echo "<script>
                alert('Vehicle added successfully!');
                window.location.href='add_new_vehicle.php';
            </script>";
               } else {
                  echo "<script>alert('Insert failed');</script>";
               }
            }
         }
         ?>

         <?php include 'footer.php'; ?>

         <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
         <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

</body>

</html>