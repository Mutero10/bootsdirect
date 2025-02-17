<?php
session_start();

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
$stmt->bind_param("ssd", $userName, $userEmail, $totalPrice);
$stmt->execute();

// Check if insertion was successful
if ($stmt->affected_rows > 0) {
    // Fetch the latest order (to display in confirmation page)
    $orderID = $stmt->insert_id;

    // Simulated delivery details
    $_SESSION['delivery_details'] = [
        'address' => '123 Main St, City, Country',
        'delivery_time' => '3-5 business days',
        'order_confirmation_number' => rand(1000, 9999),
        'order_id' => $orderID  // Store order ID for reference
    ];

    // Close database connection
    $stmt->close();
    $conn->close();

    // Redirect to confirmation page
    header('Location: confirmation.php');
    exit;
} else {
    die("Error inserting order: " . $conn->error);
}
?>
