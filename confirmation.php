<?php
session_start();
include 'databasehandler.php';

$orderId = $_GET['order_id'];
$db = new DatabaseHandler();
$query = "SELECT * FROM orders WHERE id = ?";
$stmt = $db->connect()->prepare($query);
$stmt->execute([$orderId]);
$order = $stmt->fetch();

if ($order) {
    echo "<h1>Order Confirmation</h1>";
    echo "<p>Order ID: " . $order['id'] . "</p>";
    echo "<p>Name: " . $order['name'] . "</p>";
    echo "<p>Email: " . $order['email'] . "</p>";
    echo "<p>Total: Ksh " . $order['total_price'] . "</p>";
    echo "<h3>Order Details:</h3>";
    echo "<pre>" . $order['order_details'] . "</pre>";

    echo "<p>Your order has been received and will be confirmed shortly. We will send you an email with the delivery details once it's processed.</p>";
} else {
    echo "<p>Order not found.</p>";
}
?>
