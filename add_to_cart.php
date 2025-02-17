<?php

session_start();

// Get the raw POST data
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['product_id'])) {
    $product_id = $input['product_id'];

    // Add the product to the cart (session-based in this case)
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add the product to the session cart
    $_SESSION['cart'][] = $product_id;

    // Send a success response
    echo json_encode(['success' => true, 'message' => 'Product added to cart']);
} else {
    // No product_id received in the request
    echo json_encode(['success' => false, 'error' => 'Product ID not provided']);
}
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
