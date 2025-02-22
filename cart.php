<?php 
session_start();
include 'databasehandler.php';

$db = new DatabaseHandler();

// Ensure the cart is initialized
$cart = $_SESSION["cart"] ?? [];

if (empty($cart)) {
    echo "<p>Your cart is empty.</p>";
    exit;
}

$cartItems = $cart; // Use session data directly

// Display cart items
foreach ($cartItems as $item) {
  //  echo "<p>" . htmlspecialchars($item["name"]) . " (Size: " . htmlspecialchars($item["size"]) . ") - Ksh " . htmlspecialchars($item["price"]) . "</p>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        
        /* Background Styling */
        body {
            background:rgb(20, 30, 48); /* Dark blue */
            color: white;
            font-family: Arial, sans-serif;
        }

        /* Container Styling */
        .container {
            background: rgba(255, 255, 255, 0.1); /* Slightly transparent white */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }

        /* Header Styling */
        h1 {
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
        }

        /* List Group Item Styling */
        .list-group-item {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: none;
            margin-bottom: 10px;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Button Styling */
        .btn-primary {
            background-color:rgb(0, 59, 177);
            border: none;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 20px;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color:rgb(6, 164, 237);
            transform: scale(1.05);
        }

        .btn-danger {
            background-color:rgb(193, 133, 30);
            border: none;
            padding: 5px 10px;
            transition: 0.3s;
        }

        .btn-danger:hover {
            background-color:rgb(211, 143, 47);
        }

        .cart-empty-message {
            text-align: center;
            font-size: 18px;
            color: #ff9800;
        }

        /* Responsive Layout */
        @media (max-width: 767px) {
            .list-group-item {
                padding: 10px;
                font-size: 14px;
            }

            .btn-primary, .btn-danger {
                width: 100%;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>

<!-- Navbar Section -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="adidas.php">My Products</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="adidas.php">Home</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="container mt-5">
        <h1>Your Cart</h1>

        <?php if (empty($cartItems)): ?>
     <div class="alert alert-warning" role="alert">
        Your cart is empty.
     </div>
    <?php else: ?>

        <ul class="list-group">
    <?php foreach ($cartItems as $index => $item): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <strong><?= htmlspecialchars($item['name']) ?></strong>  
                <br> <small>Size: <?= htmlspecialchars($item['size']) ?></small>  
                <br> Price: Ksh <?= htmlspecialchars($item['price']) ?>
            </div>
            <form action="remove_item.php" method="POST">
                <input type="hidden" name="index" value="<?= $index ?>">
                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>

            <a href="checkout.php" class="btn btn-primary mt-3">Proceed to Checkout</a>
        <?php endif; ?>
    </div>
</body>
</html>