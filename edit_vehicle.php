<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vehicle</title>

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
</head>

<body>

    <?php
    include 'dbconfig.php';

    if (!isset($_GET['vehicle_id'])) {
        die("Vehicle ID missing");
    }

    $vehicle_id = $_GET['vehicle_id'];

    // Fetch existing data
    $result = mysqli_query($conn, "SELECT * FROM vehicle WHERE vehicle_id = '$vehicle_id'");
    $data = mysqli_fetch_assoc($result);

    // Update logic
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

        // CHECK DUPLICATE REG NO (EXCEPT CURRENT RECORD)
        $check = mysqli_query(
            $conn,
            "SELECT vehicle_id FROM vehicle 
         WHERE reg_no = '$reg_no' AND vehicle_id != '$vehicle_id'"
        );

        if (mysqli_num_rows($check) > 0) {
            echo "<script>alert('This Reg No already exists!');</script>";
        } else {

            $update = "UPDATE vehicle SET
            reg_no='$reg_no',
            reg_date='$reg_date',
            type='$type',
            make='$make',
            model='$model',
            color='$color',
            engine_no='$engine_no',
            chassis_no='$chassis_no',
            engine_power='$engine_power',
            user_name='$user_name',
            designation='$designation',
            user_location='$user_location',
            fuel_tank_capacity='$fuel_tank_capacity'
            WHERE vehicle_id='$vehicle_id'";

            if (mysqli_query($conn, $update)) {
                echo "<script>
                alert('Vehicle updated successfully!');
                window.location.href='vehicle_listall.php';
            </script>";
            } else {
                echo "<script>alert('Update failed');</script>";
            }
        }
    }
    ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Edit Vehicle</h6>
                        <a href="vehicle_listall.php" class="btn btn-light btn-sm">Back</a>
                    </div>

                    <div class="card-body">
                        <form method="POST">

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Reg No</label>
                                    <input type="text" name="reg_no" class="form-control" required value="<?= $data['reg_no'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Reg Date</label>
                                    <input type="date" name="reg_date" class="form-control" value="<?= $data['reg_date'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Type</label>
                                    <input type="text" name="type" class="form-control" value="<?= $data['type'] ?>">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Make</label>
                                    <input type="text" name="make" class="form-control" value="<?= $data['make'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Model</label>
                                    <input type="text" name="model" class="form-control" value="<?= $data['model'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Color</label>
                                    <input type="text" name="color" class="form-control" value="<?= $data['color'] ?>">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Engine No</label>
                                    <input type="text" name="engine_no" class="form-control" value="<?= $data['engine_no'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Chassis No</label>
                                    <input type="text" name="chassis_no" class="form-control" value="<?= $data['chassis_no'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Engine Power</label>
                                    <input type="text" name="engine_power" class="form-control" value="<?= $data['engine_power'] ?>">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>User Name</label>
                                    <input type="text" name="user_name" class="form-control" value="<?= $data['user_name'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Designation</label>
                                    <input type="text" name="designation" class="form-control" value="<?= $data['designation'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>User Location</label>
                                    <input type="text" name="user_location" class="form-control" value="<?= $data['user_location'] ?>">
                                </div>
                            </div>

                            <div class="form-group col-md-4 p-0">
                                <label>Fuel Tank Capacity</label>
                                <input type="text" name="fuel_tank_capacity" class="form-control" value="<?= $data['fuel_tank_capacity'] ?>">
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" name="submit" class="btn btn-dark px-4">
                                    Save Changes
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

</body>

</html>