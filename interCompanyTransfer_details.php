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
        <title>Asset Transfer Form - Details</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
    <!-- Poppins Font -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <link rel="stylesheet" href="assets/css/style.css">
        <style>
            body {
font-family: 'Poppins', sans-serif;
}

            input::placeholder {
            color: black!important; /* Placeholder text color */
            }
        </style>
        <style>
            .btn, .btn-menu{
            font-size: 11px!important;
            border-radius:0px
            }
            a{
            text-decoration:none!important;
            }
            .table-container1 {
            overflow-y: auto;
            height: 93vh; 
            margin: 0;
            padding: 0;
            }
            table {
            width: 100%;
            border-collapse: collapse;
            }
            table th {
            background-color: #0D9276!important;;
            position: sticky;
            top: 0;
            z-index: 1000; 
            font-size: 10px;
            border: none!important;
            text-align: left;
            color:white!important;;
            }
            table td {
            font-size: 10px;
            color: black!important;
            padding: 5px!important; /* Adjust padding as needed */
            border: 1px solid #ddd;
            }
        </style>
        <style>
           .btn{
                font-size: 11px!important;
                color:white!important;
                border-radius:0px!important
            }
            input{
        font-size: 12px;
        background-color:#f2f2f2;
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 5px;
        border: 1px solid black;
        
    }
            p{
                font-size: 12px!important;
         padding: 0px!important;
         margin: 0px!important;
         font-weight: 500;
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
                  <button type="button" id="sidebarCollapse" class="btn btn-info btn-menu">
                  <i class="fas fa-align-left"></i>
                  <span>Menu</span>
                  </button>
               </div>
            </nav>
        <?php
            include 'dbconfig.php';
            
            
            $id=$_GET['id'];
            $select = "SELECT * FROM intercompanytransfer_form WHERE
            id = '$id' ";
            
            $select_q = mysqli_query($conn,$select);
            $data = mysqli_num_rows($select_q);
            ?>
        <?php 
            if($data){
            	while ($row=mysqli_fetch_array($select_q)) {
            		?>
        <div class="row justify-content-center">
            <div class="col-12">
                <form class="form pb-3" method="POST">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-10 p-5" Style="border:1px solid black;background-color:White">
                            <h6 class="text-center pb-md-4 pb-3 font-weight-bold"><span style="float:right"><a class="btn btn-dark btn-sm" href="assets_management_home.php" style="font-size:11px!important"><i class="fa-solid fa-arrow-left"></i> Home</a></span>Asset Transfer #<?php echo $row['id']?></h6>
                            <!-- row 0 starts -->
                            <!-- <h6 class="text-center pb-3">Disposal Content</h6> -->
                            <div class="row pb-2 justify-content-center" >
                                <div class="col-md-4 pb-md-0 pb-2">
                                    <p>Receiving Custodian Name</p>
                                    <input type="text" value="<?php echo $row['rc_name']?>" name="rc_name" class="w-100">
                                </div>
                                <div class="col-md-4 pb-md-0 pb-2">
                                    <p>Receiving Custodian No.</p>
                                    <input type="text" value="<?php echo $row['rc_no']?>" name="rc_no" class="w-100">
                                </div>
                                <div class="col-md-4 pb-md-0 pb-2">
                                    <p>Department Code</p>
                                    <input type="text" value="<?php echo $row['department']?>" name="department" class="w-100">
                                </div>
                            </div>
                            <div class="row pb-2 justify-content-center">
                                <div class="col-md-4 pb-md-0 pb-2">
                                    <p>Date</p>
                                    <input type="text" value="<?php echo $row['date_1']?>" name="date_1" class="w-100">
                                </div>
                                <div class="col-md-4 pb-md-0 pb-2">
                                    <p>Asset Tag Number</p>
                                    <input type="text" value="<?php echo $row['asset_tag_number']?>" name="asset_tag_number" class="w-100">
                                </div>
                                <div class="col-md-4 pb-md-0 pb-2">
                                    <p>Qty</p>
                                    <input type="text" value="<?php echo $row['qty']?>" name="qty" class="w-100">
                                </div>
                            </div>
                            <div class="row pb-2 justify-content-center">
                                <div class="col-12">
                                    <p>Description</p>
                                    <input type="text" value="<?php echo $row['description']?>" name="description" class="w-100">
                                </div>
                            </div>
                            <div class="row pb-2 justify-content-center">
                                <div class="col-md-4 pb-md-0 pb-2">
                                    <p>S.no</p>
                                    <input type="text" value="<?php echo $row['s_no']?>" name="s_no" class="w-100">
                                </div>
                                <div class="col-md-4 pb-md-0 pb-2">
                                    <p>Cost</p>
                                    <input type="text" value="<?php echo $row['cost']?>" name="cost" class="w-100">
                                </div>
                                <div class="col-md-4 pb-md-0 pb-2">
                                    <p>Bldg</p>
                                    <input type="text" value="<?php echo $row['bldg']?>" name="bldg" class="w-100">
                                </div>
                            </div>
                            <!-- row 0 ends -->
                            <!-- row 1 starts -->
                            <div class="row pb-2">
                                <div class="col-md-6 pb-md-0 pb-2">
                                    <p>Room</p>
                                    <input type="text" value="<?php echo $row['room']?>" name="room" class="w-100">
                                </div>
                                <div class="col-md-6 pb-md-0 pb-2">
                                    <p>Owner Code</p>
                                    <input type="text" value="<?php echo $row['owner_code']?>" name="owner_code" class="w-100">
                                </div>
                            </div>
                            <!-- row 1 ends -->
                            <!-- row 2 starts -->
                            <div class="row">
                                <div class="col-md-6 pb-md-0 pb-2">
                                    <p>Comments</p>
                                    <input type="text" value="<?php echo $row['comments']?>" name="comments" class="w-100">
                                </div>
                                <div class="col-md-6 pb-md-0 pb-2">
                                    <p>Finance</p>
                                    <input type="text" value="<?php echo $row['finance_msg']?>" name="finance_msg" class="w-100">
                                </div>
                            </div>

                            <div class="row pt-3">
                                <div class="col">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-sm btn-dark" name="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    include 'dbconfig.php';
                    
                    // Check if form is submitted
                    if (isset($_POST['submit'])) {
                        // Retrieve form data
                        $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                        $name =  $_SESSION['fullname'];
                    
                        $f_rc_name= isset($_POST['rc_name']) && $_POST['rc_name'] !== $row['rc_name'] ? $_POST['rc_name'] : $row['rc_name'];
                        $f_rc_no = isset($_POST['rc_no']) && $_POST['rc_no'] !== $row['rc_no'] ? $_POST['rc_no'] : $row['rc_no'];
                        $f_department= isset($_POST['department']) && $_POST['department'] !== $row['department'] ? $_POST['department'] : $row['department'];

                        $f_date_1 = isset($_POST['date_1']) && $_POST['date_1'] !== $row['date_1'] ? $_POST['date_1'] : $row['date_1'];
                        $f_asset_tag_number = isset($_POST['asset_tag_number']) && $_POST['asset_tag_number'] !== $row['asset_tag_number'] ? $_POST['asset_tag_number'] : $row['asset_tag_number'];
                        $f_qty = isset($_POST['qty']) && $_POST['qty'] !== $row['qty'] ? $_POST['qty'] : $row['qty'];

                        $f_description = isset($_POST['description']) && $_POST['description'] !== $row['description'] ? $_POST['description'] : $row['description'];
                        $f_s_no = isset($_POST['s_no']) && $_POST['s_no'] !== $row['s_no'] ? $_POST['s_no'] : $row['s_no'];
                        $f_cost = isset($_POST['cost']) && $_POST['cost'] !== $row['cost'] ? $_POST['cost'] : $row['cost'];

                        $f_bldg = isset($_POST['bldg']) && $_POST['bldg'] !== $row['bldg'] ? $_POST['bldg'] : $row['bldg'];
                        $f_room = isset($_POST['room']) && $_POST['room'] !== $row['room'] ? $_POST['room'] : $row['room'];
                        $f_owner_code = isset($_POST['owner_code']) && $_POST['owner_code'] !== $row['owner_code'] ? $_POST['owner_code'] : $row['owner_code'];

                        $f_comments = isset($_POST['comments']) && $_POST['comments'] !== $row['comments'] ? $_POST['comments'] : $row['comments'];
                        $f_finance_msg= isset($_POST['finance_msg']) && $_POST['finance_msg'] !== $row['finance_msg'] ? $_POST['finance_msg'] : $row['finance_msg'];


                      
                        $update_query = "UPDATE intercompanytransfer_form SET 
                    
                                          rc_name = '$f_rc_name',
                                          rc_no = '$f_rc_no',
                                           department = '$f_department',

                                          date_1 = '$f_date_1',
                                          asset_tag_number = '$f_asset_tag_number',
                                          qty = '$f_qty',

                                          description = '$f_description',
                                          s_no= '$f_s_no',
                                          cost = '$f_cost',

                                          bldg = '$f_bldg',
                                          room = '$f_room',
                                          owner_code = '$f_owner_code',

                                           comments = '$f_comments',
                                          finance_msg = '$f_finance_msg'

                
                                         
                    
                                            WHERE id = '$id'";
                    
                        // Execute update query
                        $result = mysqli_query($conn, $update_query);
                    
                        if ($result) {
                            echo "<script>
                            alert('Data updated successfully.');
                            window.location.href = window.location.href; // Reload the page
                          </script>";
                        } else {
                            // Update failed
                            echo "<script>
                            alert('Update Failed.');
                            window.location.href = window.location.href; // Reload the page
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
    </body>
</html>