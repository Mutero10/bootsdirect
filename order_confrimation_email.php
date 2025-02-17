<?php
// Include the necessary file to handle DB connection
include 'databasehandler.php';

$orderId = $_GET['order_id']; // Order ID passed as GET or use a POST method
$db = new DatabaseHandler();

// Query to get the customer's email
$query = "SELECT email FROM orders WHERE id = ?";
$stmt = $db->connect()->prepare($query);
$stmt->execute([$orderId]);
$user = $stmt->fetch();

if ($user) {
    $userEmail = $user['email'];

    // Set up the subject and message
    $subject = "Your Order #$orderId Has Been Confirmed";
    $message = "
        <html>
        <body>
        <p>Your order has been confirmed!</p>
        <p><strong>Order ID:</strong> $orderId</p>
        <p><strong>Expected Delivery:</strong> 3-5 Business Days</p>
        <p>Thank you for shopping with us!</p>
        </body>
        </html>
    ";

    // Set up the email headers
    $headers = "From: noreply@yourwebsite.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n"; // HTML email

    // Send the email
    if (mail($userEmail, $subject, $message, $headers)) {
        echo "Confirmation email sent to the customer.";
    } else {
        echo "Failed to send confirmation email.";
    }

    // Optionally update the order status in the database
    $updateQuery = "UPDATE orders SET status = 'Confirmed' WHERE id = ?";
    $stmt = $db->connect()->prepare($updateQuery);
    $stmt->execute([$orderId]);
} else {
    echo "Order not found.";
}
?>
