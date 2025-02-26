<?php
session_start();

require_once 'databasehandler.php';


// Ensure there are items in the cart
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    echo "<p>Your cart is empty. <a href='adidas.php'>Go back to shop</a></p>";
    exit;
}


$cartItems = $_SESSION['cart'];
$totalPrice = array_sum(array_column($cartItems, 'price'));

$dbHandler = new DatabaseHandler(); // Database connection

// Process each item in the cart and update product quantity
foreach ($cartItems as $item) {
    $productId = $item['id']; // Make sure 'id' exists in your cart session
    $quantityBought = 1; // Assuming each item is bought once

    $updateSuccess = $dbHandler->updateProductQuantity($productId, $quantityBought);

    if (!$updateSuccess) {
        echo "<p>Sorry, one or more items are out of stock!</p>";
        exit;
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
  /* General Styling */
body {
    background: rgb(20, 30, 48); /* Dark background */
    color: white;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.list-group-item {
    background: rgba(255, 255, 255, 0.1) !important; /* Matches container */
    color: white !important; /* Ensures text remains readable */
    border: 1px solid rgba(255, 255, 255, 0.2); /* Soft border */
}

/* Navbar Styling */
.navbar {
    background: linear-gradient(90deg, rgb(0, 59, 177), rgb(20, 30, 48)); /* Dark blue gradient */
    color: white;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.navbar a {
    color: white;
    text-decoration: none;
    padding: 10px 15px;
    transition: 0.3s;
}

.navbar a:hover {
    background: grey;
    color: black;
    border-radius: 5px;
}

/* Main Container Styling */
.container {
    background: rgba(255, 255, 255, 0.1); /* Slight transparency for a smooth look */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(10px);
    color: white; /* White text for readability */
    max-width: 600px;
    margin: 20px auto;
}

/* Checkout Section Styling - Same as container */
.checkout-container {
    background: rgba(255, 255, 255, 0.1); /* Same as .container */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(10px);
    color: black; /* Black text for readability */
}

/* Header Styling */
h2, h4 {
    text-align: center;
    font-weight: bold;
}

/* Form Styling */
.form-group label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

/* Input Fields */
.form-control {
    width: 80%;
    margin: 0 auto;
    display: block;
    padding: 8px;
    border: 1px solid grey;
    border-radius: 5px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.checkout-container .form-control {
    background: rgba(255, 255, 255, 0.2); /* Keep inputs same as the container */
    color: white;
    border: 1px solid grey;
}

.form-control::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

.checkout-container .form-control::placeholder {
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

<!-- Navbar Section -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="adidas.php">My Store</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="adidas.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">Cart</a>
                </li>
               
            </ul>
        </div>
    </div>
</nav>


<div class="container mt-5">
    <h2>Checkout</h2>
    <!-- Cart Items List -->
    <ul class="list-group">
    <?php foreach ($cartItems as $item): ?>
        <li class="list-group-item">
            <strong><?= htmlspecialchars($item['name']) ?></strong>  
            <br> <small>Size: <?= htmlspecialchars($item['size']) ?></small>  
            <br> Ksh <?= htmlspecialchars($item['price']) ?>
        </li>
    <?php endforeach; ?>
   </ul>


    <h4 class="mt-3">Total: Ksh <?= $totalPrice ?></h4>

    <!-- Order Form -->
    <form action="send_order.php" method="POST">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Place Order</button>
    </form>
</div>

</body>
</html>
