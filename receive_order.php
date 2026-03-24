<?php
// Show errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// Include DB
include 'dbconfig.php';

// Read and decode JSON input
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// Validate JSON
if (!is_array($data)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
    exit;
}

// Extract credentials
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

// ✅ Authenticate user using plain text password
$stmt = $conn->prepare("SELECT password FROM api_users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Authentication failed: user not found']);
    exit;
}

$row = $result->fetch_assoc();
$storedPassword = $row['password'];

// 👉 Plain password comparison (as you asked)
if ($password !== $storedPassword) {
    echo json_encode(['status' => 'error', 'message' => 'Authentication failed: wrong password']);
    exit;
}

// Extract order data
$email = $conn->real_escape_string($data['email'] ?? '');
$country = $conn->real_escape_string($data['country'] ?? '');
$full_name = $conn->real_escape_string($data['full_name'] ?? '');
$address = $conn->real_escape_string($data['address'] ?? '');
$city = $conn->real_escape_string($data['city'] ?? '');
$postal_code = $conn->real_escape_string($data['postal_code'] ?? '');
$phone = $conn->real_escape_string($data['phone'] ?? '');
$cart_data = $conn->real_escape_string($data['cart_data'] ?? '');
$shipping_method = $conn->real_escape_string($data['shipping_method'] ?? '');
$payment_method = $conn->real_escape_string($data['payment_method'] ?? '');

// Insert into orders table
$sql = "INSERT INTO orders 
(email, country, full_name, address, city, postal_code, phone, cart_data, shipping_method, payment_method)
VALUES 
('$email', '$country', '$full_name', '$address', '$city', '$postal_code', '$phone', '$cart_data', '$shipping_method', '$payment_method')";

if ($conn->query($sql)) {
    echo json_encode(['status' => 'success', 'message' => 'Order saved successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}

$conn->close();
?>
