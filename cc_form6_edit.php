<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
$head_email = $_SESSION['head_email'];
$fullname = $_SESSION['fullname'];
$head_email = $_SESSION['head_email'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$mail = new PHPMailer(true);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MedicsFlow</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
    <?php
    include 'cdncss.php'
    ?>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f6fa;
        }

        p {
            font-size: 10.5px !important;
            font-weight: 500 !important;
            display: inline !important;
            padding: 0 !important;
            margin: 0 10px 0 0 !important;
        }

        .card {
            border-radius: 10px;
        }

        .bg-menu {
            background-color: #393E46 !important;
        }

        .btn-menu {
            font-size: 12.5px;
            font-weight: 600;
            background-color: #FFB22C !important;
            padding: 5px 10px;
            border: none !important;
            border-radius: 2px !important;
        }

        .btn-light {
            font-size: 13px;
            font-weight: 400;
        }

        .btn-submit {
            font-size: 15px;
            font-weight: 500;
        }

        thead {
            border: 1px solid grey !important;
        }

        th {
            font-size: 11px !important;
            font-weight: 600 !important;
            color: black !important;
            background-color: #ced4da !important;
            border: none !important;
        }

        td {
            font-size: 10.5px;
            font-weight: 500;
            color: black;
            padding: 7px 5px !important;
            border: none !important;
        }

        .table-1 td,
        .table-2 td,
        .table-3 td {
            padding: 7px 10px !important;
        }

        .ul-msg li {
            font-size: 12px;
            font-weight: 500;
            padding-top: 10px;
        }

        input {
            width: 100% !important;
            height: 25px !important;
            font-size: 11.7px !important;
            letter-spacing: 0.4px !important;
            padding: 5px !important;
            border: none !important;
            border-radius: 0 !important;
            transition: border-color 0.3s ease !important;
        }

        input:focus {
            outline: none;
            background-color: #e9ecef;
        }

        input[type="checkbox"],
        label {
            padding: 0 !important;
            margin: 0 !important;
        }

        .cbox {
            width: 13px !important;
            height: 13px !important;
        }

        .main-heading {
            font-size: 15px !important;
            font-weight: 600 !important;
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
            $select = "SELECT * FROM qc_ccrf2 WHERE
                    fk_id = '$id'";

            $select_q = mysqli_query($conn, $select);
            $data = mysqli_num_rows($select_q);
            ?>
            <?php
            if ($data) {
                while ($row = mysqli_fetch_array($select_q)) {
            ?>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-10 ">
                                <form class="form pb-3" method="POST" enctype="multipart/form-data">

                                    <div class="card shadow mt-3">
                                        <div class="card-header bg-dark text-white d-flex align-items-center">
                                            <h6 class="mb-0 main-heading">Change Control Closing</h6>

                                            <div class="ms-auto">
                                                <a href="cc_home.php" class="btn btn-light btn-sm me-2">Home</a>
                                                <a href="cc_edit_list.php" class="btn btn-light btn-sm">Back</a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <td rowspan="8" style="vertical-align:middle!important;font-size:12px!important"
                                                            class="p-1 text-right">Effectiveness Checks
                                                            Completion:
                                                        </td>
                                                        <td><input type="text" name="i_1" value="<?php echo $row['i_1']; ?>" style="border:0.5px solid grey!important;flex: 1;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1"><input type="text" name="i_2"
                                                                value="<?php echo $row['i_2']; ?>" style="border:0.5px solid grey!important;flex: 1;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1"><input type="text" name="i_3"
                                                                value="<?php echo $row['i_3']; ?>" style="border:0.5px solid grey!important;flex: 1;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1"><input type="text" name="i_4"
                                                                value="<?php echo $row['i_4']; ?>" style="border:0.5px solid grey!important;flex: 1;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1"><input type="text" name="i_5"
                                                                value="<?php echo $row['i_5']; ?>" style="border:0.5px solid grey!important;flex: 1;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1"><input type="text" name="i_6"
                                                                value="<?php echo $row['i_6']; ?>" style="border:0.5px solid grey!important;flex: 1;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1"><input type="text" name="i_7"
                                                                value="<?php echo $row['i_7']; ?>" style="border:0.5px solid grey!important;flex: 1;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1"><input type="text" name="i_8"
                                                                value="<?php echo $row['i_8']; ?>" style="border:0.5px solid grey!important;flex: 1;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-1"
                                                            style="vertical-align:middle!important;font-size:12px!important">Change
                                                            completion date:</td>
                                                        <td>
                                                            <input
                                                                type="date"
                                                                name="i_9"
                                                                value="<?php echo !empty($row['i_9']) ? $row['i_9'] : ''; ?>"
                                                                style="border:0.5px solid grey!important;flex: 1;">

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-3">
                                                            <div style="display: flex; align-items: center; gap: 5px;">
                                                                <label for="name" style="font-size:12px">Name:</label>
                                                                <input type="text" name="i_10" value="<?php echo $row['i_10']; ?>"
                                                                    style="border:0.5px solid grey!important;flex: 1;">
                                                            </div>
                                                        </td>
                                                        <td class="py-3">
                                                            <div style="display: flex; align-items: center; gap: 5px;font-size:13px">
                                                                <label for="sign" style="font-size:12px">Sign / Date:</label>
                                                                <input
                                                                    type="date"
                                                                    name="i_11"
                                                                    value="<?php echo !empty($row['i_11']) ? $row['i_11'] : ''; ?>"
                                                                    style="border:0.5px solid grey!important;flex: 1;">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </table>
                                            </div>

                                            <!-- doc start -->

                                            <input type="file"
                                                name="evidence_files[]"
                                                id="evidenceInput"
                                                multiple
                                                accept=".pdf,.jpg,.jpeg,.png,.xls,.xlsx"
                                                class="form-control form-control-sm">

                                            <button type="button"
                                                class="btn btn-sm btn-outline-secondary mt-2 d-none"
                                                id="previewBtn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#previewModal">
                                                Preview Evidence
                                            </button>


                                            <?php
                                            // Show View Evidence button if files exist
                                            if (!empty($row['evidence_files'])) {
                                                $files = json_decode($row['evidence_files'], true);
                                                if (!empty($files)) {
                                                    echo '<tr><td></td><td>';
                                                    foreach ($files as $file) {
                                                        echo '<a href="' . $file . '" target="_blank" class="btn btn-sm btn-outline-primary me-2 mb-1">
                    View Evidence
                  </a>';
                                                    }
                                                    echo '</td></tr>';
                                                }
                                            }
                                            ?>


                                            <!-- doc end -->



                                            <div class="text-center mt-4">
                                                <button type="submit" name="submit" class="btn btn-dark px-4 btn-submit">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <?php
                                include 'dbconfig.php';

                                if (isset($_POST['submit'])) {
                                    $id = $_GET['id'];
                                    $name = $_SESSION['fullname'];

                                    $f_i_1 = isset($_POST['i_1']) && $_POST['i_1'] !== $row['i_1'] ? $_POST['i_1'] : $row['i_1'];
                                    $f_i_2 = isset($_POST['i_2']) && $_POST['i_2'] !== $row['i_2'] ? $_POST['i_2'] : $row['i_2'];
                                    $f_i_3 = isset($_POST['i_3']) && $_POST['i_3'] !== $row['i_3'] ? $_POST['i_3'] : $row['i_3'];
                                    $f_i_4 = isset($_POST['i_4']) && $_POST['i_4'] !== $row['i_4'] ? $_POST['i_4'] : $row['i_4'];
                                    $f_i_5 = isset($_POST['i_5']) && $_POST['i_5'] !== $row['i_5'] ? $_POST['i_5'] : $row['i_5'];
                                    $f_i_6 = isset($_POST['i_6']) && $_POST['i_6'] !== $row['i_6'] ? $_POST['i_6'] : $row['i_6'];
                                    $f_i_7 = isset($_POST['i_7']) && $_POST['i_7'] !== $row['i_7'] ? $_POST['i_7'] : $row['i_7'];
                                    $f_i_8 = isset($_POST['i_8']) && $_POST['i_8'] !== $row['i_8'] ? $_POST['i_8'] : $row['i_8'];
                                    $f_i_9 = isset($_POST['i_9']) && $_POST['i_9'] !== $row['i_9'] ? $_POST['i_9'] : $row['i_9'];
                                    $f_i_10 = isset($_POST['i_10']) && $_POST['i_10'] !== $row['i_10'] ? $_POST['i_10'] : $row['i_10'];
                                    $f_i_11 = isset($_POST['i_11']) && $_POST['i_11'] !== $row['i_11'] ? $_POST['i_11'] : $row['i_11'];
                                    $f_date = date('Y-m-d');


                                    $uploadedFiles = [];
                                    $uploadDir = "uploads/cc/";

                                    if (!is_dir($uploadDir)) {
                                        mkdir($uploadDir, 0777, true);
                                    }

                                    if (!empty($_FILES['evidence_files']['name'][0])) {
                                        foreach ($_FILES['evidence_files']['name'] as $key => $name) {

                                            $tmpName = $_FILES['evidence_files']['tmp_name'][$key];
                                            $fileSize = $_FILES['evidence_files']['size'][$key];
                                            $fileError = $_FILES['evidence_files']['error'][$key];

                                            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                                            $allowed = ['pdf', 'jpg', 'jpeg', 'png', 'xls', 'xlsx'];

                                            if (in_array($ext, $allowed) && $fileError === 0) {
                                                $newName = uniqid('evidence_') . "." . $ext;
                                                $filePath = $uploadDir . $newName;

                                                if (move_uploaded_file($tmpName, $filePath)) {
                                                    $uploadedFiles[] = $filePath;
                                                }
                                            }
                                        }
                                    }

                                    // Existing files
                                    $existingFiles = [];
                                    if (!empty($row['evidence_files'])) {
                                        $existingFiles = json_decode($row['evidence_files'], true);
                                    }

                                    // Merge
                                    $finalFiles = array_merge($existingFiles, $uploadedFiles);
                                    $finalFilesJson = json_encode($finalFiles);


                                    $update_query = "UPDATE qc_ccrf2 SET 
                                                        i_1 = '$f_i_1',
                                                        i_2 = '$f_i_2',
                                                        i_3 = '$f_i_3',
                                                        i_4 = '$f_i_4',
                                                        i_5 = '$f_i_5',
                                                        i_6 = '$f_i_6',
                                                        i_7 = '$f_i_7',
                                                        i_8 = '$f_i_8',
                                                        i_9 = '$f_i_9',
                                                        i_10 = '$f_i_10',
                                                        i_11 = '$f_i_11',
                                                        evidence_files = '$finalFilesJson',
                                                        part_3 = 'Approved'

                                                        WHERE fk_id = '$id'";

                                    $result = mysqli_query($conn, $update_query);

                                    if ($result) {
                                        $update_ccrf_query = "UPDATE qc_ccrf SET part_2 = 'Approved', status = 'Closed' WHERE id = '$id'";

                                        $result_ccrf = mysqli_query($conn, $update_ccrf_query);

                                        if ($result_ccrf) {
                                            echo "<script>alert('Record updated successfully!');
                                
                                window.location.href = 'cc_form6_edit?id=" . $id . "';
                                </script>";
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
            } else {
                echo "No record found!";
            }
                ?>
        </div>
    </div>

<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Evidence Preview</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="previewContainer">
                <!-- previews injected here -->
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

<script>
document.getElementById('evidenceInput').addEventListener('change', function () {
    const previewBtn = document.getElementById('previewBtn');
    const previewContainer = document.getElementById('previewContainer');

    previewContainer.innerHTML = '';

    if (this.files.length === 0) {
        previewBtn.classList.add('d-none');
        return;
    }

    previewBtn.classList.remove('d-none');

    Array.from(this.files).forEach(file => {
        const ext = file.name.split('.').pop().toLowerCase();
        const wrapper = document.createElement('div');
        wrapper.classList.add('mb-4');

        // IMAGE PREVIEW
        if (['jpg','jpeg','png'].includes(ext)) {
            const url = URL.createObjectURL(file);
            wrapper.innerHTML = `
                <p><strong>${file.name}</strong></p>
                <img src="${url}" class="img-fluid rounded border">
            `;
            previewContainer.appendChild(wrapper);
        }

        // PDF PREVIEW
        else if (ext === 'pdf') {
            const url = URL.createObjectURL(file);
            wrapper.innerHTML = `
                <p><strong>${file.name}</strong></p>
                <iframe src="${url}" width="100%" height="500px"></iframe>
            `;
            previewContainer.appendChild(wrapper);
        }

        // EXCEL PREVIEW
        else if (['xls','xlsx'].includes(ext)) {
            const reader = new FileReader();

            reader.onload = function (e) {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array' });

                const sheetName = workbook.SheetNames[0];
                const sheet = workbook.Sheets[sheetName];

                const html = XLSX.utils.sheet_to_html(sheet);

                wrapper.innerHTML = `
                    <p><strong>${file.name}</strong></p>
                    <div style="max-height:400px; overflow:auto;" class="border p-2">
                        ${html}
                    </div>
                `;

                previewContainer.appendChild(wrapper);
            };

            reader.readAsArrayBuffer(file);
        }

        // OTHER FILES
        else {
            wrapper.innerHTML = `
                <p><strong>${file.name}</strong></p>
                <p class="text-muted">Preview not available. File will be uploaded.</p>
            `;
            previewContainer.appendChild(wrapper);
        }
    });
});
</script>




    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#sidebar').addClass('active');
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });
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