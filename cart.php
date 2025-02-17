<?php
session_start();
include 'databasehandler.php';

$db = new DatabaseHandler();

// Check if the cart is empty
if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
    echo "<p>Your cart is empty.</p>";
    exit;
}

$cartItems = $_SESSION["cart"]; // Use session data directly

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <!-- Add Bootstrap CSS link for styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <h1>Your Cart</h1>
    <ul id="cartItems" class="list-group">
        <?php
        // Loop through the session cart items and display them
        foreach ($cartItems as $item) {
            echo '
                <li class="list-group-item">
                    <strong>' . htmlspecialchars($item['name']) . '</strong><br>
                    Price: Ksh ' . htmlspecialchars($item['price']) . '
                </li>
            ';
        }
        ?>
    </ul>

    <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>

    <script>
        // Checkout button functionality
        document.getElementById('checkoutBtn').addEventListener('click', function() {
            window.location.href = '/checkout.html';  // redirect to checkout page
        });
    </script>
</body>
</html>
