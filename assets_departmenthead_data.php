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
        <title>Asset Data</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <style>
            body {
font-family: 'Poppins', sans-serif;
}

            .btn{
                font-size: 11px!important;
                color:white!important;
                border-radius:0px!important
            }
            p{
            font-size: 13px;
            padding: 2px;
            margin:0px;
            }
            .modal-dialog.modal-fullscreen {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            max-width: none;
            }
            .modal-content {
            height: 100%;
            border-radius: 0;
            }
            h6{
            font-size: 16px!important;
            }
            th.hidden, td.hidden {
            display: none;
            }
            .btn-dark,.btn-success,.btn-danger, .btn-info{
            font-size: 11px;
            }
            .labelm {
            font-size: 11px;
            font-weight: bold;
            }
            select,  select option , input[type=date]{
            font-size: 13px!important;
            height:10px:!important;
            }
        </style>
        <style>
            .heading-main{
            padding-top: 10px;
            padding-bottom: 10px;
            font-size: 22px;
            font-weight:700;
            color: white;
            background-color: #8576FF;
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
            color:black;
            padding:1px!important;
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
               
                <div class="row pb-2">
           
                 
        
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
                        $select = "SELECT * FROM assets_main where department_be = '$be_depart' ";
                        
                        $select_q = mysqli_query($conn,$select);
                        $data = mysqli_num_rows($select_q);
                           ?>

                           <h6 class="text-center"><span style="float:left"><a class="btn btn-dark btn-sm" href="assets_management_home.php" style="font-size:11px!important"><i class="fa-solid fa-arrow-left"></i> Home</a></span>Department Data</h6>
                    <div class="table-responsive">
                        <table  class="table table-responsive" id="myTable" >
                            <thead style="background-color:#0d9276;color:white">
                                <tr id="row_<?php echo $row['id']; ?>">
                                    <th scope="col">Id</th>
                                    <th scope="col">S.no</th>
                                    <th scope="col">Part&nbsp;Of&nbsp;far</th>
                                    <th scope="col">Name/Discription</th>
                                    <th scope="col">Department1</th>
                                    <th scope="col">Asset&nbsp;Location</th>
                                    <th scope="col">Number&nbsp;of&nbsp;unit</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Comments</th>
                                    <th scope="col">Part&nbsp;Of&nbsp;Machine</th>
                                    <th scope="col">Old&nbsp;Code</th>
                                    <th scope="col">New&nbsp;Code</th>
                                    <th scope="col">Purchase&nbsp;Date</th>
                                    <th scope="col">Asset&nbsp;Class</th>
                                    <th scope="col">Model</th>
                                    <th scope="col">Usage</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Remarts2</th>
                                    <th scope="col">Part&nbsp;of&nbsp;far2</th>
                                    <!-- <th scope="col" style="background-color:#1A2130;color:white;font-size:11px!important;text-align:center">Finance Input</th> -->
                                    <th>Department2</th>
                                    <th>Unique&nbsp;Nuim</th>
                                    <th>Item&nbsp;Discription</th>
                                    <th>Balances</th>
                                    <th>Supplier&nbsp;Name</th>
                                    <th>Department&nbsp;Name</th>
                                    <th>Category</th>
                                    <th>Invoice&nbsp;Date</th>
                                    <th>Invoice&nbsp;Number</th>
                                    <th>Orignal&nbsp;Amount</th>
                                    <th>Available&nbsp;Amount</th>
                                    <th>Asset&nbsp;tag&nbsp;number</th>
                                    <th>quantity</th>
                                    <th>Location</th>
                                    <th>Cost</th>
                                    <th>Owner&nbsp;Code</th>
                                </tr>
                            </thead>
                            <?php 
                                if($data){
                                  while ($row=mysqli_fetch_array($select_q)) {
                                    ?>
                            <tbody class="searchable">
                                <tr id="row_<?php echo $row['id']; ?>">
                                    <td><?php echo $row['id']?></td>
                                    <td><?php echo $row['s_no']?></td>
                                    <td><?php echo $row['part_of_far']?></td>
                                    <td><?php echo $row['name_description']?></td>
                                    <td><?php echo $row['department1']?></td>
                                    <td><?php echo $row['asset_location']?></td>
                                    <td><?php echo $row['no_of_units']?></td>
                                    <td><?php echo $row['remarks']?></td>
                                    <td><?php echo $row['type']?></td>
                                    <td><?php echo $row['comments']?></td>
                                    <td><?php echo $row['part_of_machine']?></td>
                                    <td><?php echo $row['old_code']?></td>
                                    <td><?php echo $row['new_code']?></td>
                                    <td><?php echo $row['purchase_date']?></td>
                                    <td><?php echo $row['asset_class']?></td>
                                    <td><?php echo $row['model']?></td>
                                    <td><?php echo $row['usage']?></td>
                                    <td><?php echo $row['amount']?></td>
                                    <td><?php echo $row['status']?></td>
                                    <td><?php echo $row['remarks2']?></td>
                                    <td><?php echo $row['part_of_far2']?></td>
                                    <td><?php echo $row['department2']?></td>
                                    <td><?php echo $row['unique_nuim']?></td>
                                    <td><?php echo $row['item_description']?></td>
                                    <td><?php echo $row['balances']?></td>
                                    <td><?php echo $row['supplier_name']?></td>
                                    <td><?php echo $row['department_name']?></td>
                                    <td><?php echo $row['category']?></td>
                                    <td><?php echo $row['invoice_date']?></td>
                                    <td><?php echo $row['invoice_number']?></td>
                                    <td><?php echo $row['original_amount']?></td>
                                    <td><?php echo $row['available_amount']?></td>
                                    <td><?php echo $row['asset_tag_number']?></td>
                                    <td><?php echo $row['quantity']?></td>
                                    <td><?php echo $row['location']?></td>
                                    <td><?php echo $row['cost']?></td>
                                    <td><?php echo $row['owner_code']?></td>
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
            </div>
            <!--page content-->
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
        <!-- <script type="text/javascript">
            $(document).ready(function() {
            $('#excel').click(function() {
            $('#myTable').tableExport({ type: 'excel'});
            //$('#table_report').tableExport({ type: 'excel',escape:'false',ignoreColumn: [15]});
            });
            });
            </script> -->
        <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
        <script type="text/javascript">
            document.getElementById('excel').addEventListener('click', function() {
                var table = document.getElementById('myTable');
                var workbook = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
                XLSX.writeFile(workbook, 'export.xlsx');
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
        <!-- <script>
            function applyFilters() {
                var fromDate = document.getElementById("fromDate").value;
                var toDate = document.getElementById("toDate").value;
                var taskStatus = document.getElementById("taskStatus").value.toLowerCase().trim();
                var taskDepartment = document.getElementById("taskDepartment").value.toLowerCase().trim();
                var table = document.getElementById("myTable");
                var tr = table.getElementsByTagName("tr");
            
                for (var i = 1; i < tr.length; i++) {
                    var tdDate = tr[i].getElementsByTagName("td")[5];
                    var tdStatus = tr[i].getElementsByTagName("td")[0];
                    var tdDepartment = tr[i].getElementsByTagName("td")[3];
                    var dateValue = tdDate.textContent || tdDate.innerText;
                    var statusValue = tdStatus.textContent || tdStatus.innerText;
                    var departmentValue = tdDepartment.textContent || tdDepartment.innerText;
                    var showRow = true;
                    var date = new Date(dateValue);
                    var from = fromDate ? new Date(fromDate) : null;
                    var to = toDate ? new Date(toDate) : null;
            
                    if (from && date < from) {
                        showRow = false;
                    }
                    if (to && date > to) {
                        showRow = false;
                    }
                    if (fromDate && toDate && fromDate === toDate && dateValue !== fromDate) {
                        showRow = false;
                    }
                    if (taskStatus !== "all" && statusValue.trim().toLowerCase() !== taskStatus) {
                        showRow = false;
                    }
                    if (taskDepartment !== "all" && departmentValue.trim().toLowerCase() !== taskDepartment) {
                        showRow = false;
                    }
            
                    if (showRow) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
            </script> -->
        <script>
            function applyFilters() {
                var fromDate = document.getElementById("fromDate").value;
                var toDate = document.getElementById("toDate").value;
                var taskStatus = document.getElementById("taskStatus").value.toLowerCase().trim();
                var taskDepartment = document.getElementById("taskDepartment").value.toLowerCase().trim();
                var table = document.getElementById("myTable");
                var tr = table.getElementsByTagName("tr");
            
                for (var i = 1; i < tr.length; i++) {
                    var tdDate = tr[i].getElementsByTagName("td")[5];
                    var tdStatus = tr[i].getElementsByTagName("td")[0];
                    var tdDepartment = tr[i].getElementsByTagName("td")[3];
                    var dateValue = tdDate.textContent || tdDate.innerText;
                    var statusValue = tdStatus.textContent || tdStatus.innerText;
                    var departmentValue = tdDepartment.textContent || tdDepartment.innerText;
                    var showRow = true;
                    var date = new Date(dateValue);
                    var from = fromDate ? new Date(fromDate) : null;
                    var to = toDate ? new Date(toDate) : null;
            
                    // Ensure the date is valid
                    if (!isNaN(date)) {
                        if (from && date < from) {
                            showRow = false;
                        }
                        if (to && date > to) {
                            showRow = false;
                        }
                    } else {
                        showRow = false;
                    }
            
                    if (taskStatus !== "all" && statusValue.trim().toLowerCase() !== taskStatus) {
                        showRow = false;
                    }
                    if (taskDepartment !== "all" && departmentValue.trim().toLowerCase() !== taskDepartment) {
                        showRow = false;
                    }
            
                    if (showRow) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        </script>
        <script src="assets/js/main.js"></script>
    </body>
</html>