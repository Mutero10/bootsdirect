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
    background: rgb(20, 30, 48); /* Dark theme for consistency */
    color: white;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

/* Navbar Styling */
.navbar {
    background: linear-gradient(90deg, rgb(0, 59, 177), rgb(20, 30, 48)); /* Dark blue gradient */
    backdrop-filter: blur(10px);
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.list-group-item {
    background: rgba(255, 255, 255, 0.1) !important; /* Matches container */
    color: white !important; /* Ensures text remains readable */
    border: 1px solid rgba(255, 255, 255, 0.2); /* Soft border */
}

.navbar-brand, .nav-link {
    color: white !important;
    font-weight: bold;
    text-decoration: none;
    padding: 10px 15px;
    transition: 0.3s;
}

.navbar-brand:hover, .nav-link:hover {
    color: #06a4ed !important;
}

/* Main Container Styling */
.container {
    background: rgba(255, 255, 255, 0.1); /* Transparent, matching the background */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(10px);
    color: white; /* Ensure text is readable */
    max-width: 600px;
    text-align: center;
}

/* Checkout Section Styling */
.checkout-container {
    background: rgba(255, 255, 255, 0.1); /* Same as .container */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(10px);
    color: white; /* Keep text readable */
}

/* Header Styling */
h2, h4 {
    font-weight: bold;
}

/* Input Fields */
.form-control {
    width: 80%;
    margin: 10px auto;
    display: block;
    padding: 8px;
    border: 1px solid grey;
    border-radius: 5px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.form-control::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

/* Button Styling */
.btn-primary {
    background-color: rgb(0, 59, 177);
    border: none;
    font-size: 16px;
    font-weight: bold;
    padding: 10px 20px;
    margin-top: 15px;
    display: block;
    width: 80%;
    margin-left: auto;
    margin-right: auto;
    transition: 0.3s;
    border-radius: 5px;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: rgb(6, 164, 237);
    transform: scale(1.05);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .form-control, .btn-primary {
        width: 100%;
    }
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

    <!-- Ordered Items List -->
    <h3>Ordered Items:</h3>
    <ul class="list-group">
        <?php foreach ($_SESSION['cart'] as $item): ?>
            <li class="list-group-item">
                <strong><?= htmlspecialchars($item['name']) ?></strong>  
                <br> <small>Size: <?= htmlspecialchars($item['size']) ?></small>  
                <br> Ksh <?= htmlspecialchars($item['price']) ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="adidas.php" class="btn btn-primary mt-3">Back to Shop</a>
</div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>