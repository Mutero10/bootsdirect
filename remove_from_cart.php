<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $productId = $_POST["id"];

    if (isset($_SESSION["cart"])) {
        $_SESSION["cart"] = array_filter($_SESSION["cart"], function ($id) use ($productId) {
            return $id != $productId; // Remove selected item
        });
    }

    echo json_encode(["success" => true]);
    exit;
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
