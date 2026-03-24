<?php
    session_start();
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    function sendPHPMailer($to, $subject, $body)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.office365.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'info@medicslab.com';
            $mail->Password   = 'kcmzrskfgmwzzshz';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
    
            $mail->setFrom('info@medicslab.com', 'Medics Digital Form');
            $mail->addAddress($to);
    
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
    
            $mail->send();
        } catch (Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo}");
        }
    }
    ?>
<?php
    $id = $_SESSION['id'];
    $fname = $_SESSION['fullname'];
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    $password = $_SESSION['password'];
    $gender = $_SESSION['gender'];
    $department = $_SESSION['department'];
    
    $email = $_SESSION['email'];
    
    $be_depart = $_SESSION['be_depart'];
    $be_role = $_SESSION['be_role'];
    
    $sa_user = $_SESSION['sa_user'];
    $sa_depart = $_SESSION['sa_depart'];
    $sa_depart2 = $_SESSION['sa_depart2'];
    $sa_depart3 = $_SESSION['sa_depart3'];
    $sa_role = $_SESSION['sa_role'];
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Change Control Request Form</title>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="assets/css/style.css">
        <style>
/*------------------------------
    Global Styles
------------------------------*/
body {
    font-family: 'Poppins', sans-serif !important;
}

p {
    font-size: 11.7px !important;
    padding: 0 !important;
    margin: 0 !important;
    font-weight: 500 !important;
    display: inline !important;
    margin-right: 10px !important;
}

/*------------------------------
    Buttons
------------------------------*/
.btn {
    font-size: 11px;
    color: white;
}

.btn-brown {
    background-color: #129990;
    padding: 1px 10px !important;
    font-weight: 500;
}
.btn-brown:hover {
    background-color: #6A9C89;
}

.btn-menu {
    font-size: 12.5px;
    background-color: #FFB22C !important;
    padding: 5px 10px;
    font-weight: 600;
    border: none !important;
}

/*------------------------------
    Layout Helpers
------------------------------*/
.center-screen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    background-color: rgba(255, 255, 255, 0.8);
}

/*------------------------------
    Message Box
------------------------------*/
.message-box {
    padding: 20px 30px;
    background-color: #d4edda;
    color: #155724;
    font-weight: bold;
    border: 1px solid #c3e6cb;
    border-radius: 8px;
    text-align: center;
}

/*------------------------------
    Tables
------------------------------*/
.table-1 td,
.table-2 td,
.table-3 td {
    padding: 7px 10px !important;
}

th {
    font-size: 11px !important;
    border: none !important;
    background-color: #ced4da !important;
    color: black !important;
    font-weight: 600 !important;
}

td {
    font-size: 11.5px !important;
    border: none !important;
    margin: 0 !important;
}

tr {
    border: 0.5px solid black !important;
}

thead {
    border: 1px solid grey !important;
}

/*------------------------------
    Lists
------------------------------*/
.ul-msg li {
    font-size: 12px;
    font-weight: 500;
    padding-top: 10px;
}

/*------------------------------
    Forms & Inputs
------------------------------*/
input {
    width: 100% !important;
    font-size: 11px !important;
    border-radius: 0 !important;
    border: 0.5px solid #adb5bd !important;
    transition: border-color 0.3s ease !important;
    padding: 10px 5px !important;
    height: 23px !important;
}

input[type=checkbox],
label {
    padding: 0 !important;
    margin: 0 !important;
}

.cbox {
    height: 13px !important;
    width: 13px !important;
}

/*------------------------------
    Backgrounds & Menus
------------------------------*/
.bg-menu {
    background-color: #393E46 !important;
}
</style>

        <?php
            include 'sidebarcss.php';
            ?>
    </head>
    <body>
        <div class="wrapper">
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
                    
                    
                    $id = $_GET['id'];
                    $select = "SELECT * FROM qc_ccrf2 WHERE
                                    fk_id = '$id'";
                    
                    $select_q = mysqli_query($conn, $select);
                    $data = mysqli_num_rows($select_q);
                    ?>
                <?php
                    if ($data) {
                        while ($row = mysqli_fetch_array($select_q)) {
                    ?>
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col">
                            <form class="form pb-3" method="POST" style="border: 1px solid black; padding: 25px; padding-bottom: 0px; border-radius: 2px;background-color:white!important">
                                <div style="position: relative; text-align: center;">
                                    <h5 class="pb-3"><b>Add Action Plan</b></h5>
                                    <div style="position: absolute; left: 0; top: 0;">
                                        <a class="btn btn-dark btn-sm" href="cc_home.php">
                                        <i class="fa-solid fa-home"></i> Home
                                        </a>
                                        <a class="btn btn-dark btn-sm" href="cc_add_action_plan_list.php">
                                        <i class="fa-solid fa-arrow-left"></i> Back
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Event / Action Plan</th>
                                                <th>Responsiblity</th>
                                                <th>Timeline</th>
                                                <th>Email</th>
                                                <th>Mark Complete/Completion Date</th>
                                                <th>Verified By Quality Department</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                            <tr>
                                                <td>
                                                    <input type="text" name="f_ac_<?php echo $i; ?>" value="<?php echo $row["f_ac_$i"]; ?>">
                                                </td>
                                                <td>
                                                    <input type="text" name="f_responsibility_<?php echo $i; ?>" value="<?php echo $row["f_responsibility_$i"]; ?>">
                                                </td>
                                                <td>
                                                    <input type="date" name="f_timeline_<?php echo $i; ?>"
                                                        value="<?php echo !empty($row["f_timeline_$i"]) ? htmlspecialchars($row["f_timeline_$i"]) : ''; ?>">
                                                </td>
                                                <td>
                                                    <input type="text" name="f_signature_<?php echo $i; ?>" value="<?php echo $row["f_signature_$i"]; ?>">
                                                </td>
                                                <td>
                                                    <?php if ($email === $row["f_signature_$i"]): ?>
                                                    <?php if (empty($row["workdone{$i}_date"])): ?>
                                                    <a href="cc_workdone<?php echo $i; ?>.php?id=<?php echo $row['id']; ?>"
                                                        class="btn btn-primary btn-sm">Workdone</a>
                                                    <?php else: ?>
                                                    <span class="p-3"><?php echo $row["workdone{$i}_date"]; ?></span>
                                                    <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($be_depart == 'it' || ($be_role == 'approver' && $be_depart == 'qaqc')): ?>
                                                    <?php if (empty($row["f_verify_by_$i"])): ?>
                                                    <a href="cc_qc_verify<?php echo $i; ?>.php?id=<?php echo $row['id']; ?>"
                                                        class="btn btn-brown btn-sm m-1">
                                                    <i class="fa-solid fa-check"></i> Verify
                                                    </a>
                                                    <?php else: ?>
                                                    <span class="p-3"><b><?php echo $row["f_verify_by_$i"]; ?></b></span>
                                                    <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center mt-4">
                                    <button type="submit" name="submit" class="btn btn-dark px-4" style="font-size: 14px;">
                                    Submit
                                    </button>
                                </div>
                                <?php if (isset($_SESSION['success'])): ?>
                                <div class="center-screen">
                                    <div class="message-box">
                                        <?php echo $_SESSION['success']; ?>
                                    </div>
                                </div>
                                <?php unset($_SESSION['success']); ?>
                                <?php endif; ?>
                            </form>
                            <?php
                                include 'dbconfig.php';
                                
                                // Check if form is submitted
                                if (isset($_POST['submit'])) {
                                    // Retrieve form data
                                    $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                                    $name = $_SESSION['fullname'];
                                
                                    // Fetch the current record from qc_ccrf2
                                    $result_row = mysqli_query($conn, "SELECT * FROM qc_ccrf2 WHERE fk_id = '$id'");
                                    if (!$result_row) {
                                        die("Error fetching record: " . mysqli_error($conn));
                                    }
                                
                                    $row = mysqli_fetch_assoc($result_row);
                                
                                    // Define groups
                                    $groups = [
                                        'f_ac',
                                        'f_responsibility',
                                        'f_timeline',
                                        'f_signature',
                                        'f_verify_by'
                                    ];
                                
                                    // Generate dynamic variables for each group and number
                                    foreach ($groups as $group) {
                                        for ($i = 1; $i <= 10; $i++) {
                                            $postKey = "{$group}_{$i}";
                                            $varName = "f_f_{$group}_{$i}";
                                
                                            $$varName = (isset($_POST[$postKey]) && $_POST[$postKey] !== $row[$postKey])
                                                ? $_POST[$postKey]
                                                : $row[$postKey];
                                        }
                                    }
                                
                                    $f_date = date('Y-m-d');
                                
                                    // Build dynamic SQL update query
                                    $update_parts = [];
                                    foreach ($groups as $group) {
                                        for ($i = 1; $i <= 10; $i++) {
                                            $varName = "f_f_{$group}_{$i}";
                                            $update_parts[] = "{$group}_{$i} = '" . mysqli_real_escape_string($conn, ${$varName}) . "'";
                                        }
                                    }
                                
                                    $update_set_clause = implode(",\n", $update_parts);
                                    $update_query = "UPDATE qc_ccrf2 SET $update_set_clause WHERE fk_id = '$id'";
                                
                                    // Execute update query for qc_ccrf2
                                    $result = mysqli_query($conn, $update_query);
                                
                                    if ($result) {
                                        // Now update the qc_ccrf table
                                        $update_ccrf_query = "UPDATE qc_ccrf SET part_2 = 'Approved' WHERE id = '$id'";
                                        $result_ccrf = mysqli_query($conn, $update_ccrf_query);
                                
                                        if ($result_ccrf) {
                                            // Include PHPMailer
                                            require 'vendor/autoload.php';
                                
                                            $subject = "Approval Notification: CCRF ID $id";
                                            $sender = $_SESSION['fullname'];
                                            $baseMessage = "
                                <p>Dear Concern Department,</p>
                                <p>A new action plan has been assigned to you by <strong>$sender</strong> in the Change Control Form (CCRF).</p>
                                <p>Please visit the <a href='http://43.245.128.46:9090/medicsflow/login' target='_blank'>MedicsFlow Application</a> at your earliest convenience to review and take the necessary actions.</p>
                                <p>Thank you for your prompt attention.</p>
                                <p>Best regards,<br>MedicsFlow</p>
                                ";
                                
                                            // Loop through signature emails dynamically
                                            for ($i = 1; $i <= 10; $i++) {
                                                $varName = "f_f_signature_$i";
                                                $email = ${$varName};
                                
                                                if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                                    sendPHPMailer($email, $subject, $baseMessage);
                                                }
                                            }
                                
                                            // Success message
                                            echo "<script>alert('Record updated successfully!');
                                                  window.location.href = 'cc_add_action_plan?id=" . $id . "';</script>";
                                        } else {
                                            echo "<script>alert('Error updating qc_ccrf table!');
                                                  window.location.href = window.location.href;</script>";
                                        }
                                    } else {
                                        echo "<script>alert('Update failed for qc_ccrf2!');
                                              window.location.href = window.location.href;</script>";
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
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                // Ensure the sidebar is active (visible) by default
                $('#sidebar').addClass('active'); // Change to addClass to show sidebar initially
            
                // Handle sidebar collapse toggle
                $('#sidebarCollapse').on('click', function() {
                    $('#sidebar').toggleClass('active');
                });
            
                // Update the icon when collapsing/expanding
                $('[data-bs-toggle="collapse"]').on('click', function() {
                    var target = $(this).find('.toggle-icon');
                    if ($(this).attr('aria-expanded') === 'true') {
                        target.removeClass('fa-plus').addClass('fa-minus');
                    } else {
                        target.removeClass('fa-minus').addClass('fa-plus');
                    }
                });
            });
        </script>
        <script src="assets/js/main.js"></script>
    </body>
</html>
<?php
    if (isset($_SESSION['success'])) {
        echo "<div style='color: green; font-weight: bold; margin-bottom: 10px;'>" . $_SESSION['success'] . "</div>";
        unset($_SESSION['success']); // remove it after showing
    }
    ?>