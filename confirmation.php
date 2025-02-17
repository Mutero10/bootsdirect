<?php
session_start();

// Check if delivery details are available
if (isset($_SESSION['delivery_details'])) {
    $deliveryDetails = $_SESSION['delivery_details'];
} else {
    echo "No delivery details found. Please try again.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <div class="container mt-5">
        <h2>Order Confirmation</h2>
        
        <!-- Display Order and Delivery Details -->
        <h4>Order Summary:</h4>
        <ul class="list-group">
            <?php foreach ($deliveryDetails['cart'] as $item): ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($item['name']) ?></strong> - Ksh <?= htmlspecialchars($item['price']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <h4>Total: Ksh <?= $deliveryDetails['total'] ?></h4>

        <h4>Delivery Details:</h4>
        <p><strong>Delivery Address:</strong> <?= htmlspecialchars($deliveryDetails['address']) ?></p>
        <p><strong>Expected Delivery Time:</strong> <?= htmlspecialchars($deliveryDetails['delivery_time']) ?> days</p>

        <p>Thank you for your order!</p>
    </div>

</body>
</html>
