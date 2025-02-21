<?php
session_start();
require 'databasehandler.php';

// Ensure only admins can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied! You are not an admin.");
}

// Define Product class
class Product {
    private $name;
    private $quantity;
    private $price;
    private $image;
    private $pdo;

    // Constructor
    public function __construct($name, $quantity, $price, $image, $pdo) {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->image = $image;
        $this->pdo = $pdo;
    }

    // Method to save product
    public function save() {
        try {
            $sql = "INSERT INTO products (name, quantity, price, image) VALUES (:name, :quantity, :price, :image)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':name' => $this->name,
                ':quantity' => $this->quantity,
                ':price' => $this->price,
                ':image' => $this->image
            ]);
            return "Product added successfully!";
        } catch (PDOException $e) {
            return "Error adding product: " . $e->getMessage();
        }
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $image = null; // Default to NULL

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    }

    // Create DatabaseHandler instance
    $dbHandler = new DatabaseHandler();
    $pdo = $dbHandler->getPDO();

    // Create Product object and save
    $product = new Product($name, $quantity, $price, $image, $pdo);
    echo $product->save();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
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
                    <h4>Add New Product</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="add.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter product name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control" placeholder="Enter quantity" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price (Ksh)</label>
                            <input type="number" step="0.01" name="price" class="form-control" placeholder="Enter price" required>
                        </div>

                        

                        <button type="submit" class="btn btn-success w-100">Add Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
