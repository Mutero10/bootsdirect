<?php
include 'databasehandler.php';

$db = new DatabaseHandler();
$products = $db->getProducts();
$pumaProducts = $db->getPumaProducts(); 


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
    echo "<p>No products found.</p>";
}

if (!empty($pumaProducts)) {
    foreach ($pumaProducts as $row) {
        echo '
        <div class="col-md-4 mb-4 product-card" data-type="' . htmlspecialchars($row["category"]) . '" data-price="' . htmlspecialchars($row["price"]) . '">
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
    echo "<p>No puma products found.</p>";
}

?>
