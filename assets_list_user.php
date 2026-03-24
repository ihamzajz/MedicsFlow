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
    <title>Asset List</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        h6 {
            font-size: 16px !important;
        }

        th.hidden,
        td.hidden {
            display: none;
        }

        .btn-dark,
        .btn-success,
        .btn-danger,
        .btn-info {
            font-size: 11px;
        }

        .labelm {
            font-size: 11px;
            font-weight: bold;
        }

        select,
        select option,
        input[type=date] {
            font-size: 13px !important;
            height: 10px !important;
        }

        .btn-menu {
            background-color: #06923E !important;
            color: white !important;
            border-radius: 0px !important;
            font-size: 11px !important;
        }

        .btn-menu:hover {
            background-color: #06923E !important;
            color: white !important;
            border-radius: 0px !important;
            font-size: 11px !important;
        }
    </style>
    <style>
        .heading-main {
            padding-top: 10px;
            padding-bottom: 10px;
            font-size: 22px;
            font-weight: 700;
            color: white;
            background-color: #8576FF;
        }

        table th {
            background-color: #1B7BBC !important;
            color: white !important;
            position: sticky;
            top: 0;
            z-index: 1000;
            font-size: 11.5px;
            text-align: left;
            letter-spacing: 0.4px;
            font-weight: 600;
            border: none !important;
        }

        table td {
            font-size: 11px;
            color: black !important;
            padding: 5px 10px !important;
            border: 1px solid #ddd;
            letter-spacing: 0.2px;
        }
    </style>
    <link rel="stylesheet" href="assets/css/style.css">

    <?php
    include 'sidebarcss.php'
        ?>

    <style>
        /* Force horizontal scrolling for table */
        .table-responsive {
            overflow-x: auto;
        }

        /* Prevent buttons from wrapping */
        .btn-view {
            white-space: nowrap !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            background-color: #CFE2FF;
            color: white !important;
            border-radius: 15px !important;
            transition: all 0.3s ease !important;
            padding: 4px 15px !important;
            color: black !important;
            border: 1px solid #0DCAF0 !important;
        }

        .btn-view:hover {
            filter: brightness(85%);
        }

        .btn-delete {
            white-space: nowrap;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.5px;
            border-radius: 15px;
            background-color: #DC2525 !important;
            color: white !important;
        }
    </style>
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <?php
        include 'sidebar1.php';
        ?>
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-menu">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </nav>
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

            $be_depart = $_SESSION['be_depart'];
            $bc_role = $_SESSION['be_role'];

            // $select = "SELECT * FROM workorder_form where username = '$username'";
            $select = "SELECT * FROM assets WHERE department_be = '$be_depart' order by id desc";


            $select_q = mysqli_query($conn, $select);
            $data = mysqli_num_rows($select_q);
            ?>
            <div class="table-wrapper">
                <div class="table-container1">
                    <!-- <a href="asset_receipt_form" class="btn btn-primary" style="font-size:12px!important;border-radius:15px!important"><i class="fa-solid fa-plus"></i> Create New</a> -->


                    <div class="d-flex align-items-center mb-2 px-3">
                        <!-- Left Buttons -->
                        <div class="d-flex">
                            <a class="btn btn-dark btn-sm me-2" href="assets_management_home.php"
                                style="font-size:11px!important">
                                <i class="fa-solid fa-home"></i> Home
                            </a>
                            <a href="asset_receipt_form" class="btn btn-primary btn-sm"
                                style="font-size:12px!important;">
                                <i class="fa-solid fa-plus"></i> Create New
                            </a>
                        </div>

                        <!-- Center Heading -->
                        <div class="flex-grow-1 text-center">
                            <h5 class="m-0 fw-bold">Assets List</h5>
                        </div>

                        <!-- Right Search -->
                        <div style="min-width:200px;">
                            <input type="text" id="filter" class="form-control form-control-sm" placeholder="Search...">
                        </div>
                    </div>




                </div>
                <table class="table table-responsive table-bordered mt-1 table-hover" id="myTable">
                    <thead>
                        <tr id="row_<?php echo $row['id']; ?>">
                            <th scope="col" class="hidden">Status</th>
                            <th>View</th>
                            <th scope="col">Asset Name</th>
                            <th scope="col">Asset Tag No</th>
                            <th scope="col">Department Location</th>
                            <th scope="col">Asset Location</th>
                            <th scope="col">Date Of Purchase</th>
                            <th scope="col">Ref id</th>
                            <th scope="col">Status</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody class='searchable' id="data-body">
                        <!-- Data will be loaded via AJAX -->
                    </tbody>
                </table>
            </div>
            <div class="container-fluid pagination-scroll" style="width: 100%;">
                <div class="d-flex align-items-center position-relative" style="min-height: 40px;">
                    <!-- Left: Total Count -->
                    <div id="total-count" style="font-size:13px; white-space: nowrap;">
                        Total: 0
                    </div>
                    <!-- Center: Pagination Controls -->
                    <div id="pagination-controls" class="position-absolute start-50 translate-middle-x text-center">
                        <!-- Pagination buttons loaded via AJAX -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable({
                "paging": true, // Enable pagination
                "searching": true, // Enable search box
                // More options can be added as needed
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('#excel').click(function () {
                $('#myTable').tableExport({ type: 'excel' });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            (function ($) {
                $('#filter').keyup(function () {
                    var rex = new RegExp($(this).val(), 'i');
                    $('.searchable tr').hide();
                    $('.searchable tr').filter(function () {
                        return rex.test($(this).text());
                    }).show();
                })

            }(jQuery));
        });
    </script>
    <script src="assets/js/main.js"></script>
    <script>
        $(document).ready(function () {
            let offset = 0;
            const limit = 15;
            const $dataBody = $('#data-body');
            const $paginationControls = $('#pagination-controls');
            const $filterInput = $('#filter');

            function loadData() {
                $.ajax({
                    url: 'fetchData_asset_management_user.php',
                    type: 'GET',
                    data: {
                        limit: limit,
                        offset: offset,
                        search: $filterInput.val()
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.data) {
                            $dataBody.html(response.data.rows);
                            $paginationControls.html(response.data.pagination);
                            $('#total-count').text("Total: " + response.total); // ✅ update total
                            offset = response.nextOffset;
                        } else {
                            $dataBody.html('<tr><td colspan="10" class="text-center">No results found</td></tr>');
                            $('#total-count').text("Total: 0");
                        }
                    }
                });
            }

            loadData();

            $paginationControls.on('click', 'button', function () {
                let newOffset = $(this).data('offset');
                if (newOffset !== undefined) {
                    offset = newOffset;
                    loadData();
                }
            });

            $filterInput.on('input', function () {
                offset = 0;
                loadData();
            });
        });
    </script>
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this asset?")) {
                window.location.href = "asset_delete.php?id=" + id;
            }
        }
    </script>
    <!-- ✅ Delete success/error alert -->
    <?php if (isset($_GET['delete_success'])): ?>
        <script>
            alert("Asset deleted successfully!");
            if (history.replaceState) {
                const cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                window.history.replaceState({ path: cleanUrl }, '', cleanUrl);
            }
        </script>
    <?php elseif (isset($_GET['delete_error'])): ?>
        <script>
            alert("Error deleting asset.");
            if (history.replaceState) {
                const cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                window.history.replaceState({ path: cleanUrl }, '', cleanUrl);
            }
        </script>
    <?php endif; ?>
</body>

</html>