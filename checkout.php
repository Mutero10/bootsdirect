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
    /* Background Styling */
    body {
        background: rgb(20, 30, 48); /* Same as cart.php */
        color: white;
        font-family: Arial, sans-serif;
    }

    /* Container Styling */
    .container {
        background: rgba(255, 255, 255, 0.1); /* Same as cart.php */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(10px);
        color: black; /* Black text inside the container */
    }

    /* Header Styling */
    h2, h4 {
        text-align: center;
        font-weight: bold;
    }

    /* Form Styling */
    .form-group label {
        font-weight: bold;
    }

    /* Reduce text field width */
    .form-control {
        width: 50%; /* Adjust the width as needed */
        margin: 0 auto; /* Center the input fields */
        display: block;
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

    /* Center text fields on smaller screens */
    @media (max-width: 768px) {
        .form-control {
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
