<?php
    session_start();
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php'); // Redirect to the login page
        exit;
    }
    include 'dbconfig.php';
    ?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Expense Dashboard</title>
        <style>
            p {
            margin-bottom: 2px; 
            padding-bottom: 0; 
            }
        </style>
        <style>
            .label{
            font-size: 16px;
            font-weight:500;
            padding-bottom: 5px;
            }
            .row1-cols{
            background-color: #fefffe;
            padding-top: 15px;
            padding-bottom: 10px;
            margin-right: 20px!important;
            margin-left: 20px!important;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            }
            .row2-cols{
            background-color: #fefffe;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            padding: 15px;
            }
            th{
            font-size: 12px!important;
            }
            td{
            font-size: 13px!important;
            }
            th{
            border-color: #00ADB5;
            }
            tr, td{
            border-color: grey;
            }
        </style>
        <style>
            .modal-fullscreen {
            width: 100vw;
            max-width: 100%;
            height: 100vh;
            max-height: 100%;
            margin: 0;
            }
            .modal-fullscreen .modal-dialog {
            width: 100%;
            max-width: none;
            height: 100%;
            margin: 0;
            }
            .modal-fullscreen .modal-content {
            height: 100%;
            border: none;
            border-radius: 0;
            }
        </style>
        <style>
            button{
            padding: 6px!important;
            }
            .heading-main{
            padding-top: 10px;
            padding-bottom: 10px;
            font-size: 22px;
            font-weight:700;
            color: white;
            background-image: linear-gradient( 109.6deg,  rgba(254,87,98,1) 11.2%, rgba(255,107,161,1) 99.1% );
            }
        </style>
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <ul class="nav nav-pills" id="pills-tab" role="tablist">       
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <a href="field_visit_search.php"><button  type="button" class="btn btn-dark btn-sm">Back</button></a>
                    <button id="print1" type="button" class="btn btn-danger btn-sm" onclick="getPrint()">PDF</button>
                    <button id="excel" class="btn btn-success btn-sm dataExport" data-type="excel">Excel</button>
                    <input id="filter" type="text" class="form-control w-25" placeholder="Search here..." style="height: 30px; display:inline;">          
                </div>
                <div class="row">
    <div class="col">
        <?php
        include 'dbconfig.php';
        $asm = $_GET['asm'];
        $date = $_GET['date'];

        // Fetch the row data from the database
        $select = "SELECT * FROM field_visit_form WHERE name = '$asm' AND date = '$date' ORDER BY date DESC";
        $select_q = mysqli_query($conn, $select);
        $data = mysqli_num_rows($select_q);

        // Fetch the depot and joint_visit values
        $depot = '';
        $joint_visit = '';
        $zone = '';
        if ($data) {
            $row = mysqli_fetch_array($select_q);
            $depot = $row['depot'];
            $joint_visit = $row['joint_visit'];
            $zone = $row['zone'];
            // Reset the result pointer to the beginning
            mysqli_data_seek($select_q, 0);
        }

        $products = [
            'Coldeez (Pelargonium) Syrup 120ml',
            'Digas Antacid Suspension 120ml',
            'Digas Antacid Susp. Sachet 25x10ml',
            'Digas Classic Tab 120\'s',
            'Digas Tab. Khatti Meethi 120\'s',
            'Digas Colic Drops 20ml',
            'Digas Syrup 120ml',
            'F. C. Forte Syrup 120ml',
            'Herbituss Syrup 120ml',
            'Livgen Drops 20ml',
            'Livgen Syrup 120ml',
            'Medics Children Cough Syrup 120ml',
            'Medics Toot Siah Plus 120ml',
            'Medics Inhaler 1ml',
            'Rumol Cream 25gm'
        ];
        ?>
        <div id="dataTableCont">
            <table class="table table-responsive table-bordered mt-1" id="myTable">
                <thead style="background-color: #00ADB5; color: white">
                    <tr>
                        <th colspan="4" style="background-color: #F8F6E3;color:black">Name: <span style="color: #00ADB5;font-size:13px"><?php echo $asm ?></span> <br> Date: <span style="color: #00ADB5;font-size:13px"><?php echo $date ?></span></th>
                        <th colspan="9" style="background-color: #cbf1f5;color:black;font-size:24px!important;text-align:center">Field Visit Report</th>
                        <th colspan="5" style="background-color: #F8F6E3;color:black">Depot: <span style="color: #00ADB5;font-size:13px"><?php echo $depot ?></span><br>Joint Visit: <span style="color: #00ADB5;font-size:13px"><?php echo $joint_visit ?></span><br>Zone: <span style="color: #00ADB5;font-size:13px"><?php echo $zone ?></span></th>
                    <tr>
                        <th scope="col">Serial No</th>
                        <th scope="col">Date</th>
                        <th scope="col">Customer Name</th>
                        <?php foreach ($products as $product): ?>
                        <th scope="col"><?php echo $product; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody class="searchable">
                    <?php 
                    if ($data) {
                        $serialNo = 1; 
                        while ($row = mysqli_fetch_array($select_q)) {
                            echo '<tr>';
                            echo '<td>' . $serialNo++ . '</td>'; 
                            echo '<td>' . $row['date'] . '</td>';
                            echo '<td>' . $row['customer_name'] . '</td>';
                            $cellValues = array_fill(0, 15, '');

                            for ($i = 1; $i <= 15; $i++) {
                                $productColumn = "products_" . $i;
                                $qtyColumn = "order_qty_" . $i;
                                $productValue = $row[$productColumn];
                                $orderQty = $row[$qtyColumn];
                                $index = array_search($productValue, $products);
                                if ($index !== false) {
                                    $cellValues[$index] = $orderQty;
                                }
                            }
                            foreach ($cellValues as $cellValue) {
                                echo "<td>$cellValue</td>";
                            }
                            echo '</tr>';
                        }
                    } else {
                        echo "<tr><td colspan='18' class='text-center' style='font-size:18px!important'>No Data Found!</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

            </div>
        </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>
        <script>
            $(document).ready(function() {
                $(".full-screen-image").click(function() {
                    var imgSrc = $(this).attr("data-src");
                    $(".full-screen-overlay").html('<span class="close-btn">&times;</span><img src="' + imgSrc + '" class="img-fluid">');
                    $(".full-screen-overlay").fadeIn();
                });
                $(document).on("click", ".close-btn", function() {
                    $(".full-screen-overlay").fadeOut();
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
        <script src="
            https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/tableExport.min.js
            "></script>
        <script type="text/javascript" src="libs/FileSaver/FileSaver.min.js"></script>
        <script type="text/javascript" src="../libs/jsPDF/polyfills.umd.js"></script>
        <script type="text/javascript" src="tableExport.min.js"></script>
        <script type="text/javascript">   </script>
        <script>
            $(document).ready(function() {
                $('#excel').click(function() {
                    $('#myTable').tableExport({
                        type: 'excel'
                    });
                });
            });
        </script>
    </body>
</html>