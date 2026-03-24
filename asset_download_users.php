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
        <title>Assets - Download</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <!-- Our Custom CSS -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
        <!-- Font Awesome JS -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
        <style>
            .btn-menu{
            font-size: 11px!important;
            border-radius: 0px!important;
            }
            .table{
            height:10px!important;
            }
            .btn{
            font-size: 11px!important;
            border-radius: 0px!important;
            }
            th{
            font-size: 10.5px!important;
            border:none!important;
            }
            td{
            font-size: 10.5px!important;
            background-color:White!important;
            color:black!important;
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
        <div class="wrapper d-flex align-items-stretch">
            <?php
                include 'sidebar1.php';
                ?>
            <div id="content">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-info btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                        </button>
                    </div>
                </nav>
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                        <div class="d-flex justify-content-between align-items-center" style="background-color:white;">
    <!-- Left: Home Button -->
    <div>
        <a class="btn btn-dark btn-sm" href="assets_management_home.php" style="font-size:11px!important">
            <i class="fa-solid fa-arrow-left"></i> Home
        </a>
    </div>

    <!-- Center: Heading -->
    <div class="mx-auto text-center">
        <a href="export_assets_excel.php" class="btn btn-success" style="font-size:25px!important">
            Download On Excel
        </a>
    </div>

    <!-- Right: Placeholder to balance layout -->
    <div style="width:80px;"></div> <!-- Adjust width to match Home button size -->
</div>




                            </div>
                        </div>
                        <!-- col -->
                    </div>
                    <!-- row -->
                    <!-- Assets Main Start -->
                    <div class="row">
                        <div class="col">
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
                                
                                $select = "SELECT * FROM assets";
                                
                                $select_q = mysqli_query($conn,$select);
                                $data = mysqli_num_rows($select_q);
                                   ?>
                            <table  class="table table-responsive" id="myTable1" style="visibility: hidden">
                                <thead style="background-color:#0D9276;color:white">
                                    <tr id="row_<?php echo $row['id']; ?>">
                                        <th scope="col">Id</th>
                                        <th scope="col">S.no</th>
                                        <th scope="col">Part&nbsp;Of&nbsp;far</th>
                                        <th scope="col">Remarks</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Comments</th>
                                        <th scope="col">Part&nbsp;Of&nbsp;Machine</th>
                                        <th scope="col">Old&nbsp;Code</th>
                                        <th scope="col">New&nbsp;Code</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Department1</th>
                                        <th scope="col">Asset Location</th>
                                        <th scope="col">Purchase Date</th>
                                        <th scope="col">Asset Class</th>
                                        <th scope="col">No Of Units</th>
                                        <th scope="col">Model</th>
                                        <th scope="col">Usage</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Remarks2</th>
                                        <th scope="col">Part of far2</th>
                                        <th scope="col">Department2</th>
                                        <th scope="col">Unique Nuim</th>
                                        <th scope="col">Item Description</th>
                                        <th scope="col">Balances</th>
                                        <th scope="col">Supplier Name</th>
                                        <th scope="col">Department Name</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Invoice Date</th>
                                        <th scope="col">Invoice Number</th>
                                        <th scope="col">Original Amount</th>
                                        <th scope="col">Available Amount</th>
                                        <th scope="col">Asset Tag Number</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Cost</th>
                                        <th scope="col">Comments</th>
                                        <!-- dispose starts  -->
                                        <th scope="col">dc_disposal_department</th>
                                        <th scope="col">dc_applicant</th>
                                        <th scope="col">dc_email</th>
                                        <th scope="col">dc_date_of_application</th>
                                        <th scope="col">dc_name</th>
                                        <th scope="col">dc_asset_number</th>
                                        <th scope="col">dc_date_of_purchase</th>
                                        <th scope="col">dc_quantity</th>
                                        <th scope="col">dc_brand_specification</th>
                                        <th scope="col">dc_disposition_date</th>
                                        <th scope="col">dc_original_value</th>
                                        <th scope="col">dc_depreciation_value</th>
                                        <th scope="col">dc_networth</th>
                                        <th scope="col">dc_disposal_reason</th>
                                        <th scope="col">dc_department_head_opinion	</th>
                                        <th scope="col">dc_finance_status</th>
                                        <th scope="col">dc_finance_date</th>
                                        <th scope="col">dc_finance_msg</th>
                                        <th scope="col">dc_po_approval_status</th>
                                        <th scope="col">dc_reason</th>
                                        <th scope="col">dc_status</th>
                                        <th scope="col">dc_jv_status</th>
                                        <th scope="col">dc_disposal_jv_no</th>
                                        <!-- dispose ends -->
                                        <!-- transfer starts  -->
                                        <th scope="col">at_rc_name</th>
                                        <th scope="col">at_rc_no</th>
                                        <th scope="col">at_department</th>
                                        <th scope="col">at_date_1</th>
                                        <th scope="col">at_transfer_prepared_by</th>
                                        <th scope="col">at_date_prepared</th>
                                        <th scope="col">at_address</th>
                                        <th scope="col">at_asset_tag_number</th>
                                        <th scope="col">at_qty</th>
                                        <th scope="col">at_s_no</th>
                                        <th scope="col">at_description</th>
                                        <th scope="col">at_cost</th>
                                        <th scope="col">at_bldg</th>
                                        <th scope="col">at_room</th>
                                        <th scope="col">at_owner_code</th>
                                        <th scope="col">at_comments</th>
                                        <th scope="col">at_user_name</th>
                                        <th scope="col">at_user_date</th>
                                        <th scope="col">at_user_department</th>
                                        <th scope="col">at_finance_status</th>
                                        <th scope="col">at_finance_msg</th>
                                        <th scope="col">at_finance_date</th>
                                        <th scope="col">at_po_approve_status</th>
                                        <th scope="col">at_status</th>
                                        <th scope="col">at_reason</th>
                                        <th scope="col">at_receiver_msg</th>
                                        <th scope="col">at_receiver_status</th>
                                        <th scope="col">at_receiver_date</th>
                                        <th scope="col">final_status</th>
                                        <!-- transfer ends -->
                                    </tr>
                                </thead>
                                <?php 
                                    if($data){
                                    while ($row=mysqli_fetch_array($select_q)) {
                                        ?>
                                <tbody class="searchable">
                                    <tr id="row_<?php echo $row['id']; ?>">
                                        <td><?php echo $row['id']?>  </td>
                                        <td><?php echo $row['s_no']?></td>
                                        <td><?php echo $row['part_of_far']?></td>
                                        <td><?php echo $row['remarks']?></td>
                                        <td><?php echo $row['type']?>  </td>
                                        <td><?php echo $row['comments']?></td>
                                        <td><?php echo $row['part_of_machine']?></td>
                                        <td><?php echo $row['old_code']?></td>
                                        <td><?php echo $row['new_code']?>  </td>
                                        <td><?php echo $row['name_description']?></td>
                                        <td><?php echo $row['department1']?></td>
                                        <td><?php echo $row['asset_location']?></td>
                                        <td><?php echo $row['purchase_date']?>  </td>
                                        <td><?php echo $row['asset_class']?></td>
                                        <td><?php echo $row['no_of_units']?></td>
                                        <td><?php echo $row['model']?></td>
                                        <td><?php echo $row['usage']?>  </td>
                                        <td><?php echo $row['amount']?></td>
                                        <td><?php echo $row['status']?></td>
                                        <td><?php echo $row['remarks2']?></td>
                                        <td><?php echo $row['part_of_far2']?>  </td>
                                        <td><?php echo $row['department2']?></td>
                                        <td><?php echo $row['unique_nuim']?></td>
                                        <td><?php echo $row['item_description']?></td>
                                        <td><?php echo $row['balances']?>  </td>
                                        <td><?php echo $row['supplier_name']?></td>
                                        <td><?php echo $row['department_name']?></td>
                                        <td><?php echo $row['category']?></td>
                                        <td><?php echo $row['invoice_date']?>  </td>
                                        <td><?php echo $row['invoice_number']?></td>
                                        <td><?php echo $row['original_amount']?></td>
                                        <td><?php echo $row['available_amount']?></td>
                                        <td><?php echo $row['asset_tag_number']?>  </td>
                                        <td><?php echo $row['quantity']?></td>
                                        <td><?php echo $row['location']?></td>
                                        <td><?php echo $row['cost']?></td>
                                        <td><?php echo $row['comments']?></td>
                                        <!-- disposal start  -->
                                        <td><?php echo $row['dc_disposal_department']?></td>
                                        <td><?php echo $row['dc_applicant']?></td>
                                        <td><?php echo $row['dc_email']?></td>
                                        <td><?php echo $row['dc_date_of_application']?></td>
                                        <td><?php echo $row['dc_name']?></td>
                                        <td><?php echo $row['dc_asset_number']?></td>
                                        <td><?php echo $row['dc_date_of_purchase']?></td>
                                        <td><?php echo $row['dc_quantity']?></td>
                                        <td><?php echo $row['dc_brand_specification']?></td>
                                        <td><?php echo $row['dc_disposition_date']?></td>
                                        <td><?php echo $row['dc_original_value']?></td>
                                        <td><?php echo $row['dc_depreciation_value']?></td>
                                        <td><?php echo $row['dc_networth']?></td>
                                        <td><?php echo $row['dc_disposal_reason']?></td>
                                        <td><?php echo $row['dc_department_head_opinion']?></td>
                                        <td><?php echo $row['dc_finance_status']?></td>
                                        <td><?php echo $row['dc_finance_date']?></td>
                                        <td><?php echo $row['dc_finance_msg']?></td>
                                        <td><?php echo $row['dc_po_approval_status']?></td>
                                        <td><?php echo $row['dc_reason']?></td>
                                        <td><?php echo $row['dc_status']?></td>
                                        <td><?php echo $row['dc_jv_status']?></td>
                                        <td><?php echo $row['dc_disposal_jv_no']?></td>
                                        <!-- dispose ends -->
                                        <!-- transfer starts  -->
                                        <td><?php echo $row['at_rc_name']?></td>
                                        <td><?php echo $row['at_rc_no']?></td>
                                        <td><?php echo $row['at_department']?></td>
                                        <td><?php echo $row['at_date_1']?></td>
                                        <td><?php echo $row['at_transfer_prepared_by']?></td>
                                        <td><?php echo $row['at_date_prepared']?></td>
                                        <td><?php echo $row['at_address']?></td>
                                        <td><?php echo $row['at_asset_tag_number']?></td>
                                        <td><?php echo $row['at_qty']?></td>
                                        <td><?php echo $row['at_s_no']?></td>
                                        <td><?php echo $row['at_description']?></td>
                                        <td><?php echo $row['at_cost']?></td>
                                        <td><?php echo $row['at_bldg']?></td>
                                        <td><?php echo $row['at_room']?></td>
                                        <td><?php echo $row['at_owner_code']?></td>
                                        <td><?php echo $row['at_comments']?></td>
                                        <td><?php echo $row['at_user_name']?></td>
                                        <td><?php echo $row['at_user_date']?></td>
                                        <td><?php echo $row['at_user_department']?></td>
                                        <td><?php echo $row['at_finance_status']?></td>
                                        <td><?php echo $row['at_finance_msg']?></td>
                                        <td><?php echo $row['at_finance_date']?></td>
                                        <td><?php echo $row['at_po_approve_status']?></td>
                                        <td><?php echo $row['at_status']?></td>
                                        <td><?php echo $row['at_reason']?></td>
                                        <td><?php echo $row['at_receiver_msg']?></td>
                                        <td><?php echo $row['at_receiver_status']?></td>
                                        <td><?php echo $row['at_receiver_date']?></td>
                                        <td><?php echo $row['final_status']?></td>
                                        <!-- transfer ends -->
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
                            <!-- Assets Main End -->
                        </div>
                        <!-- col -->
                    </div>
                    <!-- row -->
                    <!-- Assets Main End -->
                </div>
                <!-- container -->
            </div>
            <!--page content-->
        </div>
        <!--wrapper-->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
        <script type="text/javascript" src="libs/js-xlsx/xlsx.core.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar').toggleClass('active');
                });
            });
        </script>
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
        <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
        <script type="text/javascript">
            document.getElementById('excel1').addEventListener('click', function() {
                var table = document.getElementById('myTable1');
                var workbook = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
                XLSX.writeFile(workbook, 'export.xlsx');
            });
        </script>
    </body>
</html>