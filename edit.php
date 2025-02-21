<?php
session_start();
require 'databasehandler.php';

// Ensure only admins can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied! You are not an admin.");
}

// Product class definition
class Product {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Method to fetch a product by ID
    public function getProductById($id) {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to update product details
    public function updateProduct($id, $name, $quantity, $price) {
        if (!empty($name) && is_numeric($quantity) && is_numeric($price)) {
            try {
                $sql = "UPDATE products SET name = :name, quantity = :quantity, price = :price WHERE id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(['name' => $name, 'quantity' => $quantity, 'price' => $price, 'id' => $id]);

                return "<p>Product updated successfully!</p>";
            } catch (Exception $e) {
                return "Error updating product: " . $e->getMessage();
            }
        } else {
            return "<p>Invalid input data!</p>";
        }
    }
}

// Create a DatabaseHandler instance
$dbHandler = new DatabaseHandler();
$pdo = $dbHandler->getPDO();
$productHandler = new Product($pdo);

// Handle update request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    echo $productHandler->updateProduct($_POST['id'], $_POST['name'], $_POST['quantity'], $_POST['price']);
}

// Fetch product details
if (isset($_GET['id'])) {
    $product = $productHandler->getProductById($_GET['id']);

    if (!$product) {
        die("Product not found!");
    }
} else {
    die("No product selected!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
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
                <div class="card-header bg-primary text-white text-center">
                    <h4>Edit Product</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">

                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control" value="<?php echo htmlspecialchars($product['quantity']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price (Ksh)</label>
                            <input type="text" name="price" class="form-control" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                        </div>

                        <button type="submit" class="btn btn-warning w-100">Update Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
