<?php
session_start();
include 'databasehandler.php';

// Check if request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //  Check if "id" is received
    if (!isset($_POST["id"])) {
        echo json_encode(["success" => false, "message" => "Product ID not received"]);
        exit;
    }

    $productId = $_POST["id"];

    // Display received ID
    error_log("Product ID received: " . $productId);

    // Initialize the cart if it doesn't exist
    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = [];
    }

    // Add product ID to the cart session
    $_SESSION["cart"][] = $productId;

    echo json_encode(["success" => true, "message" => "Product added"]);
    exit;
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>