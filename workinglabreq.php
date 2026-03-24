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
        <title>Lab Req - Chest Rub</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <!-- Our Custom CSS -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="assets/css/style.css">
        <style>
    /* Custom file upload button */
    .custom-file-upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
    }

            tr{
            border-bottom: 1px solid black;
            }
            th{
            font-size: 11.5px!important;
            }
            td{
            font-size: 11.5px!important;
            padding:10px !important;
            border: 1px solid black!important;
            /* border: 0.5px solid black!important; */
            }
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
            .btn{
            font-size: 11px!important;
            border-radius:0px!important;
            }
            .btn-menu{
            font-size: 11px;
            }
            .cbox{
            height: 13px!important;
            width: 13px!important;
            }
            td, .labelf{
            /* font-size: 12.5px!important; */
            padding: 0px!important;
            margin: 0px!important;
            font-weight: 500;
            }
            .labelf{
            font-size: 13.5px!important;
            padding: 0px!important;
            margin: 0px!important;
            font-weight: 500;
            }
            input {
            width: 100% !important;
            font-size: 11.5px; 
            border-radius: 0px;
            border: none;
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
            input[type=file] {
            font-size: 10px !important; 
            margin: 0; 
            padding: 0;
            border-radius: 0!important; 
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
                        <button type="button" id="sidebarCollapse" class="btn btn-info btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                        </button>
                    </div>
                </nav>



                <?php
include 'dbconfig.php';

$id = $_GET['id']; // Assuming 'id' is passed via GET method
$select = "SELECT * FROM lab_req WHERE id = '$id'";
$select_q = mysqli_query($conn, $select);
$data = mysqli_num_rows($select_q);

if ($data) {
    $row = mysqli_fetch_assoc($select_q); // Fetch a single row

    // Handle the form submission (Image Upload and Text Fields)
    if (isset($_POST['submit'])) {
        $id = $_GET['id'];  // Assuming 'id' is passed via GET method
        $name = $_SESSION['fullname'];

        // Text fields update (retaining previous data if not modified)
        $f_statement_1 = !empty($_POST['statement_1']) ? $_POST['statement_1'] : $row['statement_1'];
        $f_language_1 = !empty($_POST['language_1']) ? $_POST['language_1'] : $row['language_1'];

        // Image upload logic (separate from update query)
        $image_url = $row['image_url']; // Default to the current image URL

        // Check if the user uploaded a new image
        if (isset($_FILES['upload_1']) && $_FILES['upload_1']['error'] == 0) {
            $uploadDir = 'assets/uploads/';
            $fileName = basename($_FILES['upload_1']['name']);
            $filePath = $uploadDir . $fileName;

            // Try to move the uploaded file
            if (move_uploaded_file($_FILES['upload_1']['tmp_name'], $filePath)) {
                $image_url = $filePath;  // Update the image URL with the new file path
            } else {
                echo "<script>alert('Image upload failed');</script>";
            }
        }

        // Update query for text fields and image URL
        $update_query = "UPDATE lab_req SET 
                         statement_1 = '$f_statement_1',
                         language_1 = '$f_language_1',
                         image_url = '$image_url'  -- Only update the image URL if changed
                         WHERE id = '$id'";

        // Execute the update query
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            echo "<script>
                    alert('Record updated successfully');
                    window.location.href = window.location.href; // Reload the page
                  </script>";
        } else {
            echo "<script>alert('Error updating record: " . mysqli_error($conn) . "');</script>";
        }
    }

    ?>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <form class="form pb-3" method="POST" enctype="multipart/form-data">
                <div class="col-md-12 pt-md-2">
                    <h6 class="text-center">Labelling Requirements - Medics Chest Rub</h6>
                    <table class="table table-responsiove">
                        <thead style="background-color: grey; color: white;">
                            <tr style="border:1px solid white!important">
                                <th style="width:20px!important">Sno</th>
                                <th>Parameters</th>
                                <th>Statement</th>
                                <th>Languages</th>
                                <th>Upload</th>
                                <th>Concern Department</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="pl-2">1</td>
                                <td class="pl-2" id="pro_name1">Product name / Brand Name</td> <!-- Product name captured here -->
                                <td>
                                    <input type="text" name="statement_1" value="<?php echo htmlspecialchars($row['statement_1']); ?>">
                                </td>
                                <td>
                                    <input type="text" name="language_1" value="<?php echo htmlspecialchars($row['language_1']); ?>">
                                </td>
                                <td>
                                    <!-- If image URL exists, display "View Image" button -->
                                    <?php if (!empty($row['image_url'])) { ?>
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#viewImageModal">View Image</button>
                                    <?php } else { ?>
                                        <label class="custom-file-upload">
                                            <input type="file" name="upload_1" accept="image/*">
                                            Upload Image
                                        </label>
                                    <?php } ?>
                                </td>
                                <td class="pl-2">Regulatory Affairs</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-submit" name="submit" style="font-size: 20px">Submit</button>
                    </div>
                </div>
            </form>

            <!-- Modal for Viewing Image (if it exists) -->
            <?php if (!empty($row['image_url'])) { ?>
                <div class="modal fade" id="viewImageModal" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img src="<?php echo $row['image_url']; ?>" class="img-fluid" alt="Uploaded Image">
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>

    <?php
} else {
    echo "No record found!";
}
?>




</div>
</div>
    <!--wrapper-->
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

        <script>
    document.querySelector('.form').onsubmit = function() {
        // Set the hidden input values based on the product name text
        document.getElementById('pro_name1_input').value = document.getElementById('pro_name1').innerText.trim();
        document.getElementById('pro_name2_input').value = document.getElementById('pro_name2').innerText.trim();
        document.getElementById('pro_name3_input').value = document.getElementById('pro_name3').innerText.trim();
        document.getElementById('pro_name4_input').value = document.getElementById('pro_name4').innerText.trim();
        document.getElementById('pro_name5_input').value = document.getElementById('pro_name5').innerText.trim();
        document.getElementById('pro_name6_input').value = document.getElementById('pro_name6').innerText.trim();
        document.getElementById('pro_name7_input').value = document.getElementById('pro_name7').innerText.trim();
        document.getElementById('pro_name8_input').value = document.getElementById('pro_name8').innerText.trim();
        document.getElementById('pro_name9_input').value = document.getElementById('pro_name9').innerText.trim();
        document.getElementById('pro_name10_input').value = document.getElementById('pro_name10').innerText.trim();
        document.getElementById('pro_name11_input').value = document.getElementById('pro_name11').innerText.trim();
        document.getElementById('pro_name12_input').value = document.getElementById('pro_name12').innerText.trim();
        document.getElementById('pro_name13_input').value = document.getElementById('pro_name13').innerText.trim();
        document.getElementById('pro_name14_input').value = document.getElementById('pro_name14').innerText.trim();
        document.getElementById('pro_name15_input').value = document.getElementById('pro_name15').innerText.trim();
        document.getElementById('pro_name16_input').value = document.getElementById('pro_name16').innerText.trim();
        document.getElementById('pro_name17_input').value = document.getElementById('pro_name17').innerText.trim();
        document.getElementById('pro_name18_input').value = document.getElementById('pro_name18').innerText.trim();
        document.getElementById('pro_name19_input').value = document.getElementById('pro_name19').innerText.trim();
        document.getElementById('pro_name20_input').value = document.getElementById('pro_name20').innerText.trim();
        document.getElementById('pro_name21_input').value = document.getElementById('pro_name21').innerText.trim();
        document.getElementById('pro_name22_input').value = document.getElementById('pro_name22').innerText.trim();
        document.getElementById('pro_name23_input').value = document.getElementById('pro_name23').innerText.trim();
        document.getElementById('pro_name24_input').value = document.getElementById('pro_name24').innerText.trim();
        document.getElementById('pro_name25_input').value = document.getElementById('pro_name25').innerText.trim();
        document.getElementById('pro_name26_input').value = document.getElementById('pro_name26').innerText.trim();

    }
</script>

    </body>
</html>