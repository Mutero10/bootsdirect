<?php
$connection = new mysqli("localhost", "root", "", "mydatabase");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$query = "SELECT * FROM products";
$result = $connection->query($query);
?>

<div class="row">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="col-md-4 product-card" data-type="<?= $row['type']; ?>" data-price="<?= $row['price']; ?>">
            <div class="card h-100">
                <img src="<?= $row['image']; ?>" class="card-img-top product-image" alt="<?= $row['name']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $row['name']; ?></h5>
                    <p class="card-text">Ksh <?= number_format($row['price']); ?></p>
                    <a href="#" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>