<?php 
    session_start (); 

    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php'); // Redirect to the login page
        exit;
    }
    $id = $_SESSION['id'];
    $fname = $_SESSION['fullname'];
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    $password = $_SESSION['password'];
    $gender = $_SESSION['gender'];
    $department = $_SESSION['department'];
    ?>
<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Meter All</title>
        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <!-- Our Custom CSS -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
        <!-- Font Awesome JS -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="assets/css/style.css">
        <!-- fevicon -->
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <style>
            .a1 td {
            width: 25px!important; 
            }
            .a1 th {
            width: 25px!important;
            }
            table.a1 td{
            font-weight:500;
            }
            .table-vehicle-info th{
            font-size: 14px!important;
            font-weight:600;
            // background: blue;
            width: 30%;
            }
            .table-vehicle-info td{
            font-size: 13px!important;
            font-weight:500;
            width: 70%;
            //background: red;
            }
            .layout-tabs{background-color: #f8f9fa;}
            .card{background-color: #f8f9fa;}
        </style>
        <!-- tabs work -->
        <style type="text/css">
            .tab-content {
            padding: 0;
            margin: 0;
            }
            .card {
            border-radius: 0 0 .25rem .25rem;
            border-top: 0;
            }
            .nav-tabs {
            height: 42px;
            padding: 0;
            position: relative;
            .nav-item {
            margin-left: 0;
            a {
            color: black;
            display: block;
            padding: 8px 25px;
            }
            &.overflow-tab {
            background-color: white;
            display: none;
            position: absolute;
            right: 0;
            width: 150px;
            z-index: 1;
            a {
            border: 1px solid lightgray;
            border-radius: 0;
            padding: 6px 10px;
            &:hover,
            &:focus,
            &:active,
            &.active {
            background-color: #f8f9fa;
            }
            }
            &:last-child {
            border-radius: 0 0 0 4px;
            }
            }
            &.overflow-tab-action {
            position: absolute;
            right: 0;
            }
            }
            }
        </style>
        <!-- for image zoom -->
        <style>
            /* Style for the thumbnail image */
            .thumbnail-image {
            width: 80px;
            transition: transform 0.3s ease-in-out;
            cursor: pointer;
            }
            /* Style for the expanded image */
            .expanded-image {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            max-width: 100%;
            max-height: 100%;
            z-index: 9999;
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
         }
         #sidebar.active {
         margin-left: -250px;
         }
         #sidebar .sidebar-header {
         padding: 20px;
         background: #263144!important;
         }
         #sidebar ul.components {
         padding: 10px 0;
         /* border-bottom: 1px solid #263144!important; */
         }
         #sidebar ul p {
         color: #fff;
         padding: 8px!important;
         }
         #sidebar ul li a {
         padding: 8px!important;
         font-size: 13px !important;
         display: block;
         color: white!important;
         }
         #sidebar ul li a:hover {
         /* color: black!important;
         background: #E5BA73!important; */
         text-decoration: none;
         }
         #sidebar ul li.active>a,
         a[aria-expanded="true"] {
         color: black!important;
         background: #E5BA73!important;
         }
         a[data-toggle="collapse"] {
         position: relative;
         }
         .dropdown-toggle::after {
         display: block;
         position: absolute;
         color: black!important;
         top: 50%;
         right: 20px;
         transform: translateY(-50%);
         background: transparent!important;
         }
         ul ul a {
         font-size: 13px !important;
         padding-left: 15px !important;
         background: #263144!important;
         color: black!important;
         }
         ul.CTAs {
         font-size: 13px !important;
         }
         ul.CTAs a {
         text-align: center;
         font-size: 13px;
         display: block;
         border-radius: 5px;
         margin-bottom: 5px;
         }
         a.download {
         background: #fff;
         color: #263144;
         }
         a.article,
         a.article:hover {
         background: white;
         color: black!important ;
         }
      </style>

    </head>
    <body>
        <div class="wrapper d-flex align-items-stretch">
            <?php
                include 'sidebar.php';
                ?>
            <!-- Page Content  -->
            <div id="content" class="">
                <!-- navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                        </button>
                    </div>
                </nav>
                <!-- tabs starts -->
                <div class="layout-tabs">
                    <div class="container-fluid">
                        <div class="header">
                            <!-- <h2>Bootstrap 4 responsive tabs</h2> -->
                        </div>
                        <div class="nav-tabs-wrapper">
                            <ul class="nav nav-tabs" id="tabs-title-region-nav-tabs" role="tablist">
                                <li class="nav-item active">
                                    <a class="nav-link" data-toggle="tab" role="tab" href="#block-simple-text-1" aria-selected="false" aria-controls="block-simple-text-1" id="block-simple-text-1-tab">All Meter</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" role="tab" href="#block-simple-text-2" aria-selected="false" aria-controls="block-simple-text-2" id="block-simple-text-2-tab">Meter 2 Reading Logs</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" role="tab" href="#block-simple-text-3" aria-selected="false" aria-controls="block-simple-text-3" id="block-simple-text-3-tab">All Readings Logs</a>
                                </li>
                                <!--<li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" role="tab" href="#block-simple-text-4" aria-selected="false" aria-controls="block-simple-text-4" id="block-simple-text-4-tab">Where can I get some?</a>
                                    </li> -->
                            </ul>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content">

                                     <!-- 1st one starts -->
                                    <div id="block-simple-text-1" class="tab-pane active block block-layout-builder block-inline-blockqfcc-blocktype-simple-text" role="tabpanel" aria-labelledby="block-simple-text-1-tab">
                                        <!-- 1st one starts -->

                                        <h3 class="text-center pb-3" style="font-size: 27px;">All Meters</h3>
                                        <button id="print1" type="button" class="btn btn-danger btn-sm" onclick="getPrint()">PDF</button>
                                        <button id="excel" class="btn btn-success dataExport btn-sm" data-type="excel">Excel</button>	
                                        <button class="btn btn-primary btn-sm"><a href="ecs_meter_add.php">Add</a></button>
                                        <input id="filter1" type="text" class="form-control w-25" placeholder="Search here..." style="height: 30px; display:inline;">
                                        <?php
                                            include 'dbconfig.php';
                                            // $select = "SELECT * FROM meters";
                                            $select = "SELECT meters.*, department.department_name,users.fullname
                                            FROM meters
                                            JOIN department ON meters.department_id = department.id
                                            JOIN users ON meters.assigned_user_id = users.id;";
                                            
                                            $select_q = mysqli_query($conn,$select);
                                            $data = mysqli_num_rows($select_q);
                                            ?>
                                        <table  class="table table-bordered mt-1" id="myTable1">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">Id</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Reading</th>
                                                    <th scope="col">Assigned Department</th>
                                                    <th scope="col">Administrator</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <?php 
                                                if($data){
                                                    while ($row=mysqli_fetch_array($select_q)) {
                                                        ?>
                                            <tbody class="searchable1">
                                                <td><?php echo $row['id']?></td>
                                                <td><?php echo $row['name']?></td>
                                                <td><?php echo $row['total_reading']?></td>
                                                <td><?php echo $row['department_name']?></td>
                                                <td><?php echo $row['fullname']?></td>
                                                <td>
                                                    <a href="ecs_meterall_edit.php?id=<?php echo $row['id'] ?>" class="text-success" style="text-decoration: none;color: green;">Edit
                                                    <a/>
                                                </td>
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
            
                                        <!-- 1st one ends -->
                                    </div>


                                    <!-- 2 starts -->
                                    <div id="block-simple-text-2" class="tab-pane block block-layout-builder block-inline-blockqfcc-blocktype-simple-text" role="tabpanel" aria-labelledby="block-simple-text-2-tab">


                                            <h3 class="text-center pb-3" style="font-size: 27px;">Meter 2 Logs</h3>
                                        <!-- <p class="text-info" ><a href="books-create.php" style="text-decoration: none; float: right;">Add new book</a></p> -->
                                        <button id="print1" type="button" class="btn btn-danger btn-sm" onclick="getPrint()">PDF</button>
                                        <button id="excel" class="btn btn-success dataExport btn-sm" data-type="excel">Excel</button>	
                                        <input id="filter2" type="text" class="form-control w-25" placeholder="Search here..." style="height: 30px; display:inline;">
                                        <!-- <button class="btn btn-primary btn-sm"><a href="ecs_meter_add.php">Add</a></button> -->
                                        <?php

                                            include 'dbconfig.php';

                                            $select = "SELECT meter_reading.*, meters.name AS meter_name
                                            FROM meter_reading
                                            INNER JOIN meters ON meter_reading.meter_id = meters.id
                                            WHERE meters.id = 2";

                                            // $select = "
                                            // SELECT mr.id, mr.meter_id, meters.name AS meter_name, mr.reading_date, mr.reading_value AS reading_value
                                            // FROM meter_reading mr
                                            // INNER JOIN meters ON mr.meter_id = meters.id
                                            // WHERE meters.name = 'Meter 2'
                                            // ORDER BY mr.reading_date DESC
                                            // LIMIT 1";
                                            
                                            $select_q = mysqli_query($conn,$select);
                                            $data = mysqli_num_rows($select_q);
                                            ?>
                                        <table  class="table table-bordered mt-1" id="myTable2">
                                        <thead class="thead-dark">
                                        <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Meter Id</th>
                                        <th scope="col">Meter Name</th>
                                        <th scope="col">Date & Time</th>
                                        <th scope="col">Value</th>


                                        <!-- <th>Meter name</th> -->
                                        <!-- <th scope="col">By</th> -->
                                        <!-- <th scope="col">Administrator</th>
                                        <th scope="col">Actions</th> -->
                                        </tr>
                                        </thead>
                                        <?php 
                                            if($data){
                                                while ($row=mysqli_fetch_array($select_q)) {
                                                    ?>
                                        <tbody class="searchable2">
                                        <td><?php echo $row['id']?></td>
                                        <td><?php echo $row['meter_id']?></td>
                                        <td><?php echo $row['meter_name']?></td>
                                        <td><?php echo $row['reading_date']?></td>
                                        <td><?php echo $row['reading_value']?></td>


                                        <!-- <td><?php echo $row['meter_name']?></td> -->
                                        <!-- <td><?php echo $row['reading_value']?></td> -->
                                        <!-- <td><?php echo $row['fullname']?></td>
                                        <td><a href="ecs_meterall_edit.php?id=<?php echo $row['id'] ?>" class="text-success" style="text-decoration: none;color: green;">Edit<a/></td> -->
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


                                    </div><!-- 2 end -->
                                     
                                    <!-- 3 starts -->
                                    <div id="block-simple-text-3" class="tab-pane block block-layout-builder block-inline-blockqfcc-blocktype-simple-text" role="tabpanel" aria-labelledby="block-simple-text-3-tab">
                                       




                                    <h3 class="text-center pb-3" style="font-size: 27px;">All Readings Logs</h3>
                                        <!-- <p class="text-info" ><a href="books-create.php" style="text-decoration: none; float: right;">Add new book</a></p> -->
                                        <button id="print1" type="button" class="btn btn-danger btn-sm" onclick="getPrint()">PDF</button>
                                        <button id="excel" class="btn btn-success dataExport btn-sm" data-type="excel">Excel</button>	
                                        <input id="filter" type="text" class="form-control w-25" placeholder="Search here..." style="height: 30px; display:inline;">
                                        <!-- <button class="btn btn-primary btn-sm"><a href="ecs_meter_add.php">Add</a></button> -->
                                        <?php

                                            include 'dbconfig.php';
                                            //  $select = "SELECT * FROM meter_reading";


                                            //  $select = "SELECT meter_reading.*, meters.name AS meter_name
                                            // FROM meter_reading
                                            // INNER JOIN meters ON meter_reading.id = meters.id";

                                           // SELECT meter_reading.*, meters.name AS meter_name


                                            $select = " SELECT meter_reading.*, meters.name AS meter_name
                                            FROM meter_reading
                                            INNER JOIN meters ON meter_reading.meter_id = meters.id";





        
                                            

                                            
                                            $select_q = mysqli_query($conn,$select);
                                            $data = mysqli_num_rows($select_q);
                                            ?>
                                        
                                        
                                        <table  class="table table-bordered mt-1" id="myTable3">
                                            
                                        <thead class="thead-dark">
                                        <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Meter Id</th>
                                        <th scope="col">Meter name</th>
                                        <th scope="col">Date & Time</th>
                                        <th scope="col">Value</th>
                                       

                                        </tr>
                                        </thead>
                                        <?php 
                                            if($data){
                                                while ($row=mysqli_fetch_array($select_q)) {
                                                    ?>
                                        <tbody class="searchable" >
                                        <td><?php echo $row['id']?></td>
                                        <td><?php echo $row['meter_id']?></td>
                                        <td><?php echo $row['meter_name']?></td>  
                                        <td><?php echo $row['reading_date']?></td>
                                        <td><?php echo $row['reading_value']?></td>
                                                      

                                        <!-- <td><?php echo $row['reading_value']?></td> -->
                                        <!-- <td><?php echo $row['fullname']?></td>
                                        <td><a href="ecs_meterall_edit.php?id=<?php echo $row['id'] ?>" class="text-success" style="text-decoration: none;color: green;">Edit<a/></td> -->
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

                                    
                                    </div><!-- 2 end -->
                                    <!--<div id="block-simple-text-4" class="tab-pane active block block-layout-builder block-inline-blockqfcc-blocktype-simple-text" role="tabpanel" aria-labelledby="block-simple-text-4-tab">
                                        <p>
                                        	4
                                        </p>
                                        </div> -->
                                </div>
                                <!--tab content-->
                            </div>
                            <!--card body-->
                        </div>
                        <!--card-->
                    </div>
                    <!--container-->
                </div>
                <!--tabs main-->
                <!--tabs ends -->
            </div>
            <!--contianer-fluid-->
        </div>
        <!--page content-->
        </div>
        <!--wrapper-->
        <!-- jQuery CDN - Slim version (=without AJAX) -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <!-- Popper.JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
        <!-- DataTables JavaScript -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" src="libs/js-xlsx/xlsx.core.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar').toggleClass('active');
                });
            });
        </script>
        <!-- <script type="text/javascript">
            $(document).ready(function() {
            $('#example').DataTable({
                "paging": true, // Enable pagination
                "searching": true, // Enable search box
                // More options can be added as needed
            });
            });
        </script> -->
        <!-- table export -->
        <script src=" https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/tableExport.min.js "></script>
        <script type="text/javascript" src="libs/FileSaver/FileSaver.min.js"></script>
        <script type="text/javascript" src="../libs/jsPDF/polyfills.umd.js"></script>
        <script type="text/javascript" src="tableExport.min.js"></script>
        <!-- <script type="text/javascript">
            $(document).ready(function() {
            $('#excel').click(function() {
            $('#myTable').tableExport({ type: 'excel',ignoreColumn: [8,9] });
            //$('#table_report').tableExport({ type: 'excel',escape:'false',ignoreColumn: [15]});
            });
            });
            </script> -->
        <script src="assets/js/main.js"></script>
        <!-- tabs work -->
        <script>
            var tabsActions = function (element) {
            this.element = $(element);
            this.setup = function () {
                if (this.element.length <= 0) {
                return;
                }
                this.init();
                // Update after resize window.
                var resizeId = null;
                $(window).resize(function () {
                clearTimeout(resizeId);
                resizeId = setTimeout(() => {this.init()}, 50);
                }.bind(this));
            };
            this.init = function () {
                // Add class to overflow items.
                this.actionOverflowItems();
                var tabs_overflow = this.element.find('.overflow-tab');
                // Build overflow action tab element.
                if (tabs_overflow.length > 0) {
                if (!this.element.find('.overflow-tab-action').length) {
                    var tab_link = $('<a>')
                    .addClass('nav-link')
                    .attr('href', '#')
                    .attr('data-toggle', 'dropdown')
                    .text('...')
                    .on('click', function (e) {
                        e.preventDefault();
                        $(this).parents('.nav.nav-tabs').children('.nav-item.overflow-tab').toggle();
                    });
                    var overflow_tab_action = $('<li>')
                    .addClass('nav-item')
                    .addClass('overflow-tab-action')
                    .append(tab_link);
                    // Add hide to overflow tabs when click on any tab.
                    this.element.find('.nav-link').on('click', function (e) {
                    $(this).parents('.nav.nav-tabs').children('.nav-item.overflow-tab').hide();
                    });
                    this.element.append(overflow_tab_action);
                }
                this.openOverflowDropdown();
                }
                else {
                this.element.find('.overflow-tab-action').remove();
                }
            };
            this.openOverflowDropdown = function () {
                var overflow_sum_height = 0;
                var overflow_first_top = 41;
                this.element.find('.overflow-tab').hide();
                // Calc top position of overflow tabs.
                this.element.find('.overflow-tab').each(function () {
                var overflow_item_height = $(this).height() - 1;
                if (overflow_sum_height === 0) {
                    $(this).css('top', overflow_first_top + 'px');
                    overflow_sum_height += overflow_first_top + overflow_item_height;
                }
                else {
                    $(this).css('top', overflow_sum_height + 'px');
                    overflow_sum_height += overflow_item_height;
                }
                });
            };
            this.actionOverflowItems = function () {
                var tabs_limit = this.element.width() - 100;
                var count = 0;
                // Calc tans width and add class to any tab that is overflow.
                for (var i = 0; i < this.element.children().length; i += 1) {
                var item = $(this.element.children()[i]);
                if (item.hasClass('overflow-tab-action')) {
                    continue;
                }
                count += item.width();
                if (count > tabs_limit) {
                    item.addClass('overflow-tab');
                }
                else if (count < tabs_limit) {
                    item.removeClass('overflow-tab');
                    item.show();
                }
                }
            };
            };
            var tabsAction = new tabsActions('.layout--tabs .nav-tabs-wrapper .nav-tabs');
            tabsAction.setup();
        </script>
        <!-- for image zoom -->
        <script>
            function expandImage(img) {
                if (!img.classList.contains("expanded-image")) {
                    img.classList.add("expanded-image");
                    img.style.width = "80vw";
                    img.style.height = "80vh";
                    img.style.position = "fixed";
                    img.style.top = "50%";
                    img.style.left = "50%";
                    img.style.transform = "translate(-50%, -50%)";
                    img.style.zIndex = "9999";
                    img.style.cursor = "zoom-out";
            
                    // Create and append a close button
                    var closeButton = document.createElement("button");
                    closeButton.innerHTML = "✖"; // You can change this to an icon or any text
                    closeButton.classList.add("close-button");
                    closeButton.style.position = "fixed";
                    closeButton.style.top = "10px";
                    closeButton.style.right = "10px";
                    closeButton.style.zIndex = "10000";
                    closeButton.style.cursor = "pointer";
                    document.body.appendChild(closeButton);
            
                    // Close the expanded image when the close button is clicked
                    closeButton.addEventListener("click", function() {
                        img.classList.remove("expanded-image");
                        img.style = ""; // Reset styles to default
                        closeButton.remove(); // Remove the close button
                    });
                } else {
                    img.classList.remove("expanded-image");
                    img.style = ""; // Reset styles to default
                    document.querySelector(".close-button").remove(); // Remove the close button
                }
            }
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



    <script>
            $(document).ready(function () {
            (function ($) {
                $('#filter1').keyup(function () {
                    var rex = new RegExp($(this).val(), 'i');
                    $('.searchable1 tr').hide();
                    $('.searchable1 tr').filter(function () {
                        return rex.test($(this).text());
                    }).show();
                })

            }(jQuery));
            });
    </script>

    <script>
        $(document).ready(function () {
        (function ($) {
            $('#filter2').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.searchable2 tr').hide();
                $('.searchable2 tr').filter(function () {
                    return rex.test($(this).text());
                }).show();
            })

        }(jQuery));
        });
    </script>



    </body>
</html>