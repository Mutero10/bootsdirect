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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Your Cart</h1>

        <?php if (empty($cartItems)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <ul class="list-group">
                <?php foreach ($cartItems as $index => $item): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?= htmlspecialchars($item['name']) ?></strong><br>
                            Price: Ksh <?= htmlspecialchars($item['price']) ?>
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

