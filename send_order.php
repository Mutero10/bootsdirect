<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load PHPMailer

// Ensure cart exists
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Your cart is empty!");
}

// Collect user input
$userName = $_POST['name'] ?? '';
$userEmail = $_POST['email'] ?? '';

if (empty($userName) || empty($userEmail)) {
    die("Name and email are required!");
}

$cartItems = $_SESSION['cart'];
$totalPrice = array_sum(array_column($cartItems, 'price'));

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Insert order into database
$sql = "INSERT INTO orders (name, email, total_price) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Database query failed: " . $conn->error);
}

$stmt->bind_param("ssd", $userName, $userEmail, $totalPrice);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Fetch the latest order ID
    $orderID = $stmt->insert_id;

    // Generate a random order confirmation number
    $orderNumber = rand(1000, 9999);

    // Simulated delivery details
    $_SESSION['delivery_details'] = [
        'address' => 'Nairobi, Kilimani',
        'delivery_time' => '2 hours',
        'order_confirmation_number' => $orderNumber,
        'order_id' => $orderID
    ];

    // Use PHPMailer to send email
    try {
        $mail = new PHPMailer(true);

        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Change if using another provider
        $mail->SMTPAuth = true;
        $mail->Username = 'amutero5@gmail.com'; // Your email
        $mail->Password = 'ripxivfofjghtvyq'; // Use App Password if using Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email Headers
        $mail->setFrom('mutero.27.andrew@gmail.com', 'Your Store');
        $mail->addAddress($userEmail, $userName);
        $mail->addReplyTo('amutero5@gmail.com', 'Customer Support');

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = "Order Confirmation - Order #$orderNumber";
        $mail->Body = "
            <h3>Thank you for your order, $userName!</h3>
            <p><strong>Order Number:</strong> $orderNumber</p>
            <p><strong>Total Price:</strong> Ksh $totalPrice</p>
            <p><strong>Estimated Delivery:</strong> 2 hours</p>
            <p><strong>Delivery Address:</strong> Nairobi, Kilimani</p>
            <p>We appreciate your business!</p>
        ";

        // Send Email
        $mail->send();

        // Close database connection
        $stmt->close();
        $conn->close();

        // Redirect to confirmation page
        header('Location: confirmation.php');
        exit;
        
    } catch (Exception $e) {
        echo "Order placed but failed to send email. Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Error placing order: " . $conn->error;
}

// Close database connection
$stmt->close();
$conn->close();

// Clear the cart only after the order has been processed successfully
$_SESSION['cart'] = [];
?>
