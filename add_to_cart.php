<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit();
}

// Retrieve data from the POST request
$product_id = $_POST['product_id'] ?? null;
$name = $_POST['name'] ?? null;
$price = $_POST['price'] ?? null;
$size = $_POST['size'] ?? null;

// Validate data
if (!$product_id || !$name || !$price || !$size) {
    echo json_encode(["status" => "error", "message" => "Missing product details"]);
    exit();
}

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add the product with size to the session cart
$_SESSION['cart'][] = [
    'id' => $product_id,
    'name' => $name,
    'price' => $price,
    'size' => $size
];

// Return a JSON response instead of redirecting
//echo json_encode(["status" => "success", "message" => "Product added to cart"]);
exit();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
</head>
<body>
    <h1>Your Cart</h1>
    <ul id="cartItems"></ul>

    <button id="checkoutBtn">Proceed to Checkout</button>

    <script>
        const cartItemsList = document.getElementById('cartItems');
        const cart = JSON.parse(localStorage.getItem('cart')) || [];

        cart.forEach(item => {
            const li = document.createElement('li');
            li.textContent = `${item.name} - $${item.price}`;
            cartItemsList.appendChild(li);
        });

        document.getElementById('checkoutBtn').addEventListener('click', function() {
            if (cart.length > 0) {
                window.location.href = '/checkout.html';  // redirect to checkout page
            } else {
                alert('Your cart is empty!');
            }
        });
    </script>
</body>
</html>
