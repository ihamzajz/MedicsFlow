<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Your Page Title</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <style>
            body {
            font-family: 'Poppins', sans-serif;
            }
            th{
            font-size: 11.5px;
            }
            td{
            font-size: 11.5px;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <?php
                include 'dbconfig.php';
                
                $select = "SELECT * FROM orders";
                
                $select_q = mysqli_query($conn,$select);
                $data = mysqli_num_rows($select_q);
                   ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Id </th>
                        <th scope="col">Email</th>
                        <th scope="col">Fullname</th>
                        <th scope="col">Country</th>
                        <th scope="col">Address </th>
                        <th scope="col">City</th>
                        <th scope="col">Postol Code</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Cart Data</th>
                        <th scope="col">Shipping Method</th>
                        <th scope="col">Payment Method</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Order Status</th>
                         <th scope="col">Update</th>
                    </tr>
                </thead>
   <tbody class="searchable">
<?php 
if ($data) {
    while ($row = mysqli_fetch_array($select_q)) {
?>
<tr>
    <form method="POST">
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['full_name']; ?></td>
        <td><?php echo $row['country']; ?></td>
        <td><?php echo $row['address']; ?></td>
        <td><?php echo $row['city']; ?></td>
        <td><?php echo $row['postal_code']; ?></td>
        <td><?php echo $row['phone']; ?></td>
        <td>
            <?php 
                $cartItems = json_decode($row['cart_data'], true); 
                if ($cartItems) {
                    foreach ($cartItems as $item) {
                        echo htmlspecialchars($item['name']) . ' x ' . $item['qty'] . ' = ' . $item['price'] . '<br>';
                    }
                } else {
                    echo 'Invalid cart data';
                }
            ?>
        </td>
        <td><?php echo $row['shipping_method']; ?></td>
        <td><?php echo $row['payment_method']; ?></td>
        <td><?php echo $row['created_at']; ?></td>
        <td>
            <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
            <select class="form-select" name="status">
                <option value="1" <?= $row['courier_order_status'] == 1 ? 'selected' : '' ?>>Confirmed</option>
                <option value="2" <?= $row['courier_order_status'] == 2 ? 'selected' : '' ?>>Order in Process</option>
                <option value="4" <?= $row['courier_order_status'] == 4 ? 'selected' : '' ?>>Dispatched</option>
                <option value="5" <?= $row['courier_order_status'] == 5 ? 'selected' : '' ?>>Delivered</option>
                <option value="6" <?= $row['courier_order_status'] == 6 ? 'selected' : '' ?>>Returned</option>
                <option value="7" <?= $row['courier_order_status'] == 7 ? 'selected' : '' ?>>Cancelled</option>
                <option value="8" <?= $row['courier_order_status'] == 8 ? 'selected' : '' ?>>Cancelled Manually</option>
                <option value="9" <?= $row['courier_order_status'] == 9 ? 'selected' : '' ?>>Returned</option>
            </select>
            
        </td>
        <td>
          <button type="submit" class="btn btn-sm btn-primary mt-1">Update</button>
        </td>

    </form>
</tr>
<?php
    }
} else {
    echo "<tr><td colspan='13'>No record found!</td></tr>";
}
?>
</tbody>
<?php
include 'dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Update local DB
    if (isset($_POST['order_id'], $_POST['status'])) {
        $orderId = intval($_POST['order_id']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        $update = "UPDATE orders SET courier_order_status = '$status' WHERE id = '$orderId'";
        if (mysqli_query($conn, $update)) {
            echo "<script>alert('✅ Local DB: Status updated for Order ID $orderId');</script>";
        } else {
            $error = mysqli_error($conn);
            echo "<script>alert('❌ Local DB: Update failed. Error: $error');</script>";
        }
    }

    // 2. Send status to Laravel if requested
    if (isset($_POST['update_status'])) {
        $orderId = intval($_POST['order_id']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        $username = 'medics';
        $password = '!@#$%^&*()_++_)(*&^%$#@!';
        $url = 'http://127.0.0.1:8000/receive-status-update';

        $postData = [
            'order_id' => $orderId,
            'status_code' => $status,
            'username' => $username,
            'password' => $password,
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);

        if ($curlError) {
            echo "<script>alert('❌ CURL Error: $curlError');</script>";
        } else {
            if ($httpCode == 200) {
                echo "<script>alert('✅ Laravel: Status sent successfully. Response: " . htmlspecialchars($response) . "');</script>";
            } else {
                echo "<script>alert('❌ Laravel: Failed. HTTP Code: $httpCode. Response: " . htmlspecialchars($response) . "');</script>";
            }
        }
        curl_close($ch);
    }
}
?>





            </table>
        </div>
        <!--ander ka kaam khatam-->
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-LZN37f5QGtVUb+V0M+qOKW0CJqNnro8m4qbTIe3zZlroZbi8jM3BbTwYwHf5bF5M" crossorigin="anonymous"></script>
    </body>
</html>