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
        <title>New Product Idea</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <!-- Bootstrap CSS CDN -->
        <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous"> -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Poppins Font -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="assets/css/style.css">
        <style>
    td .textp {
    text-align: right !important;
}
.textp {
    font-size: 12px !important;
}
            .th_secondary{
                font-size: 12px!important; 
                color:white!important; 
                background-color: #3D3D3D!important; 
                text-transform:capitalize!important; 
            }
            body {
            font-family: 'Poppins', sans-serif;
            }
            .btn{
            border-radius:0px;
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
            .btn-submit:hover {
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
            }
            .cbox{
            height: 13px!important;
            width: 13px!important;
            }
            td, .labelf{
            font-size: 12.5px!important;
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
            font-size: 13px; 
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
    <body>
        <div class="wrapper">
            <?php
                include 'sidebar1.php';
                ?>
            <!-- Page Content  -->
            <div id="content">
                <!-- navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-success" style="font-size:11px!important">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                        </button>
                    </div>
                </nav>
                <div class="container-fluid">
                   
                    <div class="row justify-content-center">
                        <div class="col-md-10 pt-md-2">
                            <form class="form pb-3" method="POST" style="border: 1px solid black; padding: 25px; padding-bottom: 0px; border-radius: 2px;background-color:white!important" >
                                <h5 class="text-center pb-3" style="font-weight: bolder;"><span> <a class="btn btn-dark btn-sm" href="newproductidea_home.php" style="font-size:11px!important;float:left!important"><i class="fa-solid fa-arrow-left"></i> Home</a></span>New Product Idea Form</h5>

                                <table class="table">
                                    <thead>
                                    </thead>
                                    <tbody>
                                        <tr>
                                           
                                            <td class="textp">a) Therapeutic Category</td>
                                            <td><input type="text" name="therapeutic_category"></td>
                                        </tr>
                                        <tr>
                                  
                                            <td class="textp">b) Dosage Form</td>
                                            <td><input type="text" name="dosage_form"></td>
                                        </tr>
                                        <tr>
                   
                                            <td class="textp">c) Primary Packaging</td>
                                            <td><input type="text" name="primary_packaging"></td>
                                        </tr>
                                        <tr>
                                        
                                            <td class="textp">C) Proposed Indication</td>
                                            <td><input type="text" name="proposed_indication"></td>
                                        </tr>
                                        <tr>
                                   
                                            <td class="textp">D) Preferred Ingredient</td>
                                            <td><input type="text" name="preferred_ingredient"></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table">
                                    <head>
                                    <th class="th_secondary">Actives</th>
                                    <th class="th_secondary">Inactives (Flavors,Colors ETC)</th>
                                    </head>
                                    <tbody>
                                        <tr>
                                        <td><input type="text" name="active_1"></td>
                                        <td><input type="text" name="inactive_1"></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <p class="textp">e)	Undesired Ingredient (S):</p>
                                <table class="table">
                                    <head>
                                        <th class="th_secondary">Actives</th>
                                        <th class="th_secondary">Inactives (Flavors,Colors ETC)</th>
                                    </head>
                                    <tbody>
                                        <tr>
                                        <td><input type="text" name="active_2"></td>
                                        <td><input type="text" name="inactive_2"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p class="textp">f)	Benchmarking:</p>
                                <table class="table">
                                    <head>
                                        <th class="th_secondary">Local Samples</th>
                                        <th class="th_secondary">International Samples</th>
                                    </head>
                                    <tbody>
                                        <tr>
                                        <td><input type="text" name="local_samples_1"></td>
                                        <td><input type="text" name="international_samples_1"></td>
                           
                                        </tr>
                                        <tr>
                                        <td><input type="text" name="local_samples_2"></td>
                                        <td><input type="text" name="international_samples_2"></td>
                                       
                                        </tr>
                                    </tbody>
                                </table>
                                
                                <p class="textp">g) Any other remarks or preferences:</p>
                                <input type="text" name="any_other_1">
                                <p class="textp">Extracts sample provided</p>
                                <input type="text" name="any_other_2"> 

                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-submit" name="submit" style="font-size: 20px">Submit</button>
                                </div>
                            </form>
                            <?php
include 'dbconfig.php';

if (isset($_POST['submit'])) {

    date_default_timezone_set("Asia/Karachi");


    $id = $_SESSION['id'];
    $name = $_SESSION['fullname'];
    $email = $_SESSION['email'];
    $username = $_SESSION['username'];
    $department = $_SESSION['department'];
    $role = $_SESSION['role'];
    $date = date('Y-m-d H:i:s');

    $be_depart = $_SESSION['be_depart'];
    $be_role = $_SESSION['be_role'];

    $therapeutic_category = $_POST['therapeutic_category'];
    $dosage_form = $_POST['dosage_form'];
    $primary_packaging = $_POST['primary_packaging'];
    $proposed_indication = $_POST['proposed_indication'];
    $preferred_ingredient = $_POST['preferred_ingredient'];
    $active_1 = $_POST['active_1'];
    $active_2 = $_POST['active_2'];
    $inactive_1 = $_POST['inactive_1'];
    $inactive_2 = $_POST['inactive_2'];

    $local_samples_1 = $_POST['local_samples_1'];
    $local_samples_2 = $_POST['local_samples_2'];
    $international_samples_1 = $_POST['international_samples_1'];
    $international_samples_2 = $_POST['international_samples_2'];

    $any_other_1 = $_POST['any_other_1'];
    $any_other_2 = $_POST['any_other_2'];

    $insert = "INSERT INTO new_product_idea (
        therapeutic_category, dosage_form, primary_packaging, proposed_indication, 
        preferred_ingredient, active_1, active_2, inactive_1, inactive_2, 
        local_samples_1, local_samples_2, international_samples_1, international_samples_2, 
        any_other_1, any_other_2, user_name, user_date, user_email, user_dept, user_role, 
        be_depart, be_role, head_status, bd_status, rnd_status
    ) VALUES (
        '$therapeutic_category', '$dosage_form', '$primary_packaging', '$proposed_indication', 
        '$preferred_ingredient', '$active_1', '$active_2', '$inactive_1', '$inactive_2', 
        '$local_samples_1', '$local_samples_2', '$international_samples_1', '$international_samples_2', 
        '$any_other_1', '$any_other_2', '$name', '$date', '$email', '$department', '$role', 
        '$be_depart', '$be_role', 'Pending', 'Pending', 'Pending'
    )";

    $insert_q = mysqli_query($conn, $insert);
    if ($insert_q) {
        // Get inserted ID
        $last_insert_id = mysqli_insert_id($conn);

        // Insert into newproductidea_npd
        $insert_npd = "INSERT INTO newproductidea_npd (fk_id) VALUES ('$last_insert_id')";
        $insert_npd_q = mysqli_query($conn, $insert_npd);

        if ($insert_npd_q) {
            // Sending email
            try {
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->Host       = 'smtp.office365.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'info@medicslab.com';
                $mail->Password   = 'kcmzrskfgmwzzshz';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom('info@medicslab.com', 'Medics Digital form');
                $mail->addAddress('ihamzajz@gmail.com', 'HOD');

                $mail->isHTML(true);
                $mail->Subject = "New Product Idea Form Submission";
                $mail->Body = "
                    <p>Dear BD,</p>
                    <p>New Product Idea form has been submitted by {$name}.</p>
                ";

                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            echo "<script>alert('Form has been submitted!'); window.location.href = 'newproductidea_form.php';</script>";
        } else {
            echo "<script>alert('Failed to link NPD record!'); window.location.href = 'newproductidea_form.php';</script>";
        }
    } else {
        echo "<script>alert('Form submission failed!'); window.location.href = 'newproductidea_form.php';</script>";
    }
}
?>

                        </div>
                    </div>
                </div>
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