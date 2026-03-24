<?php
    include 'dbconfig.php';
    
    $date = $_GET['date'] ?? '';
    $empName = $_GET['emp'] ?? '';
    
    if (empty($date) || empty($empName)) {
        die("Invalid request. Please provide both date and employee.");
    }
    
    // Fetch all rows for selected date
    $query = "SELECT * FROM staff_allocation WHERE date = '$date'";
    $result = mysqli_query($conn, $query);
    
    $records = [];
    $totalSeconds = 0; // ✅ to track total working time
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            for ($i = 1; $i <= 40; $i++) {
                if (!empty($row["name_$i"]) && $row["name_$i"] === $empName) {
                    $checkin1  = $row["checkin_$i"] ?? '';
                    $checkout1 = $row["checkout_$i"] ?? '';
                    $checkin2  = $row["checkin_{$i}_2"] ?? '';
                    $checkout2 = $row["checkout_{$i}_2"] ?? '';
                    $batchNo   = $row["batch_no"] ?? ''; // ✅ New
                    
                    // ✅ calculate hours difference
                    if (!empty($checkin1) && !empty($checkout1)) {
                        $totalSeconds += strtotime($checkout1) - strtotime($checkin1);
                    }
                    if (!empty($checkin2) && !empty($checkout2)) {
                        $totalSeconds += strtotime($checkout2) - strtotime($checkin2);
                    }
    
                    $records[] = [
                        'name'      => $row["name_$i"],
                        'job'       => $row["jobs_$i"] ?? '',
                        'batch_no'  => $batchNo,   // ✅ store batch no
                        'checkin1'  => $checkin1,
                        'checkout1' => $checkout1,
                        'checkin2'  => $checkin2,
                        'checkout2' => $checkout2,
                    ];
                }
            }
        }
    }
    
    // ✅ Convert total seconds into H:i format
    $totalHours = gmdate("H:i", $totalSeconds);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Employee Record - <?= htmlspecialchars($empName) ?></title>
        <?php include 'cdncss.php'?>
        <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
        <style>
                a{
        text-decoration:none!important
    }
    body {
        font-family: 'Poppins', sans-serif;
    }
            .table th {
                font-size: 12px !important;
                border: none !important;
                background-color: #1B7BBC !important;
                color: white !important;
                padding: 6px 5px !important;
            }
            .table td {
                font-size: 12px;
                color: black;
                padding: 7px 5px !important;
                font-weight: 500;
                border: none !important
            }
        </style>
    </head>
    <body class="p-4">
        <h5 style="font-weight:600!important">
            Records for <span style="color:#0D9276"><?= htmlspecialchars($empName) ?></span> 
            on <?= date('d-M-Y', strtotime($date)) ?>
        </h5>
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Job</th>
                    <th>Batch No</th> <!-- ✅ New -->
                    <th>Checkin 1</th>
                    <th>Checkout 1</th>
                    <th>Checkin 2</th>
                    <th>Checkout 2</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($records)): ?>
                <?php foreach ($records as $rec): ?>
                <tr>
                    <td><?= htmlspecialchars($rec['name']) ?></td>
                    <td><?= htmlspecialchars($rec['job']) ?></td>
                    <td><?= htmlspecialchars($rec['batch_no']) ?></td> <!-- ✅ Show Batch -->
                    <td><?= htmlspecialchars($rec['checkin1']) ?></td>
                    <td><?= htmlspecialchars($rec['checkout1']) ?></td>
                    <td><?= htmlspecialchars($rec['checkin2']) ?></td>
                    <td><?= htmlspecialchars($rec['checkout2']) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center text-danger">
                        No records found for this employee on selected date.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if (!empty($records)): ?>
        <h6 class="mt-3" style="font-weight:600;color:black">
            Total Working Hours: <span style="color:#0D9276"><?= $totalHours ?></span>
        </h6>
        <?php endif; ?>
        <?php include 'footer.php'?>
    </body>
</html>
