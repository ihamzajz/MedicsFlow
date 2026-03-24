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
            input {
            font-size: 13px !important;
            width: 100% !important;
            height: 25px !important;
            padding: 5px 5px !important;
            }
            textarea,
            select,
            option {
            font-size: 13px !important;
            width: 100% !important;
            height: 25px !important;
            padding: 5px 5px !important;
            }
            ::placeholder {
            color: black;
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
                            <a class="btn btn-dark btn-sm mt-1" href="trf_admin_list.php" style="font-size:11px!important">
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
                    <div class="row pb-2 pt-5">
                        <h6 class="fw-bold pb-2 text-primary">User Request</h6>
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
                    <div class="row pb-2">
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
                    <p class="py-2 fw-bold text-secondary">Traveling Advance (For Finance Department)</p>
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
                    <!-- admin input starts -->
                    <form class="form" method="POST" style="border: 2px solid whites;">
                        <h6 class="fw-bold pt-5 pb-2 text-primary">Final Details By Admin</h6>
                        <div class="row pb-2">
                            <div class="col-md-3">
                                <p for="up_to_1">Departure from</p>
                                <select id="admin_to_1" name="admin_to_1" class="w-100" value="<?php echo $row['admin_to_1']; ?>">
                                <option value="" disabled selected>Select</option>
                                    <option value="Karachi" <?php if ($row['admin_to_1'] == 'Karachi') echo 'selected'; ?>>Karachi</option>
                                    <option value="Lahore" <?php if ($row['admin_to_1'] == 'Lahore') echo 'selected'; ?>>Lahore</option>
                                    <option value="Peshawar" <?php if ($row['admin_to_1'] == 'Peshawar') echo 'selected'; ?>>Peshawar</option>
                                    <option value="Islamabad" <?php if ($row['admin_to_1'] == 'Islamabad') echo 'selected'; ?>>Islamabad</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <p for="up_to_1">To</p>
                                <select id="admin_to_1" name="admin_to_2" class="w-100" value="<?php echo $row['admin_to_2']; ?>">
                                <option value="" disabled selected>Select</option>
                                    <option value="Karachi" <?php if ($row['admin_to_2'] == 'Karachi') echo 'selected'; ?>>Karachi</option>
                                    <option value="Lahore" <?php if ($row['admin_to_2'] == 'Lahore') echo 'selected'; ?>>Lahore</option>
                                    <option value="Peshawar" <?php if ($row['admin_to_2'] == 'Peshawar') echo 'selected'; ?>>Peshawar</option>
                                    <option value="Islamabad" <?php if ($row['admin_to_2'] == 'Islamabad') echo 'selected'; ?>>Islamabad</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <p for="up_to_2">To</p>
                                <select id="admin_to_2" name="admin_to_3" class="w-100" value="<?php echo $row['admin_to_3']; ?>">
                                <option value="" disabled selected>Select</option>
                                    <option value="Karachi" <?php if ($row['admin_to_3'] == 'Karachi') echo 'selected'; ?>>Karachi</option>
                                    <option value="Lahore" <?php if ($row['admin_to_3'] == 'Lahore') echo 'selected'; ?>>Lahore</option>
                                    <option value="Peshawar" <?php if ($row['admin_to_3'] == 'Peshawar') echo 'selected'; ?>>Peshawar</option>
                                    <option value="Islamabad" <?php if ($row['admin_to_3'] == 'Islamabad') echo 'selected'; ?>>Islamabad</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <p for="up_to_2">To</p>
                                <select id="admin_to_2" name="admin_to_4" class="w-100" value="<?php echo $row['admin_to_4']; ?>">
                                <option value="" disabled selected>Select</option>
                                    <option value="Karachi" <?php if ($row['admin_to_4'] == 'Karachi') echo 'selected'; ?>>Karachi</option>
                                    <option value="Lahore" <?php if ($row['admin_to_4'] == 'Lahore') echo 'selected'; ?>>Lahore</option>
                                    <option value="Peshawar" <?php if ($row['admin_to_4'] == 'Peshawar') echo 'selected'; ?>>Peshawar</option>
                                    <option value="Islamabad" <?php if ($row['admin_to_4'] == 'Islamabad') echo 'selected'; ?>>Islamabad</option>
                                </select>
                            </div>
                        </div>
                        <div class="row pb-2">
                            <div class="col-md-3">
                                <p for="up_date_1">Date From</p>
                                <input type="date" name="admin_date_1" class="w-100" value="<?php echo $row['admin_date_1']; ?>">
                            </div>
                            <div class="col-md-3">
                                <p for="to_1">To</p>
                                <input type="date" name="admin_date_2" class="w-100" value="<?php echo $row['admin_date_2']; ?>">
                            </div>
                            <div class="col-md-3">
                                <p for="up_to_2">To</p>
                                <input type="date" name="admin_date_3" class="w-100" value="<?php echo $row['admin_date_3']; ?>">
                            </div>
                            <div class="col-md-3">
                                <p for="up_to_3">To</p>
                                <input type="date" name="admin_date_4" class="w-100" value="<?php echo $row['admin_date_4']; ?>">
                            </div>
                        </div>
                        <div class="row pb-2">
                            <div class="col-md-3">
                                <p for="up_date_1">Preferable Time From</p>
                                <input type="time" name="admin_time_1" class="w-100" value="<?php echo $row['admin_time_1']; ?>">
                            </div>
                            <div class="col-md-3">
                                <p for="up_time_2">To</p>
                                <input type="time" name="admin_time_2" class="w-100" value="<?php echo $row['admin_time_2']; ?>">
                            </div>
                            <div class="col-md-3">
                                <p for="up_time_3">To</p>
                                <input type="time" name="admin_time_3" class="w-100" value="<?php echo $row['admin_time_3']; ?>">
                            </div>
                            <div class="col-md-3">
                                <p for="up_time_4">To</p>
                                <input type="time" name="admin_time_4" class="w-100" value="<?php echo $row['admin_time_4']; ?>">
                            </div>
                        </div>
                        <div class="row pb-2">
                            <div class="col-md-4">
                                <p for="up_preferable_flight">Preferable Flight</p>
                                <select id="admin_preferable_flight" name="admin_preferable_flight" class="w-100">
                                <option value="" disabled selected>Select</option>
                                    <option value="Air Blue" <?php if ($row['admin_flight_details'] == 'Air Blue') echo 'selected'; ?>>Air Blue</option>
                                    <option value="Emirates" <?php if ($row['admin_flight_details'] == 'Emirates') echo 'selected'; ?>>Emirates</option>
                                    <option value="PIA" <?php if ($row['admin_flight_details'] == 'PIA') echo 'selected'; ?>>PIA</option>
                                    <option value="Serene Air" <?php if ($row['admin_flight_details'] == 'Serene Air') echo 'selected'; ?>>Serene Air</option>
                                    <option value="Shaheen" <?php if ($row['admin_flight_details'] == 'Shaheen') echo 'selected'; ?>>Shaheen</option>
                                    <option value="Thai Airline" <?php if ($row['admin_flight_details'] == 'Thai Airline') echo 'selected'; ?>>Thai Airline</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <p for="up_flight_nos">Flight Nos</p>
                                <input type="text" id="admin_flight_nos" name="admin_flight_nos" autocomplete="off" value="<?php echo $row['admin_flight_nos']; ?>"
                                    class="w-100">
                            </div>
                            <div class="col-md-4">
                                <p for="up_airline_cost">Airline Cost</p>
                                <input type="number" id="admin_airline_cost" name="admin_airline_cost" class="w-100" 
                                    value="<?php echo $row['admin_flight_cost']; ?>">                             
                            </div>
                            <div class="row pb-2 pt-2">
                                <div class="col-md-4">
                                    <p for="up_mode_of_travel">Hotel Cost</p>
                                    <input type="text" id="admin_hotel_cost" name="admin_hotel_cost" autocomplete="off" value="<?php echo $row['admin_hotel_cost']; ?>"
                                        class="w-100">
                                </div>
                                <div class="col-md-4">
                                    <p for="up_transport_cost">Transport Cost</p>
                                    <input type="text" id="admin_transport_cost" name="admin_transport_cost" autocomplete="off" value="<?php echo $row['admin_transport_cost']; ?>"
                                        class="w-100">
                                </div>
                                <div class="col-md-4">
                                    <p for="up_visa_cost">Visa Cost</p>
                                    <input type="text" id="admin_visa_cost" name="admin_visa_cost" autocomplete="off" value="<?php echo $row['admin_visa_cost']; ?>"
                                        class="w-100">
                                </div>
                            </div>
                            <div class="row pb-2 pt-2">
                                <div class="col-md-4">
                                    <p for="up_other">Other Cost</p>
                                    <input type="text" id="admin_other_cost" name="admin_other_cost" autocomplete="off" value="<?php echo $row['admin_other_cost']; ?>"
                                        class="w-100">
                                </div>
                                <div class="col-md-4">
                                    <p for="up_estimate_cost">Travel Estimate Cost</p>
                                    <input type="text" id="admin_estimate_cost" name="admin_estimate_cost" autocomplete="off" 
                                        value="<?php echo $row['admin_total_cost']; ?>" class="w-100">
                                </div>
                                <div class="col-md-4">
                                    <p for="up_agent_name">Name of Travel Agent</p>
                                    <input type="text" id="admin_agent_name" name="admin_agent_name" autocomplete="off" value="<?php echo $row['admin_agent_name']; ?>"
                                        class="w-100">
                                </div>
                            </div>
                            <p style="font-weight:600" class="py-2"> Representation of Travel Agent who has booked Flight</p>
                            <div class="row pb-2">
                                <div class="col-md-6">
                                    <p for="up_repname">Name</p>
                                    <input type="text" id="admin_repname" name="admin_repname" autocomplete="off" class="w-100" value="<?php echo $row['admin_repname']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <p for="up_repcontact">Contact No</p>
                                    <input type="text" id="admin_repcontact" name="admin_repcontact" autocomplete="off" value="<?php echo $row['admin_repcontact']; ?>"
                                        class="w-100">
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <button class="slide" name="submit" style="font-size: 17px; height: 36px; width: 150px;">
                                <span class="text">Submit</span>
                                </button>
                            </div>
                            <!-- <td><a href="trf_admin_approve.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email']; ?>&name=<?php echo $row['name']; ?>"
                                class="btn-approve"><i class="fa-solid fa-check"></i> Approve</a></td>
                                <td><a href="trf_admin_reject.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email']; ?>&name=<?php echo $row['name']; ?>"
                                class="btn-reject"><i class="fa-solid fa-xmark"></i> Reject</a></td> -->
                                <div class="row align-items-center mb-2">
    <div class="col-12 mb-2">
        <p class="fw-bold mb-1">Approval</p>
    </div>

    <?php if ($row['admin_status'] === 'Pending') { ?>
        <div class="col-auto">
            <a href="trf_admin_approve.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email']; ?>&name=<?php echo $row['name']; ?>" 
                class="btn-approve">
                <i class="fa-solid fa-check"></i> Approve
            </a>
        </div>
        <div class="col-auto">
            <a href="trf_admin_reject.php?id=<?php echo $row['id']; ?>&email=<?php echo $row['email']; ?>&name=<?php echo $row['name']; ?>" 
                class="btn-reject">
                <i class="fa-solid fa-xmark"></i> Reject
            </a>
        </div>
    <?php } else { ?>
        <div class="col-auto">
            <span class="badge <?php echo $row['admin_status'] === 'Approved' ? 'bg-success' : 'bg-danger'; ?>">
                <?php echo $row['admin_status']; ?>
            </span>
        </div>
    <?php } ?>
</div>

                    </form>
                    <?php
                        include 'dbconfig.php';
                        
                        // Check if form is submitted
                        if (isset($_POST['submit'])) {
                        
                            // Retrieve form data
                            $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                            $name = $_SESSION['fullname'];
                            $date = date('Y-m-d');
                        
                            $admin_to_1 = isset($_POST['admin_to_1']) && $_POST['admin_to_1'] !== $row['admin_to_1'] ? $_POST['admin_to_1'] : $row['admin_to_1'];
                            $admin_to_2 = isset($_POST['admin_to_2']) && $_POST['admin_to_2'] !== $row['admin_to_2'] ? $_POST['admin_to_2'] : $row['admin_to_2'];
                            $admin_to_3 = isset($_POST['admin_to_3']) && $_POST['admin_to_3'] !== $row['admin_to_3'] ? $_POST['admin_to_3'] : $row['admin_to_3'];
                            $admin_to_4 = isset($_POST['admin_to_4']) && $_POST['admin_to_4'] !== $row['admin_to_4'] ? $_POST['admin_to_4'] : $row['admin_to_4'];
                        
                            $admin_date_1 = isset($_POST['admin_date_1']) && $_POST['admin_date_1'] !== $row['admin_date_1'] ? $_POST['admin_date_1'] : $row['admin_date_1'];
                            $admin_date_2 = isset($_POST['admin_date_2']) && $_POST['admin_date_2'] !== $row['admin_date_2'] ? $_POST['admin_date_2'] : $row['admin_date_2'];
                            $admin_date_3 = isset($_POST['admin_date_3']) && $_POST['admin_date_3'] !== $row['admin_date_3'] ? $_POST['admin_date_3'] : $row['admin_date_3'];
                            $admin_date_4 = isset($_POST['admin_date_4']) && $_POST['admin_date_4'] !== $row['admin_date_4'] ? $_POST['admin_date_4'] : $row['admin_date_4'];
                        
                            $admin_time_1 = isset($_POST['admin_time_1']) && $_POST['admin_time_1'] !== $row['admin_time_1'] ? $_POST['admin_time_1'] : $row['admin_time_1'];
                            $admin_time_2 = isset($_POST['admin_time_2']) && $_POST['admin_time_2'] !== $row['admin_time_2'] ? $_POST['admin_time_2'] : $row['admin_time_2'];
                            $admin_time_3 = isset($_POST['admin_time_3']) && $_POST['admin_time_3'] !== $row['admin_time_3'] ? $_POST['admin_time_3'] : $row['admin_time_3'];
                            $admin_time_4 = isset($_POST['admin_time_4']) && $_POST['admin_time_4'] !== $row['admin_time_4'] ? $_POST['admin_time_4'] : $row['admin_time_4'];
                        
                            $admin_preferable_flight = isset($_POST['admin_preferable_flight']) && $_POST['admin_preferable_flight'] !== $row['admin_flight_details'] ? $_POST['admin_preferable_flight'] : $row['admin_flight_details'];
                            $admin_flight_nos = isset($_POST['admin_flight_nos']) && $_POST['admin_flight_nos'] !== $row['admin_flight_nos'] ? $_POST['admin_flight_nos'] : $row['admin_flight_nos'];
                        
                            $admin_airline_cost = isset($_POST['admin_airline_cost']) && $_POST['admin_airline_cost'] !== $row['admin_flight_cost'] ? $_POST['admin_airline_cost'] : $row['admin_flight_cost'];
                            $admin_hotel_cost = isset($_POST['admin_hotel_cost']) && $_POST['admin_hotel_cost'] !== $row['admin_hotel_cost'] ? $_POST['admin_hotel_cost'] : $row['admin_hotel_cost'];
                            $admin_transport_cost = isset($_POST['admin_transport_cost']) && $_POST['admin_transport_cost'] !== $row['admin_transport_cost'] ? $_POST['admin_transport_cost'] : $row['admin_transport_cost'];
                            $admin_visa_cost = isset($_POST['admin_visa_cost']) && $_POST['admin_visa_cost'] !== $row['admin_visa_cost'] ? $_POST['admin_visa_cost'] : $row['admin_visa_cost'];
                        
                            $admin_other_cost = isset($_POST['admin_other_cost']) && $_POST['admin_other_cost'] !== $row['admin_other_cost'] ? $_POST['admin_other_cost'] : $row['admin_other_cost'];
                            $admin_repname = isset($_POST['admin_repname']) && $_POST['admin_repname'] !== $row['admin_repname'] ? $_POST['admin_repname'] : $row['admin_repname'];
                            $admin_agent_name = isset($_POST['admin_agent_name']) && $_POST['admin_agent_name'] !== $row['admin_agent_name'] ? $_POST['admin_agent_name'] : $row['admin_agent_name'];
                            $admin_estimate_cost = isset($_POST['admin_estimate_cost']) && $_POST['admin_estimate_cost'] !== $row['admin_total_cost'] ? $_POST['admin_estimate_cost'] : $row['admin_total_cost'];
                            $admin_repcontact = isset($_POST['admin_repcontact']) && $_POST['admin_repcontact'] !== $row['admin_repcontact'] ? $_POST['admin_repcontact'] : $row['admin_repcontact'];
                        
                        
                        
                            // Update query
                            // Update query
                            $update_query = "UPDATE trf SET 
                        
                        admin_to_1 = '$admin_to_1',
                        admin_to_2 = '$admin_to_2',
                        admin_to_3 = '$admin_to_3',
                        admin_to_4 = '$admin_to_4',
                        
                        admin_date_1 = '$admin_date_1',
                        admin_date_2 = '$admin_date_2',
                        admin_date_3 = '$admin_date_3',
                        admin_date_4 = '$admin_date_4',
                        
                        admin_time_1 = '$admin_time_1',
                        admin_time_2 = '$admin_time_2',
                        admin_time_3 = '$admin_time_3',
                        admin_time_4 = '$admin_time_4',
                        
                        admin_flight_details = '$admin_preferable_flight',
                        admin_flight_nos = '$admin_flight_nos',
                        admin_flight_cost = '$admin_airline_cost',
                        admin_hotel_cost = '$admin_hotel_cost',
                        admin_transport_cost = '$admin_transport_cost',
                        admin_visa_cost = '$admin_visa_cost',
                        admin_other_cost = '$admin_other_cost',
                        
                        admin_repname = '$admin_repname',
                        admin_agent_name = '$admin_agent_name',
                        admin_repcontact = '$admin_repcontact',
                        admin_total_cost = '$admin_estimate_cost',
                        
                        admin_date = '$date',
                        admin_name = '$name',
                        admin_status = 'Approved'
                        
                        WHERE id = '$id'";
                            $result = mysqli_query($conn, $update_query);
                        
                            if ($result) {
                                echo "<script>
                                    alert('Record updated successfully!');
                                    window.location.href = window.location.href; // reload page with same GET parameters
                                </script>";
                            } else {
                                echo "<script>alert('Update failed!');</script>";
                            }
                            
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
                }
                } else {
                echo "No record found!";
                }
                ?>
        </div>
        </div>
        </div>
        <?php
            include "footer.php"
                ?>