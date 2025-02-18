<?php
session_start();
require 'db_connect.php'; // Make sure this file connects to your database

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT name, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Fetch user order history
$order_sql = "SELECT product_name, price, order_date FROM orders WHERE user_id = ? ORDER BY order_date DESC";
$order_stmt = $conn->prepare($order_sql);
$order_stmt->bind_param("i", $user_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: rgb(20, 30, 48);
            color: white;
            font-family: Arial, sans-serif;
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            color: black; /* Text inside container is black */
        }
        .order-history {
            background: rgba(255, 255, 255, 0.2);
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="adidas.php">Adidas Shop</a>
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
            <li class="nav-item">
                <a class="nav-link" href="profile.php">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Profile Section -->
<div class="container mt-5">
    <h2 class="text-center">Profile</h2>
    <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>

    <h4 class="mt-4">Order History</h4>
    <?php if ($order_result->num_rows > 0): ?>
        <ul class="list-group">
            <?php while ($order = $order_result->fetch_assoc()): ?>
                <li class="list-group-item order-history">
                    <strong><?= htmlspecialchars($order['product_name']) ?></strong> - 
                    Ksh <?= htmlspecialchars($order['price']) ?> <br>
                    <small>Ordered on: <?= htmlspecialchars($order['order_date']) ?></small>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No past orders found.</p>
    <?php endif; ?>
</div>

</body>
</html>
