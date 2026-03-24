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

    textarea{
        font-size: 11.5px!important;
        font-weight:400;
        padding:5px;
       
        
    }

    input{
        font-size: 11.5px!important;
    }
    th{
        font-size: 11.5px!important;
    }
    td{
        font-size: 11.5px!important;
        font-weight: 500!important;
        border:0.1px solid grey;
       
       
    }

</style>


 
        <style>
    /* Custom file upload button */
    .custom-file-upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
    }

       
    .btn-submit {
            font-size: 25px !important; 
            color: white;
            background-color: #0d6efd;
            padding: 5px 35px;
            border-radius: 2px;
            border: 2px solid #0d6efd;
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
            .labelf{
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
          <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

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

// Fetch existing data
$select = "SELECT * FROM lab_req WHERE id = '$id'";
$select_q = mysqli_query($conn, $select);
$data = mysqli_num_rows($select_q);

if ($data) {
    $row = mysqli_fetch_assoc($select_q); // Fetch a single row

    // Handle the form submission (Image Upload and Text Fields)
    if (isset($_POST['submit'])) {
        $id = $_GET['id'];  // Get ID again from GET
        $name = $_SESSION['fullname']; // Logged-in username

        // Retain existing values if fields are not modified
        $f_statement_1 = !empty($_POST['statement_1']) ? $_POST['statement_1'] : $row['statement_1'];
        $f_language_1 = !empty($_POST['language_1']) ? $_POST['language_1'] : $row['language_1'];
        $f_pro_name1 = !empty($_POST['pro_name1']) ? $_POST['pro_name1'] : $row['pro_name1'];

        $f_statement_2 = !empty($_POST['statement_2']) ? $_POST['statement_2'] : $row['statement_2'];
        $f_language_2 = !empty($_POST['language_2']) ? $_POST['language_2'] : $row['language_2'];
        $f_pro_name2 = !empty($_POST['pro_name2']) ? $_POST['pro_name2'] : $row['pro_name2'];

        $f_statement_3 = !empty($_POST['statement_3']) ? $_POST['statement_3'] : $row['statement_3'];
        $f_language_3 = !empty($_POST['language_3']) ? $_POST['language_3'] : $row['language_3'];
        $f_pro_name3 = !empty($_POST['pro_name3']) ? $_POST['pro_name3'] : $row['pro_name3'];

        $f_statement_4 = !empty($_POST['statement_4']) ? $_POST['statement_4'] : $row['statement_4'];
        $f_language_4 = !empty($_POST['language_4']) ? $_POST['language_4'] : $row['language_4'];
        $f_pro_name4 = !empty($_POST['pro_name4']) ? $_POST['pro_name4'] : $row['pro_name4'];

        $f_statement_5 = !empty($_POST['statement_5']) ? $_POST['statement_5'] : $row['statement_5'];
        $f_language_5 = !empty($_POST['language_5']) ? $_POST['language_5'] : $row['language_5'];
        $f_pro_name5 = !empty($_POST['pro_name5']) ? $_POST['pro_name5'] : $row['pro_name5'];

        $f_statement_6 = !empty($_POST['statement_6']) ? $_POST['statement_6'] : $row['statement_6'];
        $f_language_6 = !empty($_POST['language_6']) ? $_POST['language_6'] : $row['language_6'];
        $f_pro_name6 = !empty($_POST['pro_name6']) ? $_POST['pro_name6'] : $row['pro_name6'];

        $f_statement_7 = !empty($_POST['statement_7']) ? $_POST['statement_7'] : $row['statement_7'];
        $f_language_7 = !empty($_POST['language_7']) ? $_POST['language_7'] : $row['language_7'];
        $f_pro_name7 = !empty($_POST['pro_name7']) ? $_POST['pro_name7'] : $row['pro_name7'];

        $f_statement_8 = !empty($_POST['statement_8']) ? $_POST['statement_8'] : $row['statement_8'];
        $f_language_8 = !empty($_POST['language_8']) ? $_POST['language_8'] : $row['language_8'];
        $f_pro_name8 = !empty($_POST['pro_name8']) ? $_POST['pro_name8'] : $row['pro_name8'];

        $f_statement_9 = !empty($_POST['statement_9']) ? $_POST['statement_9'] : $row['statement_9'];
        $f_language_9 = !empty($_POST['language_9']) ? $_POST['language_9'] : $row['language_9'];
        $f_pro_name9 = !empty($_POST['pro_name9']) ? $_POST['pro_name9'] : $row['pro_name9'];

        $f_statement_10 = !empty($_POST['statement_10']) ? $_POST['statement_10'] : $row['statement_10'];
        $f_language_10 = !empty($_POST['language_10']) ? $_POST['language_10'] : $row['language_10'];
        $f_pro_name10 = !empty($_POST['pro_name10']) ? $_POST['pro_name10'] : $row['pro_name10'];

        $f_statement_11 = !empty($_POST['statement_11']) ? $_POST['statement_11'] : $row['statement_11'];
        $f_language_11 = !empty($_POST['language_11']) ? $_POST['language_11'] : $row['language_11'];
        $f_pro_name11 = !empty($_POST['pro_name11']) ? $_POST['pro_name11'] : $row['pro_name11'];

        $f_statement_12 = !empty($_POST['statement_12']) ? $_POST['statement_12'] : $row['statement_12'];
        $f_language_12 = !empty($_POST['language_12']) ? $_POST['language_12'] : $row['language_12'];
        $f_pro_name12 = !empty($_POST['pro_name12']) ? $_POST['pro_name12'] : $row['pro_name12'];

        $f_statement_13 = !empty($_POST['statement_13']) ? $_POST['statement_13'] : $row['statement_13'];
        $f_language_13 = !empty($_POST['language_13']) ? $_POST['language_13'] : $row['language_13'];
        $f_pro_name13 = !empty($_POST['pro_name13']) ? $_POST['pro_name13'] : $row['pro_name13'];

        $f_statement_14 = !empty($_POST['statement_14']) ? $_POST['statement_14'] : $row['statement_14'];
        $f_language_14 = !empty($_POST['language_14']) ? $_POST['language_14'] : $row['language_14'];
        $f_pro_name14 = !empty($_POST['pro_name14']) ? $_POST['pro_name14'] : $row['pro_name14'];

        $f_statement_15 = !empty($_POST['statement_15']) ? $_POST['statement_15'] : $row['statement_15'];
        $f_language_15 = !empty($_POST['language_15']) ? $_POST['language_15'] : $row['language_15'];
        $f_pro_name15 = !empty($_POST['pro_name15']) ? $_POST['pro_name15'] : $row['pro_name15'];

        $f_statement_16 = !empty($_POST['statement_16']) ? $_POST['statement_16'] : $row['statement_16'];
        $f_language_16 = !empty($_POST['language_16']) ? $_POST['language_16'] : $row['language_16'];
        $f_pro_name16 = !empty($_POST['pro_name16']) ? $_POST['pro_name16'] : $row['pro_name16'];

        $f_statement_17 = !empty($_POST['statement_17']) ? $_POST['statement_17'] : $row['statement_17'];
        $f_language_17 = !empty($_POST['language_17']) ? $_POST['language_17'] : $row['language_17'];
        $f_pro_name17 = !empty($_POST['pro_name17']) ? $_POST['pro_name17'] : $row['pro_name17'];

        $f_statement_18 = !empty($_POST['statement_18']) ? $_POST['statement_18'] : $row['statement_18'];
        $f_language_18 = !empty($_POST['language_18']) ? $_POST['language_18'] : $row['language_18'];
        $f_pro_name18 = !empty($_POST['pro_name18']) ? $_POST['pro_name18'] : $row['pro_name18'];

        $f_statement_19 = !empty($_POST['statement_19']) ? $_POST['statement_19'] : $row['statement_19'];
        $f_language_19 = !empty($_POST['language_19']) ? $_POST['language_19'] : $row['language_19'];
        $f_pro_name19 = !empty($_POST['pro_name19']) ? $_POST['pro_name19'] : $row['pro_name19'];

        $f_statement_20 = !empty($_POST['statement_20']) ? $_POST['statement_20'] : $row['statement_20'];
        $f_language_20 = !empty($_POST['language_20']) ? $_POST['language_20'] : $row['language_20'];
        $f_pro_name20 = !empty($_POST['pro_name20']) ? $_POST['pro_name20'] : $row['pro_name20'];

        $f_statement_21 = !empty($_POST['statement_21']) ? $_POST['statement_21'] : $row['statement_21'];
        $f_language_21 = !empty($_POST['language_21']) ? $_POST['language_21'] : $row['language_21'];
        $f_pro_name21 = !empty($_POST['pro_name21']) ? $_POST['pro_name21'] : $row['pro_name21'];

        $f_statement_22 = !empty($_POST['statement_22']) ? $_POST['statement_22'] : $row['statement_22'];
        $f_language_22 = !empty($_POST['language_22']) ? $_POST['language_22'] : $row['language_22'];
        $f_pro_name22 = !empty($_POST['pro_name22']) ? $_POST['pro_name22'] : $row['pro_name22'];

        $f_statement_23 = !empty($_POST['statement_23']) ? $_POST['statement_23'] : $row['statement_23'];
        $f_language_23 = !empty($_POST['language_23']) ? $_POST['language_23'] : $row['language_23'];
        $f_pro_name23 = !empty($_POST['pro_name23']) ? $_POST['pro_name23'] : $row['pro_name23'];

        $f_statement_24 = !empty($_POST['statement_24']) ? $_POST['statement_24'] : $row['statement_24'];
        $f_language_24 = !empty($_POST['language_24']) ? $_POST['language_24'] : $row['language_24'];
        $f_pro_name24 = !empty($_POST['pro_name24']) ? $_POST['pro_name24'] : $row['pro_name24'];

        $f_statement_25 = !empty($_POST['statement_25']) ? $_POST['statement_25'] : $row['statement_25'];
        $f_language_25 = !empty($_POST['language_25']) ? $_POST['language_25'] : $row['language_25'];
        $f_pro_name25 = !empty($_POST['pro_name25']) ? $_POST['pro_name25'] : $row['pro_name25'];

        $f_statement_26 = !empty($_POST['statement_26']) ? $_POST['statement_26'] : $row['statement_26'];
        $f_language_26 = !empty($_POST['language_26']) ? $_POST['language_26'] : $row['language_26'];
        $f_pro_name26 = !empty($_POST['pro_name26']) ? $_POST['pro_name26'] : $row['pro_name26'];





        // Image upload handling for the first row
        $upload_1 = isset($row['upload_1']) ? $row['upload_1'] : ''; // Default to existing image or empty string
        if (isset($_FILES['upload_1']) && $_FILES['upload_1']['error'] == 0) {
            $uploadDir = 'assets/uploads/';
            $fileName = time() . '_' . basename($_FILES['upload_1']['name']);
            $filePath = $uploadDir . $fileName;

            // Move uploaded file
            if (move_uploaded_file($_FILES['upload_1']['tmp_name'], $filePath)) {
                $upload_1 = $filePath;  // Update image path
            } else {
                echo "<script>alert('Image upload failed');</script>";
            }
        }





        // Image upload handling for the second row
        $upload_2 = isset($row['upload_2']) ? $row['upload_2'] : ''; // Default to existing image or empty string
        if (isset($_FILES['upload_2']) && $_FILES['upload_2']['error'] == 0) {
            $uploadDir = 'assets/uploads/';
            $fileName = time() . '_' . basename($_FILES['upload_2']['name']);
            $filePath = $uploadDir . $fileName;

            // Move uploaded file
            if (move_uploaded_file($_FILES['upload_2']['tmp_name'], $filePath)) {
                $upload_2 = $filePath;  // Update image path
            } else {
                echo "<script>alert('Image upload failed');</script>";
            }
        }

        // Image upload handling for the third row
        $upload_3 = isset($row['upload_3']) ? $row['upload_3'] : ''; // Default to existing image or empty string
        if (isset($_FILES['upload_3']) && $_FILES['upload_3']['error'] == 0) {
            $uploadDir = 'assets/uploads/';
            $fileName = time() . '_' . basename($_FILES['upload_3']['name']);
            $filePath = $uploadDir . $fileName;

            // Move uploaded file
            if (move_uploaded_file($_FILES['upload_3']['tmp_name'], $filePath)) {
                $upload_3 = $filePath;  // Update image path
            } else {
                echo "<script>alert('Image upload failed');</script>";
            }
        }


           // Image upload handling for the third row
           $upload_4 = isset($row['upload_4']) ? $row['upload_4'] : ''; // Default to existing image or empty string
           if (isset($_FILES['upload_4']) && $_FILES['upload_4']['error'] == 0) {
               $uploadDir = 'assets/uploads/';
               $fileName = time() . '_' . basename($_FILES['upload_4']['name']);
               $filePath = $uploadDir . $fileName;
   
               // Move uploaded file
               if (move_uploaded_file($_FILES['upload_4']['tmp_name'], $filePath)) {
                   $upload_4 = $filePath;  // Update image path
               } else {
                   echo "<script>alert('Image upload failed');</script>";
               }
           }


              // Image upload handling for the third row
        $upload_5 = isset($row['upload_5']) ? $row['upload_5'] : ''; // Default to existing image or empty string
        if (isset($_FILES['upload_5']) && $_FILES['upload_5']['error'] == 0) {
            $uploadDir = 'assets/uploads/';
            $fileName = time() . '_' . basename($_FILES['upload_5']['name']);
            $filePath = $uploadDir . $fileName;

            // Move uploaded file
            if (move_uploaded_file($_FILES['upload_5']['tmp_name'], $filePath)) {
                $upload_5 = $filePath;  // Update image path
            } else {
                echo "<script>alert('Image upload failed');</script>";
            }
        }

             // Image upload handling for the third row
             $upload_6 = isset($row['upload_6']) ? $row['upload_6'] : ''; // Default to existing image or empty string
             if (isset($_FILES['upload_6']) && $_FILES['upload_6']['error'] == 0) {
                 $uploadDir = 'assets/uploads/';
                 $fileName = time() . '_' . basename($_FILES['upload_6']['name']);
                 $filePath = $uploadDir . $fileName;
     
                 // Move uploaded file
                 if (move_uploaded_file($_FILES['upload_6']['tmp_name'], $filePath)) {
                     $upload_6 = $filePath;  // Update image path
                 } else {
                     echo "<script>alert('Image upload failed');</script>";
                 }
             }
  
  
                // Image upload handling for the third row
          $upload_7 = isset($row['upload_7']) ? $row['upload_7'] : ''; // Default to existing image or empty string
          if (isset($_FILES['upload_7']) && $_FILES['upload_7']['error'] == 0) {
              $uploadDir = 'assets/uploads/';
              $fileName = time() . '_' . basename($_FILES['upload_7']['name']);
              $filePath = $uploadDir . $fileName;
  
              // Move uploaded file
              if (move_uploaded_file($_FILES['upload_7']['tmp_name'], $filePath)) {
                  $upload_7 = $filePath;  // Update image path
              } else {
                  echo "<script>alert('Image upload failed');</script>";
              }
          }

               // Image upload handling for the third row
               $upload_8 = isset($row['upload_8']) ? $row['upload_8'] : ''; // Default to existing image or empty string
               if (isset($_FILES['upload_8']) && $_FILES['upload_8']['error'] == 0) {
                   $uploadDir = 'assets/uploads/';
                   $fileName = time() . '_' . basename($_FILES['upload_8']['name']);
                   $filePath = $uploadDir . $fileName;
       
                   // Move uploaded file
                   if (move_uploaded_file($_FILES['upload_8']['tmp_name'], $filePath)) {
                       $upload_8 = $filePath;  // Update image path
                   } else {
                       echo "<script>alert('Image upload failed');</script>";
                   }
               }
    
    
                  // Image upload handling for the third row
            $upload_9 = isset($row['upload_9']) ? $row['upload_9'] : ''; // Default to existing image or empty string
            if (isset($_FILES['upload_9']) && $_FILES['upload_9']['error'] == 0) {
                $uploadDir = 'assets/uploads/';
                $fileName = time() . '_' . basename($_FILES['upload_9']['name']);
                $filePath = $uploadDir . $fileName;
    
                // Move uploaded file
                if (move_uploaded_file($_FILES['upload_9']['tmp_name'], $filePath)) {
                    $upload_9 = $filePath;  // Update image path
                } else {
                    echo "<script>alert('Image upload failed');</script>";
                }
            }

                 // Image upload handling for the third row
           $upload_10 = isset($row['upload_10']) ? $row['upload_10'] : ''; // Default to existing image or empty string
           if (isset($_FILES['upload_10']) && $_FILES['upload_10']['error'] == 0) {
               $uploadDir = 'assets/uploads/';
               $fileName = time() . '_' . basename($_FILES['upload_10']['name']);
               $filePath = $uploadDir . $fileName;
   
               // Move uploaded file
               if (move_uploaded_file($_FILES['upload_10']['tmp_name'], $filePath)) {
                   $upload_10 = $filePath;  // Update image path
               } else {
                   echo "<script>alert('Image upload failed');</script>";
               }
           }


              // Image upload handling for the third row
        $upload_11 = isset($row['upload_11']) ? $row['upload_11'] : ''; // Default to existing image or empty string
        if (isset($_FILES['upload_11']) && $_FILES['upload_11']['error'] == 0) {
            $uploadDir = 'assets/uploads/';
            $fileName = time() . '_' . basename($_FILES['upload_11']['name']);
            $filePath = $uploadDir . $fileName;

            // Move uploaded file
            if (move_uploaded_file($_FILES['upload_11']['tmp_name'], $filePath)) {
                $upload_11 = $filePath;  // Update image path
            } else {
                echo "<script>alert('Image upload failed');</script>";
            }
        }

             // Image upload handling for the third row
             $upload_12 = isset($row['upload_12']) ? $row['upload_12'] : ''; // Default to existing image or empty string
             if (isset($_FILES['upload_12']) && $_FILES['upload_12']['error'] == 0) {
                 $uploadDir = 'assets/uploads/';
                 $fileName = time() . '_' . basename($_FILES['upload_12']['name']);
                 $filePath = $uploadDir . $fileName;
     
                 // Move uploaded file
                 if (move_uploaded_file($_FILES['upload_12']['tmp_name'], $filePath)) {
                     $upload_12 = $filePath;  // Update image path
                 } else {
                     echo "<script>alert('Image upload failed');</script>";
                 }
             }
  
  
                // Image upload handling for the third row
          $upload_13 = isset($row['upload_13']) ? $row['upload_13'] : ''; // Default to existing image or empty string
          if (isset($_FILES['upload_13']) && $_FILES['upload_13']['error'] == 0) {
              $uploadDir = 'assets/uploads/';
              $fileName = time() . '_' . basename($_FILES['upload_13']['name']);
              $filePath = $uploadDir . $fileName;
  
              // Move uploaded file
              if (move_uploaded_file($_FILES['upload_13']['tmp_name'], $filePath)) {
                  $upload_13 = $filePath;  // Update image path
              } else {
                  echo "<script>alert('Image upload failed');</script>";
              }
          }

               // Image upload handling for the third row
               $upload_14 = isset($row['upload_14']) ? $row['upload_14'] : ''; // Default to existing image or empty string
               if (isset($_FILES['upload_14']) && $_FILES['upload_14']['error'] == 0) {
                   $uploadDir = 'assets/uploads/';
                   $fileName = time() . '_' . basename($_FILES['upload_14']['name']);
                   $filePath = $uploadDir . $fileName;
       
                   // Move uploaded file
                   if (move_uploaded_file($_FILES['upload_14']['tmp_name'], $filePath)) {
                       $upload_14 = $filePath;  // Update image path
                   } else {
                       echo "<script>alert('Image upload failed');</script>";
                   }
               }
    
    
                  // Image upload handling for the third row
            $upload_15 = isset($row['upload_15']) ? $row['upload_15'] : ''; // Default to existing image or empty string
            if (isset($_FILES['upload_15']) && $_FILES['upload_15']['error'] == 0) {
                $uploadDir = 'assets/uploads/';
                $fileName = time() . '_' . basename($_FILES['upload_15']['name']);
                $filePath = $uploadDir . $fileName;
    
                // Move uploaded file
                if (move_uploaded_file($_FILES['upload_15']['tmp_name'], $filePath)) {
                    $upload_15 = $filePath;  // Update image path
                } else {
                    echo "<script>alert('Image upload failed');</script>";
                }
            }

                 // Image upload handling for the third row
           $upload_16 = isset($row['upload_16']) ? $row['upload_16'] : ''; // Default to existing image or empty string
           if (isset($_FILES['upload_16']) && $_FILES['upload_16']['error'] == 0) {
               $uploadDir = 'assets/uploads/';
               $fileName = time() . '_' . basename($_FILES['upload_16']['name']);
               $filePath = $uploadDir . $fileName;
   
               // Move uploaded file
               if (move_uploaded_file($_FILES['upload_16']['tmp_name'], $filePath)) {
                   $upload_16 = $filePath;  // Update image path
               } else {
                   echo "<script>alert('Image upload failed');</script>";
               }
           }


              // Image upload handling for the third row
        $upload_17 = isset($row['upload_17']) ? $row['upload_17'] : ''; // Default to existing image or empty string
        if (isset($_FILES['upload_17']) && $_FILES['upload_17']['error'] == 0) {
            $uploadDir = 'assets/uploads/';
            $fileName = time() . '_' . basename($_FILES['upload_17']['name']);
            $filePath = $uploadDir . $fileName;

            // Move uploaded file
            if (move_uploaded_file($_FILES['upload_17']['tmp_name'], $filePath)) {
                $upload_17 = $filePath;  // Update image path
            } else {
                echo "<script>alert('Image upload failed');</script>";
            }
        }

             // Image upload handling for the third row
             $upload_18 = isset($row['upload_18']) ? $row['upload_18'] : ''; // Default to existing image or empty string
             if (isset($_FILES['upload_18']) && $_FILES['upload_18']['error'] == 0) {
                 $uploadDir = 'assets/uploads/';
                 $fileName = time() . '_' . basename($_FILES['upload_18']['name']);
                 $filePath = $uploadDir . $fileName;
     
                 // Move uploaded file
                 if (move_uploaded_file($_FILES['upload_18']['tmp_name'], $filePath)) {
                     $upload_18 = $filePath;  // Update image path
                 } else {
                     echo "<script>alert('Image upload failed');</script>";
                 }
             }
  
  
                // Image upload handling for the third row
          $upload_19 = isset($row['upload_19']) ? $row['upload_19'] : ''; // Default to existing image or empty string
          if (isset($_FILES['upload_19']) && $_FILES['upload_19']['error'] == 0) {
              $uploadDir = 'assets/uploads/';
              $fileName = time() . '_' . basename($_FILES['upload_19']['name']);
              $filePath = $uploadDir . $fileName;
  
              // Move uploaded file
              if (move_uploaded_file($_FILES['upload_19']['tmp_name'], $filePath)) {
                  $upload_19 = $filePath;  // Update image path
              } else {
                  echo "<script>alert('Image upload failed');</script>";
              }
          }

               // Image upload handling for the third row
               $upload_20 = isset($row['upload_20']) ? $row['upload_20'] : ''; // Default to existing image or empty string
               if (isset($_FILES['upload_20']) && $_FILES['upload_20']['error'] == 0) {
                   $uploadDir = 'assets/uploads/';
                   $fileName = time() . '_' . basename($_FILES['upload_20']['name']);
                   $filePath = $uploadDir . $fileName;
       
                   // Move uploaded file
                   if (move_uploaded_file($_FILES['upload_20']['tmp_name'], $filePath)) {
                       $upload_20 = $filePath;  // Update image path
                   } else {
                       echo "<script>alert('Image upload failed');</script>";
                   }
               }
    
    
                  // Image upload handling for the third row
            $upload_21 = isset($row['upload_21']) ? $row['upload_21'] : ''; // Default to existing image or empty string
            if (isset($_FILES['upload_21']) && $_FILES['upload_21']['error'] == 0) {
                $uploadDir = 'assets/uploads/';
                $fileName = time() . '_' . basename($_FILES['upload_21']['name']);
                $filePath = $uploadDir . $fileName;
    
                // Move uploaded file
                if (move_uploaded_file($_FILES['upload_21']['tmp_name'], $filePath)) {
                    $upload_21 = $filePath;  // Update image path
                } else {
                    echo "<script>alert('Image upload failed');</script>";
                }
            }

                 // Image upload handling for the third row
           $upload_22 = isset($row['upload_22']) ? $row['upload_22'] : ''; // Default to existing image or empty string
           if (isset($_FILES['upload_3']) && $_FILES['upload_22']['error'] == 0) {
               $uploadDir = 'assets/uploads/';
               $fileName = time() . '_' . basename($_FILES['upload_22']['name']);
               $filePath = $uploadDir . $fileName;
   
               // Move uploaded file
               if (move_uploaded_file($_FILES['upload_22']['tmp_name'], $filePath)) {
                   $upload_22 = $filePath;  // Update image path
               } else {
                   echo "<script>alert('Image upload failed');</script>";
               }
           }


              // Image upload handling for the third row
        $upload_23 = isset($row['upload_23']) ? $row['upload_23'] : ''; // Default to existing image or empty string
        if (isset($_FILES['upload_23']) && $_FILES['upload_23']['error'] == 0) {
            $uploadDir = 'assets/uploads/';
            $fileName = time() . '_' . basename($_FILES['upload_23']['name']);
            $filePath = $uploadDir . $fileName;

            // Move uploaded file
            if (move_uploaded_file($_FILES['upload_23']['tmp_name'], $filePath)) {
                $upload_23 = $filePath;  // Update image path
            } else {
                echo "<script>alert('Image upload failed');</script>";
            }
        }

             // Image upload handling for the third row
             $upload_24 = isset($row['upload_24']) ? $row['upload_24'] : ''; // Default to existing image or empty string
             if (isset($_FILES['upload_24']) && $_FILES['upload_24']['error'] == 0) {
                 $uploadDir = 'assets/uploads/';
                 $fileName = time() . '_' . basename($_FILES['upload_24']['name']);
                 $filePath = $uploadDir . $fileName;
     
                 // Move uploaded file
                 if (move_uploaded_file($_FILES['upload_24']['tmp_name'], $filePath)) {
                     $upload_24 = $filePath;  // Update image path
                 } else {
                     echo "<script>alert('Image upload failed');</script>";
                 }
             }
  
  
                // Image upload handling for the third row
          $upload_25 = isset($row['upload_25']) ? $row['upload_25'] : ''; // Default to existing image or empty string
          if (isset($_FILES['upload_25']) && $_FILES['upload_25']['error'] == 0) {
              $uploadDir = 'assets/uploads/';
              $fileName = time() . '_' . basename($_FILES['upload_25']['name']);
              $filePath = $uploadDir . $fileName;
  
              // Move uploaded file
              if (move_uploaded_file($_FILES['upload_25']['tmp_name'], $filePath)) {
                  $upload_25 = $filePath;  // Update image path
              } else {
                  echo "<script>alert('Image upload failed');</script>";
              }
          }

               // Image upload handling for the third row
               $upload_26 = isset($row['upload_26']) ? $row['upload_26'] : ''; // Default to existing image or empty string
               if (isset($_FILES['upload_26']) && $_FILES['upload_26']['error'] == 0) {
                   $uploadDir = 'assets/uploads/';
                   $fileName = time() . '_' . basename($_FILES['upload_26']['name']);
                   $filePath = $uploadDir . $fileName;
       
                   // Move uploaded file
                   if (move_uploaded_file($_FILES['upload_26']['tmp_name'], $filePath)) {
                       $upload_26 = $filePath;  // Update image path
                   } else {
                       echo "<script>alert('Image upload failed');</script>";
                   }
               }
    
    
      








        // Log updates for the first row if statement_1 changes
        if ($f_statement_1 != $row['statement_1']) {
            $log_query_1 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name1', '$f_statement_1', NOW())";
            mysqli_query($conn, $log_query_1);
        }


        // Log updates for the second row if statement_2 changes
        if ($f_statement_2 != $row['statement_2']) {
            $log_query_2 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name2', '$f_statement_2', NOW())";
            mysqli_query($conn, $log_query_2);
        }


        // Log updates for the second row if statement_2 changes
        if ($f_statement_3 != $row['statement_3']) {
            $log_query_3 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name3', '$f_statement_3', NOW())";
            mysqli_query($conn, $log_query_3);
        }


        
        // Log updates for the 4 row if statement_2 changes
        if ($f_statement_4 != $row['statement_4']) {
            $log_query_4 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name4', '$f_statement_4', NOW())";
            mysqli_query($conn, $log_query_4);
        }


           // Log updates for the 5 row if statement_2 changes
           if ($f_statement_5 != $row['statement_5']) {
            $log_query_5 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name5', '$f_statement_5', NOW())";
            mysqli_query($conn, $log_query_5);
        }


           // Log updates for the 4 row if statement_2 changes
           if ($f_statement_6 != $row['statement_6']) {
            $log_query_6 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name6', '$f_statement_6', NOW())";
            mysqli_query($conn, $log_query_6);
        }


           // Log updates for the 4 row if statement_2 changes
           if ($f_statement_7 != $row['statement_7']) {
            $log_query_7 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name7', '$f_statement_7', NOW())";
            mysqli_query($conn, $log_query_7);
        }


           // Log updates for the 4 row if statement_2 changes
           if ($f_statement_8 != $row['statement_8']) {
            $log_query_8 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name8', '$f_statement_8', NOW())";
            mysqli_query($conn, $log_query_8);
        }


           // Log updates for the 4 row if statement_2 changes
           if ($f_statement_9 != $row['statement_9']) {
            $log_query_9 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name9', '$f_statement_9', NOW())";
            mysqli_query($conn, $log_query_9);
        }

           // Log updates for the 4 row if statement_2 changes
           if ($f_statement_10 != $row['statement_10']) {
            $log_query_10 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name10', '$f_statement_10', NOW())";
            mysqli_query($conn, $log_query_10);
        }

           // Log updates for the 4 row if statement_2 changes
           if ($f_statement_11 != $row['statement_11']) {
            $log_query_11 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name11', '$f_statement_11', NOW())";
            mysqli_query($conn, $log_query_11);
        }

           // Log updates for the 4 row if statement_2 changes
           if ($f_statement_12 != $row['statement_12']) {
            $log_query_12 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name12', '$f_statement_12', NOW())";
            mysqli_query($conn, $log_query_12);
        }

           // Log updates for the 4 row if statement_2 changes
           if ($f_statement_13 != $row['statement_13']) {
            $log_query_13 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name13', '$f_statement_13', NOW())";
            mysqli_query($conn, $log_query_13);
        }


           // Log updates for the 4 row if statement_2 changes
           if ($f_statement_14 != $row['statement_14']) {
            $log_query_14 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name14', '$f_statement_14', NOW())";
            mysqli_query($conn, $log_query_14);
        }


           // Log updates for the 4 row if statement_2 changes
           if ($f_statement_15 != $row['statement_15']) {
            $log_query_15 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name15', '$f_statement_15', NOW())";
            mysqli_query($conn, $log_query_15);
        }


           // Log updates for the 4 row if statement_2 changes
           if ($f_statement_16 != $row['statement_16']) {
            $log_query_16 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name16', '$f_statement_16', NOW())";
            mysqli_query($conn, $log_query_16);
        }

           // Log updates for the 4 row if statement_2 changes
           if ($f_statement_17 != $row['statement_16']) {
            $log_query_17 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name17', '$f_statement_17', NOW())";
            mysqli_query($conn, $log_query_17);
        }


           // Log updates for the 4 row if statement_2 changes
           if ($f_statement_18 != $row['statement_18']) {
            $log_query_18 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name18', '$f_statement_18', NOW())";
            mysqli_query($conn, $log_query_18);
        }

           // Log updates for the 4 row if statement_2 changes
           if ($f_statement_19 != $row['statement_19']) {
            $log_query_19 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name19', '$f_statement_19', NOW())";
            mysqli_query($conn, $log_query_19);
        }

           // Log updates for the 4 row if statement_2 changes
           if ($f_statement_20 != $row['statement_20']) {
            $log_query_20 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name20', '$f_statement_20', NOW())";
            mysqli_query($conn, $log_query_20);
        }

           // Log updates for the 4 row if statement_2 changes
           if ($f_statement_21 != $row['statement_21']) {
            $log_query_21 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name21', '$f_statement_21', NOW())";
            mysqli_query($conn, $log_query_21);
        }

           // Log updates for the 4 row if statement_2 changes
           if ($f_statement_21 != $row['statement_21']) {
            $log_query_21 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name21', '$f_statement_21', NOW())";
            mysqli_query($conn, $log_query_21);
        }

           // Log updates for the 4 row if statement_2 changes
           if ($f_statement_22 != $row['statement_22']) {
            $log_query_22 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name22', '$f_statement_22', NOW())";
            mysqli_query($conn, $log_query_22);
        }

           // Log updates for the 4 row if statement_2 changes
           if ($f_statement_23 != $row['statement_23']) {
            $log_query_23 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name23', '$f_statement_23', NOW())";
            mysqli_query($conn, $log_query_23);
        }

           // Log updates for the 4 row if statement_2 changes
           if ($f_statement_24 != $row['statement_24']) {
            $log_query_24 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name24', '$f_statement_24', NOW())";
            mysqli_query($conn, $log_query_24);
        }

         // Log updates for the 4 row if statement_2 changes
         if ($f_statement_25 != $row['statement_25']) {
            $log_query_25 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name25', '$f_statement_25', NOW())";
            mysqli_query($conn, $log_query_25);
        }

         // Log updates for the 4 row if statement_2 changes
         if ($f_statement_26 != $row['statement_26']) {
            $log_query_26 = "INSERT INTO lab_req_2 (fk_id, username, product_name, statement, date) 
                            VALUES ('$id','$name', '$f_pro_name26', '$f_statement_26', NOW())";
            mysqli_query($conn, $log_query_26);
        }



        // Update query for both rows
        $update_query = "UPDATE lab_req SET 
                         statement_1 = '$f_statement_1',
                         language_1 = '$f_language_1',
                         upload_1 = '$upload_1',

                         statement_2 = '$f_statement_2',
                         language_2 = '$f_language_2',
                         upload_2 = '$upload_2',

                         statement_3 = '$f_statement_3',
                         language_3 = '$f_language_3',
                         upload_3 = '$upload_3',

                        statement_4 = '$f_statement_4',
                        language_4 = '$f_language_4',
                        upload_4 = '$upload_4',


                          statement_5 = '$f_statement_5',
                         language_5 = '$f_language_5',
                         upload_5 = '$upload_5',


                          statement_6 = '$f_statement_6',
                         language_6 = '$f_language_6',
                         upload_6 = '$upload_6',

                          statement_7 = '$f_statement_7',
                         language_7 = '$f_language_7',
                         upload_7 = '$upload_7',

                          statement_8 = '$f_statement_8',
                         language_8 = '$f_language_8',
                         upload_8 = '$upload_8',

                          statement_9 = '$f_statement_9',
                         language_9 = '$f_language_9',
                         upload_9 = '$upload_9',

                          statement_10 = '$f_statement_10',
                         language_10 = '$f_language_10',
                         upload_10 = '$upload_10',

                          statement_11 = '$f_statement_11',
                         language_11 = '$f_language_11',
                         upload_11 = '$upload_11',

                          statement_12 = '$f_statement_12',
                         language_12 = '$f_language_12',
                         upload_12 = '$upload_12',

                          statement_13 = '$f_statement_13',
                         language_13 = '$f_language_13',
                         upload_13 = '$upload_13',

                          statement_14 = '$f_statement_15',
                         language_14 = '$f_language_15',
                         upload_14 = '$upload_15',

                          statement_16 = '$f_statement_16',
                         language_16 = '$f_language_16',
                         upload_16 = '$upload_16',

                          statement_17 = '$f_statement_17',
                         language_17 = '$f_language_17',
                         upload_17 = '$upload_17',

                          statement_18 = '$f_statement_18',
                         language_18 = '$f_language_18',
                         upload_18 = '$upload_18',

                          statement_19 = '$f_statement_19',
                         language_19 = '$f_language_19',
                         upload_19 = '$upload_19',

                          statement_20 = '$f_statement_20',
                         language_20 = '$f_language_20',
                         upload_20 = '$upload_20',

                          statement_21 = '$f_statement_21',
                         language_21 = '$f_language_21',
                         upload_21 = '$upload_21',

                          statement_22 = '$f_statement_22',
                         language_22 = '$f_language_22',
                         upload_22 = '$upload_22',

                          statement_23 = '$f_statement_23',
                         language_23 = '$f_language_23',
                         upload_23 = '$upload_23',

                          statement_24 = '$f_statement_24',
                         language_24 = '$f_language_24',
                         upload_24 = '$upload_24',

                          statement_25 = '$f_statement_25',
                         language_25 = '$f_language_25',
                         upload_25 = '$upload_25',

                          statement_26 = '$f_statement_26',
                         language_26 = '$f_language_26',
                         upload_26 = '$upload_26'

                    

                         WHERE id = '$id'";

        // Execute the update query
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            echo "<script>
                    alert('Record updated successfully');
                   
                  </script>";
        } else {
            echo "<script>alert('Error updating record: " . mysqli_error($conn) . "');</script>";
        }
    }
?>

<div class="container-fluid">

    <div class="row justify-content-center">

       

            <div class="col">

            <form class="form pb-3" method="POST" enctype="multipart/form-data">
                
                <h6 class="" style="font-size:22px;font-weight:600">Medics Chest Rub <span style="float:right!important"><a href="lab_req_form_list.php" class="btn btn-dark"><i class="fa-solid fa-list-ul"></i> Product List</a> <a href="lab_req_chest_rub_history?id=1" class="btn btn-danger"><i class="fa-solid fa-clock-rotate-left"></i> History </a></span></h6>

                <table class="table table-striped">
                <thead style="background-color:#0D9276;color:white">
                        <tr style="border:1px solid white!important">
                            <th style="width:20px!important">Sno</th>
                            <th>Parameters</th>
                            <th>Statement</th>
                            <th>Languages</th>
                            <th>Upload (Urdu Statement) </th>
                            <th>Conern Department</th>
                        </tr>
                    </thead>
                    <tbody>



                        <!-- 1 Row -->
                        <tr>
                            <td class="pl-2">1</td>
                            <td><textarea name="pro_name1" cols="40" rows="2" readonly style="resize:none;font-weight:500">Product name / Brand Name</textarea></td>
                            <!-- <td><input type="text" name="pro_name1" value="Product name / Brand Name" style="height:500px!important"></td> -->


                            <td><textarea name="statement_1" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_1']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_1" value="<?php echo htmlspecialchars($row['statement_1']); ?>"></td> -->


                            <td><input type="text" name="language_1" value="<?php echo htmlspecialchars($row['language_1']); ?>"></td>
                            <td>
                                <?php if (!empty($row['upload_1'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_1" id="fileInput" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;"  onclick="document.getElementById('fileInput').click();"><i class="fa-solid fa-upload"></i> Upload</button>
                            </td>
                            <td class="pl-2">Regulatory Affairs</td>
                        </tr>




                        <!-- 2 Row -->
                        <tr>
                            <td class="pl-2">2</td>
                            <td><textarea name="pro_name2" cols="40" rows="2" readonly style="resize:none;font-weight:500">Dosage Form</textarea></td>
                            <!-- <td><input type="text" name="pro_name2" value="Dosage Form"></td> -->

                            <td><textarea name="statement_2" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_2']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_2" value="<?php echo htmlspecialchars($row['statement_2']); ?>"></td> -->

                            <td><input type="text" name="language_2" value="<?php echo htmlspecialchars($row['language_2']); ?>"></td>
                            <td>
                                <?php if (!empty($row['upload_2'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal2"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_2" id="fileInput2" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;"  onclick="document.getElementById('fileInput2').click();"><i class="fa-solid fa-upload"></i> Upload</button>
                            </td>
                            <td class="pl-2">Regulatory Affairs</td>
                        </tr>




                         <!-- 3 Row -->
                         <tr>
                            <td class="pl-2">3</td>

                            <td><textarea name="pro_name3" cols="40" rows="2" readonly style="resize:none;font-weight:500">Name of Active Substance</textarea></td>
                            <!-- <td><input type="text" name="pro_name3" value="Name of Active Substance"></td> -->

                            <td><textarea name="statement_3" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_3']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_3" value="<?php echo htmlspecialchars($row['statement_3']); ?>"></td> -->


                            <td><input type="text" name="language_3" value="<?php echo htmlspecialchars($row['language_3']); ?>"></td>
                            <td>
                                <!-- <?php if (!empty($row['upload_3'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal3"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_3" id="fileInput3" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput3').click();"><i class="fa-solid fa-upload"></i> Upload</button> -->
                            </td>
                            <td class="pl-2">Regulatory Affairs</td>
                        </tr>

                         <!-- 4 Row -->
                         <tr>
                            <td class="pl-2">4</td>

                            <td><textarea name="pro_name4" cols="40" rows="2" readonly style="resize:none;font-weight:500">Strength of Active Substance</textarea></td>
                            <!-- <td><input type="text" name="pro_name4" value="Strength of Active Substance"></td> -->

                            <td><textarea  name="statement_4" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_4']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_4" value="<?php echo htmlspecialchars($row['statement_4']); ?>"></td> -->

                            <td><input type="text" name="language_4" value="<?php echo htmlspecialchars($row['language_4']); ?>"></td>
                            <td>
                                <!-- <?php if (!empty($row['upload_4'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal4"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_4" id="fileInput4" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput4').click();"><i class="fa-solid fa-upload"></i> Upload</button> -->
                            </td>
                            <td class="pl-2">Regulatory Affairs</td>
                        </tr>

                        <!-- 5 Row -->
                        <tr>
                            <td class="pl-2">5</td>

                            <td><textarea name="pro_name5" cols="40" rows="2" readonly style="resize:none;font-weight:500">Product Specfiction/pharmacopoeial references</textarea></td>
                            <!-- <td><input type="text" name="pro_name5" value="Product Specfiction/pharmacopoeial references"></td> -->

                            <td><textarea name="statement_5" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_5']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_5" value="<?php echo htmlspecialchars($row['statement_5']); ?>"></td> -->

                            <td><input type="text" name="language_5" value="<?php echo htmlspecialchars($row['language_5']); ?>"></td>
                            <td>
                                <!-- <?php if (!empty($row['upload_5'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal5"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_5" id="fileInput5" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput5').click();"><i class="fa-solid fa-upload"></i> Upload</button>
                            </td> -->
                            <td class="pl-2">Regulatory Affairs</td>
                        </tr>

                         <!-- 6 Row -->
                         <tr>
                            <td class="pl-2">6</td>

                            <td><textarea name="pro_name6" cols="40" rows="2" readonly style="resize:none;font-weight:500">Pack Sizes (unit/volume)e</textarea></td>
                            <!-- <td><input type="text" name="pro_name6" value="Pack Sizes (unit/volume)e"></td> -->

                            <td><textarea name="statement_6" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_6']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_6" value="<?php echo htmlspecialchars($row['statement_6']); ?>"></td> -->


                            <td><input type="text" name="language_6" value="<?php echo htmlspecialchars($row['language_6']); ?>"></td>
                            <td>
                                <?php if (!empty($row['upload_6'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal6"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_6" id="fileInput6" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput6').click();"><i class="fa-solid fa-upload"></i> Upload</button>
                            </td>
                            <td class="pl-2">Regulatory Affairs</td>
                        </tr>


                         <!-- First Row -->
                         <tr>
                            <td class="pl-2">7</td>

                            <td><textarea name="pro_name7" cols="40" rows="2" readonly style="resize:none;font-weight:500">Indication</textarea></td>
                            <!-- <td><input type="text" name="pro_name7" value="Indication"></td> -->

                            <td><textarea name="statement_7" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_7']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_7" value="<?php echo htmlspecialchars($row['statement_7']); ?>"></td> -->

                            <td><input type="text" name="language_7" value="<?php echo htmlspecialchars($row['language_7']); ?>"></td>
                            <td>
                                <?php if (!empty($row['upload_7'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal7"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_7" id="fileInput7" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput7').click();"><i class="fa-solid fa-upload"></i> Upload</button>
                            </td>
                            <td class="pl-2">Regulatory Affairs</td>
                        </tr>

                        <!-- 8 Row -->
                        <tr>
                            <td class="pl-2">8</td>

                            <td><textarea name="pro_name8" cols="40" rows="2" readonly style="resize:none;font-weight:500">Manufacturer Enlistment Number</textarea></td>
                            <!-- <td><input type="text" name="pro_name8" value="Manufacturer Enlistment Number"></td> -->

                            <td><textarea name="statement_8" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_8']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_8" value="<?php echo htmlspecialchars($row['statement_8']); ?>"></td> -->

                            <td><input type="text" name="language_8" value="<?php echo htmlspecialchars($row['language_8']); ?>"></td>
                            <td>
                                <!-- <?php if (!empty($row['upload_8'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal8"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_8" id="fileInput8" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput8').click();"><i class="fa-solid fa-upload"></i> Upload</button> -->
                            </td>
                            <td class="pl-2">Regulatory Affairs</td>
                        </tr>

                         <!-- 9 Row -->
                         <tr>
                            <td class="pl-2">9</td>

                            <td><textarea name="pro_name9" cols="40" rows="2" readonly style="resize:none;font-weight:500">Product Enlistment Number</textarea></td>
                            <!-- <td><input type="text" name="pro_name9" value="Product Enlistment Number"></td> -->

                            <td><textarea name="statement_9" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_9']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_9" value="<?php echo htmlspecialchars($row['statement_9']); ?>"></td> -->


                            <td><input type="text" name="language_9" value="<?php echo htmlspecialchars($row['language_9']); ?>"></td>
                            <td>
                                <!-- <?php if (!empty($row['upload_9'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal9"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_9" id="fileInput9" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;"  onclick="document.getElementById('fileInput9').click();"><i class="fa-solid fa-upload"></i> Upload</button> -->
                            </td>
                            <td class="pl-2">Regulatory Affairs</td>
                        </tr>




                         <!-- 10 Row -->
                         <tr>
                            <td class="pl-2">10</td>

                            <td><textarea name="pro_name10" cols="40" rows="2" readonly style="resize:none;font-weight:500">Name & Address of Product Enlistment Holder (Manufacturer)"</textarea></td>
                            <!-- <td><input type="text" name="pro_name10" value="Name & Address of Product Enlistment Holder (Manufacturer)"></td> -->

                            <td><textarea name="statement_10" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_10']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_10" value="<?php echo htmlspecialchars($row['statement_10']); ?>"></td> -->

                            <td><input type="text" name="language_10" value="<?php echo htmlspecialchars($row['language_10']); ?>"></td>
                            <td>
                                <!-- <?php if (!empty($row['upload_10'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal10"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_10" id="fileInput10" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput10').click();"><i class="fa-solid fa-upload"></i> Upload</button> -->
                            </td>
                            <td class="pl-2">Regulatory Affairs</td>
                        </tr>



                        <!-- 11 Row -->
                        <tr>
                            <td class="pl-2">11</td>

                            <td><textarea name="pro_name11" cols="40" rows="2" readonly style="resize:none;font-weight:500">Product Description</textarea></td>
                            <!-- <td><input type="text" name="pro_name11" value="Product Description"></td> -->

                            <td><textarea  name="statement_11" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_11']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_11" value="<?php echo htmlspecialchars($row['statement_11']); ?>"></td> -->

                            <td><input type="text" name="language_11" value="<?php echo htmlspecialchars($row['language_11']); ?>"></td>
                            <td>
                                <!-- <?php if (!empty($row['upload_11'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal11"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_11" id="fileInput11" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput11').click();"><i class="fa-solid fa-upload"></i> Upload</button> -->
                            </td>
                            <td class="pl-2">BD/R&D/Marketing</td>
                        </tr>




                         <!-- 12 Row -->
                         <tr>
                            <td class="pl-2">12</td>

                            <td><textarea name="pro_name12" cols="40" rows="2" readonly style="resize:none;font-weight:500">Dose (Should be in a dose chart)</textarea></td>
                            <!-- <td><input type="text" name="pro_name12" value="Dose (Should be in a dose chart)"></td> -->

                            <td><textarea name="statement_12" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_12']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_12" value="<?php echo htmlspecialchars($row['statement_12']); ?>"></td> -->

                            <td><input type="text" name="language_12" value="<?php echo htmlspecialchars($row['language_12']); ?>"></td>
                            <td>
                                <?php if (!empty($row['upload_12'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal12"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_12" id="fileInput12" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput12').click();"><i class="fa-solid fa-upload"></i> Upload</button>
                            </td>
                            <td class="pl-2">BD/R&D</td>
                        </tr>


                         <!-- 13 Row -->
                         <tr>
                            <td class="pl-2">13</td>

                            <td><textarea name="pro_name13" cols="40" rows="2" readonly style="resize:none;font-weight:500">Instructions (Follow the same sequence for Urdu instructions as well)</textarea></td>
                            <!-- <td><input type="text" name="pro_name13" value="Instructions (Follow the same sequence for Urdu instructions as well)"></td> -->

                            <td><textarea name="statement_13" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_13']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_13" value="<?php echo htmlspecialchars($row['statement_13']); ?>"></td> -->

                            <td><input type="text" name="language_13" value="<?php echo htmlspecialchars($row['language_13']); ?>"></td>
                            <td>
                                <?php if (!empty($row['upload_13'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal13"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_13" id="fileInput13" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput13').click();"><i class="fa-solid fa-upload"></i> Upload</button>
                            </td>
                            <td class="pl-2">BD/R&D</td>
                        </tr>

                        <!-- 14 Row -->
                        <tr>
                            <td class="pl-2">14</td>

                            <td><textarea name="pro_name14" cols="40" rows="2" readonly style="resize:none;font-weight:500">Warnings</textarea></td>
                            <!-- <td><input type="text" name="pro_name14" value="Warnings"></td> -->

                            <td><textarea name="statement_14" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_14']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_14" value="<?php echo htmlspecialchars($row['statement_14']); ?>"></td> -->

                            <td><input type="text" name="language_14" value="<?php echo htmlspecialchars($row['language_14']); ?>"></td>
                            <td>
                                <!-- <?php if (!empty($row['upload_14'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal14"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_14" id="fileInput2" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput14').click();"><i class="fa-solid fa-upload"></i> Upload</button> -->
                            </td>
                            <td class="pl-2">BD/R&D/ RA</td>
                        </tr>

                         <!-- 15 Row -->
                         <tr>
                            <td class="pl-2">15</td>

                            <td><textarea name="pro_name15" cols="40" rows="2" readonly style="resize:none;font-weight:500">Dimensions (UC/ Label/ Tube)</textarea></td>
                            <!-- <td><input type="text" name="pro_name15" value="Dimensions (UC/ Label/ Tube)"></td> -->

                            <td><textarea name="statement_15" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_15']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_15" value="<?php echo htmlspecialchars($row['statement_15']); ?>"></td> -->

                            <td><input type="text" name="language_15" value="<?php echo htmlspecialchars($row['language_15']); ?>"></td>
                            <td>
                                <!-- <?php if (!empty($row['upload_3'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal3"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_3" id="fileInput3" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput3').click();"><i class="fa-solid fa-upload"></i> Upload</button> -->
                            </td>
                            <td class="pl-2">Quality</td>
                        </tr>

                         <!-- 16 Row -->
                         <tr>
                            <td class="pl-2">16</td>

                            <td><textarea name="pro_name16" cols="40" rows="2" readonly style="resize:none;font-weight:500">Other Instructions (i.e) Trade mark</textarea></td>
                            <!-- <td><input type="text" name="pro_name16" value="Other Instructions (i.e) Trade mark"></td> -->

                            <td><textarea name="statement_16" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_16']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_16" value="<?php echo htmlspecialchars($row['statement_16']); ?>"></td> -->

                            <td><input type="text" name="language_16" value="<?php echo htmlspecialchars($row['language_16']); ?>"></td>
                            <td>
                                <!-- <?php if (!empty($row['upload_16'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal16"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_16" id="fileInput16" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput16').click();"><i class="fa-solid fa-upload"></i> Upload</button> -->
                            </td>
                            <td class="pl-2">BD/R&D</td>
                        </tr>

                        <!-- 17 Row -->
                        <tr>
                            <td class="pl-2">17</td>

                            <td><textarea name="pro_name17" cols="40" rows="2" readonly style="resize:none;font-weight:500">Other Instructions (i.e) Registartion Symbol ®</textarea></td>
                            <!-- <td><input type="text" name="pro_name17" value="Other Instructions (i.e) Registartion Symbol ®"></td> -->

                            <td><textarea name="statement_17" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_17']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_17" value="<?php echo htmlspecialchars($row['statement_17']); ?>"></td> -->

                            <td><input type="text" name="language_17" value="<?php echo htmlspecialchars($row['language_17']); ?>"></td>
                            <td>
                                <!-- <?php if (!empty($row['upload_17'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal17"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_17" id="fileInput2" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput17').click();"><i class="fa-solid fa-upload"></i> Upload</button> -->
                            </td>
                            <td class="pl-2">BD/R&D</td>
                        </tr>

                         <!-- 18 Row -->
                         <tr>
                            <td class="pl-2">18</td>

                            <td><textarea name="pro_name18" cols="40" rows="2" readonly style="resize:none;font-weight:500">Other Instructions (i.e) Barcode</textarea></td>
                            <!-- <td><input type="text" name="pro_name18" value="Other Instructions (i.e) Barcode"></td> -->

                            <td><textarea name="statement_18" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_18']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_18" value="<?php echo htmlspecialchars($row['statement_18']); ?>"></td> -->

                            <td><input type="text" name="language_18" value="<?php echo htmlspecialchars($row['language_18']); ?>"></td>
                            <td>
                                <!-- <?php if (!empty($row['upload_18'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal18"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_18" id="fileInput18" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput18').click();"><i class="fa-solid fa-upload"></i> Upload</button> -->
                            </td>
                            <td class="pl-2">Quality</td>
                        </tr>

                         <!-- 19 Row -->
                         <tr>
                            <td class="pl-2">19</td>

                            <td><textarea name="pro_name19" cols="40" rows="2" readonly style="resize:none;font-weight:500">Other Instructions (i.e) Art work Code</textarea></td>
                            <!-- <td><input type="text" name="pro_name19" value="Other Instructions (i.e) Art work Code"></td> -->

                            <td><textarea name="statement_19" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_19']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_19" value="<?php echo htmlspecialchars($row['statement_19']); ?>"></td> -->

                            <td><input type="text" name="language_19" value="<?php echo htmlspecialchars($row['language_19']); ?>"></td>
                            <td>
                                <!-- <?php if (!empty($row['upload_1'])) { ?>
                                    <button type="button" class="btn"  style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal19"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_19" id="fileInput19" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput19').click();"><i class="fa-solid fa-upload"></i> Upload</button> -->
                            </td>
                            <td class="pl-2">Quality</td>
                        </tr>

                        <!-- 20 Row -->
                        <tr>
                            <td class="pl-2">20</td>

                            <td><textarea name="pro_name20" cols="40" rows="2" readonly style="resize:none;font-weight:500">Batch Number</textarea></td>
                            <!-- <td><input type="text" name="pro_name20" value="Batch Number"></td> -->

                            <td><textarea  name="statement_20" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_20']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_20" value="<?php echo htmlspecialchars($row['statement_20']); ?>"></td> -->

                            <td><input type="text" name="language_20" value="<?php echo htmlspecialchars($row['language_20']); ?>"></td>
                            <td>
                                <!-- <?php if (!empty($row['upload_20'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal20"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_20" id="fileInput20" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput20').click();"><i class="fa-solid fa-upload"></i> Upload</button> -->
                            </td>
                            <td class="pl-2">Supply Chain</td>
                        </tr>

                         <!-- 21 Row -->
                         <tr>
                            <td class="pl-2">21</td>

                            <td><textarea name="pro_name21" cols="40" rows="2" readonly style="resize:none;font-weight:500">Manufacturing Date</textarea></td>
                            <!-- <td><input type="text" name="pro_name21" value="Manufacturing Date"></td> -->

                            <td><textarea name="statement_21" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_21']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_21" value="<?php echo htmlspecialchars($row['statement_21']); ?>"></td> -->

                            <td><input type="text" name="language_21" value="<?php echo htmlspecialchars($row['language_21']); ?>"></td>
                            <td>
                                <!-- <?php if (!empty($row['upload_21'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal21"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_21" id="fileInput21" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput21').click();"><i class="fa-solid fa-upload"></i> Upload</button> -->
                            </td>
                            <td class="pl-2">Supply Chain</td>
                        </tr>

                         <!-- 22 Row -->
                         <tr>
                            <td class="pl-2">22</td>

                            <td><textarea name="pro_name22" cols="40" rows="2" readonly style="resize:none;font-weight:500">Expiry Date</textarea></td>
                            <!-- <td><input type="text" name="pro_name22" value="Expiry Date"></td> -->

                            <td><textarea name="statement_22" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_22']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_22" value="<?php echo htmlspecialchars($row['statement_22']); ?>"></td> -->

                            <td><input type="text" name="language_22" value="<?php echo htmlspecialchars($row['language_22']); ?>"></td>
                            <td>
                                <!-- <?php if (!empty($row['upload_22'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal22"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_22" id="fileInput22" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput22').click();"><i class="fa-solid fa-upload"></i> Upload</button> -->
                            </td>
                            <td class="pl-2">Supply Chain</td>
                        </tr>

                        <!-- 23 Row -->
                        <tr>
                            <td class="pl-2">23</td>

                            <td><textarea name="pro_name23" cols="40" rows="2" readonly style="resize:none;font-weight:500">Maximum Retail Price (MRP) including GST</textarea></td>
                            <!-- <td><input type="text" name="pro_name23" value="Maximum Retail Price (MRP) including GST"></td> -->

                            <td><textarea name="statement_23" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_23']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_23" value="<?php echo htmlspecialchars($row['statement_23']); ?>"></td> -->

                            <td><input type="text" name="language_23" value="<?php echo htmlspecialchars($row['language_23']); ?>"></td>
                            <td>
                                <!-- <?php if (!empty($row['upload_23'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal23"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_23" id="fileInput23" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput23').click();"><i class="fa-solid fa-upload"></i> Upload</button> -->
                            </td>
                            <td class="pl-2">Supply Chain</td>
                        </tr>

                         <!-- 24 Row -->
                         <tr>
                            <td class="pl-2">24</td>

                            <td><textarea name="pro_name24" cols="40" rows="2" readonly style="resize:none;font-weight:500">Product Design</textarea></td>
                            <!-- <td><input type="text" name="pro_name24" value="Product Design"></td> -->

                            <td><textarea name="statement_24" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_24']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_24" value="<?php echo htmlspecialchars($row['statement_24']); ?>"></td> -->

                            <td><input type="text" name="language_24" value="<?php echo htmlspecialchars($row['language_24']); ?>"></td>
                            <td>
                                <!-- <?php if (!empty($row['upload_24'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal24"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_24" id="fileInput3" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput24').click();"><i class="fa-solid fa-upload"></i> Upload</button> -->
                            </td>
                            <td class="pl-2">Marketing</td>
                        </tr>



                         <!-- 25 Row -->
                         <tr>
                            <td class="pl-2">25</td>


                            <td><textarea name="pro_name25" cols="40" rows="2" readonly style="resize:none;font-weight:500">Product Positioning</textarea></td>
                            <!-- <td><input type="text" name="pro_name25" value="Product Positioning"></td> -->


                            <td><textarea name="statement_25" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_25']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_25" value="<?php echo htmlspecialchars($row['statement_25']); ?>"></td> -->


                            <td><input type="text" name="language_25" value="<?php echo htmlspecialchars($row['language_25']); ?>"></td>
                            <td>
                                <!-- <?php if (!empty($row['upload_25'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal25"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_25" id="fileInput25" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput25').click();"><i class="fa-solid fa-upload"></i> Upload</button> -->
                            </td>
                            <td class="pl-2">Marketing</td>
                        </tr>

                        <!-- 26 Row -->
                        <tr>
                            <td class="pl-2">26</td>

                            <td><textarea name="pro_name26" cols="40" rows="2" readonly style="resize:none;font-weight:500">Dosage Form</textarea></td>
                            <!-- <td><input type="text" name="pro_name26" value="Dosage Form"></td> -->

                            <td><textarea name="statement_26" cols="50" rows="2"><?php echo htmlspecialchars($row['statement_26']); ?></textarea></td>
                            <!-- <td><input type="text" name="statement_26" value="<?php echo htmlspecialchars($row['statement_26']); ?>"></td> -->

                            <td><input type="text" name="language_26" value="<?php echo htmlspecialchars($row['language_26']); ?>"></td>

                            <td>
                                <?php if (!empty($row['upload_26'])) { ?>
                                    <button type="button" class="btn" style="background-color:#FFDBB5;border:1px solid black" data-toggle="modal" data-target="#viewImageModal26"><i class="fa-regular fa-eye"></i> View</button>
                                <?php } ?>
                                <input type="file" name="upload_26" id="fileInput26" accept="image/*" style="display: none;">
                                <button type="button" class="btn" style="background-color:#B17457;color:white;" onclick="document.getElementById('fileInput26').click();"><i class="fa-solid fa-upload"></i> Upload</button>
                            </td>
                            <td class="pl-2">Regulatory Affairs</td>
                        </tr>




           

                        






                    </tbody>
                </table>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-submit" name="submit" style="font-size: 18px!important">Submit</button>
                </div>
            </div>
        </form>

        <!-- Modal for first image -->
        <?php if (!empty($row['upload_1'])) { ?>
        <div class="modal fade" id="viewImageModal" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_1']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

        <!-- Modal for second image -->
        <?php if (!empty($row['upload_2'])) { ?>
        <div class="modal fade" id="viewImageModal2" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel2" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_2']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>



        <!-- Modal for third image -->
        <?php if (!empty($row['upload_3'])) { ?>
        <div class="modal fade" id="viewImageModal3" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel3" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_3']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>



         <!-- Modal for 4 image -->
         <?php if (!empty($row['upload_4'])) { ?>
        <div class="modal fade" id="viewImageModal4" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel4" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_4']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>


         <!-- Modal for 5 image -->
         <?php if (!empty($row['upload_5'])) { ?>
        <div class="modal fade" id="viewImageModal5" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel5" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_5']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>


              <!-- Modal for 6 image -->
              <?php if (!empty($row['upload_6'])) { ?>
        <div class="modal fade" id="viewImageModal6" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel6" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_6']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>



                <!-- Modal for 7 image -->
                <?php if (!empty($row['upload_7'])) { ?>
        <div class="modal fade" id="viewImageModal7" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel7" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_7']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>



                   <!-- Modal for 8 image -->
                   <?php if (!empty($row['upload_8'])) { ?>
        <div class="modal fade" id="viewImageModal8" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel8" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_8']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>


                    <!-- Modal for 9 image -->
                    <?php if (!empty($row['upload_9'])) { ?>
        <div class="modal fade" id="viewImageModal9" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel9" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_9']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>



                     <!-- Modal for 10 image -->
                     <?php if (!empty($row['upload_10'])) { ?>
        <div class="modal fade" id="viewImageModal10" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel10" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_10']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>


         <!-- Modal for 10 image -->
         <?php if (!empty($row['upload_11'])) { ?>
        <div class="modal fade" id="viewImageModal11" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel11" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_11']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>




         <!-- Modal for 12 image -->
         <?php if (!empty($row['upload_12'])) { ?>
        <div class="modal fade" id="viewImageModal12" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel12" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_12']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>


            <!-- Modal for 13 image -->
            <?php if (!empty($row['upload_13'])) { ?>
        <div class="modal fade" id="viewImageModal13" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel13" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_13']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>


              <!-- Modal for 14 image -->
              <?php if (!empty($row['upload_14'])) { ?>
        <div class="modal fade" id="viewImageModal14" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel14" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_14']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>


         <!-- Modal for 15 image -->
         <?php if (!empty($row['upload_15'])) { ?>
        <div class="modal fade" id="viewImageModal15" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel15" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_15']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>


          <!-- Modal for 16 image -->
          <?php if (!empty($row['upload_16'])) { ?>
        <div class="modal fade" id="viewImageModal16" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel16" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_16']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>


              <!-- Modal for 17 image -->
              <?php if (!empty($row['upload_17'])) { ?>
        <div class="modal fade" id="viewImageModal17" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel17" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_17']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>


       <!-- Modal for 18 image -->
       <?php if (!empty($row['upload_18'])) { ?>
        <div class="modal fade" id="viewImageModal18" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel18" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_18']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

         <!-- Modal for 19 image -->
       <?php if (!empty($row['upload_19'])) { ?>
        <div class="modal fade" id="viewImageModal19" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel19" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_19']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

         <!-- Modal for 20 image -->
       <?php if (!empty($row['upload_20'])) { ?>
        <div class="modal fade" id="viewImageModal20" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel20" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_20']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>


         <!-- Modal for 21 image -->
       <?php if (!empty($row['upload_21'])) { ?>
        <div class="modal fade" id="viewImageModal21" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel21" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_21']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

          <!-- Modal for 22 image -->
       <?php if (!empty($row['upload_22'])) { ?>
        <div class="modal fade" id="viewImageModal22" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel22" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_22']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

             <!-- Modal for 23 image -->
       <?php if (!empty($row['upload_23'])) { ?>
        <div class="modal fade" id="viewImageModal23" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel23" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_23']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>


          <!-- Modal for 24 image -->
       <?php if (!empty($row['upload_24'])) { ?>
        <div class="modal fade" id="viewImageModal24" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel24" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_24']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>


          <!-- Modal for 25 image -->
       <?php if (!empty($row['upload_25'])) { ?>
        <div class="modal fade" id="viewImageModal25" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel25" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_25']; ?>" class="img-fluid" alt="Uploaded Image">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>


          <!-- Modal for 26 image -->
       <?php if (!empty($row['upload_26'])) { ?>
        <div class="modal fade" id="viewImageModal26" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel26" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?php echo $row['upload_26']; ?>" class="img-fluid" alt="Uploaded Image">
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