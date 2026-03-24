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
        <title>Bonus Form - Invoice number</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <style>
            #dataTableCont {
            overflow-x: auto;
            overflow-y: auto;
            max-height: 600px; /* Adjust height as needed */
            white-space: nowrap;
            }
            #myTable th, #myTable td {
            min-width: 130px; /* Adjust as needed for wider columns */
            vertical-align: top;
            }
        </style>
        <style>
            body {
            font-family: 'Poppins', sans-serif;
            }
            .btn{
            font-size: 11px;
            border-radius:0px;
            color:white!important;
            }
            .btn-danger , .btn-success , input{
            font-size: 10px!important;
            }
        </style>
        <style>
            th{
            font-size: 10.5px!important;
            border:none!important;
            background-color: #0D9276!important;
            color:white!important;
            }
            td{
            font-size: 10px!important;
            border:1px solid black;
            background-color: #FFFFFF!important;
            }
        </style>
        <link rel="stylesheet" href="assets/css/style.css">
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
        <div class="wrapper d-flex align-items-stretch">
            <?php
                include 'sidebar1.php';
                ?>
            <div id="content">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                        </button>
                    </div>
                </nav>
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <a class="btn btn-dark btn-sm" href="bonus_approval_home.php" style="font-size:11px!important"><i class="fa-solid fa-arrow-left"></i> Home</a>
                            <input id="filter" type="text" class="form-control w-25" placeholder="Search here..." style="height: 30px; display:inline;font-size:13px!important">
                            <?php
                                include 'dbconfig.php';
                                $id = $_SESSION['id'];
                                $name = $_SESSION['fullname'];
                                $email = $_SESSION['email'];
                                $username = $_SESSION['username'];
                                $password = $_SESSION['password'];
                                $gender = $_SESSION['gender'];
                                $department = $_SESSION['department'];
                                $role = $_SESSION['role'];
                                $email = $_SESSION['email'];
                                
                                $be_depart = $_SESSION['be_depart'];
                                $bc_role = $_SESSION['be_role'];
                                
                                // $select = "SELECT * FROM workorder_form where username = '$username'";
                                $select = "SELECT * FROM bonus_form WHERE 
                                name = '$name' AND
                                ho_status = 'Approved' AND
                                zsm_status = 'Approved' AND
                                invoice_number = ''
                                ORDER BY date DESC";
                                
                                $select_q = mysqli_query($conn,$select);
                                $data = mysqli_num_rows($select_q);
                                ?>
                            <div id="dataTableCont">
                                <table class="table  table-bordered mt-1 table-striped" id="myTable" style="background-color: #fefefe;box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
                                    <thead style="background-color:#8576FF;color:white">
                                        <tr>
                                            <th scope="col">Invoice</th>
                                            <th scope="col">Ref&nbsp;No</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Depot</th>
                                            <th scope="col">Town</th>
                                            <th scope="col">Cust&nbsp;Name</th>
                                            <th scope="col">Cust&nbsp;Code</th>
                                            <th scope="col">Products</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Actual&nbsp;B</th>
                                            <th scope="col">Additional&nbsp;B</th>
                                            <th scope="col">Total&nbsp;B</th>
                                            <th scope="col">Gift</th>
                                            <th scope="col">Withdrawal</th>
                                            <th scope="col">Remarks</th>
                                            <th scope="col">Approval</th>
                                        </tr>
                                    </thead>
                                    <tbody class="searchable">
                                        <?php 
                                            if ($data) {
                                                while ($row = mysqli_fetch_array($select_q)) {
                                                    $products = array();
                                                    $quantities = array();
                                                    $actual = array();
                                                    $additional_bonuses = array();
                                                    $total_bonuses = array();
                                                    $gifts = array();
                                                    $withdrawal = array();
                                                    $remarks = array();
                                                    
                                                    for ($i = 1; $i <= 6; $i++) {
                                                        if (!empty($row['products_' . $i])) {
                                                            $products[] = $row['products_' . $i];
                                                            $quantities[] = $row['order_qty_' . $i];
                                                            $actual[] = $row['actual_bonus_' . $i];
                                                            $additional_bonuses[] = $row['additional_bonus_' . $i];
                                                            $total_bonuses[] = $row['total_bonus_' . $i];
                                                            $gifts[] = $row['gift_' . $i];
                                                            $withdrawal[] = $row['withdrawal_' . $i];
                                                            $remarks[] = $row['remarks_' . $i];
                                                        }
                                                    }
                                                    ?>
                                        <tr>
                                            <td>
                                                <form method="post" class="d-flex align-items-center">
                                                    <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                                                    <input type="text" name="invoice_number_<?php echo $row['id']; ?>" placeholder="Enter Invoice Number" required>
                                                    <button class="btn btn-success btn-sm" type="submit" name="invoice_number_btn_<?php echo $row['id']; ?>">✓</button>
                                                </form>
                                                <?php
                                                    include 'dbconfig.php';
                                                    date_default_timezone_set("Asia/Karachi");
                                                    $invoice_date =  date('Y-m-d H:i:s');
                                                    $fname = $_SESSION['fullname'];
                                                    
                                                    
                                                    if (isset($_POST['invoice_number_btn_' . $row['id']])) {
                                                    
                                                        $invoice_number = $_POST['invoice_number_' . $row['id']];
                                                        // $reqid = $row['id'];
                                                        $reqid = $_POST['request_id'];
                                                    
                                                        $update = "UPDATE bonus_form SET invoice_number = '$invoice_number' ,invoice_date = '$invoice_date' WHERE id = '$reqid'";
                                                                                $update_q = mysqli_query($conn, $update);
                                                        if ($update_q) {
                                                            ?>
                                                <script type="text/javascript">
                                                    // alert("Budget has been approved");
                                                    location.reload();
                                                    // header("location:workorder_engineering_closeout.php");
                                                </script>
                                                <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                <script type="text/javascript">
                                                    alert("failed!");
                                                    location.reload();
                                                    // header("location:workorder_engineering_closeout.php");
                                                </script>
                                                <?php
                                                    }
                                                    }
                                                    
                                                    ?>
                                            </td>
                                            <td><?php echo $row['custom_id']; ?></td>
                                            <td><?php echo $row['date']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['depot']; ?></td>
                                            <td><?php echo $row['customer_name']; ?></td>
                                            <td><?php echo implode('<br>', $products); ?></td>
                                            <td><?php echo implode('<br>', $quantities); ?></td>
                                            <td><?php echo implode('<br>', $actual); ?></td>
                                            <td><?php echo implode('<br>', $additional_bonuses); ?></td>
                                            <td><?php echo implode('<br>', $total_bonuses); ?></td>
                                            <td><?php echo implode('<br>', $gifts); ?></td>
                                            <td><?php echo $row['ho_msg']; ?><br><?php echo $row['zsm_msg']; ?></td>
                                        </tr>
                                    </tbody>
                                    <?php
                                        }
                                        }
                                        else{
                                        echo "No record found!";
                                        }
                                        ?>
                                </table>
                            </div>
                        </div>
                        <!--ander ka kaam khatam-->
                    </div>
                </div>
            </div>
        </div>
        <!--page content-->
        </div> <!--wrapper-->
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
            $('#myTable').tableExport({ type: 'excel'});
            //$('#table_report').tableExport({ type: 'excel',escape:'false',ignoreColumn: [15]});
            });
            });
        </script>
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