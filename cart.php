<?php
session_start();
include 'databasehandler.php';

$db = new DatabaseHandler();

// Check if the cart is empty
if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
    echo "<p>Your cart is empty.</p>";
    exit;
}

// Get product details from the database
$cartItems = [];
foreach ($_SESSION["cart"] as $productId) {
    $product = $db->getProductById($productId); // Fetch product details
    if ($product) {
        $cartItems[] = $product;
    }
}

// Display cart items
if (!empty($cartItems)) {
    echo "<h2>Your Cart</h2><div class='row'>";
    foreach ($cartItems as $item) {
        echo '
        <div class="col-md-4 mb-4 product-card">
            <div class="card h-100">
                <img src="images/' . htmlspecialchars($item["image"]) . '" class="card-img-top" alt="' . htmlspecialchars($item["name"]) . '">
                <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($item["name"]) . '</h5>
                    <p class="card-text">Ksh ' . htmlspecialchars($item["price"]) . '</p>
                    <button class="btn btn-danger remove-item" data-id="' . $item["id"] . '">Remove</button>
                </div>
            </div>
        </div>';
    }
    echo "</div>";
} else {
    echo "<p>Your cart is empty.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <!-- Include your CSS and JS files here -->
</head>
<body>
    <h1>Your Shopping Cart</h1>
    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>Ksh <?php echo htmlspecialchars($item['price']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>Ksh <?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>

    <script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".remove-item").forEach(button => {
        button.addEventListener("click", function () {
            let productId = this.getAttribute("data-id");

            fetch("remove_from_cart.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "id=" + productId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Refresh cart page
                } else {
                    alert("Failed to remove item: " + data.message);
                }
            })
            .catch(error => console.error("Error:", error));
        });
    });
});
</script>
</body>
</html>
