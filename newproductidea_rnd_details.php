<?php
    session_start();
    
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php'); // Redirect to the login page
        exit;
    }
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>New Product Idea Detail</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <!-- Bootstrap CSS CDN -->
        <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous"> -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!--Font -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
            tr{
                border:none!important;
                padding:0px!important;
                margin:0px!important;
            }
            th{
                font-size: 10.5px!important;
            }
            td{
                border:none!important;
                padding:0px!important;
                margin:0px!important;
                font-size: 11px!important;
            }
            p{
                padding:0px!important;
                margin:0px!important; 
            }
            .th_secondary{
            font-size: 11px!important; 
            color:white!important; 
            background-color: #3D3D3D!important; 
            text-transform:capitalize!important; 
            }
            .textp {
            font-size: 12px !important;
            }
            body {
            font-family: 'Poppins', sans-serif;
            }
            .btn{
            font-size: 11px;
            border-radius:0px;
            }
            p{
            font-size: 12.5px!important;
            padding: 0px!important;
            margin: 0px!important;
            font-weight: 500;
            }
            input,textarea {
            width: 100% !important;
            font-size: 11px!important; 
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
            ::placeholder {
            color: black; 
            }
            textarea {
            font-size: 14px; 
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
        <?php
            include 'dbconfig.php';
            ?>
        <div class="wrapper d-flex align-items-stretch">
            <?php
                include 'sidebar1.php';
                ?>
            <!-- Page Content  -->
            <div id="content">
                <!-- navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-success">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                        </button>
                    </div>
                </nav>
                <?php
                include 'dbconfig.php';
                
                
                $id=$_GET['id'];
                $select = "SELECT * FROM new_product_idea WHERE
                id = '$id' ";
                
                $select_q = mysqli_query($conn,$select);
                $data = mysqli_num_rows($select_q);
                ?>
                            <?php 
                if($data){
                	while ($row=mysqli_fetch_array($select_q)) {
                		?>
                <div class="container">
                    <form class="form pb-3" method="POST" style="border: 1px solid black; padding: 25px; padding-bottom: 0px; border-radius: 2px;background-color:white!important" >
                        <div class="d-flex align-items-center justify-content-between pb-3" style="position: relative;">
                            <div>
                                <a class="btn btn-dark btn-sm me-2" href="newproductidea_home.php" style="font-size:11px!important;">
                                <i class="fa-solid fa-arrow-left"></i> Home
                                </a>
                                <a class="btn btn-dark btn-sm" href="newproductidea_rnd_list.php" style="font-size:11px!important;">
                                <i class="fa-solid fa-arrow-left"></i> Back
                                </a>
                            </div>
                            <h5 class="position-absolute top-50 start-50 translate-middle" style="font-weight: bolder;">
                                New Product Idea Form
                            </h5>
                        </div>

                        <div class="row pt-3 pb-4">

                            <div class="col-md-4">
                                <p>Submitted by:</p>
                                <input type="text" readonly value="<?php echo $row['user_name']; ?>">
                            </div>
                            <div class="col-md-4">
                            <p>Department:</p>
                                <input type="text" readonly value="<?php echo $row['user_dept']; ?>">
                            </div>
                            <div class="col-md-4">
                            <p>Role</p>
                                <input type="text" readonly value="<?php echo $row['user_role']; ?>">
                            </div>
                        </div>
                        <table class="table pt-5">
                            <thead>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="textp">a) Therapeutic Category</td>
                                    <td><input type="text" name="therapeutic_category" value="<?php echo $row['therapeutic_category']; ?>"></td>
                                </tr>
                                <tr>
                                    <td class="textp">b) Dosage Form</td>
                                    <td><input type="text" name="dosage_form" value="<?php echo $row['dosage_form']; ?>"></td>
                                </tr>
                                <tr>
                                    <td class="textp">c) Primary Packaging</td>
                                    <td><input type="text" name="primary_packaging" value="<?php echo $row['primary_packaging']; ?>" ></td>
                                </tr>
                                <tr>
                                    <td class="textp">C) Proposed Indication</td>
                                    <td><input type="text" name="proposed_indication" value="<?php echo $row['proposed_indication']; ?>"></td>
                                </tr>
                                <tr>
                                    <td class="textp">D) Preferred Ingredient</td>
                                    <td><input type="text" name="preferred_ingredient" value="<?php echo $row['preferred_ingredient']; ?>"></td>
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
                                    <td><input type="text" name="active_1" value="<?php echo $row['active_1']; ?>"></td>
                                    <td><input type="text" name="inactive_1" value="<?php echo $row['inactive_1']; ?>"></td>
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
                                    <td><input type="text" name="active_2" value="<?php echo $row['active_2']; ?>"></td>
                                    <td><input type="text" name="inactive_2" value="<?php echo $row['inactive_2']; ?>"></td>
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
                                    <td><input type="text" name="local_samples_1" value="<?php echo $row['local_samples_1']; ?>"></td>
                                    <td><input type="text" name="international_samples_1" value="<?php echo $row['international_samples_1']; ?>"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="local_samples_2" value="<?php echo $row['local_samples_2']; ?>"></td>
                                    <td><input type="text" name="international_samples_2" value="<?php echo $row['international_samples_2']; ?>"></td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="textp">g) Any other remarks or preferences:</p>
                        <input type="text" name="any_other_1" value="<?php echo $row['any_other_1']; ?>">
                        <p class="textp">Extracts sample provided</p>
                        <input type="text" name="any_other_2" value="<?php echo $row['any_other_2']; ?>"> 
                        <div class="row">
                            <div class="col">
                                <div class="text-center py-3">
                                    <button type="submit" class="btn-submit" name="submit"><i class="fa-solid fa-pencil"></i> Update</button>
                                    <a href="#"  style="font-size: 14.4px" class="btn btn-success" onclick="promptReason2(<?php echo $row['id']; ?>)" ><i class="fa-regular fa-circle-check"></i> Approve</a>
                                    <a href="#"  style="font-size: 14.4px" class="btn btn-danger" onclick="promptReason(<?php echo $row['id']; ?>)" ><i class="fa-regular fa-circle-xmark"></i> Reject</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <?php
                    include 'dbconfig.php';
                    
                    // Check if form is submitted
                    if (isset($_POST['submit'])) {
                        // Retrieve form data
                        $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                        $name =  $_SESSION['fullname'];
                    
                        $therapeutic_category = isset($_POST['therapeutic_category']) && $_POST['therapeutic_category'] !== $row['therapeutic_category'] ? $_POST['therapeutic_category'] : $row['therapeutic_category'];
                        $dosage_form = isset($_POST['dosage_form']) && $_POST['dosage_form'] !== $row['dosage_form'] ? $_POST['dosage_form'] : $row['dosage_form'];
                        $primary_packaging = isset($_POST['primary_packaging']) && $_POST['primary_packaging'] !== $row['primary_packaging'] ? $_POST['primary_packaging'] : $row['primary_packaging'];
                        $proposed_indication = isset($_POST['proposed_indication']) && $_POST['proposed_indication'] !== $row['proposed_indication'] ? $_POST['proposed_indication'] : $row['proposed_indication'];
                        $preferred_ingredient = isset($_POST['preferred_ingredient']) && $_POST['preferred_ingredient'] !== $row['preferred_ingredient'] ? $_POST['preferred_ingredient'] : $row['preferred_ingredient'];
                         

                        $active_1 = isset($_POST['active_1']) && $_POST['active_1'] !== $row['active_1'] ? $_POST['active_1'] : $row['active_1'];
                        $inactive_1 = isset($_POST['inactive_1']) && $_POST['inactive_1'] !== $row['inactive_1'] ? $_POST['inactive_1'] : $row['inactive_1'];
                        $active_2 = isset($_POST['active_2']) && $_POST['active_2'] !== $row['active_2'] ? $_POST['active_2'] : $row['active_2'];
                        $inactive_2 = isset($_POST['inactive_2']) && $_POST['inactive_2'] !== $row['inactive_2'] ? $_POST['inactive_2'] : $row['inactive_2'];
                         
                        $local_samples_1 = isset($_POST['local_samples_1']) && $_POST['local_samples_1'] !== $row['local_samples_1'] ? $_POST['local_samples_1'] : $row['local_samples_1'];
                        $international_samples_1 = isset($_POST['international_samples_1']) && $_POST['international_samples_1'] !== $row['international_samples_1'] ? $_POST['international_samples_1'] : $row['international_samples_1'];
                        $local_samples_2 = isset($_POST['local_samples_2']) && $_POST['local_samples_2'] !== $row['local_samples_2'] ? $_POST['local_samples_2'] : $row['local_samples_2'];
                        $international_samples_2 = isset($_POST['international_samples_2']) && $_POST['international_samples_2'] !== $row['international_samples_2'] ? $_POST['international_samples_2'] : $row['international_samples_2'];
                         
                        $any_other_1 = isset($_POST['any_other_1']) && $_POST['any_other_1'] !== $row['any_other_1'] ? $_POST['any_other_1'] : $row['any_other_1'];
                        $any_other_2 = isset($_POST['any_other_2']) && $_POST['any_other_2'] !== $row['any_other_2'] ? $_POST['any_other_2'] : $row['any_other_2'];
                         
                   
                      
                        $update_query = "UPDATE new_product_idea SET 
                    
                                          therapeutic_category = '$therapeutic_category',
                                          dosage_form = '$dosage_form',
                                          primary_packaging = '$primary_packaging',
                                          proposed_indication = '$proposed_indication',
                                          preferred_ingredient = ' $preferred_ingredient',

                                          active_1 = '$active_1',
                                          inactive_1 = '$inactive_1',
                                          active_2 = '$active_2',
                                          inactive_2 = '$inactive_2',

                                          local_samples_1 = '$local_samples_1',
                                          international_samples_1 = '$international_samples_1',
                                          local_samples_2 = '$local_samples_2',
                                          international_samples_2 = '$international_samples_2',

                                          any_other_1 = '$any_other_1',
                                          any_other_2 = '$any_other_2'
                                         
                    
                                       
                    
                                            WHERE id = '$id'";
                    
                        // Execute update query
                        $result = mysqli_query($conn, $update_query);
                    
                        if ($result) {
                            // Update successful
                            echo "<script>
                            alert('Data updated successfully.');
                            window.location.href = window.location.href; // Reload the page
                          </script>";
                            // Redirect or perform additional actions as needed
                        } else {
                            // Update failed
                            echo "<script>
                            alert('Update Failed.');
                            window.location.href = window.location.href; // Reload the page
                          </script>";
                            // Redirect or handle error as needed
                        }
                    }
                    ?>
                <!-- col-1-ends -->
            </div>
            <?php
                }
                }
                else{
                echo "No record found!";
                }
                ?>
        </div>
        <!--content-->
        </div>
        <!--wrapper-->
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
        <script type="text/javascript" src="libs/js-xlsx/xlsx.core.min.js"></script>
        <!-- table export -->
        <script src="
            https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/tableExport.min.js
            "></script>
        <script type="text/javascript" src="libs/FileSaver/FileSaver.min.js"></script>
        <script type="text/javascript" src="../libs/jsPDF/polyfills.umd.js"></script>
        <script type="text/javascript" src="tableExport.min.js"></script>
        <!-- TABLE EXPORT -->
        <!-- ALL -->
        <script type="text/javascript">
            $(document).ready(function() {
            $('#excel').click(function() {
            $('#myTable').tableExport({ type: 'excel',ignoreColumn: [16] });
            });
            });
        </script>
        <!-- ALL -->
        <script>
            $(document).ready(function () {
            (function ($) {
                $('#filter').keyup(function () {
                    var rex = new RegExp($(this).val(), 'i');
                    $('.searchable tr').hide();
                    $('.searchable tr').filter(function () {
                        return rex.test($(this).text());
                    }).show();
                })
            
            }(jQuery));
            });
        </script>
        <script src="assets/js/main.js"></script>


        <script>
            function promptReason(itemId) {
                var reason = prompt("Rejection Remarks:");
                if (reason != null && reason.trim() !== "") {
                    window.location.href = "newproductidea_rnd_reject.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
                }
            }
        </script>
        <script>
            function submitRejectionReason(itemId, reason) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload(); 
                    }
                };
                xhr.open("POST", "update_rejection_reason.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + itemId + "&reason=" + encodeURIComponent(reason));
            }
        </script>





        <script>
            function promptReason2(itemId) {
                var reason = prompt("Approval Remarks:");
                if (reason != null && reason.trim() !== "") {
                    window.location.href = "newproductidea_rnd_approve.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
                }
            }
        </script>
        <script>
            function submitRejectionReason(itemId, reason) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload(); 
                    }
                };
                xhr.open("POST", "update_rejection_reason.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + itemId + "&reason=" + encodeURIComponent(reason));
            }
        </script>
    </body>
</html>