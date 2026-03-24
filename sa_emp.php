<?php 
    include 'dbconfig.php';
        session_start (); 
        
        
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Staff Allocation Data Entry</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <link rel="stylesheet" href="assets/css/style.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style>
            body {
font-family: 'Poppins', sans-serif;
}

            label{
            font-size: 15px!important;
            font-weight: 500!important;
            }
            input{
                border:1px solid black!important;
                border-radius:0px!important
            }
            .form-group {
            display: inline-block;
            vertical-align: top;
            text-align: left;
            margin-right: 10px;
            }
            .custom-label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            }
            .custom-select, .custom-input {
            }
        </style>
        <style>
            #table2 td{
            padding:0px!important;
            margin:0px!important;
            }
            #table2 td input{
            border: none !important;
            outline: none!important;
            background-color: white!important;
            }
            #table2 tr{
            border: 0.5px solid black !important;
            padding:0px!important;
            margin:0px!important;
            }
            #table2 th{
            padding:7px!important;
            }
            body{
            background-color: white!important;
            }
            .time-input {
            width: 100px !important; /* Reduce width */
            font-size: 14px; /* Adjust font size */
            padding: 4px; /* Reduce padding */
            }
            @media (max-width: 768px) {
            .time-input {
            width: 80px !important; /* Smaller on mobile */
            }
            }
        </style>
        <style>
            /* Default widths */
            .emp-col {
            width: 80px; /* Slightly bigger */
            }
            .jobs-col select {
            width: 100% !important; /* Ensures dropdown fills the column */
            min-width: 200px; /* Prevents it from shrinking too much */
            }
            /* On smaller screens */
            @media (max-width: 768px) {
            .emp-col {
            width: 100px; /* Make Emp# column wider */
            }
            .jobs-col {
            min-width: 250px !important; /* Increase width */
            max-width: 300px; /* Prevent it from becoming too wide */
            white-space: nowrap; /* Prevents text from breaking */
            }
            }
            select,option{
            height:28px!important;
            font-size: 13px!important;
            border:0.5px solid black!important;
            border-radius:0px!important;
            color:black!important;
            padding:0px!important;
            padding-left:5px!important;
            }
        </style>
        <style>
            input[readonly] {
            background-color: #FAFAFA !important; /* Your desired background */
            color: black !important; /* Text color */
            opacity: 1 !important; /* Remove the default grayed-out look */
            cursor: default; /* Keep the default cursor */
            font-size: 12px!important; 
            }
        </style>
        <style>
            tr{
            padding:0px!important;
            margin:0p!important;
            }
            th{
            font-size: 12.5px!important;
            padding: 0px!important;
            margin: 0px!important;
            font-weight:700!important;
            border:none!important;
            letter-spacing: 0.3px;
            }
            td{
            font-size: 20.5px!important;
            padding: 0px!important;
            margin: 0px!important;
            font-weight: 500!important;
            border:none!important;
            padding-top:7px!important;
            }
            #table1 {
            border-spacing: 0 !important;
            border-collapse: collapse !important; 
            }
            #table1 th {
            font-size: 14px !important;
            font-weight: 400 !important;
            padding: 5px !important;
            }
            #table1 td, #table1 input {
            margin: 0 !important;
            padding: 0 !important;
            }
            #table1 input {
            background-color: white !important;
            padding: 5px 10px !important;
            }
            .btn{
            font-size: 11px;
            border-radius:0px;
            color:white!important;
            }
            .btn-submit {
            font-size: 14.4px !important; 
            color: white;
            background-color: #0D9276;
            padding: 5px 35px;
            border-radius: 2px;
            border: 2px solid #0D9276;
            letter-spacing: 1.35px; 
            font-weight: 500;
            }
            .btn-menu{
            font-size: 11px;
            }
            .cbox{
            height: 13px!important;
            width: 13px!important;
            }
            td, {
            font-size: 12.5px!important;
            padding: 0px!important;
            margin: 0px!important;
            font-weight: 500;
            }
            input {
            width: 100% !important;
            font-size: 13px; 
            border-radius: 0px;
            border: 1px solid grey;
            transition: border-color 0.3s ease;
            padding: 2.5px 5px;
            letter-spacing: 0.4px; 
            height:25px!important;
            }
            input:focus {
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
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
        <style>
            .time-input {
            font-size: 16px; /* Default size */
            }
            .time-input:valid {
            font-size: 12px; /* Change font size when value is present */
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <?php include 'sidebar1.php'; ?>
            <!-- Page Content  -->
            <div id="content">
                <!-- navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-info btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                        </button>
                    </div>
                </nav>
                <div class="container mt-4">
                <h4 class="pb-3">Staff Allocation - Employee Wise Report</h4>
                    <div class="form-group">
                       
                        <label class="custom-label" for="employee">Select Employee</label> 
                        <select class="custom-select" name="employee" id="employee">
                            <option value="">-- Select Employee --</option>
                            <?php 
                                $users = mysqli_query($conn, "SELECT fullname FROM users WHERE sa_user = 'yes'"); 
                                while ($row = mysqli_fetch_assoc($users)) { 
                                    echo '<option value="' . htmlspecialchars($row['fullname']) . '">' . htmlspecialchars($row['fullname']) . '</option>'; 
                                } 
                                ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="custom-label" for="date">Select Date</label> 
                        <input class="custom-input form-control" type="date" id="date">
                    </div>
                    <br>
                    <button onclick="redirectToFetch()" class="btn btn-primary btn-sm mt-2">View Report</button>
                    <script>
                        function redirectToFetch() {
                            var employee = document.getElementById("employee").value;
                            var date = document.getElementById("date").value;
                        
                            if (!employee || !date) {
                                alert("Please select both employee and date.");
                                return;
                            }
                        
                            window.location.href = "fetchdata_staffemp.php?employee=" + encodeURIComponent(employee) + "&date=" + encodeURIComponent(date);
                        }
                    </script>
        
                </div>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
             
            </div>
        </div>
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
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const checkboxes = document.querySelectorAll('.category-checkbox');
            
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
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const checkboxes = document.querySelectorAll('.depart_type-checkbox');
            
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

        <script src="assets/js/main.js"></script>
    </body>
</html>