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
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon1.png"/>

       <!-- Bootstrap CSS CDN -->
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
      <!-- Poppins Font -->
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body {
  font-family: 'Poppins', sans-serif;
     }
         .btn-menu{
            font-size: 11px!important;
            border-radius: 0px!important;
         }
         .btn{
            font-size: 11px!important;
            border-radius: 0px!important;
         }
         th{
            font-size: 10.5px!important;
            border:none!important;
            background-color: #0D9276!important;
            color:white!important;
        }
        td{
            font-size: 10.5px!important;
            background-color:White!important;
            color:black!important;
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
                        <button type="button" id="sidebarCollapse" class="btn btn-success btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                        </button>
                    </div>
                </nav>
                <a class="btn btn-dark btn-sm" href="workorder_home.php" style="font-size:11px!important"><i class="fa-solid fa-arrow-left"></i> Home</a>

                <button id="excel" class="btn btn-success btn-sm dataExport" data-type="excel">Excel</button>
                <input id="filter" type="text" class="form-control w-25" placeholder="Search here..." style="height: 30px; display:inline;">
                <?php
                    include 'dbconfig.php';
                    $select = "SELECT * FROM workorder_form WHERE depart_type = 'Admin' ORDER BY date DESC";
                    $select_q = mysqli_query($conn,$select);
                    $data = mysqli_num_rows($select_q);
                    ?>
                <div id="dataTableCont">
                    <table  class="table table-responsive table-bordered mt-1" id="myTable">
                    <thead style="background-color:#0D9276;color:white">
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Department</th>
                                <th scope="col">Desc</th>
                                <th scope="col">Amount</th>
                                <th scope="col">View&nbsp;Detail</th>
                                
                            </tr>
                        </thead>
                        <?php 
                            if($data){
                            	while ($row=mysqli_fetch_array($select_q)) {
                            		?>
                        <tbody  class="searchable">
                            <tr id="row_<?php echo $row['id']; ?>">
                                <td><?php echo $row['id']?>
                                </td>
                                </td>
                                <td><?php echo $row['name']?></td>
                                <td><?php echo $row['department']?></td>
                                <td><?php echo $row['description']?></td>
                                <td><?php echo $row['amount']?></td>
                                <td>
                                    <a href="workorder_admin_details.php?id=<?php echo $row['id']; ?>" style="text-decoration: none;"><button class="btn btn-secondary btn-sm">
                                    View Details
                                    </button></a>
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
        </div>
        <!--content-->
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
            $('#myTable').tableExport({ type: 'excel',ignoreColumn: [5] });
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