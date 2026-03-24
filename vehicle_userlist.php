<?php 
session_start (); 
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Digital Form</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon1.png"/>
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
<link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>


<!-- <style>
        th{
            font-size: 14px!important;
        }
        td{
            font-size: 13px!important;
        }
    </style> -->
<style>
    .table-logs th{
        font-size: 14px!important;
    }
    .table-logs td{
        font-size: 13px!important;
    }
        .table-logs th td{
            width: 30%;
        }
        .table-logs td{
            font-weight:500;
        }
        .table-vehicle-info th{
            background: blue;
           font-size: 14px!important;
            width: 30%;
        }
        .table-vehicle-info td{
            font-size: 13px!important;
            width: 70%;
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
						<a class="nav-link" data-toggle="tab" role="tab" href="#block-simple-text-1" aria-selected="false" aria-controls="block-simple-text-1" id="block-simple-text-1-tab">Your Vehicle Info</a>
						</li>
						 <li class="nav-item">
						<a class="nav-link" data-toggle="tab" role="tab" href="#block-simple-text-2" aria-selected="false" aria-controls="block-simple-text-2" id="block-simple-text-2-tab">Logs</a>
						</li>
						<!--<li class="nav-item">
						<a class="nav-link" data-toggle="tab" role="tab" href="#block-simple-text-3" aria-selected="false" aria-controls="block-simple-text-3" id="block-simple-text-3-tab">Where does it come from?</a>
						</li>
						<li class="nav-item">
						<a class="nav-link" data-toggle="tab" role="tab" href="#block-simple-text-4" aria-selected="false" aria-controls="block-simple-text-4" id="block-simple-text-4-tab">Where can I get some?</a>
						</li> -->
					</ul>
				</div>
				<div class="card">
					<div class="card-body">
						<div class="tab-content">
							<div id="block-simple-text-1" class="tab-pane active block block-layout-builder block-inline-blockqfcc-blocktype-simple-text" role="tabpanel" aria-labelledby="block-simple-text-1-tab">
								<!--ander ka kaam start-->
								<h3 class="text-center" style="font-size:27px;">Your Vehicle Info</h3>
								<button id="print1" type="button" class="btn btn-danger btn-sm" onclick="getPrint()">PDF</button>
								<button id="excel" class="btn btn-success dataExport btn-sm" data-type="excel">Excel</button>
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
                                    $select = "SELECT * FROM vehicle_info where assigned_user_id = '$id'";
                                    $select_q = mysqli_query($conn,$select);
                                    $data = mysqli_num_rows($select_q);
                                    ?>
								<div id="dataTableCont">
									<table class="table table-vehicle-info mt-1" id="myTable">
									<?php 
                                            if($data){
                                                while ($row=mysqli_fetch_array($select_q)) {
                                                ?>
									<tbody >
									<tr>
										<th scope="col">
											Id
										</th>
										<td>
                                            <?php echo $row['id']?>
										</td>
									</tr>
									<tr>
										<th scope="col">
											Make
										</th>
										<td>
                                            <?php echo $row['make']?>
										</td>
									</tr>
									<tr>
										<th scope="col">
											Model
										</th>
										<td>
                                            <?php echo $row['model']?>
										</td>
									</tr>
									<tr>
										<th scope="col">
											Year
										</th>
										<td>
                                            <?php echo $row['year']?>
										</td>
									</tr>
									<tr>
										<th scope="col">
											Engine Power
										</th>
										<td>
                                            <?php echo $row['engine_power']?>
										</td>
									</tr>
									<tr>
										<th scope="col">
											Transmission
										</th>
										<td>
                                            <?php echo $row['transmission']?>
										</td>
									</tr>
									<tr>
										<th scope="col">
											Fuel Type
										</th>
										<td>
                                            <?php echo $row['fuel_type']?>
										</td>
									</tr>
									<tr>
										<th scope="col">
											Fuel tank capacity
										</th>
										<td>
                                            <?php echo $row['fuel_tank_capacity']?>
										</td>
									</tr>
									<tr>
										<th scope="col">
											Registration Number
										</th>
										<td>
                                            <?php echo $row['registration_number']?>
										</td>
									</tr>
									<tr>
										<th scope="col">
											Assigned user id
										</th>
										<td>
                                            <?php echo $row['assigned_user_id']?>
										</td>
									</tr>
									<tr>
										<th scope="col">
											status
										</th>
										<td>
                                            <?php echo $row['status']?>
										</td>
									</tr>
									<tr>
										<th scope="col">
											image
										</th>
                                        <td>
                                             <div class="image-container">
                                                <img src="assets/images/<?php echo $row['image']?>" class="thumbnail-image" onclick="expandImage(this)">
                                             </div>
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
								</div>
							</div>

                            <!-- 2nd LOGS-->
							<div id="block-simple-text-2" class="tab-pane block block-layout-builder block-inline-blockqfcc-blocktype-simple-text" role="tabpanel" aria-labelledby="block-simple-text-2-tab">
            <!--ander ka kaam start-->
            <h3 class="text-center" style="font-size:27px;">Logs</h3>
             <button id="print1" type="button" class="btn btn-danger btn-sm" onclick="getPrint()">PDF</button>
             <button id="excel" class="btn btn-success btn-sm dataExport" data-type="excel">Excel</button>
             <input id="filter" type="text" class="form-control w-25" placeholder="Search here..." style="height: 30px; display:inline;">
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



                $select = " SELECT * FROM vehicle_log
                JOIN vehicle_info ON vehicle_log.vehicle_id = vehicle_info.id
                WHERE vehicle_info.assigned_user_id = '$id'";

                // $select = "SELECT * FROM vehicle_log where assigned_user_id = '$id'";
                $select_q = mysqli_query($conn,$select);
                $data = mysqli_num_rows($select_q);
                   ?>

                   <div class="table-wrapper">

                   <div id="dataTableCont">
                <table  class="table table-logs mt-1" id="myTable" >
                
                      <thead class="bg-primary text-white">
                        <th scope="col">Date</th>
                        <th scope="col">Log Id</th>
                        <!-- <th scope="col">Vehicle Id</th> -->
                        <th scope="col">Total Mileage</th>
                        <th scope="col">Daily Mileage</th>
                        <th scope="col">Issues</th>
                      </thead>
                      <?php 
                  if($data){
                    while ($row=mysqli_fetch_array($select_q)) {
                      ?>
                     <tbody  class="searchable">  
                            <td><?php echo $row['date']?></td>                
                            <td><?php echo $row['log_id']?></td>
                            <!-- <td><?php echo $row['vehicle_id']?></td> -->
                            <td><?php echo $row['total_mileage']?></td>
                            <td><?php echo $row['daily_mileage']?></td>
                            <td><?php echo $row['issues']?></td>
                      <?php
                    }
                  }
                  else{
                    echo "No record found!";
                  }
                  ?>
                </table>
               </div>

                   </div> <!--table wrapper-->
							</div>
							<!-- <div id="block-simple-text-3" class="tab-pane active block block-layout-builder block-inline-blockqfcc-blocktype-simple-text" role="tabpanel" aria-labelledby="block-simple-text-3-tab">
								<p>
									3
								</p>
							</div>
							<div id="block-simple-text-4" class="tab-pane active block block-layout-builder block-inline-blockqfcc-blocktype-simple-text" role="tabpanel" aria-labelledby="block-simple-text-4-tab">
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



</body>
</html>