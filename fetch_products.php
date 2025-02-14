<?php
include 'products.php'; 

$sql = "SELECT id, name, image, price FROM products";
$result = $conn->query($sql);

$products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

echo json_encode($products); // Convert data to JSON format for frontend use
$conn->close();
?>
