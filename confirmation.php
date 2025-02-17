<?php
session_start();

// Ensure delivery details exist
if (!isset($_SESSION['delivery_details'])) {
    die("No order details found in session!");
}

$deliveryDetails = $_SESSION['delivery_details'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Retrieve the latest order from database using stored order ID
$orderID = $deliveryDetails['order_id'];
$sql = "SELECT * FROM orders WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $orderID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
} else {
    die("Order not found in database.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <div class="container mt-5">
        <h2>Order Confirmation</h2>
        <p>Thank you, <strong><?= htmlspecialchars($order['name'] ?? 'Customer') ?></strong>! Your order has been received.</p>
        <p>Email: <?= htmlspecialchars($order['email'] ?? 'Not provided') ?></p>
        <p>Total Price: Ksh <?= htmlspecialchars($order['total_price'] ?? '0') ?></p>

        <h4>Delivery Details:</h4>
        <p>Address: <?= htmlspecialchars($deliveryDetails['address'] ?? 'Unknown') ?></p>
        <p>Expected Delivery: <?= htmlspecialchars($deliveryDetails['delivery_time'] ?? 'Unknown') ?></p>
        <p>Order Confirmation Number: <?= htmlspecialchars($deliveryDetails['order_confirmation_number'] ?? 'N/A') ?></p>

        <a href="index.php" class="btn btn-primary">Back to Shop</a>
    </div>

</body>
</html>
