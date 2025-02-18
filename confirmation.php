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
    <style>
        /* Background Styling */
        body {
            background: rgb(20, 30, 48); /* Consistent with cart.php */
            color: white;
            font-family: Arial, sans-serif;
        }

        /* Navbar Styling */
        .navbar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .navbar-brand, .nav-link {
            color: white !important;
            font-weight: bold;
        }

        .navbar-brand:hover, .nav-link:hover {
            color: #06a4ed !important;
        }

        /* Container Styling */
        .container {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            color: black;
            max-width: 600px;
            text-align: center;
        }

        /* Header Styling */
        h2, h4 {
            font-weight: bold;
        }

        /* Button Styling */
        .btn-primary {
            background-color: rgb(0, 59, 177);
            border: none;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 20px;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: rgb(6, 164, 237);
            transform: scale(1.05);
        }

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="cart.php">Cart</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="checkout.php">Checkout</a>
            </li>
        </ul>
    </div>
</nav>


    <!-- Order Confirmation Section -->
    <div class="container mt-5">
        <h2>Order Confirmation</h2>
        <p>Thank you, <strong><?= htmlspecialchars($order['name'] ?? 'Customer') ?></strong>! Your order has been received.</p>
        <p><strong>Email:</strong> <?= htmlspecialchars($order['email'] ?? 'Not provided') ?></p>
        <p><strong>Total Price:</strong> Ksh <?= htmlspecialchars($order['total_price'] ?? '0') ?></p>

        <a href="adidas.php" class="btn btn-primary mt-3">Back to Shop</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
