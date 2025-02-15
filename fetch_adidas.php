<?php
include 'databasehandler.php';

$db = new DatabaseHandler();
$products = $db->getAdidasProducts(); // Fetch only Adidas products

if (!empty($products)) {
    foreach ($products as $row) {
        echo '
        <div class="col-md-4 mb-4 product-card" data-type="' . htmlspecialchars($row["type"]) . '" data-price="' . htmlspecialchars($row["price"]) . '">
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
    echo "<p>No Adidas products found.</p>";
}
?>

