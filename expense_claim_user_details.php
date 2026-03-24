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
    <title>Expense Claim</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
    <?php
    include 'cdncss.php'
    ?>
    <style>
        .btn {
            font-size: 11px !important;
            padding: 5px 10px !important
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        .btn {
            border-radius: 0px;
        }

        .btn-submit {
            font-size: 15px !important;
            color: white;
            background-color: #0D9276;
            padding: 5px 35px;
            border-radius: 2px;
            border: 2px solid #0D9276;
            letter-spacing: 1px;
            font-weight: 500;
            transition: all 0.3s ease;
            /* Smooth transition effect */
        }

        .btn-submit:hover {
            color: #0D9276;
            background-color: white;
            border: 2px solid #0D9276;
        }

        .btn-menu {
            font-size: 11px;
        }

        .cbox {
            height: 13px !important;
            width: 13px !important;
        }

        table th {
            font-size: 12.5px !important;
            border: none !important;
            background-color: #1B7BBC !important;
            color: white !important;
            padding: 6px 5px !important;
        }

        table td {
            font-size: 12.5px;
            color: black;
            padding: 0px !important;
            /* Adjust padding as needed */
            /* border: 1px solid #ddd; */
        }

        input {
            width: 100% !important;
            font-size: 12.5px;
            border-radius: 0px;
            border: 1px solid grey;
            transition: border-color 0.3s ease;
            padding: 2.5px 5px;
            letter-spacing: 0.4px;
            height: 25px !important;
            /* color:#2c2c2c!important; */
        }

        input:focus {
            outline: none;
            border: 1px solid black;
            background-color: #FFF4B5;
        }

        .labelp {
            padding: 0px !important;
            margin: 0px !important;
            font-size: 12.5px !important;
            font-weight: 600 !important;
            padding-bottom: 5px !important;
            ;
        }
    </style>
    <?php
    include 'sidebarcss.php'
    ?>
    <style>
        input[type="file"] {
            border-radius: 6px;
            border: 1px solid #ced4da;
            padding: 6px 10px;
        }
    </style>
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
                    <button type="button" id="sidebarCollapse" class="btn btn-success"> <i
                            class="fas fa-align-left"></i> <span>Menu</span> </button>
                </div>
            </nav>
            <?php
            include 'dbconfig.php';


            $id = $_GET['id'];
            $select = "SELECT * FROM expense_claim WHERE
                    id = '$id' ";

            $select_q = mysqli_query($conn, $select);
            $data = mysqli_num_rows($select_q);
            ?>
            <?php
            if ($data) {
                while ($row = mysqli_fetch_array($select_q)) {
            ?>
                    <div class="container-fluid">
                        <div style="background-color:White!important;border:1px solid black" class="p-5 m-5">
                            <form class="form pb-3" method="POST" enctype="multipart/form-data">
                                <div class="d-flex align-items-center justify-content-between mb-3" style="min-height: 40px;">
                                    <!-- Left: Heading -->
                                    <h5 class="mb-0" style="font-size:18px!important;font-weight:700">
                                        Expense Claim Form
                                    </h5>
                                    <!-- Right: Buttons -->
                                    <div>
                                        <a class="btn btn-dark btn-sm me-2"
                                            href="expense_claim_home.php"
                                            style="font-size:12px!important">
                                            <i class="fa fa-home"></i> Home
                                        </a>
                                        <a class="btn btn-secondary btn-sm"
                                            href="expense_claim_userlist.php"
                                            style="font-size:12px!important">
                                            <i class="fa fa-list"></i> Back
                                        </a>
                                    </div>
                                </div>

                                <div class="row mb-2 mt-5">
                                    <div class="col-md-4">
                                        <div>
                                            <p class="labelp">Requestor Name</p>
                                            <input type="text" name="name" value="<?php echo $row['user_name']; ?>"
                                                class="w-100" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <p class="labelp">Department</p>
                                            <input type="text" name="department" value="<?php echo $row['user_department']; ?>"
                                                class="w-100" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <p class="labelp">Role</p>
                                            <input type="text" name="role" value="<?php echo $row['user_role']; ?>"
                                                class="w-100" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <div>
                                            <p class="labelp">Emp #</p>
                                            <input type="text" name="name" value="<?php echo $row['emp_id']; ?>" class="w-100"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <p class="labelp">Amount</p>
                                            <input type="text" name="department" value="<?php echo $row['amount']; ?>"
                                                class="w-100" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <p class="labelp">Reason For Claim</p>
                                            <input type="text" name="role" value="<?php echo $row['reason_for_claim']; ?>"
                                                class="w-100" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-12">
                                        <div>
                                            <p class="labelp">Amount Breakup</p>
                                            <input type="text" name="name" value="<?php echo $row['amount_breakup']; ?>"
                                                class="w-100" readonly>
                                        </div>
                                    </div>

                                </div>

                                <!-- comments start  -->
                                <div>
                                    <form method="POST">

                                        <label for="finance_comments"
                                            style="font-weight:600;display:block;margin-bottom:1px;font-size:12px!important">Finance
                                            Comments</label>
                                        <input class="p-2" name="finance_comments" id="finance_comments"
                                            style="width:100%;background-color:#DBDFEA"
                                            value="<?php echo $row['finance_comments']; ?>" readonly>
                                    </form>
                                </div>

                                <div>
                                    <form method="POST">
                                        <label for="admin_comments"
                                            style="font-weight:600;display:block;margin-bottom:1px;font-size:12px!important"
                                            class="">Admin Comments</label>
                                        <input class="pb-2" name="admin_comments" id="admin_comments"
                                            style="width:100%;background-color:#DBDFEA" readonly
                                            value="<?php echo $row['admin_comments']; ?>">

                                    </form>
                                </div>

                                <!-- comments end -->




                                <?php if ($row['finance_status'] === 'Approved'): ?>
                                    <div class="bg-white p-3 mt-3" style="border:0.5px solid black!important">
                                        <form method="POST" enctype="multipart/form-data">
                                            <div class="row">

                                                <div class="col-md-4">
                                                    <button type="button" class="btn"
                                                        style="background-color:#57564F;color:white;font-size:13px!important"
                                                        data-bs-toggle="modal" data-bs-target="#evidenceModal"> <i
                                                            class="fa-solid fa-image"></i> View Evidence </button>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                <?php endif; ?>


                                <?php if ($row['admin_status'] === 'Pending'): ?>

                        </div>
                    <?php endif; ?>
                    <?php if ($row['status'] === 'Closed'): ?>
                        <div class="container mt-4">
                            <<div class="bg-white p-3 mt-3" style="border:0.5px solid black!important">
                                <div class="row text-center align-items-center">
                                    <!-- Box 1: Status -->
                                    <div class="col-md-6">
                                        <p style="font-size:15px!important; margin:0;"> <strong>Status:</strong> Closed </p>
                                    </div>
                                    <!-- Box 2: Closed By -->
                                    <div class="col-md-6">
                                        <p style="font-size:15px!important; margin:0;">
                                            <strong><?= $row['status_by']; ?></strong>
                                        </p>
                                    </div>
                                </div>
                        </div>
                    </div>
                <?php endif; ?>



                <div class="mx-5">
                    <div class="bg-white p-3 mt-3" style="border:0.5px solid black!important">
                        <div class="row text-center align-items-center">
                            <!-- Box 1: Finance Status -->
                            <div class="col-md-6" style="border-right: 2px solid #000;">
                                <p style="font-size:13.5px!important; margin:0;"> <strong>Finance Status:</strong>
                                    <?= $row['finance_status']; ?>
                                </p>
                            </div>
                            <!-- Box 2: Finance Message -->
                            <div class="col-md-6">
                                <?php if ($row['finance_status'] !== 'Pending'): ?>
                                    <p style="font-size:13.5px!important; margin:0;">
                                        <?= $row['finance_msg']; ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- admin start  -->

                <div class="mx-5">
                    <div class="bg-white p-3 mt-3" style="border:0.5px solid black!important">
                        <div class="row text-center align-items-center">
                            <!-- Box 1: Finance Status -->
                            <div class="col-md-6" style="border-right: 2px solid #000;">
                                <p style="font-size:13.5px!important; margin:0;"> <strong>Admin Status:</strong>
                                    <?= $row['admin_status']; ?>
                                </p>
                            </div>
                            <!-- Box 2: Finance Message -->
                            <div class="col-md-6">
                                <?php if ($row['admin_status'] !== 'Pending'): ?>
                                    <p style="font-size:13.5px!important; margin:0;">
                                        <?= $row['admin_msg']; ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- admin end -->
                </form>
        </div>
        <?php if (!empty($row['evidence'])): ?>
            <?php
                        $images = json_decode($row['evidence'], true);
                        $numbers = json_decode($row['evidence_numbers'] ?? '[]', true);
            ?>
            <div class="modal fade" id="evidenceModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content bg-dark bg-opacity-75">
                        <div class="modal-header border-0">
                            <h5 class="text-white">
                                Evidence Viewer
                                <span class="badge bg-secondary ms-2">Total: <?= count($images); ?></span>
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <form method="POST">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>">

                                <!-- Swiper Main -->
                                <div class="swiper mySwiper2 mb-3">
                                    <div class="swiper-wrapper">
                                        <?php foreach ($images as $index => $image): ?>
                                            <div class="swiper-slide position-relative">

                                                <!-- Number Input -->
                                                <div class="mb-2">
                                                    <label for="number_<?= $index ?>" class="text-white">Amount:</label>
                                                    <input type="number" name="evidence_numbers[<?= $index ?>]"
                                                        id="number_<?= $index ?>"
                                                        class="form-control text-center mx-auto w-25 py-3 my-3"
                                                        value="<?= $numbers[$index] ?? '' ?>" readonly>
                                                </div>

                                                <!-- Image -->
                                                <img src="<?= $image ?>" class="img-fluid evidence-img"
                                                    style="max-height:400px;cursor:pointer"
                                                    onclick="openFullscreen(this.src)">

                                                <!-- Save Button -->


                                                <!-- Delete Button -->
                                                <!-- <div class="mt-4">
              <button type="submit" name="save_evidence_numbers" class="btn btn-success" style="font-size:16px!important">
            <i class="fa-solid fa-floppy-disk"></i> Save Amount
        </button>

        <span class="px-3">-</span>

            <button type="button" class="btn btn-danger" style="font-size:16px!important" onclick="deleteEvidence('<?= $row['id']; ?>', '<?= $image; ?>')">
              <i class="fa-regular fa-trash-can"></i> Delete
            </button>
          </div> -->
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>


                            </form>
                            <!-- Swiper Thumbnails -->
                            <div class="swiper mySwiper mt-3">
                                <div class="swiper-wrapper">
                                    <?php foreach ($images as $image): ?>
                                        <div class="swiper-slide">
                                            <img src="<?= $image; ?>" class="img-thumbnail" style="height:100px">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>








        <?php

                    if (isset($_POST['save_evidence_numbers'])) {
                        $id = $_POST['id'];
                        $numbers = $_POST['evidence_numbers'] ?? [];

                        // Ensure order consistency
                        ksort($numbers);

                        // Normalize to fill empty spots with null if needed
                        $result = mysqli_query($conn, "SELECT evidence FROM expense_claim WHERE id = '$id'");
                        $row_data = mysqli_fetch_assoc($result);
                        $images = json_decode($row_data['evidence'], true);

                        $finalNumbers = [];
                        foreach ($images as $index => $img) {
                            $finalNumbers[] = isset($numbers[$index]) ? $numbers[$index] : null;
                        }

                        $encoded = json_encode($finalNumbers);
                        mysqli_query($conn, "UPDATE expense_claim SET evidence_numbers = '$encoded' WHERE id = '$id'");
                        echo "<script>alert('Evidence numbers saved successfully!'); window.location.href = window.location.href;</script>";
                    }


        ?>











        <?php
                    if (isset($_POST['delete_evidence'])) {
                        $id = $_POST['id'];
                        $deleteImage = $_POST['delete_image'];

                        $result = mysqli_query($conn, "SELECT evidence, evidence_numbers FROM expense_claim WHERE id = '$id'");
                        $row_del = mysqli_fetch_assoc($result);

                        $images = json_decode($row_del['evidence'], true);
                        $numbers = json_decode($row_del['evidence_numbers'], true);

                        // Fallback if null
                        if (!is_array($images)) {
                            $images = [];
                        }
                        if (!is_array($numbers)) {
                            $numbers = [];
                        }

                        if (($key = array_search($deleteImage, $images)) !== false) {
                            if (file_exists($deleteImage)) {
                                unlink($deleteImage);
                            }
                            unset($images[$key]);
                            unset($numbers[$key]);
                        }

                        // Re-index arrays
                        $updatedImages = json_encode(array_values($images));
                        $updatedNumbers = json_encode(array_values($numbers));

                        mysqli_query($conn, "UPDATE expense_claim SET evidence = '$updatedImages', evidence_numbers = '$updatedNumbers' WHERE id = '$id'");

                        echo "<script>alert('Evidence deleted successfully!'); window.location.href = window.location.href;</script>";
                    }
        ?>

        <?php
                    if (isset($_POST['upload_evidence'])) {
                        $id = $_GET['id'];
                        $targetDir = "uploads/evidence/";
                        $uploadedFiles = [];

                        // Fetch current evidence array
                        $result = mysqli_query($conn, "SELECT evidence FROM expense_claim WHERE id = '$id'");
                        $row_evi = mysqli_fetch_assoc($result);
                        $existingImages = json_decode($row_evi['evidence'], true) ?? [];

                        foreach ($_FILES['evidence_images']['tmp_name'] as $key => $tmpName) {
                            $filename = time() . '_' . basename($_FILES['evidence_images']['name'][$key]);
                            $targetPath = $targetDir . $filename;
                            if (move_uploaded_file($tmpName, $targetPath)) {
                                $uploadedFiles[] = $targetPath;
                            }
                        }

                        $finalImages = array_merge($existingImages, $uploadedFiles);
                        $evidenceJson = json_encode($finalImages);
                        mysqli_query($conn, "UPDATE expense_claim SET evidence = '$evidenceJson' WHERE id = '$id'");

                        echo "<script>alert('Evidence uploaded successfully!'); window.location.href = window.location.href;</script>";
                    }
        ?>
        <?php
                    include 'dbconfig.php';






                    // Check if form is submitted
                    if (isset($_POST['admin_sub'])) {
                        // Retrieve form data
                        $id = $_GET['id'];  // Assuming 'id' is passed via GET method
                        $name = $_SESSION['fullname'];

                        // If admin_comments is set in POST, use it, otherwise keep existing
                        $admin_comments = isset($_POST['admin_comments']) && $_POST['admin_comments'] !== $row['admin_comments']
                            ? $_POST['admin_comments']
                            : $row['admin_comments'];

                        // Update query (only updates expense_claim table)
                        $update_query = "UPDATE expense_claim 
                     SET admin_comments = '$admin_comments'
                     WHERE id = '$id'";

                        $result = mysqli_query($conn, $update_query);

                        if ($result) {
                            echo "<script>
        alert('Admin comments updated successfully.');
        window.location.href = window.location.href;
        </script>";
                        } else {
                            echo "<script>
        alert('Update Failed.');
        window.location.href = window.location.href;
        </script>";
                        }
                    }
        ?>

    </div>
<?php
                }
            } else {
                echo "No record found!";
            }
?>
</div>
<!--content-->
</div>
<!--wrapper-->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {

        // Ensure sidebar is CLOSED by default
        $('#sidebar').removeClass('active');

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
                ignoreColumn: []
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
<!-- 2-->
<script>
    function promptReason2(itemId) {
        var reason = prompt("Enter reason for rejection:");
        if (reason != null && reason.trim() !== "") {
            window.location.href = "ot_fpna_reject_2.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
        }
    }
</script>
<script>
    function submitRejectionReason(itemId, reason) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                location.reload();
            }
        };
        xhr.open("POST", "update_rejection_reason.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("id=" + itemId + "&reason=" + encodeURIComponent(reason));
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script>
    var thumbSwiper = new Swiper(".mySwiper", {
        spaceBetween: 10,
        slidesPerView: 5,
        watchSlidesProgress: true,
    });
    var mainSwiper = new Swiper(".mySwiper2", {
        spaceBetween: 10,
        navigation: true,
        loop: true,
        thumbs: {
            swiper: thumbSwiper
        },
    });

    function openFullscreen(src) {
        let win = window.open("", "_blank");
        win.document.write(`<img src="${src}" style="width:100%;height:100%;object-fit:contain"><button onclick="window.close()" style="position:fixed;top:10px;right:10px;z-index:999;padding:10px;background:red;color:white;border:none">Close</button>`);
    }
</script>
<script>
    function deleteEvidence(id, imagePath) {
        if (!confirm('Delete this evidence?')) return;

        const form = document.createElement('form');
        form.method = 'POST';
        form.style.display = 'none';

        const idInput = document.createElement('input');
        idInput.name = 'id';
        idInput.value = id;
        form.appendChild(idInput);

        const imgInput = document.createElement('input');
        imgInput.name = 'delete_image';
        imgInput.value = imagePath;
        form.appendChild(imgInput);

        const actionInput = document.createElement('input');
        actionInput.name = 'delete_evidence';
        actionInput.value = '1';
        form.appendChild(actionInput);

        document.body.appendChild(form);
        form.submit();
    }
</script>
</body>

</html>