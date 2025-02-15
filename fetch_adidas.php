<?php
include 'databasehandler.php';

$db = new DatabaseHandler();

// Check if a brand is passed in the URL
$brand = isset($_GET['brand']) ? $_GET['brand'] : '';

// Fetch products based on the brand
if ($brand === 'adidas') {
    $products = $db->getAdidasProducts();
} elseif ($brand === 'puma') {
    $products = $db->getPumaProducts();
} else {
    $products = []; // If no valid brand is given, return an empty array
}

// Display products
if (!empty($products)) {
    foreach ($products as $row) {
        echo '
        <div class="col-md-4 mb-4 product-card" data-type="' . htmlspecialchars($row["type"] ?? $row["category"]) . '" data-price="' . htmlspecialchars($row["price"]) . '">
            <div class="card h-100">
                <img src="' . htmlspecialchars($row["image"]) . '" class="card-img-top product-image" alt="' . htmlspecialchars($row["name"]) . '">
                <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($row["name"]) . '</h5>
                    <p class="card-text">Ksh ' . htmlspecialchars($row["price"]) . '</p>
                    <a href="#" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>';
    }
} else {
    echo "<p>No products found for this brand.</p>";
}
?>
