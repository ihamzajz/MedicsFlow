<?php 
session_start (); 
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php'); // Redirect to the login page
    exit;
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Your WorkOrder Requests</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        table tr th td{ 
            padding: 0 !important;
            margin: 0 !important;
            border: none;
        }
        th{
            width: 30%;
        }
        input{
            font-size: 14px!important;
        }
    </style>

    </script>


   
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">

    <?php
            include 'sidebar.php';
        ?>


        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">
            <!-- navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
<!--                     <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button> -->

                    <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                        </ul>
                    </div> -->
                </div>
            </nav>
            
            <h3 class="text-center">Add new car</h3>

            <form method="POST" enctype="multipart/form-data">
                <table class="table table=bordered">
                    <tr>
                        <th><label>Make</label></th>
                        <td><input type="text" name="make" class="form-control" placeholder="Make" autocomplete="off" required> </td>
                    </tr>

                    <tr>
                        <th><label>Model</label></th>
                        <td><input type="text" name="model" class="form-control" placeholder="Model" autocomplete="off" required> </td>
                    </tr>

                    <tr>
                        <th><label>Year</label></th>
                        <td><input type="number" name="year" class="form-control" placeholder="Year" autocomplete="off" required> </td>
                    </tr>

                    <tr>
                        <th><label>Engine Power</label></th>
                        <td><input type="text" name="engine_power"  class="form-control" placeholder="Engine Power" autocomplete="off" required> </td>
                    </tr>

                    <tr>
                        <th><label>Transmission</label></th>
                        <td><input type="text" name="transmission" class="form-control" placeholder="Transmission" autocomplete="off" required> </td>
                    </tr>

                    <tr>
                        <th><label>Fuel Type</label></th>
                        <td><input type="text" name="fuel_type" class="form-control" placeholder="Fuel Type" autocomplete="off" required> </td>
                    </tr>

                    <tr>
                        <th><label>Fuel Tank Capacity</label></th>
                        <td><input type="text" name="fuel_tank_capacity" class="form-control" placeholder="Fuel Tank Capacity" autocomplete="off" required> </td>
                    </tr>

                    <tr>
                        <th><label>Registration Number</label></th>
                        <td><input type="text" name="registration_number" class="form-control" placeholder="Registration Number" autocomplete="off" required> </td>
                    </tr>

                    <!-- <tr>
                        <th><label>Assign User id</label></th>
                        <td><input type="number" class="form-control" placeholder="Fuel Tank Capacity" autocomplete="off" required> </td>
                    </tr> -->

                    <tr>
                        <th><label for="status" style="font-size: 15px;">Status:</label></th>
                        <td>
                            <select name="status" id="" style="height: 32px; width:100%">
                                <option value="Available">Available</option>
                                <option value="In Use">In Use</option>
                                <option value="Under Maintaince">Under Maintaince</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th><label>Image</label></th>
                        <td><input type="file" name="image" class="form-control"  required> </td>
                    </tr>
                    <tr>
                        <th colspan="2">                  
                            <div class="text-center">
              			        <button type="submit" class="btn btn-dark" name="vehicle_submit">Create</button>
      			           </div>
                        </th>
                    </tr>


                </table>
            </form>
            <?php

            include 'dbconfig.php';
            if (isset($_POST['vehicle_submit'])) {
                $make =  $_POST['make'];
                $model =  $_POST['model'];
                $year =  $_POST['year'];
                $engine_power =  $_POST['engine_power'];
                $transmission =  $_POST['transmission'];
                $fuel_type =  $_POST['fuel_type'];
                $fuel_tank_capacity =  $_POST['fuel_tank_capacity'];

                $registration_number =  $_POST['registration_number'];
                $status =  $_POST['status'];
                //$image =  $_POST['image'];

                //$pdf =  $_FILES['bpdf']['name'];
                //$tmp_name =  $_FILES['bpdf']['tmp_name'];
               // $destination = "images/".$pdf;
                //move_uploaded_file($tmp_name, $destination);

                $image =  $_FILES['image']['name'];
                $tmp_name =  $_FILES['image']['tmp_name'];
                $destination = "assets/images/".$image;
                move_uploaded_file($tmp_name, $destination);

                $insert = "INSERT INTO vehicle_info (make,model,year,engine_power,transmission,fuel_type,fuel_tank_capacity,registration_number,status,image)
                 VALUES 
                 ('$make','$model','$year','$engine_power','$transmission','$fuel_type','$fuel_tank_capacity','$registration_number','$status','$image')";

                $insert_q=mysqli_query($conn,$insert);
                if ($insert_q) {
                    ?>
                    <script type="text/javascript">
                        alert("Data inserted successfully!");
                    </script>
                    <?php
                }
                else
                {
                    ?>
                    <script type="text/javascript">
                        alert("Data inserting failed!");
                    </script>
                    <?php
                }
                }

            ?>

       
        </div> <!--page content-->
    </div> <!--wrapper-->

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript" src="libs/js-xlsx/xlsx.core.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
        $('#example').DataTable({
            "paging": true, // Enable pagination
            "searching": true, // Enable search box
            // More options can be added as needed
        });
        });
    </script>

    <!-- table export -->
    <script src="
    https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/tableExport.min.js
    "></script>
    <script type="text/javascript" src="libs/FileSaver/FileSaver.min.js"></script>
    <script type="text/javascript" src="../libs/jsPDF/polyfills.umd.js"></script>
    <script type="text/javascript" src="tableExport.min.js"></script>
    <script type="text/javascript">
            $(document).ready(function() {
        $('#excel').click(function() {
            $('#myTable').tableExport({ type: 'excel',ignoreColumn: [8,9] });
            //$('#table_report').tableExport({ type: 'excel',escape:'false',ignoreColumn: [15]});
        });
    });
    </script>

    <script src="assets/js/main.js"></script>


</body>

</html>