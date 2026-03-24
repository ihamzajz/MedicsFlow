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
        <title>Asset Receipt Form - Details</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


        <link rel="stylesheet" href="assets/css/style.css">
        <style>
            body {
font-family: 'Poppins', sans-serif;
}
.btn{
            font-size: 11px!important;
            color:white!important;
            border-radius:0px!important;
            }
            input::placeholder {
            color: black!important; /* Placeholder text color */
            }
        </style>
        <style>
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
            p{
            font-size: 12.5px!important;
            padding: 0px!important;
            margin: 0px!important;
            font-weight: 500;
            }
        </style>
        <style>
            a{
            text-decoration:none;
            color:white;
            }
            a:hover{
            text-decoration:none;
            color:white;
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
            input{
            font-size: 11.5px;
            background-color:#f2f2f2;
            padding-top: 2px;
            padding-bottom: 2px;
            padding-left: 5px;
            border: 1px solid black;
            }
            textarea {
            font-size: 12px; 
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
            $select = "SELECT * FROM assets WHERE
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
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-xl-10 p-5" style="background-color:White;border:1px solid black">
                            <h6 class="text-center pb-3 font-weight-bold"><span style="float:left"><a class="btn btn-dark btn-sm" href="assets_management_home.php" style="font-size:11px!important"><i class="fa-solid fa-arrow-left"></i> Home</a></span> Asset Receipt Form # <?php echo $row['id']?></h6>
                            <!-- row 0 starts -->
                            <div class="row pb-2 pt-2" >
                                <div class="col-md-4">
                                    <p>Purchase Date</p>
                                    <input type="text" value="<?php echo $row['purchase_date']; ?>" name="purchase_date" class="w-100" readonly>
                                </div>
                                <div class="col-md-4">
                                    <p>Invoice Number</p>
                                    <input type="text" value="<?php echo $row['invoice_number']; ?>" name="invoice_number" class="w-100" readonly>
                                </div>
                            </div>
                            <div class="row pb-3" >
                                <div class="col-md-4">
                                    <p>Asset Location</p>
                                    <input type="text" value="<?php echo $row['asset_location']; ?>" name="asset_location" class="w-100" readonly>
                                </div>
                                <div class="col-md-4">
                                    <p>Supplier Name</p>
                                    <input type="text" value="<?php echo $row['supplier_name']; ?>" name="supplier_name" class="w-100" readonly>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col-md-4">
                                    <p>Asset tag number</p>
                                    <input type="text" value="<?php echo $row['asset_tag_number']; ?>" name="asset_tag_number" class="w-100" readonly>
                                </div>
                                <div class="col-md-4">
                                    <p>Quantity</p>
                                    <input type="text" value="<?php echo $row['quantity']; ?>"  name="quantity"  class="w-100" readonly>
                                </div>
                                <div class="col-md-4">
                                    <p>Serial Number</p>
                                    <input type="text" value="<?php echo $row['s_no']; ?>"  name="s_no" class="w-100" readonly>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col">
                                    <p>Name/Description</p>
                                    <input type="text" value="<?php echo $row['name_description']; ?>"  name="name_description" class="w-100" readonly>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col-md-4">
                                    <p>Model</p>
                                    <td>
                                        <input type="text" value="<?php echo $row['model']; ?>"  name="model" class="w-100" readonly>
                                    </td>
                                </div>
                                <div class="col-md-4">
                                    <p>Capacity/Usage</p>
                                    <td> <input type="text" value="<?php echo $row['usage']; ?>"  name="usage" class="w-100" readonly></td>
                                </div>
                                <div class="col-md-4">
                                    <p>Cost</p>
                                    <td><input type="text" value="<?php echo $row['cost']; ?>"  name="cost" class="w-100" readonly></td>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col-md-4">
                                    <p>Location</p>
                                    <td><input type="text" value="<?php echo $row['location']; ?>"  name="location" class="w-100" readonly></td>
                                </div>
                                <div class="col-md-4">
                                    <p>Owner Code</p>
                                    <td> <input type="text" value="<?php echo $row['owner_code']; ?>"  name="owner_code" class="w-100" readonly></td>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col-12">
                                    <p>Comments</p>
                                    <td> <input type="text" value="<?php echo $row['comments']; ?>"  name="comments" class="w-100" readonly></td>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col-md-4">
                                    <p>PO Finance Approval</p>
                                    <td> <input type="text" value="<?php echo $row['po_approve_status']; ?>" name="po_approve_status" class="w-100" readonly></td>
                                </div>
                            </div>

                            <!-- <div class="row">
                                <div class="col">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-sm btn-dark" name="submit">Submit</button>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <form>
                    </div>
                    <?php
                    include 'dbconfig.php';
                    
                    // Check if form is submitted
                    if (isset($_POST['submit'])) {
                        // Retrieve form data
                        $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                        $name =  $_SESSION['fullname'];
                    
                        $f_purchase_date = isset($_POST['purchase_date']) && $_POST['purchase_date'] !== $row['purchase_date'] ? $_POST['purchase_date'] : $row['purchase_date'];
                        $f_invoice_number = isset($_POST['invoice_number']) && $_POST['invoice_number'] !== $row['invoice_number'] ? $_POST['invoice_number'] : $row['invoice_number'];
                        $f_asset_location = isset($_POST['asset_location']) && $_POST['asset_location'] !== $row['asset_location'] ? $_POST['asset_location'] : $row['asset_location'];

                        $f_supplier_name = isset($_POST['supplier_name']) && $_POST['supplier_name'] !== $row['supplier_name'] ? $_POST['supplier_name'] : $row['supplier_name'];
                        $f_asset_tag_number = isset($_POST['asset_tag_number']) && $_POST['asset_tag_number'] !== $row['asset_tag_number'] ? $_POST['asset_tag_number'] : $row['asset_tag_number'];
                        $f_quantity = isset($_POST['quantity']) && $_POST['quantity'] !== $row['quantity'] ? $_POST['quantity'] : $row['quantity'];

                        $f_s_no = isset($_POST['s_no']) && $_POST['s_no'] !== $row['s_no'] ? $_POST['s_no'] : $row['s_no'];
                        $f_name_description = isset($_POST['name_description']) && $_POST['name_description'] !== $row['name_description'] ? $_POST['name_description'] : $row['name_description'];
                        $f_model = isset($_POST['model']) && $_POST['model'] !== $row['model'] ? $_POST['model'] : $row['model'];

                        $f_usage = isset($_POST['usage']) && $_POST['usage'] !== $row['usage'] ? $_POST['usage'] : $row['usage'];
                        $f_cost = isset($_POST['cost']) && $_POST['cost'] !== $row['cost'] ? $_POST['cost'] : $row['cost'];
                        $f_location = isset($_POST['location']) && $_POST['location'] !== $row['location'] ? $_POST['location'] : $row['location'];

                        $f_owner_code= isset($_POST['owner_code']) && $_POST['owner_code'] !== $row['owner_code'] ? $_POST['owner_code'] : $row['owner_code'];
                        $f_comments = isset($_POST['comments']) && $_POST['comments'] !== $row['comments'] ? $_POST['comments'] : $row['comments'];
                        $f_po_approve_status = isset($_POST['po_approve_status']) && $_POST['po_approve_status'] !== $row['po_approve_status'] ? $_POST['po_approve_status'] : $row['po_approve_status'];


                      
                        $update_query = "UPDATE assets SET 
                    
                                          purchase_date = '$f_purchase_date',
                                          invoice_number = '$f_invoice_number',
                                          asset_location = '$f_asset_location',

                                          supplier_name = '$f_supplier_name',
                                          asset_tag_number = '$f_asset_tag_number',
                                          quantity = '$f_quantity',

                                          s_no = '$f_s_no',
                                          name_description = '$f_name_description',
                                          model = '$f_model',

                                          `usage` = '$f_usage',
                                          cost = '$f_cost',
                                          location = '$f_location',

                                          owner_code = '$f_owner_code',
                                          comments = '$f_comments',
                                          po_approve_status = '$f_po_approve_status'
                                         
                    
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