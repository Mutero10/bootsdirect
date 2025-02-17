<?php
session_start();
include 'databasehandler.php';

// Get the total price and product details from the form
$totalPrice = $_POST['total'];
$name = $_POST['name'];
$email = $_POST['email'];
$orderDetails = json_encode($_SESSION['cart']); // Store cart items as JSON

// Save order to the database
$db = new DatabaseHandler();
$query = "INSERT INTO orders (name, email, total_price, order_details) VALUES (?, ?, ?, ?)";
$stmt = $db->connect()->prepare($query);
$stmt->execute([$name, $email, $totalPrice, $orderDetails]);

// Get the order ID
$orderId = $db->connect()->lastInsertId();

// Send email to the company with the order details
$subject = "New Order Received: Order #$orderId";
$message = "
    A new order has been received.\n
    Order ID: $orderId\n
    Name: $name\n
    Email: $email\n
    Total: Ksh $totalPrice\n
    Order Details: $orderDetails\n
    Please confirm delivery details.
";

$companyEmail = "amutero5@gmail.com"; // Replace with the company's email
$headers = "From: mutero.27.andrew@gmail.com\r\n";
mail($companyEmail, $subject, $message, $headers);

// After the order is placed, redirect the user to a confirmation page
header("Location: confirmation.php?order_id=$orderId");
exit();
?>
