<?php
session_start();


if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php'); // Redirect to the login page
    exit;
}

$head_email = $_SESSION['head_email'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TRF - Dashboard</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
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
    <style>
        td {

            padding: 5px !important;
        }

        .travel-desk {
            width: 70% !important;
        }

        .ready {
            background-color: #efefef;
            border: none !important;
            border: 1px solid grey !important;
            padding-left: 5px !important;
        }

        p {
            font-size: 14px;
            margin: 0;
            padding: 0;
        }

        select,
        input,
        textarea {
            width: 100%;
            font-size: 14px;
            height: 25px;
            color: black !important;
        }

        ::placeholder {
            color: black;
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
            background: #263144 !important;
            color: #fff;
            transition: all 0.3s;
        }

        #sidebar.active {
            margin-left: -250px;
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: yellow !important;
        }

        #sidebar ul.components {
            padding: 10px 0;
        }

        #sidebar ul p {
            color: #fff;
            padding: 8px !important;
        }

        #sidebar ul li a {
            padding: 8px !important;
            font-size: 11px !important;
            display: block;
            color: white !important;
        }

        #sidebar ul li a:hover {
            text-decoration: none;
        }

        #sidebar ul li.active>a,
        a[aria-expanded="true"] {
            color: cyan !important;
            background: #1c9be7 !important;
        }

        a[data-toggle="collapse"] {
            position: relative;
        }

        .dropdown-toggle::after {
            display: block;
            position: absolute;
            color: #1c9be7 !important;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            background: transparent !important;
        }

        ul ul a {
            font-size: 11px !important;
            padding-left: 15px !important;
            background: yellow !important;
            color: yellow !important;
        }

        ul.CTAs {
            font-size: 11px !important;
        }

        ul.CTAs a {
            text-align: center;
            font-size: 11px !important;
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
            color: yellow !important;
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
    <?php
    include 'dbconfig.php';
    ?>
    <div class="wrapper d-flex align-items-stretch">
        <?php
        include 'sidebar.php';
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
                    <div class="container">
                        <h4 class="text-center pb-md-4">Travel Request <?php echo $row['id'] ?> Details</h4>
                        <div class="row pb-1">
                            <!-- row 1 start-->
                            <div class="col-md-3 pb-2">
                                <p>Name:</p>
                                <input type="text" placeholder="<?php echo $row['name'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-3">
                                <p>Department:</p>
                                <input type="text" placeholder="<?php echo $row['department'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-3">
                                <p>Role:</p>
                                <input type="text" placeholder="<?php echo $row['role'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-3">
                                <p>Submission Date:</p>
                                <input type="text" placeholder="<?php echo $row['date'] ?>" readonly class="ready">
                            </div>
                        </div>
                        <!-- row 1 end-->
                        <div class="row pb-2">
                            <div class="col-md-6">
                                <p>Purpose of Travel</p>
                                <input type="text" placeholder="<?php echo $row['purpose'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-6">
                                <p>Reason</p>
                                <input type="text" placeholder="<?php echo $row['reason'] ?>" readonly class="ready">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 pb-2">
                                <p>Departure From</p>
                                <input type="text" placeholder="<?php echo $row['to_1'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-3">
                                <p>To</p>
                                <input type="text" placeholder="<?php echo $row['to_2'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-3">
                                <p>To</p>
                                <input type="text" placeholder="<?php echo $row['to_3'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-3">
                                <p>To</p>
                                <input type="text" placeholder="<?php echo $row['to_4'] ?>" readonly class="ready">
                            </div>
                        </div>
                        <div class="row pb-2">
                            <div class="col-md-3">
                                <p>Preferable Date From</p>
                                <input type="text" placeholder="<?php echo $row['date_1'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-3">
                                <p>To</p>
                                <input type="text" placeholder="<?php echo $row['date_2'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-3">
                                <p>To</p>
                                <input type="text" placeholder="<?php echo $row['date_3'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-3">
                                <p>To</p>
                                <input type="text" placeholder="<?php echo $row['date_4'] ?>" readonly class="ready">
                            </div>
                        </div>
                        <div class="row pb-2">
                            <div class="col-md-3">
                                <p>Preferable Time From</p>
                                <input type="text" placeholder="<?php echo $row['time_1'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-3">
                                <p>To</p>
                                <input type="text" placeholder="<?php echo $row['time_2'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-3">
                                <p>To</p>
                                <input type="text" placeholder="<?php echo $row['time_3'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-3">
                                <p>To</p>
                                <input type="text" placeholder="<?php echo $row['time_4'] ?>" readonly class="ready">
                            </div>
                        </div>
                        <div class="row pb-2">
                            <div class="col-md-4">
                                <p>Preferable Flight</p>
                                <input type="text" placeholder="<?php echo $row['preferable_flight'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-4">
                                <p>Duration of Visit (In Days)</p>
                                <input type="text" placeholder="<?php echo $row['duration'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-4">
                                <p>Expected day of return</p>
                                <input type="text" placeholder="<?php echo $row['expected_days'] ?>" readonly class="ready">
                            </div>
                        </div>
                        <div class="row pb-2">
                            <div class="col-md-4">
                                <p>Mode Of Travel</p>
                                <input type="text" placeholder="<?php echo $row['mode_of_travel'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-4">
                                <p>Hotel Booking Required</p>
                                <input type="text" placeholder="<?php echo $row['hotel_booking'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-4">
                                <p>Visa Required</p>
                                <input type="text" placeholder="<?php echo $row['visa_required'] ?>" readonly class="ready">
                            </div>
                        </div>
                        <h6 class=" py-2">Traveling Advance (For Finance Department)</h6>
                        <div class="row pb-2">
                            <div class="col-md-6">
                                <p for="advance_required">Advance Required</p>
                                <input type="text" placeholder="<?php echo $row['advance_required'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-6">
                                <p for="advance_amount">Advance Amount (PKR)</p>
                                <input type="text" placeholder="<?php echo $row['advance_amount'] ?>" readonly class="ready">
                            </div>
                        </div>
                        <!-- fetch ends -->





                        <!-- final starts  -->
                        <h4 class="pt-5 pb-3 text-center">Final Flight Details</h4>
                        <div class="row pb-2">
                            <div class="col-md-3">
                                <p for="up_to_1">Departure from</p>
                                <input type="text" placeholder="<?php echo $row['up_to_1'] ?>" readonly class="ready">

                                </select>
                            </div>
                            <div class="col-md-3">
                                <p for="up_to_1">To</p>
                                <input type="text" placeholder="<?php echo $row['up_to_2'] ?>" readonly class="ready">

                            </div>
                            <div class="col-md-3">
                                <p for="up_to_2">To</p>
                                <input type="text" placeholder="<?php echo $row['up_to_3'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-3">
                                <p for="up_to_2">To</p>
                                <input type="text" placeholder="<?php echo $row['up_to_4'] ?>" readonly class="ready">
                            </div>
                        </div>
                        <div class="row pb-2">
                            <div class="col-md-3">
                                <p for="up_date_1">Date From</p>
                                <input type="text" placeholder="<?php echo $row['up_date_1'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-3">
                                <p for="to_1">To</p>
                                <input type="text" placeholder="<?php echo $row['up_date_2'] ?>" readonly class="ready">

                            </div>
                            <div class="col-md-3">
                                <p for="up_to_2">To</p>
                                <input type="text" placeholder="<?php echo $row['up_date_3'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-3">
                                <p for="up_to_3">To</p>
                                <input type="text" placeholder="<?php echo $row['up_date_4'] ?>" readonly class="ready">
                            </div>
                        </div>
                        <div class="row pb-2">
                            <div class="col-md-3">
                                <p for="up_date_1">Preferable Time From</p>
                                <input type="text" placeholder="<?php echo $row['up_time_1'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-3">
                                <p for="up_time_2">To</p>
                                <input type="text" placeholder="<?php echo $row['up_time_2'] ?>" readonly class="ready">

                            </div>
                            <div class="col-md-3">
                                <p for="up_time_3">To</p>
                                <input type="text" placeholder="<?php echo $row['up_time_3'] ?>" readonly class="ready">

                            </div>
                            <div class="col-md-3">
                                <p for="up_time_4">To</p>
                                <input type="text" placeholder="<?php echo $row['up_time_4'] ?>" readonly class="ready">
                            </div>
                        </div>
                        <div class="row pb-2">
                            <div class="col-md-4">
                                <p for="up_preferable_flight">Preferable Flight</p>
                                <input type="text" placeholder="<?php echo $row['up_flight_details'] ?>" readonly class="ready">
                            </div>

                            <div class="col-md-4">
                                <p for="up_flight_nos">Flight Nos</p>
                                <input type="text" placeholder="<?php echo $row['up_flight_nos'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-4">
                                <p for="up_airline_cost">Airline Cost</p>
                                <input type="text" placeholder="<?php echo $row['up_flight_cost'] ?>" readonly class="ready">
                            </div>
                        </div>
                        <div class="row pb-2">
                            <div class="col-md-4">
                                <p for="up_mode_of_travel">Hotel Cost</p>
                                <input type="text" placeholder="<?php echo $row['up_hotel_cost'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-4">
                                <p for="up_transport_cost">Transport Cost</p>
                                <input type="text" placeholder="<?php echo $row['up_transport_cost'] ?>" readonly class="ready">

                            </div>
                            <div class="col-md-4">
                                <p for="up_visa_cost">Visa Cost</p>
                                <input type="text" placeholder="<?php echo $row['up_visa_cost'] ?>" readonly class="readyk">

                            </div>
                        </div>
                        <div class="row pb-2">
                            <div class="col-md-4">
                                <p for="up_other">Other</p>
                                <input type="text" placeholder="<?php echo $row['up_other_cost'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-4">
                                <p for="up_estimate_cost">Travel Estimate Cost</p>
                                <input type="text" placeholder="<?php echo $row['up_total_cost'] ?>" readonly class="ready">
                            </div>

                            <div class="col-md-4">
                                <p for="up_agent_name">Name of Travel Agent</p>
                                <input type="text" placeholder="<?php echo $row['up_agent_name'] ?>" readonly class="ready">
                            </div>
                        </div>
                        <p style="font-weight:600" class="py-2"> Representation of Travel Agent who has booked Flight</p>
                        <div class="row">
                            <div class="col-md-6">
                                <p for="up_repname">Name</p>
                                <input type="text" placeholder="<?php echo $row['up_repname'] ?>" readonly class="ready">
                            </div>
                            <div class="col-md-6">
                                <p for="up_repcontact">Contact No</p>
                                <input type="text" placeholder="<?php echo $row['up_repcontact'] ?>" readonly class="ready">
                            </div>
                        </div>
                        <!-- final ends -->

                        <!-- admin input starts -->
                        <form class="form" method="POST" style="border: 2px solid whites;">
                            <h4 class="pt-5 pb-3 text-center">Travel Desk</h4>

                            <div class="row">
                                <div class="col">
                                    <table class="table table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Category</th>
                                                <th>Ac. Amount</th>
                                                <th>Est. Amount</th>
                                                <th>Invoice</th>
                                                <th>Supplier</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Airline</td>
                                                <td> <input type="text" placeholder="<?php echo $row['fi_airline_cost'] ?>" readonly class="ready travel-desk"></td>
                                                <td> <input type="text" placeholder="<?php echo $row['up_flight_cost'] ?>" readonly class="ready travel-desk"></td>
                                                <td> <input type="text" placeholder="<?php echo $row['fi_airline_invoice'] ?>" readonly class="ready travel-desk"></td>
                                                <td> <input type="text" placeholder="<?php echo $row['fi_airline_supplier'] ?>" readonly class="ready travel-desk"></td>
                                                <td> <input type="text" placeholder="<?php echo $row['fi_date_1'] ?>" readonly class="ready travel-desk"></td>
                                            </tr>
                                            <tr>
                                                <td>Hotel</td>
                                                <td> <input type="text" placeholder="<?php echo $row['fi_hotel_cost'] ?>" readonly class="ready travel-desk"></td>
                                                <td> <input type="text" placeholder="<?php echo $row['up_hotel_cost'] ?>" readonly class="ready travel-desk"></td>
                                                <td> <input type="text" placeholder="<?php echo $row['fi_hotel_invoice'] ?>" readonly class="ready travel-desk"></td>
                                                <td> <input type="text" placeholder="<?php echo $row['fi_hotel_supplier'] ?>" readonly class="ready travel-desk"></td>
                                                <td> <input type="text" placeholder="<?php echo $row['fi_date_2'] ?>" readonly class="ready travel-desk"></td>
                                            </tr>
                                            <tr>
                                                <td>Transport</td>
                                                <td> <input type="text" placeholder="<?php echo $row['fi_transport_cost'] ?>" readonly class="ready travel-desk"></td>
                                                <td> <input type="text" placeholder="<?php echo $row['up_transport_cost'] ?>" readonly class="ready travel-desk"></td>
                                                <td> <input type="text" placeholder="<?php echo $row['fi_transport_invoice'] ?>" readonly class="ready travel-desk"></td>
                                                <td> <input type="text" placeholder="<?php echo $row['fi_transport_supplier'] ?>" readonly class="ready travel-desk"></td>
                                                <td> <input type="text" placeholder="<?php echo $row['fi_date_3'] ?>" readonly class="ready travel-desk"></td>

                                            </tr>
                                            <tr>
                                                <td>Visa</td>
                                                <td> <input type="text" placeholder="<?php echo $row['fi_visa_cost'] ?>" readonly class="ready travel-desk"></td>
                                                <td> <input type="text" placeholder="<?php echo $row['up_visa_cost'] ?>" readonly class="ready travel-desk"></td>
                                                <td> <input type="text" placeholder="<?php echo $row['fi_visa_invoice'] ?>" readonly class="ready travel-desk"></td>
                                                <td> <input type="text" placeholder="<?php echo $row['fi_visa_supplier'] ?>" readonly class="ready travel-desk"></td>
                                                <td> <input type="text" placeholder="<?php echo $row['fi_date_4'] ?>" readonly class="ready travel-desk"></td>
                                            </tr>
                                            <tr>
                                                <td>Other</td>
                                                <td> <input type="text" placeholder="<?php echo $row['fi_other_cost'] ?>" readonly class="ready travel-desk"></td>
                                                <td> <input type="text" placeholder="<?php echo $row['up_other_cost'] ?>" readonly class="ready travel-desk"></td>
                                                <td> <input type="text" placeholder="<?php echo $row['fi_other_invoice'] ?>" readonly class="ready travel-desk"></td>
                                                <td> <input type="text" placeholder="<?php echo $row['fi_other_supplier'] ?>" readonly class="ready travel-desk"></td>
                                                <td> <input type="text" placeholder="<?php echo $row['fi_date_5'] ?>" readonly class="ready travel-desk"></td>
                                            </tr>
                                            <tr>
                                                <td>Total</td>
                                                <td> <input type="text" placeholder="<?php echo $row['fi_total_cost'] ?>" readonly class="ready travel-desk"></td>
                                                <td> <input type="text" placeholder="<?php echo $row['up_total_cost'] ?>" readonly class="ready travel-desk"></td>
                                            </tr>
                                        </tbody>
                                    </table>

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
                        $name =  $_SESSION['fullname'];
                        $date =  date('Y-m-d H:i:s');


                        $fi_airline_amount = $_POST['fi_airline_amount'];
                        $fi_hotel_amount = $_POST['fi_hotel_amount'];
                        $fi_transport_amount = $_POST['fi_transport_amount'];
                        $fi_visa_amount = $_POST['fi_visa_amount'];
                        $fi_other_amount = $_POST['fi_other_amount'];
                        $fi_total_amount = $_POST['fi_total_amount'];

                        $fi_airline_invoice = $_POST['fi_airline_invoice'];
                        $fi_hotel_invoice = $_POST['fi_hotel_invoice'];
                        $fi_transport_invoice = $_POST['fi_transport_invoice'];
                        $fi_visa_invoice = $_POST['fi_visa_invoice'];
                        $fi_other_invoice = $_POST['fi_other_invoice'];

                        $fi_airline_supplier = $_POST['fi_airline_supplier'];
                        $fi_hotel_supplier = $_POST['fi_hotel_supplier'];
                        $fi_transport_supplier = $_POST['fi_transport_supplier'];
                        $fi_visa_supplier = $_POST['fi_visa_supplier'];
                        $fi_other_supplier = $_POST['fi_other_supplier'];

                        $fi_date_1 = $_POST['fi_date_1'];
                        $fi_date_2 = $_POST['fi_date_2'];
                        $fi_date_3 = $_POST['fi_date_3'];
                        $fi_date_4 = $_POST['fi_date_4'];
                        $fi_date_5 = $_POST['fi_date_5'];

                        // Update query
                        $update_query = "UPDATE trf SET 
                    
                    fi_airline_cost = '$fi_airline_amount',
                    fi_hotel_cost  = '$fi_hotel_amount',
                    fi_transport_cost  = '$fi_transport_amount',
                    fi_visa_cost  = '$fi_visa_amount',
                    fi_other_cost  = '$fi_other_amount',
                    fi_total_cost  = '$fi_total_amount',

                    fi_airline_invoice = '$fi_airline_invoice',
                    fi_hotel_invoice = '$fi_hotel_invoice',
                    fi_transport_invoice = '$fi_transport_invoice',
                    fi_visa_invoice = '$fi_visa_invoice',
                    fi_other_invoice = '$fi_other_invoice',

                    fi_airline_supplier = '$fi_airline_supplier',
                    fi_hotel_supplier = '$fi_hotel_supplier',
                    fi_transport_supplier = '$fi_transport_supplier',
                    fi_visa_supplier = '$fi_visa_supplier',
                    fi_other_supplier = '$fi_other_supplier',

                    fi_date_1 = '$fi_date_1',
                    fi_date_2 = '$fi_date_2',
                    fi_date_3 = '$fi_date_3',
                    fi_date_4 = '$fi_date_4',
                    fi_date_5 = '$fi_date_5',

                    finance_date = '$date',
                    finance_name = '$name',
                    finance_status = 'Approved'

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
                    <!-- admin input ends -->
        </div>
    </div>
    <!-- row 6 end-->
    </div>
    <!-- container end-->
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
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="libs/js-xlsx/xlsx.core.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
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
            $('#myTable').tableExport({
                type: 'excel',
                ignoreColumn: [16]
            });
        });
    });
</script>
<!-- ALL -->
<script>
    $(document).ready(function() {
        (function($) {
            $('#filter').keyup(function() {
                var rex = new RegExp($(this).val(), 'i');
                $('.searchable tr').hide();
                $('.searchable tr').filter(function() {
                    return rex.test($(this).text());
                }).show();
            })
        }(jQuery));
    });
</script>
<script src="assets/js/main.js"></script>
</body>

</html>