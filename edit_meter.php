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
        <title>Edit Meter</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <!--Font -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
        <!-- Font Awesome JS -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="assets/css/style.css">
        <style> .bg-menu {
            background-color: #393E46 !important;
        }

        .btn-menu {
            font-size: 12.5px;
            background-color: #FFB22C !important;
            padding: 5px 10px;
            font-weight: 600;
            border: none !important;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        .btn {
            border-radius: 0px;
            font-size: 11px !important;
        }

        .btn-home {
            background-color: #62CDFF;
            border: 1px solid #62CDFF;
            color: black;
            padding: 5px 10px;
            font-weight: 600;
            border: none !important;
            font-size: 12px;
        }

        .btn-back {
            background-color: #56DFCF;
            color: black;
            padding: 5px 10px;
            font-weight: 600;
            border: 1px solid #56DFCF;
            font-size: 12px;
        }

        .slide {
            position: relative;
            overflow: hidden;
            background-color: #7868E6;
            border: 2px solid #4B2C91;
            color: white;
            font-weight: 600;
            border-radius: 4px;
            cursor: pointer;
            padding: 0 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .text {
            position: relative;
            z-index: 2;
            transition: color 0.4s ease;
        }

        .slide::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 130%;
            height: 100%;
            background-color: white;
            /* white overlay */
            transform: translateX(-110%) skew(-30deg);
            transition: transform 0.5s ease;
            z-index: 1;
        }

        .slide:hover::before {
            transform: translateX(-5%) skew(-15deg);
        }

        .slide:hover .text {
            color: #4B2C91;
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
       <?php
            include("sidebarcss.php");
            ?>
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
        <nav class="navbar navbar-expand-lg navbar-light bg-menu">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn-menu">
                <i class="fas fa-align-left"></i>
                <span>Menu</span>
                </button>
            </div>
        </nav>
        <?php
            include 'dbconfig.php';
            
            
            $id=$_GET['id'];
            $select = "SELECT * FROM meters WHERE
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
                        <div class="col-xl-10 p-5 mt-3" style="background-color:White;border:1px solid black">
                            <h6 class="text-center pb-3 font-weight-bold"><span style="float:right"><a href="ecs.php" class="btn btn-sm btn-secondary">Back</a></span> Meter # <?php echo $row['id']?></h6>
                            <!-- row 0 starts -->
                            <div class="row pb-2 pt-2" >
                                <div class="col-md-4">
                                    <p>Name</p>
                                    <input type="text" value="<?php echo $row['name']; ?>" name="name" class="w-100">
                                </div>
                                <div class="col-md-4">
                                    <p>Area</p>
                                    <input type="text" value="<?php echo $row['area']; ?>" name="area" class="w-100" >
                                </div>
                                <div class="col-md-4">
                                    <p>Tag #</p>
                                    <input type="text" value="<?php echo $row['tagno']; ?>" name="tagno" class="w-100" >
                                </div>
                            </div>
                            <div class="row pb-3" >
                               
                                <div class="col-md-4">
                                    <p>Meter Type</p>
                                    <!-- <input type="text" value="<?php echo $row['supplier_name']; ?>" name="supplier_name" class="w-100"> -->
                
                                    <label style="font-size:12px!important;font-weight:500!important">
                                    <input type="checkbox" class="type-checkbox cbox" 
                                                    name="meter_type" 
                                                    value="K-Electric" 
                                                    <?php echo ($row['meter_type'] === 'K-Electric') ? 'checked' : ''; ?>>
                                                K-Electric
                                                </label>
                                                <label style="font-size:12px!important;font-weight:500!important">
                                                <input type="checkbox" class="type-checkbox cbox" 
                                                    name="meter_type" 
                                                    value="SUI Gas" 
                                                    <?php echo ($row['meter_type'] === 'SUI Gas') ? 'checked' : ''; ?>>
                                                SUI Gas
                                                </label>
                               
                               
                               
                               
                               
                               
                               
                                </div>
                            </div>


                          

                                <div class="text-center mt-3">
                                <button class="slide" name="submit"
                                    style="font-size: 17px; height: 36px; width: 150px;">
                                    <span class="text">Submit</span>
                                </button>
                            </div>
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
                    
                        $f_name = isset($_POST['name']) && $_POST['name'] !== $row['name'] ? $_POST['name'] : $row['name'];
                        $f_area = isset($_POST['area']) && $_POST['area'] !== $row['area'] ? $_POST['area'] : $row['area'];
                        $f_tagno = isset($_POST['tagno']) && $_POST['tagno'] !== $row['tagno'] ? $_POST['tagno'] : $row['tagno'];
                        $f_meter_type = isset($_POST['meter_type']) && $_POST['meter_type'] !== $row['meter_type'] ? $_POST['meter_type'] : $row['meter_type'];
                       
                       


                      
                        $update_query = "UPDATE meters SET 
                    
                                          name = '$f_name',
                                          area = '$f_area',
                                          tagno = '$f_tagno',
                                          meter_type = '$f_meter_type'
                                         
                    
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
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
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
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const checkboxes = document.querySelectorAll('.type-checkbox');
            
                checkboxes.forEach(function (checkbox) {
                    checkbox.addEventListener('change', function () {
                        const groupName = this.name.split('_')[0]; // Extract the group name
            
                        // Uncheck other checkboxes in the same group
                        checkboxes.forEach(function (cb) {
                            if (cb !== checkbox && cb.name.startsWith(groupName)) {
                                cb.checked = false;
                            }
                        });
                    });
                });
            });
        </script>
  <?php
    include 'footer.php'
    ?>