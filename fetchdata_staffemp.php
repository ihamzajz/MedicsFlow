<?php
include 'dbconfig.php';

$employee = $_GET['employee'] ?? null;
$date = $_GET['date'] ?? null;

if (!$employee || !$date) {
    die("<p class='error'>❌ Invalid Input</p>");
}

$query = "SELECT * FROM staff_allocation WHERE date = '$date'";
$result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Data</title>
        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <!-- Our Custom CSS -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
        <!-- Font Awesome JS -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="assets/css/style.css">
        <!-- fevicon -->
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>
    <style>
     
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }
        th, td {
            font-size: 11.5px;
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
            
        }
        .error {
            color: red;
            font-size: 18px;
        }
        .back-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h5>Employee Data for <?php echo htmlspecialchars($employee); ?> on <?php echo htmlspecialchars($date); ?></h5>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Batch</th>
                        <th>Job</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Remarks</th>
                        <th>Total Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while ($row = mysqli_fetch_assoc($result)): 
                        for ($i = 1; $i <= 25; $i++): 
                            $nameCol = "name_$i";
                            $jobCol = "jobs_$i";
                            $checkinCol = "checkin_$i";
                            $checkoutCol = "checkout_$i";
                            $remarksCol = "remarks_$i";

                            if (!empty($row[$nameCol]) && $row[$nameCol] == $employee): 
                                $checkin = strtotime($row[$checkinCol]);
                                $checkout = strtotime($row[$checkoutCol]);
                                $totalTime = ($checkout && $checkin) ? gmdate("H:i:s", $checkout - $checkin) : "N/A";
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['batch_no']); ?></td>
                        <td><?php echo htmlspecialchars($row[$jobCol]); ?></td>
                        <td><?php echo htmlspecialchars($row[$checkinCol]); ?></td>
                        <td><?php echo htmlspecialchars($row[$checkoutCol]); ?></td>
                        <td><?php echo htmlspecialchars($row[$remarksCol]); ?></td>
                        <td><?php echo $totalTime; ?></td>
                    </tr>
                    <?php 
                            endif;
                        endfor; 
                    endwhile; 
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="error">❌ No records found</p>
        <?php endif; ?>

        <a href="sa_emp.php" class="btn btn-primary">🔙 Go Back</a>
    </div>
</body>

</html>
