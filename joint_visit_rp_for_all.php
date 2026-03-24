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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Joint Visit Reporting Tool</title>
        <style>
            .heading-main{
            padding-top: 10px;
            padding-bottom: 10px;
            font-size: 22px;
            font-weight:700;
            color: white;
            background-color: #8576FF;
            /* background-image: linear-gradient( 109.6deg,  rgba(254,87,98,1) 11.2%, rgba(255,107,161,1) 99.1% ); */
        }
            th{
                font-size: 12px!important;
            }
            td{
                font-size: 12px!important;
            }
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
            .row1-cols {
            background-color: #fefffe;
            padding-top: 15px;
            padding-bottom: 10px;
            margin-right: 10px !important;
            margin-left: 10px !important;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        .row1-cols {
                background-color: #fefffe;
                padding: 15px 10px 10px 10px;
                margin: 0 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            }
            @media (max-width: 767.98px) {
                .row1-cols {
                    margin: 0 5px;
                    padding: 10px 5px 5px 5px;
                }
            }
            .row2-cols {
                background-color: #fefffe;
                padding: 15px 20px 10px 20px;
                margin: 0 20px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            }
            @media (max-width: 767.98px) {
                .row2-cols {
                    margin: 0 10px;
                }
            }
        </style>

        <style>
            button{
            /* font-size: 15px!important; */
            padding: 6px!important;
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
                        <h4 class="text-center heading-main">
                    <span style="float:left;">
                        <a href="reportingtool.php"><button class="btn btn-sm" style="color: white;font-weight:bold">Back</button></a>
                    </span>
                    Joint Visit Dashboard
                </h4>
                    <div class="row pb-2 g-0">
                        <div class="col-lg-2 col-md-3 col-sm-6  row1-cols">
                            <label for="fromDate" class="label labelm">From Date:</label><br>
                            <input type="date" id="fromDate" name="fromDate" class="form-control">
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 row2-cols">
                            <label for="toDate" class="label labelm">To Date:</label><br>
                            <input type="date" id="toDate" name="toDate" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?php
                            include 'dbconfig.php';
                            $select = "SELECT * FROM joint_visit  ORDER BY date DESC";
                            $select_q = mysqli_query($conn,$select);
                            $data = mysqli_num_rows($select_q);
                            ?>
                        <div id="dataTableCont">
                            <table class="table table-responsive table-bordered mt-1" id="myTable" style="background-color: #fefefe;box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
                                <thead class="thead-dark" style="background-color: #FE6389;color:white">
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Development Plan</th>
                                        <th scope="col">Details</th>
                                    </tr>
                                </thead>
                                <tbody class="searchable">
                                    <?php 
                                        if($data){
                                            while ($row=mysqli_fetch_array($select_q)) {
                                        
                                                ?>
                                    <tr>
                                        <td><?php echo $row['id']?></td>
                                        <td><?php echo $row['name']?></td>
                                        <td><?php echo $row['date']?></td>
                                        <td><?php echo $row['development_plan']?></td>
                                        <td>
                                            <a style="background-color: #8576FF;color:white" href="joint_visit_details.php?id=<?php echo $row['id']; ?>" class="btn btn-sm medics-system ">Details</a>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                        } else {
                                        echo "No record found!";
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
            $(document).ready(function(){
             function applyDateFilters() {
                 var fromDate = $('#fromDate').val(); 
                 var toDate = $('#toDate').val(); 
                 filterTableByDate(fromDate, toDate);
             }
             function filterTableByDate(fromDate, toDate) {
                 $('#myTable tbody tr').each(function() {
                     // Parse the row date and selected dates
                     var rowDate = $(this).find('td:nth-child(6)').text().trim(); // Get date from sixth column
                     var rowDateObj = new Date(rowDate);
                     var selectedFromDate = new Date(fromDate);
                     var selectedToDate = new Date(toDate);
                     var dateMatch = (fromDate === "" || rowDateObj >= selectedFromDate) && (toDate === "" || rowDateObj <= selectedToDate);
                     
                     if (dateMatch) {
                         $(this).show();
                     } else {
                         $(this).hide();
                     }
                 });
             }
            
             // Add event listeners to fromDate and toDate inputs
             $('#fromDate, #toDate').change(applyDateFilters);
            });
            
            
        </script>
    </body>
</html>