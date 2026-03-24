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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Smart Meter Reading</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">
    <!-- fevicon -->
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">


    <style>
        select,
        option {
            width: 200px !important;
            height: 25px !important;
            font-size: 11px !important;
            border: 0.5px solid black !important;
        }

        .btn {
            font-size: 11px !important;
            border-radius: 0px !important;
        }

        .table-container {
            overflow-y: auto;
            height: 100vh;
            /* Full viewport height */
            margin: 0;
            padding: 0;
        }

      .table {
        border: 0.5px solid grey !important;
    }

    .table th {
        font-size: 12px !important;
        border: none !important;
        background-color: #1B7BBC !important;
        color: white !important;
        padding: 6px 5px !important;
        font-weight: 500;
    }

    .table td {
        font-size: 11px;
        color: black;
        padding: 7px 5px !important;
        font-weight: 500;
        border: none !important
    }

        .table2 tr,
        th,
        td {
            border: 1px solid black !important;
        }

        .table2 th {
            background-color: white !important;
            color: black !important;
            font-size: 14px;
        }

        select,
        option {
            font-size: 13px !important;
        }

        .btn-submit {
            font-size: 12px !important;
            color: white;
            background-color: #0d6efd;
            padding: 5px 35px;
            border-radius: 2px;
            border: 2px solid #0D9276;
            letter-spacing: 1.35px;
            font-weight: 500;
        }

        input {
            font-size: 13px !important;
        }
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
                    /* padding: 8px 25px; */
                    font-size: 12px !important;
                    font-weight: 500 !important;
                    letter-spacing: 0.2px !important;
                    border: 1px solid black !important;
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


    <style>
        .bg-menu {
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
    </style>








    <?php
    include("sidebarcss.php");
    ?>

</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <?php
        include 'sidebar1.php';
        ?>
        <!-- Page Content  -->
        <div id="content" class="">
            <!-- navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-menu">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn-menu">
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
                    <div class="nav-tabs-wrapper mt-2">
                        <ul class="nav nav-tabs" id="tabs-title-region-nav-tabs" role="tablist">
                            <li class="nav-item active">
                                <a class="nav-link" data-toggle="tab" role="tab" href="#block-simple-text-1" aria-selected="false" aria-controls="block-simple-text-1" id="block-simple-text-1-tab">All Meters</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" role="tab" href="#block-simple-text-2" aria-selected="false" aria-controls="block-simple-text-2" id="block-simple-text-2-tab">Enter Reading</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" role="tab" href="#block-simple-text-3" aria-selected="false" aria-controls="block-simple-text-3" id="block-simple-text-3-tab">Reading Data</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <!-- 1 starts-->
                                <div id="block-simple-text-1" class="tab-pane active block block-layout-builder block-inline-blockqfcc-blocktype-simple-text" role="tabpanel" aria-labelledby="block-simple-text-1-tab">
                                    <!--ander ka kaam start-->
                                    <h3 class="text-center" style="font-weight: 600;">All Meter</h3>
                                    <a href="add_new_meter.php"> <button class="btn btn-primary btn-sm">Add New <i class="fa-solid fa-plus"></i></button></a>
                                    <input id="filter1" type="text" class="form-control w-25" placeholder="Search here..." style="height: 30px; display:inline;font-size:12px!important;float:right!important;border:1px solid black">
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


                                    $select = " SELECT * FROM meters";

                                    // $select = "SELECT * FROM vehicle_log where assigned_user_id = '$id'";
                                    $select_q = mysqli_query($conn, $select);
                                    $data = mysqli_num_rows($select_q);
                                    ?>
                                    <div class="table-wrapper">
                                        <div class="table-responsive table-container">
                                            <table class="table mt-1 table-1" id="myTable1">
                                                <thead >
                                                    <th scope="col">Id</th>
                                                    <th scope="col">Meter Type</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Area</th>
                                                    <th scope="col">Tag #</th>
                                                    <th scope="col">Edit</th>


                                                </thead>
                                                <?php
                                                if ($data) {
                                                    while ($row = mysqli_fetch_array($select_q)) {
                                                ?>
                                                        <tbody class="searchable1">
                                                            <td><?php echo $row['id'] ?></td>
                                                            <td><?php echo $row['meter_type'] ?></td>
                                                            <td><?php echo $row['name'] ?></td>
                                                            <td><?php echo $row['area'] ?></td>
                                                            <td><?php echo $row['tagno'] ?></td>

                                                            <td>
                                                                <a href="edit_meter.php?id=<?php echo $row['id']; ?>" class="btn btn-secondary btn-sm">Edit
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            </td>

                                                    <?php
                                                    }
                                                } else {
                                                    echo "No record found!";
                                                }
                                                    ?>
                                            </table>
                                        </div>
                                    </div>
                                    <!--table wrapper-->
                                </div>
                                <!-- 1ends -->
                                <!-- 2 starts -->
                                <div id="block-simple-text-2" class="tab-pane block block-layout-builder block-inline-blockqfcc-blocktype-simple-text" role="tabpanel" aria-labelledby="block-simple-text-2-tab">
                                    <p>


                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            <h5 class="text-center pb-3" style="font-weight:600">Enter Reading</h5>
                                            <form method="POST" enctype="multipart/form-data">
                                                <table class="table table-bordered table2">
                                                    <tr>
                                                        <th style="font-size:13px!important"><label>Meter Type:</label></th>
                                                        <td style="font-size:13px!important" class="pt-3"><label><input type="checkbox" class="type-checkbox cbox" name="meter_type" value="K-Electric"> K-Electric&nbsp;</label>
                                                            <label><input type="checkbox" class="type-checkbox cbox" name="meter_type" value="SUI Gas"> SUI Gas</label>
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <th style="font-size:13px!important"><label>Meter</label></th>
                                                        <td>
                                                            <select name="meter" class="form-control" required style="height:30px!important">
                                                                <option value="" disabled selected>Please select</option>
                                                                <?php
                                                                // Fetch meter values from the database
                                                                $query = "SELECT name FROM meters";
                                                                $result = $conn->query($query);

                                                                if ($result) {
                                                                    if ($result->num_rows > 0) {
                                                                        // Loop through each meter and create an option in the dropdown
                                                                        while ($meter_row = $result->fetch_assoc()) {
                                                                            echo "<option value='" . htmlspecialchars($meter_row['name']) . "'>" . htmlspecialchars($meter_row['name']) . "</option>";
                                                                        }
                                                                    } else {
                                                                        echo "<option value='' disabled>No meters available</option>";
                                                                    }
                                                                } else {
                                                                    echo "<option value='' disabled>Error fetching meters</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th style="font-size:13px!important"><label>Daily Reading</label></th>
                                                        <td><input type="text" name="daily_reading" class="form-control" placeholder="Enter Daily Reading" autocomplete="off" required> </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="font-size:13px!important"><label>Time</label></th>
                                                        <td><input type="time" name="time" class="form-control" autocomplete="off" required> </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="font-size:13px!important"><label>Comments</label></th>
                                                        <td><input type="text" name="issue" class="form-control" placeholder="Enter Comments" autocomplete="off"> </td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2">
                                                            <div class="text-center">
                                                                <button type="submit" class="btn btn-submit" name="submit">Enter</button>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </table>
                                            </form>
                                        </div>
                                    </div>

                                    <?php
                                    include 'dbconfig.php';
                                    if (isset($_POST['submit'])) {

                                        date_default_timezone_set("Asia/Karachi");

                                        $id = $_SESSION['id'];
                                        $name = $_SESSION['fullname'];
                                        $email = $_SESSION['email'];
                                        $username = $_SESSION['username'];
                                        $department = $_SESSION['department'];
                                        $role = $_SESSION['role'];
                                        $date = date('Y-m-d H:i:s');

                                        $meter = mysqli_real_escape_string($conn, $_POST['meter']);
                                        $daily_reading = mysqli_real_escape_string($conn, $_POST['daily_reading']);
                                        $issue = mysqli_real_escape_string($conn, $_POST['issue']);

                                        $time = mysqli_real_escape_string($conn, $_POST['time']);

                                        $meter_type = mysqli_real_escape_string($conn, $_POST['meter_type']);

                                        $insert = "INSERT INTO ecs
               (meter, daily_reading, issue, date, username, time, meter_type) 
               VALUES 
               ('$meter', '$daily_reading', '$issue', '$date', '$name', '$time', '$meter_type')";

                                        $insert_q = mysqli_query($conn, $insert);
                                        if ($insert_q) {
                                    ?>
                                            <script type="text/javascript">
                                                alert("Data Inserted successfully");
                                                window.location.href = "ecs.php";
                                            </script>
                                        <?php
                                        } else {
                                        ?>
                                            <script type="text/javascript">
                                                alert("Data submission failed!");
                                                window.location.href = "ecs.php";
                                            </script>
                                    <?php
                                        }
                                    }
                                    ?>

                                    </p>
                                </div>
                                <!-- 2ends -->
                                <!-- 3starts -->
                                <div id="block-simple-text-3" class="tab-pane block block-layout-builder block-inline-blockqfcc-blocktype-simple-text" role="tabpanel" aria-labelledby="block-simple-text-3-tab">
                                    <p>
                                    <h5 class="text-center pb-3" style="font-weight: 600;">All Reading Data</h5>
                                    <!-- <button id="print1" type="button" class="btn btn-danger btn-sm" onclick="getPrint()">PDF</button> -->

                                    <button id="excel2" class="btn btn-success btn-sm dataExport mb-2 mr-2" style="float: left;">Excel</button>
                                    <!-- <button id="excel2" class="btn btn-success btn-sm dataExport" data-type="excel">Excel</button> -->

                                    <input id="filter2" type="text" class="form-control w-25" placeholder="Search here..." style="height: 30px; display:inline;">



                                    <div style="float:right!important">
                                        <label for="meter_type" class="label labelm" style="display: inline-block; margin-right: 10px;font-size:12px!important">Meter Type</label>
                                        <select id="meter_type" style="display: inline-block;">
                                            <option value="all">All</option>
                                            <option value="K-Electric">K-Electric</option>
                                            <option value="SUI Gas">SUI Gas</option>
                                        </select>
                                    </div>





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

                                    $select = "SELECT * from ecs
                                                       ORDER BY date DESC";

                                    $select_q = mysqli_query($conn, $select);
                                    $data = mysqli_num_rows($select_q);
                                    ?>
                                    <div class="table-wrapper">
                                        <div id="dataTableCont">
                                            <table class="table  a1 mt-1" id="myTable2">
                                                <thead style="background-color:#8576FF;color:white">

                                                    <th scope="col">Id</th>
                                                    <th scope="col">Meter Type</th>
                                                    <th scope="col">Meter</th>

                                                    <th scope="col">Daily Reading</th>
                                                    <th scope="col">Time</th>
                                                    <th scope="col">Comments</th>

                                                    <th scope="col">Date</th>
                                                    <th scope="col">Username</th>
                                                </thead>
                                                <?php
                                                if ($data) {
                                                    while ($row = mysqli_fetch_array($select_q)) {
                                                ?>
                                                        <tbody class="searchable2">

                                                            <td><?php echo $row['id'] ?></td>
                                                            <td><?php echo $row['meter_type'] ?></td>
                                                            <td><?php echo $row['meter'] ?></td>

                                                            <td><?php echo $row['daily_reading'] ?></td>
                                                            <td><?php echo $row['time'] ?></td>
                                                            <td><?php echo $row['issue'] ?></td>

                                                            <td><?php echo $row['date'] ?></td>
                                                            <td><?php echo $row['username'] ?></td>
                                                        </tbody>
                                                <?php
                                                    }
                                                } else {
                                                    echo "No record found!";
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                    </p>
                                </div>
                                <!-- 3ends -->

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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <script type="text/javascript" src="libs/js-xlsx/xlsx.core.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>









    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>

    <script type="text/javascript">
        document.getElementById('excel1').addEventListener('click', function() {
            var table = document.getElementById('myTable1');
            var workbook = XLSX.utils.table_to_book(table, {
                sheet: "Sheet1"
            });
            XLSX.writeFile(workbook, 'export.xlsx');
        });
    </script>

    <script type="text/javascript">
        document.getElementById('excel2').addEventListener('click', function() {
            var table = document.getElementById('myTable2');
            var workbook = XLSX.utils.table_to_book(table, {
                sheet: "Sheet1"
            });
            XLSX.writeFile(workbook, 'export.xlsx');
        });
    </script>

    <script type="text/javascript">
        document.getElementById('excel3').addEventListener('click', function() {
            var table = document.getElementById('myTable3');
            var workbook = XLSX.utils.table_to_book(table, {
                sheet: "Sheet1"
            });
            XLSX.writeFile(workbook, 'export.xlsx');
        });
    </script>

    <script type="text/javascript">
        document.getElementById('excel4').addEventListener('click', function() {
            var table = document.getElementById('myTable4');
            var workbook = XLSX.utils.table_to_book(table, {
                sheet: "Sheet1"
            });
            XLSX.writeFile(workbook, 'export.xlsx');
        });
    </script>














    <script src="assets/js/main.js"></script>
    <!-- tabs work -->
    <script>
        var tabsActions = function(element) {
            this.element = $(element);
            this.setup = function() {
                if (this.element.length <= 0) {
                    return;
                }
                this.init();
                // Update after resize window.
                var resizeId = null;
                $(window).resize(function() {
                    clearTimeout(resizeId);
                    resizeId = setTimeout(() => {
                        this.init()
                    }, 50);
                }.bind(this));
            };
            this.init = function() {
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
                            .on('click', function(e) {
                                e.preventDefault();
                                $(this).parents('.nav.nav-tabs').children('.nav-item.overflow-tab').toggle();
                            });
                        var overflow_tab_action = $('<li>')
                            .addClass('nav-item')
                            .addClass('overflow-tab-action')
                            .append(tab_link);
                        // Add hide to overflow tabs when click on any tab.
                        this.element.find('.nav-link').on('click', function(e) {
                            $(this).parents('.nav.nav-tabs').children('.nav-item.overflow-tab').hide();
                        });
                        this.element.append(overflow_tab_action);
                    }
                    this.openOverflowDropdown();
                } else {
                    this.element.find('.overflow-tab-action').remove();
                }
            };
            this.openOverflowDropdown = function() {
                var overflow_sum_height = 0;
                var overflow_first_top = 41;
                this.element.find('.overflow-tab').hide();
                // Calc top position of overflow tabs.
                this.element.find('.overflow-tab').each(function() {
                    var overflow_item_height = $(this).height() - 1;
                    if (overflow_sum_height === 0) {
                        $(this).css('top', overflow_first_top + 'px');
                        overflow_sum_height += overflow_first_top + overflow_item_height;
                    } else {
                        $(this).css('top', overflow_sum_height + 'px');
                        overflow_sum_height += overflow_item_height;
                    }
                });
            };
            this.actionOverflowItems = function() {
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
                    } else if (count < tabs_limit) {
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
        $(document).ready(function() {
            (function($) {
                $('#filter1').keyup(function() {
                    var rex = new RegExp($(this).val(), 'i');
                    $('.searchable1 tr').hide();
                    $('.searchable1 tr').filter(function() {
                        return rex.test($(this).text());
                    }).show();
                })
            }(jQuery));
        });
    </script>
    <script>
        $(document).ready(function() {
            (function($) {
                $('#filter2').keyup(function() {
                    var rex = new RegExp($(this).val(), 'i');
                    $('.searchable2 tr').hide();
                    $('.searchable2 tr').filter(function() {
                        return rex.test($(this).text());
                    }).show();
                })
            }(jQuery));
        });
    </script>
    <script>
        $(document).ready(function() {
            (function($) {
                $('#filter3').keyup(function() {
                    var rex = new RegExp($(this).val(), 'i');
                    $('.searchable3 tr').hide();
                    $('.searchable3 tr').filter(function() {
                        return rex.test($(this).text());
                    }).show();
                })
            }(jQuery));
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.type-checkbox');

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const groupName = this.name.split('_')[0]; // Extract the group name

                    // Uncheck other checkboxes in the same group
                    checkboxes.forEach(function(cb) {
                        if (cb !== checkbox && cb.name.startsWith(groupName)) {
                            cb.checked = false;
                        }
                    });
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#meter_type').on('change', function() {
                var meterType = $(this).val().toLowerCase();

                $('tbody.searchable2').each(function() {
                    var rowType = $(this).find('td:nth-child(2)').text().toLowerCase();

                    if (meterType === 'all' || rowType === meterType) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
</body>

</html>