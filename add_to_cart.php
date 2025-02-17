<?php

session_start();

// Get the raw POST data
$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the POST request
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Prepare the product to be added to the cart
    $product = array('id' => $id, 'name' => $name, 'price' => $price);

    // Initialize the cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array(); // Initialize the cart if it's empty
    }

    // Add the product to the session cart
    $_SESSION['cart'][] = $product;

    echo 'Product added to cart'; // Optional message to confirm
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
