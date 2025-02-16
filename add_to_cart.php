<?php
session_start();
include 'databasehandler.php';

$db = new DatabaseHandler();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $productId = $_POST["id"];
    $product = $db->getProductById($productId);

    if ($product) {
        // Initialize cart if not set
        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = [];
        }

        // Check if the product is already in the cart
        $found = false;
        foreach ($_SESSION["cart"] as &$item) {
            if ($item["id"] == $productId) {
                $item["quantity"] += 1; // Increase quantity
                $found = true;
                break;
            }
        }

        // If not found, add a new product with quantity
        if (!$found) {
            $product["quantity"] = 1;
            $_SESSION["cart"][] = $product;
        }

        echo json_encode(["success" => true]);
        exit;
    }
}

echo json_encode(["success" => false, "message" => "Product not found"]);
exit;

?>