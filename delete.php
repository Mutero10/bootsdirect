<?php
session_start();
require 'databasehandler.php';

// Ensure only admins can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied! You are not an admin.");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $dbHandler = new DatabaseHandler();
    $pdo = $dbHandler->getPDO();

    try {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        echo "<p>Product deleted successfully!</p>";
    } catch (Exception $e) {
        die("Error deleting product: " . $e->getMessage());
    }
} else {
    die("No product selected!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <a href="admin_dashboard.php" class="btn btn-outline-light">Back to Dashboard</a>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-danger text-white text-center">
                    <h4>Confirm Delete</h4>
                </div>
                <div class="card-body text-center">
                    <p class="fs-5">Are you sure you want to delete this product?</p>
                    <h5 class="fw-bold"><?php echo htmlspecialchars($product['name']); ?></h5>
                    <p>Price: Ksh<?php echo htmlspecialchars($product['price']); ?> | Quantity: <?php echo htmlspecialchars($product['quantity']); ?></p>

                    <form method="POST">
                        <button type="submit" class="btn btn-danger w-100">Delete Product</button>
                    </form>

                    <a href="admin_dashboard.php" class="btn btn-secondary w-100 mt-3">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
