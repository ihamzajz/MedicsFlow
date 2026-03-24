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
    <title>MedicsFlow</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon1.png" />
    <!-- Bootstrap CSS CDN -->
    <?php
    include 'cdncss.php'
        ?>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .btn {
            font-size: 11px !important;
            border-radius: 0px !important;
        }

        p {
            font-size: 13px !important;

            padding: 0px !important;
            margin: 0px !important;
            font-weight: 600;
        }

        input[type="text"] {
            font-size: 12.3px !important;
            width: 100% !important;
            height: 24px !important;
            padding: 5px 5px !important;
        }

        textarea {
            font-size: 12.3px !important;

        }

        ::placeholder {
            color: black;
        }

        textarea {
            font-size: 14px;
        }



        /* Approve Button  */
        .btn-approve {
            white-space: nowrap !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            background-color: #D1E7DD;
            color: white !important;
            border-radius: 15px !important;
            transition: all 0.3s ease !important;
            padding: 4px 15px !important;
            color: black !important;
            border: 1px solid #198754 !important;
        }

        .btn-approve:hover {
            filter: brightness(85%);
        }

        /* Reject Button */
        .btn-reject {
            white-space: nowrap !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            background-color: #F8D7DA;
            color: white !important;
            border-radius: 15px !important;
            transition: all 0.3s ease !important;
            padding: 4px 15px !important;
            color: black !important;
            border: 1px solid #DC3545 !important;
        }

        .btn-reject:hover {
            filter: brightness(85%);
        }
    </style>
    <?php
    include 'sidebarcss.php'
        ?>
</head>

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
                    <button type="button" id="sidebarCollapse" class="btn btn-success">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </nav>
            <?php
            include 'dbconfig.php';


            $id = $_GET['id'];
            $select = "SELECT * FROM trf WHERE
                    id = '$id' ";

            $select_q = mysqli_query($conn, $select);
            $data = mysqli_num_rows($select_q);
            ?>
            <?php
            if ($data) {
                while ($row = mysqli_fetch_array($select_q)) {
                    ?>
                      <div style="background-color: white!important;border:1px solid black!important; padding:20px!important"
                        class="m-5">
                        <div class="d-flex align-items-center justify-content-between">
                            <!-- Left Side Buttons -->
                            <div>
                                <a class="btn btn-dark btn-sm mt-1" href="trf_home.php" style="font-size:11px!important">
                                    <i class="fa-solid fa-home"></i> Home
                                </a>
                                <a class="btn btn-dark btn-sm mt-1" href="trf_userlist.php"
                                    style="font-size:11px!important">
                                    <i class="fa-solid fa-arrow-left"></i> Back
                                </a>
                            </div>

                            <!-- Center Heading -->
                            <h5 class="m-0 text-center" style="flex:1; font-weight:600">
                                Trf # <?php echo $row['id'] ?>
                            </h5>

                            <!-- Right Side (optional, placeholder for now) -->
                            <div style="width:100px"></div>
                        </div>

                        <div class="row pt-5">



                            <!-- row 1 start-->
                            <div class="col-md-3 pb-3">
                                <p>Name:</p>
                                <input type="text" placeholder="<?php echo $row['name'] ?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <p>Department:</p>
                                <input type="text" placeholder="<?php echo $row['department'] ?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <p>Role:</p>
                                <input type="text" placeholder="<?php echo $row['role'] ?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <p>Submission Date:</p>
                                <input type="text" placeholder="<?php echo $row['date'] ?>" readonly>
                            </div>
                        </div>
                        <!-- row 1 end-->

                        <div class="row pb-3">

                            <div class="col-md-6">
                                <p>Purpose of Travel</p>
                                <input type="text" placeholder="<?php echo $row['purpose'] ?>" readonly>
                            </div>

                            <div class="col-md-6">
                                <p>Reason</p>
                                <input type="text" placeholder="<?php echo $row['reason'] ?>" readonly>
                            </div>

                        </div>


                        <div class="row">

                            <div class="col-md-3 pb-3">
                                <p>Departure From</p>
                                <input type="text" placeholder="<?php echo $row['to_1'] ?>" readonly>
                            </div>

                            <div class="col-md-3">
                                <p>To</p>
                                <input type="text" placeholder="<?php echo $row['to_2'] ?>" readonly>
                            </div>

                            <div class="col-md-3">
                                <p>To</p>
                                <input type="text" placeholder="<?php echo $row['to_3'] ?>" readonly>
                            </div>

                            <div class="col-md-3">
                                <p>To</p>
                                <input type="text" placeholder="<?php echo $row['to_4'] ?>" readonly>
                            </div>
                        </div>



                        <div class="row pb-3">

                            <div class="col-md-3">
                                <p>Preferable Date From</p>
                                <input type="text" placeholder="<?php echo $row['time_1'] ?>" readonly>
                            </div>

                            <div class="col-md-3">
                                <p>To</p>
                                <input type="text" placeholder="<?php echo $row['time_2'] ?>" readonly>
                            </div>

                            <div class="col-md-3">
                                <p>To</p>
                                <input type="text" placeholder="<?php echo $row['time_3'] ?>" readonly>
                            </div>

                            <div class="col-md-3">
                                <p>To</p>
                                <input type="text" placeholder="<?php echo $row['time_4'] ?>" readonly>
                            </div>
                        </div>

                        <div class="row pb-3">
                            <div class="col-md-4">
                                <p>Preferable Flight</p>
                                <input type="text" placeholder="<?php echo $row['preferable_flight'] ?>" readonly>
                            </div>

                            <div class="col-md-4">
                                <p>Duration of Visit (In Days)</p>
                                <input type="text" placeholder="<?php echo $row['duration'] ?>" readonly>
                            </div>

                            <div class="col-md-4">
                                <p>Expected day of return</p>
                                <input type="text" placeholder="<?php echo $row['expected_days'] ?>" readonly>
                            </div>
                        </div>



                        <div class="row pb-3">
                            <div class="col-md-4">
                                <p>Mode Of Travel</p>
                                <input type="text" placeholder="<?php echo $row['mode_of_travel'] ?>" readonly>
                            </div>

                            <div class="col-md-4">
                                <p>Hotel Booking Required</p>
                                <input type="text" placeholder="<?php echo $row['hotel_booking'] ?>" readonly>
                            </div>

                            <div class="col-md-4">
                                <p>Visa Required</p>
                                <input type="text" placeholder="<?php echo $row['visa_required'] ?>" readonly>
                            </div>
                        </div>

                        <h6 class="py-2">Traveling Advance (For Finance Department)</h6>

                        <div class="row pb-3">
                            <div class="col-md-6">
                                <p for="advance_required">Advance Required</p>
                                <input type="text" placeholder="<?php echo $row['advance_required'] ?>" readonly>
                            </div>

                            <div class="col-md-6">
                                <p for="advance_amount">Advance Amount (PKR)</p>
                                <input type="text" placeholder="<?php echo $row['advance_amount'] ?>" readonly>
                            </div>
                        </div>





                    </div>
                </div>
                <!-- row 6 end-->

            </div><!-- container end-->


            <?php
                }
            } else {
                echo "No record found!";
            }
            ?>
       </div>
    </div>
    <!--content-->
    </div> <!--wrapper-->

    <?php
    include "footer.php"
        ?>