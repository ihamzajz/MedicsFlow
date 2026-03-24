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
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon1.png" />
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

        .btn {
            border-radius: 0px !important;
        }

        .btn-menu {
            font-size: 11px !important;
            border-radius: 0px !important;
        }

        p {
            font-size: 12.5px !important;
            padding: 0px !important;
            margin: 0px !important;
            font-weight: 500;
        }

        input[type="text"] {
            font-size: 12px;
            padding: 5px;
            color: black !important;
            width: 100%;
            font-weight: 500;
        }

        ::placeholder {
            color: grey !important;
        }

        textarea {
            font-size: 12px;
            padding: 5px;
            color: grey !important;
            width: 100%;
            font-weight: 500;
        }
    </style>

    <style>
        /* ===== Sidebar Layout ===== */
        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        /* ✅ CLOSED by default (support both ids) */
        #sidebar,
        #sidebar1 {
            min-width: 250px;
            max-width: 250px;
            background: #263144 !important;
            color: #fff;
            transition: all 0.3s ease;
            margin-left: -250px; /* hidden initially */
        }

        /* ✅ OPEN state */
        #sidebar.active,
        #sidebar1.active {
            margin-left: 0;
        }

        /* Sidebar header */
        #sidebar .sidebar-header,
        #sidebar1 .sidebar-header {
            padding: 20px;
            background: #0d9276 !important;
        }

        /* Sidebar links */
        #sidebar ul.components,
        #sidebar1 ul.components {
            padding: 10px 0;
        }

        #sidebar ul li a,
        #sidebar1 ul li a {
            padding: 8px !important;
            font-size: 11px !important;
            display: block;
            color: #fff !important;
            position: relative;
        }

        #sidebar ul li a:hover,
        #sidebar1 ul li a:hover {
            text-decoration: none;
        }

        #sidebar ul li.active>a,
        #sidebar1 ul li.active>a,
        a[aria-expanded="true"] {
            background: #1c9be7 !important;
            color: cyan !important;
        }

        /* Content area */
        #content {
            width: 100%;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Mobile */
        @media (max-width: 768px) {
            #sidebar,
            #sidebar1 {
                margin-left: -250px;
            }

            #sidebar.active,
            #sidebar1.active {
                margin-left: 0;
            }
        }
    </style>
<?php include 'workorder_nav_theme.php'; ?>
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
            <?php
            include 'dbconfig.php';

            $id = $_GET['id'];
            $select = "SELECT * FROM workorder_form WHERE
                    id = '$id' ";

            $select_q = mysqli_query($conn, $select);
            $data = mysqli_num_rows($select_q);
            ?>
            <?php
            if ($data) {
                while ($row = mysqli_fetch_array($select_q)) {
            ?>
                    <div class="container" style="background-color:White;border:1px solid black">
                        <a class="btn btn-dark btn-sm mt-1" href="workorder_home.php" style="font-size:11px!important"><i class="fa-solid fa-arrow-left"></i> Home</a>
                        <a class="btn btn-dark btn-sm mt-1" href="workorder_engineeringall_list.php" style="font-size:11px!important"><i class="fa-solid fa-arrow-left"></i> Back</a>

                        <h6 class="text-center pb-5 pt-3" style="font-weight:bold">Work Order <?php echo $row['id'] ?> Details</h6>
                        <div class="row pb-1">
                            <!-- row 1 start-->
                            <div class="col-md-3">
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
                        <hr>
                        <!-- row 1 end-->

                        <!-- row 2.1 start-->
                        <div class="row pb-1">
                            <div class="col-md-3">
                                <p>Type:</p>
                                <input type="text" placeholder="<?php echo $row['type'] ?>" readonly class="mb-2">
                                <p>Category:</p>
                                <input type="text" placeholder="<?php echo $row['category'] ?>" readonly class="mb-2">
                                <p>Amount:</p>
                                <input type="text" placeholder="<?php echo $row['amount'] ?>" readonly class="mb-2">
                            </div>
                            <div class="col-md-6">
                                <p>Discription:</p>
                                <textarea placeholder="<?php echo $row['description'] ?>" readonly rows="50" cols="50" style="height:100px!important"></textarea>
                            </div>
                        </div>

                        <div class="row pb-2">
                            <div class="col-md-3">
                                <p>Head Status:</p>
                                <input type="text" placeholder="<?php echo $row['head_status'] ?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <p>Head Message:</p>
                                <input type="text" placeholder="<?php echo $row['head_msg'] ?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <p>Head Date:</p>
                                <input type="text" placeholder="<?php echo $row['head_date'] ?>" readonly>
                            </div>
                        </div>

                        <div class="row pb-2">
                            <div class="col-md-3">
                                <p>Engineering Status:</p>
                                <input type="text" placeholder="<?php echo $row['engineering_status'] ?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <p>Engineering Message:</p>
                                <input type="text" placeholder="<?php echo $row['engineering_msg'] ?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <p>Engineering Date:</p>
                                <input type="text" placeholder="<?php echo $row['eng_date'] ?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <p>Engineering Reject Reason:</p>
                                <input type="text" placeholder="<?php echo $row['reason'] ?>" readonly>
                            </div>
                        </div>

                        <div class="row pb-2">
                            <div class="col-md-3">
                                <p>Admin Status:</p>
                                <input type="text" placeholder="<?php echo $row['admin_status'] ?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <p>Admin Message:</p>
                                <input type="text" placeholder="<?php echo $row['admin_msg'] ?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <p>Admin Date:</p>
                                <input type="text" placeholder="<?php echo $row['admin_date'] ?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <p>Admin Reject Reason:</p>
                                <input type="text" placeholder="<?php echo $row['reason'] ?>" readonly>
                            </div>
                        </div>

                        <div class="row pb-1">
                            <div class="col-md-3">
                                <p>Finance Status:</p>
                                <input type="text" placeholder="<?php echo $row['finance_status'] ?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <p>Finance Message:</p>
                                <input type="text" placeholder="<?php echo $row['finance_msg'] ?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <p>Finance Date:</p>
                                <input type="text" placeholder="<?php echo $row['fc_date'] ?>" readonly>
                            </div>
                        </div>

                        <hr>
                        <div class="row pb-4">
                            <div class="col-md-6">
                                <p>Closeout Date:</p>
                                <input type="text" placeholder="<?php echo $row['closeout_date'] ?>" readonly class="mb-1">
                                <p>Closeout Remarks:</p>
                                <textarea placeholder="<?php echo $row['closeout'] ?>" readonly rows=3 cols="50" style="height:100px!important"></textarea>
                            </div>
                            <div class="col-md-4">
                                <p>Task Status:</p>
                                <textarea placeholder="<?php echo $row['task_status'] ?>" readonly rows=2 cols="40"></textarea>
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
    <!--content-->
    </div> <!--wrapper-->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function() {

            // ✅ Find sidebar even if sidebar1.php uses a different id
            var $sidebar = $('#sidebar');
            if ($sidebar.length === 0) $sidebar = $('#sidebar1');
            if ($sidebar.length === 0) $sidebar = $('nav[id*="sidebar"]').first(); // fallback
            if ($sidebar.length === 0) $sidebar = $('.sidebar').first();           // fallback

            // ✅ Force CLOSED on page load
            $sidebar.removeClass('active');

            // ✅ Always bind toggle (even if DOM changes)
            $(document).on('click', '#sidebarCollapse', function(e) {
                e.preventDefault();
                $sidebar.toggleClass('active');
            });

        });
    </script>

</body>

</html>

