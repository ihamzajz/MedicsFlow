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
         .sub-by{
         font-weight:bold!important;
         }
         a
         {
         text-decoration:none;
         color:white
         }
         a:hover
         {
         text-decoration:none;
         color:white
         }
         p{
         margin: 0;
         margin-bottom: 2px;
         font-size: 13px!important;
         color: black;
         }
         input[type="text"] {
         font-size: 12px;
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
         <div class="row">
            <div class="col-12">
               <form class="form pb-3" method="POST">
                  <div class="container-fluid">
                     <!-- <button class="btn btn-sm btn-dark text-center"> <a href="asset_receipt_finance_edit.php">Back</a></button> -->
                     <div class="row">
                        <!-- col-1-starts -->
                        <div class="col-6 p-5"  Style="border:1px solid black; background-color:white">
                           <h5 class="text-center pb-3 font-weight-bold">Asset Receipt Form # <?php echo $row['id']?></h5>
                           <div class="pb-4">
                              <p class="sub-by">Submit by:</p>
                              <p>  <?php echo $row['user_name']?><span class="pl-3"> <?php echo $row['user_date']?></span></p>
                              <p>  <?php echo $row['user_department']?><span class="pl-3"><?php echo $row['user_role']?> </span></p>
                           </div>
                           <div class="row pb-2" >
                              
                              <div class="col-md-4">
                                 <p>Purchase Date</p>
                                 <input type="text" placeholder="<?php echo $row['purchase_date']?>" readonly class="w-100">
                              </div>
                              <div class="col-md-4">
                                 <p>Inovice Number</p>
                                 <input type="text" placeholder="<?php echo $row['invoice_number']?>" readonly class="w-100">
                              </div>
                           </div>
                           <div class="row pb-2 ">
               
                              <div class="col-md-4">
                                 <p>Asset Location</p>
                                 <input type="text" placeholder="<?php echo $row['location']?>" readonly class="w-100">
                              </div>
                              <div class="col-md-4">
                                 <p>Supplier Name</p>
                                 <input type="text" placeholder="<?php echo $row['supplier_name']?>" readonly class="w-100">
                              </div>
                           </div>
                           <h6 class="text-center py-3">Following Assets Received</h6>
                           <div class="row pb-2">
                              <div class="col-md-4">
                                 <p>Asset Tag Number</p>
                                 <input type="text" placeholder="<?php echo $row['asset_tag_number']?>" readonly class="w-100">
                              </div>
                              <div class="col-md-4">
                                 <p>Quantity</p>
                                 <input type="text" placeholder="<?php echo $row['quantity']?>" readonly class="w-100">
                              </div>
                              <div class="col-md-4">
                                 <p>Serial Number</p>
                                 <input type="text" placeholder="<?php echo $row['s_no']?>" readonly class="w-100">
                              </div>
                           </div>
                           <div class="row pb-2">
                              <div class="col">
                                 <p>Name/Description</p>
                                 <input type="text" placeholder="<?php echo $row['name_description']?>" readonly class="w-100">
                              </div>
                           </div>
                           <div class="row pb-2">
                              <div class="col-md-4">
                                 <p>Model</p>
                                 <input type="text" placeholder="<?php echo $row['model']?>" readonly class="w-100">
                              </div>
                              <div class="col-md-4">
                                 <p>Capacity/Usage</p>
                                 <input type="text" placeholder="<?php echo $row['usage']?>" readonly class="w-100">
                              </div>
                              <div class="col-md-4">
                                 <p>Cost</p>
                                 <input type="text" placeholder="<?php echo $row['cost']?>" readonly class="w-100">
                              </div>
                           </div>
                           <div class="row pb-2">
                              <div class="col-md-4">
                                 <p>Owner Code</p>
                                 <td>
                                    <input type="text" placeholder="<?php echo $row['owner_code']?>" readonly></td class="w-100">
                              </div>
                              <div class="col-md-4">
                              <p>Location</p>
                              <input type="text" placeholder="<?php echo $row['location']?>" readonly class="w-100">
                              </div>
                           </div>
                           <div class="row pb-2">
                           <div class="col-12">
                           <p>Comments</p>
                           <td> <input type="text" placeholder="<?php echo $row['comments']?>" readonly class="w-100"></td>
                           </div>
                           </div>
                           <div class="row pb-2">
                              <div class="col-12">
                                 <p>PO Finance Approval</p>
                                 <td> <input type="text" placeholder="<?php echo $row['po_approve_status']?>" readonly class="w-100"></td>
                              </div>
                           </div>
                        </div>
                        <!-- col-1-ends -->
                        <!-- col-1-starts -->
                        <div class="col-6 p-5"  Style="border:1px solid black; background-color:white">
                           <h5 class="text-center pb-3 font-weight-bold">Edit Data</h5>

                           <form method="POST" action="your_action_page.php">
    <div class="row pb-2 justify-content-center">
        <div class="col-md-4">
            <p>Grn</p>
            <input type="text" name="grn" class="w-100">
        </div>

        <div class="col-md-4">
            <p>PO Number</p>
            <input type="text" name="po_no" class="w-100">
        </div>
        <div class="col-md-4">
            <p>PO Date</p>
            <input type="date" name="po_date" class="w-100">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="text-center">
                <button type="submit" class="btn btn-sm btn-dark" name="submit">Submit</button>
            </div>
        </div>
    </div>
</form>

<?php
include 'dbconfig.php';

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Retrieve form data
    $id = $_GET['id'];  // Assuming 'id' is passed via GET method

    $grn = $_POST['grn'];
    $po_no = $_POST['po_no'];
    $po_date = $_POST['po_date'];
   

    // Update query
    $update_query = "UPDATE assets SET 
                      grn = '$grn',
                      po_no = '$po_no',
                      po_date = '$po_date',
                      grn_status = 'Approved',
                      po_no_status = 'Approved',
                      po_date_status = 'Approved'

                    WHERE id = '$id'";

    // Execute update query
    $result = mysqli_query($conn, $update_query);

    if ($result) {
        // Update successful
        echo "<script>alert('Record updated successfully!');</script>";
        // Redirect or perform additional actions as needed
    } else {
        // Update failed
        echo "<script>alert('Update failed!');</script>";
        // Redirect or handle error as needed
    }
}
?>
               </div>
               </div> 
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
            </div>
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