<?php
session_start();

// Ensure there are items in the cart
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty. <a href='index.php'>Go back to shop</a></p>";
    exit;
}

$cartItems = $_SESSION['cart'];
$totalPrice = array_sum(array_column($cartItems, 'price'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Checkout</h2>
        <ul class="list-group">
            <?php foreach ($cartItems as $item): ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($item['name']) ?></strong> - Ksh <?= htmlspecialchars($item['price']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <h4 class="mt-3">Total: Ksh <?= $totalPrice ?></h4>

        <!-- Payment Form -->
        <form action="process_payment.php" method="POST">
            <input type="hidden" name="total" value="<?= $totalPrice ?>">

            <div class="form-group mt-3">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Pay Now</button>
        </form>
    </div>
</body>
</html>
