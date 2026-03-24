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
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
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
            .btn{
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
         
th{
font-size: 10.5px!important;
border:none!important;
background-color: #0D9276!important;
color:white!important;
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
    font-size: 11px;
    border-radius:0px;
    color:white!important;
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
            margin: 0;
            margin-bottom: 2px;
            font-size: 12px!important;
            color: black;
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
                <button type="button" id="sidebarCollapse" class="btn btn-info">
                <i class="fas fa-align-left"></i>
                <span>Menu</span>
                </button>
            </div>
        </nav>
        <?php
            include 'dbconfig.php';
            
            
            $id=$_GET['id'];
            $select = "SELECT * FROM fixed_assets_disposal_form WHERE
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
                <div class="col-xl-10 p-5" style="border:1px solid black;background-color:White">
                            <h6 class="text-center pb-1 font-weight-bold"><span style="float:right"> <a class="btn btn-dark btn-sm" href="assets_management_home.php" style="font-size:11px!important"><i class="fa-solid fa-arrow-left"></i> Home</a></span>Fixed Assets Disposal Form</h6>




                            <!-- row 0 starts -->





                            <h6 class="pt-2" style="font-size:14px">Disposal Content</h6>
                            <div class="row pb-1" >
                               
                                <div class="col-md-4">
                                    <p>Name</p>
                                    <input type="text" value="<?php echo $row['dc_name']?>" name="dc_name"  class="w-100" readonly>
                                </div>
                                <div class="col-md-4">
                                    <p>Asset Number</p>
                                    <input type="text" value="<?php echo $row['dc_asset_number']?>" name="dc_asset_number"  class="w-100" readonly>
                                </div>

                                <div class="col-md-4">
                                    <p>Date of Purchase</p>
                                    <input type="text" value="<?php echo $row['dc_date_of_purchase']?>" name="dc_date_of_purchase"  class="w-100" readonly>
                                </div>
                            </div>

                            <div class="row pb-1 pt-md-2" >
                                <div class="col-md-4">
                                    <p>Quantity</p>
                                    <input type="text" value="<?php echo $row['dc_quantity']?>" name="dc_quantity" class="w-100" readonly>
                                </div>
                                <div class="col-md-4">
                                    <p>Brand/Specification</p>
                                    <input type="text" value="<?php echo $row['dc_brand_specification']?>" name="dc_brand_specification" class="w-100" readonly>
                                </div>
                                <div class="col-md-4">
                                    <p>Disposition Date</p>
                                    <input type="text" value="<?php echo $row['dc_disposition_date']?>" name="dc_disposition_date" class="w-100" readonly>
                                </div>
                            </div>     
                            
                            


                            <div class="row pb-1 pt-md-2" >
                               <div class="col-md-4">
                                   <p>Orignal Value</p>
                                   <input type="text" value="<?php echo $row['dc_original_value']?>" name="dc_original_value" class="w-100" readonly>

                               </div>
                               <div class="col-md-4">
                                   <p>Depreciation Value</p>
                                   <input type="text" value="<?php echo $row['dc_depreciation_value']?>" name="dc_depreciation_value" class="w-100" readonly>
                               </div>
                               <div class="col-md-4">
                                   <p>Net Worth</p>
                                   <input type="text" value="<?php echo $row['dc_networth']?>" name="dc_networth" class="w-100" readonly>
                               </div>
                           
                           </div>    
                            <!-- row 0 ends -->

                          
                            <!-- row 1 starts -->
                            <div class="row pb-1 pt-md-2" >
                                <div class="col-md-4">
                                    <p>Disposal Reason</p>
                                    <input type="text" value="<?php echo $row['disposal_reason']?>" name="disposal_reason" class="w-100" readonly>
                                </div>
                                <div class="col-md-8">
                                    <p>Department Head Opinion</p>
                                    <input type="text" value="<?php echo $row['department_head_opinion']?>" name="department_head_opinion" class="w-100" readonly>
                                </div>
                            </div>
                            <!-- row 1 ends -->

                            <!-- row 2 starts -->
                            <div class="row pb-1 pt-md-2" >
                                <div class="col">
                                    <p>Disposal Method</p>
                                    <span>
                                    <div class="">
                                    <input type="text" value="<?php echo $row['disposal_method']?>" name="disposal_method" class="w-100" readonly>
                                    </span>
                                    
                                </div>
                            </div>
                            <!-- row 2 ends -->

                            <div class="row">
                                <div class="col-12">
                                    <p>Po Approved By Finance</p><span>
                                        <input type="text" value="<?php echo $row['po_approval_status']?>" name="po_approval_status" class="w-100" readonly>
                                    </span>
                                </div>
                            </div>


                        

                           
                        </div>


                        <!-- <div class="row pt-3">
                                <div class="col">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-sm btn-dark" name="submit">Submit</button>
                                    </div>
                                </div>
                            </div> -->
                    </div>
                    <?php
                    include 'dbconfig.php';
                    
                    // Check if form is submitted
                    if (isset($_POST['submit'])) {
                        // Retrieve form data
                        $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                        $name =  $_SESSION['fullname'];
                    
                        $f_dc_name = isset($_POST['dc_name']) && $_POST['dc_name'] !== $row['dc_name'] ? $_POST['dc_name'] : $row['dc_name'];
                        $f_dc_asset_number = isset($_POST['dc_asset_number']) && $_POST['dc_asset_number'] !== $row['dc_asset_number'] ? $_POST['dc_asset_number'] : $row['dc_asset_number'];
                        $f_dc_date_of_purchase = isset($_POST['dc_date_of_purchase']) && $_POST['dc_date_of_purchase'] !== $row['dc_date_of_purchase'] ? $_POST['dc_date_of_purchase'] : $row['dc_date_of_purchase'];

                        $f_dc_quantity = isset($_POST['dc_quantity']) && $_POST['dc_quantity'] !== $row['dc_quantity'] ? $_POST['dc_quantity'] : $row['dc_quantity'];
                        $f_dc_brand_specification = isset($_POST['dc_brand_specification']) && $_POST['dc_brand_specification'] !== $row['dc_brand_specification'] ? $_POST['dc_brand_specification'] : $row['dc_brand_specification'];
                        $f_dc_disposition_date = isset($_POST['dc_disposition_date']) && $_POST['dc_disposition_date'] !== $row['dc_disposition_date'] ? $_POST['dc_disposition_date'] : $row['dc_disposition_date'];

                        $f_dc_original_value = isset($_POST['dc_original_value']) && $_POST['dc_original_value'] !== $row['dc_original_value'] ? $_POST['dc_original_value'] : $row['dc_original_value'];
                        $f_dc_depreciation_value= isset($_POST['dc_depreciation_value']) && $_POST['dc_depreciation_value'] !== $row['dc_depreciation_value'] ? $_POST['dc_depreciation_value'] : $row['dc_depreciation_value'];
                        $f_dc_networth = isset($_POST['dc_networth']) && $_POST['dc_networth'] !== $row['dc_networth'] ? $_POST['dc_networth'] : $row['dc_networth'];
                       
                        $f_disposal_reason = isset($_POST['disposal_reason']) && $_POST['disposal_reason'] !== $row['disposal_reason'] ? $_POST['disposal_reason'] : $row['disposal_reason'];
                        $f_department_head_opinion = isset($_POST['department_head_opinion']) && $_POST['department_head_opinion'] !== $row['department_head_opinion'] ? $_POST['department_head_opinion'] : $row['department_head_opinion'];
                        $f_disposal_method = isset($_POST['disposal_method']) && $_POST['disposal_method'] !== $row['disposal_method'] ? $_POST['disposal_method'] : $row['disposal_method'];

                        $f_po_approval_status = isset($_POST['po_approval_status']) && $_POST['po_approval_status'] !== $row['po_approval_status'] ? $_POST['po_approval_status'] : $row['po_approval_status'];

     

                      
                        $update_query = "UPDATE fixed_assets_disposal_form SET 
                    
                                          dc_name = '$f_dc_name',
                                          dc_asset_number = '$f_dc_asset_number',
                                         dc_date_of_purchase = '$dc_date_of_purchase',

                                          dc_quantity = '$f_dc_quantity',
                                          dc_brand_specification = '$f_dc_brand_specification',
                                          dc_disposition_date = '$f_dc_disposition_date',

                                          dc_original_value = '$f_dc_original_value',
                                          dc_depreciation_value = '$f_dc_depreciation_value',
                                          dc_networth = '$f_dc_networth',

                                          disposal_reason = '$f_disposal_reason',
                                          department_head_opinion = '$f_department_head_opinion',

                                         disposal_method = '$f_disposal_method',
                                          po_approval_status = '$f_po_approval_status'

                
                                         
                    
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