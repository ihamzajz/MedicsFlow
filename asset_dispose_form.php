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
        <title>Digital Form</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
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
                background-color: #06923E!important;
                color:white!important;
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
            p{
            font-size: 12px!important;
            padding: 0px!important;
            margin: 0px!important;
            font-weight: 500;
            }
        </style>
        <style>
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
                        <button type="button" id="sidebarCollapse" class="btn btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                        </button>
                    </div>
                </nav>
                <?php
                    include 'dbconfig.php';
                    
                    
                    $id=$_GET['id'];
                    $select = "SELECT * FROM assets WHERE
                    id = '$id' ";
                    
                    $select_q = mysqli_query($conn,$select);
                    $data = mysqli_num_rows($select_q);
                    ?>
                <?php 
                    if($data){
                    	while ($row=mysqli_fetch_array($select_q)) {
                    		?>
                <div class="container">
                    <form class="form pb-3" method="POST">
                        <div class="row">
                            <!-- col-1-starts -->
                            <div class="col-12 p-5" Style="border:1px solid black; background-color:white;padding:20px">
                                <!-- Header with buttons on left and heading centered -->
                                <!-- Header row -->
                                <div class="position-relative mb-4" style="min-height: 40px;">
    <!-- Left buttons -->
    <div class="position-relative z-1">
        <a class="btn btn-dark btn-sm me-2" href="assets_management_home.php" style="font-size:11px!important">
            <i class="fa-solid fa-home"></i> Home
        </a>
        <a class="btn btn-dark btn-sm" href="asset_details.php?id=<?php echo $id; ?>" style="font-size:11px!important">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>

    <!-- Centered heading -->
    <h6 class="position-absolute top-50 start-50 translate-middle text-center mb-0 font-weight-bold">
        <b>
            <span class="text-primary"><?php echo $row['name_description'] ?></span>
            <span>(<?php echo $row['asset_tag_number'] ?>)</span>
        </b>
    </h6>
</div>


                                <div class="row pb-2 pt-5">
                                    <div class="col-md-4">
                                        <p>Orignal Value</p>
                                        <input type="text" name="dc_original_value" value="<?php echo $row['dc_original_value']; ?>" class="w-100">
                                    </div>
                                    <div class="col-md-4">
                                        <p>Depreciation Value</p>
                                        <input type="text" name="dc_depreciation_value" value="<?php echo $row['dc_depreciation_value']; ?>" class="w-100">
                                    </div>
                                    <div class="col-md-4">
                                        <p>Net Worth</p>
                                        <input type="text" name="dc_networth" value="<?php echo $row['dc_networth']; ?>" class="w-100">
                                    </div>
                                </div>
                                <div class="row pb-2">
                                    <div class="col-md-4">
                                        <p>Disposal Reason</p>
                                        <input type="text" name="dc_disposal_reason" value="<?php echo $row['dc_disposal_reason']; ?>" class="w-100">
                                    </div>
                                    <div class="col-md-4">
                                        <p>Department Head Opinion</p>
                                        <input type="text" name="dc_department_head_opinion" value="<?php echo $row['dc_department_head_opinion']; ?>" class="w-100">
                                    </div>
                                </div>
                                <?php
                                    $dc_disposal_method = $row['dc_disposal_method']; // Get actual value from database
                                    ?>
                                <div class="row pb-3">
                                    <div class="col">
                                        <h6 style="font-size:13.5px" class="pb-1">Disposal Method</h6>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th style="background-color:#AEDEFC;color:black;font-size:13px">Sold</th>
                                                    <th style="background-color:#AEDEFC;color:black;font-size:13px">Scrapped</th>
                                                    <th style="background-color:#AEDEFC;color:black;font-size:13px">Destroyed</th>
                                                    <th style="background-color:#AEDEFC;color:black;font-size:13px">Lost</th>
                                                    <th style="background-color:#AEDEFC;color:black;font-size:13px">Idle</th>
                                                    <th style="background-color:#AEDEFC;color:black;font-size:13px">Other</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input type="radio" name="dc_disposal_method" value="Sold" <?php if($dc_disposal_method == 'Sold') echo 'checked'; ?>></td>
                                                    <td><input type="radio" name="dc_disposal_method" value="Scrapped" <?php if($dc_disposal_method == 'Scrapped') echo 'checked'; ?>></td>
                                                    <td><input type="radio" name="dc_disposal_method" value="Destroyed" <?php if($dc_disposal_method == 'Destroyed') echo 'checked'; ?>></td>
                                                    <td><input type="radio" name="dc_disposal_method" value="Lost" <?php if($dc_disposal_method == 'Lost') echo 'checked'; ?>></td>
                                                    <td><input type="radio" name="dc_disposal_method" value="Idle" <?php if($dc_disposal_method == 'Idle') echo 'checked'; ?>></td>
                                                    <td><input type="radio" name="dc_disposal_method" value="Other" <?php if($dc_disposal_method == 'Other') echo 'checked'; ?>></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                            <div class="col">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-submit" name="submit">Dispose Asset</button>
                                </div>
                            </div>
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
                    
                        $dc_original_value = isset($_POST['dc_original_value']) && $_POST['dc_original_value'] !== $row['dc_original_value'] ? $_POST['dc_original_value'] : $row['dc_original_value'];
                        $dc_depreciation_value = isset($_POST['dc_depreciation_value']) && $_POST['dc_depreciation_value'] !== $row['dc_depreciation_value'] ? $_POST['dc_depreciation_value'] : $row['dc_depreciation_value'];
                        $dc_networth = isset($_POST['dc_networth']) && $_POST['dc_networth'] !== $row['dc_networth'] ? $_POST['dc_networth'] : $row['dc_networth'];
                        $dc_disposal_reason = isset($_POST['dc_disposal_reason']) && $_POST['dc_disposal_reason'] !== $row['dc_disposal_reason'] ? $_POST['dc_disposal_reason'] : $row['dc_disposal_reason'];
                        $dc_department_head_opinion = isset($_POST['dc_department_head_opinion']) && $_POST['dc_department_head_opinion'] !== $row['dc_department_head_opinion'] ? $_POST['dc_department_head_opinion'] : $row['dc_department_head_opinion'];
                        $dc_disposal_method = isset($_POST['dc_disposal_method']) && $_POST['dc_disposal_method'] !== $row['dc_disposal_method'] ? $_POST['dc_disposal_method'] : $row['dc_disposal_method'];
                    
                    
                    
                      
                        $update_query = "UPDATE assets SET 
                    
                                          dc_original_value = '$dc_original_value',
                                          dc_depreciation_value = '$dc_depreciation_value',
                                          dc_networth = '$dc_networth',
                                          dc_disposal_reason = '$dc_disposal_reason',
                                          dc_department_head_opinion = ' $dc_department_head_opinion',
                    
                                          dc_disposal_method = '$dc_disposal_method',
                                          final_status = 'Disposed'
                                          
                    
                                            WHERE id = '$id'";
                    
                        // Execute update query
                        $result = mysqli_query($conn, $update_query);
                    
                        if ($result) {
                            // Update successful
                            echo "<script>
                                alert('Asset disposal completed successfully..');
                                window.location.href = 'asset_details.php?id={$id}';
                            </script>";
                        } else {
                            // Update failed
                            echo "<script>
                                alert('Disposal Failed.');
                                window.location.href = 'asset_details.php?id={$id}';
                            </script>";
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
            $('#myTable').tableExport({ type: 'excel',ignoreColumn: [] });
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
    </body>
</html>