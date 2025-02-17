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
