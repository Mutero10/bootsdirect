<?php
session_start();

// Ensure there is a cart
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty!";
    exit;
}

// Collect user info and cart data
$userName = $_POST['name'];
$userEmail = $_POST['email'];
$cartItems = $_SESSION['cart'];
$totalPrice = array_sum(array_column($cartItems, 'price'));

// Simulate an order processing (you could store this in a database)
$orderDetails = [
    'name' => $userName,
    'email' => $userEmail,
    'cart' => $cartItems,
    'total' => $totalPrice
];

// Hardcoded delivery details (You can change this as needed)
$deliveryDetails = [
    'address' => '123 Main St, City, Country',
    'delivery_time' => '3-5 business days',
    'order_confirmation_number' => rand(1000, 9999), // Random confirmation number
];

// Simulate sending the order to the company (this is now local processing)
$_SESSION['delivery_details'] = $deliveryDetails;

// Redirect to the confirmation page
header('Location: confirmation.php');
exit;
?>
