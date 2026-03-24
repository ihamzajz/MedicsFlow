<?php
session_start();


if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php'); // Redirect to the login page
    exit;
}

$head_email = $_SESSION['head_email'];


$fullname = $_SESSION['fullname'];
// $department = $_SESSION['department'];
// $role = $_SESSION['role'];
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
    <title>Change Control Request Form</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .table-1 td,
        .table-2 td,
        .table-3 td {
            padding: 7px 10px !important;
        }

        .ul-msg li {
            font-size: 12px;
            font-weight: 500;
            padding-top: 10px
        }

        th {
            font-size: 11px !important;
            border: none !important;
            background-color: #ced4da !important;
            color: black !important;
            font-weight: 600 !important;
        }

        td {
            font-size: 11px !important;
            background-color: white !important;
            color: black !important;
            border: 1px solid grey !important;
            padding: 5px !important;
            margin: 0px !important;
        }

        /* thead{
            border:1px solid grey!important;
            } */
        input[type=checkbox],
        label {
            padding: 0px !important;
            margin: 0px !important;
        }

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

        .cbox {
            height: 13px !important;
            width: 13px !important;
        }

        p {
            font-size: 11.7px !important;
            padding: 0px !important;
            margin: 0px !important;
            font-weight: 500 !important;
            display: inline !important;
            margin-right: 10px !important;
        }

        input,
        textarea {
            width: 100% !important;
            font-size: 11.7px !important;
            border-radius: 0px !important;
            border: none !important;
            transition: border-color 0.3s ease !important;
            padding: 5px 5px !important;
            letter-spacing: 0.4px !important;
            height: 25px !important;
        }

        textarea {
            width: 200px !important;
            /* font-size: 11.7px!important; 
            border-radius: 0px!important;
            border: 1px solid grey!important;
            transition: border-color 0.3s ease!important;
            padding: 5px 5px!important;
            letter-spacing: 0.4px!important;  */
            /* height:25px!important; */
        }

        input:focus,
        textarea:focus {
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
        }
    </style>

  
    <?php
    include 'sidebarcss.php'
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
                    <button type="button" id="sidebarCollapse" class="btn btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </nav>
            <?php
            include 'dbconfig.php';


            $id = $_GET['id'];
            $select = "SELECT * FROM qc_ccrf WHERE
                    id = '$id' ";

            $select_q = mysqli_query($conn, $select);
            $data = mysqli_num_rows($select_q);
            ?>
            <?php
            if ($data) {
                while ($row = mysqli_fetch_array($select_q)) {
            ?>
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <form class="form pb-3" method="POST" style="border: 1px solid black; padding: 25px; padding-bottom: 0px; border-radius: 2px;background-color:white!important">

                                    <h6 class="text-center pb-3">
                                        <span style="float:left!important">
                                            <a style="font-size:11px!important" class="btn btn-dark btn-sm" href="cc_home.php"><i class="fa-solid fa-home" style="font-size:11px!important"></i> Home</a>
                                            <a style="font-size:11px!important" class="btn btn-dark btn-sm" href="cc_dept_input_list.php"><i class="fa-solid fa-arrow-left" style="font-size:11px!important"></i> Back</a>
                                        </span>

                                        <b>Department Input</b>
                                    </h6>
                                    </h6>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="width:25%!important">Department</th>
                                                <th>Comments and suggestions (if any) </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($be_depart == 'admin' or $be_depart == 'it' or $be_depart == 'super') { ?>
                                                <tr>
                                                    <td class="pl-2">Administration</td>
                                                    <td><input type="text" name="administration_input2" value="<?php echo $row['e_admin_2']; ?>"></td>
                                                </tr>
                                            <?php } ?>


                                            <?php if ($be_depart == 'pro' or $be_depart == 'it' or $be_depart == 'super') { ?>
                                                <tr>
                                                    <td class="pl-2">Production</td>
                                                    <td><input type="text" name="production_input2" value="<?php echo $row['e_production_2']; ?>"></td>
                                                </tr>
                                            <?php } ?>


                                            <?php if ($be_depart == 'qaqc' or $be_depart == 'it' or $be_depart == 'super') { ?>
                                                <tr>
                                                    <td class="pl-2">Quality Assurance</td>
                                                    <td><input type="text" name="qa_input2" value="<?php echo $row['e_qa_2']; ?>"></td>
                                                </tr>
                                            <?php } ?>


                                            <?php if ($be_depart == 'qaqc' or $be_depart == 'it' or $be_depart == 'super') { ?>
                                                <tr>
                                                    <td class="pl-2">Quality Control</td>
                                                    <td><input type="text" name="qc_input2" value="<?php echo $row['e_qc_2']; ?>"></td>
                                                </tr>
                                            <?php } ?>


                                            <?php if ($be_depart == 'sc' or $be_depart == 'it' or $be_depart == 'super') { ?>
                                                <tr>
                                                    <td class="pl-2">Herb Warehouse</td>
                                                    <td><input type="text" name="herb_warehouse_input2" value="<?php echo $row['e_herb_2']; ?>"></td>
                                                </tr>
                                            <?php } ?>


                                            <?php if ($be_depart == 'sc' or $be_depart == 'it' or $be_depart == 'super') { ?>
                                                <tr>
                                                    <td class="pl-2">Chemical Warehouse</td>
                                                    <td><input type="text" name="chemical_warehouse_input2" value="<?php echo $row['e_chemical_2']; ?>"></td>
                                                </tr>
                                            <?php } ?>


                                            <?php if ($be_depart == 'sc' or $be_depart == 'it' or $be_depart == 'super') { ?>
                                                <tr>
                                                    <td class="pl-2">Packing Warehouse</td>
                                                    <td><input type="text" name="packing_warehouse_input2" value="<?php echo $row['e_packing_2']; ?>"></td>
                                                </tr>
                                            <?php } ?>


                                            <?php if ($be_depart == 'sc' or $be_depart == 'it' or $be_depart == 'super') { ?>
                                                <tr>
                                                    <td class="pl-2">Finished Goods Warehouse</td>
                                                    <td><input type="text" name="finished_goods_warehouse_input2" value="<?php echo $row['e_finished_goods_2']; ?>"></td>
                                                </tr>
                                            <?php } ?>


                                            <?php if ($be_depart == 'sc' or $be_depart == 'it' or $be_depart == 'super') { ?>
                                                <tr>
                                                    <td class="pl-2">Procurement</td>
                                                    <td><input type="text" name="procurement_input2" value="<?php echo $row['e_procurement_2']; ?>"></td>
                                                </tr>
                                            <?php } ?>


                                            <?php if ($be_depart == 'sc' or $be_depart == 'it' or $be_depart == 'super') { ?>
                                                <tr>
                                                    <td class="pl-2">Supply Chain Management</td>
                                                    <td><input type="text" name="supply_chain_management_input2" value="<?php echo $row['e_scm_2']; ?>"></td>
                                                </tr>
                                            <?php } ?>

                                            <?php if ($be_depart == 'fi' or $be_depart == 'it' or $be_depart == 'super') { ?>
                                                <tr>
                                                    <td class="pl-2">Finance & Accounts</td>
                                                    <td><input type="text" name="finance_n_accounts_input2" value="<?php echo $row['e_finance_2']; ?>"></td>
                                                </tr>
                                            <?php } ?>

                                            <?php if ($be_depart == 'bdd' or $be_depart == 'it' or $be_depart == 'super') { ?>
                                                <tr>
                                                    <td class="pl-2">Business Development Department</td>
                                                    <td><input type="text" name="business_development_department_input2" value="<?php echo $row['e_bdd_2']; ?>"></td>
                                                </tr>
                                            <?php } ?>

                                            <?php if ($be_depart == 'mar' or $be_depart == 'it' or $be_depart == 'super') { ?>
                                                <tr>
                                                    <td class="pl-2">Marketing Department</td>
                                                    <td><input type="text" name="marketing_department_input2" value="<?php echo $row['e_marketing_2']; ?>"></td>
                                                </tr>
                                            <?php } ?>


                                            <?php if ($be_depart == 'rnd' or $be_depart == 'it' or $be_depart == 'super') { ?>

                                                <tr>
                                                    <td class="pl-2">Research and Development</td>
                                                    <td><input type="text" name="research_and_development_input2" value="<?php echo $row['e_rnd_2']; ?>"></td>
                                                </tr>
                                            <?php } ?>

                                            <?php if ($be_depart == 'regu' or $be_depart == 'it' or $be_depart == 'super') { ?>
                                                <tr>
                                                    <td class="pl-2">Regulatory</td>
                                                    <td><input type="text" name="regulatory_input2" value="<?php echo $row['e_regulatory_2']; ?>"></td>
                                                </tr>
                                            <?php } ?>


                                            <?php if ($be_depart == 'eng' or $be_depart == 'it' or $be_depart == 'super') { ?>
                                                <tr>
                                                    <td class="pl-2">Engineering</td>
                                                    <td><input type="text" name="engineering_input2" value="<?php echo $row['e_engineering_2']; ?>"></td>
                                                </tr>
                                            <?php } ?>

                                            <?php if ($be_depart == 'qaqc' or $be_depart == 'it' or $be_depart == 'super') { ?>
                                                <tr>
                                                    <td class="pl-2">Microbiology</td>
                                                    <td><input type="text" name="microbiology_input2" value="<?php echo $row['e_microbiology_2']; ?>"></td>
                                                </tr>
                                            <?php } ?>

                                            <?php if ($be_depart == 'hr' or $be_depart == 'it' or $be_depart == 'super') { ?>
                                                <tr>
                                                    <td class="pl-2">Human Resource</td>
                                                    <td><input type="text" name="human_resource_input2" value="<?php echo $row['e_hr_2']; ?>"></td>
                                                </tr>
                                            <?php } ?>

                                            <?php if ($be_depart == 'it' or $be_depart == 'it' or $be_depart == 'super') { ?>
                                                <tr>

                                                    <td class="pl-2">IT Department</td>
                                                    <td><input type="text" name="it_department_input2" value="<?php echo $row['e_it_2']; ?>"></td>
                                                <?php } ?>
                                                </tr>
                                        </tbody>
                                    </table>
                                    <tr>
                                         <div class="text-center mt-4">
                                        <button type="submit" name="submit" class="btn btn-dark px-4">
                                            Submit
                                        </button>
                                    </div>
                                    </tr>
                                </form>
                                <?php
                                include 'dbconfig.php';

                                if (isset($_POST['submit'])) {
                                    $id = $_GET['id'];
                                    $fname = $_SESSION['fullname'];
                                    $username = $_SESSION['username'];
                                    $role = $_SESSION['role'];
                                    $gender = $_SESSION['gender'];
                                    $department = $_SESSION['department'];
                                    $be_depart = $_SESSION['be_depart'];
                                    $be_role = $_SESSION['be_role'];


                                    // $f_production_input2 = isset($_POST['production_input2']) && trim($_POST['production_input2']) !== '' ? $_POST['production_input2'] : $row['e_production_2'];

                                    $f_production_input2 = isset($_POST['production_input2']) ? $_POST['production_input2'] : $row['e_production_2'];
                                    $f_administration_input2 = isset($_POST['administration_input2']) ? $_POST['administration_input2'] : $row['e_admin_2'];
                                    $f_qa_input2 = isset($_POST['qa_input2']) ? $_POST['qa_input2'] : $row['e_qa_2'];
                                    $f_qc_input2 = isset($_POST['qc_input2']) ? $_POST['qc_input2'] : $row['e_qc_2'];
                                    $f_herb_warehouse_input2 = isset($_POST['herb_warehouse_input2']) ? $_POST['herb_warehouse_input2'] : $row['e_herb_2'];
                                    $f_chemical_warehouse_input2 = isset($_POST['chemical_warehouse_input2']) ? $_POST['chemical_warehouse_input2'] : $row['e_chemical_2'];
                                    $f_packing_warehouse_input2 = isset($_POST['packing_warehouse_input2']) ? $_POST['packing_warehouse_input2'] : $row['e_packing_2'];
                                    $f_finished_goods_warehouse_input2 = isset($_POST['finished_goods_warehouse_input2']) ? $_POST['finished_goods_warehouse_input2'] : $row['e_finished_goods_2'];
                                    $f_procurement_input2 = isset($_POST['procurement_input2']) ? $_POST['procurement_input2'] : $row['e_procurement_2'];
                                    $f_supply_chain_management_input2 = isset($_POST['supply_chain_management_input2']) ? $_POST['supply_chain_management_input2'] : $row['e_scm_2'];
                                    $f_finance_n_accounts_input2 = isset($_POST['finance_n_accounts_input2']) ? $_POST['finance_n_accounts_input2'] : $row['e_finance_2'];
                                    $f_business_development_department_input2 = isset($_POST['business_development_department_input2']) ? $_POST['business_development_department_input2'] : $row['e_bdd_2'];
                                    $f_marketing_department_input2 = isset($_POST['marketing_department_input2']) ? $_POST['marketing_department_input2'] : $row['e_marketing_2'];
                                    $f_research_and_development_input2 = isset($_POST['research_and_development_input2']) ? $_POST['research_and_development_input2'] : $row['e_rnd_2'];
                                    $f_regulatory_input2 = isset($_POST['regulatory_input2']) ? $_POST['regulatory_input2'] : $row['e_regulatory_2'];
                                    $f_engineering_input2 = isset($_POST['engineering_input2']) ? $_POST['engineering_input2'] : $row['e_engineering_2'];
                                    $f_microbiology_input2 = isset($_POST['microbiology_input2']) ? $_POST['microbiology_input2'] : $row['e_microbiology_2'];
                                    $f_human_resource_input2 = isset($_POST['human_resource_input2']) ? $_POST['human_resource_input2'] : $row['e_hr_2'];
                                    $f_it_department_input2 = isset($_POST['it_department_input2']) ? $_POST['it_department_input2'] : $row['e_it_2'];

                                    $f_date = date('Y-m-d');

                                    $update_query = "UPDATE qc_ccrf SET 
                                
                                                        e_admin_2 = '$f_administration_input2',
                                                        e_production_2 = '$f_production_input2',
                                                        e_qa_2 = '$f_qa_input2',
                                                        e_qc_2 = '$f_qc_input2',
                                                        e_herb_2 = '$f_herb_warehouse_input2',
                                                        e_chemical_2 = '$f_chemical_warehouse_input2',
                                                        e_packing_2 = '$f_packing_warehouse_input2',
                                                        e_finished_goods_2 = '$f_finished_goods_warehouse_input2',
                                                        e_procurement_2 = '$f_procurement_input2',
                                                        e_scm_2 = '$f_supply_chain_management_input2',
                                                        e_finance_2 = '$f_finance_n_accounts_input2',
                                                        e_bdd_2 = '$f_business_development_department_input2',
                                                        e_marketing_2 = '$f_marketing_department_input2',
                                                        e_rnd_2 = '$f_research_and_development_input2',
                                                        e_regulatory_2 = '$f_regulatory_input2',
                                                        e_engineering_2 = '$f_engineering_input2',
                                                        e_microbiology_2 = '$f_microbiology_input2',
                                                        e_hr_2 = '$f_human_resource_input2',
                                                        e_it_2 = '$f_it_department_input2'
                                
                                                        WHERE id = '$id'";
                                    $result = mysqli_query($conn, $update_query);

                                    if ($result) {
                                        echo "<script>alert('Record updated successfully!');
                                        window.location.href = window.location.href;
                                        
                                        </script>";
                                    } else {
                                        echo "<script>alert('Update failed!');
                                        window.location.href = window.location.href;</script>";
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
        </div>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.category-checkbox');

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
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.depart_type-checkbox');

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

<script src="assets/js/main.js"></script>
</body>

</html>