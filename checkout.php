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
        <form action="verify_payment.php" method="POST">

    <!-- M-Pesa Payment Instructions -->
    <div class="alert alert-info mt-3">
        <strong>Pay via M-Pesa:</strong>
        <ul>
            <li>Go to <strong>M-Pesa > Lipa na M-Pesa</strong></li>
            <li>Enter Paybill: <strong>123456</strong></li>
            <li>Enter Account No: <strong>YourName</strong></li>
            <li>Enter Amount: <strong>Ksh <?= $totalPrice ?></strong></li>
            <li>Confirm and Send</li>
        </ul>
        <p><strong>After payment, enter the M-Pesa transaction code below:</strong></p>
    </div>

    <div class="form-group">
        <label for="mpesa_code">M-Pesa Transaction Code</label>
        <input type="text" id="mpesa_code" name="mpesa_code" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Confirm Payment</button>
</form>

    </div>
</body>
</html>
