<?php
include 'products.php'; 

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$priceRange = isset($_GET['price']) ? $_GET['price'] : '';

$sql = "SELECT id, name, image, price FROM products WHERE 1";

// Apply search filter
if (!empty($searchQuery)) {
    $sql .= " AND name LIKE '%" . $conn->real_escape_string($searchQuery) . "%'";
}

// Apply price filter
if (!empty($priceRange)) {
    list($minPrice, $maxPrice) = explode('-', $priceRange);
    $sql .= " AND price BETWEEN $minPrice AND $maxPrice";
}

$result = $conn->query($sql);
$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);
$conn->close();
?>
